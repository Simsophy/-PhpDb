<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: ../login.php"); exit; }

require_once('../config.php');
require_once('../function.php');

// Map database codes to full display names
$langs = [
    'en' => 'English',
    'km' => 'ភាសាខ្មែរ',
    'zh' => 'Chinese'
];

$users = query("SELECT * FROM users ORDER BY id DESC");
include('../includes/header.php'); 
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0"><i class="fas fa-users me-2 text-primary"></i>User Accounts</h4>
        <a href="create.php" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">+ New User</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light small text-uppercase fw-bold text-muted">
                    <tr>
                        <th class="ps-4">Full Name</th>
                        <th>Username</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Language</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users): foreach ($users as $u): 
                        $l_code = strtolower($u['language'] ?? 'en');
                    ?>
                    <tr>
                        <td class="ps-4 fw-bold text-dark"><?= $u['name'] ?></td>
                        <td><code class="text-primary">@<?= $u['username'] ?></code></td>
                        <td class="small"><?= $u['phone'] ?></td>
                        <td class="small text-muted"><?= $u['email'] ?></td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3">
                                <?= strtoupper($u['role']) ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-inline-flex align-items-center bg-light border px-2 py-1 rounded small">
                                <i class="fas fa-globe-asia me-2 text-muted"></i>
                                <?= $langs[$l_code] ?? 'English' ?>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-warning border-0" title="Reset Password"
                                    data-bs-toggle="modal" data-bs-target="#passModal" 
                                    onclick="document.getElementById('uid').value='<?= $u['id'] ?>'">
                                    <i class="fas fa-key"></i>
                                </button>
                                <a href="edit.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-success border-0">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-danger border-0" 
                                   onclick="return confirm('Delete user?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="7" class="text-center py-5">No users found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>