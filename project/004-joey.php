<?php
include __DIR__ . '/partials/init.php';
$title = 'Hi Joey!!';
$activeLi = 'joey';

// 若無登入 則返回登入葉面
if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
    exit;
}
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
      body {
        background-color: #151b29;
      }

      .geo_box {
        color: #ffa260;
        border: 2px solid;
        border-radius: 5px;
      }

      .info {
        font-size: 1.3rem;
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 1.2rem;
        font-weight: bold;
      }

      .geo_btn {
        background: none;
        color: #ffa260;
        border: 2px solid;
        transition: all 0.2s;
        font-size: 1.3rem;
        font-weight: 600;
        border-radius: 20px;
        animation: btnShine 0.6s ease-in infinite alternate;
      }

      .geo_btn:hover {
        border-color: #f1ff5c;
        color: #f1ff5c;
        box-shadow: 0 0.5rem 0.5rem -0.4rem #f1ff5c;
        transform: translateY(-0.25rem);
        animation-play-state: paused;
      }

      .geo_btn:active {
        transform: translateY(0);
      }

      .geo_btn_shine {
        border-color: #f1ff5c;
        color: #f1ff5c;
        box-shadow: 0 0.5rem 0.5rem -0.4rem #f1ff5c;
        transform: translateY(-0.25rem);
        animation: btnPopping 0.6s ease-in infinite alternate;
      }

      @keyframes btnShine {
        from {
          box-shadow: 0 0 1rem 0 #f1ff5c;
        }
        to {
          box-shadow: 0 0 0 -0.6rem #f1ff5c;
        }
      }

      @keyframes btnPopping {
        from {
          transform: translateY(-0.25rem);
          box-shadow: 0 0 1rem 0 #f1ff5c;
        }
        to {
          transform: translateY(0);
          box-shadow: 0 0 0 -0.6rem #f1ff5c;
        }
      }

      /* NOTE map */
      #map {
        /* NOTE height setting with vh */
        height: 50vh;
        width: 100%;
      }

      /* NOTE pop up */
      /* pop up的背景 */
      .leaflet-popup .leaflet-popup-content-wrapper {
        background-color: #151b29;
        color: #ffa260;
        border-radius: 15px;
        /* padding: 3px; */
        /* padding-right: 0.6rem; */
      }
      /* pop up 背景下方的三角形 */
      .leaflet-popup .leaflet-popup-tip {
        background-color: #151b29;
      }

      /* pop div內的文字 */
      .leaflet-popup .leaflet-popup-content {
        font-size: 1rem;
      }
    </style>
    <!-- NOTE title -->
    <title>Title</title>
  </head>
  <body>
    <!-- NOTE start -->
    <div class="container mt-3">
      <div class="row align-items-stretch">
        <div class="col-md-6 col-lg-4">
          <div
            class="
              geo_box
              d-flex
              flex-column
              justify-content-center
              align-items-center
              px-5
              h-100
            "
          >
            <!-- NOTE : php -->
            <h3 class="title mt-2 mb-4 font-weight-bold">嗨！<?=$_SESSION['user']['nickname']?></h3>
            <div class="info w-100 px-1">
              緯度:<span class="lat">待確認</span>
            </div>
            <div class="info w-100 px-1">
              經度:<span class="lng">待確認</span>
            </div>
            <div class="info w-100 px-1">
              城市:<span class="city">待確認</span>
            </div>
            <div class="info w-100 px-1">
              區域: <span class="locality">待確認</span>
            </div>
            <!-- for test -->
            <div class="info w-100 px-1">
              誤差:<span class="accuracy">待確認</span>
            </div>
            <!-- NOTE : php -->
            <button class="geo_btn w-100 py-2 mt-1">以<?=$_SESSION['user']['nickname']?>的位置建立活動</button>
          </div>
        </div>

        <div class="col-md-6 col-lg-8">
          <div id="map"></div>
        </div>
      </div>
    </div>
    <!-- form start -->
    <div class="container mt-4">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">以所選位置發起新活動</h5>
              <!-- NOTE FIX onsubmit setting 還有記得FormData POST -->
              <form name="geoForm" id="geoForm">
                <div class="first-line">
                  <!-- 活動類型 -->
                  <!-- combobox -->
                  <div class="form-group">
                    <label for="activity_type">活動類型</label>
                    <select
                      class="form-control"
                      id="activity_type"
                      name="activity_type"
                    >
                      <option value="" disabled selected>
                        -- 請選擇活動類型 --
                      </option>
                      <option value="跑步">跑步</option>
                      <option value="爬山">爬山</option>
                      <option value="游泳">游泳</option>
                      <option value="健身">健身</option>
                      <option value="其他">其他</option>
                    </select>
                    <small class="form-text text-danger invisible typeWarn"
                      >請選擇活動類型</small
                    >
                  </div>
                  <!-- first-line end -->
                </div>

                <!-- 活動內容 -->
                <!-- flex-grow-1 -->
                <div class="form-group">
                  <label for="activity_detail">活動內容</label>
                  <textarea
                    placeholder="請輸入活動內容 15~255字"
                    class="form-control"
                    id="activity_detail"
                    name="activity_detail"
                    cols="30"
                    rows="1"
                    style="resize: none"
                  ></textarea>
                  <small class="form-text text-danger invisible detailWarn"
                    >請輸入15~255字的活動內容</small
                  >
                </div>

                <button type="submit" class="btn btn-primary">建立</button>
              </form>
            </div>
          </div>
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
      const titleText = document.querySelector(".title");
      const latText = document.querySelector(".lat");
      const lngText = document.querySelector(".lng");
      const cityText = document.querySelector(".city");
      const localityText = document.querySelector(".locality");
      const accuracyText = document.querySelector(".accuracy");
      const geoBtn = document.querySelector(".geo_btn");

      // NOTE 瀏覽器API 取得當前地理座標
      const geoLocation = () =>
        new Promise((resolve, reject) => {
          // WARN 此為設定檔 要再討論
          const options = {
            enableHighAccuracy: true,
            // WARN timeout:won't return until the position is available
            // maybe change to 5000?
            timeout: Infinity,
            maximumAge: 0,
          };

          //  if reject
          const userDenied = () =>
            reject(new Error("☜(ﾟヮﾟ☜) 請允許瀏覽器讀取您的位置資料 QQ"));

          navigator.geolocation.getCurrentPosition(
            resolve,
            userDenied,
            options
          );
        });

      // NOTE  geo reverse 取得當前地理位置
      const geoReverse = async (lat, lng) => {
        const revResult = await fetch(
          `https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lng}&localityLanguage=zh`
        );

        if (!revResult.ok) throw new Error("Problem with geoReverse");

        const finalResult = await revResult.json();
        return finalResult;
      };

      //  NOTE Map
      //   create map 使用資策會當作初始地點 zoom 17 -> zoom 14 (once btn fired)
      const map = L.map("map").setView([25.03382, 121.5434], 17);
      // console.log(map);

      //   https://wiki.openstreetmap.org/wiki/Tile_servers
      //   add tile layer to map  NOTE another .org -> .fr/hot
      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
          '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      }).addTo(map);

      // init popup -> would be removed once btn is fired
      const initMarker = L.marker([25.03382, 121.5434])
        .addTo(map)
        .bindPopup("我們的公司在這裡歐👍")
        .openPopup();

      // console.log(
      //   map
      //     .distance(['25.03771', 121.50623], ['25.03785', 121.50465])
      //     .toFixed(0)
      // );

      // NOTE 有時間可討論看看 甚麼時間點 remove initMarker (暫定為全視窗)
      window.addEventListener("click", () => initMarker.remove());

      // 顯示當前位置 點擊新的時候移除先前的
      let userPick;
      map.on("click", async (mapEvent) => {
        // TODO: 當使用者滿足條件時 將地理座標存到資料庫
        console.log(mapEvent);
        // NOTE 這邊取得當前點擊的經緯度
        const { lat, lng } = mapEvent.latlng;

        //FIX:這邊和fetchLocationInfo的code重複了 有時間修一下 + try catch
        const cityInfo = await geoReverse(lat, lng);

        let { city } = cityInfo; //所在城市 e.g.台北市 (因桃園改為市 因此這邊改設為let)
        let { locality } = cityInfo; //所在區  e.g. 中正區  (因桃園改為市 因此這邊改設為let)
        console.log(cityInfo);

        // fix 桃園改名
        if (city === "桃園縣") {
          city = "桃園市";
          locality = locality.slice(0, -1) + "區";
        }

        // for title
        titleText.innerText = "您選擇的位置:";
        // from mapEvent
        latText.innerText = lat.toFixed(6);
        lngText.innerText = lng.toFixed(6);
        // NOTE FIX討論一下怎麼下內文會比較好?
        accuracyText.innerText = "零誤差❤";

        // from geoReverse
        cityText.innerText = city;
        localityText.innerText = locality;

        //////////////////////////////////////////////////////////////
        // console.log(userLat, userLng, 'HERE');
        // NOTE 距離計算  TODO:  userLat userLng 是丟出來的 看以後能不能不要全域
        let distanceStr = "";
        if (userLat && userLng) {
          const distanceBetween = map
            .distance([lat, lng], [userLat, userLng])
            .toFixed(0);
          distanceStr = `<br>距離您 ${distanceBetween} (米)`;
        }
        // 移動到所選位置
        map.flyTo([lat, lng], 17);

        userPick?.remove();
        userPick = L.marker([lat, lng])
          .addTo(map)
          .bindPopup(
            L.popup({
              maxWidth: 250,
              minWidth: 100,
              autoClose: false,
              closeOnClick: false,
              // NOTE personal className
              className: "map_icon",
            })
          )
          .setPopupContent(
            `<strong>選擇的地點位於:<br>${city}${locality}${distanceStr}</strong>`
          )
          .openPopup();
        console.log(userPick);
      });

      /*
        const mapRender = (lat = 25.03382, lng = 121.5434, zoom = 16) => {
          // NOTE zoom max 18? default 13
          const map = L.map('map').setView([lat, lng], zoom);

          //   https://wiki.openstreetmap.org/wiki/Tile_servers
          L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
            attribution:
              '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
          }).addTo(map);

          L.marker([lat, lng]).addTo(map).bindPopup('您的位置').openPopup();
          L.marker([25.03382, 121.5434]).addTo(map).bindPopup('資策會');
        };

        mapRender();

        */

      // NOTE render info into page by using geoLocation & geoReverse
      let curCircle; //避免重複點擊時效果疊加 會於下列函式中 先remove 後再次給值
      let curMarker; // 同上
      let userLat; // TODO:  userLat userLng 是丟出來的 看以後能不能不要全域
      let userLng; // TODO:  userLat userLng 是丟出來的 看以後能不能不要全域
      const fetchLocationInfo = async () => {
        try {
          // guard 在取得用戶當前座標前 用戶已經點選地圖並建立marker的情況
          userPick?.remove();
          titleText.innerText = "計算中";

          const geoInfo = await geoLocation();
          const { latitude: lat } = geoInfo.coords; // 緯度 -> 重新命名為 lat
          const { longitude: lng } = geoInfo.coords; //經度 -> 重新命名為 lng
          const { accuracy } = geoInfo.coords; //準確度(誤差值) 以meters(公尺)為單位
          // const { latitude: lat, longitude: lng, accuracy } = geoInfo.coords;

          //TODO: FIX 這邊為了讓 map.on(click) 的互動 而把userLat userLng 丟出來的 有時間的話修一下
          userLat = lat;
          userLng = lng;

          const cityInfo = await geoReverse(lat, lng);

          let { city } = cityInfo; //所在城市 e.g.台北市 (因桃園改為市 因此這邊改設為let)
          let { locality } = cityInfo; //所在區  e.g. 中正區  (因桃園改為市 因此這邊改設為let)

          // fix 桃園改名
          if (city === "桃園縣") {
            city = "桃園市";
            locality = locality.slice(0, -1) + "區";
          }

          // from geoLocation
          latText.innerText = lat.toFixed(6);
          lngText.innerText = lng.toFixed(6);
          accuracyText.innerText = accuracy.toFixed(1) + " (米)";
          // from geoReverse
          cityText.innerText = city;
          localityText.innerText = locality;
          // for title
          titleText.innerText = "您的位置是在:";
          // for btn
          geoBtn.innerText = "點擊再次尋找 🚴‍♂️";
          geoBtn.classList.add("geo_btn_shine");

          // remove current Marker and Circle
          curMarker?.remove();
          curCircle?.remove();

          // current location popup
          curMarker = L.marker([lat, lng])
            .addTo(map)
            .bindPopup("您的當前位置")
            .openPopup();

          // NOTE 紅圈
          curCircle = L.circle([lat, lng], {
            color: "red",
            fillColor: "#f03",
            fillOpacity: 0.1,
            // Radius of the circle, in meters.
            // 半徑1.5公里 總和3公里
            radius: 1500,
          }).addTo(map);

          // 跳到當前位置 zoom 改為14 放大範圍
          map.flyTo([lat, lng], 14);
        } catch (err) {
          alert(err.message);
        }
      };

      geoBtn.addEventListener("click", fetchLocationInfo);

      // NOTE form data to backend
      const geoForm = document.querySelector("#geoForm");
      geoForm.addEventListener("submit", (e) => {
        e.preventDefault();
        let isPass = true;
        const activityType = document.querySelector("#activity_type");
        const activityDetail = document.querySelector("#activity_detail");
        const typeWarn = document.querySelector(".typeWarn");
        const detailWarn = document.querySelector(".detailWarn");

        const optionType = ["跑步", "爬山", "游泳", "健身", "其他"];
        const warningVisible = (info, visible) => {
          if (visible) return info.classList.remove("invisible");
          info.classList.add("invisible");
        };
        // WARN FIX verify lat (應急用) 之後改成座標生成後才 visible
        if (latText.textContent == "待確認")
          return alert("請先於地圖上選擇發起活動的位置 ಥ_ಥ ");

        // reset
        warningVisible(typeWarn, false);
        warningVisible(detailWarn, false);

        // verify activity type
        if (!optionType.includes(activityType.value)) {
          warningVisible(typeWarn, true);
          isPass = false;
        }
        // verify activity detail
        if (
          activityDetail.value.length < 15 ||
          activityDetail.value.length > 255
        ) {
          warningVisible(detailWarn, true);
          isPass = false;
        }

        if (!isPass) return;

        const fd = new FormData(geoForm);
        fd.append("lat", latText.textContent);
        fd.append("lng", lngText.textContent);
        fd.append("city", cityText.textContent);
        fd.append("locality", localityText.textContent);
        fetch("./004-joey-api.php", {
          method: "POST",
          body: fd,
        })
          .then((res) => res.json())
          .then((obj) => {
            console.log(obj);
            // NOTE if wrong return (might need throw error in future)
            if (!obj.success) return alert(obj.error);

            // confirm 是否繼續建立?
            const createAnother = confirm('建立成功!😎\n請問是否要新增下一筆?\n點擊取消將返回首頁')

            // NOTE 若不續建立 則返回首頁(暫定)
            if(!createAnother){
                location.href = './index_.php';
            };

            // 若要繼續建立 -> reset value
            activityType.value="";
            activityDetail.value="";
          });
      });
    </script>
<?php include __DIR__ . '/partials/html-foot.php';?>