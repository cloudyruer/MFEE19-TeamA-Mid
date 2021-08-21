<?php
include __DIR__ . "/partials/init.php";

header("Content-Type: application/json"); //搭配postman

// $pKeys = array_keys($_SESSION['cart']);

// $rows = []; // 預設值
// $data_ar = []; // dict

// 有登入才能結帳
if(! isset($_SESSION['user'])){
    header('Location: 019-henry-product-list.php');
    exit;
}


// if(!empty($pKeys)) {
//     $sql = sprintf("SELECT * FROM products WHERE sid IN(%s)", implode(',', $pKeys));
//     $rows = $pdo->query($sql)->fetchAll();
//     $total = 0;
//     foreach($rows as $r){
//         $r['quantity'] = $_SESSION['cart'][$r['sid']];
//         $data_ar[$r['sid']] = $r;
//         $total += $r['quantity'] * $r['price'];
//     }
// } else {
//     header('Location: 019-henry-product-list.php');
//     exit;
// }




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
$sql = "INSERT INTO `order_list`(`user_id`, `total_price`,`order_status`,`user_name`,`user_phone`,`user_email`,`pickup_store`,`pickup_way`,`user_address`,`created_at`
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,NOW())"; 

//prepare的缺點：看不到執行時sql的語法
$stmt = $pdo->prepare($sql);
$stmt->execute([
  $_SESSION['user']['id'],
  $_POST["total_price"],
  $_POST["order_status"],
  $_POST["name"],
  $_POST["mobile"],
  $_POST["email"],
  $_POST["pickup_store"],
  $_POST["pickup_way"],
  $_POST["address"],
]);

$output["rowCount"] = $stmt->rowCount();
if ($stmt->rowCount() == 1) {
  $output["success"] = true;
  //成功新增一筆就是true
}


// $order_sid = $pdo->lastInsertId(); // 最近新增資料的 PK

// $od_sql = "INSERT INTO `order_details`(`order_sid`, `product_sid`, `price`, `quantity`) VALUES (?, ?, ?, ?)";
// $od_stmt = $pdo->prepare($od_sql);

// foreach($_SESSION['cart'] as $p_sid=>$qty){
//     $od_stmt->execute([
//         $order_sid,
//         $p_sid,
//         $data_ar[$p_sid]['price'],
//         $qty,
//     ]);
// }


unset($_SESSION['cart']); // 清除購物車內容

echo json_encode([
  "rowCount" => $stmt->rowCount(), //新增的筆數。如果方法是select，是讀取的筆數
  "postData" => $_POST,
]);

echo json_encode($output);
