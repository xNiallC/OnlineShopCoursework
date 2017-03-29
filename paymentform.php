<!DOCTYPE html>
<?php
  session_start();
 ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CurtisGames.co.uk - Payment Form</title>
    <link rel="stylesheet" type="text/css" href="stylesheetPAYMENT.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="fonts/css/font-awesome.min.css">
    <script type="text/javascript">
        // Fields:
        // Card number, must be 16 digits
        // Expiration Date, equal or greater than 2017, not empty, month integer between 1-12
        // Cardholder's name, not empty
        // Security code, 3 digit number
        var count = 0;

        // This function initialised a p element to be edited on body if one doesn't exist
        function initialise(inputText, nodeId) {
            var p = document.createElement("p");
            var node = document.getElementById(nodeId);
            var text = document.createTextNode(inputText);
            p.appendChild(text);
            node.appendChild(p);
        }

        // Edit the p element with item of our choosing, or initialise if not available
        function editText(inputText, nodeId) {
            var node = document.getElementById(nodeId);
            if (node.hasChildNodes() == false) {
                initialise('', nodeId);
            }
            var text = document.createTextNode(inputText);
            var childNodes = node.childNodes[0];
            node.replaceChild(text, childNodes);
        }

        // Simple Jscript form validation
        function validateForm() {
            // Get all our values from the form
            var number = document.forms["form"]["cardNumber"].value;
            var expMonth = document.forms["form"]["expirationMonth"].value;
            var expYear = document.forms["form"]["expirationYear"].value;
            var name = document.forms["form"]["cardName"].value;
            var code = document.forms["form"]["cvc"].value;

            if (count == 1) {
                editText('', 'cN');
                editText('', 'eM');
                editText('', 'eY');
                editText('', 'cN2');
                editText('', 'secCode');
                count--;
            }

            if (number.length != 16 || !(number > 0)) {
                editText('Card number must be 16-digits long.\n', 'cN');
            }
            if (1 > parseInt(expMonth) || parseInt(expMonth) > 12 || isNaN(expMonth) || expMonth != parseInt(expMonth)|| expMonth.length > 2 || expMonth.length == 0) {
                editText('Month must be a number between 1 and 12.\n', 'eM');
            }
            if (expYear <= 2017 || isNaN(expYear) || expYear != parseInt(expYear)|| expYear.length != 4) {
                editText('Year must be a 4-digit year, equal or greater than 17.\n', 'eY');
            }
            if (name == "" || name == "Name on Card") {
                editText('Name field must be correctly filled out.', 'cN2');
            }
            if (code.length != 3 || !(code > 0) || !(code < 1000)) {
                editText('CVC must be a 3 digit long number.\n', 'secCode');
            }
            count++;
            return false;
        }


    </script>
</head>
<body id="body" onLoad="initialise(' ', 'body')">
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

    <p class="enterDetails">
        Please Enter Card Details:
    </p>



    <form id="form" name="form" onSubmit="return validateForm()">
        <div class="formElement">
        <input id="cardNumber" name="cardNumber" type="text" placeholder="Card Number" onFocus="editText('16-digit number on front of card.', 'helpArea')" onBlur="editText(' ', 'helpArea')">
        <p id="cN"></p>
        <br />
        </div>
        <div class="formElement">
        <input id="expirationMonth" name="expirationMonth" placeholder="MM" onFocus="editText('Month of Expiration Date.', 'helpArea')" onBlur="editText(' ', 'helpArea')">
        <p id="eM"></p>
        <br />
        </div>
        <div class="formElement">
        <input id="expirationYear" name="expirationYear" placeholder="YYYY" onFocus="editText('Year of Expiration Date.', 'helpArea')" onBlur="editText(' ', 'helpArea')">
        <p id="eY"></p>
        <br />
        </div>
        <div class="formElement">
        <input id="cardName" name="cardName" type="text" placeholder="Name on Card" onFocus="editText('Full cardholder name on front of card.', 'helpArea')" onBlur="editText(' ', 'helpArea')">
        <p id="cN2"></p>
        <br />
        </div>
        <div class="formElement">
        <input id="cvc" name="cvc" type="text" placeholder="CVC" onFocus="editText('3-digit security code on back of card.', 'helpArea')" onBlur="editText(' ', 'helpArea')">
        <p id="secCode"></p>
        <br />
        </div>
        <p id="helpArea" style="height: 15px;"></p>
        <hr class="rule" />
        <p style="text-align: center;">
          Please confirm before submitting: <br /><br />
          Total Price: <strong>£<?php echo $_SESSION['price']; ?></strong>
        </p>
        <br />
        <input id="submit" type="submit">
        <br />


    </form>
</body>
</html>
