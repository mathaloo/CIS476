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
    
    // For New Logins: 
    // redirect to a form asking for 3 security questions
    // create the row in the database
    // redirect to index.html
    
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

    How to make query's in PHP:
    https://www.w3schools.com/php/php_mysql_connect.asp 
    -->
</body>
</html>

