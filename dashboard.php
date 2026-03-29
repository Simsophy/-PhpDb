<?php
session_start();
// Security: If the user is not logged in, send them to the Welcome (index) page

require_once 'config.php';
include('includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main Dashboard - MY STOCK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .menu-card { transition: 0.3s; border: none; border-radius: 15px; text-decoration: none !important; }
        .menu-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .icon-box { font-size: 2.5rem; margin-bottom: 10px; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-success shadow mb-5">
    <div class="container">
        <span class="navbar-brand fw-bold">MY STOCK SYSTEM</span>
        <div class="text-white">
            <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['username']) ?> | 
            <a href="logout.php" class="btn btn-sm btn-outline-light ms-2">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row g-4 text-center">
        <?php 
        // These folder names must match your Laragon folder names exactly
        $menus = [
            ['name' => 'Companies', 'icon' => 'bi-building', 'link' => 'companies/index.php', 'color' => '#0d6efd'],
            ['name' => 'Products', 'icon' => 'bi-box-seam', 'link' => 'products/index.php', 'color' => '#198754'],
            ['name' => 'Employees', 'icon' => 'bi-people', 'link' => 'employees/index.php', 'color' => '#0dcaf0'],
            ['name' => 'Categories', 'icon' => 'bi-tags', 'link' => 'categories/index.php', 'color' => '#ffc107'],
            ['name' => 'Exchanges', 'icon' => 'bi-arrow-left-right', 'link' => 'exchanges/index.php', 'color' => '#6c757d'],
            ['name' => 'Users', 'icon' => 'bi-person-gear', 'link' => 'users/index.php', 'color' => '#212529'],
            ['name' => 'Reports', 'icon' => 'bi-clipboard-data', 'link' => 'reports/index.php', 'color' => '#dc3545'],
            ['name' => 'Units', 'icon' => 'bi-rulers', 'link' => 'units/index.php', 'color' => '#6610f2']
        ];

        foreach($menus as $m): ?>
        <div class="col-md-3">
            <a href="<?= $m['link'] ?>" class="text-decoration-none">
                <div class="card menu-card p-4 h-100 shadow-sm">
                    <div class="icon-box" style="color: <?= $m['color'] ?>;"><i class="bi <?= $m['icon'] ?>"></i></div>
                    <h5 class="text-dark fw-bold"><?= $m['name'] ?></h5>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>