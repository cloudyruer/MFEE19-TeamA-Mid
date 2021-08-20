<?php
include __DIR__ . "/partials/init.php";
$title = "購物清單";
if (!isset($_SESSION["user"])) {
  $login = 'no';
}


// -----------------------只能看到自己的訂單----------------------------//
$sid = isset($_SESSION['user']['id']) ? intval($_SESSION['user']['id']) : 0;
$sql = "SELECT * FROM `order_list` WHERE `user_id`= $sid";
$rows = $pdo->query($sql)->fetchALL();


?>
<script>
  let login = '<?= $login ?>';
  console.log(login);
  if (login == 'no') {
    alert("請先登入會員")
    location.href = 'login.php'
  }
</script>
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
          <th scope="col">刪除訂單</i></th>
          <th scope="col">訂單編號</i></th>
          <th scope="col">訂購人姓名</th>
          <th scope="col">購買商品</th>
          <th scope="col">數量</th>
          <th scope="col">金額</th>
          <th scope="col">訂單狀態</th>
          <th scope="col">取貨方式</th>
          <th scope="col">取貨門市</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $r) : ?>
          <tr data-sid="<?= $r['sid'] ?>">
            <td>
              <button type="button" class="btn btn-outline-warning del1btn" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-trash-alt"></i>
              </button>
            </td>
            <td><?= $r['sid'] ?></td>
            <td><?= htmlentities($r['user_name']) ?></td>
            <td><?= htmlentities($r['product_img']) ?><?= htmlentities($r['product_name']) ?></td>
            <td><?= htmlentities($r['quantity']) ?></td>
            <td><?= htmlentities($r['total_price']) ?></td>
            <td><?= htmlentities($r['order_status']) ?></td>
            <td><?= htmlentities($r['pickup_way']) ?></td>
            <td><?= htmlentities($r['pickup_store']) ?></td>
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
        <h5 class="modal-title" id="exampleModalLabel">退訂確認</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary modal-del-btn">忍痛放棄</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">我要保留</button>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . "/019-henry-scripts.php"; ?>
<script>
  const myTable = document.querySelector('table');
  const modal = $('.modal1');
  $('.del1btn').on('click', function(event) {
    // console.log(event.target);
    willDeleteId = event.target.closest('tr').dataset.sid;
    console.log(willDeleteId);
    modal.find('.modal-body').html(`確定要放棄編號為 ${willDeleteId} 的訂單嗎？`)
  })

  modal.find('.modal-del-btn').on('click', function(event) {
    console.log(`019-henry-order-delete.php?sid=${willDeleteId}`);
    location.href = `019-henry-order-delete.php?sid=${willDeleteId}`;

  })

  //一開始顯示時觸發
  // modal.on('show.bs.modal',function(event){
  //   console.log(event.target);
  // })
</script>

<?php include __DIR__ . "/partials/html-foot.php"; ?>