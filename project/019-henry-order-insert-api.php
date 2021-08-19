<?php
include __DIR__ . "/partials/init.php";


header("Content-Type: application/json"); //搭配postman

$output = [
  "success" => false,
  "error" => "",
  "code" => 0,
  "rowCount" => 0,
  "postDate" => $_POST,
];

if (!isset($_POST["name"]) or !isset($_POST["email"])) {
  $output["error"] = "沒有帳號資料或email";
  $output["code"] = "400";
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit();
}

//資料格式檢查
if (mb_strlen($_POST["name"]) < 2) {
  $output["error"] = "姓名長度太短";
  $output["code"] = 410;
  echo json_encode($output);
  exit();
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
  $output["error"] = "email 格式不對";
  $output["code"] = 420;
  echo json_encode($output);
  exit();
}

if(!preg_match("/^09\d{2}-?\d{3}-?\d{3}$/", $_POST["mobile"])){
  $output["error"] = "手機格式不對";
  $output["code"] = 430;
  echo json_encode($output);
  exit();
}



//正確做法
$sql = "INSERT INTO `order_list`(`user_id`, 
        `user_name`, `user_email`, `user_phone`, `user_address`, `pickup_way`, `created_at`
        ) VALUES (
          ?, ?, ?, ?, ?, ?, NOW()
        )"; //將外來的資料都視為不安全的資料，用?配合prepare方式較安全

//prepare的缺點：看不到執行時sql的語法
$stmt = $pdo->prepare($sql);
$stmt->execute([
  $_SESSION['user']['id'],
  $_POST["name"],
  $_POST["email"],
  $_POST["mobile"],
  $_POST["address"],
  $_POST["pickup_way"],
]);

$output["rowCount"] = $stmt->rowCount();
if ($stmt->rowCount() == 1) {
  $output["success"] = true;
  //成功新增一筆就是true
}

// echo json_encode([
//   "rowCount" => $stmt->rowCount(), //新增的筆數。如果方法是select，是讀取的筆數
//   "postData" => $_POST,
// ]);

echo json_encode($output);
