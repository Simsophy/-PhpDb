<?php
// Use absolute paths for includes for consistency
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../function.php';

// FIX: Ensure session is started. (CRITICAL for security and alerts)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// SECURITY CHECK: Redirect unauthenticated users
if (!isset($_SESSION['username'])) {
    $current_page = basename($_SERVER['PHP_SELF']);
    if ($current_page !== 'login.php' && !str_contains($_SERVER['REQUEST_URI'], 'login.php')) {
        header('Location: ' . BURL . 'dashboard.php'); 
        exit();
    }
}

$title = $title ?? "Dashboard"; 
$app_name = defined('APP_NAME') ? APP_NAME : 'MYAPP';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title;?> | <?=$app_name;?></title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Modern Navbar Styling */
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 0.8rem 0;
            background-color: #1a1d20 !important;
        }
        
        .navbar-brand {
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #fff !important;
        }

        /* Enhanced Dropdown Menu */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 12px;
            padding: 0.8rem;
            margin-top: 10px !important;
            animation: dropdownFade 0.2s ease-out;
        }

        @keyframes dropdownFade {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Modern Dropdown Header Styling */
        .dropdown-header {
            text-transform: uppercase;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 1.2px;
            color: #6c757d;
            padding: 0.5rem 1rem 0.3rem;
            margin-top: 0.5rem;
        }

        .dropdown-header:first-child {
            margin-top: 0;
        }

        /* Dropdown Item Styling */
        .dropdown-item {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-weight: 500;
            font-size: 0.9rem;
            color: #495057;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
            transform: translateX(5px);
        }

        .dropdown-divider {
            border-top: 1px solid #f1f3f5;
            margin: 0.6rem 0;
        }

        /* Profile Capsule */
        .user-capsule {
            background: rgba(255,255,255,0.1);
            border-radius: 50px;
            padding: 4px 15px !important;
            margin-left: 10px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="<?=BURL;?>">
        <i class="fas fa-layer-group me-2 text-primary"></i> <?=$app_name;?>
    </a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topnav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="topnav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
        <li class="nav-item">
          <a class="nav-link" href="<?=BURL;?>dashboard.php">Home</a>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="<?=BURL;?>products/index.php" role="button" data-bs-toggle="dropdown">
            Inventory & Products
          </a>
          <ul class="dropdown-menu">
            <li><h6 class="dropdown-header">Products Management</h6></li>
            <li><a class="dropdown-item" href="<?=BURL;?>products/index.php"><i class="fas fa-list-ul me-2 opacity-50"></i>Products List</a></li>
            <li><a class="dropdown-item" href="<?=BURL;?>products/low.php"><i class="fas fa-arrow-down me-2 opacity-50 text-danger"></i>Low Stock</a></li>
          </ul>
        </li>
        
       <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-gear-fill me-1"></i> Setting & Admin
    </a>
    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2 py-3 px-2" style="min-width: 250px;">
        
        <li><a class="dropdown-item rounded-3 py-2 mb-1 bg-light fw-bold" href="<?=BURL;?>admin.php">
            <i class="bi bi-speedometer2 text-danger me-2"></i> Admin Dashboard
        </a></li>
        <li><hr class="dropdown-divider opacity-50"></li>

        <li><h6 class="dropdown-header text-uppercase fw-bold smaller text-muted ls-1">Company & Data</h6></li>
        <li><a class="dropdown-item rounded-3 py-2" href="<?=BURL;?>companies/index.php">
            <i class="bi bi-building text-primary me-2"></i> Companies Info
        </a></li>
        <li><a class="dropdown-item rounded-3 py-2" href="<?=BURL;?>exchanges/index.php">
            <i class="bi bi-currency-exchange text-info me-2"></i> Exchanges
        </a></li>

        <li><hr class="dropdown-divider opacity-50"></li>

        <li><h6 class="dropdown-header text-uppercase fw-bold smaller text-muted ls-1">System References</h6></li>
        <li><a class="dropdown-item rounded-3 py-2" href="<?=BURL;?>categories/index.php">
            <i class="bi bi-tags text-warning me-2"></i> Categories
        </a></li>
        <li><a class="dropdown-item rounded-3 py-2" href="<?=BURL;?>units/index.php">
            <i class="bi bi-rulers text-secondary me-2"></i> Units
        </a></li>

        <li><hr class="dropdown-divider opacity-50"></li>

        <li><h6 class="dropdown-header text-uppercase fw-bold smaller text-muted ls-1">Access Control</h6></li>
        <li><a class="dropdown-item rounded-3 py-2" href="<?=BURL;?>roles/index.php">
            <i class="bi bi-shield-lock text-dark me-2"></i> Roles
        </a></li>
        <li><a class="dropdown-item rounded-3 py-2" href="<?=BURL;?>users/index.php">
            <i class="bi bi-people text-success me-2"></i> Users
        </a></li>
    </ul>
</li>
        <li class="nav-item">
          <a class="nav-link" href="<?=BURL;?>reports/index.php">Reports</a>
        </li>
      </ul>
      
      <?php if (isset($_SESSION['username'])): ?>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle user-capsule" data-bs-toggle="dropdown">
            <i class="far fa-user-circle me-1"></i> <?=$_SESSION['username'];?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?=BURL;?>profile.php">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger fw-bold" href="<?=BURL;?>logout.php">
                <i class="fas fa-sign-out-alt me-2"></i>Log out
            </a></li>
          </ul>
        </li>
      </ul>
      <?php endif; ?>
      
    </div>
  </div>
</nav>