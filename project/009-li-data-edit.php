<?php
    include __DIR__. '/partials/init.php';
    $title = '修改資料';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "SELECT * FROM `products` WHERE sid=$sid ";

$r = $pdo->query($sql)->fetch();

$rStock = $pdo->query("SELECT * FROM `stock` WHERE `products_id`= $sid")->fetch();

$brands = $pdo->query("SELECT * FROM `brands`")->fetchAll();

$categoriesMain = $pdo->query("SELECT * FROM `categories` WHERE `parents_id` = 0")->fetchAll();

$categoriesChild = $pdo->query("SELECT * FROM `categories` WHERE `parents_id` = 1")->fetchAll();

$sqlImg = "SELECT * FROM `images` WHERE `products_sid` = $sid";
$images = $pdo->query($sqlImg)->fetch();


?>


 <?php include __DIR__. '/partials/html-head.php'; ?>
<?php include __DIR__. '/partials/navbar.php'; ?>
<style>
    form .form-group small {
        color: red;
    }

</style>
<div class="container mt-3">
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mt-3">修改商品資料</h5>
                    <form name="formEdit" onsubmit="checkForm(); return false;">
                    <input type="hidden" name="sid" value="<?= $r['sid'] ?>">
                    <div class="form-group mt-5">
                        <label for="number">商品編號(不可更改)</label>
                        <input disabled class="form-control disabled" id="number" name="number" cols="30" rows="3" value="<?= htmlentities($r['number']); ?>"></input>
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group ">
                        <label for="name">商品名稱*</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlentities($r['name']); ?>">
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="images">商品圖片*</label>
                            <input type="file" class="form-control" id="images" name="images" accept="image/*" onchange="loadFile(event)">
                                <img src="imgs/<?= $images['fileName'] ?>" alt="" width="300px" id="output" class="w-50 mt-3">
                            <small class="form-text"></small>
                    </div>

                    <div class="form-group">
                        <label for="detail">商品描述*</label>
                        <textarea class="form-control" id="detail" name="detail" cols="30" rows="3"><?= htmlentities($r['detail']); ?></textarea>
                        <small class="form-text"></small>
                    </div>
                    
                    <div class="form-group">
                        <label for="categoriesMain">商品主分類</label>
                        <select class="form-control" id="categoriesMain" name="categoriesMain">
                        <option disabled selected>請選擇</option>
                        <?php foreach($categoriesMain as $cm) : ?>
                        <option value="<?= $cm['id'] ?>" <?php if ($cm['id'] == $r['categories_id']) {echo "selected";} ?>><?= $cm['name'] ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="categoriesChild">商品子分類</label>
                        <select class="form-control" id="categoriesChild" name="categoriesChild">
                        <option disabled selected>請選擇</option>
                        <?php foreach($categoriesChild as $cc) : ?>
                        <option value="<?= $cc['id'] ?>" <?php if ($cc['id'] == $r['categories_parents_id']) {echo "selected";} ?>><?= $cc['name'] ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="brands">商品品牌</label>
                        <select class="form-control" id="brands" name="brands">
                        <option disabled>請選擇</option>
                        <?php foreach ( $brands as $b) : ?>
                        <option value="<?= $b['id'] ?>" 
                        <?php if ($b['id'] == $r['brands_id']) {echo "selected";} ?>><?= $b['name'] ?></option>
                        <?php endforeach; ?>
                        </select> 
                    </div>
                    
                    <div class="form-group">
                        <label for="origin">產地</label>
                        <input type="text" class="form-control" id="origin" name="origin" value="<?= htmlentities($r['origin']); ?>">
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="price">價格</label>
                        <input type="text" class="form-control" id="price" name="price" value="<?= htmlentities($r['price']); ?>">
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="sale">特價</label>
                        <input type="text" class="form-control" id="sale" name="sale" value="<?= htmlentities($r['sale']); ?>">
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="launched">上下架</label>
                        <select class="form-control" id="launched" name="launched">
                        <option disabled>請選擇</option>
                        <option value="1" <?php if ($r['launched'] ==1 ) {echo "selected";} ?>>上架</option>
                        <option value="0" <?php if ($r['launched'] ==0 ) {echo "selected";} ?>>下架</option>
                        </select> 
                        <!-- 忘記一個</select>浪費快一小時... -->
                    </div>
                    <div class="form-group">
                        <label for="size">鞋碼</label>
                        <input type="text" class="form-control" id="size" name="size" value="<?= empty($rStock['size']) ? "無資料"  : htmlentities($rStock['size']) ; ?>">
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="stock">庫存</label>
                        <input type="text" class="form-control" id="stock" name="stock" value="<?= empty($rStock['stock']) ? "無資料"  : htmlentities($rStock['stock']) ; ?>">
                        <small class="form-text"></small>
                    </div> 
 
                    <button type="submit" class="btn btn-primary">修改</button>
                    </form>

               
            </div>
        </div>
    </div>
</div>

<?php include __DIR__. '/partials/scripts.php'; ?>
<script>
    const name = document.querySelector('#name');
    var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };

    function checkForm(){

        name.nextElementSibling.innerHTML = '';
        name.style.border = '1px #CCCCCC solid';

        let isPass = true;
        if(name.value.length < 5){
            isPass = false;
            name.nextElementSibling.innerHTML = '至少要填5個字ㄛ！';
            name.style.border = '1px red solid';
        }
        if(name.value.length > 61){
            isPass = false;
            name.nextElementSibling.innerHTML = '最多不能超過60個字ㄛ！';
            name.style.border = '1px red solid';
        }
        if(isPass){
            const fd = new FormData(document.formEdit)
            fetch('009-li-data-edit-api.php',{
                method:'POST',
                body: fd
            })
                .then(r=>r.json())
                .then(obj=>{
                    console.log(obj);
                    if(obj.success){
                        alert('修改成功!');
                        location.href= '009-li.php';
                    }else{
                        alert(obj.error);
                    }
            })
            // 若是回傳不是JSON資料 記得要做錯誤處理
            .catch(error=>{
                console.log('error:', error);
            });
        }
    }
</script>


<?php include __DIR__. '/partials/html-foot.php'; ?>