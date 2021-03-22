<?php

//include the library file
require 'includes/library.php';
// create the database connection
$pdo = connectDB();

// get the data necessary to populate the radio buttons
$query = "SELECT ID,name FROM `cois3420_characters`";
$stmt = $pdo->query($query);

$errors = array(); //declare empty array to add errors too
// GET EVERYTHING FROM $_POST
$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$character = $_POST['character'] ?? null;
$agree = $_POST['agree'] ?? null;

if (isset($_POST['submit'])) {

// ERROR VALIDATION
    //checking for empty name
    if (!isset($name) || strlen($name) === 0) {
        $errors['name'] = true;
    }
    //checking for lack of space (indication of not full name)
    if (strpos($name, " ") === false) {
        $errors['fullname'] = true;
    }
    //validate email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = true;

    }
    //make sure the chose a character
    if (empty($character)) {
        $errors['character'] = true;

    }
    //make sure they agreed to the terms
    if (empty($agree)) {
        $errors['term'] = true;

    }
    // BONUS: CHECK TO SEE IF THE USER HAS ALREADY VOTED
    $query = "SELECT * FROM `cois3420_nintendo_allvotes` WHERE email = ?";
    $stmt2 = $pdo->prepare($query);
    $stmt2->execute([$email]);

    if ($stmt2->fetch()) {
        $errors['voted'] = true;
    }

    //only do this if there weren't any errors
    if (count($errors) === 0) {

        //query to insert entire voting record
        $query = "INSERT INTO `cois3420_nintendo_allvotes` (name, email, character_choice, terms, vote_date) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($query); //
        $stmt->execute([$name, $email, $character, $agree]);

        //query to update vote count for voted character
        $query = "UPDATE `cois3420_characters` SET votecount = votecount + 1 WHERE ID = ?";
        $stmt2 = $pdo->prepare($query);
        $stmt2->execute([$character]);

        //send the user to the thankyou page.
        header("Location:thankyou.php");
    }

}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
 <?php
$PAGE_TITLE = "Voting Page";
include 'includes/metadata.php';
?>
  </head>

  <body>
   <?php include 'includes/header.php';?>

    <!-- MAIN CONTENT -->
    <main>
      <h1>Vote For Your Favourite Character</h1>
       <div>  <span class="error <?=!isset($errors['voted']) ? 'hidden' : "";?>">*You have already voted.</span></div>
      <form id="voting" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate>

        <div>
          <label for="name">Name:</label>
          <input id="name" name="name" type="text" placeholder="John Smith" value="<?php echo $name; ?>" />

        </div>
        <div>
          <span class="error <?=!isset($errors['name']) ? 'hidden' : "";?>">*Enter a name</span>
           <span class="error <?=!isset($errors['fullname']) ? 'hidden' : "";?>">*Your name must include first and last.</span>
        </div>
        <div>
          <label for="email">Email:</label>
          <input
            id="email"
            name="email"
            type="email"
            placeholder="john@email.com"
            value="<?php echo $email ?>"
            required
          />

        </div>
        <div>
           <span class="error <?=!isset($errors['email']) ? 'hidden' : "";?>">*Enter a valid email address.</span>
        </div>
        <fieldset>
          <legend>Vote For Your Favourite Mario Character</legend>
          <!-- populate radio buttons with database result set -->
          <?php foreach ($stmt as $row): ?>
          <div>
            <input id="<?=$row['name'];?>" name="character" type="radio"
            value="<?=$row['ID'];?>"
            <?=$character == $row['ID'] ? 'checked' : ''?> />
            <label for="<?=$row['name'];?>"><?=$row['name'];?></label>
          </div>

         <?php endforeach;?>

              <span class="error <?=!isset($errors['character']) ? 'hidden' : "";?>">
          *Please choose a character.
        </span>
        </fieldset>

        <div id="agree-container">
          <input id="agree" type="checkbox" name="agree" value="Y"
          <?=$agree == "Y" ? 'checked' : ''?> />
          <label for="agree">
            I agree to the <a href="">Terms and Conditions</a>.
          </label>

        </div>
        <div>
           <span class="error <?=!isset($errors['term']) ? 'hidden' : "";?>">*You must agree to the terms and conditions</span>
        </div>
        <div>
        <button id="submit" name="submit">Submit Vote</button>
        </div>
      </form>
    </main>

      <?php include 'includes/footer.php';?>
  </body>
</html>

