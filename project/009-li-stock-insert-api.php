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

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;



$sqlStock = "INSERT INTO `stock`
(`products_id`, `size`, `stock`) VALUES (
    ?, 
    ?, 
    ?)";

$stmtStock = $pdo->prepare($sqlStock);
$stmtStock->execute([
    $_POST['sid'],
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





$output['rowCount'] = $stmtStock->rowCount(); 
// 新增的筆數

if($stmtStock->rowCount()==1){
    $output['success'] = true;
}
echo json_encode($output);

