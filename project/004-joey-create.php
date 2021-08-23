<?php include __DIR__ . '/partials/init.php';
$title = 'Hi Joey!!';
$activeLi = 'joey';if (!isset($_SESSION['user'])) {header('Location: ./login.php');exit;}?><?php include __DIR__ . '/partials/html-head.php';?><?php include __DIR__ . '/partials/navbar.php';?>
<link crossorigin=""href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="rel="stylesheet"><style>body{background-color:#151b29}.geo_box{color:#ffa260;border:2px solid;border-radius:5px}.info{font-size:1.3rem;display:flex;justify-content:space-between;align-items:baseline;margin-bottom:1.2rem;font-weight:700}.geo_btn{background:0 0;color:#ffa260;border:2px solid;transition:all .2s;font-size:1.3rem;font-weight:600;border-radius:20px;animation:btnShine .6s ease-in infinite alternate}.geo_btn:hover{border-color:#f1ff5c;color:#f1ff5c;box-shadow:0 .5rem .5rem -.4rem #f1ff5c;transform:translateY(-.25rem);animation-play-state:paused}.geo_btn:active{transform:translateY(0)}.geo_btn_shine{border-color:#f1ff5c;color:#f1ff5c;box-shadow:0 .5rem .5rem -.4rem #f1ff5c;transform:translateY(-.25rem);animation:btnPopping .6s ease-in infinite alternate}@keyframes btnShine{from{box-shadow:0 0 1rem 0 #f1ff5c}to{box-shadow:0 0 0 -.6rem #f1ff5c}}@keyframes btnPopping{from{transform:translateY(-.25rem);box-shadow:0 0 1rem 0 #f1ff5c}to{transform:translateY(0);box-shadow:0 0 0 -.6rem #f1ff5c}}#map{height:50vh;width:100%}.leaflet-popup .leaflet-popup-content-wrapper{background-color:#151b29;color:#ffa260;border-radius:15px}.leaflet-popup .leaflet-popup-tip{background-color:#151b29}.leaflet-popup .leaflet-popup-content{font-size:1rem}</style><body><div class="container mt-3"><div class="row align-items-stretch"><div class="col-md-6 col-lg-4"><div class="align-items-center d-flex flex-column geo_box h-100 justify-content-center px-5"><h3 class="font-weight-bold mb-4 mt-2 title">嗨！<?=$_SESSION['user']['nickname']?></h3><div class="w-100 info px-1">緯度:<span class="lat">待確認</span></div><div class="w-100 info px-1">經度:<span class="lng">待確認</span></div><div class="w-100 info px-1">城市:<span class="city">待確認</span></div><div class="w-100 info px-1">區域: <span class="locality">待確認</span></div><div class="w-100 info px-1">誤差:<span class="accuracy">待確認</span></div><button class="w-100 geo_btn mt-1 py-2">以<?=$_SESSION['user']['nickname']?>的位置建立活動</button></div></div><div class="col-md-6 col-lg-8"><div id="map"></div></div></div></div><div class="container mt-4"><div class="row"><div class="col"><div class="card"><div class="card-body"><h5 class="card-title">以所選位置發起新活動</h5><form id="geoForm"name="geoForm"><div class="first-line"><div class="form-group"><label for="activity_type">活動類型</label> <select class="form-control"id="activity_type"name="activity_type"><option value=""disabled selected>-- 請選擇活動類型 --</option><option value="跑步">跑步</option><option value="爬山">爬山</option><option value="游泳">游泳</option><option value="健身">健身</option><option value="其他">其他</option></select> <small class="form-text invisible text-danger typeWarn">請選擇活動類型</small></div></div><div class="form-group"><label for="activity_detail">活動內容</label> <textarea class="form-control"cols="30"id="activity_detail"name="activity_detail"placeholder="請輸入活動內容 15~255字"rows="1"style="resize:none"></textarea> <small class="form-text invisible text-danger detailWarn">請輸入15~255字的活動內容</small></div><button class="btn btn-primary"type="submit">建立</button></form></div></div></div></div></div><?php include __DIR__ . '/partials/scripts.php';?><script crossorigin=""integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>const titleText=document.querySelector(".title"),latText=document.querySelector(".lat"),lngText=document.querySelector(".lng"),cityText=document.querySelector(".city"),localityText=document.querySelector(".locality"),accuracyText=document.querySelector(".accuracy"),geoBtn=document.querySelector(".geo_btn"),geoLocation=()=>new Promise((e,t)=>{const o={enableHighAccuracy:!0,timeout:1/0,maximumAge:0};navigator.geolocation.getCurrentPosition(e,()=>t(new Error("☜(ﾟヮﾟ☜) 請允許瀏覽器讀取您的位置資料 QQ")),o)}),geoReverse=async(e,t)=>{const o=await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${e}&longitude=${t}&localityLanguage=zh`);if(!o.ok)throw new Error("Problem with geoReverse");return await o.json()},map=L.map("map").setView([25.03382,121.5434],17);L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",{attribution:'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);const initMarker=L.marker([25.03382,121.5434]).addTo(map).bindPopup("我們的公司在這裡歐👍").openPopup();let userPick,curCircle,curMarker,userLat,userLng;window.addEventListener("click",()=>initMarker.remove()),map.on("click",async e=>{const{lat:t,lng:o}=e.latlng,r=await geoReverse(t,o);let{city:n}=r,{locality:a}=r;"桃園縣"===n&&(n="桃園市",a=a.slice(0,-1)+"區"),titleText.innerText="您選擇的位置:",latText.innerText=t.toFixed(6),lngText.innerText=o.toFixed(6),accuracyText.innerText="零誤差❤",cityText.innerText=n,localityText.innerText=a;let i="";if(userLat&&userLng){i=`<br>距離您 ${map.distance([t,o],[userLat,userLng]).toFixed(0)} (米)`}map.flyTo([t,o],17),userPick?.remove(),userPick=L.marker([t,o]).addTo(map).bindPopup(L.popup({maxWidth:250,minWidth:100,autoClose:!1,closeOnClick:!1,className:"map_icon"})).setPopupContent(`<strong>選擇的地點位於:<br>${n}${a}${i}</strong>`).openPopup()});const fetchLocationInfo=async()=>{try{userPick?.remove(),titleText.innerText="計算中";const e=await new Promise((e,t)=>{const o={enableHighAccuracy:!0,timeout:1/0,maximumAge:0};navigator.geolocation.getCurrentPosition(e,()=>t(new Error("☜(ﾟヮﾟ☜) 請允許瀏覽器讀取您的位置資料 QQ")),o)}),{latitude:t}=e.coords,{longitude:o}=e.coords,{accuracy:r}=e.coords;userLat=t,userLng=o;const n=await geoReverse(t,o);let{city:a}=n,{locality:i}=n;"桃園縣"===a&&(a="桃園市",i=i.slice(0,-1)+"區"),latText.innerText=t.toFixed(6),lngText.innerText=o.toFixed(6),accuracyText.innerText=r.toFixed(1)+" (米)",cityText.innerText=a,localityText.innerText=i,titleText.innerText="您的位置是在:",geoBtn.innerText="點擊再次尋找 🚴‍♂️",geoBtn.classList.add("geo_btn_shine"),curMarker?.remove(),curCircle?.remove(),curMarker=L.marker([t,o]).addTo(map).bindPopup("您的當前位置").openPopup(),curCircle=L.circle([t,o],{color:"red",fillColor:"#f03",fillOpacity:.1,radius:1500}).addTo(map),map.flyTo([t,o],14)}catch(e){alert(e.message)}};geoBtn.addEventListener("click",fetchLocationInfo);const geoForm=document.querySelector("#geoForm");geoForm.addEventListener("submit",e=>{e.preventDefault();let t=!0;const o=document.querySelector("#activity_type"),r=document.querySelector("#activity_detail"),n=document.querySelector(".typeWarn"),a=document.querySelector(".detailWarn"),i=(e,t)=>{if(t)return e.classList.remove("invisible");e.classList.add("invisible")};if("待確認"==latText.textContent)return alert("請先於地圖上選擇發起活動的位置 ಥ_ಥ ");if(i(n,!1),i(a,!1),["跑步","爬山","游泳","健身","其他"].includes(o.value)||(i(n,!0),t=!1),(r.value.length<15||r.value.length>255)&&(i(a,!0),t=!1),!t)return;const c=new FormData(geoForm);c.append("lat",latText.textContent),c.append("lng",lngText.textContent),c.append("city",cityText.textContent),c.append("locality",localityText.textContent),fetch("./004-joey-create-api.php",{method:"POST",body:c}).then(e=>e.json()).then(e=>{if(!e.success)return alert(e.error);confirm("建立成功!😎\n請問是否要新增下一筆?\n點擊取消將返回組隊頁面")||(location.href="./004-joey.php"),o.value="",r.value=""})});</script><?php include __DIR__ . '/partials/html-foot.php';?>