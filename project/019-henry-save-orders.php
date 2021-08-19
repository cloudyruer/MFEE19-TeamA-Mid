<?php
require __DIR__ . '/partials/init.php';

$pKeys = array_keys($_SESSION['cart']);

$rows = []; // 預設值
$data_ar = []; // dict

// 有登入才能結帳
if(! isset($_SESSION['user'])){
    header('Location: 019-henry-product-list.php');
    exit;
}

if(!empty($pKeys)) {
    $sql = sprintf("SELECT * FROM product_list WHERE sid IN(%s)", implode(',', $pKeys));
    $rows = $pdo->query($sql)->fetchAll();
    $total = 0;
    foreach($rows as $r){
        $r['quantity'] = $_SESSION['cart'][$r['sid']];
        $data_ar[$r['sid']] = $r;
        $total += $r['quantity'] * $r['product_price'];
    }
} else {
    header('Location: 019-henry-product-list.php');
    exit;
}

$o_sql = "INSERT INTO `order_list`(`user_id`, `grand_total`,`order_status`,`user_name`,`user_phone`,`user_email`,`user_address`,`pickup_way`,`pickup_store`,`delivery_fee`,`discount`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$o_stmt = $pdo->prepare($o_sql);
$o_stmt->execute([
    $_SESSION['user']['id'],
    $total,
]);

$order_sid = $pdo->lastInsertId(); // 最近新增資料的 PK

$od_sql = "INSERT INTO `order_details`(`order_number`, `product_id`, `price`, `quantity`) VALUES (?, ?, ?, ?)";
$od_stmt = $pdo->prepare($od_sql);

foreach($_SESSION['cart'] as $p_sid=>$qty){
    $od_stmt->execute([
        $order_sid,
        $p_sid,
        $data_ar[$p_sid]['price'],
        $qty,
    ]);
}

unset($_SESSION['cart']); // 清除購物車內容

?>
<?php include __DIR__ . '/partials/html-head.php';?>
<?php include __DIR__ . '/partials/navbar.php';?>


<?php include __DIR__ . "/019-henry-scripts.php"; ?>

<?php include __DIR__ . '/partials/html-foot.php'; ?>