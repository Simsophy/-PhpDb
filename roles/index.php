<?php
session_start();
include('../config.php');
include('../function.php');

$title = "Roles";

// Fetch all active roles
$result = query("SELECT * FROM roles WHERE active = 1 ORDER BY id DESC");

?>

<?php include('../includes/header.php'); ?>

<div class="container mt-4">
    <h2>Roles</h2>

    <p>
        <a href="create.php" class="btn btn-primary btn-sm">Create</a>
        <a href="../index.php" class="btn btn-success btn-sm">Back</a>
    </p>

    <?php alert_success(); ?>
    <?php alert_error(); ?>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($result) && is_array($result)): ?>
                <?php $i = 1; ?>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                            <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this role?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No roles found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>
