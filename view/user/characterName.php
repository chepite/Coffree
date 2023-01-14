<link rel="stylesheet" href="css/login.css">

<form method="post" action="index.php?page=characterName">
<input type="hidden" name="action" required value="characterName"/>
<div class="formLine">
<label for="characterName">Character name</label>
<span class="error"><?php if(!empty($errors['characterName'])){echo $errors['characterName'];}; 
if(!empty($errors['characterTooLong'])){echo $errors['characterTooLong'];};?></span>
<input type="text" name="characterName" required value="<?php
          if (!empty($_POST["characterName"])) echo $_POST["characterName"];
          ?>">
          </div>
<input type="submit">
</form>
<script src="js/validate.js"></script>
