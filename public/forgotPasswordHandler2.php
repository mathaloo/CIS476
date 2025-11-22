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
    // We get a warning when set to 1 and user doesnt exist, but functionality remains the same. Turn to 0 before turn in
    ini_set('display_errors',1);
    interface ForgotPasswordHandler{
        public function checkSQ($username, $SQA):string;
    }
    class SQ1Handler implements ForgotPasswordHandler{
        private $databaseLoc;
        private $sucessor;
        public function checkSQ($username, $SQA) : string {
            $conn = new PDO("sqlite:".$this->databaseLoc);
            $checkUser = $conn->prepare("SELECT COUNT(*) AS `total` FROM user WHERE username=?");
            $checkUser->execute([$username]);
            $checkUser = $checkUser->fetchObject();
            if($checkUser->total == 1){
                $login = $conn->prepare("SELECT * FROM user WHERE username=?");
                $login->execute([$username]);
                $login = $login->fetch();
                if($login['SQA1'] == $SQA["0"]){
                    return $this->sucessor->checkSQ($username,$SQA);
                }
                else {
                    return "Security Question 1 Failed";
                }
            }else {
                return "User does not exist";
            }
        }
        public function __construct($dbloc){
            $this->databaseLoc = $dbloc;
        }
        public function setSucessor($sucessor){
            $this->sucessor = $sucessor;
        }
    }
    class SQ2Handler implements ForgotPasswordHandler{
        private $databaseLoc;
        private $sucessor;
        public function checkSQ($username, $SQA) : string {
            $conn = new PDO("sqlite:".$this->databaseLoc);
            $login = $conn->prepare("SELECT * FROM user WHERE username=?");
            $login->execute([$username]);
            $login = $login->fetch();
            if($login['SQA2'] == $SQA["1"]){
                return $this->sucessor->checkSQ($username, $SQA);
            }
            else {
                return "Security Question 2 Failed";
            }
        }
        public function __construct($dbloc){
            $this->databaseLoc = $dbloc;
        }
        public function setSucessor($sucessor){
            $this->sucessor = $sucessor; 
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
    $SQ2H = new SQ2Handler($databaseLoc);
    $SQ3H = new SQ3Handler($databaseLoc);
    $SQ1H->setSucessor($SQ2H);
    $SQ2H->setSucessor($SQ3H);
    echo "<div id='main'>";
    echo $SQ1H->checkSQ($username,$answers)
    ?>
    <p>
        <a href="index.php">Homepage</a>
    </p>
    </div>  
</body>
</html>