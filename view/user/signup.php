<link rel="stylesheet" href="css/login.css">

<!-- <form method="post" action="index.php?page=characterName"> -->
<form method="post" action="index.php?page=signup">
    <input type="hidden" name="action" required value="addUser"/>
    <div class="formLine">
    <label for="username">Username</label>
    <span class="error"><?php if(!empty($errors['username'])){echo $errors['username'];}; 
    if(!empty($errors['tooLong'])){echo $errors['tooLong'];};?></span>
    <input type="text"  required name="username" value="<?php
          if (!empty($_POST['username'])) echo $_POST['username'];
          ?>">
          </div>
          <div class="formLine">
    <label for="password">Password</label>
    <span class="error"><?php if(!empty($errors['password'])){echo $errors['password'];}; 
    if(!empty($errors['passwordLength'])){echo $errors['passwordLength'];};?></span>
    <input type="password" name="password" required value="<?php
          if (!empty($_POST['password'])) echo $_POST['password'];
          ?>">
          </div>
          <div class="formLine">
    <label for="repeatPassword">Repeat password</label>
    <span class="error"><?php if(!empty($errors['repeatPassword'])){echo $errors['repeatPassword'];};
 if(!empty($errors['password mismatch'])){echo $errors['password mismatch'];};?></span>
    <input type="password" name="repeatPassword" required value="<?php
          if (!empty($_POST['repeatPassword'])) echo $_POST['repeatPassword'];
          ?>">
          </div>
    <input type="submit">
</form>
<script src="js/validate.js"></script>
<?php 
// if(!empty($errors)){
//                 var_dump($errors);
//             }?>