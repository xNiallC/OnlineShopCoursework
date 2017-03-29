<?php
  session_start();
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

<header>
    <img src="img/franklin.jpg" class="topImage fade" />
    <img src="img/mario.jpg" class="topImage fade"/>
    <img src="img/fez.png" class="topImage fade"  />
    <img src="img/minecraft.png" class="topImage fade" />
    <img src="img/rl.jpg" class="topImage fade" />
    <img src="img/wow.jpg" class="topImage fade" />
    <img src="img/zelda.jpg" class="topImage fade" />
    <img src="img/uncharted.jpg" class="topImage fade" />
    <img src="img/fifa.jpg" class="topImage fade" />
    <img src="img/r&c.jpg" class="topImage fade" />
    <img src="img/ff15.jpg" class="topImage fade" />
    <img src="img/hzd.jpg" class="topImage fade" />

    <script>
    // Automatic slideshow, learnt from https://www.w3schools.com/w3css/w3css_slideshow.asp. Thanks W3Schools ! :D

    // set initial slideshow index, and get images
    var slideIndex = 0;
    slideshow();

    function slideshow() {
      var i;
      // Get images from their class name
      // iterate through images
      var images = document.getElementsByClassName('topImage');

      for (i = 0; i < images.length; i++) {
        images[i].style.display = 'none';
      }
      slideIndex++;
      // Once we have looped through all images, reset the number
      if (slideIndex > images.length) {
        slideIndex = 1
      }
      // display as block
      images[slideIndex-1].style.display = 'block';
      // change image every 4 seconds
      setTimeout(slideshow, 10000);
    }
    </script>
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
    if(empty($_SESSION['cart'])) {
        ?>
        <div class='emptyCart'>
          Your cart is empty.<br />):
        </div>
        <?php
    }
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
    // Calculate price from our prices in session
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
          <!-- Get game and quantity from PHP session -->
          <input type="text" name="quantity[<?php echo $row['gameID'] ?>]" size="5" value="<?php echo $_SESSION['cart'][$row['gameID']]['quantity'] ?>" />
        </div>
      </td>
    <?php
    if( $totalPrice == 0) {
      echo $totalPrice;
    }
    // Split 3 games per row
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
  }
  // Keep the price in session
   $_SESSION['price'] = $totalPrice;

?>
