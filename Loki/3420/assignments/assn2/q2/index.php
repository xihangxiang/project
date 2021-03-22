<?php
session_start();
if (!isset($_SESSION['win'])) {
    $_SESSION['win'] = 0;
}
if (!isset($_SESSION['lost'])) {
    $_SESSION['lost'] = 0;
}

$yourChoose = "-";
$ComputerChoose = "-";
$result = "";
$error = " ";
if (isset($_POST['submit'])) {
    if (!isset($_POST['choose'])) {
        $error = "<span class='red'>Please make a choose.</span>";
    } else {
        //win rules
        $my_array = array("stone", "scissors", "cloth");
        $guize = array(array("stone", "scissors"), array("scissors", "cloth"), array("cloth", "stone"));
        $rand_keys = array_rand($my_array);
        $ComputerChoose = $my_array[$rand_keys];
        $yourChoose = $_POST['choose'];
        $input = array($yourChoose, $ComputerChoose);
        if ($yourChoose == $ComputerChoose) {
            $result = "Draw";
        } elseif (in_array($input, $guize)) {
            $result = "You win";
            $_SESSION['win'] = +$_SESSION['win'] + 1;
        } else {
            $result = "Computer win";
            $_SESSION['lost'] = +$_SESSION['lost'] + 1;
            if ($_SESSION['lost'] >= 10) {
                header("location:GameOver.php");
            }
        }
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Game</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
<?php include 'includes/header.php'; ?>
<main>
    <div class="scores">Scores: <span class="green">win <?= $_SESSION['win']; ?> times</span> / <span
                class="red">lost <?= $_SESSION['lost']; ?> times</span></div>
    <form action="index.php" method="post">
        <div class="btn">Plesase choose：<input type="radio" value="stone" name="choose">stone <input type="radio"
                                                                                                     value="scissors"
                                                                                                     name="choose">scissors
            <input type="radio" value="cloth" name="choose">cloth <input type="submit" name="submit" value="confirm">

        </div>
    </form>
    <table>
        <tr>
            <td class="w200">You</td>
            <td class="gray">vs</td>
            <td class="w200">Computer</td>
        </tr>
        <tr>
            <td><?= $yourChoose ?></td>
            <td class="gray">vs</td>
            <td><?= $ComputerChoose ?></td>
        </tr>
    </table>
    <div><?= $error; ?><?= $result ?></div>
</main>
</body>
</html>
