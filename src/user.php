<?php
require_once 'SQHandler.php';

class User{
    private $username;
    private $password;
    private static $instance = null;

    private function __construct() {
        if (!empty($_SESSION['username']) && !empty($_SESSION['password']))  {
            $this->username = $_SESSION['username'];
            $this->password = $_SESSION['password'];
        }
    }

    
    public static function getInstance(): User {
        if (self::$instance === null) {
            self::$instance = new self();
            
        }
        return self::$instance;
    }
    public function getUsername(){
        return $this->username;
    }
    public function getPassword(){
        return $this->password;
    }
    public function signIn() {
        try {
          $conn = new PDO("sqlite:../myPass.db");
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          echo "Connected successfully";
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
         $login = $conn->prepare("SELECT * FROM user WHERE username=?");
        if(!empty($_POST['username']) && !empty($_POST['password'])){
            $login->execute([htmlspecialchars($_POST['username'])]);
            $login = $login->fetch();    
            if(htmlspecialchars($_POST['username']) == $login['username'] 
               && htmlspecialchars($_POST['password']) == $login['masterPassword']){
                //assign variables | singleton implmentation
                
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['password'] = $_POST['password'];
                header("location: homepage.php");
                exit();
                
            } 
            else {
                echo "
                <br>
                Incorrect Password or User does not Exist
                ";
            }
        }
    }
    public function createNewAccount() {
        $newUsername = htmlspecialchars($_POST['newUsername']);
        $newPassword = htmlspecialchars($_POST['newPassword']);
        $rep_password = htmlspecialchars($_POST['rep_password']);
        $answer1 = htmlspecialchars($_POST['answer1']);
        $answer2 = htmlspecialchars($_POST['answer2']);
        $answer3 = htmlspecialchars($_POST['answer3']);

        try {
        $conn = new PDO("sqlite:../myPass.db");
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
        } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        }
        $login = $conn->prepare("SELECT COUNT(*) AS `total` FROM user WHERE username=?");
        $login->execute([$newUsername]);
        $login = $login->fetchObject();
        if($login->total == 0 && $newPassword == $rep_password){ // username doesnt exist
          $login = $conn->prepare("INSERT INTO user (username, masterPassword, SQA1, SQA2, SQA3) VALUES (?,?,?,?,?)");
          $login->execute([$newUsername,$newPassword,$answer1, $answer2, $answer3]);
          echo '<div id="main">
                Successful Created New User Account
                <br>
                <br>
                <a href="index.php">Back to Login Page</a> 
                </div>';
        }
        else{ //username does exist or passwords dont match
          echo '<div id="main">
                Username already exists or the Passwords did not match
                <br>
                </div>';
        }
    }
}
