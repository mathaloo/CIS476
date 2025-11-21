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
    ini_set('display_errors',1);
    $table = htmlspecialchars($_POST['type']);
    class User{
        private $username;
        private $password;
        public function __construct($u, $p){
            $this->username = $u;
            $this->password = $p;
        }
        public function getUsername(){
            return $this->username;
        }
        public function getPassword(){
            return $this->password;
        }
    }
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
        $login->execute([$_POST['siteName'],$_POST['username'],$_POST['password'], $_POST['url'], $_SESSION["user"]->getUsername()]);
    }else if($table == "Identification"){
        $login = $conn->prepare("INSERT INTO Identification (idNum, type, expiration, u_User) VALUES (?,?,?,?)");
        $login->execute([$_POST['idNum'],$_POST['idType'],$_POST['expiration'], $_SESSION["user"]->getUsername()]);
    }else if($table == "Credit_Card"){
        $login = $conn->prepare("INSERT INTO Credit_Card (cardNum, cvv, nameOnCard, expiration, zip, u_User) VALUES (?,?,?,?,?,?)");
        $login->execute([$_POST['cardNum'],$_POST['cvv'], $_POST['nameOnCard'],$_POST['expiration'], $_POST['zip'], $_SESSION["user"]->getUsername()]);
    }else if($table == "Secure_Notes"){
        $login = $conn->prepare("INSERT INTO Secure_Notes (noteName, note, u_User) VALUES (?,?,?)");
        $login->execute([$_POST['noteName'],$_POST['note'],$_SESSION["user"]->getUsername()]);
    }
    ?>
</body>
</html>