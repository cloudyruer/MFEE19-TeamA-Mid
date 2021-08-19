<?php
    include __DIR__. '/partials/init.php';
    $title = '新增資料';

    $brands = $pdo->query("SELECT * FROM brands")->fetchAll();

    $categoriesMain = $pdo->query("SELECT * FROM categories WHERE `parents_id` = 0")->fetchAll();

    // $sqlCC = sprintf("SELECT * FROM categories WHERE `parents_id` = %s " , $cm['id']) ;
    // $categoriesChild = $pdo->query($sqlCC)->fetchAll();


    // $categoriesChild = $pdo->query("SELECT * FROM categories")->fetchAll();

    $categoriesChild1 = $pdo->query("SELECT * FROM categories WHERE `parents_id` = 1")->fetchAll();

    $categoriesChild2 = $pdo->query("SELECT * FROM categories WHERE `parents_id` = 2")->fetchAll();

    $categoriesChild3 = $pdo->query("SELECT * FROM categories WHERE `parents_id` = 3")->fetchAll();




    // $sqlImg = "SELECT * FROM `images` WHERE `products_sid` = $sid";
    // $images = $pdo->query($sqlImg)->fetch();
    
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
                    <h5 class="card-title mt-3">新增商品資料</h5>
                    <form name="formInsert" onsubmit="checkForm(); return false;">
                    <div class="form-group mt-5">
                        <label for="name">商品名稱*</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="number">商品編號(未來不可更改)</label>
                        <input type="text" class="form-control" id="number" name="number">
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="images">商品圖片*</label>
                            <input type="file" class="form-control" id="images" name="images" accept="image/*" onchange="loadFile(event)">
                            <img id="output" class="w-50 mt-3"/>
                            <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="detail">商品描述*</label>
                        <textarea class="form-control" id="detail" name="detail" cols="30" rows="3"></textarea>
                        <small class="form-text"></small>
                    </div>
                    <div>
                    <?php // foreach($categoriesMain as $cm) : ?>
                        <div class="form-group">
                            <label for="categoriesMain">商品主分類</label>
                            <select class="form-control" id="categoriesMain" name="categoriesMain" onchange="getID(this.value)">
                            <option disabled selected>請選擇</option>
                            <?php  foreach($categoriesMain as $cm) : ?>
                            <option value="<?= $cm['id'] ?>"><?= $cm['name'] ?></option>
                            <?php $cmid[] = $cm['id'] ?>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- 如何在這邊獲得上面的$cm['id']的值 -->
                        <div class="form-group">
                            <label for="categoriesChild">商品子分類</label>
                            <select class="form-control" id="categoriesChild" name="categoriesChild">
                            <option disabled selected>請選擇</option>
                            <!-- <?php // if($cmid==1): ?>
                            <?php foreach($categoriesChild1 as $cc) : ?>
                            <option value="<?= $cc['id'] ?>"><?= $cc['name'] ?></option>
                            <?php endforeach; ?>
                            <?php // endif; ?>
                            <?php if($cmid==2): ?>
                            <?php foreach($categoriesChild2 as $cc) : ?>
                            <option value="<?= $cc['id'] ?>"><?= $cc['name'] ?></option>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            <?php if($cmid==3): ?>
                            <?php foreach($categoriesChild3 as $cc) : ?>
                            <option value="<?= $cc['id'] ?>"><?= $cc['name'] ?></option>
                            <?php endforeach; ?>
                            <?php endif; ?> -->
                            </select>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="brands">商品品牌</label>
                        <select class="form-control" id="brands" name="brands">
                        <option disabled selected>請選擇</option>
                        <?php foreach ( $brands as $b) : ?>
                        <option value="<?= $b['id'] ?>"><?= $b['name'] ?></option>
                        <?php endforeach; ?>
                        </select> 
                    </div>
                   
                    
                    <div class="form-group">
                        <label for="origin">產地</label>
                        <input type="text" class="form-control" id="origin" name="origin">
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="price">價格</label>
                        <input type="text" class="form-control" id="price" name="price">
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="price">特價</label>
                        <input type="text" class="form-control" id="sale" name="sale">
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="launched">上下架</label>
                        <select class="form-control" id="launched" name="launched">
                        <option disabled selected>請選擇</option>
                        <option value="1">上架</option>
                        <option value="0">下架</option>
                        </select> 
                        <!-- 忘記一個</select>浪費快一小時... -->
                    </div>
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


//---------------分類選單溜--------------------
$(function() {
        $('#categoriesMain').change(function() {
            //更動第一層時第二層清空
            $('#categoriesChild').empty().append("<option value=''>請選擇</option>");
            var i = 0;
            $.ajax({
                type: "GET",
                url: "009-li-deal.php",
                data: {
                    lv: $('#categoriesMain option:selected').val()
                },
                datatype: "json",
                success: function(resuslt) {
                    //當第一層回到預設值時，第二層回到預設位置
                    if (result == "") {
                        $('#categoriesChild').val($('option:first').val());
                    }
                    //依據第一層回傳的值去改變第二層的內容
                    while (i < result.length) {
                        $("#categoriesChild").append("<option value='" + result[i]['id']+ "'>" + result[i]['name'] + "</option>");
                        i++;
                    }
                },
                error: function(xhr, status, msg) {
                    console.error(xhr);
                    console.error(msg);
                }
            });
        });
    });



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
        /* if(number.value == 0)){
            isPass = false;
            number.nextElementSibling.innerHTML = '你沒填到ㄛ！';
            number.style.border = '1px red solid';
        } */
        if(isPass){
            const fd = new FormData(document.formInsert)
            fetch('009-li-data-insert-api.php',{
                method:'POST',
                body: fd
            })
                .then(r=>r.json())
                .then(obj=>{
                    console.log(obj);
                    if(obj.success){
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