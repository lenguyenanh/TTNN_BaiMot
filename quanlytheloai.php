<?php
session_start();
if (!isset($_SESSION['categories'])) {
    $_SESSION['categories'] = array(
        array('id' => 1, 'code' => 'TT', 'name' => 'Trinh thám', 'status' => 'hoạt động'),
        array('id' => 2, 'code' => 'KH', 'name' => 'Khoa học', 'status' => 'hoạt động'),
        array('id' => 3, 'code' => 'VH', 'name' => 'Văn học', 'status' => 'không hoạt động')
    );
}
//Tìm kiếm
if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
    $results = array();
    foreach ($_SESSION['categories'] as $category) {
        if ($category['name'] === $keyword) {
            $results[] = $category;
        }
    }
    if (count($results) > 0) {
        echo '<h3>Kết quả tìm kiếm:</h3>';
        echo '<ul>';
        foreach ($results as $category) {
            echo '<li>';
            echo 'ID: ' . $category['id'] . '<br>';
            echo '<li>';
            echo 'Mã thể loại: ' . $category['code'] . '<br>';
            echo '<li>';
            echo 'Tên thể loại: ' . $category['name'] . '<br>';
            echo '<li>';
            echo 'Trạng thái: ' . $category['status'] . '<br>';
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
    $code = $_POST['code'];
    $name = $_POST['name'];
    $status = $_POST['status'];
    $categories = $_SESSION['categories'];
    $new_category = array(
        'id' => $id,
        'code' => $code,
        'name' => $name,
        'status' => $status
    );
    $categories[] = $new_category;
    $_SESSION['categories'] = $categories;
    echo '<div style="background-color: #dff0d8;border: 1px solid #d6e9c6;padding: 10px;margin-bottom: 10px;">
    Thêm thể loại thành công</div>';
}

// Xóa thể loại
if (isset($_POST['delete_category'])) {
    $id = $_POST['id'];
    foreach ($_SESSION['categories'] as $key => $value) {
        if ($value['id'] == $id) {
            unset($_SESSION['categories'][$key]);
            echo '<div style="background-color: #dff0d8;border: 1px solid #d6e9c6;padding: 10px;margin-bottom: 10px;">
            Xóa thể loại thành công</div>';
            break;
        }
    }
}

// Cập nhật thể loại
if (isset($_POST['update_category'])) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $name = $_POST['name'];
    $status = $_POST['status'];
    foreach ($_SESSION['categories'] as &$category) {
        if ($category['id'] == $id) {
            $category['code'] = $code;
            $category['name'] = $name;
            $category['status'] = $status;
            echo '<div style="background-color: #dff0d8;border: 1px solid #d6e9c6;padding: 10px;margin-bottom: 10px;">
            Cập nhật thể loại thành công.</div>';
            break;
        }
    }
}

// Hiển thị form cập nhật thể loại
if (isset($_POST['edit_category'])) {
    $id = $_POST['id'];
    $category = null;
    foreach ($_SESSION['categories'] as $c) {
        if ($c['id'] == $id) {
            $category = $c;
            break;
        }
    }
    if ($category) {
?>
        <div>
            <h2>Cập nhật thể loại</h2>
            <form method="POST" action="">
                <div>
                    <label for="code">Mã thể loại:</label>
                    <input type="text" id="code" name="code" value="<?= $category['code'] ?>">
                </div>
                <div>
                    <label for="name">Tên thể loại:</label>
                    <input type="text" id="name" name="name" value="<?= $category['name'] ?>">
                </div>
                <div>
                    <label for="status">Trạng thái:</label>
                    <select id="status" name="status" style="padding: 8px;font-size: 16px;border-radius: 5px;border: 1px solid #ccc;outline: none;background-color: #f9f9f9;">
                        <option style="font-size: 16px;" value="hoạt động" <?= $category['status'] == 'hoạt động' ? 'selected' : '' ?>>Hoạt động</option>
                        <option style="font-size: 16px;" value="không hoạt động" <?= $category['status'] == 'không hoạt động' ? 'selected' : '' ?>>Không hoạt động</option>
                    </select>
                </div>

                <input type="hidden" name="id" value="<?= $category['id'] ?>">
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
            </tr>
            <?php foreach ($_SESSION['categories'] as $key) { ?>
                <tr>
                    <td><?= $key['id'] ?></td>
                    <td><?= $key['code'] ?></td>
                    <td><?= $key['name'] ?></td>
                    <td><?= $key['status'] ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $key['id'] ?>">
                            <button type="submit" name="delete_category">Xóa</button>
                        </form>
                    </td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $key['id'] ?>">
                            <button type="submit" name="edit_category">Sửa</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="form-them">
    <h2>Thêm thể loại sách</h2>
        <form method="POST" action="quanlytheloai.php">
            <div><label>Mã thể loại:</label>
                <input type="text" name="code" required>
            </div>
            <div><label>Tên thể loại</label><input type="text" name="name" required></div>
            <div><label>Trạng thái</label>
                <select name="status" id="" required>
                    <option value="hoạt động">Hoạt động</option>
                    <option value="không hoạt động">Không hoạt động</option>
                </select>
            </div>
            <input type="hidden" name="id" value="<?= count($_SESSION['categories']) + 1 ?>">
            <input type="submit" value="Thêm thể loại" name="add_category">
        </form>
    </div>
</body>