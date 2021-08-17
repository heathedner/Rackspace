<?php


//Connection Variables:
$dbhost = "localhost";
$dbname = "main";
$dbuser = "root";
$dbpass = 'root$plinzedous0n';

//Connect to SQL:
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
// Enable Error Mesaging
$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$user = '';
$pass = '';
$error_msg = "Enter Username & Password";
if(isset($_POST['login_submit']))
{
    //Start Session
    session_start();

    if(empty($_POST['username'])){
        echo "Invalid Username";
        echo $error_msg;
    } else if(empty($_POST['password'])){
        echo "Invalid Password";
        echo $error_msg;
    } else {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        
        //SQL:
        $query = $conn->prepare("SELECT * FROM login WHERE user = :u AND password= :p");
        $query->bindParam(':u',$user);
        $query->bindParam(':p',$pass);
        $query->execute();
        $number_rows = $query->fetch(PDO::FETCH_NUM);
        if($number_rows>0){
            echo $user;
            $_SESSION = $user;
            $_SESSION = $pass;
            header("Location: home.php");
        } else {
            echo "Invalid Username or Password";
            header("Location: index.php");
            
        }
    }
   
  
} else {
    echo "Login Not Performed";
}
echo $user;
echo $pass;
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
<form action="login.php" method="post" name="login">
<input type="text" name="username" placeholder="Enter Username"/>
<input type="text" name="password" placeholder="Enter Password"/>
<input type="submit" name="login_submit" value="Login"/>

</form>
</body>
</html>