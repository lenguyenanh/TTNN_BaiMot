<?php
session_start();

if (isset($_POST['ten-the-loai'])) {
    $ten_the_loai = $_POST['ten-the-loai'];
    $arrSach = array();
    foreach ($_SESSION['arrSach'] as $b) {
        if ($b['TheLoaiSach'] == $ten_the_loai) {
            $arrSach[] = $b;
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
    <h1 style="text-align: center;">Danh sách sách thuộc thể loại <?= $ten_the_loai ?></h1>
    <?php if (isset($_POST['ten-the-loai'])) { ?>
        <?php if (count(($arrSach)) > 0) { ?>
            <div class="list-book">
                <table border="1">
                    <tr>
                        <th>ID</th>
                        <th>Tên sách</th>
                        <th>Tên tác giả</th>
                        <th>Ngày phát hành</th>
                    </tr>
                    <?php foreach ($arrSach as $b) { ?>
                        <tr>
                            <td><?= $b['id'] ?></td>
                            <td><?= $b['TenSach'] ?></td>
                            <td><?= $b['TenTacGia'] ?></td>
                            <td><?= $b['NgayPhatHanh']->format('d-m-Y') ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        <?php } else { ?>
            <p style="font-size: 16px;font-weight: bold;color: red;text-align: center;">Không có sách thuộc thể loại <?= $ten_the_loai ?></p>
        <?php } ?>
    <?php } ?>

</body>

</html>