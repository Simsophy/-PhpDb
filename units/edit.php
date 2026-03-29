<?php 
// Standard includes
include('../config.php');
include('../function.php');

// Security: Ensure session is active for alerts
if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Validate and sanitize ID from GET
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    $_SESSION['error'] = "Invalid unit ID provided.";
    header('Location: index.php');
    exit;
}

// 1. HANDLE FORM SUBMISSION (UPDATE)
if(isset($_POST['btn'])){
    global $conn;
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $sql = "UPDATE units SET name = '$name' WHERE id = $id";

    if (non_query($sql)) {
        $_SESSION['success'] = "Unit updated successfully!";
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['error'] = "Failed to edit unit! MySQL Error: " . mysqli_error($conn);
    }
}

// 2. READ DATA FOR FORM
$sql1 = "SELECT * FROM units WHERE id = $id";
$row = scalar_query($sql1);

if (!$row) {
    $_SESSION['error'] = "Unit with ID $id not found.";
    header('Location: index.php');
    exit;
}

$current_name = htmlspecialchars($row['name'] ?? '');
$title = "Edit Unit";
include('../includes/header.php'); 
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <div class="mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h3 class="fw-bold text-dark m-0">Edit Unit</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb small m-0">
                            <li class="breadcrumb-item"><a href="../dashboard.php" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Units</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
                <a href="index.php" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>

            <?php alert_error(); alert_success(); ?>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="" method="post">
                        <div class="mb-4">
                            <label for="name" class="form-label small fw-bold text-muted text-uppercase">
                                Unit Name <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-ruler-combined text-primary"></i>
                                </span>
                                <input type="text" id="name" name="name" 
                                       class="form-control border-start-0 ps-0 shadow-none" 
                                       placeholder="e.g. Kilograms, Box, Liters"
                                       required autofocus 
                                       value="<?= $current_name; ?>">
                            </div>
                            <div class="form-text mt-2 small">
                                Ensure the unit name is unique and clear (e.g., "kg" or "Pieces").
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="d-flex gap-2">
                            <button type="submit" name="btn" class="btn btn-primary px-4 rounded-3 w-100 shadow-sm">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                            <a href="index.php" class="btn btn-light px-4 rounded-3 w-100 border text-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-4 text-center">
                <p class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i> 
                    Updating this unit will affect all products assigned to it.
                </p>
            </div>

        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>