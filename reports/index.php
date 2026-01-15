<?php
// reports/index.php

// Set the page title before including the header
$title = "Reports Hub"; 

// Includes necessary files for security, functions, and layout
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../function.php';

// --- DATA FETCH FOR CATEGORY FILTER ---
// Fetch all categories to populate the dropdown filter
// Assumes query() returns an array of associative rows.
$categories = query("SELECT id, name FROM categories ORDER BY name ASC");
// ------------------------------------

include('../includes/header.php'); 
?>

<div class="container mt-4">
    <?php 
    // Display alert messages (Success/Error)
    // NOTE: This assumes alert_success() and alert_error() are defined in function.php
    alert_success(); 
    alert_error(); 
    ?>

    <h3 class="mb-4">Generate Application Reports</h3>
    <p class="text-muted">Select the type of report you wish to generate and specify the filtering criteria.</p>

    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <form action="generate.php" method="GET">
                
                <div class="row g-3">
                    
                    <div class="col-md-4">
                        <label for="report_type" class="form-label">Report Type</label>
                        <select class="form-select" id="report_type" name="type" required>
                            <option value="">-- Select Report --</option>
                            <option value="inventory_summary">Inventory Summary</option>
                            <option value="low_stock">Low Stock Alerts</option>
                            <option value="sales_history">Sales History</option>
                            <option value="customer_activity">Customer Activity</option>
                            <option value="user_logins">User Login Activity</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date">
                    </div>

                    <div class="col-md-4">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
                    </div>

                    <div class="col-md-4">
                        <label for="category_id" class="form-label">Filter by Category (Optional)</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">All Categories</option>
                            
                            <?php 
                            if (!empty($categories)) {
                                foreach ($categories as $cat) {
                                    echo '<option value="' . htmlspecialchars($cat['id']) . '">' . htmlspecialchars($cat['name']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary btn-lg">Generate Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div id="report-output">
    </div>
</div>

<?php 
include('../includes/footer.php'); 
?>