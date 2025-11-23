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
    $_SESSION['toUpdate'] = $_POST["nName"];
    echo'
    <div id="main">
        <h1>MyPass</h1>
        <hr> 
        <h2>Update Secure Note:'.$_POST["nName"].'</h2>        
        <form action="editSave.php" method="post">
            <input type="hidden" name="type" id="type" value="Secure_Notes">

            <label for="">Note Name:</label>
            <input type="text" id="noteName" name="noteName" maxlength="10" value='.$_POST["nName"].'><br>

            <label for="">Note:</label>
            <textarea id="note" name="note" maxlength="1000" value="">'.$_POST["note"].'</textarea>

            <input type="submit" value="Update New Secure Note"><br>        
        </form>
    </div>
    '
    ?>
</body>
</html>