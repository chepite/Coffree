<link rel="stylesheet" href="css/login.css">
<link rel="stylesheet" href="css/character.css">
<?php 
if(!isset($_POST['characterName'])){
    //if for one odd reason the name doesn't get saved have a default name
    $_POST['characterName']= "your character";
}
// $_SESSION['characterName']= $_POST['characterName'];
// echo('<p> characterName:'. $_SESSION['characterName'] .'</p>');
// echo('<p> username:'. $_SESSION['username'] .'</p>');
// echo('<p> password:'. $_SESSION['password'] .'</p>');
// echo('<p> password:'. $_SESSION['userId'] .'</p>');
?>
<div class="subtitle__div">
    <h2 class="subtitle">Let's give <?php echo $_SESSION["characterName"]; ?> a fresh look</h2>
</div>
<div class="characterGenerator">
    <form class="characterForm" method="post" action="index.php?page=characterGenerator">
    <input type="hidden" name="action" required value="characterGenerator"/>
        <div class="formLine">
        <label for="color">Color</label>
        <div class="colorDiv">
            <input type="color" name="color" id="colorSelector">
        </div>
        </div>
        <div class="formLine">
        <label for="characterHead">Give <?php echo $_SESSION["characterName"] ?> a head</label>
        <select name="characterHead" id="characterHead">
        <option value="1">Erika</option>
            <option value="2">Boris</option>
        </select>
        </div>
        <div class="formLine">
        <label name="characterBody">Give <?php echo $_SESSION["characterName"] ?> a body</label>
        <select name="characterBody" id="characterBody">
            <option value="bodybuilder">Bodybuilder</option>
            <option value="test2">Beach</option>
        </select>
        </div>
        <input type="submit">
    </form>
    <div class="preview">
         <div class="preview__head"> 
            <!-- <img class="preview__head--image" src=""> -->
        </div>
        <div class="preview__body"> 
        <div id="overlay">
            <img class="preview__body--image" src="">
            </div>
         </div> 
    </div>
</div>
<script src="js/validate.js"></script>
<?php
// if(!empty($errors)){
//                 var_dump($errors);
//             }
?>
<script type="text/javascript" src="js/characterGenerator.js"></script>