<?php
session_start(); 

include('../config.php');
$title = "Exchanges";
include('../function.php');


if(isset($_POST['btn'])){
    // CRITICAL FIX: Sanitize and validate input to prevent SQL Injection
    $khr = mysqli_real_escape_string($conn, $_POST['khr']);
    // BUG FIX: The modal form is missing the 'usd' input for the POST data
    // Assuming 1 USD is the implicit USD value for the exchange rate update.
    // If the 'usd' field was added to the form: $usd = mysqli_real_escape_string($conn, $_POST['usd']);
    $usd = 1; // Assuming 1 USD is the fixed base

    $date = date('Y-m-d H:i:s'); // Use standard format
    
    // FIX: Check if session variable is set before using it
    $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0; 

    // 1a. Deactivate old rates
    // Assuming 'non_query' uses $conn, this sets all current active rates to inactive (active=0)
    non_query("UPDATE exchanges SET active = 0 WHERE active = 1"); 
    
    // 1b. Insert new rate
    // CRITICAL FIX: Ensure $usd is included in the query, as the table structure requires it.
    // Use prepared statements or at least intval() for numeric user_id, and sanitize strings.
    $x = non_query("INSERT INTO exchanges (usd, khr, date, user_id, active)
                   VALUES($usd, '$khr', '$date', $user_id, 1)"); // active=1 is essential

    if($x){
        $_SESSION['success'] = SUCCESS_SMS;
        header('Location: index.php'); // 'location' is safer than 'location'
        exit;
    } else {
        // FIX: Provide detailed error message for debugging
        global $conn;
        $_SESSION['error'] = ERROR_SMS . " | MySQL Error: " . mysqli_error($conn);
    }
}

// --- 2. FETCH DATA ---
// FIX: scalar_query only returns one row. Use query() if you want an array.
// But since this is the CURRENT rate, fetching only one row is correct.
// The use of scalar_query is prone to error if multiple active rates exist.
$current_rate_result = scalar_query("SELECT exchanges.*, users.username FROM exchanges 
                                     JOIN users ON exchanges.user_id = users.id 
                                     WHERE exchanges.active=1 ORDER BY exchanges.id DESC LIMIT 1");

// FIX: query() returns an array, not a mysqli result object.
$old_rates = query("SELECT exchanges.*, users.username FROM exchanges 
                    JOIN users ON exchanges.user_id = users.id 
                    WHERE exchanges.active=0 ORDER BY exchanges.id DESC");

// Set $exc to an empty array if no current rate is found, preventing 'Undefined array key' errors
$exc = $current_rate_result ?: [];
?>

<?php include('../includes/header.php');?>
    <div class="container">
        <?php alert_success(); ?>
    <?php alert_error(); ?>
        <h2>Exchanges</h2>
        <p>
            <button class="btn btn-primary btn-sm" type="button" data-bs-target='#exModal' data-bs-toggle="modal">Set New Rate</button>
            <a href="../index.php" class="btn btn-success btn-sm">Back</a>
        </p>

        <?php 
            alert_error();
            alert_success();
        ?>
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>USD</th>
                    <th>KHR</th>
                    <th>Date Time</th>
                    <th>User</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($exc)): ?>
                    <tr>
                        <td><?= htmlspecialchars($exc['id'] ?? ''); ?></td>
                        <td><?= htmlspecialchars($exc['usd'] ?? '1'); ?></td>
                        <td><?= htmlspecialchars($exc['khr'] ?? ''); ?></td>
                        <td><?= htmlspecialchars($exc['date'] ?? ''); ?></td>
                        <td><?= htmlspecialchars($exc['username'] ?? ''); ?></td>
                        <td>
                            <button class="btn btn-success btn-sm" type="button" data-bs-target='#exModal'
                            data-bs-toggle="modal">Edit</button>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-danger">No Current Exchange Rate Set. Please set a new rate.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tbody>
                <?php if (is_array($old_rates) && count($old_rates) > 0): ?>
                    <?php $i = 1; ?>
                    <?php foreach ($old_rates as $row): ?> 
                        <tr>
                            <td class="text-muted"><?= htmlspecialchars($row['id'] ?? ''); ?></td>
                            <td class="text-muted"><?= htmlspecialchars($row['usd'] ?? ''); ?>$</td>
                            <td class="text-muted"><?= htmlspecialchars($row['khr'] ?? ''); ?>KHR</td>
                            <td class="text-muted"><?= htmlspecialchars($row['date'] ?? ''); ?></td>
                            <td class="text-muted"><?= htmlspecialchars($row['username'] ?? ''); ?></td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-info">No history of old rates found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table> 
    </div>

    <div class="modal fade" id="exModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5">Update Exchange Rate</h3>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="usd">USD (Base)</label>
                            <input type="number" class="form-control" id="usd" name="usd" value="1" readonly>
                        </div>
                        <div class="form-group">
                            <label for="khr">KHR Rate (to 1 USD)</label>
                            <input type="number" class="form-control" id="khr" name="khr" required step="0.01">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary btn-sm" type="submit" name="btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include('../includes/footer.php');?>