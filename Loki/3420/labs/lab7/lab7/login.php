<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php
$PAGE_TITLE = "Login";
include "includes/metadata.php";
//include the library file
require 'includes/library.php';
// create the database connection
$pdo = connectDB();

$errors = array(); //declare empty array to add errors too
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

session_start(); //start session
if (isset($_POST['submit'])){
    $query = "select * from cois3420_users where username=? ";
    $stmt = $pdo->prepare($query);
    $stmt-> execute([$username]);
    $result = $stmt->fetch();

if($result===false){ //if username doesn't exist
        $errors['user'] = "not exist";
        }
    else if (password_verify($password, $result['password'])) { //if password match
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $result['id'];
            header("Location:results.php");
            exit();
        } 
        else  
           $errors['login']= true;
}
?>
</head>

<body>
    <!-- HEADER -->
    <?php include "includes/header.php"?>

    <!-- MAIN -->
    <main>
        <h1>Login</h1>

        <!-- LOGIN FORM -->
        <form action="<?=htmlentities($_SERVER['PHP_SELF'])?>" method="POST" autocomplete="off">
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Username"  value="<?=$username;?>">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <div>
                <span class="<?=!isset($errors['user']) ? 'hidden' : "";?>">*That user doesn't exist</span>
                <span class="<?=!isset($errors['login']) ? 'hidden' : "";?>">*Incorrect login info</span>
            </div>
            <button id="submit" name="submit">Log In</button>
        </form>
    </main>

    <!-- FOOTER -->
    <?php include "includes/footer.php"?>
</body>

</html>