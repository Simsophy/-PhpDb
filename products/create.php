<?php 
// CRITICAL: Start the session first for $_SESSION messages
if (session_status() == PHP_SESSION_NONE) { session_start(); }

include('../config.php');
include('../function.php');
$title = "Create Product";
global $conn; // Ensure database connection is available for sanitization

// -----------------------------------------------------------
// 1. HANDLE FORM SUBMISSION (INSERT)
// -----------------------------------------------------------
if(isset($_POST['btn']))
{
    // CRITICAL SECURITY FIX 1: Sanitize all POST inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $code = mysqli_real_escape_string($conn, $_POST['code']);
    $price = floatval($_POST['price']); // Use floatval for price
    $low_stock = intval($_POST['low_stock']); // Use intval for low_stock
    $category_id = intval($_POST['category_id']);
    $unit_id = intval($_POST['unit_id']);
    
    // Build the secure INSERT query
    $sql = "INSERT INTO products (name, code, price, low_stock, category_id, unit_id, active) 
            VALUES ('$name', '$code', $price, $low_stock, $category_id, $unit_id, 1)";
            
    $x = non_query($sql);
    
    if($x)
    {
        // FIX 1: Use the constant (assuming it's defined in config.php)
        $_SESSION['success'] = SUCCESS_SMS;
        
        // FIX 2: Implement Post/Redirect/Get (PRG) pattern
        // Redirect to index.php to display the success message
        header('Location: index.php');
        exit; // Terminate script execution after redirect
    } else {
        // Handle insertion failure on the same page
        $_SESSION['error'] = ERROR_SMS . " | Failed to create product. MySQL Error: " . mysqli_error($conn);
    }
}

// -----------------------------------------------------------
// 2. DATA FETCHING (for dropdowns)
// -----------------------------------------------------------
// Assuming the 'active' column is now fixed in categories and units tables.
$cats = query("SELECT id, name FROM categories WHERE active=1 ORDER BY name ASC");
$units = query("SELECT id, name FROM units WHERE active=1 ORDER BY name ASC");
?>

<?php include('../includes/header.php'); ?>

<div class="container">
    <?php alert_success(); ?>
    <?php alert_error(); ?> 
    
    <h3>Create Product</h3>
    <p>
        <a href="index.php" class="btn btn-success btn-sm">Back</a>
    </p>
    <form method="post">
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <label for="code" class="col-sm-3">Code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="code" id="code" >
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="name" class="col-sm-3">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                </div>
                
                <div class="row mt-2">
                    <label for="price" class="col-sm-3">Price($)</label>
                    <div class="col-sm-9">
                        <input type="number" step="0.01" min="0" class="form-control" name="price" id="price" required>
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="low_stock" class="col-sm-3">Low Stock</label>
                    <div class="col-sm-9">
                        <input type="number" min="0" class="form-control" name="low_stock" id="low_stock" value="3">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row mt-2">
                    <label for="category_id" class="col-sm-3">Category</label>
                    <div class="col-sm-9">
                        <?=bind($cats, 'category_id');?>
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="unit_id" class="col-sm-3">Unit</label>
                    <div class="col-sm-9">
                        <?=bind($units, 'unit_id');?>
                        <div class="mt-2">
                            <button class="btn btn-primary btn-sm" name="btn">Save</button>
                            <a href="index.php" class="btn btn-danger btn-sm">Cancel</a>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </form>
</div>
<?php include('../includes/footer.php'); ?>