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
        session_start();
        include '../src/user.php';
        
        $u = User::getInstance();
        if (isset($_POST['signin'])) {
            $u->signIn();
        }
        else if (isset($_POST['create'])) {
            $u->createNewAccount();
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
            <input type="text" id="username" name="username" maxlength="12" value=""><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" maxlength="32" value=""><br>

            <input type="hidden" name="signin" value="true">

            <input type="submit" value="Submit"><br>
        </form> 
        <hr>
        <h2>Create New Account:</h2>
        <form action="index.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="newUsername" name="newUsername" maxlength="12" value=""><br>

            <label for="password">Password:</label>
            <input type="password" id="newPassword" name="newPassword" maxlength="32" value=""><br>

            <label for="rep_password">Repeat Password:</label>
            <input type="password" id="rep_password" name="rep_password" maxlength="32" value=""><br>

            <label for="Security Question 1: ">First Pets Name:</label>
            <input type="text" id="answer1" name="answer1" maxlength="30" value=""><br>

            <label for="Security Question 2: ">Elementary School:</label>
            <input type="text" id="answer2" name="answer2" maxlength="30" value=""><br>

            <label for="Security Question 3: ">Mothers Maiden Name:</label>
            <input type="text" id="answer3" name="answer3" maxlength="30" value=""><br>

            <input type="hidden" name="create" value="true">

            <input type="submit" value="Create New Account"><br>        
        </form>
        <hr>
        <a href="forgotPasswordHandler.html">Forgot Password</a>        
    </div>
</body>
</html>