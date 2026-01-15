<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-body-tertiary">

    <div class="container mt-5">
        
        <div class="card p-4 shadow bg-info text-black">
            
            <h1 class="mb-3 display-4 fw-bold">Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
            
           <div class="d-flex flex-wrap gap-2">
    
    <a href="index.php" class="btn btn-light text-black">
        <i class="bi bi-house-door-fill"></i> Home
    </a>
    
    <a href="categories/index.php" class="btn btn-outline-light text-black">
        <i class="bi bi-tag-fill"></i> Categories
    </a>
    <a href="products/index.php" class="btn btn-outline-light text-black">
        <i class="bi bi-box-seam-fill"></i> Products
    </a>
    <a href="companies/index.php" class="btn btn-outline-light text-black">
        <i class="bi bi-building-fill"></i> Companies
    </a>
    <a href="employees/index.php" class="btn btn-outline-light text-black">
        <i class="bi bi-person-badge-fill"></i> Employees
    </a>
    
    <a href="users/index.php" class="btn btn-outline-light text-black">
        <i class="bi bi-person-circle"></i> User
    </a>
    <a href="roles/index.php" class="btn btn-outline-light text-black">
        <i class="bi bi-shield-lock-fill"></i> Role
    </a>

    <div class="w-100"></div> <a href="exchanges/index.php" class="btn btn-outline-light text-black">
        <i class="bi bi-arrow-left-right"></i> Exchange
    </a>
    <a href="units/index.php" class="btn btn-outline-light text-black">
        <i class="bi bi-rulers"></i> Unit
    </a>
    
    <a href="reports/index.php" class="btn btn-outline-light text-black">
        <i class="bi bi-bar-chart-fill"></i> Report
    </a>
    
    <a href="logout.php" class="btn btn-danger text-white">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</div>

            <hr class="my-4">
            
            <p>Your main dashboard content goes here.</p>
        
        </div>
        </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>