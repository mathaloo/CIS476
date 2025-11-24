<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?PHP
    session_start();
    session_start();

    if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 600) {
     session_unset(); // unset $_SESSION variable 
     session_destroy(); // destroy session data in storage
     header("Location: index.php"); // redirect to login page
    }
    $_SESSION['last_activity'] = time(); // update last activity time stamp
    error_reporting(E_ALL);
    ini_set('display_errors',1);

    ?>
    <div id="main">
        <h1>MyPass</h1>
        <hr> 
        <h2>New Credit Card:</h2>        
        <form action="saveItem.php" method="post">
            <input type="hidden" name="type" id="type" value="Credit_Card">

            <label for="">Card Number:</label>
            <input type="text" id="cardNum" name="cardNum" maxlength="16" value=""><br>

            <label for="">CVV:</label>
            <input type="text" id="cvv" name="cvv" maxlength="4" value=""><br>

            <label for="">Name on Card:</label>
            <input type="text" id="nameOnCard" name="nameOnCard" maxlength="26" value=""><br>

            <label for="">Expiration:</label>
            <input type="date" id="expiration" name="expiration" maxlength="10" value=""><br>

            <label for="">Zipcode:</label>
            <input type="text" id="zip" name="zip" maxlength="5" value=""><br>

            <input type="submit" value="Submit Credit Card"><br>        
        </form>
    </div>
</body>
</html>