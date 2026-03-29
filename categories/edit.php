<?php 
    include('../config.php');
    include('../function.php');
    session_start();

    // 1. SECURITY FIX: Sanitize the ID from GET
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id <= 0) {
        $_SESSION['error'] = "Invalid category ID.";
        header('Location: index.php');
        exit;
    }

    // 2. HANDLE FORM SUBMISSION
    if(isset($_POST['btn'])){
        global $conn;
        // SECURITY FIX: Sanitize inputs to prevent SQL Injection
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        
        $sql = "UPDATE categories SET name = '$name', description = '$description' WHERE id = $id";

        if(non_query($sql)){
            $_SESSION['success'] = "Category updated successfully!";
            header('Location: index.php'); // Redirect to list after success
            exit;
        } else {
            $_SESSION['error'] = "Failed to update category.";
        }
    }

    // 3. READ DATA FOR UPDATE
    $sql1 = "SELECT * FROM categories WHERE id = $id";
    $row = scalar_query($sql1);

    if (!$row) {
        $_SESSION['error'] = "Category not found.";
        header('Location: index.php');
        exit;
    }

    $name = htmlspecialchars($row['name'] ?? '');
    $description = htmlspecialchars($row['description'] ?? '');

    $title = "Edit Category";
    include('../includes/header.php'); 
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-dark m-0">Edit Category</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb small m-0">
                            <li class="breadcrumb-item"><a href="../admin.php">Admin</a></li>
                            <li class="breadcrumb-item"><a href="index.php">Categories</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
                <a href="index.php" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>

            <?php alert_success(); alert_error(); ?>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="" method="post">
                        
                        <div class="mb-4">
                            <label for="name" class="form-label small fw-bold text-muted text-uppercase">
                                Category Name <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-warning">
                                    <i class="bi bi-tag-fill"></i>
                                </span>
                                <input type="text" id="name" name="name" 
                                       class="form-control border-start-0 ps-0 shadow-none" 
                                       required autofocus 
                                       value="<?= $name; ?>"
                                       placeholder="Enter category name">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label small fw-bold text-muted text-uppercase">
                                Description
                            </label>
                            <textarea name="description" id="description" 
                                      class="form-control bg-light shadow-none" 
                                      rows="4" 
                                      placeholder="Provide details about this category..."><?= $description; ?></textarea>
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="d-flex gap-2">
                            <button type="submit" name="btn" class="btn btn-primary px-4 rounded-3 w-100 shadow-sm">
                                <i class="bi bi-check-circle me-2"></i>Save Changes
                            </button>
                            <a href="index.php" class="btn btn-light px-4 rounded-3 w-100 border text-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <p class="text-center mt-4 text-muted small">
                <i class="bi bi-info-circle me-1"></i> 
                Changes will be reflected immediately across all linked products.
            </p>

        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>