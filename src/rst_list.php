<?php
require_once('model.php');
require_once('Restaurant.php');
$model = new Restaurant();

// データ取得
$restaurants = $model->getList();
?>

<?php include('pg_header.php'); ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>店舗一覧</title>
</head>
<body>

<h1>店舗一覧</h1>

<table border="1" width="100%">
    <tr>
        <th>ID</th>
        <th>店舗名</th>
        <th>住所</th>
        <th>営業時間</th>
        <th>電話番号</th>
        <th>支払い方法</th>
        <th>割引</th>
    </tr>

    <?php foreach ($restaurants as $row): ?>
    <tr>
        <td><?= htmlspecialchars($row['RST_ID']) ?></td>
        <td>
            <a href="restaurant_detail.php?id=<?= $row['RST_ID'] ?>">
                <?= htmlspecialchars($row['RST_NAME']) ?>
            </a>
        </td>
        <td><?= htmlspecialchars($row['RST_ADDRESS']) ?></td>
        <td><?= htmlspecialchars($row['START_TIME']) ?>〜<?= htmlspecialchars($row['END_TIME']) ?></td>
        <td><?= htmlspecialchars($row['TEL_NUM']) ?></td>
        <td><?= htmlspecialchars($row['RST_PAY']) ?></td>
        <td><?= $row['DISCOUNT'] ? 'あり' : 'なし' ?></td>
    </tr>
    <?php endforeach; ?>

</table>

</body>
</html>
<?php include('pg_footer.php'); ?>  