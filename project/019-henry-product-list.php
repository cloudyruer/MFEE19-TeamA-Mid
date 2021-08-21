<?php
include __DIR__ . "/partials/init.php";
$title = "產品列表";
//資料處理的部分盡量放前面
//M、C放此區，V放下面

//固定每一頁最多幾筆資料
$perPage = 3;

//query string parameters (關鍵字分頁用)
$qs = [];

//關鍵字查詢
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

//用戶決定看第幾頁，預設值為1
$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;

$where = ' WHERE 1 '; //1等同於true 
if (!empty($keyword)) {
  // $where .= "AND `name` LIKE '%{$keyword}%' ";//sql injection 漏洞
  $where .= sprintf("AND `product_name` LIKE %s ", $pdo->quote('%' . $keyword . '%')); //quote可做跳脫

  $qs['keyword'] = $keyword;
}

//總共幾筆
$totalRows = $pdo
  ->query("SELECT count(1) FROM product_list $where")
  ->fetch(PDO::FETCH_NUM)[0];

//總共幾頁，才能生出分頁按鈕
$totalPages = ceil($totalRows / $perPage); //正數 無條件進位

$rows = [];
//有資料才能讀取該頁的資料
if ($totalRows !== 0) {
  //讓 $page 的值在安全的範圍
  if ($page < 1) {
    header("Location: ?page=1");
    exit();
  }

  if ($page > $totalPages) {
    header("Location: ?page=" . $totalPages);
    exit();
  }

  $sql = sprintf(
    "SELECT * FROM product_list %s ORDER BY sid DESC LIMIT %s, %s",
    $where,
    ($page - 1) * $perPage,
    $perPage
  ); //降冪：將最新的資料拿到最前面

  $rows = $pdo->query($sql)->fetchALL();
}

?>

<?php include __DIR__ . "/partials/html-head.php"; ?>
<?php include __DIR__ . "/019-henry-css.php"; ?>
<?php include __DIR__ . "/partials/navbar.php"; ?>

<div class="container">
  <div class="row my-3">
    <a href="019-henry-product-list.php" id="btnMing" class="btn_pro-list">產品列表</a>
    <a href="019-henry-cargo.php" id="btnMing" class="btn_cargo">購物車 <span class="badge badge-pill badge-info cart-count"></span></a>
    <a href="019-henry-shop-list.php" id="btnMing" class="btn_shop-list">購物清單</a>
    <?php if($_SESSION['user']['account']=='pikachu') {
    echo "<a href='019-henry-product-stock.php' id='btnMing' class='product_edit'>庫存商品</a>";}?>

    <div class="col">
      <form action="019-henry-product-list.php" class="form-inline my-2 my-lg-0 d-flex justify-content-end">
        <input class="form-control mr-sm-2" name="keyword" type="search" placeholder="Search" aria-label="Search" value="<?= htmlentities($keyword) ?>">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <nav aria-label="Page navigation example">
        <ul class="pagination d-flex justify-content-end">
          <li class="page-item <?= $page <= 1 ? "disabled" : "" ?>">
            <a class="page-link" href="?<?php $qs['page'] = $page - 1;
                                        echo http_build_query($qs) ?>">
              <i class="fas fa-arrow-circle-left"></i>
            </a>
          </li>
          <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
            if ($i >= 1 and $i <= $totalPages) : $qs['page'] = $i;
          ?>
              <li class="page-item <?= $i == $page ? "active" : "" ?>">
                <a class="page-link" href="?<?= http_build_query($qs) ?>"><?= $i ?></a>
              </li>
          <?php endif;
          endfor; ?>
          <!-- <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
              <li class="page-item <?= $i == $page ? "active" : "" ?>">
                  <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?> -->
          <li class="page-item <?= $page >= $totalPages ? "disabled" : "" ?>">
            <a class="page-link" href="?<?php $qs['page'] = $page + 1;
                                        echo http_build_query($qs) ?>">
              <i class="fas fa-arrow-circle-right"></i>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row justify-content-around">
    <?php foreach ($rows as $r) : ?>
      <div class="col-md-3 product-unit" data-sid="<?= $r['sid'] ?>">
        <img src="imgs/<?= $r['product_img'] ?>" alt="">
        <p><?= $r['product_name'] ?></p>
        <p>$<?= $r['product_price'] ?></p>
        <p>還剩 <span id="stock_productNumber<?= $r['sid'] ?>" id="stock<?= $r['sid'] ?>"><?= $r['stock'] ?></span> 雙</p>
        <form>
          <div class="form-group d-flex justify-content-around">
            <div class="minus" id="btnMing" data-productNumber="productNumber<?= $r['sid'] ?>">-</div>
            <input type="text" class="qty text-center" width="20" value="0" size=5 id="productNumber<?= $r['sid'] ?>">
            <div class="add" id="btnMing" data-productNumber="productNumber<?= $r['sid'] ?>">+</div>
          </div>
          <div id="tip_productNumber<?= $r['sid'] ?>" class="my-2 stock_tip <?php if ($r['stock'] != 0) {echo "visibilityHidden";} ?>">此商品已售罄，限量是殘酷的！</div>
          <button type="button" class="btn btn-primary add-to-cart-btn"><i class="fas fa-cart-plus"></i></button>
        </form>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include __DIR__ . "/019-henry-scripts.php"; ?>
<script>
  // 數量欄位限制輸入數字
  $(".qty").keyup(function() {
    let number = /^\d+(\.\d{0,})?$/g;
    if (!number.test(this.value)) this.value = "";
  });

  let stock,stockId,input,inputId,tipId 
  
  $(".minus").click(function minus() {
    inputId = this.dataset.productnumber
    input = +$('#'+inputId).val()
    if (input === 0) {
      //數量不能<0
      $("#" + inputId).val(input);
      stock_tip()
    } else {
      input--;
      $("#" + inputId).val(input);
      stock_tip()
    }
  });

  $(".add").click(function add() {
    inputId = this.dataset.productnumber
    stockId = 'stock_' + inputId
    tipId = 'tip_' + inputId
    
    stock = +$('#'+stockId).text()
    input = +$('#'+inputId).val()
    if (input === stock) {
      $("#" + inputId).val(input);
      stock_tip()
    } else {
      input++;
      $("#" + inputId).val(input);
      stock_tip()
    }
  });
  
  $('#'+inputId).change(function(){
    // input = $(".qty").val();
    // $(".qty").val(input);
    console.log('123');
  })
  

  function stock_tip() {
    if (stock === input) {
      $('#'+tipId).removeClass('visibilityHidden')
      $('#'+tipId).text('已達購買上限')
    } else {
      $('#'+tipId).addClass('visibilityHidden')
      $('#'+tipId).text('你看不到我')
    }
  }
  stock_tip()


  const btn = $('.add-to-cart-btn');

  btn.click(function() {

    const sid = $(this).closest('.product-unit').attr('data-sid');
    const qty = $(this).closest('.product-unit').find('.qty').val();
    
    $.get('019-henry-add-to-cart-api.php', {
      sid,
      qty
    }, function(data) {
      countCartObj(data);
    }, 'json');
  });
</script>
<?php include __DIR__ . "/partials/html-foot.php"; ?>