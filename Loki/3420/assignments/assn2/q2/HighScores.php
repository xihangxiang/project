<?php
session_start();
include 'includes/library.php';
$pdo = connectDB();
$sql = "select * from cois3420_scores order by score desc,addtime asc ";
$stmt = $pdo->query($sql);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>High Scores</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
<?php include 'includes/header.php'; ?>
<table>
    <tr>
        <td>Rank</td>
        <td>Nick Name</td>
        <td>Score</td>
        <td>Time</td>
    </tr>
    <?php
    $i = 1;
    foreach ($stmt as $row):?>
        <tr>
            <td><?= $i; ?></td>
            <td><?= $row["nickname"]; ?></td>
            <td><?= $row["score"]; ?></td>
            <td><?= $row["addtime"]; ?></td>
        </tr>
        <?php
        $i++;
    endforeach ?>
</table>
</body>
</html>
