<?php
include __DIR__ . '/partials/init.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (!empty($sid)) {
    $sql = "DELETE FROM `stadiumType` WHERE sid=$sid";
    $stmt = $pdo->query($sql);
}

header('Location: 033-leo-stadium-type.php');
