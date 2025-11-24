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
    require_once '../src/user.php';
    error_reporting(E_ALL);
    ini_set('display_errors',1);

    try {
      $conn = new PDO("sqlite:../myPass.db");
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }

    // SUBSCRIBE/UNSUBCRIBE FROM USER PASSWORD NOTIFICATIONS
    $u = User::getInstance();

    $subbed = $u->subbed;
    if (isset($_POST['sub'])) {
        if ($_POST['sub'] === "unsub") {
            /*update db
            $stmt = $conn->prepare("UPDATE user SET notify=? WHERE username=?");
            $stmt->execute(['0', $u->getUsername()]);
            */
            $subbed = false;
            $_SESSION['notify'] = $subbed;
        }
        if ($_POST['sub'] === "resub") {
            /*update db
            $stmt = $conn->prepare("UPDATE user SET notify=? WHERE username=?");
            $stmt->execute(['1', $u->getUsername()]);
            */
            $subbed = true;
            $_SESSION['notify'] = $subbed;
        }
    }

    // DISPLAY
    echo'
    <div id="main">
        <h1>MyPass</h1>
        <hr>
        <a href="homepage.php">Homepage</a>
        <h2>Update Master Password:</h2>        
        <form action="editSave.php" method="post">
            <input type="hidden" name="type" id="type" value="masterPassword">

            <label for="">Current Master Password:</label>
            <input type="password" id="masterPassword" name="masterPassword" maxlength="30" value=""><br>

            <label for="password">Password:</label>
            <input type="password" id="newPassword" name="newPassword" value=""><br>

            <label for="rep_password">Repeat Password:</label>
            <input type="password" id="rep_password" name="rep_password" value=""><br>
            
            <input type="submit" value="Update"><br>

            ';
            if ($subbed) {
                echo '<form action="editMasterPassword.php" method="post">
                    <button type="submit" name="sub" value="unsub">Unsub</button>
                </form>
                ';
            }
            else {
                echo '<form action="editMasterPassword.php" method="post">
                    <button type="submit" name="sub" value="resub">Resub</button>
                </form>
                ';
            }
            echo'
        </form>
    </div>
    '
    ?>
</body>
</html>