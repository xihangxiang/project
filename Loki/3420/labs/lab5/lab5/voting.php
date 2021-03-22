<?php

  $errors = array(); //declare empty array to add errors too

if (isset($_POST['submit'])) { 

    //validate user has entered a name
    $name = $_POST['name'] ?? null; //get name from post or set to NULL
    if (!isset($name) || strlen($name) === 0) {
        $errors['name'] = "Please enter a name";
    }
 
    //fullname
    if(strpos($name, " ") === false)
    {
      $errors['fullname'] = "Please enter valid first and last name";
    }

    //validate character
    $character=$_POST['character'] ?? null;
    if(empty($character)){
      $errors['character'] = "please choose a character";
    }

    //email validation
    $email = $_POST['email'] ?? null;
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Invalid email format";
  }

  //term
  $term = $_POST['agree'] ?? null;
  if(empty($term)){
    $errors['term'] = "You must agree to terms";
  }

  if(count($errors)==0){

    header('location:thankyou.php');
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php $PAGE_TiTLE = "Voting";
      include 'includes/metadata.php';?>

  <body>
    <!-- HEADER -->
   <?php include 'includes/header.php';?>

    <!-- MAIN CONTENT -->
    <main>
      <h1>Vote For Your Favourite Character</h1>
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate>
        <div>
          <label for="name">This Name:</label>
          <input id="name" name="name" type="text" placeholder="John Smith" />

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
            required
          />

        </div>
        <div>
           <span class="error <?=!isset($errors['email']) ? 'hidden' : "";?>">*Enter a valid email address.</span>
        </div>
        <fieldset>
          <legend>Vote For Your Favourite Mario Character</legend>

          <div>
            <input id="mario" name="character" type="radio" value="mario" />
            <label for="mario">Mario</label>
          </div>

          <div>
            <input id="luigi" name="character" type="radio" value="luigi" />
            <label for="luigi">Luigi</label>
          </div>

          <div>
            <input id="peach" name="character" type="radio" value="peach" />
            <label for="peach">Peach</label>
          </div>

          <div>
            <input id="daisy" name="character" type="radio" value="daisy" />
            <label for="daisy">Daisy</label>
          </div>

          <div>
            <input id="yoshi" name="character" type="radio" value="yoshi" />
            <label for="yoshi">Yoshi</label>
          </div>
          <span class="error <?=!isset($errors['character']) ? 'hidden' : "";?>">
          *Please choose a character.
        </span>
        </fieldset>

        <div id="agree-container">
          <input id="agree" type="checkbox" name="agree" />
          <label for="agree"
            >I agree to the <a href="">Terms and Conditions</a>.</label
          >

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

