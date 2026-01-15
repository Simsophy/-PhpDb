<?php 
// Ensure session is started (if not handled by config.php or header.php)
if (session_status() == PHP_SESSION_NONE) { session_start(); }

include('../config.php');
include('../function.php');

// CRITICAL SECURITY FIX 1: Validate and sanitize ID from GET to prevent SQL Injection
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$title = "Edit Product";

// Redirect if ID is invalid
if ($id <= 0) {
    $_SESSION['error'] = "Invalid Product ID provided.";
    header('Location: index.php');
    exit;
}

// -----------------------------------------------------------
// 1. HANDLE FORM SUBMISSION (UPDATE)
// -----------------------------------------------------------
if(isset($_POST['btn'])) {
    global $conn;
    
    // CRITICAL SECURITY FIX 2: Sanitize all POST inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $code = mysqli_real_escape_string($conn, $_POST['code']);
    $price = floatval($_POST['price']);
    $low_stock = intval($_POST['low_stock']);
    $category_id = intval($_POST['category_id']);
    $unit_id = intval($_POST['unit_id']);

    // Build the secure update query
    $sql = "UPDATE products SET 
                code='$code', 
                name='$name', 
                price=$price, 
                category_id=$category_id, 
                unit_id=$unit_id, 
                low_stock=$low_stock
            WHERE id=$id"; // Using the safe $id integer

    $x = non_query($sql);
    
    if($x) {
        // FIX 1: Use the constant and redirect (Post/Redirect/Get)
        $_SESSION['success'] = SUCCESS_SMS; 
        header('Location: index.php');
        exit;
    } else {
        // FIX 2: Provide actual MySQL error feedback for debugging
        $_SESSION['error'] = ERROR_SMS . " | Failed to update product! MySQL Error: " . mysqli_error($conn);
    }
}

// -----------------------------------------------------------
// 2. READ DATA FOR FORM (always executed)
// -----------------------------------------------------------
$pro = scalar_query("SELECT * FROM products WHERE id=$id");

// Logic Check: If no row is found, redirect
if (!$pro) {
    $_SESSION['error'] = "Product with ID $id not found.";
    header('Location: index.php');
    exit;
}

// Fetch lookup data for dropdowns
$cats = query("SELECT id, name FROM categories WHERE active = 1 ORDER BY name ASC");
$units = query("SELECT id, name FROM units WHERE active = 1 ORDER BY name ASC");
?>

<?php include('../includes/header.php'); ?>

    <div class="container">
        <h3>Edit Product</h3>
        <p>
            <a href="index.php" class="btn btn-success btn-sm">Back</a>
        </p>
        <form method="post">
            <?php alert_success(); alert_error(); ?>
            <div class="row">
                <div class="col-sm-6">
                    
                    <div class="row">
                        <label for="code" class="col-sm-3">Code</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="code" id="code" value="<?= htmlspecialchars($pro['code'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label for="name" class="col-sm-3">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($pro['name'] ?? ''); ?>" required>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <label for="price" class="col-sm-3">Price($)</label>
                        <div class="col-sm-9">
                            <input type="number" step="0.01" min="0" class="form-control" name="price" id="price" value="<?= htmlspecialchars($pro['price'] ?? ''); ?>" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label for="low_stock" class="col-sm-3">Low Stock</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" class="form-control" name="low_stock" id="low_stock" value="<?= htmlspecialchars($pro['low_stock'] ?? ''); ?>">
                        </div>
                    </div>
                    
                </div>
                <div class="col-sm-6">
                    <div class="row mt-2">
                        <label for="category_id" class="col-sm-3">Category</label>
                        <div class="col-sm-9">
                            <?=bind($cats, 'category_id', $pro['category_id']);?>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label for="unit_id" class="col-sm-3">Unit</label>
                        <div class="col-sm-9">
                            <?=bind($units, 'unit_id', $pro['unit_id']);?>
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