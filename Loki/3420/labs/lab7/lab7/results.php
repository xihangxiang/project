<?php
/****************************************
// ENSURES THE USER HAS ACTUALLY LOGGED IN
// IF NOT REDIRECT TO THE LOGIN PAGE HERE
 ******************************************/
session_start();
if(!isset($_SESSION['username'])){
   header("Location:login.php");
   exit();
 }

require "includes/library.php";

// CONNECT TO DATABASE
$pdo = connectDB();

// FIND ALL VOTES SUBMITTED
$query = "SELECT name, votecount FROM `cois3420_characters` ORDER BY votecount DESC";
$stmt = $pdo->query($query);
if (!$stmt) {
    die("Something went horribly wrong");
}

//get the total votes
$stmt2 = $pdo->query("select sum(votecount) as total from cois3420_characters");
$total = $stmt2->fetchColumn(); // will only be one value

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
$PAGE_TITLE = "Voting Results";
include "includes/metadata.php";
?>
</head>

<body>
    <?php include "includes/header.php"?>
    <main>
        <h1>Results</h1>
        <table>
            <thead>
                <th>Name</th>
                <th>Votes</th>
            </thead>
            <tbody>
                <?php foreach ($stmt as $row): ?>
                <tr>
                    <td><?=$row['name']?></td>
                    <td><?=$row['votecount']?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
            <tfoot>
                <tr>
                    <td>Total Votes</td>
                    <td><?php echo $total //output total    ?></td>
                </tr>
            </tfoot>
        </table>
    </main>
    <?php include "includes/footer.php"?>
</body>

</html>