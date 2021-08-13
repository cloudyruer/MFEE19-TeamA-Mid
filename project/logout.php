<?php
session_start();

// session_destroy(); // 清除所有的 session
unset($_SESSION['user']); // 移除某個 session 變數

header('Location: index_.php');
