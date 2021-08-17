<?php
include __DIR__. '/partials/init.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'rowCount' => 0,
    'postData' => $_POST,
];
//避免直接拜訪時的錯誤訊息
// 資料格式檢查
if(isset($_POST['account'])){
    $output['error'] = '帳號已經用了！';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit; // 直接離開 (中斷) 程式
}

if(mb_strlen($_POST['account'])<2){
    $output['error'] = '姓名長度太短';
    $output['code'] = 410;
    echo json_encode($output);
    exit;
}

if(! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $output['error'] = 'email 格式錯誤';
    $output['code'] = 420;
    echo json_encode($output);
    exit;
}


// 檢查 email 格式
//var_dump(filter_var('bob@example.com', FILTER_VALIDATE_EMAIL));
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO `members`(
               `account`, `password`, `email`, `mobile`,
               `address`,`birthday`,`nickname`, `create_at`
               ) VALUES (
                    ?, ?, ?,
                    ?, ?, ?, ?, NOW()
               )";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['account'],
    $password,
    $_POST['email'],
    // $_POST['avatar'],
    $_POST['mobile'],
    $_POST['address'],
    $_POST['birthday'],
    $_POST['nickname'],
]);

$output['rowCount'] = $stmt->rowCount(); // 新增的筆數
if($stmt->rowCount()==1){
    $output['success'] = true;
}

echo json_encode($output);
