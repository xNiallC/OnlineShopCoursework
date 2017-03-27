<?php
  session_start()
  // I learnt this cool shopping cart technology from https://code.tutsplus.com/tutorials/build-a-shopping-cart-with-php-and-mysql--net-5144
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Curtis Games</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<body>

<nav>
    <h1>
        CurtisGames<span style="font-size: 10pt;">.co.uk</span>
    </h1>
    <ul>
        <li><a href="cart.php">Cart</a></li>
    </ul>
    <ul>
        <li><a href="index.php">Games</a></li>
    </ul>
    <div style="clear:both"></div>
</nav>

<header>
    <img src="img/mario.jpg" class="topImage"/>
</header>

<code>
  <?php

// Establishing SQL details

$serverName="csmysql.cs.cf.ac.uk";
$userName="c1623580";
$password="Holiday01";
$database="c1623580";

$gamesTable="SELECT * FROM Games";

// Open MySQL connection, get needed info

$connect = new mysqli($serverName, $userName, $password, $database);

// Access games table

$result= $connect->query($gamesTable);


// Get ID from URL using get
$gameID = $_GET['id'];

// Create query for specific game based on the ID passed
$getGame = "SELECT * FROM Games WHERE gameID={$gameID}";


// Make query using what we made
$query=$connect->query($getGame);

$gameRow=$query->fetch_array();

?>

</code>

<body>
  <section id="Games" class="allGamesProduct">
      <?php
      // Create variables from info about game
        $gameName = $gameRow['name'];
        $gamePrice = $gameRow['price'];
        $gameImage = $gameRow['image'];
        $gameDescription = $gameRow['description'];
      ?>
      <div class="gameImgProduct"><img src="<?php echo $gameImage ?>"></div>
      <div class="gameTitle"><?php echo $gameName?></div>
  </section>
</body>
