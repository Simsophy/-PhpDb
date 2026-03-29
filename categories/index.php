<?php
session_start();
include('../config.php');
include('../function.php');

// Security Check
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

$title = "Categories Management";
$categories = query("SELECT * FROM categories ORDER BY id DESC"); 

include('../includes/header.php'); 
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0">
                <i class="bi bi-tags text-warning me-2"></i> Categories List
            </h3>
            <p class="text-muted small mb-0">Manage and organize your product groupings.</p>
        </div>
        <div>
            <a href="../admin.php" class="btn btn-outline-secondary rounded-pill px-3 me-1">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <a href="create.php" class="btn btn-primary shadow-sm px-4 rounded-pill">
                <i class="bi bi-plus-lg"></i> Create New
            </a>
        </div>
    </div>

    <?php alert_success(); alert_error(); ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4" style="width: 100px;">ID</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th class="text-center pe-4" style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($categories)): ?>
                        <?php foreach($categories as $row): ?> 
                        <tr>
                            <td class="ps-4 text-muted small">#<?= htmlspecialchars($row['id'] ?? ''); ?></td>
                            <td>
                                <span class="fw-bold text-dark"><?= htmlspecialchars($row['name'] ?? ''); ?></span>
                            </td>
                            <td>
                                <span class="text-muted small"><?= htmlspecialchars($row['description'] ?? 'No description'); ?></span>
                            </td>
                           
    <td>
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                            <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this role?')">Delete</a>
                        </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-folder2-open display-4 d-block mb-2"></i>
                                No categories found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>