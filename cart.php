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
        <li><a href="#Games">Games</a></li>
    </ul>
    <div style="clear:both"></div>
</nav>

<header>
    <img src="img/mario.jpg" class="topImage"/>
</header>

<?php

  // If statement to check if session exists
  if(isset($_SESSION['cart'])) {
    $getGame = "SELECT * FROM Games WHERE gameID IN(";

    // MySQL select for only the products in the cart
    foreach($_SESSION['cart'] as $gameID => $value) {
      $getGame.=$gameID.",";
    }

    // Some substr sorting for the products
    $getGame=substr($sql, 0, -1).") ORDER BY name ASC";

    // Make the big ol query
    $query=mysql_query($getGame);

    // Initiate price variable
    $totalPrice = 0;

    // Calculate price
    while($row=mysql_fetch_array($query)){
      $totalPrice += $_SESSION['cart'][$row['gameID']]['quantity']*$row['price'];
    ?>
    <div class="tableOfGames">
        <div class="gameTitle"><?php echo $row["name"] ?></div>
        <div class="game">
          <input type="text" name="quantity[<?php echo $row['gameID'] ?>]" size="5" value="<?php echo $_SESSION['cart'][$row['gameID']]['quantity'] ?>" />
        </div>
        <div class="gamePrice">£<?php echo $row["price"] ?><br />
    </div>
    <?php
    }
     ?>
     <h2><?php echo $totalPrice ?></h2>
    <?php
  }
?>
