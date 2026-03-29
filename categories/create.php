<?php 
    include('../config.php');
    include('../function.php');
    session_start();

    if(isset($_POST['btn'])){
        global $conn;
        
        // SECURITY FIX: Sanitize input to prevent SQL Injection
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        
        $sql = "INSERT INTO categories (name, description) VALUES ('$name', '$description')";

        if(non_query($sql)) {
            $_SESSION['success'] = "Category created successfully!";
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['error'] = "Failed to create category. Please try again.";
        }
    }

    $title = "Create Category";
    include('../includes/header.php'); 
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-dark m-0">New Category</h3>
                    <p class="text-muted small mb-0">Add a new grouping for your products.</p>
                </div>
                <a href="index.php" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>

            <?php alert_success(); alert_error(); ?>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form method="post">
                        
                        <div class="mb-4">
                            <label for="name" class="form-label small fw-bold text-muted text-uppercase">
                                Category Name <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-primary">
                                    <i class="bi bi-tag"></i>
                                </span>
                                <input type="text" name="name" id="name" 
                                       class="form-control border-start-0 ps-0 shadow-none" 
                                       placeholder="e.g. Electronics, Groceries" 
                                       required autofocus>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label small fw-bold text-muted text-uppercase">
                                Description
                            </label>
                            <textarea name="description" id="description" 
                                      class="form-control bg-light shadow-none" 
                                      rows="4" 
                                      placeholder="Briefly describe what goes in this category..."></textarea>
                        </div>   

                        <hr class="my-4 opacity-25">

                        <div class="d-flex gap-2">
                            <button type="submit" name="btn" class="btn btn-primary px-4 rounded-3 w-100 shadow-sm">
                                <i class="bi bi-plus-circle me-2"></i>Create Category
                            </button>
                            <a href="index.php" class="btn btn-light px-4 rounded-3 w-100 border text-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>