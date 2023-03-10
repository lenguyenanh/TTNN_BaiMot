<?php
session_start();
if(!isset($_SESSION['username'])){
    echo"Chưa đăng nhập";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Quản lý tủ sách</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>


<body>
    <div class="menu">
        <h1>Trang quản lý tủ sách</h1>
        <?php if(isset($_SESSION['username'])) {
            ?><p>Xin chào, <?php echo $_SESSION['fullname']; ?></p>
            <?php } ?>
        <ul>
            <li><a href="quanlytheloai.php">Quản lý thể loại sách</a></li>
            <li><a href="quanlysach.php">Quản lý sách</a></li>
            <li><a href="logout.php">Đăng xuất</a></li>
        </ul>
    </div>
</body>

</html>