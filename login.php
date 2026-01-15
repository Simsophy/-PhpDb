<?php
session_start();
// NOTE: Make sure your config.php file correctly includes your database connection ($conn)
require_once 'config.php'; 

$sms = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if($username === '' || $password === ''){
        $sms = "Enter username and password.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username=? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows === 1){
            $stmt->bind_result($id, $db_user, $db_hash);
            $stmt->fetch();

            if(password_verify($password, $db_hash)){
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $db_user;
                header("Location: index.php");
                exit;
            } else {
                $sms = "Invalid username or password.";
            }
        } else {
            $sms = "Invalid username or password.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - MY STOCK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        .login-card {
            max-width: 400px;
        }
    </style>
</head>
<body class="bg-body-tertiary">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5 login-card"> 
            
            <div class="card p-4 shadow-lg"> 
                
                <h3 class="text-center text-success mb-4">
                    <i class="bi bi-box-seam-fill me-2"></i> MY STOCK Login
                </h3>
                
                <?php if($sms !== ''): ?>
                    <div class="alert alert-danger text-center"><?= htmlspecialchars($sms) ?></div>
                <?php endif; ?>
                
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </button>
                </form>
                
                <p class="mt-3 text-center">
                    <a href="register.php" class="text-success text-decoration-none">
                        <i class="bi bi-person-plus-fill me-1"></i> Create an account
                    </a>
                </p>
            </div>
            </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>