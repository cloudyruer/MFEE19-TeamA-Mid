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

//  練習: 避免直接拜訪表單時的錯誤訊息
//  資料格式檢查



$sql = "INSERT INTO `products`
(`name`, `number`, `detail`,`categories_id`, `categories_parents_id`, `brands_id`,`origin`, `price`, `sale`,`launched`,`created_time`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['name'],
    $_POST['number'],
    $_POST['detail'],
    $_POST['categoriesMain'],
    $_POST['categoriesChild'],
    $_POST['brands'],
    $_POST['origin'],
    $_POST['price'],
    $_POST['sale'],
    $_POST['launched'],
]);

$sid = $pdo->lastInsertId();



// $sqlImg = "INSERT INTO `images`
// (`products_sid`, `fileName`) VALUES (?, ?)";

// $stmtImg = $pdo->prepare($sqlImg);
// $stmtImg->execute([
//     $sid,
//     $_POST['fileName'],
// ]);


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
            $sqlImg = "INSERT INTO `images` (`fileName`,`products_sid`) VALUES (?,?)";
            $stmtImg = $pdo->prepare($sqlImg);
            $stmtImg->execute([
                $filename,
                $sid,
            ]);
        }
    }

}



$output['rowCount'] = $stmt->rowCount(); 
// 新增的筆數

if($stmt->rowCount()==1){
    $output['success'] = true;
}
echo json_encode($output);

