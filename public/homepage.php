<?php
    session_start();
    require '../src/user.php';
    require '../src/vaultElements.php';
    //require '../src/observers.php';
    require '../src/pswdGenerator.php';
    error_reporting(E_ALL);
    ini_set('display_errors',1);

    // Create connection to database
    try {
      $conn = new PDO("sqlite:../myPass.db");
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    } 

    if (!isset($_SESSION['revealedLogins'])) {
        $_SESSION['revealedLogins'] = array();
    }
    $revealedLogins = $_SESSION['revealedLogins'];

    // ACTIONS TAKE PLACE (edit, delete, unsub saved through post methods)

?>
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
    echo '
        <div id="main">
            <h1>MyPass</h1><hr>
            <h2>Saved Items</h2>

            <hr>
            <h2>Generated Password:</h2>
        ';
    //echo output of observer pattern here | TODO

    //GENERATE PASSWORD AND DISPLAY
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
    
    <!-- OTHER DISPLAY -->
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
    
    // GETTING USER INFO
    $u = User::getInstance();

    // INITIALIZE AND DISPLAY LOGINS
    $stmt = $conn->prepare("SELECT * FROM login WHERE u_User=?");
    $stmt->execute([$u->getUsername()]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $pswdObs = array();  // for keeping track of weak passwords

    echo '<table>
            <thead>
                <tr>
                    <th>Website</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>URL</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            <thead>
            <tbody>';
            foreach ($rows as $row) {
                $pw =  $row['password'];
                $un =  $row['username'];
                $site =  $row['siteName'];
                $url =  $row['url'];
                // need to add $sub = $row['sub'];   // for if user wants the item to be get observer notifications
        
                $rl = new RealLogin($pw, $un, $site, $url);
                //add sub condition (does not make observer if not needed)
                $obs = new PswdObserver();
                $rl->regObs($obs);
                $rl->notify();
                if ($obs->weakPassword()) {
                    $pswdObs[] = $obs;
                }
                // add condition for if reveal is true or not (check by site since it is unique)
                $pl = new ProxyLogin($rl, false);

                echo '<tr>';   // start of table row
                echo "{$pl->display()}";
                // echo button forms here. get from notepad and put in a table column
                echo '<td>
                    <form action="homepage.php" method="post">
                        <input type="hidden" name="site" value="' . $site . '">
                        <button type="submit" name="reveal" value="true">Unhide</button>
                    </form>
                </td>
                <td>
                    <form action="homepage.php" method="post">
                        <input type="hidden" name="site" value="' . $site . '">
                        <input type="hidden" name="uname" value="' . $u->getUsername() . '">
                        <button type="submit" name="sub" value="unsub">Unsub</button>
                    </form>
                </td>
                <td>
                    <form action="#" method="post">
                        <input type="hidden" name="siteUN" value="' . $un . '">
                        <input type="hidden" name="pw" value="' . $pw . '">
                        <input type="hidden" name="site" value="' . $site . '">
                        <input type="hidden" name="url" value="' . $url . '">
                        <input type="hidden" name="uname" value="' . $u->getUsername() . '">
                        <button type="submit" name="edit" value="true">Edit</button>
                    </form>
                </td>
                <td>
                    <form action="homepage.php" method="post">
                        <input type="hidden" name="site" value="' . $site . '">
                        <input type="hidden" name="uname" value="' . $u->getUsername() . '">
                        <button type="submit" name="delete" value="true">Delete</button>
                    </form>
                </td>
                </tr>';  // end of table row
            }
            echo '</tbody>
        </table>';
    foreach ($pswdObs as $o) {   // get observer messages
        $o->display();
    }

    // INITIALIZE AND DISPLAY CREDIT CARDS
    $stmt = $conn->prepare("SELECT * FROM Credit_Card WHERE u_User=?");
    $stmt->execute([$u->getUsername()]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $ccObs = array();  // for keeping track of weak passwords

    echo '<table>
            <thead>
                <tr>
                    <th>Row#</th>
                    <th>Card Holder</th>
                    <th>Card Number</th>
                    <th>CVV</th>
                    <th>Type</th>
                    <th>Expiration Date</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            <thead>
            <tbody>';
            $itemID = 1;   // for identifying rows by row number
            foreach ($rows as $row) {
                $cn =  $row['cardNum'];
                $cvv =  $row['cvv'];
                $name =  $row['nameOnCard'];
                $exp =  $row['expiration'];
                $zip =  $row['zip'];
                // need to add $sub = $row['sub'];   // for if user wants the item to be get observer notifications
        
                $rcc = new RealCreditCard($cn, $cvv, $name, $exp, $zip, $itemID);
                //add sub condition (does not make observer if not needed)
                $obs = new ExpObserver();
                $rcc->regObs($obs);
                $rcc->notify();
                if ($obs->expired()) {
                    $ccObs[] = $obs;
                }
                // add condition for if reveal is true or not (check by card num since it is unique)
                $pcc = new ProxyCreditCard($rl, $itemID, false);

                echo '<tr>';   // start of table row
                echo "{$pcc->display()}";
                // echo button forms here. get from notepad and put in a table column
                echo '<td>
                    <form action="homepage.php" method="post">
                        <input type="hidden" name="site" value="' . $cn . '">
                        <button type="submit" name="reveal" value="true">Unhide</button>
                    </form>
                </td>
                <td>
                    <form action="homepage.php" method="post">
                        <input type="hidden" name="site" value="' . $cn . '">
                        <button type="submit" name="sub" value="unsub">Unsub</button>
                    </form>
                </td>
                <td>
                    <form action="#" method="post">
                        <input type="hidden" name="cardNum" value="' . $cn . '">
                        <input type="hidden" name="cvv" value="' . $cvv . '">
                        <input type="hidden" name="name" value="' . $name . '">
                        <input type="hidden" name="exp" value="' . $exp . '">
                        <input type="hidden" name="zip" value="' . $zip . '">
                        <input type="hidden" name="uname" value="' . $u->getUsername() . '">
                        <button type="submit" name="edit" value="true">Edit</button>
                    </form>
                </td>
                <td>
                    <form action="homepage.php" method="post">
                        <input type="hidden" name="site" value="' . $cn . '">
                        <button type="submit" name="delete" value="true">Delete</button>
                    </form>
                </td>
                </tr>';  // end of table row
                $itemID++;
            }
            echo '</tbody>
        </table>';
    foreach ($ccObs as $o) {
        $o->display();
    }

    // INITIALIZE AND DISPLAY IDs
    $stmt = $conn->prepare("SELECT * FROM Identification WHERE u_User=?");
    $stmt->execute([$u->getUsername()]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $idObs = array();  // for keeping track of weak passwords

    echo '<table>
            <thead>
                <tr>
                    <th>Row#</th>
                    <th>ID Number</th>
                    <th>Type</th>
                    <th>Expiration Date</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            <thead>
            <tbody>';
            $itemID = 1;   // for identifying rows by row number
            foreach ($rows as $row) {
                $id =  $row['idNum'];
                $t =  $row['type'];
                $exp =  $row['expiration'];
                // need to add $sub = $row['sub'];   // for if user wants the item to be get observer notifications
        
                $ri = new RealID($id, $exp, $t, $itemID);
                //add sub condition (does not make observer if not needed)
                $obs = new ExpObserver();
                $ri->regObs($obs);
                $ri->notify();
                if ($obs->expired()) {
                    $idObs[] = $obs;
                }
                // add condition for if reveal is true or not (check by card num since it is unique)
                $pid = new ProxyID($rl, $itemID, false);

                echo '<tr>';   // start of table row
                echo "{$pid->display()}";
                // echo button forms here. get from notepad and put in a table column
                echo '<td>
                    <form action="homepage.php" method="post">
                        <input type="hidden" name="site" value="' . $id . '">
                        <button type="submit" name="reveal" value="true">Unhide</button>
                    </form>
                </td>
                <td>
                    <form action="homepage.php" method="post">
                        <input type="hidden" name="site" value="' . $id . '">
                        <button type="submit" name="sub" value="unsub">Unsub</button>
                    </form>
                </td>
                <td>
                    <form action="#" method="post">
                        <input type="hidden" name="cardNum" value="' . $id . '">
                        <input type="hidden" name="cvv" value="' . $t . '">
                        <input type="hidden" name="name" value="' . $exp . '">
                        <input type="hidden" name="uname" value="' . $u->getUsername() . '">
                        <button type="submit" name="edit" value="true">Edit</button>
                    </form>
                </td>
                <td>
                    <form action="homepage.php" method="post">
                        <input type="hidden" name="site" value="' . $id . '">
                        <button type="submit" name="delete" value="true">Delete</button>
                    </form>
                </td>
                </tr>';  // end of table row
                $itemID++;
            }
            echo '</tbody>
        </table>';
    foreach ($idObs as $o) {
        $o->display();
    }

    // INITIALIZE AND DISPLAY SECURE NOTES
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

