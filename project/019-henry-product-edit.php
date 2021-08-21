<?php

  include __DIR__ . "/partials/init.php";
  $title = "修改商品資料";


  if ($_SESSION["user"]['account'] !== 'pikachu') {
    header("Location: 019-henry-product-list.php"); //只允許皮卡丘進入
    exit();
  }

  $sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

  $sql = "SELECT * FROM `product_list` WHERE sid=$sid";
  $r = $pdo->query($sql)->fetch(); 
  echo json_encode($r);
  if(empty($r)){
    header("Location: 019-henry-product-stock.php");
    exit();
  }
?>

<?php include __DIR__ . "/partials/html-head.php"; ?>
<?php include __DIR__ . "/partials/navbar.php"; ?>
<style>
  form .form-group small, .star {
    color: red;
  }
</style>

<div class="container mt-3">
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">修改商品資料</h5>
          <form name="form1" onsubmit="checkForm(); return false;">
            <div class="form-group">
              <label for="product_img">商品圖片</label>
              <input type="file" class="form-control" id="product_img" name="product_img" accept="image/*">
              <?php if(empty( $r['product_img'])): ?>
                  <!-- 預設的大頭貼 -->
              <?php else: ?>
                  <!-- 顯示原本的大頭貼 -->
                  <img src="imgs/<?= htmlentities($r['product_img']) ?>.jpg" alt="" width="100px" class="mt-2">
                  
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="product_id">商品序 <span class="star">*</span></label>
              <input type="text" class="form-control" id="product_id" name="product_id" value="<?= htmlentities($r['product_id']) ?>">
            </div>
            
            <div class="form-group">
              <label for="product_name">品名 <span class="star">*</span></label>
              <input type="text" class="form-control" id="product_name" name="product_name" value="<?= htmlentities($r['product_name']) ?>">
            </div>
            <div class="form-group">
              <label for="product_brand">品牌 <span class="star">*</span></label>
              <input type="text" class="form-control" id="product_brand" name="product_brand" value="<?= htmlentities($r['product_brand']) ?>">
            </div>
            <div class="form-group">
              <label for="product_price">價格 <span class="star">*</span></label>
              <input type="text" class="form-control" id="product_price" name="product_price" value="<?= htmlentities($r['product_price']) ?>">
            </div>
            <div class="form-group">
                <label for="stock">庫存 <span class="star">*</span></label>
                <input type="text" class="form-control" id="stock" name="stock" value="<?= htmlentities($r['stock']) ?>">
              </div>
            <button type="submit" class="btn btn-primary">修改</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . "/partials/scripts.php"; ?>
  <script>
    function checkForm(){
      //使用formdata上傳修改資料  不用再設定enctype="multipart/form-data"   會自動設定
      const fd = new FormData(document.form1);
      fetch('019-henry-product-edit-api.php', {
          method: 'POST',
          body: fd
      }).then(r=>r.json()).then(obj=> {
          console.log(obj);
          if(obj.success) {     
            alert('修改成功')
          } else {
            alert(obj.error)
          }
      }).catch(error=> {
        console.log('error',error);
      })//錯誤處理，怕回傳的資料不是JSON格式。會造成JS停止
    }
  </script>
<?php include __DIR__ . "/partials/html-foot.php"; ?>
