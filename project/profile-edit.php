<?php
// 資料表要增加一個存放圖片檔名的欄位
// ALTER TABLE `members` ADD `avatar` VARCHAR(255) NULL DEFAULT '' AFTER `id`;

include __DIR__ . '/partials/init.php';
$title = '修改個人資料';
// NOTE add $activeLi
$activeLi = 'edit';

if (!isset($_SESSION['user'])) {
    header('Location: index_.php');
    exit;
}

$sql = "SELECT * FROM `members` WHERE id=" . intval($_SESSION['user']['id']);

$r = $pdo->query($sql)->fetch();

if (empty($r)) {
    header('Location: index_.php');
    exit;
}
?>
<?php include __DIR__ . '/partials/html-head.php';?>
<?php include __DIR__ . '/partials/navbar.php';?>
<style>
    form .form-group small {
        color: red;
    }
</style>
<!-- NOTE change mt-3 -->
<div class="container mt-3">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改個人資料</h5>

                    <form name="form1" onsubmit="checkForm(); return false;">
                        <div class="form-group">
                            <label for="avatar">大頭貼</label>
                            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                            <?php if (empty($r['avatar'])): ?>
                                <!-- 預設的大頭貼 -->
                            <?php else: ?>
                                <!-- 顯示原本的大頭貼 -->
                                <img src="imgs/<?=$r['avatar']?>" alt="" width="300px">
                            <?php endif;?>

                        </div>
                        <div class="form-group">
                            <!-- NOTE  Email(不能修改) -> Account(不能修改)-->
                            <label for="account">Account (帳號不能修改)</label>
                            <input type="text" class="form-control" disabled
                                   value="<?=htmlentities($r['account'])?>">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="nickname">暱稱</label>
                            <input type="text" class="form-control" id="nickname" name="nickname"
                                   value="<?=htmlentities($r['nickname'])?>">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="email">email</label>
                            <input type="text" class="form-control" id="email" name="email"
                                   value="<?=htmlentities($r['email'])?>">
                            <small class="form-text "></small>
                        </div>

                        <div class="form-group">
                            <label for="birthday">birthday</label>
                            <input type="text" class="form-control" id="birthday" name="birthday"
                                   value="<?=htmlentities($r['birthday'])?>">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="mobile">mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile"
                                   value="<?=htmlentities($r['mobile'])?>">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="create_at">create_at</label>
                            <input type="text" class="form-control" id="create_at" name="create_at"
                                   value="<?=htmlentities($r['create_at'])?>">
                            <small class="form-text "></small>
                        </div>
                        <button type="submit" class="btn btn-primary">修改</button>
                    </form>


                </div>
            </div>
        </div>
    </div>


</div>
<?php include __DIR__ . '/partials/scripts.php';?>
<script>

    function checkForm(){

            const fd = new FormData(document.form1);
            fetch('profile-edit-api.php', {
                method: 'POST',
                body: fd
            })
                .then(r=>r.json())
                .then(obj=>{
                    console.log(obj);
                    if(obj.success){
                        alert('修改成功');
                    } else {
                        alert(obj.error);
                    }
                })
                .catch(error=>{
                    console.log('error:', error);
                });


    }
</script>
<?php include __DIR__ . '/partials/html-foot.php';?>