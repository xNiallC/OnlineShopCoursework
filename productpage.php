<?php
  session_start()
  // I learnt this cool shopping cart technology from https://code.tutsplus.com/tutorials/build-a-shopping-cart-with-php-and-mysql--net-5144
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Curtis Games</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="fonts/css/font-awesome.min.css">
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

<code>
  <?php

// Establishing SQL details

$serverName="csmysql.cs.cf.ac.uk";
$userName="c1623580";
$password="";
$database="c1623580";

$gamesTable="SELECT * FROM Games";

// Open MySQL connection, get needed info

$connect = new mysqli($serverName, $userName, $password, $database);

// Access games table

$result= $connect->query($gamesTable);

// Next we deal with adding to the cart

// Check if set and action
if(isset($_GET['action']) && $_GET['action'] == "add") {

  // Set Game ID = value of the id from page
  $gameID = $_GET['id'];

  // Check if session with cart and the game exists
  if (isset($_SESSION['cart'][$gameID])) {
    // Add one to the cart
    $_SESSION['cart'][$gameID]['quantity'] ++;
  }
  else {

    // Select game from ID, then query database
    $selectGame="SELECT * FROM Games WHERE gameID={$gameID}";
    $query_stock=$connect->query($selectGame);

    $row_stock=$query_stock->fetch_array();

    // With our new session, get the price from the game ID, add it to the session and add one to the cart
    $_SESSION['cart'][$row_stock['gameID']]=array(
      "quantity" => 1,
      "price" => $row_stock['price']
    );
  }
}

// Get ID from URL using get
$gameID = $_GET['id'];

// Create query for specific game based on the ID passed
$getGame = "SELECT * FROM Games WHERE gameID={$gameID}";


// Make query using what we made
$query=$connect->query($getGame);

$gameRow=$query->fetch_array();

?>

</code>

<header>
  <?php $gameName = $gameRow['screenshot'] ?>
  <img src="img/<?php echo $gameName ?>" class="topImageProduct" />
</header>

<body>
  <section id="Games" class="allGamesProduct">
      <?php
      // Create variables from info about game
        $gameName = $gameRow['name'];
        $gamePrice = $gameRow['price'];
        $gameImage = $gameRow['image'];
        $gameDescription = $gameRow['detaileddesc'];
      ?>
      <div class="gameImgProduct"><img src="<?php echo $gameImage ?>"></div>
      <div class="gameTitleProduct"><?php echo $gameName?></div>
      <div class="gamePriceProduct">£<?php echo $gamePrice?></div>
      <hr class="ruleProduct" />
      <div class="gameDescriptionProduct"><?php echo $gameDescription?></div>
      <div class="inCart">
        <?php
        if(isset($_GET['action'])) {
          echo "Added to cart! - ";
        }
        if(isset($_SESSION['cart'][$gameID]['quantity'])) {
          ?>Number already in cart: <?php echo $_SESSION['cart'][$gameID]['quantity'];
        }?>
      </div>
      <div class="addToCartProduct"><a href="productpage.php?page=index&action=add&id=<?php echo $gameID?>">
        <i class="fa fa-cart-plus" aria-hidden="true"></i> Add to Cart</a></div>
  </section>
</body>
