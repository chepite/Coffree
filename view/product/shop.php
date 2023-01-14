<link rel="stylesheet" href="css/shop.css">
<!--products-->
<!--shopping cart section-->
<!-- <p><a href="index.php?page=cart">cart</a></p> -->
<div class="intro">
    <h2 class="intro__title">Caffeine detox can be a challenge...</h2>
    <p>Here you can buy items to help you through your detox journey</p>
</div>
<div class="cart">
    <a href="index.php?page=cart"><img src="assets/products/cart.png"></a>
</div>
<section class="products">
    <?php foreach ($products as $product) : ?>


        <article class="product" id="<?php $product->id ?>">
            <!--img hier-->
            <img class="product__image" src="./assets/products/<?php echo $product->image ?>.png">
            <div class="product__info">
                <div class="product__info--firstLine">
                    <h2><?php echo $product["title"] ?></h2>
                    <p><?php echo $product->price ?></p>
                </div>
                <div class="product__info--desc">
                    <p><?php echo $product->description ?></p>
                </div>
                <!--button-->
                <form method="post" action="index.php?page=shop">
                    <input type="hidden" name="product_id" value="<?php echo $product->id; ?>" />
                    <button class="storeButton" type="submit" name="action" value="addItem">Add to Cart</button>
                </form>
                <!--/button-->
            </div>
        </article>

    <?php endforeach; ?>
</section>