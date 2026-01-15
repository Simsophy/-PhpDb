<?php
// --- APPLICATION CONSTANTS ---
define('APP_NAME', 'MY STOCK');
define('BURL', 'http://localhost/phpdb/');

// --- DATABASE CONSTANTS ---
define('DB_SERVER', '127.0.0.1'); 
define('USER', 'root');
define('PASSWORD', '');
define('DB', 'php');
define('DB_PORT', 3307); 

// ... database connection setup goes here ...

// --- Application Constants ---
// Define SUCCESS and ERROR messages used across the application
define('SUCCESS_SMS', 'Operation completed successfully!');
define('ERROR_SMS', 'An error occurred. Please try again.');

// If you are using DEL_SUCCESS_SMS (as seen in roles/edit.php) define those too:
define('DEL_SUCCESS_SMS', 'Record deleted successfully!');
define('DEL_ERROR_SMS', 'Failed to delete record.');


// --- DATABASE CONNECTION ---
$conn = mysqli_connect(DB_SERVER, USER, PASSWORD, DB, DB_PORT);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error() . 
        " (Error No: " . mysqli_connect_errno() . ")");
}

mysqli_set_charset($conn, "utf8");
?>
