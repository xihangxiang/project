<?php
$errors = array(); //declare empty array to add errors too

// GET EVERYTHING FROM $_POST
$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$character = $_POST['character'] ?? null;
$agree = $_POST['agree'] ?? null;

/*****************************************
 * Include library, make database connection,
 * and query for radio button information here
 ***********************************************/
  include "includes/library.php";
  $pdo = connectdb();
  $query = "SELECT ID, name FROM `cois3420_characters`";
  $stmt = $pdo->query($query);

if (isset($_POST['submit'])) {

// ERROR VALIDATION
    //checking for empty name
    if (!isset($name) || strlen($name) === 0) {
        $errors['name'] = "Please enter a name";
    }
    //checking for lack of space (indication of not full name)
    if (strpos($name, " ") === false) {
        $errors['fullname'] = "Please enter a name";
    }
    //validate email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address";
    }
    //make sure the chose a character
    if (empty($character)) {
        $errors['character'] = "Please select a character";
    }
    //make sure they agreed to the terms
    if (empty($agree)) {
        $errors['term'] = "Please agree to the terms and conditions";
    }

    //only do this if there weren't any errors
    if (count($errors) === 0) {

        /********************************************
         * Put the code to write to the database here
         ********************************************/
        $query = "insert into cois3420_nintendo_allvotes(ID, name, email, character_choice, terms, vote_date) values (null, ?,?,?,?,NOW())";
        $stmt = $pdo->prepare($query)->execute([$name,$email,$character, $agree ]);
        $query = "UPDATE `cois3420_characters` SET votecount = votecount + 1 WHERE ID = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$character]);

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
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate>
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
    <!-- Put for loop for database results here. Use the one radio button left below as the template.  Replace the radio button value with a php echo of the database ID, and the contents of the label, the id, and the for with a echo of the database name  -->
         <?php foreach($stmt as $row):?>
            <div>
              <input id=<?php echo $row["name"]; ?> name="character" type="radio"  value=<?php echo $row["ID"]; ?>
              <?=$character == "1" ? 'checked' : ''?> />
              <label for=<?php echo $row["name"]; ?>><?php echo $row["name"]; ?></label>
            </div>
          <?php endforeach ?>

          <!-- loop should stop here -->
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

