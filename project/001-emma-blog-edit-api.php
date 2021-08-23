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
    'error' => '資料欄位不足',
    'code' => 0,
    'rowCount' => 0,
    'postData' => $_POST,
];

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


// 練習題解答：避免直接拜訪時的錯誤訊息
if(
    empty($_POST['id']) or
    empty($_POST['author']) or
    empty($_POST['nick_name']) or
    empty($_POST['title']) or
    empty($_POST['content']) 
    
){
    echo json_encode($output);
    exit;
}


$sql = "UPDATE `Blog` SET 
                          `author`=?,
                          `nick_name`=?,
                          `prvw_img_name`=?,
                          `title`=?,
                          `content`=?,
                          `last_modified`= NOW(),
                          `category`=?
                          WHERE `id`=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['author'],
    $_POST['nick_name'],
    $filename,
    $_POST['title'],
    $_POST['content'],
    $_POST['category'],
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
