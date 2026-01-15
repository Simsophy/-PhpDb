<?php
session_start();
include('../config.php');
include('../function.php');

// CRITICAL FIX: Ensure ID is an integer
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // SECURITY FIX: Use the safe integer $id in the query
    // NOTE: Using soft delete (UPDATE SET active=0) is safer than hard DELETE
    $sql = "UPDATE roles SET active = 0 WHERE id = $id";
    
    $x = non_query($sql);

    if ($x) {
        $_SESSION['success'] = "Role successfully deleted (set to inactive)!";
    } else {
        // Provide error details for debugging
        global $conn; 
        $_SESSION['error'] = "Failed to delete role. MySQL Error: " . mysqli_error($conn);
    }
} else {
    $_SESSION['error'] = "Invalid role ID.";
}

header('Location: index.php');
exit;
?>