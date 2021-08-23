<?php
include __DIR__ . '/partials/init.php';
$title = '修改資料';
$activeLi = 'joey';

// TODO: 顯示地圖

// guard 登入後才可以使用
if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
    exit;
}

// 這個id是活動的id(geo_info的id) (對使用者是隱藏的)
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 其實session 就有 members的資料 (因為要求要登入) 但再練一次JOIN吧 XDD
// 但這樣重新抓的好處是 管理員介面也可以重複使用 因為綁定的是選定的資料而非登入者
$sql = "SELECT geo_info.id, nickname , city, locality, lat, lng, activity_type,activity_detail, changed_at
FROM geo_info JOIN members
ON members.id = members_id WHERE geo_info.id = {$id} ";

$r = $pdo->query($sql)->fetch();

// 如果有拿到會是關聯式陣列 出錯的話直接回到原資料頁面
if (empty($r)) {
    header('Location: 004-joey-datalist.php');
    exit;
}

// for debug
// echo json_encode($r, JSON_UNESCAPED_UNICODE);exit;
?>

<?php include __DIR__ . '/partials/html-head.php';?>
<?php include __DIR__ . '/partials/navbar.php';?>
<!-- leaflet css -->
<link
      rel="stylesheet"
      href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
      integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
      crossorigin=""
    />
<style>
    form .form-group small {
        color: red;
    }

      /* NOTE map */
      #map {
        /* NOTE height setting with vh */
        height: 100%;
        width: 100%;
      }
</style>

<div class="container mt-3">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改活動類型與內容</h5>
                    <form name="form1" onsubmit="checkForm(); return false;">
                        <!-- 用來 where -->
                        <input type="hidden" name="id" value="<?=$r['id']?>">
                        <!-- 不給改 NOTE 沒有name-->
                        <div class="form-group">
                            <label>舉辦者 *</label>
                            <input class="form-control" disabled
                                value="<?=htmlentities($r['nickname'])?>">
                            <small class="form-text"></small>
                        </div>
                        <!-- 暫時不給改 看之後版本決定 NOTE 沒有name -->
                        <div class="form-group">
                            <label>活動舉辦地點 *</label>
                            <input class="form-control"
                                   value="<?=htmlentities($r['city'])?> <?=htmlentities($r['locality'])?>" disabled>
                            <small class="form-text"></small>
                        </div>
                        <!-- TODO: drop down list -->
                        <div class="form-group">
                            <label for="activity_type">活動類型</label>
                            <select
                                class="form-control"
                                id="activity_type"
                                name="activity_type"
                            >
                                <option value="跑步" <?=$r['activity_type'] == "跑步" ? 'selected' : ''?>>跑步</option>
                                <option value="爬山" <?=$r['activity_type'] == "爬山" ? 'selected' : ''?>>爬山</option>
                                <option value="游泳" <?=$r['activity_type'] == "游泳" ? 'selected' : ''?>>游泳</option>
                                <option value="健身" <?=$r['activity_type'] == "健身" ? 'selected' : ''?>>健身</option>
                                <option value="其他" <?=$r['activity_type'] == "其他" ? 'selected' : ''?>>其他</option>
                            </select>
                        </div>
                       <!-- drop down list -->
                        <!-- textarea start -->
                        <div class="form-group">
                            <label for="activity_detail">活動內容</label>
                            <textarea
                                placeholder="請輸入活動內容 15~255字"
                                class="form-control"
                                id="activity_detail"
                                name="activity_detail"
                                cols="30"
                                rows="5"
                                style="resize: none"
                            ><?=htmlentities($r['activity_detail'])?></textarea>
                            <small class="form-text text-danger invisible detailWarn"
                                >請輸入15~255字的活動內容</small
                            >
                        </div>
                        <!-- textarea end -->
                        <div class="d-flex justify-content-between align-items-baseline">
                            <button type="submit" class="btn btn-primary">修改</button>
                            <div>最後編輯時間: <?=$r['changed_at']?></div>
                        </div>
                    </form>


                </div>
            </div>
        </div>

        <div class="col-md-6">
          <div id="map"></div>
        </div>
    </div>


</div>
<?php include __DIR__ . '/partials/scripts.php';?>
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script
      src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
      integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
      crossorigin=""
    ></script>
<script>
    // map
    const map = L.map("map").setView([<?=$r['lat']?>, <?=$r['lng']?>], 16);

      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
          '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      }).addTo(map);

      const initMarker = L.marker([<?=$r['lat']?>, <?=$r['lng']?>])
          .addTo(map)
          .bindPopup(
            L.popup({
              maxWidth: 250,
              minWidth: 100,
              autoClose: false,
              closeOnClick: false,
              // NOTE personal className: this one not yet used!!
              className: "map_icon",
            })
          )
          .setPopupContent(
            `<h4>活動的舉辦位置🚴‍♂️</h4>`
          )
          .openPopup();

    function checkForm(){
        let isPass = true;


        //
        const activityDetail = document.querySelector("#activity_detail");
        const detailWarn = document.querySelector(".detailWarn");

        const warningVisible = (info, visible) => {
          if (visible) return info.classList.remove("invisible");
          info.classList.add("invisible");
        };
        // reset
        warningVisible(detailWarn, false);

         // verify activity detail
         if (
          activityDetail.value.length < 15 ||
          activityDetail.value.length > 255
        ) {
          warningVisible(detailWarn, true);
          isPass = false;
        }

        if(isPass){
            const fd = new FormData(document.form1);
            // 附加並且將現網址傳送到後端
            fd.append('location', document.referrer);
            fetch('004-joey-data-edit-api.php', {
                method: 'POST',
                body: fd
            })
                .then(r=>r.json())
                .then(obj=>{
                    console.log(obj);
                    if(obj.success){
                        alert('修改成功')
                        location.href=obj.location;//NOTE跳轉
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
<?php include __DIR__ . '/partials/html-foot.php';?>

