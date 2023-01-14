<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
<link rel="stylesheet" href="css/brewery.css">
<div class="intro">
    <h2 class="intro__title">Welcome to the brewery</h2>
    <p>Here you can see your collected recipes, once you made them you can add them to your consumed recipes</br>
These will show up on your personal profile</p>
</div>
<?php 
    if(empty($_SESSION['userId'])){
        echo('<a class="redirectLogin" href="index.php?page=login">Log in to acces the brewery<a>');
    }
?>
<!-- <ul>
    <?php //foreach ($user->recipes as $recipe) : 
    ?>
         <article>
           <h2><?php //echo $recipe->name 
                ?></h2> 
             <p><?php //echo $recipe->ingredients[0]->ingredientName 
                ?></p> 
        </article> 
    <?php // endforeach; 
    ?>
</ul> -->
<!-- <div class="splide__arrows">
	<button class="splide__arrow splide__arrow--prev">
	</button>
	<button class="splide__arrow splide__arrow--next">
	</button>
</div> -->
<div class="splide">
    <div class="splide__track">
        <ul class="splide__list">

        </ul>
    </div>
</div>
<?php 
if(!empty($_SESSION['userId'])){
 echo('<img class="chef" src="assets/brewery/chef.png">');
}
?>
<div class="details">
    <!-- <div class="image">
        <img src="">
    </div>
    <div class="details">
        <h2 class="details__title"></h2>
        <ul class="details__list">
            <li class="details__list--item"></li>
        </ul>
        <ul class="details__steps">
        <li class="details__steps--step"></li>
        </ul>
    </div> -->
</div>
<!-- <form method="post">
<button type="submit">
</form> -->

<?php  
if(!empty($_SESSION['userId'])){

echo(
'<form method="post" action="index.php?page=brewery">
    <input type="hidden" name="action" value="addConsumation">
    <input type="hidden" id="recipeId" name="recipe_id" value="">
    <button type="submit" >Consume</button>
</form>');
}
?>
<?php
// if(!empty($recipes)){
//                 var_dump($recipes);
//             }
?>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

<?php  
if(!empty($_SESSION['userId'])){

echo(
'<script src="js/recipe.js"></script>');
}
?>










<?php //foreach ($user->recipes as $recipe) : 
?>
<!-- <li class="splide__slide">
                    <div class="splide__slide__container">
                        <img class="<?php //echo str_replace(" ", "", $recipe->name)
                                    ?>" src="assets/recipes/<?php echo $recipe->name ?>.png">
                        <div class="item__overlay">
                            <h2 class="item__overlay--title"><?php // echo $recipe->name 
                                                                ?></h2>
                            <p class="item__overlay--desc"><?php //echo $recipe->description 
                                                            ?></p>
                        </div>
                    </div>
                </li> -->
<?php //endforeach; 
?>