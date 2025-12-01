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
    ini_set('display_errors',0);
    ?>
    <div id="main">
        <h1>MyPass</h1>
        <hr> 
        <h2>New Secure Note:</h2>        
        <form action="saveItem.php" method="post">
            <input type="hidden" name="type" id="type" value="Secure_Notes">

            <label for="">Note Name:</label>
            <input type="text" id="noteName" name="noteName" maxlength="10" value=""><br>

            <label for="">Note:</label>
            <textarea id="note" name="note" maxlength="1000" value=""></textarea>
          
            <input type="submit" value="Submit New Secure Note"><br>        
        </form>
    </div>
</body>
</html>