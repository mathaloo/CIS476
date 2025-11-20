<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?PHP
    $username = htmlspecialchars($_POST['username']);
    $answer1 = htmlspecialchars($_POST['answer1']);
    $answer2 = htmlspecialchars($_POST['answer2']);  
    $answer3 = htmlspecialchars($_POST['answer3']);
    //run py program here | chain or responsibilty | TODO
    ?>
    <p>
        <a href="index.php">Homepage</a>
    </p>
</body>
</html>