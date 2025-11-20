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
    error_reporting(E_ALL);
    ini_set('display_errors',1);
     // singleton class
    class User{
        private $username;
        private $password;
        function __construct($u, $p){
            $this->username = $u;
            $this->password = $p;
        }
        function getUsername(){
            return $this->username;
        }
        function getPassword(){
            return $this->password;
        }
    }
    //Mediator
    class UIManager{
        function printTable(){
            //code here
        }
        function printTable_unmaskElement($elementToUnmask){
            //code here
        }
    }
    //assign variables | singleton implmentation
    if(!isset($_SESSION["user"])){
        $_SESSION["user"] = new User(htmlspecialchars($_POST['username']),htmlspecialchars($_POST['password']));
    }
    // Create connection to database
    try {
      $conn = new PDO("sqlite:myPass.db");
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }  

    // For successful login:
    // run the oberserver pattern with the username and password as arguments
    // On logout, delete the session

    $login = $conn->prepare("SELECT * FROM user WHERE username=?");
    $login->execute([$_SESSION["user"]->getUsername()]);
    $login = $login->fetch();     

    if($_SESSION["user"]->getUsername() == $login['username'] && $_SESSION["user"]->getPassword() == $login['masterPassword'])
    {
    echo '
        <div id="main">
            <h1>MyPass</h1><hr>
            <h2>Saved Items</h2>

            <hr>
        ';
    //echo output of observer pattern here | TODO
    echo '
        <h2>New Item:</h2>
            <form action="#.php" method="post">

                <input type="submit" value="Create New Item"><br>        
            </form>
            <hr>
            <a href="index.php">Logout</a>              
        </div>
    '; 
    }
    // For Unsuccessful Logins
    else{
    echo '
        <div id="main">
            <h1>MyPass</h1><hr>
            <h2>Unsuccessful Login</h2>
            <hr>
                <a href="index.php">Login Screen</a> 
            <hr>
            <h2>Create New Account:</h2>
                <form action="newUser.php" method="post">
                    <label for="username">Username:</label>
                    <input type="text" id="newUsername" name="newUsername" value=""><br>

                    <label for="password">Password:</label>
                    <input type="newPassword" id="newPassword" name="newPassword" value=""><br>

                    <label for="rep_password">Repeat Password:</label>
                    <input type="rep_password" id="rep_password" name="rep_password" value=""><br>

                    <label for="Security Question 1: ">Security Question 1:</label>
                    <input type="text" id="answer1" name="answer1" value=""><br>

                    <label for="Security Question 2: ">Security Question 2:</label>
                    <input type="text" id="answer2" name="answer2" value=""><br>

                    <label for="Security Question 3: ">Security Question 3:</label>
                    <input type="text" id="answer3" name="answer3" value=""><br>

                    <input type="submit" value="Create New Account"><br>        
                </form>
            <hr>
            <a href="forgotPasswordHandler.html">Forgot Password</a> 
        ';        
    }
    ?>

    <!--
    example of php class structure:
        class className{
            public $temp;
            function set_temp($temp2) {
              $this->temp = $temp2;
            }
            function get_temp() {
                return $this->temp;
            }
        }

    how to make a query and get a row:
        $user = $conn->query("SELECT * FROM login WHERE username='hayden'")->fetch();
    how to get a specific column in a row:
        $pass = $user['masterPassword'];
    How to make query's in PHP:
    https://www.w3schools.com/php/php_mysql_connect.asp 
    -->
</body>
</html>

