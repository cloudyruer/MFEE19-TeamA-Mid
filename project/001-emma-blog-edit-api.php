<?php
include __DIR__. '/partials/init.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '資料欄位不足',
    'code' => 0,
    'rowCount' => 0,
    'postData' => $_POST,
];

// 練習題解答：避免直接拜訪時的錯誤訊息
if(
    empty($_POST['id']) or
    empty($_POST['author']) or
    empty($_POST['title']) or
    empty($_POST['content']) 
    
){
    echo json_encode($output);
    exit;
}


$sql = "UPDATE `Blog` SET 
                          `author`=?,
                          `nick_name`=?,
                          `title`=?,
                          `content`=?,
                          `last_modified`= NOW()
                          WHERE `id`=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['author'],
    $_POST['nick_name'],
    $_POST['title'],
    $_POST['content'],
    $_POST['id']
]);

$output['rowCount'] = $stmt->rowCount(); // 修改的筆數
if($stmt->rowCount()==1){
    $output['success'] = true;
    $output['error'] = '';
} else {
    $output['error'] = '資料沒有修改';
}

echo json_encode($output);
