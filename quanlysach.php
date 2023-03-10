<?php
session_start();

if (!isset($_SESSION['arrSach'])) {
    $_SESSION['arrSach'] = array(
        array(
            "id" => 1,
            "TheLoaiSach" => "Trinh thám",
            "TenSach" => "Sherlock Holmes",
            "TenTacGia" => "Arthur Conan Doyle",
            "NgayPhatHanh" => date_create("01-01-1999")
        ),
        array(
            "id" => 2,
            "TheLoaiSach" => "Văn học",
            "TenSach" => "Tuổi Trẻ Đáng Giá Bao Nhiêu?",
            "TenTacGia" => "Rosie Nguyễn",
            "NgayPhatHanh" => date_create("01-02-2016")
        )
    );
}

//Tìm theo thể loại, tên sách, tên tác giả
if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
    $kq = array();
    foreach ($_SESSION['arrSach'] as $b) {
        if ($b['TheLoaiSach'] == $keyword | $b['TenSach'] == $keyword | $b['TenTacGia'] == $keyword) {
            $kq[] = $b;
        }
    }
    if (count($kq) > 0) {
        echo '<h3 style="text-align: center;"> Kết quả tìm kiếm: </h3>';
        echo '<table>';
        echo '<thead>';
        echo '<tr><th>Tên thể loại</th><th>Tên sách</th><th>Tên tác giả</th><th>Ngày phát hành</th></tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($kq as $b) {
            echo '<tr>';
            echo '<td>' . $b['TheLoaiSach'] . '</td>';
            echo '<td>' . $b['TenSach'] . '</td>';
            echo '<td>' . $b['TenTacGia'] . '</td>';
            echo '<td>' . $b['NgayPhatHanh']->format('d-m-Y') . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<span style="background-color: yellow; font-weight: bold;">
        Không tìm thấy kết quả ' . $keyword . ' phù hợp</span>';
    }
}

//Tìm theo ngày phát hành
if (isset($_POST['ngay_bat_dau']) && isset($_POST['ngay_ket_thuc'])) {
    $ngay_bat_dau = date_create($_POST['ngay_bat_dau']);
    $ngay_ket_thuc = date_create($_POST['ngay_ket_thuc']);
    $kq = array();
    foreach ($_SESSION['arrSach'] as $b) {
        $ngay_phat_hanh = $b['NgayPhatHanh'];
        if ($ngay_phat_hanh >= $ngay_bat_dau && $ngay_phat_hanh <= $ngay_ket_thuc) {
            $kq[] = $b;
        }
    }
    if (count($kq) > 0) {
        echo '<h3 style="text-align: center;"> Kết quả tìm kiếm: </h3>';
        echo '<table>';
        echo '<thead><tr><th>Tên thể loại</th><th>Tên sách</th><th>Tên tác giả</th><th>Ngày phát hành</th></tr></thead>';
        echo '<tbody>';
        foreach ($kq as $b) {
            echo '<tr>';
            echo '<td>' . $b['TheLoaiSach'] . '</td>';
            echo '<td>' . $b['TenSach'] . '</td>';
            echo '<td>' . $b['TenTacGia'] . '</td>';
            echo '<td>' . $b['NgayPhatHanh']->format('d-m-Y') . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<span style="background-color: yellow; font-weight: bold;">
        Trong khoảng thời gian này không có sách nào được phát hành.</span>';
    }
}

//Thêm sách mới
if (isset($_POST['add_book'])) {
    $id = $_POST['id'];
    $tentheloai = $_POST['tentheloai'];
    $tensach = $_POST['tensach'];
    $tentacgia = $_POST['tentacgia'];
    $ngayphathanh = date_create($_POST['ngayphathanh']);
    $books = $_SESSION['arrSach'];

    $book_exist = false;
    foreach ($books as $b) {
        if ($b['TenSach'] === $tensach) {
            $book_exist = true;
            break;
        }
    }
    if ($book_exist) {
        echo '<div style="background-color: #f2dede;border: 1px solid #ebccd1;padding: 10px;margin-bottom: 10px;">
        Lỗi: Sách ' . $tensach . ' đã tồn tại trong danh sách!</div>';
    } else {
        $new_book = array(
            'id' => $id,
            'TheLoaiSach' => $tentheloai,
            'TenSach' => $tensach,
            'TenTacGia' => $tentacgia,
            'NgayPhatHanh' => $ngayphathanh
        );
        $books[] = $new_book;
        $_SESSION['arrSach'] = $books;
        echo '<div style="background-color: #dff0d8;border: 1px solid #d6e9c6;padding: 10px;margin-bottom: 10px;">
    Thêm sách thành công sách ' . $tensach . '</div>';
    }
}

// Xóa sách
if (isset($_POST['delete_book'])) {
    $id = $_POST['id'];
    $books = $_SESSION['arrSach'];
    foreach ($books as $key => $value) {
        if ($value['id'] == $id) {
            unset($books[$key]);
            break;
        }
    }
    $_SESSION['arrSach'] = array_values($books);
    echo '<div style="background-color: #dff0d8;border: 1px solid #d6e9c6;padding: 10px;margin-bottom: 10px;">
    Xóa sách thành công </div>';
}

// Cập nhật sách
if (isset($_POST['update_book'])) {
    $id = $_POST['id'];
    $theloaisach = $_POST['tentheloai'];
    $tensach = $_POST['tensach'];
    $ngayphathanh = date_create($_POST['ngayphathanh']);
    foreach ($_SESSION['arrSach'] as &$b) {
        if ($b['id'] == $id) {
            $b['TheLoaiSach'] = $theloaisach;
            $b['TenSach'] = $tensach;
            $b['NgayPhatHanh'] = $ngayphathanh;
            echo '<div style="background-color: #dff0d8;border: 1px solid #d6e9c6;padding: 10px;margin-bottom: 10px;">
            Cập nhật thể loại thành công</div>';
            break;
        }
    }
}

// Hiển thị form cập nhật thể loại
if (isset($_POST['edit_book'])) {
    $id = $_POST['id'];
    $book = null;
    foreach ($_SESSION['arrSach'] as $b) {
        if ($b['id'] == $id) {
            $book = $b;
            break;
        }
    }
    if ($book) {
?>
        <div style="text-align: center;">
            <h2>Cập nhật thể loại</h2>
            <form method="POST" action="">
                <div>
                    <label for="tentheloai">Tên thể loại:</label>
                    <input type="text" id="tentheloai" name="tentheloai" value="<?= $book['TheLoaiSach'] ?>">
                </div>
                <div>
                    <label for="tensach">Tên sách:</label>
                    <input type="text" id="tensach" name="tensach" value="<?= $book['TenSach'] ?>">
                </div>
                <div>
                    <label for="tentacgia">Tên tác giả:</label>
                    <input type="text" id="tentacgia" name="tentacgia" value="<?= $book['TenTacGia'] ?>">
                </div>
                <div>
                    <label for="ngayphathanh">Ngày phát hành:</label>
                    <input type="date" id="ngayphathanh" name="ngayphathanh" value="<?= date_format($book['NgayPhatHanh'], 'Y-m-d') ?>">
                </div>
                <input type="hidden" name="id" value="<?= $book['id'] ?>">
                <input type="submit" value="Cập nhật" name="update_book">
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
        <h1>Quản lý sách</h1>
    </div>
    <?php if (isset($_SESSION['username'])) {
    ?><p>Xin chào, <?php echo $_SESSION['fullname']; ?><a style="text-decoration: none;" href="logout.php"> Đăng xuất</a></p>
    <?php } ?>
    <div class="search-form">
        <form action="" method="post">
            <label for="keyword">Tìm kiếm tên thể loại: </label>
            <input type="text" id="keyword" name="keyword">
            <button type="submit">Tìm kiếm</button>
        </form>

        <form method="post" action="">
            <label for="ngay_bat_dau">Ngày bắt đầu:</label>
            <input type="date" name="ngay_bat_dau" id="ngay_bat_dau" required>
            <br>
            <label for="ngay_ket_thuc">Ngày kết thúc:</label>
            <input type="date" name="ngay_ket_thuc" id="ngay_ket_thuc" required>
            <br>
            <button type="submit">Tìm kiếm theo ngày</button>
        </form>
    </div>

    <div>
        <table border="1">
            <tr>
                <th>Thể loại sách</th>
                <th>Tên sách</th>
                <th>Tác giả</th>
                <th>Ngày phát hành</th>
                <th>Xóa</th>
                <th>Sửa</th>
            </tr>
            <?php foreach ($_SESSION['arrSach'] as $b) { ?>
                <tr>
                    <td><?= $b['TheLoaiSach'] ?></td>
                    <td><?= $b['TenSach'] ?></td>
                    <td><?= $b['TenTacGia'] ?></td>
                    <td><?= $b['NgayPhatHanh']->format('d-m-Y') ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $b['id'] ?>">
                            <button type="submit" name="delete_book">Xóa</button>
                        </form>
                    </td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $b['id'] ?>">
                            <button type="submit" name="edit_book">Sửa</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div class="form-them">
        <h2>Thêm sách</h2>
        <form method="POST" action="quanlysach.php">
            <div><label for="tentheloai">Tên thể loại</label>
                <input type="text" id="tentheloai" name="tentheloai" required>
            </div>
            <div><label for="tensach">Tên sách</label><input type="text" id="tensach" name="tensach" required></div>
            <div><label>Tên tác giả</label><input type="text" id="tentacgia" name="tentacgia" required></div>
            <div><label>Ngày phát hành</label>
                <input type="date" name="ngayphathanh" required>
            </div>
            <input type="hidden" name="id" value="<?= count($_SESSION['arrSach']) + 1 ?>">
            <input style="background-color: #0077be;color: #fff;border: none;border-radius: 5px; cursor: pointer;"
            type="submit" value="Thêm sách" name="add_book">
        </form>
    </div>
</body>