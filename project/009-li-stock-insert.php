<?php
include __DIR__. '/partials/init.php';
$title = '新增庫存資料';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;


$sql ="SELECT * FROM (`products` LEFT JOIN `stock` ON `stock`.`products_id` = `sid`) WHERE `sid` = $sid";
$rows = $pdo->query($sql)->fetch();

$rStock = $pdo->query("SELECT * FROM `stock` WHERE `products_id`= $sid")->fetch();

$sqlProducts = "SELECT * FROM `products` WHERE sid=$sid ";

$r = $pdo->query($sqlProducts)->fetch();
    
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
                    <h5 class="card-title mt-3">產品鞋碼資料</h5>
                    <form name="formStockInsert" onsubmit="checkForm(); return false;">
                    <input type="hidden" name="sid" value="<?= $r['sid'] ?>">
                    <div class="form-group">
                        <label for="size">鞋碼</label>
                        <input type="text" class="form-control" id="size" name="size">
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="stock">庫存</label>
                        <input type="text" class="form-control" id="stock" name="stock">
                        <small class="form-text"></small>
                    </div>

                    

                    <button type="submit" class="btn btn-primary mt-5">新增</button>


                    </form>

               
                </div>
            </div>
        </div>
    </div>

<?php include __DIR__. '/partials/scripts.php'; ?>
<script>
    
const name = document.querySelector('#name');
const size = document.querySelector('#size');
const number = document.querySelector('#number');

// ---------------照片預覽-----------------
var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
};
// ---------------照片預覽-----------------




function checkForm(){

        let isPass = true;
        if(isPass){
            const fd = new FormData(document.formStockInsert)
            fetch('009-li-stock-insert-api.php',{
                method:'POST',
                body: fd
            })
                .then(r=>r.json())
                .then(obj=>{
                    console.log(obj);
                    if(obj.success){
                        location.href= '009-li-stock.php?sid=<?= $r['sid'] ?>';
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