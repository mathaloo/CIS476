<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?PHP
        session_start();
        error_reporting(E_ALL);
        // We get a warning when set to 1, but functionality remains the same. Turn to 0 before turn in
        ini_set('display_errors',1);
        session_unset();
        session_destroy();
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
        // Create connection to database
        try {
          $conn = new PDO("sqlite:myPass.db");
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          echo "Connected successfully";
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }  
        $login = $conn->prepare("SELECT * FROM user WHERE username=?");
        if(isset($_POST['username']) && isset($_POST['password'])){
            $login->execute([htmlspecialchars($_POST['username'])]);
            $login = $login->fetch();
            session_start();     
            if(htmlspecialchars($_POST['username']) == $login['username'] && htmlspecialchars($_POST['password']) == $login['masterPassword']){
                //assign variables | singleton implmentation
                if(!isset($_SESSION["user"])){
                    $_SESSION["user"] = new User($login['username'], $login['masterPassword']);
                    echo "here";
                    header("location: homepage.php");
                    echo "here2";
                    die();
                }
            } else {
                echo "
                <br>
                Incorrect Password or User does not Exist
                ";
            }
        }
    ?>
    <!--

    -->
    <div id="main">
        <h1>MyPass</h1>
        <hr>
        <h2>Login:</h2>
        <form action="index.php" method="post">           
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value=""><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value=""><br>

            <input type="submit" value="Submit"><br>
        </form> 
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
    </div>
</body>
</html>