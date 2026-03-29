<?php
// 1. DATA LOGIC FIRST (Before any HTML output)
include('../config.php'); 
include('../function.php');

if (session_status() == PHP_SESSION_NONE) { session_start(); }

if(isset($_POST['btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $sql = "INSERT INTO units (name) VALUES ('$name')";
    
    if (non_query($sql)) {
        $_SESSION['success'] = "Unit created successfully!";
        header('Location: index.php'); // Now works because no HTML was sent yet
        exit;
    } else {
        $_SESSION['error'] = "Failed to create unit!";
        // We don't redirect on error so the user can see the alert and fix the name
    }
}

// 2. UI SECTION SECOND
$title = "Create Unit";
include('../includes/header.php'); 
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold m-0">New Unit</h4>
                <a href="index.php" class="btn btn-light btn-sm border">Back</a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <?php alert_error(); ?>
                    
                    <form method="post">
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1">Unit Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control bg-light border-0" placeholder="e.g. PCS, Box, KG" required autofocus>
                        </div>
                        
                        <div class="pt-2">
                            <button type="submit" name="btn" class="btn btn-primary px-4">Save Unit</button>
                            <a href="index.php" class="btn btn-link text-muted text-decoration-none">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>