<?php
include __DIR__ . "/partials/init.php";

// header("Content-Type: application/json"); //搭配postman

// $output = [
//   "success" => false,
//   "error" => "",
// ];

$sid = isset($_GET["sid"]) ? intval($_GET["sid"]) : 0;
//empty:測試是否為0或空字串或空陣列，yes→true，非空→false。此法如果是undefined不會提醒，直接判斷true
// if (empty($sid)) {
//   $output["error"] = "沒有sid";
//   echo json_encode($output);
//   exit();
// }

//因為只有一個值，而且intval($_GET["sid"])已轉換為整數，不會有sql injection的問題，所以不需使用prepare
if (!empty($sid)) {
  $sql = "DELETE FROM `order_list` WHERE sid=$sid";
  $stmt = $pdo->query($sql);
}



//$_SERVER['HTTP_REFERER'] 從哪個頁面連結果來
//不一定有資料
//https://youtu.be/9BfP61_wydw?t=3197
if (isset($_SERVER["HTTP_REFERER"])) {
  header("Location: " . $_SERVER["HTTP_REFERER"]);
} else {
  header("Location: 019-henry-product-list.php");
}
