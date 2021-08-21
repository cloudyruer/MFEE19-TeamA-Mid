<?php
include __DIR__ . "/partials/init.php";

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$output = [
  "success" => false,
  "error" => "沒有給sid",
  "sid" => $sid, 
];

//empty:測試是否為0或空字串或空陣列，yes→true，非空→false。此法如果是undefined不會提醒，直接判斷true
if (!empty($sid)) {
  $sql = "DELETE FROM `product_list` WHERE sid=$sid";
  $stmt = $pdo->query($sql);

  if ($stmt->rowCount() == 1) {
    $output["success"] = true;
    $output["error"] = "";
  } else {
    //https://youtu.be/chjXX1vfcEI?t=1638
    //刪除不存在的sid的資料會出現這行
    $output["error"] = "退訂失敗(可能沒有該筆訂單)";
  }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
