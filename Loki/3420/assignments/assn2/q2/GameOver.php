<?php
session_start();
include 'includes/library.php';
$error = " ";
if (isset($_POST['submit'])) {
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $score = isset($_POST['score']) ? $_POST['score'] : null;
    $pdo = connectDB();
    $query = "INSERT INTO `cois3420_scores`(`nickname`, `score`)  values (?,?)";
    $stmt = $pdo->prepare($query)->execute([$name, $score]);
    if ($stmt) {
        session_destroy();
        header("location:HighScores.php");
    } else {
        $error = "<span class='red'>Add failed.</span>";
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Game Over</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>


<?php include 'includes/header.php'; ?>
<div class="des"><h3 class="red">Game Over!</h3>
    <p class="green">
        Please fill in your name!</p>
</div>
<form action="GameOver.php" method="post" class="btn">
    name：<input type="text" name="name"><br>
    score：<input type="text" name="score" value="<?= $_SESSION['win']; ?>" readonly disable><br>
    <input type="submit" name="submit" value="submit">

</form>
<div><?= $error; ?></div>
</body>
</html>
