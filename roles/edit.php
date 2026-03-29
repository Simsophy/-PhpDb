<?php
session_start();
include('../config.php');
include('../function.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$title = "Edit Role";

if ($id <= 0) {
    $_SESSION['error'] = "Invalid role ID.";
    header("Location: index.php");
    exit;
}

// Fetch role info
$role = scalar_query("SELECT * FROM roles WHERE id=$id");
if (!$role) {
    $_SESSION['error'] = "Role not found.";
    header("Location: index.php");
    exit;
}

// Handle form submission
if (isset($_POST['btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    if (!empty($name)) {
        $sql = "UPDATE roles SET name='$name' WHERE id=$id";
        if (non_query($sql)) {
            $_SESSION['success'] = "Role updated successfully!";
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['error'] = "Failed to update role: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error'] = "Role name cannot be empty.";
    }
}
?>

<?php include('../includes/header.php'); ?>

<div class="container mt-4">
    <h3>Edit Role</h3>
    <p>
        <a href="index.php" class="btn btn-success btn-sm">Back</a>
    </p>

    <?php alert_success(); alert_error(); ?>

    <form method="post">
        <div class="mb-2">
            <label for="name">Role Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" required value="<?= htmlspecialchars($role['name']); ?>">
        </div>

        <div class="mt-3">
            <button class="btn btn-primary btn-sm" type="submit" name="btn">Save</button>
            <a href="index.php" class="btn btn-danger btn-sm">Cancel</a>
        </div>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
