<?php
session_start();
include('../config.php');
include('../function.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$title = "Edit Product";

// 1. UPDATE LOGIC
if(isset($_POST['btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $code = mysqli_real_escape_string($conn, $_POST['code']);
    $price = floatval($_POST['price']);
    $low_stock = intval($_POST['low_stock']);
    $cat_id = intval($_POST['category_id']);
    $unit_id = intval($_POST['unit_id']);

    $sql = "UPDATE products SET code='$code', name='$name', price=$price, 
            category_id=$cat_id, unit_id=$unit_id, low_stock=$low_stock WHERE id=$id";

    if(non_query($sql)) {
        $_SESSION['success'] = "Product updated successfully!";
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['error'] = "Update failed: " . mysqli_error($conn);
    }
}

// 2. FETCH DATA
$pro = scalar_query("SELECT * FROM products WHERE id=$id");
if (!$pro) { header('Location: index.php'); exit; }

$cats = query("SELECT id, name FROM categories WHERE active = 1 ORDER BY name ASC");
$units = query("SELECT id, name FROM units WHERE active = 1 ORDER BY name ASC");

include('../includes/header.php'); 
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold m-0 text-dark">Edit Product</h4>
                <a href="index.php" class="btn btn-light btn-sm border">Back to List</a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <?php alert_success(); alert_error(); ?>

                    <form method="post">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="small fw-bold text-muted">Item Code</label>
                                <input type="text" name="code" class="form-control bg-light border-0" value="<?= $pro['code'] ?>">
                            </div>
                            <div class="col-md-8">
                                <label class="small fw-bold text-muted">Product Name</label>
                                <input type="text" name="name" class="form-control bg-light border-0" value="<?= $pro['name'] ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="small fw-bold text-muted">Price ($)</label>
                                <input type="number" step="0.01" name="price" class="form-control bg-light border-0" value="<?= $pro['price'] ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-muted">Low Stock Alert</label>
                                <input type="number" name="low_stock" class="form-control bg-light border-0" value="<?= $pro['low_stock'] ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="small fw-bold text-muted">Category</label>
                                <?= bind($cats, 'category_id', $pro['category_id']); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-muted">Unit</label>
                                <?= bind($units, 'unit_id', $pro['unit_id']); ?>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <button type="submit" name="btn" class="btn btn-primary px-4 shadow-sm">Update Product</button>
                            <a href="index.php" class="btn btn-link text-muted text-decoration-none">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>