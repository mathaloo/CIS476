<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?PHP
    //Mediator
    class UIManager{
        
        function printTable($query){
            //code here
        }
        function printTable_unmaskElement($query, $elementToUnmask){
            //code here
        }
    }

    $servername = "localhost";
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']); 
    // Create connection
    try {
      $conn = new PDO("sqlite:myPass.db");
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }  

    echo "<br>".$pass."here2<br>";

    // For successful login:
    // run the oberserver pattern with the username and password as arguments
    // On logout, delete the session
    echo '
        <div id="main">
            <h1>MyPass</h1><hr>
            <h2>Saved Items</h2>

            <hr>
        ';
    //echo output of observer pattern here.
    echo '
        <h2>New Item:</h2>
            <form action="#.php" method="post">

                <input type="submit" value="Create New Item"><br>        
            </form>
            <hr>
            <a href="index.html">Logout</a>              
        </div>
    ';
    
    // For Unsuccessful Logins
    echo '
        <div id="main">
            <h1>MyPass</h1><hr>
            <h2>Unsuccessful Login</h2>
            <hr>
                <a href="index.html">Login Screen</a> 
            <hr>
            <h2>Create New Account:</h2>
                <form action="newUser.php" method="post">
                    <label for="username">Username:</label>
                    <input type="text" id="newUsername" name="newUsername" value=""><br>

                    <label for="password">Password:</label>
                    <input type="newPassword" id="newPassword" name="newPassword" value=""><br>

                    <label for="rep_password">Repeat Password:</label>
                    <input type="rep_password" id="rep_password" name="rep_password" value=""><br>

                    <input type="submit" value="Create New Account"><br>        
                </form>
            <hr>
            <a href="forgotPasswordHandler.html">Forgot Password</a> 
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
        $user = $conn->query("SELECT * FROM login WHERE username='hayden'")->fetch();
    how to get a specific column in a row:
        $pass = $user['masterPassword'];
    How to make query's in PHP:
    https://www.w3schools.com/php/php_mysql_connect.asp 
    -->
</body>
</html>

