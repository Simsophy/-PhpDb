<?php
require_once('../config.php');
require_once('../function.php');

// 1. ទាញយកអត្រាប្តូរប្រាក់បច្ចុប្បន្ន (Current Exchange Rate)
$rate_data = scalar_query("SELECT khr FROM exchanges WHERE active = 1 LIMIT 1");
$current_rate = $rate_data ? $rate_data['khr'] : 4000; // តម្លៃ default បើរកមិនឃើញ

// 2. Data Logic & Sanitization
$cid = $_GET['cid'] ?? 'all'; 
$q = $_GET['q'] ?? '';

$cats = query("SELECT * FROM categories"); 

$sql = "SELECT p.*, c.name as catname, u.name as unit 
        FROM products p
        INNER JOIN categories c ON p.category_id = c.id
        INNER JOIN units u ON p.unit_id = u.id 
        WHERE p.active=1";

if ($cid !== 'all') { 
    $safe_cid = mysqli_real_escape_string($conn, $cid);
    $sql .= " AND p.category_id = '{$safe_cid}'"; 
}

if (!empty($q)) { 
    $safe_q = mysqli_real_escape_string($conn, $q);
    $sql .= " AND (p.code LIKE '%{$safe_q}%' OR p.name LIKE '%{$safe_q}%')"; 
}

$products = query($sql); 
$title = "Inventory Management";

include('../includes/header.php'); 
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold m-0"><i class="fas fa-boxes text-primary me-2"></i> តុល្យភាពស្តុក (Inventory)</h4>
            <small class="text-muted">អត្រាប្តូរប្រាក់បច្ចុប្បន្ន: <strong>$1 = <?= number_format($current_rate) ?> ៛</strong></small>
        </div>
        <a href="create.php" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
            <i class="fas fa-plus me-1"></i> ថែមទំនិញថ្មី
        </a>
    </div>

    <?php alert_success(); alert_error(); ?>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-md-3">
                    <select name="cid" class="form-select form-select-sm border-0 bg-light shadow-none">
                        <option value="all">គ្រប់ប្រភេទទំនិញ</option>
                        <?php foreach($cats as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($cid == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-7">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text border-0 bg-light"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="q" class="form-control border-0 bg-light shadow-none" 
                               placeholder="ស្វែងរកតាមលេខកូដ ឬឈ្មោះទំនិញ..." value="<?= htmlspecialchars($q) ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark btn-sm w-100 rounded-3">ស្វែងរក</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">លេខកូដ</th>
                        <th>ឈ្មោះទំនិញ</th>
                        <th>តម្លៃលក់ (USD/KHR)</th>
                        <th>ចំនួនក្នុងស្តុក</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($products)): ?>
                        <?php foreach($products as $p): ?>
                            <?php 
                                // គណនាតម្លៃជារៀលអូតូ
                                $price_khr = $p['price'] * $current_rate; 
                            ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-light text-primary border-0 font-monospace">
                                        <?= htmlspecialchars($p['code']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($p['name']) ?></div>
                                    <div class="text-muted smaller"><?= htmlspecialchars($p['catname']) ?></div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">$<?= number_format($p['price'], 2) ?></div>
                                    <div class="text-primary small"><?= number_format($price_khr) ?> ៛</div>
                                </td>
                                <td>
                                    <span class="fs-6 fw-bold <?= ($p['onhand'] <= $p['low_stock']) ? 'text-danger' : '' ?>">
                                        <?= $p['onhand'] ?>
                                    </span> 
                                    <small class="text-muted"><?= $p['unit'] ?></small>
                                    <?php if($p['onhand'] <= $p['low_stock']): ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger ms-1 px-2">
                                            <i class="fas fa-exclamation-triangle small"></i> ស្តុកទាប
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm rounded-2 overflow-hidden">
                                        <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-white text-success border-end">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-white text-danger"
                                           onclick="return confirm('តើអ្នកចង់លុបទំនិញនេះមែនទេ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center py-5 text-muted">មិនមានទិន្នន័យទំនិញឡើយ។</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>