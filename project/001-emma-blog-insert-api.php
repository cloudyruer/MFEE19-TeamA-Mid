<?php
include __DIR__. '/partials/init.php';

header('Content-Type: application/json');

$folder = __DIR__. '/imgs/';
// 允許的檔案類型
$imgTypes = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
];

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'rowCount' => 0,
    'postData' => $_POST,
];


if(mb_strlen($_POST['author'])<2){
    $output['error'] = '姓名長度太短';
    $output['code'] = 410;
    echo json_encode($output);
    exit;
}
if(mb_strlen($_POST['title'])<1){
    $output['error'] = '無標題';
    $output['code'] = 420;
    echo json_encode($output);
    exit;
}
if(mb_strlen($_POST['content'])<1){
    $output['error'] = '無內文';
    $output['code'] = 430;
    echo json_encode($output);
    exit;
}

$filename = "";

if(! empty($_FILES) and !empty($_FILES['images'])){

    $ext = isset($imgTypes[$_FILES['images']['type']])  ? $imgTypes[$_FILES['images']['type']] : null ; // 取得副檔名

    // 如果是允許的檔案類型
    if(!empty($ext)){
        $filename2 = $_FILES['images']['name'];

        if(move_uploaded_file(
            $_FILES['images']['tmp_name'],
            $folder. $filename2
        )){
            $filename = $filename2;
        }
    }

}

$sql = "INSERT INTO `Blog`(
               `author`, `nick_name`, `prvw_img_name`, `title`,
               `content`, `category` ,`created_at`,`last_modified`,`view_count`
               ) VALUES (
                    ?, ?, ?, ?, 
                    ?, ?, NOW(), NOW(), 0
               )";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['author'],
    $_POST['nick_name'],
    $filename,
    $_POST['title'],
    $_POST['content'],
    $_POST['category']
]);

$output['rowCount'] = $stmt->rowCount(); // 新增的筆數
if($stmt->rowCount()==1){
    $output['success'] = true;
}

echo json_encode($output);
