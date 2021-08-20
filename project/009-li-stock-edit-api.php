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

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;


$sqlStock = " UPDATE `stock` SET
`size`=?, `stock`=?  
WHERE `stock`.`id`=?";

$stmtStock = $pdo->prepare($sqlStock);
$stmtStock->execute([    
    $_POST['size'],
    $_POST['stock'],
    $_POST['id'],
]);



$output['rowCount'] = $stmtStock->rowCount(); 
// 修改的筆數

if($stmtStock->rowCount() == 1 ){
    $output['success'] = true;
    $output['error'] = '';
} else {
    $output['error'] = '資料沒有修改';
}
echo json_encode($output);
