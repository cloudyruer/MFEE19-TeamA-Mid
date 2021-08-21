<?php
include __DIR__ . '/partials/init.php';
$title = '新增球場';
$activeLi = 'leo';



?>
<?php include __DIR__ . '/partials/html-head.php'; ?>
<?php include __DIR__ . '/partials/navbar.php'; ?>

<!-- leo css -->
<?php include __DIR__ . '/033-leo-css.php'; ?>
<!-- leo nav -->
<ul class="nav nav-tabs mt-4 pl-5 pr-5">
    <li class="nav-item">
        <a class="nav-link " href="./033-leo-sports-type.php">賽事類別</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="./033-leo-sports-game.php">賽事</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="./033-leo-stadium-type.php">球場類別</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="./033-leo-stadium-list.php">球場</a>
    </li>
</ul>

<div id="container">
    <h1>新增球場</h1>
    <form class="editForm" name="form1" onsubmit="checkForm(); return false;" enctype="multipart/form-data">
        <div class="form-group">
            <label for="stadium_list_name">場館名稱</label>
            <input type="text" class="form-control" id="stadium_list_name" name="stadium_list_name" required placeholder="請輸入中文名稱">
            <small id="stadium_list_name_help" class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label for="city_sel">縣市</label>
            <select class="form-control" id="city_sel" name="city_sel">
            </select>
            <small id="city_sel_help" class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label for="area_sel">行政區</label>
            <select class="form-control" id="area_sel" name="area_sel">
            </select>
            <small id="area_sel_help" class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label for="stadium_list_address">地址</label>
            <input type="text" class="form-control" id="stadium_list_address" name="stadium_list_address">
        </div>
        <div class="form-group">
            <label for="stadium_list_type">選擇運動類型</label>
            <select class="form-control" id="stadium_list_type" name="stadium_list_type">
            </select>
        </div>
        <div class="form-group">
            <label for="stadium_list_kind">選擇設施類型</label>
            <select class="form-control" id="stadium_list_kind" name="stadium_list_kind">
            </select>
        </div>
        <div class="form-group">
            <label for="stadium_list_phone">電話</label>
            <input type="text" class="form-control" id="stadium_list_phone" name="stadium_list_phone">
        </div>
        <div class="form-group">
            <label for="stadium_list_inAndOut">室內外</label>
            <select class="form-control" name="stadium_list_inAndOut" id="stadium_list_inAndOut">
                <option value="" disabled selected>請選擇</option>
                <option value="室外">室外</option>
                <option value="室內">室內</option>
            </select>
        </div>
        <!-- <div class="custom-file">
            <label for="stadium_list_photo">球場照片</label>
            <input type="file" accept="image/*" class="custom-file-input" id="stadium_list_photo" name="stadium_list_photo">
        </div> -->

        <div class="form-group">
            <label for="">Google 網址</label>
            <input type="text" class="form-control" id="" name="googlemapurl" placeholder="請在google將場館的網址複製後貼上">
            <div class=" mt-2"> <a class="btn btn-secondary" href="https://www.google.com/maps/" target="_blank">Google Map</a> <button type="button" id="changeToLatIng" class="btn btn-secondary">轉換為經緯度</button></div>

        </div>

        <div class="form-group">
            <label for="stadium_list_lat">經度</label>
            <input type="text" class="form-control" id="stadium_list_lat" name="stadium_list_lat">
        </div>
        <div class="form-group">
            <label for="stadium_list_lng">緯度</label>
            <input type="text" class="form-control" id="stadium_list_lng" name="stadium_list_lng">
        </div>
        <div class="form-group">
            <p>球場照片</p>
            <div class="custom-file ">
                <input type="file" accept="image/*" class="custom-file-input" id="stadium_list_photo" name="stadium_list_photo">
                <label class="custom-file-label" for="stadium_list_photo">請上傳照片</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">確認新增</button>
    </form>
</div>
<?php include __DIR__ . '/partials/scripts.php'; ?>

<script>
    //google網址經緯度處理
    $(function() {
        $('#changeToLatIng').on('click', function() {
            var url = $('input[name=googlemapurl]').val();
            var regex = new RegExp('@(.*),(.*),');
            var lat_long_match = url.match(regex);
            var lat = lat_long_match[1];
            var long = lat_long_match[2];

            $('input[name=stadium_list_lat]').val(lat);
            $('input[name=stadium_list_lng]').val(long);
        });
    });
    //賽別名稱與選擇盃賽的下拉選單
    let data;
    const sportsDict = {};
    const sportsCat = document.querySelector('#stadium_list_type');
    const sportsGame = document.querySelector('#stadium_list_kind');
    fetch('033-leo-stadium-type-tree.php').then(r => r.json()).then(obj => {
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


    //縣市的下拉選單
    let citydata;
    const cityDict = {};
    const city_sel = document.querySelector('#city_sel');
    const area_sel = document.querySelector('#area_sel');

    const optionTpl = o => {
        return `<option value="${o.value}">${o.name}</option>`;
    };

    const genCitySel = () => {
        let str = '';

        citydata.forEach(el => {
            // 縣市名當 key
            cityDict[el.name] = el.districts;

            str += optionTpl({
                value: el.name,
                name: el.name,
            });
        });
        city_sel.innerHTML = str;
    };

    const genAreaSel = (cityName) => {
        let str = '';

        cityDict[cityName].forEach(el => {
            str += optionTpl({
                value: el.zip,
                name: el.name,
            });
        });
        area_sel.innerHTML = str;
    };

    const onCityChanged = event => {
        genAreaSel(city_sel.value);
    };
    city_sel.addEventListener('change', onCityChanged);

    fetch('033-leo-taiwan-districts.json').then(r => r.json()).then(obj => {
        citydata = obj;
        genCitySel();
        city_sel.dispatchEvent(new Event('change')); // 發送事件，派送事件
    });

    //提交表單
    function checkForm() {
        //代表可以送出表單
        let isPass = true;


        //送出表單（如果上述檢驗正確）
        if (isPass) {
            const fd = new FormData(document.form1);
            fetch('033-leo-stadium-list-createApi.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        location.href = '033-leo-stadium-list.php'; //如果api回傳true，就跳轉至首頁
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
<?php include __DIR__ . '/partials/html-foot.php'; ?>