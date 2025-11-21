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
        error_reporting(E_ALL);
        ini_set('display_errors',1);

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
        
        // if username doesnt't exist
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
                <br>
                <a href="index.php">Back to Login Page</a> 
                </div>';
        }
    ?>
</body>
</html>