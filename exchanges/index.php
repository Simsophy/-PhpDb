<?php
// 1. DATA LOGIC FIRST
session_start();
include('../config.php');
include('../function.php');

// ជួសជុល៖ ប្តូរពី kh មកជា khr ឱ្យត្រូវជាមួយ Database Column
$rate_val = scalar_query("SELECT khr FROM exchanges WHERE active = 1 LIMIT 1");
$rate_val = $rate_val ? $rate_val['khr'] : 4000; // ប្រាកដថាទាញយកតម្លៃជាលេខ

if (isset($_POST['btn'])) {
    $khr = mysqli_real_escape_string($conn, $_POST['khr']);
    $usd = mysqli_real_escape_string($conn, $_POST['usd']); 
    $date = date('Y-m-d H:i:s');
    $user_id = $_SESSION['user_id'] ?? 0;

    // បិទអត្រាចាស់ (Deactivate old rates)
    non_query("UPDATE exchanges SET active = 0 WHERE active = 1");

    // បញ្ចូលអត្រាថ្មី (Insert new rate)
    $sql = "INSERT INTO exchanges (usd, khr, date, user_id, active) 
            VALUES ($usd, '$khr', '$date', $user_id, 1)";
    
    // ត្រូវប្រាកដថាឈ្មោះ usd, khr, date, user_id, active មានក្នុង Database ទាំងអស់
$sql = "INSERT INTO exchanges (usd, khr, date, user_id, active) 
        VALUES ($usd, '$khr', '$date', $user_id, 1)";
    if (non_query($sql)) {
        $_SESSION['success'] = "បានធ្វើបច្ចុប្បន្នភាពអត្រាប្តូរប្រាក់ទៅ $khr រៀល";
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['error'] = "ការកែប្រែបរាជ័យ: " . mysqli_error($conn);
    }
}

// 2. FETCH DATA FOR UI
$current = scalar_query("SELECT e.*, u.username FROM exchanges e 
                         JOIN users u ON e.user_id = u.id 
                         WHERE e.active = 1 LIMIT 1");

$history = query("SELECT e.*, u.username FROM exchanges e 
                  JOIN users u ON e.user_id = u.id 
                  WHERE e.active = 0 ORDER BY e.id DESC");

$title = "Exchange Rates";
include('../includes/header.php');
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0"><i class="fas fa-sync-alt text-primary me-2"></i> អត្រាប្តូរប្រាក់ (Exchange Rate)</h4>
        <button class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#exModal">
            + កំណត់អត្រាថ្មី
        </button>
    </div>

    <?php alert_success(); alert_error(); ?>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-4 bg-light">
                <div class="card-body py-2 px-4 d-flex justify-content-between align-items-center">
                    <span class="text-muted small">ឧទាហរណ៍ការគណនា:</span>
                    <span class="fw-bold text-primary">
                        $10.00 = <?= number_format(10 * $rate_val) ?> រៀល 
                        <small class="text-muted fw-normal ms-2">(ផ្អែកលើអត្រា $1 = <?= number_format($rate_val) ?> រៀល)</small>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-primary text-white overflow-hidden">
        <div class="card-body p-4 d-flex align-items-center justify-content-between">
            <div>
                <p class="mb-1 opacity-75">អត្រាបច្ចុប្បន្ន (Active)</p>
                <?php if ($current): ?>
                    <h2 class="fw-bold mb-0">1 USD = <?= number_format($current['khr']) ?> KHR</h2>
                    <small class="opacity-75">កែប្រែចុងក្រោយដោយ: <?= $current['username'] ?> នៅថ្ងៃទី <?= date('d-M-Y H:i', strtotime($current['date'])) ?></small>
                <?php else: ?>
                    <h3 class="mb-0">មិនទាន់មានការកំណត់អត្រានៅឡើយ</h3>
                <?php endif; ?>
            </div>
            <i class="fas fa-coins fa-4x opacity-25"></i>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-muted">ប្រវត្តិអត្រាប្តូរប្រាក់</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light small text-uppercase fw-bold">
                    <tr>
                        <th class="ps-4">កាលបរិច្ឆេទ</th>
                        <th>អត្រា (1 USD)</th>
                        <th>អ្នកកែប្រែ</th>
                        <th class="text-center pe-4">ស្ថានភាព</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($history): foreach ($history as $h): ?>
                 <tr>
    <td><?= date('d-M-Y H:i', strtotime($h['date'])) ?></td>
    <td>1 USD = <?= number_format($h['khr']) ?> KHR</td>
    <td>
        <span class="badge bg-light text-dark">
            <i class="fas fa-user-edit me-1"></i> <?= $h['username'] ?>
        </span>
    </td>
    <td>
        <?= $h['active'] == 1 ? '<span class="text-success">Active</span>' : '<span class="text-muted">Old</span>' ?>
    </td>
</tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="4" class="text-center py-5 text-muted">មិនទាន់មានប្រវត្តិទិន្នន័យ។</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="exModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <form method="post" class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold">កំណត់អត្រាថ្មី</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="small fw-bold text-muted mb-1">រូបិយប័ណ្ណគោល</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text border-0 bg-light">USD</span>
                        <input type="number" name="usd" class="form-control border-0 bg-light shadow-none" value="1" readonly>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold text-muted mb-1">តម្លៃជារៀល (ធៀបនឹង 1$)</label>
                    <input type="number" name="khr" class="form-control border-0 bg-light shadow-none" placeholder="ឧទាហរណ៍: 4100" required>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light btn-sm px-3" data-bs-dismiss="modal">បោះបង់</button>
                <button type="submit" name="btn" class="btn btn-primary btn-sm px-4">រក្សាទុក</button>
            </div>
        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>