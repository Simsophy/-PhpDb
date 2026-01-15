<?php
// Use absolute paths for includes for consistency
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../function.php';

// FIX: Ensure session is started. (CRITICAL for security and alerts)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// SECURITY CHECK: Redirect unauthenticated users
// This prevents access to any page that includes header.php without being logged in.
if (!isset($_SESSION['username'])) {
    $current_page = basename($_SERVER['PHP_SELF']);
    // Check if the current URI path is already the login page to prevent infinite loop
    if ($current_page !== 'login.php' && !str_contains($_SERVER['REQUEST_URI'], 'login.php')) {
        // BURL (Base URL) must be defined in config.php (e.g., http://localhost/phpdb/)
        header('Location: ' . BURL . 'login.php'); 
        exit();
    }
}

// Define variables if they were not set by the calling script (default values)
// $title must be set in the calling script (e.g., $title = "Products List";)
$title = $title ?? "Dashboard"; 
$app_name = defined('APP_NAME') ? APP_NAME : 'PHP & DB';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title;?> | <?=$app_name;?></title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    
    </head>
<body>

<nav class="navbar navbar-expand-lg bg-dark bg-body-tertiary" data-bs-theme="dark">
  <div class="container">
    <a class="navbar-brand" href="<?=BURL;?>"><?=$app_name;?></a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topnav" aria-controls="topnav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="topnav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
        <li class="nav-item">
          <a class="nav-link" href="<?=BURL;?>">Home</a>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Inventory & Products
          </a>
          <ul class="dropdown-menu">
            <li><h6 class="dropdown-header">Products</h6></li>
            <li><a class="dropdown-item" href="<?=BURL;?>products/index.php">Products List</a></li>
            <li><a class="dropdown-item" href="<?=BURL;?>products/low.php">Low Stock</a></li>
            </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             Setting & Admin
          </a>
          <ul class="dropdown-menu">
            <li><h6 class="dropdown-header">Company & Data</h6></li>
            <li><a class="dropdown-item" href="<?=BURL;?>companies/index.php">Companies Info</a></li>
            <li><a class="dropdown-item" href="<?=BURL;?>exchanges/index.php">Exchanges</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><h6 class="dropdown-header">System References</h6></li>
            <li><a class="dropdown-item" href="<?=BURL;?>categories/index.php">Categories</a></li>
            <li><a class="dropdown-item" href="<?=BURL;?>units/index.php">Units</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><h6 class="dropdown-header">User Management</h6></li>
            <li><a class="dropdown-item" href="<?=BURL;?>roles/index.php">Roles</a></li>
            <li><a class="dropdown-item" href="<?=BURL;?>users/index.php">Users</a></li>
          </ul>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="<?=BURL;?>reports/index.php">Reports</a>
        </li>
      </ul>
      
      <?php if (isset($_SESSION['username'])): ?>
      <ul class="d-flex navbar-nav">
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <?=$_SESSION['username'];?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?=BURL;?>profile.php">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?=BURL;?>logout.php">Log out</a></li>
          </ul>
        </li>
      </ul>
      <?php endif; ?>
      
    </div>
  </div>
</nav>