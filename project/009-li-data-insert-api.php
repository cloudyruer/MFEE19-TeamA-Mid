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

$sqlStock = "INSERT INTO `stock`
(`products_id`, `size`, `stock`) VALUES (?, ?, ?)";

$stmtStock = $pdo->prepare($sqlStock);
$stmtStock->execute([
    $sid,
    $_POST['size'],
    $_POST['stock'],
]);

// $sqlImg = "INSERT INTO `images`
// (`products_sid`, `fileName`) VALUES (?, ?)";

// $stmtImg = $pdo->prepare($sqlImg);
// $stmtImg->execute([
//     $sid,
//     $_POST['fileName'],
// ]);


$output['rowCount'] = $stmt->rowCount(); 
// 新增的筆數

if($stmt->rowCount()==1){
    $output['success'] = true;
}
echo json_encode($output);
