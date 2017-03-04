<?php
  session_start();
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

<?php
   // Establishing SQL details

   $serverName="csmysql.cs.cf.ac.uk";
   $userName="c1623580";
   $password="Holiday01";
   $database="c1623580";

   $gamesTable="SELECT * FROM Games";

   // Open MySQL connection, get needed info

   $connect = new mysqli($serverName, $userName, $password, $database);

   // If statement for cart later on. Update value based on quantit
   if(isset($_POST['submit'])) {
     foreach($_POST['quantity'] as $gameKey => $quantity) {
       // If value in box is 0, unset session for that game
       if($quantity==0) {
         unset($_SESSION['cart'][$gameKey]);
       }
       // Else update the cart with that amount
       else {
         $_SESSION['cart'][$gameKey]['quantity']=$quantity;
       }
     }
   }

   if(isset($_POST['submit'])) {
     foreach($_POST['price'] as $gameKey => $quantity) {
       // If value in box is 0, unset session for that game
       if($quantity==0) {
         unset($_SESSION['cart'][$gameKey]);
       }
       // Else update the cart with that amount
       else {
         $_SESSION['cart'][$gameKey]['quantity']=$quantity;
       }
     }
   }

   // If statement to check if session exists
   if(isset($_SESSION['cart'])) {
    $getGame = "SELECT * FROM Games WHERE gameID IN(";

    // MySQL select for only the products in the cart
    foreach($_SESSION['cart'] as $gameID => $value) {
      if(!$gameID) {
        $gameID = 'x';
      }
      $getGame.="'$gameID'".",";
    }

    // Some substr sorting for the products
    $getGame=substr($getGame, 0, -1).") ORDER BY name ASC";

    // Make the big ol query
    $query=$connect->query($getGame);

    // Initiate price variable
    $totalPrice = 0;

    $count = 0;
    ?>
    <form method="post" action="cart.php">
    <div class="cartGames">
    <table>
    <tr>
    <?php
    // Calculate price
    while($row=$query->fetch_assoc()){
      $totalPrice += $_SESSION['cart'][$row['gameID']]['quantity']*$row['price'];
    ?>
      <td>
        <div class="cartImg"><img src="<?php echo $row["image"] ?>"></div>
        <div class="gameTitle">
          <?php echo $row["name"] ?>
          <br />£<?php echo $row["price"] ?>
        </div>
        <div class="quantityInput">
          <input type="text" name="quantity[<?php echo $row['gameID'] ?>]" size="5" value="<?php echo $_SESSION['cart'][$row['gameID']]['quantity'] ?>" />
        </div>
      </td>
    <?php
    $count += 1;
    if($count % 3 == 0) {
    echo '</tr>';
    }
    }
    ?>
    </table>
    </div>

    <br /><br />
    <div class="updateCart">
      <input type="submit" name="submit" class="submitCartUpdate" value="Update Cart" />
    </div>
    </form>
    <hr class="rule" />

    <div class="totalPriceArea">
      <p>Total Price: <strong>£<?php echo $totalPrice ?></strong></p>
      <br />
      <a href="paymentform.php" class="proceedToPayment">- Proceed to Payment -</a>
    </div>
    <?php
  } else {
?>
  <p class="emptyCart">
    <?php echo "Your cart is empty"?>
  </p>
<?php }
   $_SESSION['price'] = $totalPrice;
?>
