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
        <h2>Update Identification:'.$POST["idNum"].'</h2>        
        <form action="editSave.php" method="post">
            <input type="hidden" name="type" id="type" value="Identification">

            <label for="">Identification:</label>
            <input type="text" id="idNum" name="idNum" maxlength="19" value='.$POST["idNum"].'><br>

            <label for="">Type:</label>
            <input type="text" id="idType" name="idType" maxlength="15" value='.$POST["type"].'><br>

            <label for="">Expiration:</label>
            <input type="date" id="expiration" name="expiration" value='.$POST["exp"].'><br>
 
            <input type="submit" value="Submit New Identification"><br>
        </form>
    </div>
    '
    ?>
</body>
</html>