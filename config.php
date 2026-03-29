<?php
// Start session safely (prevents "session already active" notices on shared hosting)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BURL', 'https://phpdb.yzz.me/'); // hosting URL

define('DB_SERVER', 'sql202.yzz.me'); // 
define('USER', 'yzzme_40981778');
define('PASSWORD', 'khIgqdKyZ2aV');
define('DB', 'yzzme_40981778_PHPDB');
define('DB_PORT', 3306);

// --- Application Constants ---
define('SUCCESS_SMS', 'Operation completed successfully!');
define('ERROR_SMS', 'An error occurred. Please try again.');
define('DEL_SUCCESS_SMS', 'Record deleted successfully!');
define('DEL_ERROR_SMS', 'Failed to delete record.');

// Create connection
$conn = new mysqli(DB_SERVER, USER, PASSWORD, DB, DB_PORT);

// DEBUG (remove after testing)
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
