<link rel="stylesheet" href="css/profile.css">
<link rel="stylesheet" href="css/character.css">
<!-- <p>profile page</p> -->
<?php
// echo ('<p> hello' . $_SESSION['username'] . '</p>');
// echo ('<p> hello' . $_SESSION['userId'] . '</p>');
?>
<container class="content">
    <h2 class="title">This is your personal profile</h2>
    <p class="page_description">This is where <?php echo $_SESSION['characterName'] ?> lives, you can enter the cups of coffee you drank,
        you can track your progress, and see the alternatives you’ve consumed </p>

    <div class="top-content">
        <!--copied from charactergenerator-->
        <div class="preview">
            <div class="preview__head" style="background-image: url(assets/generator/heads/goat<?php echo $user->character->head ?>.png)">
                <!-- <img class="preview__head--image" src=""> -->
            </div>
            <div class="preview__body">
                <div id="overlay">
                    <img class="preview__body--image" src='assets/generator/bodies/<?php echo $user->character->body ?>.png'>
                </div>
            </div>
        </div>
        <!--end copy charactergenerator-->
        <div class="coffee">
            <div class="coffee__recommended">
                <h2>Todays recommended amount</h2>
                <div class=" mug__div mug__div--recommended">
                <img class="mug" src="assets/profile/mug.png">
                <p class="coffee__recommended--amount">
                    <!--aantal-->
                </p>
                </div>
            </div>
            <div class="coffee__consumed">
                <h2>Todays consumed amount</h2>
                <div class="mug__div">
                <div class="coffee__consumed--add">
                <img class="mug" src="assets/profile/mug.png">
                    <p><?php if ($todayCoffee) {
                            //echo $todayCoffee->currentAmount;
                            echo $todayCoffee->currentAmount;
                        } ?> cups</p>
                        
                    <form method="post" action="index.php?page=profile">
                        <!-- <input type="hidden" name="user_id" value="<?php //echo $user->id; 
                                                                        ?>" /> -->
                        <button class="addButton" type="submit" name="action" value="addCoffee">+</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="progress">
        <h2 class="div__header">Progress</h2>
        <!--progress-->
        <ul class="progressList">
        </ul>
        <p id="streak" style="display: none;"><?php if ($user) {
                                                    echo $user->streak;
                                                } ?></p>
    </div>

    <div class="chartConsume">
        <h2 class="div__header">During your detox you consumed...</h2>
        <div class="chartBig">
            <div class="consumed">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
            <div class="chart__text">
                <p>instead of <?php echo $AmountAlternatives ?> Coffees</p>
            </div>
        </div>
    </div>
    <div class="logout">
        <a class="logout__link" href="destroy.php">Log out</a>
    </div>
</container>
<!-- <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js" integrity="sha512-VCHVc5miKoln972iJPvkQrUYYq7XpxXzvqNfiul1H4aZDwGBGC0lq373KNleaB2LpnC2a/iNfE5zoRYmB4TRDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="js/detox.js"></script>
<script src="js/trippy.js"></script>
<!-- <script src="js/consumation.js"></script> -->

<?php //var_dump($user->id);
//var_dump($todayCoffee->user); 
?>
<!-- <script src="js/trophies.js"></script>  -->





<script type="text/javascript">
    const dataPoints = [];
    const labels = []
    const addData = (data) => {
        for (var i = 0; i < data.length; i++) {
            dataPoints.push(
                data[i].amount
            );
            labels.push(data[i].name);
        }
        console.log(dataPoints);
    }
    const init = async () => {
        let ctx = document.getElementById('myChart');
        const data = <?php echo json_encode($consumations); ?>;
        await addData(data);

        const pieData = {
            labels: Array.from(new Set(labels)),
            datasets: [{
                label: 'Consumed',
                data: Array.from(new Set(dataPoints)),
                backgroundColor: [
                    '#DC0032',
                    '#3B4376',
                    '#FFC229'
                ],
                hoverOffset: 4
            }]
        };
        const config = {
            type: 'pie',
            data: pieData,
        };
        let myChart = new Chart(ctx, config);
        console.log(myChart);

    }
    init();
</script>