<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    ini_set('display_errors',0);
    $table = htmlspecialchars($_POST['type']);
    include '../src/user.php';
    $u = User::getInstance();
    try {
      $conn = new PDO("sqlite:../myPass.db");
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    } 
    if($table == "login"){
        $login = $conn->prepare("INSERT INTO login (siteName, username, password, url, u_User) VALUES (?,?,?,?,?)");
        $login->execute([$_POST['siteName'],$_POST['username'],$_POST['password'], $_POST['url'], $u->getUsername()]);
    }else if($table == "Identification"){
        $login = $conn->prepare("INSERT INTO Identification (idNum, type, expiration, u_User) VALUES (?,?,?,?)");
        $login->execute([$_POST['idNum'],$_POST['idType'],$_POST['expiration'], $u->getUsername()]);
    }else if($table == "Credit_Card"){
        $login = $conn->prepare("INSERT INTO Credit_Card (cardNum, cvv, nameOnCard, expiration, zip, u_User) VALUES (?,?,?,?,?,?)");
        $login->execute([$_POST['cardNum'],$_POST['cvv'], $_POST['nameOnCard'],$_POST['expiration'], $_POST['zip'], $u->getUsername()]);
    }else if($table == "Secure_Notes"){
        $login = $conn->prepare("INSERT INTO Secure_Notes (noteName, note, u_User) VALUES (?,?,?)");
        $login->execute([$_POST['noteName'],$_POST['note'], $u->getUsername()]);
    }
    header("location: homepage.php");
    die();
    ?>
    <a href="homepage.php">If you do not get redirected to the homepage, click here</a>
</body>
</html>