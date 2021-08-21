<?php
include __DIR__. '/partials/init.php';

header('Content-Type: application/json');

// 要存放圖檔的資料夾
$folder = __DIR__. '/imgs/';

// 允許的檔案類型
$imgTypes = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
];

$output = [
    'success' => false,
    'error' => '檢查是否有欄位沒填寫',
    'code' => 0,
    'postData' => $_POST,
];

//避免看到notice
if (empty($_POST["product_id"])) {
  $output["error"] = "請輸入商品序";
  $output["code"] = 400;
  echo json_encode($output);
  exit();
}

if (empty($_POST["product_name"])) {
  $output["error"] = "請輸入品名";
  $output["code"] = 410;
  echo json_encode($output);
  exit();
}

if (empty($_POST["product_brand"])) {
  $output["error"] = "請輸入品牌";
  $output["code"] = 420;
  echo json_encode($output);
  exit();
}

if (empty($_POST["product_price"])) {
  $output["error"] = "請輸入價格";
  $output["code"] = 430;
  echo json_encode($output);
  exit();
}

if (empty($_POST["stock"])) {
  $output["error"] = "請輸入庫存";
  $output["code"] = 440;
  echo json_encode($output);
  exit();
}

// 預設是沒有上傳資料，沒有上傳成功
//設定兩條路：1.大頭貼、暱稱都修改 2.只選一個修改


$isSaved = false;
// 如果有上傳大頭貼且有欄位名稱
if(! empty($_FILES) and !empty($_FILES['product_img'])){
    $ext = isset($imgTypes[$_FILES['product_img']['type']]) ? $imgTypes[$_FILES['product_img']['type']] : null ; // 取得副檔名
    $output['code'] = 1;
    // 如果是允許的檔案類型
    if(! empty($ext)){
        $output['code'] = 2;
        $filename = $_FILES['product_img']['name'];
        //移動成功,true
        if(move_uploaded_file(
            $_FILES['product_img']['tmp_name'],
            $folder. $filename,
            
        )){
            $output['code'] = 3;
            $sql = "UPDATE `product_list` SET `product_img`=? WHERE `product_list`.`sid` = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $filename,
                $_POST['sid']
            ]);
            //true代表新增成功
            if($stmt->rowCount()) {
                $isSaved = true;
                $output['filename'] = $filename;
                $output['code'] = 200;
                $output['error'] = '';
                $output['success'] = true;
                echo json_encode($output);
                exit();
            }
        }
    }

}
//只改暱稱



echo json_encode($output);





