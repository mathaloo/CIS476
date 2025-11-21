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
    interface ForgotPasswordHandler{
        public function checkSQ($username, $SQA):string;
    }
    class SQ1Handler implements ForgotPasswordHandler{
        private $databaseLoc;
        public function checkSQ($username, $SQA) : string {
            $conn = new PDO("sqlite:".$this->databaseLoc);
            $login = $conn->prepare("SELECT * FROM user WHERE username=?");
            $login->execute([$username]);
            $login = $login->fetch();
            if($login['SQA1'] == $SQA["0"]){
                $temp = new SQ2Handler($this->databaseLoc);
                return $temp->checkSQ($username,$SQA);
            }
            else {
                return "Security Question 1 Failed";
            }
        }
        public function __construct($dbloc){
            $this->databaseLoc = $dbloc;
        }
    }
    class SQ2Handler implements ForgotPasswordHandler{
        private $databaseLoc;
        public function checkSQ($username, $SQA) : string {
            $conn = new PDO("sqlite:".$this->databaseLoc);
            $login = $conn->prepare("SELECT * FROM user WHERE username=?");
            $login->execute([$username]);
            $login = $login->fetch();
            if($login['SQA2'] == $SQA["1"]){
                $temp = new SQ3Handler($this->databaseLoc);
                return $temp->checkSQ($username,$SQA);
            }
            else {
                return "Security Question 2 Failed";
            }
        }
        public function __construct($dbloc){
            $this->databaseLoc = $dbloc;
        }
    }   
    class SQ3Handler implements ForgotPasswordHandler{

        private $databaseLoc;
        public function checkSQ($username, $SQA) : string {
            $conn = new PDO("sqlite:".$this->databaseLoc);
            $login = $conn->prepare("SELECT * FROM user WHERE username=?");
            $login->execute([$username]);
            $login = $login->fetch();
            if($login['SQA3'] == $SQA["2"]){
                return "Your master password is: ".$login['masterPassword'];
            }
            else {
                return "Security Question 3 Failed";
            }
        }
        public function __construct($dbloc){
            $this->databaseLoc = $dbloc;
        }
    }

    //client code 
    $databaseLoc = "../myPass.db";
    $username = htmlspecialchars($_POST['username']);
    $answers = array(htmlspecialchars($_POST['answer1']),htmlspecialchars($_POST['answer2']),htmlspecialchars($_POST['answer3']));
    $SQ1H = new SQ1Handler($databaseLoc);
    echo "<div id='main'>";
    echo $SQ1H->checkSQ($username,$answers)
    ?>
    <p>
        <a href="index.php">Homepage</a>
    </p>
    </div>  
</body>
</html>