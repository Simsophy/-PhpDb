<?php
session_start();
require_once 'config.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome - MY STOCK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&q=80&w=2000');
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            color: white;
        }
    </style>
    <script>

window.location.href = "index.php";
</script>
<body>
    
</head>
<body>
    <div class="container text-center">
        <h1 class="display-1 fw-bold">MY STOCK</h1>
        <p class="lead mb-5">Manage your inventory, employees, and company profiles in one place.</p>
        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
            <a href="login.php" class="btn btn-success btn-lg px-5 fw-bold">Login</a>
            <a href="register.php" class="btn btn-outline-light btn-lg px-5">Create Account</a>
        </div>
    </div>
</body>
</html>