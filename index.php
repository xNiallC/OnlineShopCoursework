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

$gamesTable = "HUGE MEMES";

// Check if ordering is set
if(isset($_GET['order'])) {
  $productOrder = $_GET['order'];
  if( $productOrder == 'a2z') {
    $gamesTable="SELECT * FROM Games ORDER BY name ASC";
  }
  else if( $productOrder == 'z2a') {
    $gamesTable="SELECT * FROM Games ORDER BY name DESC";
  }
  else if( $productOrder == 'price') {
    $gamesTable="SELECT * FROM Games ORDER BY price ASC";
  }
  else if( $productOrder == 'priceDesc') {
    $gamesTable="SELECT * FROM Games ORDER BY price DESC";
  }
  else {
    $gamesTable="SELECT * FROM Games";
  }
}
else {
  $gamesTable="SELECT * FROM Games";
}
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

?>

</code>

<section id="Games" class="allGames">
  <form method="get" action="index.php" class="sortForm">
    <select name="order">
      <option value="none" name="none">
        None
      </option>
      <option value="a2z" name="a2z">
        Name Ascending
      </option>
      <option value="z2a" name="a2z">
        Name Descending
      </option>
      <option value="price" name="price">
        Price Ascending
      </option>
      <option value="priceDesc" name="priceDesc">
        Price Descending
      </option>
    </select>
    <input type="submit" value="Sort" />
  </form>
<?php
    if(isset($_GET['game'])) {
      echo $_GET['game']." added to cart.";
    }
    ?>
    <br />
    <?php
    $count = 0;
    // PHP while loop that serves HTML and CSS for each database row, with an if to ensure every 2nd
    // game starts a new row.
    while($row = $result->fetch_assoc()) { ?>
    <div class="tableOfGames">

        <!-- Each element from the database has its own div for styling -->

        <div class="gameImg"><img src="<?php echo $row["image"] ?>" href="productpage.php?id=<?php echo $row['gameID'] ?>"></div>

        <br/>

        <div class="gameTitle"><a href="productpage.php?id=<?php echo $row['gameID'] ?>"><?php echo $row["name"] ?></a></div>

        <div class="gamePrice">
          £<?php echo $row["price"] ?><br />
          <a id="addItemToCartID" href="index.php?page=index&action=add&id=<?php echo $row['gameID'] ?>&game=<?php echo $row["name"] ?>" class="addToCartLink">- Add to cart -</a>
        </div>

        <div class="game"><?php echo $row["description"] ?></div>



        <br/>

        <?php
        $count += 1;
        ?>

    </div>

    <!-- If statement to work out every 2nd element via modulo -->

    <?php
        // Simple way to split rows up
        if($count % 2 == 0) {
        echo '<hr class="rule" />';
        }
        ?>


    <?php } ?>
</section>

<?php
mysqli_close($connect);
?>

</body>
</html>
