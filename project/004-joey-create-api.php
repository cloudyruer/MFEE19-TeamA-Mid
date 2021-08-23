<?php
include __DIR__ . '/partials/init.php';

header('Content-Type: application/json');

//  output for return
$output = [
    'success' => false,
    'error' => '',
    'code' => 0, //error code
    'rowCount' => 0,
    'postData' => $_POST,
];

// finish verifying & exit
$finishVerify = function ($output) {
    // JSON_UNESCAPED_UNICODE in case Mandarin
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
};

// 防直接連結的壞孩子 💢  基本上只有直連才會出問題 因為從網站來的 就算硬改js POST值也會是空字串""
if (!isset($_POST['lat']) ||
    !isset($_POST['lng']) ||
    !isset($_POST['city']) ||
    !isset($_POST['locality']) ||
    !isset($_POST['activity_detail']) ||
    !isset($_POST['activity_type'])) {
    $output['error'] = 'Oops 💤 Info Missing 請不要恣意直接連結啊💢💢 ';
    $output['code'] = 400;
    $finishVerify($output);
}

// data from front-end
$lat = $_POST['lat'];
$lng = $_POST['lng'];
$city = $_POST['city'];
$locality = $_POST['locality'];
$activity_detail = $_POST['activity_detail'];
$activity_type = $_POST['activity_type'];

// 防空字串輸入: 修改前端JS的壞孩子
// WARN FIX 因 前端geoReverse --> 根治方法 換一個 geo reverse api
// 在特定區域可能抓不到所在地名稱 後續考慮驗證 $city & $locality 的必要性 (或許考慮允許空字串)
if (empty($lat) ||
    empty($lng) ||
    empty($city) ||
    empty($locality) ||
    empty($activity_detail) ||
    empty($activity_type)) {
    // WARN FIX 應急用 說明可能出錯的原因
    $output['error'] = '    Oops 💤 Info Missing 請不要恣意更改JS啊💢💢
    但如果您沒有更改JS的話
    當前錯誤的可能原因: (缺少以下的必要欄位)
    當前的geo reverse api無法取得城市或區域值
    ------解決方法------
    只能等我換一個geo reverse api😎 求斗內❤❤❤❤❤
    另外集資亦可更換專業地形圖歐(誤)
    or
    更改資料報表的必要欄位設定(暫不考慮)
    (目前以日後更換api為主要考量)';
    $output['code'] = 402;
    $finishVerify($output);
}

// $sql = "INSERT INTO `geo_info` (`members_id`, `lat`, `lng`, `city`, `locality`, `activity_type`, `activity_detail`, `start_time`)
// VALUES ('1', '25', '121', '台北市', '大安區', '爬山', '一起看去爬山歐歐歐歐一起看去爬山歐歐歐歐一起看去爬山歐歐歐歐一起看去爬山歐歐歐歐', NULL);";

// $stmt = $pdo->query($sql);

// TODO: WARN `start_time` 小專先傳空值 大專記得處理
$sql = "INSERT INTO `geo_info` (
    `members_id`, `lat`, `lng`, `city`, `locality`,
    `activity_type`, `activity_detail`, `start_time`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_SESSION['user']['id'],
    $lat,
    $lng,
    $city,
    $locality,
    $activity_type,
    $activity_detail,
    // 這個是 start_time TODO: 大專記得加
    null,
]);

// NOTE PDOStatement::rowCount — Returns the number of rows affected by the "last" SQL statement
$output['rowCount'] = $stmt->rowCount(); //新增的筆數 select的話就是讀取的筆數

// 如果成功則更改數值
if ($stmt->rowCount() == 1) {
    $output['success'] = true;
    $output['code'] = 200;
}

// 結束
$finishVerify($output);
