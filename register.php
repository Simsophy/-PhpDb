<?php
session_start();
require_once 'config.php';

$sms = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if($username === '' || $password === ''){
        $sms = "Enter username and password.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $con->prepare("INSERT INTO users(username,password) VALUES(?,?)");
        $stmt->bind_param("ss", $username, $hash);

        if($stmt->execute()) $sms = "User created!";
        else $sms = "Error: " . $con->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <h3>Register</h3>
<form method="post">
Username: <input name="username"><br>
Password: <input type="password" name="password"><br>
<button type="submit">Register</button>
</form>  
</body>
</html>


<?= $sms ?>
