<?php
    include __DIR__. '/partials/init.php';
    $title = '修改文章';

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $sql = "SELECT * FROM `Blog` WHERE id=$id";

//    echo $sql; exit;

    $r = $pdo->query($sql)->fetch();

    if(empty($r)){
        header('Location: 001-emma-blog-list.php');
        exit;
    }
    // echo json_encode($r, JSON_UNESCAPED_UNICODE);
?>
<?php include __DIR__. '/partials/html-head.php'; ?>
<?php include __DIR__. '/partials/navbar.php'; ?>
<style>
    form .form-group small {
        color: red;
    }
</style>
<div class="container">
        <div class="row">
            <div class="col my-3">
                <button type="button" class="btn btn-secondary insert" onclick="location.href='001-emma-blog-list.php'">文章列表</button>

            </div>
            
        </div>
    </div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改文章</h5>

                    <form name="form1" onsubmit="checkForm(); return false;">
                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                        <div class="form-group">
                            <label for="author">作者 *</label>
                            <input type="text" class="form-control" id="author" name="author"
                                value="<?= htmlentities($r['author']) ?>">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="nick_name">暱稱</label>
                            <input type="text" class="form-control" id="nick_name" name="nick_name"
                                   value="<?= htmlentities($r['nick_name']) ?>">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                                <label for="images">文章預覽圖片*</label>
                                <input type="file" class="form-control" id="images" name="images" accept="image/*" onchange="loadFile(event)">
                                <img id="preview_img" class="w-50 mt-3"/>
                                <small class="form-text"></small>
                        </div>
                        
                        <div class="form-group">
                            <label for="title">標題 *</label>
                            <input type="text" class="form-control" id="title" name="title"
                                   value="<?= htmlentities($r['title']) ?>">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="content">內文 *</label>
                            <textarea class="form-control" id="content" name="content" cols="30" rows="10"
                                ><?= htmlentities($r['content']) ?></textarea>
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                                <label for="category">文章分類</label>
                                <select class="form-control" id="category" name="category">
                                <option disabled>請選擇</option>
                                <option value="男鞋">男鞋</option>
                                <option value="女鞋">女鞋</option>
                                <option value="其他商品">其他商品</option>
                                </select>
                        </div>

                        <button type="submit" class="btn btn-primary">修改</button>
                    </form>


                </div>
            </div>
        </div>
    </div>


</div>
<?php include __DIR__. '/partials/scripts.php'; ?>
<script>
    
    const author = document.querySelector('#author');
    const title = document.querySelector('#title');
    const content = document.querySelector('#content');

    function loadFile(event) {
        var preview_img = document.getElementById('preview_img');
        preview_img.src = URL.createObjectURL(event.target.files[0]);
        preview_img.onload = function() {
            URL.revokeObjectURL(preview_img.src) // free memory
        }
    };

    function checkForm(){
        // 欄位的外觀要回復原來的狀態
        author.nextElementSibling.innerHTML = '';
        author.style.border = '1px #CCCCCC solid';
        title.nextElementSibling.innerHTML = '';
        title.style.border = '1px #CCCCCC solid';
        content.nextElementSibling.innerHTML = '';
        content.style.border = '1px #CCCCCC solid';
        

        let isPass = true;
        if(author.value.length < 2){
            isPass = false;
            author.nextElementSibling.innerHTML = '請填寫正確的姓名';
            author.style.border = '1px red solid';
        }

        if(title.value.length <= 0){
            isPass = false;
            title.nextElementSibling.innerHTML = '請填寫標題';
            title.style.border = '1px red solid';
        }

        if(content.value.length <= 0){
            isPass = false;
            content.nextElementSibling.innerHTML = '請填寫內文';
            content.style.border = '1px red solid';
        }

        

        if(isPass){
            const fd = new FormData(document.form1);
            fetch('001-emma-blog-edit-api.php', {
                method: 'POST',
                body: fd
            })
                .then(r=>r.json())
                .then(obj=>{
                    console.log(obj);
                    if(obj.success){
                        alert('修改成功');
                        location.href = '001-emma-blog-list.php';
                    } else {
                        alert(obj.error);
                    }
                })
                .catch(error=>{
                    console.log('error:', error);
                });
        }
    }
</script>
<?php include __DIR__. '/partials/html-foot.php'; ?>
