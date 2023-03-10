<?php
session_start();

if (isset($_POST['category_name'])) {
    $category_name = $_POST['category_name'];
    $books_of_category = array();
    foreach ($_SESSION['books'] as $book) {
        if ($book['TheLoaiSach'] == $category_name) {
            $books_of_category[] = $book;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Danh sách sách thuộc thể loại</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    
</head>

<body>
    <h1>Danh sách sách thuộc thể loại <?= $category_name ?></h1>
    <?php if (isset($_POST['category_name'])) { ?>
        <?php if (count(($books_of_category)) > 0) { ?>
            <div class="list-book">
                <table border="1">
                    <tr>
                        <th>ID</th>
                        <th>Tên sách</th>
                        <th>Tên tác giả</th>
                        <th>Ngày phát hành</th>
                    </tr>
                    <?php foreach ($books_of_category as $book) { ?>
                        <tr>
                            <td><?= $book['id'] ?></td>
                            <td><?= $book['TenSach'] ?></td>
                            <td><?= $book['TenTacGia'] ?></td>
                            <td><?= $book['NgayPhatHanh']->format('d-m-Y') ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        <?php } else { ?>
            <p>Không có sách thuộc thể loại này</p>
        <?php } ?>
    <?php } ?>

</body>

</html>