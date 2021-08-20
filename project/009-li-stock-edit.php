<?php
include __DIR__. '/partials/init.php';
$title = '修改庫存資料';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// echo json_encode($_GET['sid']);

$sqlProducts = "SELECT * FROM `products` WHERE sid=$sid ";
$r = $pdo->query($sqlProducts)->fetch();

$sqlStock = "SELECT * FROM `stock` WHERE `stock`.`id`= $id";
$rStock = $pdo->query($sqlStock)->fetch();


    
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
                    <form name="formStockEdit" onsubmit="checkForm(); return false;">
                    <input type="hidden" name="id" value="<?= $id ?>">
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

                    

                    <button type="submit" class="btn btn-primary mt-5">修改</button>


                    </form>

               
                </div>
            </div>
        </div>
    </div>

<?php include __DIR__. '/partials/scripts.php'; ?>
<script>


function checkForm(){

        let isPass = true;
        if(isPass){
            const fd = new FormData(document.formStockEdit)
            fetch('009-li-stock-edit-api.php',{
                method:'POST',
                body: fd
            })
                .then(r=>r.json())
                .then(obj=>{
                    console.log(obj);
                    if(obj.success){
                        alert('修改成功！')
                        location.href =' 009-li-stock.php?sid=<?= $r['sid'] ?>';
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