<?php
include __DIR__ . '/partials/init.php';


//先設定回傳的狀態，預設為出錯
$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'rowCount' => 0,
    'postData' => $_POST,
];


//回寫至資料庫的資料格式

$sql = "UPDATE `sportsType` SET 
               `name`=?
               WHERE  `sid`=?";

//用prepare先將資料轉換為資料庫可用格式
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['sports_type_cat'],
    $_POST['sid'],
]);


//回傳給前端的值
$output['rowCount'] = $stmt->rowCount(); // 新增的筆數
if ($stmt->rowCount() == 1) {
    $output['success'] = true;
    $output['error'] = '';
} else {
    $output['error'] = '資料沒有修改';
}

//回傳給前端
echo json_encode($output);
