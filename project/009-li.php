<!-- TODO: 圖片未放入!!!! -->
<!-- TODO: 合併表格 -->

<?php
include __DIR__ . '/partials/init.php';
$title = 'Hi Li!!';
$activeLi = 'li';


// 固定每一頁最多幾筆
$perPage = 7;

// query string parameters
$qs = [];
$pageBtnQS = [];


// 關鍵字查詢
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// 分類查詢
$cate = isset($_GET['cate']) ? $_GET['cate'] : '';
$cateP = isset($_GET['cateP']) ? $_GET['cateP'] : '';

// 用戶決定查看第幾頁，預設值為 1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$where = ' WHERE 1 ';
if (!empty($keyword)) {
  // $where .= " AND `name` LIKE '%{$keyword}%' "; // sql injection 漏洞 
  $where .= sprintf(" AND `name` LIKE %s ", $pdo->quote('%' . $keyword . '%'));

  $qs['keyword'] = $keyword;
}

if (!empty($cate)) {
    $where .= " AND `categories_id`= $cate";
    $pageBtnQS['cate'] = $cate;
}

if (!empty($cateP)) {
  $where .= " AND `categories_parents_id`= $cateP";
  $pageBtnQS['cate'] = $cateP;
}


// 總共有幾筆
$totalRows = $pdo->query("SELECT count(1) FROM (`products` LEFT JOIN `stock` ON `sid` = `stock`.`products_id` ) $where")
  ->fetch(PDO::FETCH_NUM)[0];


// 總共有幾頁, 才能生出分頁按鈕
$totalPages = ceil($totalRows / $perPage); // 正數是無條件進位


$rows = [];
// 要有資料才能讀取該頁的資料
if ($totalRows != 0) {
  // 讓 $page 的值在安全的範圍
  if ($page < 1) {
    header('Location: ?page=1');
    exit;
  }
  if ($page > $totalPages) {
    header('Location: ?page=' . $totalPages);
    exit;
  }


// SELECT * FROM `products` JOIN `stock` ON `stock`.`products_sid` = `sid` JOIN `images` ON `images`.`products_sid` = `sid` WHERE `sid`=2 ORDER BY `sid` DESC

// 原始: "SELECT * FROM products %s ORDER BY sid DESC LIMIT %s, %s",

  $sql = sprintf(
    "SELECT * FROM (`products` LEFT JOIN `stock` ON `stock`.`products_id` = `sid`) %s ORDER BY `sid` DESC LIMIT %s, %s",
    $where,
    ($page - 1) * $perPage,
    $perPage
  );
  // echo $sql; exit;

  $rows = $pdo->query($sql)->fetchAll();
}


$sqlImg = "SELECT * FROM `images`";
$rowsImg = $pdo->query($sqlImg)->fetchAll();

// ------------------選單資料--------------
// 拿到第一層的選單資料
// $sqlCate = "SELECT * FROM `categories`";
// $rowsCate = $pdo->query($sqlCate)->fetchAll();

// $cate1 = [];
// foreach( $rowsCate as $rCate){
//   if($rCate == 0){
//     $cate1[] = $rCate;
//   }
// }
// foreach($cate1 as $k => $second){
//   foreach($rowsCate as $rCate){
//     if($rCate['parents_id'] == $second['id']){
//       $cate1['$k']['nodes'][] = $rCate;
//     }
//   }
// }

// -----------------------------------------------------
$sqlCate = "SELECT * FROM `categories`";
$rowsCate = $pdo->query($sqlCate)->fetchAll();

$dict = [];
foreach( $rowsCate as &$rCate){
    $dict[$rCate['id']] = $rCate;
  }
// echo json_encode($dict,JSON_UNESCAPED_UNICODE);
// echo '------------------';
$tree = [];
foreach($dict as $sid => $item){
    if($item['parents_id']==0){
        $tree[] = &$dict[$sid];
    } else {
        // 不是第一層，就一定會有上一層
        $dict[$item['parents_id']]['nodes'][] = &$dict[$sid];
    }
}

// echo json_encode($tree,JSON_UNESCAPED_UNICODE);


?>

<?php include __DIR__ . '/partials/html-head.php';?>
<?php include __DIR__ . '/partials/navbar.php';?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="009-li.php">Menu</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu"  aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav mr-auto">
            <?php foreach($tree as $c1):  ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#<?= $c1['id'] ?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $c1['name'] ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="?cate=<?= $c1['id'] ?>">所有產品</a>
                        <?php foreach($c1['nodes'] as $c2):  ?>
                        <a class="dropdown-item" href="?cateP=<?= $c2['id'] ?>"><?= $c2['name'] ?></a>
                        <?php endforeach;  ?>
                    </div>
                </li>

            <?php endforeach;  ?>
        </ul>

    </div>
  </div>
</nav>
<div class="container mt-3">
  <div class="row" style="margin: 1rem 0">
      <div class="col">
          <form action="009-li.php" class="form-inline my-2 my-lg-0 d-flex justify-content-end">
              <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search" aria-label="Search" value="<?=htmlentities($keyword)?> ">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
      </div>
  </div>
  <div class="row">
        <div class="col">
            <a class="nav-link d-flex justify-content-end" href="009-li-data-insert.php">新增資料</a>
        </div>
  </div>
  <div class="row">
    <div class="col-6">
            共有 <?= $totalRows ?>筆資料
        </div>
    <div class="col-6">
      <nav aria-label="Page navigation example">
        <ul class="pagination d-flex justify-content-end">

          <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?php $qs['page'] = $page - 1;
                                              echo http_build_query($qs)  ?>">
              <i class="fas fa-arrow-circle-left"></i>
            </a>
          </li>

          <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
            if ($i >= 1 and $i <= $totalPages) :
              $qs['page'] = $i;
          ?>
              <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?<?= http_build_query($qs) ?>"><?= $i ?></a>
              </li>
          <?php endif;
          endfor; ?>

          <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?php $qs['page'] = $page + 1;
                                              echo http_build_query($qs)  ?>">
              <i class="fas fa-arrow-circle-right"></i>
            </a>
          </li>
        </ul>
      </nav>

    </div>
  </div>
  <div class="row">
    <div class="col">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th scope="col"><i class="fas fa-trash-alt"></i></th>
            <!-- <th scope="col"><i class="fas fa-trash-alt"> ajax</i></th> -->
            <th scope="col">sid</th>
            <th scope="col">商品圖片</th>
            <th scope="col">商品名稱</th>
            <th scope="col">商品編號</th>
            <th scope="col">價格</th>
            <th scope="col">商品規格</th>
            <th scope="col">商品數量</th>
            <th scope="col">上下架</th>
            <th scope="col">
              <!-- <i class="fas fa-edit"></i> -->
              編輯
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r) : ?>
            <tr data-sid="<?= $r['sid'] ?>">
              <td>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-warning del1btn" data-toggle="modal" data-target="#exampleModal">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </td>
              <td><?= $r['sid'] ?></td>
              <td>
              <?php $flag = 0 ?>
              <?php foreach($rowsImg as $ri): ?>
                <?php if ( $r['sid'] == $ri['products_sid'] AND $flag == 0): ?>
                <img src="./imgs/<?= htmlentities($ri['fileName'])?>" class="w-100" style="max-width: 100px;" alt="">
                <?php $flag = 1 ?>
                  <?php endif; ?>
                <?php endforeach; ?>
             </td>
              <td><?= htmlentities($r['name']) ?></td>
              <td><?= htmlentities($r['number']) ?></td>
              <td><?= $r['price'] ?></td>
              <td><?php if(empty($r['size'])){
                echo '無資料';
              }else{
                echo $r['size'];
              } ?>
              </td>
              <td>
              <?php if(empty($r['stock'])){
                echo '無資料';
              }else{
                echo $r['stock'];
              } ?>
              </td>
              <td><?= ($r['launched']== 1) ? "上架": "已下架" ?></td>
              <td>
                <a href="009-li-data-edit.php?sid=<?= $r['sid'] ?>">
                  <i class="fas fa-edit"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">刪除注意</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary modal-del-btn">Delete</button>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/partials/scripts.php';?>
<script>
  const myTable = document.querySelector('table');
  const modal = $('#exampleModal');


  myTable.addEventListener('click', function(event) {
    // console.log(event.target);


    // 判斷有沒有點到橙色的垃圾筒
    if (event.target.classList.contains('ajaxDelete')) {
      // console.log(event.target.closest('tr'));
      const tr = event.target.closest('tr');
      const sid = tr.getAttribute('data-sid');
      console.log(`tr.dataset.sid:`, tr.dataset.sid); // 也可以這樣拿

      if (confirm(`是否要刪除編號為 ${sid} 的資料？`)) {
        fetch('009-li-data-delete-api.php?sid=' + sid)
          .then(r => r.json())
          .then(obj => {
            if (obj.success) {
              tr.remove(); // 從 DOM 裡移除元素
              // TODO: 1. 刷頁面, 2. 取得該頁的資料再呈現

            } else {
              alert(obj.error);
            }
          });
      }

    }
  });


  let willDeleteId = 0;
  $('.del1btn').on('click', function(event) {
    willDeleteId = event.target.closest('tr').dataset.sid;
    console.log(willDeleteId);
    modal.find('.modal-body').html(`確定要刪除編號為 ${willDeleteId} 的資料嗎？`);
  });

  // 按了確定刪除的按鈕
  modal.find('.modal-del-btn').on('click', function(event) {
    console.log(`009-li-data-delete.php?sid=${willDeleteId}`);
    location.href = `009-li-data-delete.php?sid=${willDeleteId}`;
  });

  // modal 一開始顯示時觸發
  modal.on('show.bs.modal', function(event) {
    // console.log(event.target);
  });
</script>
<?php include __DIR__ . '/partials/html-foot.php';?>