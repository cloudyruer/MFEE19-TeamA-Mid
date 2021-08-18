<?php
include __DIR__ . "/partials/init.php";
$title = "購物清單";

// if (!isset($_SESSION["user"])) {
//   header("Location: 019-henry-product-list.php"); //如果沒登入沒辦法看到自己的購物清單
//   exit();
// }


// -----------------只能看到自己的訂單----------------------------------//
$sid = isset($_SESSION['user']['id']) ? intval($_SESSION['user']['id']) : 0;
$sql = "SELECT * FROM `order_list` WHERE `user_id`= $sid";
$rows = $pdo->query($sql)->fetchALL(); 




?>
<?php include __DIR__ . "/partials/html-head.php"; ?>
<?php include __DIR__ . "/019-henry-css.php"; ?>
<?php include __DIR__ . "/partials/navbar.php"; ?>
<style>
  table tbody i.fas.fa-trash-alt {
      color: darkred;
  }
  table tbody i.fas.fa-trash-alt.ajaxDelete {
      color: darkorange;
      cursor: pointer;
  }
</style>
<div class="container">
  
  <div class="row">
    <?php include __DIR__ . "/019-henry-btn_page.php"; ?>
    </div>
    
  </div>
  <div class="row">
    <div class="col">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th scope="col"><i class="fas fa-trash-alt"></i></th>
            <th scope="col">訂購人姓名</th>
            <th scope="col">訂單金額</th>
            <th scope="col">訂單狀態</th>
            <th scope="col">取貨方式</th>
            <th scope="col">取貨門市</th>
            <th scope="col"><i class="fas fa-edit"></i></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr data-sid="<?= $r['sid'] ?>">
              <!-- 在html5，如果要自訂屬性，要寫data-*。這樣瀏覽器與其他開發人員都能識別，也不會覆蓋掉其他預設屬性 -->
              <!-- https://ithelp.ithome.com.tw/articles/10221029 -->
              <td>
                <!-- onclick會先觸發 -->
                <button type="button" class="btn btn-outline-warning del1btn" data-toggle="modal" data-target="#exampleModal">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </td>
             
              <!-- 避免被XSS攻擊，htmlentities比較好，直接顯示原始輸入資料，後續有法律問題可當作證據。此法有使用跳脫字元 -->
              <!-- <td><?= $r['name'] ?></td> -->
              <td><?= htmlentities($r['user_name']) ?></td>
              <td><?= htmlentities($r['grand_total']) ?></td>
              <td><?= htmlentities($r['order_status']) ?></td>
              <td><?= htmlentities($r['pickup_way']) ?></td>
              <td><?= htmlentities($r['pickup_store']) ?></td>
              <td>
                <a href="data-edit.php?sid=<?= $r['sid'] ?>">
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

<div class="modal fade modal1" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">刪除注意</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary modal-del-btn">確認</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . "/019-henry-scripts.php"; ?>
<script>
  const myTable = document.querySelector('table');
  const modal = $('.modal1');
  $('.del1btn').on('click',function(event){
    // console.log(event.target);
    willDeleteId = event.target.closest('tr').dataset.sid;
    console.log(willDeleteId);
    modal.find('.modal-body').html(`確定要刪除編號為 ${willDeleteId} 的資料嗎？`)
  })

  modal.find('.modal-del-btn').on('click',function(event){
    console.log(`data-delete.php?sid=${willDeleteId}`);
    location.href = `data-delete.php?sid=${willDeleteId}`;

  })

  //一開始顯示時觸發
  // modal.on('show.bs.modal',function(event){
  //   console.log(event.target);
  // })
</script>
<?php include __DIR__ . "/partials/html-foot.php"; ?>
