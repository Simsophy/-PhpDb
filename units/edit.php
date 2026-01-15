<?php 
// Ensure session is started, typically in header.php or config.php
// If not started in an included file, uncomment the line below:
// if (session_status() == PHP_SESSION_NONE) { session_start(); }

include('../config.php');
include('../function.php');

// CRITICAL SECURITY FIX 1: Validate and sanitize ID from GET to prevent SQL Injection
// Use intval() to ensure the ID is treated only as a number.
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Redirect if ID is invalid
if ($id <= 0) {
    $_SESSION['error'] = "Invalid unit ID provided.";
    header('Location: index.php');
    exit;
}

// -----------------------------------------------------------
// 1. HANDLE FORM SUBMISSION (UPDATE)
// -----------------------------------------------------------
if(isset($_POST['btn'])){
    global $conn;
    
    // CRITICAL SECURITY FIX 2: Sanitize input to prevent SQL Injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    
    // BUG FIX 1: Use sanitized $id_int and $name in the query
    $sql = "UPDATE units SET name = '$name' WHERE id = $id";

    $x = non_query($sql);
    
    if ($x) {
        // BUG FIX 2: Redirect on success to prevent form resubmission and display the message on index.php
        $_SESSION['success'] = "Unit edited successfully!";
        header('Location: index.php');
        exit;
    } else {
        // FIX: Provide detailed error message for debugging
        $_SESSION['error'] = "Failed to edit unit! MySQL Error: " . mysqli_error($conn);
    }
}

// -----------------------------------------------------------
// 2. READ DATA FOR FORM (always executed)
// -----------------------------------------------------------
// Initial data load for the form field
$sql1 = "SELECT * FROM units WHERE id = $id";
$row = scalar_query($sql1);

// Logic Check: If no row is found, redirect to prevent errors
if (!$row) {
    $_SESSION['error'] = "Unit with ID $id not found.";
    header('Location: index.php');
    exit;
}

// Set $name for the input value attribute
// SECURITY FIX 3: Use htmlspecialchars() when outputting data back into the form
$current_name = htmlspecialchars($row['name'] ?? '');
?>


<?php $title = "Edit Units"; ?>
<?php include('../includes/header.php'); ?>

    <div class="container">
        <?php alert_error(); alert_success(); ?>
        
        <h3>Edit Units</h3>
        <p>
            <a href="index.php" class="btn btn-success btn-sm">Back</a>
        </p>    
        <form action="" method="post">
            <div class="row">
                <div class="col-sm-6">
                    
                    <div class="form-group">
                        <label for="name">Name
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="name" name="name" class="form-control" required autofocus value="<?= $current_name; ?>">
                    </div>
                    
                    <div class="form-group mt-3">
                        <button class="btn btn-primary btn-sm" name="btn" >Save</button>
                        <a href="index.php" class="btn btn-danger btn-sm" >Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php include('../includes/footer.php'); ?>