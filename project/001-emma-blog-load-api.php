<?php
include __DIR__. '/partials/init.php';
    
$next_id = isset($_GET['next_id']) ? intval($_GET['next_id']) : 0;

$sql = sprintf("SELECT * FROM Blog WHERE 1 ORDER BY id DESC LIMIT %s, 4", $next_id);

$rows = $pdo->query($sql)->fetchAll();

echo json_encode($rows);