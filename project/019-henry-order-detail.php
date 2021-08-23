<?php
include __DIR__ . "/partials/init.php";
$title = "購物清單";
if (!isset($_SESSION["user"])) {
  $login = 'no';
}

$orderSid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
// -----------------------只能看到自己的訂單----------------------------//
$sid = isset($_SESSION['user']['id']) ? intval($_SESSION['user']['id']) : 0;
$sql = "SELECT * FROM `order_details` JOIN `product_list` ON `order_details`.`product_id`=`product_list`.`product_id` WHERE `order_id`=$orderSid";

$rows = $pdo->query($sql)->fetchALL();

echo json_encode($sid)
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
      <thead class="text-center">
        <tr>
          <th scope="col">商品圖片</th>
          <th scope="col">品名</th>
          <th scope="col">數量</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <?php foreach ($rows as $r) : ?>
          <tr data-sid="<?= $r['sid'] ?>">
            <td><img src="imgs/<?= htmlentities($r['product_img']) ?>" alt=""></td>
            <td><?= htmlentities($r['product_name']) ?></td>
            <td><?= htmlentities($r['quantity']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
</div>


<?php include __DIR__ . "/019-henry-scripts.php"; ?>
<script>
  const myTable = document.querySelector('table');
  const modal = $('.modal1');
  $('.del1btn').on('click', function(event) {
    willDeleteId = event.target.closest('tr').dataset.sid;
    modal.find('.modal-body').html(`確定要放棄編號為 ${willDeleteId} 的訂單嗎？`)
  })

  modal.find('.modal-del-btn').on('click', function(event) {
    location.href = `019-henry-order-delete.php?sid=${willDeleteId}`;
  })

  //一開始顯示時觸發
  // modal.on('show.bs.modal',function(event){
  //   console.log(event.target);
  // })
</script>

<?php include __DIR__ . "/partials/html-foot.php"; ?>