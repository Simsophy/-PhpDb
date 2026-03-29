<?php
session_start();
require_once 'config.php'; // This file defines $conn

$sms = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = $_POST['password'];

    // Validation check for all fields
    if($username === '' || $password === '' || $email === '' || $phone === ''){
        $sms = "Please fill in all fields.";
    } else {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            
            // Updated SQL to include email and phone
            $stmt = $conn->prepare("INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $phone, $hash);

            if($stmt->execute()) {
                $_SESSION['user_id'] = $stmt->insert_id;
                $_SESSION['username'] = $username;
                header("Location: dashboard.php");
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            // Check for duplicate entry (1062) for username or email
            if ($e->getCode() == 1062) {
                $sms = "Error: Username or Email already exists.";
            } else {
                $sms = "Database error: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MY STOCK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f0f2f5; }
        .register-card { 
            max-width: 450px; 
            margin-top: 50px; 
            border-radius: 15px; 
            border: none;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="card register-card p-4 shadow-lg">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary"><i class="bi bi-person-plus-fill"></i> Join MyStock</h3>
            <p class="text-muted small">Create your account to manage your inventory</p>
        </div>
        
        <?php if($sms !== ''): ?>
            <div class="alert alert-danger text-center small py-2"><?= htmlspecialchars($sms) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label small fw-bold">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="johndoe" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label small fw-bold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Phone Number</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                    <input type="tel" name="phone" class="form-control" placeholder="012 345 678" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Register Now</button>
        </form>
        
        <div class="text-center mt-4">
            <p class="small text-muted">Already have an account? <a href="login.php" class="text-primary text-decoration-none fw-bold">Login</a></p>
        </div>
    </div>
</div>

</body>
</html>