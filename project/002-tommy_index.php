<?php
include __DIR__ . '/partials/init.php';
$title = 'Hi Tommy!!';
$activeLi = 'tommy';

if (!isset($_SESSION['user'])) {
    header('Location: index_.php');
    exit;
}

// $sql = "SELECT * FROM `members` WHERE id=" . intval($_SESSION['user']['id']);
$sql = "SELECT `account_ranking`.*, `members`.*
FROM `account_ranking`
JOIN `members`
    ON `account_ranking`.`members_id` = `members`.`id` WHERE `members`.id =". intval($_SESSION['user']['id']);


$r = $pdo->query($sql)->fetch();

// SELECT o.members_sid, o.order_date, d.*, p.bookname
// FROM `orders` o
//     JOIN `order_details` d
//         ON o.sid=d.order_sid
//     JOIN `products` p
//         ON p.sid=d.product_sid
// WHERE o.sid=10

// $sql2 = "SELECT * FROM members WHERE email=?";
// $dpassword = password_verify($sql['password'], $r['password']);
// $stmt = $pdo->prepare($sql);
// $stmt->execute([$dpassword]);
// $m = $stmt->fetch();


if (empty($r)) {
    header('Location: index_.php');
    exit;
}
?>
<?php include __DIR__ . '/partials/html-head.php'; ?>
<?php include __DIR__ . '/partials/navbar.php'; ?>

<style>
    .basic_container {
        width: 100%;
    }

    .mypage_outsidebar {
        width: 30%;

    }

    .mypage_insidebar {
        border: 1px solid black;
        width: 100%;
        height: 300px;
    }

    .mypage_main {
        border: 1px solid black;
        width: 65%;
        height: 752px;
    }
</style>
<!-- <li class="nav-item">
    <?php if (!empty($_SESSION['user']['avatar'])) : ?>
        <img src="./imgs/default_avatar.jpeg" alt="" width="300px">
    <?php else : ?>
        <img src="imgs/<?= $_SESSION['user']['avatar'] ?>" alt="" width="50px">
    <?php endif; ?>
</li> -->

<div class="container mt-3">

    <div class="basic_container d-flex justify-content-between">
        <?php include __DIR__ . '/002-tommy_mypage_bar.php'; ?>
        <div class="mypage_main">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改個人資料</h5>

                    <form name="form1" onsubmit="checkForm(); return false;" action="/somewhere/to/upload" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="avatar">大頭貼</label>
                            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*" onchange="readURL(this)" targetID="preview_img">
                            <!-- <input type="text" class="form-control" id="clean" name="clean"?>"> -->
                            <a href=""></a>
                            <?php if (empty($r['avatar'])) : ?>
                                <!-- 預設的大頭貼 -->
                                <img id="preview_img" src="./imgs/default_avatar.jpeg" alt="" width="300px">
                            <?php else : ?>
                                <!-- 顯示原本的大頭貼 -->
                                <img id="preview_img" src="imgs/<?= $r['avatar'] ?>" alt="" width="300px">
                            <?php endif; ?>

                        </div>
                        <div class="form-group">
                            <label for="account">Account </label>
                            <input type="text" class="form-control" id="account" name="account" value="<?= htmlentities($r['account']) ?>" disabled>
                            <small class="form-text "></small>
                        </div>
                        <!-- <div class="form-group">
                            <label for="password_o">原來的密碼</label>
                            <input type="text" class="form-control" id="password_o" name="password_o">
                            <small class="form-text "></small>
                        </div> -->
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

    <!-- <h2>Hi Tommy!! <a href="002-tommy-api.php">Click me!</a> ☜(ﾟヮﾟ☜)</h2> -->
</div>
<?php include __DIR__ . '/partials/scripts.php'; ?>

<script>
    function checkForm() {

        const fd = new FormData(document.form1);
        fetch('002-tommy_profile-api.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(obj => {
                console.log(obj);
                if (obj.success) {
                    alert('修改成功');
                    location.href = '002-tommy_index.php';

                } else {
                    alert(obj.error);
                }
            })
            .catch(error => {
                console.log('error:', error);
            });


    };

    function readURL(input) {

        if (input.files && input.files[0]) {

            var imageTagID = input.getAttribute("targetID");

            var reader = new FileReader();

            reader.onload = function(e) {

                var img = document.getElementById(imageTagID);

                img.setAttribute("src", e.target.result)

            }

            reader.readAsDataURL(input.files[0]);

        }

    }

    // let file = document.querySelector('#avatar');
    // let clean = document.querySelector('#clean');

    // clean.addEventListener('click', (ev) => {
    //     file.value = null;
    // });
</script>
<?php include __DIR__ . '/partials/html-foot.php'; ?>