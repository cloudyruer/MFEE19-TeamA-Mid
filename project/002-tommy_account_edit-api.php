<?php
include __DIR__ . '/partials/init.php';

header('Content-Type: application/json');

$folder = __DIR__ . '/imgs/';

// 允許的檔案類型
$imgTypes = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
];

$output = [
    'success' => false,
    'error' => '資料欄位不足',
    'code' => 0,
    'rowCount' => 0,
    'postData' => $_POST,
];

// 練習題解答：避免直接拜訪時的錯誤訊息
// if (
//     empty($_POST['id']) or
//     empty($_POST['account']) or
//     empty($_POST['password']) or
//     empty($_POST['email']) or
//     empty($_POST['avatar']) or
//     empty($_POST['mobile']) or
//     empty($_POST['address']) or
//     empty($_POST['birthday']) or
//     empty($_POST['nickname'])
// ) {
//     echo json_encode($output);
//     exit;
// }


//資料格式檢查
if (mb_strlen($_POST['account']) < 2) {
    $output['error'] = '姓名長度太短';
    $output['code'] = 410;
    echo json_encode($output);
    exit;
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $output['error'] = 'email 格式錯誤';
    $output['code'] = 420;
    echo json_encode($output);
    exit;
}

if (empty($_POST['nickname'])) {
    echo json_encode($output);
    exit;
}


$sql = "UPDATE `members` SET 
    `account`=?, `password`=?, `email`=?,
    `mobile`=?, `address`=?, `birthday`=?, `nickname`=?

    WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['account'],
        $_POST['password'],
        $_POST['email'],
        $_POST['mobile'],
        $_POST['address'],
        $_POST['birthday'],
        $_POST['nickname'],
        $_POST['id'],
    ]);
$output['rowCount'] = $stmt->rowCount(); // 修改的筆數
if($stmt->rowCount()==1){
    $output['success'] = true;
    $output['error'] = '';
} else {
    $output['error'] = '資料沒有修改';
}

echo json_encode($output);
