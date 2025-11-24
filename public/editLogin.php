<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <?PHP
    session_start();

    if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 600) {
     session_unset(); // unset $_SESSION variable 
     session_destroy(); // destroy session data in storage
     header("Location: index.php"); // redirect to login page
    }
    $_SESSION['last_activity'] = time(); // update last activity time stamp
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    $_SESSION['toUpdate'] = $_POST['site'];
    echo'
    <div id="main">
        <h1>MyPass</h1>
        <hr> 
        <h2>Update Login:'.$_POST['site'].'</h2>        
        <form action="editSave.php" method="post">
            <input type="hidden" name="type" id="type" value="login">

            <label for="">siteName:</label>
            <input type="text" id="siteName" name="siteName" maxlength="30" value='.$_POST['site'].'><br>

            <label for="">username:</label>
            <input type="text" id="username" name="username" maxlength="20" value='.$_POST['siteUN'].'><br>

            <label for="">password:</label>
            <input type="text" id="password" name="password" maxlength="20" value='.$_POST['pw'].'><br>

            <label for="">url:</label>
            <input type="text" id="url" name="url" maxlength="75" value='.$_POST['url'].'><br>

            <input type="submit" value="Update Login"><br>        
        </form>
    </div>
    '
    ?>
</body>
</html>