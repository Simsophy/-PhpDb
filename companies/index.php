<?php
require_once('../config.php');
include_once('../function.php');

// 1. Fetch data (Shortened logic)
$com = scalar_query("SELECT * FROM companies WHERE id=1 LIMIT 1") ?: [];

// 2. Setup Variables
$logo = (file_exists('company.png')) ? 'company.png' : 'https://via.placeholder.com/200?text=No+Logo';
$title = "Business Profile";

// 3. Define the Information Grid (Label => Value)
$info = [
    'Contact Phone'    => $com['phone']   ?? 'N/A',
    'Email Address'    => $com['email']   ?? 'N/A',
    'Physical Address' => $com['address'] ?? 'N/A',
    'About Us'         => nl2br(htmlspecialchars($com['description'] ?? 'No description.'))
];

include('../includes/header.php'); 
?>

<div class="container py-5">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="row g-0">
            
            <div class="col-md-4 bg-light p-5 text-center border-end">
                <label class="small fw-bold text-muted text-uppercase mb-3 d-block">Brand Identity</label>
                <img src="<?= $logo ?>" class="img-fluid rounded-3 bg-white p-2 shadow-sm">
                <div class="mt-4">
                    <a href="edit.php" class="btn btn-primary w-100 rounded-pill mb-2">Edit Details</a>
                    <a href="../index.php" class="btn btn-link text-muted btn-sm">Return Home</a>
                </div>
            </div>

            <div class="col-md-8 p-5">
                <h2 class="fw-bold text-primary mb-1"><?= $com['name'] ?? 'Company Name' ?></h2>
                <p class="text-muted small mb-4">Official Business Record</p>
                
                <div class="row">
                    <?php foreach ($info as $label => $value): ?>
                        <div class="col-12 mb-3">
                            <label class="small text-uppercase fw-bold text-muted d-block"><?= $label ?></label>
                            <div class="fs-5 text-dark"><?= $value ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>