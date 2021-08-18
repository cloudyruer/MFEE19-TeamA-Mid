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

//  練習: 避免直接拜訪表單時的錯誤訊息
// if(empty($_POST['number']))
// {
//     echo json_encode($output);
//     exit;
// }


$output['error'] = '資料1';

$sql = " UPDATE `products` 
SET 
`name`=?,
`detail`=?,
`categories_id`=?,
`categories_parents_id`=?, 
`brands_id`=?,
`origin`=?, 
`price`=?, 
`sale`=?,
`launched`=?
WHERE `sid`=?";
$output['error'] = '資料2';

// 只要從用戶端!!!外面來要塞進資料庫的資料，一律用prepare
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['name'],
    $_POST['detail'],
    $_POST['categoriesMain'],
    $_POST['categoriesChild'],
    $_POST['brands'],
    $_POST['origin'],
    $_POST['price'],
    $_POST['sale'],
    $_POST['launched'],
    $_POST['sid']
]);

$sid = $pdo->lastInsertId();

$sqlStock = " UPDATE `stock` SET
`size`=?, `stock`=?  
WHERE `products_id`=?";

$stmtStock = $pdo->prepare($sqlStock);
$stmtStock->execute([    
    $_POST['size'],
    $_POST['stock'],
    $_POST['sid'],
]);

// 要存放圖檔的資料夾
$folder = __DIR__. '/imgs/';

// 允許的檔案類型
$imgTypes = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
];

// 預設是沒有上傳資料，沒有上傳成功
$isSaved = false;


// 如果有上傳檔案
if(! empty($_FILES) and !empty($_FILES['images'])){
    $ext = isset($imgTypes[$_FILES['images']['type']])  ? $imgTypes[$_FILES['images']['type']] : null ; // 取得副檔名

    // 如果是允許的檔案類型
    if(! empty($ext)){
        $filename = $_FILES['images']['name']. $ext;

        if(move_uploaded_file(
            $_FILES['images']['tmp_name'],
            $folder. $filename
        )){
            $sql = "UPDATE `images` SET `fileName`=? WHERE `products_sid`=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $filename,
                $_POST['sid'],
            ]);
        }
    }

}




$output['rowCount'] = $stmt->rowCount(); 
// 修改的筆數

if($stmt->rowCount()==1 or $stmtStock->rowCount()== 1 ){
    $output['success'] = true;
    $output['error'] = '';
} else {
    $output['error'] = '資料沒有修改';
}
echo json_encode($output);
