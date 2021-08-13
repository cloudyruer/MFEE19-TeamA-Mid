<?php
// NOTE 不要動
// for debug session check
session_start();

header('Content-Type: application/json');
echo json_encode($_SESSION, JSON_UNESCAPED_UNICODE);
