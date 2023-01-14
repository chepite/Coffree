<link rel="stylesheet" href="css/index.css">
<div class="hero">
    <div class="title__div">
        <h1 class="title">COFFREE</h1>
        <h2 class="subtitle">Beat your caffeine addiction</h2>
    </div>
</div>
<div class="waves">
    <img class="wave wave__light" src="assets/index/waves_light.png">
    <img class="wave wave__mid" src="assets/index/waves_mid.png">
    <img class="wave wave__dark" src="assets/index/waves_dark.png">
</div>
<div class="cta">
    <div class="cta__image">
        <img class="bean bean-1" src="assets/index/bean.png">
        <img class="bean bean-2" src="assets/index/bean.png">
        <img class="bean bean-3" src="assets/index/bean.png">
        <img class="cta__goat" src="assets/index/goat.png">
    </div>
    <div class="cta__text">
        <h2 class="text__subtitle">Cut the chains of Coffee</h2>
        <p class="cta__text--text">Coffee has been one of the most popular drinks in the world, perhaps a bit too popular.</p>

        <p class="cta__text--text">Caffeine addiction comes with great health risks such as insomnia, raised hearbeat and even psychosis.</p>
        <div>
            <a class="cta__link" href="index.php?page=login">Cut the chains now</a>
        </div>
    </div>
</div>
<div class="shop__teaser">
    <h2 class="text__subtitle">Coffree shop</h2>
    <p>Enhance your detox experience with these amazing upgrades</p>
    <div class="items">
        <?php foreach ($highlightedProducts as $product) : ?>
            <a href="index.php?page=shop">
                <div class="shop__teaser--card">
                    <img class="shop__teaser--image" src="assets/products/<?php echo $product->image ?>.png">
                </div>
            </a>
        <?php endforeach; ?>

        <a href="index.php?page=shop">
            <div class="shop__teaser--card arrow">
                <h2 class="text__subtitle">Explore the shop</h2>
            </div>
        </a>
    </div>
    <div class="footer">
        <img src="assets/index/footer.png">
    </div>
</div>