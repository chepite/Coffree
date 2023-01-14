<link rel="stylesheet" href="css/login.css">

<!-- <?php
    // if (!isset($_POST['username'])) {
    //     echo '<form name="login" method="post" action="">
    //     user:<input type="text" name="username"><br>
    //     pass:<input type="password" name="password"><br>
    //     <input type="submit" value="go">
    //     </form>';
    //     }else {
    //        if (in_array($_POST['username'], $usernames))  {
    //            if ($passwords[$_POST['username']] == $_POST['password']) {
    //              $_SESSION['loggedin'] = true;
    //              $_SESSION['username'] = $_POST['username'];
    //              $_SESSION['password'] = $_POST['password'];
    //              echo 'Logged in successfully.';
    //            }else {
    //              echo 'Invalid username or password given.';
    //            }
    //         }else {
    //           echo "This is not a recognised user.";
    //        }
    //     }
?> -->

<form name="login" method="post" action="index.php?page=login">
<input type="hidden" name="action" value="login" />
        <div class="formLine">
        <label for="username">Username</label>
        <span class="error"><?php if(!empty($errors['noUser'])){echo $errors['noUser'];}; ?></span>
         <input type="text" required name="username" value="<?php
          if (!empty($_POST['username'])) echo $_POST['username'];
          ?>"><br>
          </div>
          <div class="formLine">
          <label for="password">Password</label>
          <span class="error"><?php if(!empty($errors['incorrectPassword'])){echo $errors['incorrectPassword'];}; ?></span>

        <input type="password" required name="password" value="<?php
          if (!empty($_POST['password'])) echo $_POST['password'];
          ?>"><br>
           </div>
          <div class="formLine">
        <input type="submit" value="Login">
        </div>
         </form>
         <div class="signup">
            <p class="signup__text">Don't have an account yet? <a href="index.php?page=signup"><u>Sign Up</u><a></p>
         </div>
         <span class="error"><?php if (!empty($errors['text'])) echo $errors['text']; ?></span>

         <!-- user:<input type="text" name="username" value="<?php
        //   if (!empty($_POST['username'])) echo $_POST['username'];
          ?>"><br>
        pass:<input type="password" name="password" value="<?php
        //   if (!empty($_POST['password'])) echo $_POST['password'];
          ?>"><br> -->
         <script src="js/validate.js"></script>