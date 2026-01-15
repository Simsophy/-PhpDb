<?php 
// Ensure session is started (if not handled by config.php or header.php)
if (session_status() == PHP_SESSION_NONE) { session_start(); }

include('../config.php');
include('../function.php');
global $conn; // Ensure the connection object is available for sanitization

// CRITICAL SECURITY FIX 1: Validate and sanitize ID from GET
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$title = "Edit Role";

// Logic Check: Redirect if ID is invalid
if ($id <= 0) {
    $_SESSION['error'] = "Invalid Role ID provided.";
    header('Location: index.php');
    exit;
}

// -----------------------------------------------------------
// 1. HANDLE FORM SUBMISSION (UPDATE)
// -----------------------------------------------------------
if(isset($_POST['btn'])){
    
    // CRITICAL SECURITY FIX 2: Sanitize POST input
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    
    // Build the secure update query
    $sql = "UPDATE roles SET name = '$name' WHERE id = $id";

    $x = non_query($sql);
    
    if ($x) {
        // FIX 1: Use a standard update constant (e.g., UPDATE_SUCCESS_SMS) 
        // OR the general SUCCESS_SMS constant. DEL_SUCCESS_SMS is confusing here.
        $_SESSION['success'] = SUCCESS_SMS; 
        header('location: index.php');
        exit; // Important: terminate script after header redirect
    } else {
        // FIX 2: Use a standard error constant and provide MySQL error details
        $_SESSION['error'] = ERROR_SMS . " | Failed to update role. MySQL Error: " . mysqli_error($conn);
        header('location: index.php');
        exit; // Important: terminate script after header redirect
    }
}

// -----------------------------------------------------------
// 2. READ DATA FOR FORM (always executed)
// -----------------------------------------------------------

// Read data for update
$sql1 = "SELECT * FROM roles WHERE id = $id";
$row = scalar_query($sql1);

// Logic Check: If role not found
if (!$row) {
    $_SESSION['error'] = "Role not found.";
    header('location: index.php');
    exit;
}

// SECURITY FIX 3: Use htmlspecialchars() when setting the input value
$name_value = htmlspecialchars($row['name'] ?? '');
?>
<?php include('../includes/header.php'); ?>

<div class="container">
   
    <div class="container">
        <h3>Edit Roles</h3>
        <p>
            <a href="index.php" class="btn btn-success btn-sm" >Back</a>
        </p>     
        <form action="" method="post">
            <div class="row">
                <div class="col-sm-6">
                    <?php alert_error(); alert_success(); ?>
                    
                    <div class="form-group">
                        <label for="name">Name
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="name" name="name" class="form-control" required autofocus value="<?=$name_value;?>">
                    </div>
                    
                    <div class="form-group mt-3">
                        <button class="btn btn-primary btn-sm" name="btn" >Save</button>
                        <a href="index.php" class="btn btn-danger btn-sm" >Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
<?php include('../includes/footer.php'); ?>