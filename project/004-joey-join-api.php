<?php
include __DIR__ . '/partials/init.php';

header('Content-Type: application/json');

//  output for return
$output = [
    'success' => false,
    'error' => '',
    'code' => 0, //error code
    'postData' => $_POST,
    'rowCount' => 0,
    'result' => '',
];

// finish verifying & exit
$finishVerify = function ($output) {
    // JSON_UNESCAPED_UNICODE in case Mandarin (ps NO need for lat lng) 但保持一致姓
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
};

// 防直接連結的壞孩子 💢  基本上只有直連才會出問題 因為從網站來的 就算硬改js POST值也會是空字串""
if (!isset($_POST['lat']) || !isset($_POST['lng'])) {
    $output['error'] = 'Oops 💤 Info Missing 請不要恣意直接連結啊💢💢 ';
    $output['code'] = 400;
    $finishVerify($output);
}

// data from front-end
$lat = $_POST['lat'];
$lng = $_POST['lng'];

// 防空字串輸入: 修改前端JS的壞孩子
if (empty($lat) || empty($lng)) {
    $output['error'] = 'Oops 💤 Info Missing 請不要恣意更改JS啊💢💢';
    $output['code'] = 402;
    $finishVerify($output);
}

// select ST_Distance_Sphere(longs, lats)
$sql = "SELECT account,
nickname,
geo_info.*,
ROUND(ST_Distance_Sphere(point(?, ?), point(lng, lat))) AS distance
FROM `geo_info`
JOIN members ON members.id = members_id
WHERE valid = ?
HAVING distance < ?
ORDER BY distance;";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $lng,
    $lat,
    1, //有效值 1為有效  0為無效
    1500, //距離
]);

$result = $stmt->fetchAll();

// NOTE PDOStatement::rowCount — Returns the number of rows affected by the "last" SQL statement
$output['rowCount'] = $stmt->rowCount(); //新增的筆數 select的話就是讀取的筆數

// 如果沒有相關結果(0筆) 或錯誤
if (!$stmt->rowCount()) {
    $output['error'] = 'Oops 💤 很可惜 該位置半徑1.5公里內並沒有活動呢🤔';
    $output['code'] = 403;
    $finishVerify($output);
}

// 如果成功
$output['success'] = true;
$output['code'] = 200;
$output['result'] = $result;

// 結束
$finishVerify($output);
