<?php
include __DIR__ . '/partials/init.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '資料欄位不足',
    'code' => 0,
    'rowCount' => 0,
    'postData' => $_POST,
    'location' => "data-list.php",
];

// 如果不存在會為空值(e.g. 從其他網站複製url) 則使用上面的預設值 'location' => "data-list.php"
if (!empty($_POST['location'])) {
    $output['location'] = $_POST['location'];
}

// 避免直接拜訪 或 修改JS的調皮
if (
    empty($_POST['id']) or
    empty($_POST['activity_type']) or
    empty($_POST['activity_detail'])
) {
    echo json_encode($output);
    exit;
}

// 資料格式檢查
if (mb_strlen($_POST['activity_detail']) < 15 ||
    mb_strlen($_POST['activity_detail']) > 255
) {
    $output['error'] = '內容長度錯誤';
    $output['code'] = 410;
    echo json_encode($output);
    exit;
}

$sql = "UPDATE `geo_info` SET
                          `activity_type`=?,
                          `activity_detail`=?
                          WHERE `id`=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['activity_type'],
    $_POST['activity_detail'],
    $_POST['id'],
]);

$output['rowCount'] = $stmt->rowCount(); // 修改的筆數
if ($stmt->rowCount() == 1) {
    $output['success'] = true;
    $output['error'] = '';
} else {
    $output['error'] = '資料沒有修改';
}

echo json_encode($output);
