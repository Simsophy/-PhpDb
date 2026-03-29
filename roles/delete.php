<?php
// Start session for flash messages
session_start();

// Include database config and helper functions
include('../config.php');    // defines $conn
include('../function.php');  // non_query(), etc.

// 1. Get the ID from URL and validate it
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    $_SESSION['error'] = "Invalid Role ID.";
    header("Location: index.php");
    exit;
}

// 2. Check if `active` column exists for soft delete
$softDelete = false;
$result = mysqli_query($conn, "SHOW COLUMNS FROM roles LIKE 'active'");
if ($result && mysqli_num_rows($result) > 0) {
    $softDelete = true;
}

// 3. Perform delete
if ($softDelete) {
    // Soft delete: set active = 0
    $sql = "UPDATE roles SET active = 0 WHERE id = $id";
    $actionText = "soft-deleted";
} else {
    // Hard delete
    $sql = "DELETE FROM roles WHERE id = $id";
    $actionText = "deleted";
}

// 4. Execute the query and handle errors
if (mysqli_query($conn, $sql)) {
    $_SESSION['success'] = "Role successfully $actionText!";
} else {
    $_SESSION['error'] = "Failed to delete role: " . mysqli_error($conn);
}

// 5. Redirect back to role index
header("Location: index.php");
exit;
?>
