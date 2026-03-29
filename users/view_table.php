<?php
// DEBUGGING: show all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. Include config and functions
include('../config.php');   // $conn must be defined here
include('../function.php'); // optional helpers

// 2. Get table name safely
$table = isset($_GET['table']) ? $_GET['table'] : '';
if (!$table) {
    die("No table specified.");
}

// 3. Validate table name to prevent SQL injection
$allowed_tables = ['categories','companies','employees','exchanges','products','roles','sales','units','users'];
if (!in_array($table, $allowed_tables)) {
    die("Invalid table.");
}

// 4. Fetch all rows
$sql = "SELECT * FROM $table";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

// 5. Fetch columns
$columns = mysqli_fetch_fields($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Table: <?= htmlspecialchars($table) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h3>Table: <?= htmlspecialchars($table) ?></h3>
    <a href="../index.php" class="btn btn-secondary btn-sm mb-3">Back to Dashboard</a>
    <table class="table table-bordered table-striped table-sm">
        <thead>
            <tr>
                <?php foreach ($columns as $col): ?>
                    <th><?= htmlspecialchars($col->name) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <?php foreach ($columns as $col): ?>
                        <td><?= htmlspecialchars($row[$col->name]) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
