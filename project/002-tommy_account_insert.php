<?php
    include __DIR__. '/partials/init.php';
    $title = '新增資料';

    // $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // $sql = "INSERT INTO `members`  password=$password";


    // $r = $pdo->query($sql)->fetch();

    /*
// 錯誤的作法: 可能受到 SQL injection 攻擊
$sql = "INSERT INTO `address_book`(
               `name`, `email`, `mobile`,
               `birthday`, `address`, `created_at`
               ) VALUES (
                    '{$_POST['name']}', '{$_POST['email']}', '{$_POST['mobile']}',
                    '{$_POST['birthday']}', '{$_POST['address']}', NOW()
               )";

$stmt = $pdo->query($sql);
*/

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
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">新增資料</h5>

                    <form name="form1" onsubmit="checkForm(); return false;">
                        <div class="form-group">
                            <label for="account">姓名 *</label>
                            <input type="text" class="form-control" id="account" name="account">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="password">password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="form-text"></small>
                        </div>
                        <div class="form-group">
                            <label for="email">email *</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <small class="form-text "></small>
                        </div>
                        <!-- <div class="form-group">
                            <label for="avatar">avatar</label>
                            <input type="text" class="form-control" id="avatar" name="avatar">
                            <small class="form-text "></small>
                        </div> -->
                        <div class="form-group">
                            <label for="mobile">mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="address">address</label>
                            <input type="text" class="form-control" id="address" name="address">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="birthday">birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="nickname">nickname</label>
                            <input type="text" class="form-control" id="nickname" name="nickname">
                            <small class="form-text "></small>
                        </div>

                        <button type="submit" class="btn btn-primary">註冊</button>
                    </form>


                </div>
            </div>
        </div>
    </div>


</div>
<?php include __DIR__. '/partials/scripts.php'; ?>
<script>
    const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;
    const password_re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,15}$/;


    const email = document.querySelector('#email');
    const mobile = document.querySelector('#mobile');
    const password = document.querySelector('#password');

    function checkForm(){
        // 欄位的外觀要回復原來的狀態
        email.nextElementSibling.innerHTML = '';
        email.style.border = '1px #CCCCCC solid';
        mobile.nextElementSibling.innerHTML = '';
        mobile.style.border = '1px #CCCCCC solid';
        password.nextElementSibling.innerHTML = '';
        password.style.border = '1px #CCCCCC solid';

        let isPass = true;
        if (!email_re.test(email.value)) {
            isPass = false;
            email.nextElementSibling.innerHTML = '請填寫正確的 Email 格式';
            email.style.border = '1px red solid';
        }

        if (!mobile_re.test(mobile.value)) {
            isPass = false;
            mobile.nextElementSibling.innerHTML = '請填寫正確的 電話號碼 格式';
            mobile.style.border = '1px red solid';
        }
        if (!password_re.test(password.value)) {
            isPass = false;
            password.nextElementSibling.innerHTML = 
            '密碼必須包含大小寫字母和數字的組合，不能使用特殊字符，長度在6-15之間'
            password.style.border = '1px red solid';
        }

        if(isPass){
            const fd = new FormData(document.form1);
            fetch('002-tommy_signup-api.php', {
                method: 'POST',
                body: fd
            })
                .then(r=>r.json())
                .then(obj=>{
                    console.log(obj);
                    if(obj.success){
                        alert('新增成功')
                        location.href = '002-tommy_account_list.php';
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