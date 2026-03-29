<?php
session_start();
include('../config.php');
include('../function.php');

$title = "Create Role";

// Handle form submission
if (isset($_POST['btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    if (!empty($name)) {
        $sql = "INSERT INTO roles (name) VALUES ('$name')";
        if (non_query($sql)) {
            $_SESSION['success'] = "Role created successfully!";
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['error'] = "Failed to create role: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error'] = "Role name cannot be empty.";
    }
}
?>

<?php include('../includes/header.php'); ?>

<div class="container mt-4">
    <h3>Create Role</h3>
    <p>
        <a href="index.php" class="btn btn-success btn-sm">Back to Roles</a>
    </p>

    <?php alert_success(); alert_error(); ?>

    <form method="post">
        <div class="mb-2">
            <label for="name">Role Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" required autofocus>
        </div>

        <div class="mt-3">
            <button class="btn btn-primary btn-sm" type="submit" name="btn">Create</button>
            <a href="index.php" class="btn btn-danger btn-sm">Cancel</a>
        </div>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
