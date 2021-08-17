<?php
$user = '';
$pass = '';
$error_msg = "Login Invalid";
if(isset($_POST['login_submit'])){
    session_start();
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if(empty($user)){
        echo nl2br("Blank Username \n");
        echo $error_msg;
    } else if($pass){
        echo nl2br("Blank Password \n");
        echo $error_msg;

    } else {
        
        //SQL:
        $query = $conn->prepare("SELECT * FROM login WHERE user = :u AND password = :p");
        $query->bindParam(':u',$user);
        $query->bindParam(':p',$pass);

        //Execute:
        $query->execute();

        $number_rows = $query->fetch(PDO::FETCH_NUM);
        echo $number_rows;

        if($number_rows>0){
            echo $user;
            $_SESSION['usern'] = $user;
            $_SESSION['passw'] = $pass;
            header("Location: home.php");
        } else {
            echo "Invalid Username or Password";
            header("Location: index.php");
        }
    }
}
?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Rackspace</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/custom.css">
</head>

<body>
<form action="" method="post" name="login">
<input type="text" name="username" placeholder="Enter Username"/>
<input type="text" name="password" placeholder="Enter Password"/>
<input type="submit" name="login_submit" value="Login"/>

</form>
</body>
</html>