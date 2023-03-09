<?php
session_start();

// Xóa session và hủy tất cả các biến session
session_unset();
session_destroy();

// Chuyển hướng người dùng đến trang đăng nhập
header('Location: login.php');
exit();
?>
