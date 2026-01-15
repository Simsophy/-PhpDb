<?php
include('../config.php');
$title = "Companies Info";
include('../function.php');

// 1. Execute the query
$com = scalar_query("SELECT * FROM companies WHERE id=1");

// 2. Define a safe default array structure
$default_company_data = [
    'name' => '',
    'phone' => '',
    'email' => '',
    'address' => '',
    'description' => '',
    'logo' => 'default-logo.png' // Use a fallback logo path
];

// 3. Merge the default data with the query result.
if (!$com || !is_array($com)) {
    $com = $default_company_data;
} else {
    // Merging ensures all keys exist and non-NULL database values overwrite defaults
    $com = array_merge($default_company_data, $com);
}

// NOTE: Since the $com array is guaranteed to contain strings for all keys, 
// we no longer need the '??' operator in the HTML for these fields.
?>

<?php include('../includes/header.php'); ?>
<body>
<div class="container">
    <?php alert_success(); ?>
    <?php alert_error(); ?>
    <h3>Companies Info</h3>
    <p>
        <a href="edit.php" class="btn btn-primary btn-sm">Edit</a>
        <a href="../index.php" class="btn btn-success btn-sm">Back</a>
    </p>

   

    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <label class="col-sm-3">Name</label>
                <div class="col-sm-9"><strong><?= htmlspecialchars($com['name']); ?></strong></div>
            </div>
            <div class="row mt-2">
                <label class="col-sm-3">Phone</label>
                <div class="col-sm-9"><strong><?= htmlspecialchars($com['phone']); ?></strong></div>
            </div>
            <div class="row mt-2">
                <label class="col-sm-3">Email</label>
                <div class="col-sm-9"><strong><?= htmlspecialchars($com['email']); ?></strong></div>
            </div>
            
           <div class="row mt-2">
    <label class="col-sm-3">Address</label>
    <div class="col-sm-9">
        <strong><?= htmlspecialchars($com['address'] ?? ''); ?></strong>
    </div>
</div>
            <div class="row mt-2">
                <label class="col-sm-3">Description</label>
                <div class="col-sm-9">
                    <strong><?= htmlspecialchars($com['description']); ?></strong>
                </div>
            </div>
        </div>
        
     <?php 
// This variable should hold the filename from the database or the default, 
// e.g., 'company.png' or 'default-logo.png'
$logo_filename = htmlspecialchars($com['logo']); 
?>
<div class="col-sm-9">
    
<a href="http://localhost/PHPDB/companies/company.png" class="gallery">
    <img src="http://localhost/PHPDB/companies/company.png" alt="Company Logo" width="150" />
</a>
</div>
    
</div>
<?php include('../includes/footer.php'); ?>