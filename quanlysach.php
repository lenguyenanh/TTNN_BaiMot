<?php
session_start();

if (!isset($_SESSION['books'])) {
    $_SESSION['books'] = array(
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
    $results = array();
    foreach ($_SESSION['books'] as $key) {
        if ($key['TheLoaiSach'] == $keyword | $key['TenSach'] == $keyword | $key['TenTacGia'] == $keyword) {
            $results[] = $key;
        }
    }
    if (count($results) > 0) {
        echo '<h3>Kết quả tìm kiếm:</h3>';
        echo '<ul>';
        foreach ($results as $key) {
            echo '<li>';
            echo 'ID: ' . $key['TheLoaiSach'] . '<br>';
            echo '<li>';
            echo 'Mã thể loại: ' . $key['TenSach'] . '<br>';
            echo '<li>';
            echo 'Tên thể loại: ' . $key['TenTacGia'] . '<br>';
            echo '<li>';
            echo 'Trạng thái: ' . $key['NgayPhatHanh']->format('d-m-Y') . '<br>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<span style="background-color: yellow; font-weight: bold;">
        Không tìm thấy kết quả '. $keyword . ' phù hợp</span>';
    }
}

//Tìm theo ngày phát hành
if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $start_date = date_create($_POST['start_date']);
    $end_date = date_create($_POST['end_date']);
    $results = array();
    foreach ($_SESSION['books'] as $key) {
        $ngayphathanh = $key['NgayPhatHanh'];
        if ($ngayphathanh >= $start_date && $ngayphathanh <= $end_date) {
            $results[] = $key;
        }
    }
    if (count($results) > 0) {
        echo "<h3> Kết quả tìm kiếm: </h3>";
        echo '<ul>';
        foreach ($results as $key) {
            echo '<li>';
            echo 'Tên thể loại: ' . $key['TheLoaiSach'] . '<br>';
            echo '<li>';
            echo 'Tên sách: ' . $key['TenSach'] . '<br>';
            echo '<li>';
            echo 'Tên tác giả: ' . $key['TenTacGia'] . '<br>';
            echo '<li>';
            echo 'Ngày phát hành: ' . $key['NgayPhatHanh']->format('d-m-Y') . '<br>';
            echo '</li>';
        }
        echo '</ul>';
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

    $books = $_SESSION['books'];
    $new_book = array(
        'id' => $id,
        'TheLoaiSach' => $tentheloai,
        'TenSach' => $tensach,
        'TenTacGia' => $tentacgia,
        'NgayPhatHanh' => $ngayphathanh
    );
    $books[] = $new_book;
    $_SESSION['books'] = $books;
    echo '<div style="background-color: #dff0d8;border: 1px solid #d6e9c6;padding: 10px;margin-bottom: 10px;">
    Thêm sách thành công sách '. $tensach . '</div>';
}

// Xóa sách
if (isset($_POST['delete_book'])) {
    $id = $_POST['id'];
    $books = $_SESSION['books'];
    foreach ($books as $key => $value) {
        if ($value['id'] == $id) {
            unset($books[$key]);
            break;
        }
    }
    $_SESSION['books'] = array_values($books);
    echo '<div style="background-color: #dff0d8;border: 1px solid #d6e9c6;padding: 10px;margin-bottom: 10px;">
    Xóa sách thành công </div>';
}

// Cập nhật sách
if (isset($_POST['update_book'])) {
    $id = $_POST['id'];
    $theloaisach = $_POST['tentheloai'];
    $tensach = $_POST['tensach'];
    $ngayphathanh = date_create($_POST['ngayphathanh']);
    foreach ($_SESSION['books'] as &$book) {
        if ($book['id'] == $id) {
            $book['TheLoaiSach'] = $theloaisach;
            $book['TenSach'] = $tensach;
            $book['NgayPhatHanh'] = $ngayphathanh;
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
    foreach ($_SESSION['books'] as $b) {
        if ($b['id'] == $id) {
            $book = $b;
            break;
        }
    }
    if ($book) {
?>
        <div>
            <h2>Cập nhật thể loại</h2>
            <form method="POST" action="">
                <div>
                    <label>Tên thể loại:</label>
                    <input type="text" id="tentheloai" name="tentheloai" value="<?= $book['TheLoaiSach'] ?>">
                </div>
                <div>
                    <label>Tên sách:</label>
                    <input type="text" id="tensach" name="tensach" value="<?= $book['TenSach'] ?>">
                </div>
                <div>
                    <label>Tên tác giả:</label>
                    <input type="text" id="tentacgia" name="tentacgia" value="<?= $book['TenTacGia'] ?>">
                </div>
                <div>
                    <label>Ngày phát hành:</label>
                    <input type="date" id="ngayphathanh" name="ngayphathanh" value="<?= $book['NgayPhatHanh']->format('Y-m-d') ?>">
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
    <?php if(isset($_SESSION['username'])) {
            ?><p>Xin chào, <?php echo $_SESSION['fullname']; ?><a style="text-decoration: none;" href="logout.php"> Đăng xuất</a></p>
            <?php } ?>
    <div class="search-form">
        <form action="" method="post">
            <label for="keyword">Tìm kiếm tên thể loại: </label>
            <input type="text" id="keyword" name="keyword">
            <button type="submit">Tìm kiếm</button>
        </form>
    
    <form method="post" action="">
        <label for="start_date">Ngày bắt đầu:</label>
        <input type="date" name="start_date" id="start_date" required>
        <br>
        <label for="end_date">Ngày kết thúc:</label>
        <input type="date" name="end_date" id="end_date" required>
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
            <?php foreach ($_SESSION['books'] as $key) { ?>
                <tr>
                    <td><?= $key['TheLoaiSach'] ?></td>
                    <td><?= $key['TenSach'] ?></td>
                    <td><?= $key['TenTacGia'] ?></td>
                    <td><?= $key['NgayPhatHanh']->format('d-m-Y') ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $key['id'] ?>">
                            <button type="submit" name="delete_book">Xóa</button>
                        </form>
                    </td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $key['id'] ?>">
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
            <div><label>Tên thể loại</label>
                <input type="text" name="tentheloai" required>
            </div>
            <div><label>Tên sách</label><input type="text" name="tensach" required></div>
            <div><label>Tên tác giả</label><input type="text" name="tentacgia" required></div>
            <div><label>Ngày phát hành</label>
            <input type="date" name="ngayphathanh" required></div>
            <input type="hidden" name="id" value="<?= count($_SESSION['books']) + 1 ?>">
            <input type="submit" value="Thêm sách" name="add_book">
        </form>
    </div>
</body>