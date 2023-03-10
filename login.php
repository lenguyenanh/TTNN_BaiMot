<?php
session_start();

$_arrayUser = array(
    array(
        "username" => "nguyenvana1",
        "password" => "amnote123",
        "fullname" => "Nguyễn Văn A 1"
    ),
    array(
        "username" => "nguyenvana2",
        "password" => "amnote123",
        "fullname" => "Nguyễn Văn A 2"
    ),
);

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $bool = false;
    foreach ($_arrayUser as $key) {
        if ($key["username"] == $username && $key['password'] == $password) {
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $key['fullname'];
            $bool = true;
            header('location: index.php');
            exit();
        } else {
            $bool = false;
        }
    }
    if (!$bool) {
        echo "<div class='error'>Tên đăng nhập hoặc mật khẩu không đúng. Vui lòng nhập lại! </div>";
    }
}
?>

<head>
    <title>Đăng nhập</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="login">
        <h1>Đăng nhập</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" placeholder="Tên đăng nhập" value="nguyenvana2">
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" placeholder="Mật khẩu" value="amnote123">
            </div>
            <button type="submit">Đăng nhập</button>
        </form>
    </div>
</body>