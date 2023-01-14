<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/layout.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Suez+One&display=swap" rel="stylesheet">
  <title>Coffree - <?php echo $title; ?></title>
</head>

<body>
  <nav>
    <ul class="nav">
      <div class="nav__div nav__div--title">
        <h1><a href="index.php">Coffree</a></h1>
      </div>
      <div class="nav__div nav__div--sections">
        <ul>
          <li class="nav__div--item"><a href="index.php?page=brewery">Brewery</a></li>
          <li class="nav__div--item"><a href="index.php?page=shop">Shop</a></li>
          <?php
          //  if (isset($_SESSION['loggedin']) ) {
          if ($_SESSION['loggedin'] == true) {
            echo ('<li class="nav__div--item"><a href="index.php?page=profile">Profile</a></li>');
          } else {
            echo ('<li class="nav__div--item"><a href="index.php?page=login">Profile</a></li>');
          }
          ?>
        </ul>
      </div>
    </ul>
  </nav>
  <?php echo $content ?>
</body>
</html>