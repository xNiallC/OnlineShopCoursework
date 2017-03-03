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
        <li><a href="#Games">Games</a></li>
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

// Next we deal with adding to the cart

if(isset($_GET['action']) && $_GET['action'] == "add") {

  // Set Game ID = value of the id from page
  $gameID = intval($_GET['id']);

  // Check if session with cart and the game exists
  if (isset($_SESSION['cart'][$gameID])) {
    // Add one to the cart
    $_SESSION['cart'][$gameID]['quantity']++;
  }
  else {

    // Select game from ID, then query database
    $selectGame="SELECT * FROM Games WHERE gameID={$gameID}";
    $query_stock=mysql_query($selectGame);

    $row_stock=mysql_fetch_array($query_stock);

    // With our new session, get the price from the game ID, add it to the session and add one to the cart
    $_SESSION['cart'][$row_stock['gameID']]=array(
      "quantity" => 1, "price" => $row_stock['price']
    );
  }
}

?>

</code>

<section id="Games" class="allGames">
<?php
    $count = 0;
    // PHP while loop that serves HTML and CSS for each database row, with an if to ensure every 2nd
    // game starts a new row.
    while($row = $result->fetch_assoc()) { ?>
    <div class="tableOfGames">

        <!-- Each element from the database has its own div for styling -->

        <div class="gameImg"><img src="<?php echo $row["image"] ?>"></div>

        <br/>

        <div class="gameTitle"><?php echo $row["name"] ?></div>

        <div class="gamePrice">£<?php echo $row["price"] ?><br />
          <!-- <input type="submit" value="Add to Cart" class="addToCart" href="index.php?page=index&action=add&id=<?php echo $row['gameID'] ?>"> -->
          <a href="index.php?page=index&action=add&id=<?php echo $row['gameID'] ?>">Add to cart</a>
        </div>

        <div class="game"><?php echo $row["description"] ?></div>



        <br/>

        <?php
        $count += 1;
        ?>

    </div>

    <!-- If statement to work out every 2nd element via modulo -->

    <?php
        if($count % 2 == 0) {
        echo '<hr class="rule" />';
        }
        ?>


    <?php } ?>
</section>

<?php
mysqli_close($connect);
print_r($_SESSION);
?>

</body>
</html>
