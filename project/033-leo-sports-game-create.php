<?php
include __DIR__ . '/partials/init.php';
$title = '新增賽事';
$activeLi = 'leo';

//此段為編輯用
//抓到前台要修改的資料編號
// $sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

// //結合sid撰寫sql的查詢語法
// $sql = "SELECT `sportsGame`.*, `sportsType`.`name`,`sportsType`.`rank`
//     FROM `sportsGame`
//     JOIN `sportsType`
//         ON `sportsGame`.`gameName` = `sportsType`.`sid` WHERE `sportsGame`.`sid`=$sid";

// //以query將sql語法回傳給sql，並取出第一筆資料
// $row = $pdo->query($sql)->fetch();

// //判斷有值跟沒值要執行什麼
// if (empty($row)) {
//     header('Location: 033-leo-sports-game.php');
//     exit;
// }


?>
<?php include __DIR__ . '/partials/html-head.php'; ?>
<?php include __DIR__ . '/partials/navbar.php'; ?>

<!-- leo css -->
<?php include __DIR__ . '/033-leo-css.php'; ?>
<!-- leo nav -->
<ul class="nav nav-tabs mt-4 pl-5 pr-5">
    <li class="nav-item">
        <a class="nav-link" href="#">賽事類別</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="#">賽事</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">球場類別</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">球場</a>
    </li>
</ul>

<div id="container">
    <h1>新增賽事</h1>
    <form class="editForm" name="form1" onsubmit="checkForm(); return false;">
        <div class="form-group">
            <label for="sports_type_cat">選擇賽別</label>
            <select class="form-control" id="sports_type_cat" name="sports_type_cat">
            </select>
            <small id="sports_type_cat_help" class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label for="sports_type_game">選擇盃賽</label>
            <select class="form-control" id="sports_type_game" name="sports_type_game">
            </select>
            <small id="sports_type_game_help" class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label for="sports_game_one">賽事階段</label>
            <input type="text" class="form-control" id="sports_game_one" name="sports_game_one" required placeholder="請輸入中文名稱">
            <small id="sports_type_game_one_help" class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label for="sports_game_time">比賽時間</label>
            <input type="date" class="form-control" id="sports_game_time" name="sports_game_time" required>
            <small id="" class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label for="sports_game_p1">對手1</label>
            <input type="text" class="form-control" id="sports_game_p1" name="sports_game_p1">
            <small id="" class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label for="sports_game_p2">對手2</label>
            <input type="text" class="form-control" id="sports_game_p2" name="sports_game_p2">
            <small id="" class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label for="sports_game_stadium">場地</label>
            <input type="text" class="form-control" id="sports_game_stadium" name="sports_game_stadium">
            <small id="" class="form-text text-muted"></small>
        </div>

        <button type="submit" class="btn btn-primary">確認新增</button>
    </form>
</div>

<script>
    //賽別名稱與選擇盃賽的下拉選單
    let data;
    const sportsDict = {};
    const sportsCat = document.querySelector('#sports_type_cat');
    const sportsGame = document.querySelector('#sports_type_game');
    fetch('033-leo-sports-type-tree.php').then(r => r.json()).then(obj => {
        data = obj;
        putInCat()
        putInGame()
    });
    let thisCat = 1;

    function putInCat() {
        data.forEach((ar) => {
            sportsCat.innerHTML += `<option id=sportsCat${ar.sid} value=${ar.sid}>${ar.name}</option>`
        });
    };

    function putInGame() {
        data.forEach((ar) => {
            if (ar.sid == thisCat) {
                ar.nodes.forEach(element => {
                    sportsGame.innerHTML += `<option id=sportsCat${element.sid}  value=${element.sid}>${element.name}</option>`
                });
            }
        });
    };
    sportsCat.addEventListener("change", changeSportsCat)

    function changeSportsCat() {
        thisCat = sportsCat.value;
        sportsGame.innerHTML = ""
        putInGame()
    }


    //提交表單

    function checkForm() {
        //代表可以送出表單
        let isPass = true;


        //送出表單（如果上述檢驗正確）
        if (isPass) {
            const fd = new FormData(document.form1);
            fetch('033-leo-sports-game-createApi.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        location.href = '033-leo-sports-game.php'; //如果api回傳true，就跳轉至首頁
                    } else {
                        alert(obj.error);
                    }
                })
                .catch(error => {
                    console.log('error:', error); //如果回傳出錯，就顯示在console
                });
        }
    }
</script>
<?php include __DIR__ . '/partials/scripts.php'; ?>
<?php include __DIR__ . '/partials/html-foot.php'; ?>