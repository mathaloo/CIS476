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
    require '../src/pswdGenerator.php';
    // Create connection to database
    try {
      $conn = new PDO("sqlite:../myPass.db");
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }  

    echo '
        <div id="main">
            <h1>MyPass</h1><hr>
            <h2>Saved Items</h2>

            <hr>
            <h2>Generated Password:</h2>
        ';
    //echo output of observer pattern here | TODO
    $passwordBuilder = new director();
    $weakPass = new weakPassword();
    $medPass = new medPassword();
    $strongPass = new strongPassword();
    if(empty($_POST['passType']) || !isset($_POST['passType']) || $_POST['passType'] == 'weakPass'){
        echo $passwordBuilder->buildPassword($weakPass);
    }else if($_POST['passType'] == 'medPass'){
        echo $passwordBuilder->buildPassword($medPass);
    }else if($_POST['passType'] == 'strongPass'){
        echo $passwordBuilder->buildPassword($strongPass);
    }
    echo "<br><br>";
    ?>
        <form action="homepage.php" method="post">
            <label for="passType">Password Strength:</label>
            <select name="passType" id="passType">
                <option value="weakPass">Weak</option>
                <option value="medPass">Medium</option>
                <option value="strongPass">Strong</option>
            </select>
            <input type="submit" value="Submit">
        </form>
    <?PHP
    echo '
        <hr>
        <h2>New Item:</h2>
            <a href="newLogin.php">Login</a><br>                          
            <a href="newID.php">Identification Card</a><br>
            <a href="newCC.php">Credit Card</a><br>  
            <a href="newNote.php">Note</a><br>                             
            <hr>
            <a href="index.php">Logout</a>              
        </div>
    ';       
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
        $user = $conn->query("SELECT * FROM login WHERE u_User")->fetch();
    how to get a specific column in a row:
        $pass = $user['masterPassword'];
    How to make query's in PHP:
    https://www.w3schools.com/php/php_mysql_connect.asp 
    -->
</body>
</html>

