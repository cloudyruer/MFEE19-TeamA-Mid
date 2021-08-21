<?php
include __DIR__ . "/partials/init.php";



$sid = isset($_GET["sid"]) ? intval($_GET["sid"]) : 0;

if (!empty($sid)) {
  $sql = "DELETE FROM `product_list` WHERE sid=$sid";
  $stmt = $pdo->query($sql);
}


//https://youtu.be/9BfP61_wydw?t=3197
if (isset($_SERVER["HTTP_REFERER"])) {
  header("Location: " . $_SERVER["HTTP_REFERER"]);
} else {
  header("Location: 019-henry-product-list.php");
}
