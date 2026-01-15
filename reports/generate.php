<?php
// reports/generate.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../function.php';

// --- 1. COLLECT & SANITIZE INPUT ---

// Get parameters from the URL (submitted by reports/index.php form)
$report_type = $_GET['type'] ?? '';
$start_date  = $_GET['start_date'] ?? null;
$end_date    = $_GET['end_date'] ?? null;
$category_id = $_GET['category_id'] ?? null;

// Set default title
$title = strtoupper(str_replace('_', ' ', $report_type)) . " Report";

// --- 2. DETERMINE SQL QUERY & RUN ---

$data = [];
$sql = '';
$message = "Report Data";

if ($report_type === 'low_stock') {
    // Report: Low Stock Alerts
    $sql = "SELECT p.code, p.name, p.onhand, p.low_stock, c.name AS category_name
            FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE p.onhand <= p.low_stock";
    $message = "Low Stock Products";

} else if ($report_type === 'sales_history') {
    // Report: Sales History
    // **Requires the 'sales' table**
    $sql = "SELECT s.sale_date, p.name AS product_name, s.quantity, s.unit_price, s.total_price 
            FROM sales s
            JOIN products p ON s.product_id = p.id
            WHERE 1=1"; // Start of conditions

    // Add Date Filtering
    if ($start_date) {
        $sql .= " AND s.sale_date >= '{$start_date} 00:00:00'";
    }
    if ($end_date) {
        $sql .= " AND s.sale_date <= '{$end_date} 23:59:59'";
    }
    // Add Category Filtering
    if ($category_id) {
        $sql .= " AND p.category_id = '{$category_id}'";
    }
    $sql .= " ORDER BY s.sale_date DESC";
    $message = "Sales History";
    
} else if ($report_type === 'inventory_summary') {
    // Report: Inventory Summary
    $sql = "SELECT p.code, p.name, p.onhand, p.price, c.name AS category_name, u.name AS unit_name 
            FROM products p
            JOIN categories c ON p.category_id = c.id
            JOIN units u ON p.unit_id = u.id
            ORDER BY p.name ASC";
    $message = "Current Inventory Summary";
} 
// Add logic here for 'user_logins' and 'customer_activity'

// Execute query only if a valid report type was selected
if (!empty($sql)) {
    $data = query($sql); // Assumes query() returns an array of results
}

// --- 3. DISPLAY THE PAGE & RESULTS ---

include('../includes/header.php'); 
?>

<div class="container mt-4">
    <h3 class="mb-4"><?=$title;?></h3>
    <a href="index.php" class="btn btn-secondary btn-sm mb-3">← Back to Reports Hub</a>
    
    <div class="alert alert-info py-2">
        <small>
            <strong>Report Type:</strong> <?= htmlspecialchars($message) ?> |
            <strong>Dates:</strong> <?=$start_date ? date('Y-m-d', strtotime($start_date)) : 'All Time';?> to <?=$end_date ? date('Y-m-d', strtotime($end_date)) : 'Current';?> | 
            <strong>Category ID:</strong> <?=$category_id ?? 'All';?>
        </small>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            
            <?php if (!empty($data)): ?>
                <h6 class="mb-3">Results (<?=count($data);?> Records)</h6>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead class="table-dark">
                            <tr>
                                <?php foreach (array_keys($data[0]) as $key): ?>
                                    <th><?= htmlspecialchars(str_replace('_', ' ', $key)); ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $row): ?>
                                <tr>
                                    <?php foreach ($row as $value): ?>
                                        <td><?= htmlspecialchars($value); ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
                    <button onclick="window.print()" class="btn btn-secondary me-2">Print Report</button>
                    <a href="export.php?type=<?=$report_type;?>&start_date=<?=$start_date;?>&end_date=<?=$end_date;?>&category_id=<?=$category_id;?>" class="btn btn-success">Export to CSV</a>
                </div>

            <?php else: ?>
                <div class="alert alert-warning">No data found for the selected criteria.</div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php 
include('../includes/footer.php'); 
?>