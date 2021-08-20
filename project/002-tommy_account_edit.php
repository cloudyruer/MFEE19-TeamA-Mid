<?php
include __DIR__ . '/partials/init.php';
$title = '修改資料';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM `members` WHERE id=$id";

//    echo $sql; exit;

$r = $pdo->query($sql)->fetch();

if (empty($r)) {
    header('Location: 002-tommy_account_list.php');
    exit;
}
// echo json_encode($r, JSON_UNESCAPED_UNICODE);
?>
<?php include __DIR__ . '/partials/html-head.php'; ?>
<?php include __DIR__ . '/partials/navbar.php'; ?>
<style>
    form .form-group small {
        color: red;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改資料</h5>

                    <form name="form1" onsubmit="checkForm(); return false;">
                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                        <div class="form-group">
                            <!-- <label for="avatar">大頭貼</label> -->
                            <input type="hidden" class="form-control" id="avatar" name="avatar" accept="image/*" onchange="readURL(this)" targetID="preview_img">
                            <!-- <input type="text" class="form-control" id="clean" name="clean"?>"> -->
                            <a href=""></a>
                            <?php if (empty($r['avatar'])) : ?>
                                <!-- 預設的大頭貼 -->
                                <!-- <img id="preview_img" src="./imgs/default_avatar.jpeg" alt="" width="300px"> -->
                            <?php else : ?>
                                <!-- 顯示原本的大頭貼 -->
                                <!-- <img id="preview_img" src="imgs/<?= $r['avatar'] ?>" alt="" width="300px"> -->
                            <?php endif; ?>

                        </div>
                        <div class="form-group">
                            <label for="account">Account </label>
                            <input type="text" class="form-control" id="account" name="account" value="<?= htmlentities($r['account']) ?>" disabled>
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <!-- <label for="password">Password </label> -->
                            <input type="hidden" class="form-control" id="password" name="password" value="<?= htmlentities($r['password']) ?>">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="email">email</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?= htmlentities($r['email']) ?>">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="mobile">mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value="<?= htmlentities($r['mobile']) ?>">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="mobile">address</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?= htmlentities($r['address']) ?>">
                            <small class="form-text "></small>
                        </div>

                        <div class="form-group">
                            <label for="birthday">birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" value="<?= htmlentities($r['birthday']) ?>">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="nickname">暱稱</label>
                            <input type="text" class="form-control" id="nickname" name="nickname" value="<?= htmlentities($r['nickname']) ?>">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <!-- <label for="create_at">create_at</label> -->
                            <input type="hidden" class="form-control" id="create_at" name="create_at" value="<?= htmlentities($r['create_at']) ?>">
                            <small class="form-text "></small>
                        </div>
                        <button type="submit" class="btn btn-primary">修改</button>
                    </form>


                </div>
            </div>
        </div>
    </div>


</div>
<?php include __DIR__ . '/partials/scripts.php'; ?>
<script>
    const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;

    const account = document.querySelector('#account');
    const email = document.querySelector('#email');

    function checkForm() {
        // 欄位的外觀要回復原來的狀態
        account.nextElementSibling.innerHTML = '';
        account.style.border = '1px #CCCCCC solid';
        email.nextElementSibling.innerHTML = '';
        email.style.border = '1px #CCCCCC solid';

        let isPass = true;
        if (account.value.length < 2) {
            isPass = false;
            account.nextElementSibling.innerHTML = '請填寫正確的姓名';
            account.style.border = '1px red solid';
        }

        if (!email_re.test(email.value)) {
            isPass = false;
            email.nextElementSibling.innerHTML = '請填寫正確的 Email 格式';
            email.style.border = '1px red solid';
        }

        if (isPass) {
            const fd = new FormData(document.form1);
            fetch('002-tommy_account_edit-api2.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('修改成功'); //or boostrap的model
                        location.href = '002-tommy_account_list.php';

                    } else {
                        alert(obj.error);
                    }
                })
                .catch(error => {
                    console.log('error:', error);
                });
            
        }
    }
</script>
<?php include __DIR__ . '/partials/html-foot.php'; ?>