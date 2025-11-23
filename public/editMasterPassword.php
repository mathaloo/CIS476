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
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    echo'
    <div id="main">
        <h1>MyPass</h1>
        <hr> 
        <h2>Update Master Password:</h2>        
        <form action="editSave.php" method="post">
            <input type="hidden" name="type" id="type" value="masterPassword">

            <label for="">Current Master Password:</label>
            <input type="password" id="masterPassword" name="masterPassword" maxlength="30" value=""><br>

            <label for="password">Password:</label>
            <input type="password" id="newPassword" name="newPassword" value=""><br>

            <label for="rep_password">Repeat Password:</label>
            <input type="password" id="rep_password" name="rep_password" value=""><br>

            <input type="submit" value="Update Credit Card"><br>        
        </form>
    </div>
    '
    ?>
</body>
</html>