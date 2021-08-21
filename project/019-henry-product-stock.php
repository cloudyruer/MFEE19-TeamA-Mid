<?php
include __DIR__ . "/partials/init.php";
$title = "購物清單";

if ($_SESSION["user"]['account'] !== 'pikachu') {
  header("Location: 019-henry-product-list.php"); //只允許皮卡丘進入
  exit();
}




$sql = "SELECT * FROM `product_list` WHERE 1";
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
            <th scope="col">刪除商品</i></th>
            <th scope="col">商品序</i></th>
            <th scope="col">商品圖片</th>
            <th scope="col">品名</th>
            <th scope="col">品牌</th>
            <th scope="col">價格</th>
            <th scope="col">庫存</th>
            <th scope="col"><i class="fas fa-edit"></i></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr data-sid="<?= $r['sid'] ?>">
              <td>
                <button type="button" class="btn btn-outline-warning del1btn" data-toggle="modal" data-target="#exampleModal">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </td>
              <td><?= $r['sid'] ?></td>
              <td><img src="imgs/<?= htmlentities($r['product_img']) ?>.jpg" alt=""></td>
              <td><?= htmlentities($r['product_name']) ?></td>
              <td><?= htmlentities($r['product_brand']) ?></td>
              <td><?= htmlentities($r['product_price']) ?></td>
              <td><?= htmlentities($r['stock']) ?></td>
              
              <td>
                <a href="019-henry-product-edit.php?sid=<?= $r['sid'] ?>">
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
        <h5 class="modal-title" id="exampleModalLabel">刪除確認</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary modal-del-btn">確定</button>
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
    modal.find('.modal-body').html(`確定要刪除編號為 ${willDeleteId} 的商品嗎？`)
  })

  modal.find('.modal-del-btn').on('click',function(event){
    location.href = `019-henry-product-delete.php?sid=${willDeleteId}`;
  })

</script>
<?php include __DIR__ . "/partials/html-foot.php"; ?>
