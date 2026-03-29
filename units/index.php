<?php 
    include('../config.php');
    include('../function.php');
    
    $title = "Product Units";
    $units = query("SELECT * FROM units ORDER BY id DESC"); 
?>

<?php include('../includes/header.php');?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold m-0 text-dark">
                <i class="fas fa-balance-scale text-primary me-2"></i> Units
            </h4>
            <p class="text-muted small mb-0">Manage measurement units for your inventory.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="../index.php" class="btn btn-light border btn-sm px-3 shadow-sm">Back</a>
            <a href="create.php" class="btn btn-primary btn-sm px-4 shadow-sm">+ Create Unit</a>
        </div>
    </div>

    <?php alert_success(); alert_error(); ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase fw-bold">
                    <tr>
                        <th class="ps-4" style="width: 100px;">ID</th>
                        <th>Unit Name</th>
                        <th class="text-center pe-4" style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($units)): ?>
                        <?php foreach($units as $row): ?> 
                            <tr>
                                <td class="ps-4">
                                    <span class="text-muted font-monospace">#<?= $row['id']; ?></span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark"><?= htmlspecialchars($row['name']); ?></span>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="btn-group shadow-sm rounded-2 overflow-hidden">
                                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-white text-success border-end" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-white text-danger" 
                                           onclick="return confirm('Delete this unit?')" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">No units found. Click Create to add one.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('../includes/footer.php');?>