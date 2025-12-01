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
        $login = $conn->prepare("DELETE FROM login WHERE siteName=? AND u_User=?");
        $login->execute([$_SESSION['toUpdate'],$u->getUsername()]);
        $login = $conn->prepare("INSERT INTO login (siteName, username, password, url, u_User) VALUES (?,?,?,?,?)");
        $login->execute([$_POST['siteName'],$_POST['username'],$_POST['password'], $_POST['url'], $u->getUsername()]);
    }else if($table == "Identification"){
        $login = $conn->prepare("DELETE FROM Identification WHERE idNum=? AND u_User=?");
        $login->execute([$_SESSION['toUpdate'],$u->getUsername()]);
        $login = $conn->prepare("INSERT INTO Identification (idNum, type, expiration, u_User) VALUES (?,?,?,?)");
        $login->execute([$_POST['idNum'],$_POST['idType'],$_POST['expiration'], $u->getUsername()]);
    }else if($table == "Credit_Card"){
        $login = $conn->prepare("DELETE FROM Credit_Card WHERE cardNum=? AND u_User=?");
        $login->execute([$_SESSION['toUpdate'],$u->getUsername()]);
        $login = $conn->prepare("INSERT INTO Credit_Card (cardNum, cvv, nameOnCard, expiration, zip, u_User) VALUES (?,?,?,?,?,?)");
        $login->execute([$_POST['cardNum'],$_POST['cvv'], $_POST['nameOnCard'],$_POST['expiration'], $_POST['zip'], $u->getUsername()]);
    }else if($table == "Secure_Notes"){
        $login = $conn->prepare("DELETE FROM Secure_Notes WHERE noteName=? AND u_User=?");
        $login->execute([$_SESSION['toUpdate'],$u->getUsername()]);
        $login = $conn->prepare("INSERT INTO Secure_Notes (noteName, note, u_User) VALUES (?,?,?)");
        $login->execute([$_POST['noteName'],$_POST['note'], $u->getUsername()]);
    }else if($table == "masterPassword"){
        if(
            $_POST["masterPassword"] == $u->getPassword() &&
            $_POST["newPassword"] == $_POST["rep_password"]
        ){
            $login = $conn->prepare("UPDATE user SET masterPassword=? WHERE username=?");
            $login->execute([$_POST["newPassword"], $u->getUsername()]);  
            header("location: index.php");
            die();
        }else{
            echo '
                <div id="main">
                Master password was incorrect or password did not match.
                <br>
                <a href="homepage.php">click here to return to homepage</a>
                </div>';
        }
    }
    header("location: homepage.php");
    die();
    ?>
    <a href="homepage.php">If you do not get redirected to the homepage, click here</a>
</body>
</html>