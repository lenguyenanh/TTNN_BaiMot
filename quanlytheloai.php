<?php
session_start();
if (!isset($_SESSION['arrTheLoai'])) {
    $_SESSION['arrTheLoai'] = array(
        array('id' => 1, 'maTL' => 'TT', 'tenTL' => 'Trinh thám', 'trangThai' => 'hoạt động'),
        array('id' => 2, 'maTL' => 'KH', 'tenTL' => 'Khoa học', 'trangThai' => 'hoạt động'),
        array('id' => 3, 'maTL' => 'VH', 'tenTL' => 'Văn học', 'trangThai' => 'không hoạt động')
    );
}
//Tìm kiếm
if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
    $kq = array();
    foreach ($_SESSION['arrTheLoai'] as $theLoai) {
        if ($theLoai['tenTL'] === $keyword) {
            $kq[] = $theLoai;
        }
    }
    if (count($kq) > 0) {
        echo '<h3>Kết quả tìm kiếm:</h3>';
        echo '<ul>';
        foreach ($kq as $theLoai) {
            echo '<li>';
            echo 'ID: ' . $theLoai['id'] . '<br>';
            echo '<li>';
            echo 'Mã thể loại: ' . $theLoai['maTL'] . '<br>';
            echo '<li>';
            echo 'Tên thể loại: ' . $theLoai['tenTL'] . '<br>';
            echo '<li>';
            echo 'Trạng thái: ' . $theLoai['trangThai'] . '<br>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<span style="background-color: yellow; font-weight: bold;">Không tìm thấy kết quả nào cho từ khóa "' . $keyword . '"</span>';
    }
}

//Thêm thể loại sách mới
if (isset($_POST['add_category'])) {
    $id = $_POST['id'];
    $maTL = $_POST['maTL'];
    $tenTL = $_POST['tenTL'];
    $trangThai = $_POST['trangThai'];
    //$arrTheLoai = $_SESSION['arrTheLoai'];
    $exits = false;
    foreach ($_SESSION['arrTheLoai'] as $theLoai) {
        if($theLoai['maTL'] == $maTL | $theLoai['tenTL'] == $tenTL){
            $exits = true;
        }
    }
    if($exits){
        echo '<div style="background-color: #f2dede;border: 1px solid #ebccd1;padding: 10px;margin-bottom: 10px;">
        Lỗi: Thể loại đã tồn tại, không thể thêm mới!</div>';
    }else{
    $arrTheLoaiMoi = array(
        'id' => $id,
        'maTL' => $maTL,
        'tenTL' => $tenTL,
        'trangThai' => $trangThai
    );
    $_SESSION['arrTheLoai'][] = $arrTheLoaiMoi;
    echo '<div style="background-color: #dff0d8;border: 1px solid #d6e9c6;padding: 10px;margin-bottom: 10px;">
    Thêm thể loại thành công</div>';
}
}

// Xóa thể loại
if (isset($_POST['delete_category'])) {
    $id = $_POST['id'];
    foreach ($_SESSION['arrTheLoai'] as $key => $value) {
        if ($value['id'] == $id) {
            unset($_SESSION['arrTheLoai'][$key]);
            echo '<div style="background-color: #dff0d8;border: 1px solid #d6e9c6;padding: 10px;margin-bottom: 10px;">
            Xóa thể loại thành công</div>';
            break;
        }
    }
}

// Cập nhật thể loại
if (isset($_POST['update_category'])) {
    $id = $_POST['id'];
    $maTL = $_POST['maTL'];
    $tenTL = $_POST['tenTL'];
    $trangThai = $_POST['trangThai'];
    foreach ($_SESSION['arrTheLoai'] as &$theLoai) {
        if ($theLoai['id'] == $id) {
            $theLoai['maTL'] = $maTL;
            $theLoai['tenTL'] = $tenTL;
            $theLoai['trangThai'] = $trangThai;
            echo '<div style="background-color: #dff0d8;border: 1px solid #d6e9c6;padding: 10px;margin-bottom: 10px;">
            Cập nhật thể loại thành công.</div>';
            break;
        }
    }
}

// Hiển thị form cập nhật thể loại
if (isset($_POST['edit_category'])) {
    $id = $_POST['id'];
    $theLoai = null;
    foreach ($_SESSION['arrTheLoai'] as $category) {
        if ($category['id'] == $id) {
            $theLoai = $category;
            break;
        }
    }
    if ($theLoai) {
?>
        <div>
            <h2>Cập nhật thể loại</h2>
            <form method="POST" action="">
                <div>
                    <label for="maTL">Mã thể loại:</label>
                    <input type="text" id="maTL" name="maTL" value="<?= $theLoai['maTL'] ?>">
                </div>
                <div>
                    <label for="tenTL">Tên thể loại:</label>
                    <input type="text" id="tenTL" name="tenTL" value="<?= $theLoai['tenTL'] ?>">
                </div>
                <div>
                    <label for="trangThai">Trạng thái:</label>
                    <select id="trangThai" name="trangThai" style="padding: 8px;font-size: 16px;border-radius: 5px;border: 1px solid #ccc;outline: none;background-color: #f9f9f9;">
                        <option style="font-size: 16px;" value="hoạt động" <?= $theLoai['trangThai'] == 'hoạt động' ? 'selected' : '' ?>>Hoạt động</option>
                        <option style="font-size: 16px;" value="không hoạt động" <?= $theLoai['trangThai'] == 'không hoạt động' ? 'selected' : '' ?>>Không hoạt động</option>
                    </select>
                </div>

                <input type="hidden" name="id" value="<?= $theLoai['id'] ?>">
                <input type="submit" value="Cập nhật" name="update_category">
            </form>
        </div>
<?php
    }
}
?>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="header">
        <h1>Quản lý thể loại sách</h1>
    </div>
    <?php if(isset($_SESSION['username'])) {
            ?><p>Xin chào, <?php echo $_SESSION['fullname']; ?><a style="text-decoration: none;" href="logout.php"> Đăng xuất</a></p>
            <?php } ?>
    <div class="search-form">
        <form action="" method="post">
            <label for="keyword">Tìm kiếm tên thể loại: </label>
            <input type="text" id="keyword" name="keyword">
            <button type="submit">Tìm kiếm</button>
        </form>
    </div>
    <div>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Mã thể loại</th>
                <th>Tên thể loại</th>
                <th>Trạng thái</th>
                <th>Xóa</th>
                <th>Sửa</th>
                <th>Chi tiết sách</th>
            </tr>
            <?php foreach ($_SESSION['arrTheLoai'] as $theLoai) { ?>
                <tr>
                    <td><?= $theLoai['id'] ?></td>
                    <td><?= $theLoai['maTL'] ?></td>
                    <td><?= $theLoai['tenTL'] ?></td>
                    <td><?= $theLoai['trangThai'] ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $theLoai['id'] ?>">
                            <button type="submit" name="delete_category">Xóa</button>
                        </form>
                    </td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $theLoai['id'] ?>">
                            <button type="submit" name="edit_category">Sửa</button>
                        </form>
                    </td>
                    <td>
                    <form method="post" action="chitietsach.php">
                        <input type="hidden" name="ten-the-loai" value="<?= $theLoai['tenTL'] ?>">
                        <button type="submit" name="chi-tiet-sach" >Chi tiết sách</button>
                    </form>
                </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="form-them">
    <h2>Thêm thể loại sách</h2>
        <form method="POST" action="">
            <div><label for="maTL">Mã thể loại:</label>
                <input type="text" id="maTL" name="maTL" required>
            </div>
            <div><label for="tenTL">Tên thể loại</label><input type="text" id="tenTL" name="tenTL" required></div>
            <div><label for="trangThaii">Trạng thái</label>
                <select name="trangThai" id="trangThaii" required>
                    <option value="hoạt động">Hoạt động</option>
                    <option value="không hoạt động">Không hoạt động</option>
                </select>
            </div>
            <input type="hidden" name="id" value="<?= count($_SESSION['arrTheLoai']) + 1 ?>">
            <input style="background-color: #0077be;color: #fff;border: none;border-radius: 5px; cursor: pointer;" 
            type="submit" value="Thêm thể loại" name="add_category">
        </form>
    </div>
</body>