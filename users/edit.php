<?php
// DEBUG: show errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// 1. Check login
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

// 2. Include config and functions
include('../config.php');
include('../function.php');

$title = "Edit User Profile";

// 3. Get user ID and validate
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    $_SESSION['error'] = "Invalid User ID.";
    header("Location: index.php");
    exit;
}

// 4. Fetch user info
$user = scalar_query("SELECT * FROM users WHERE id=$id");
if (!$user) {
    $_SESSION['error'] = "User not found.";
    header("Location: index.php");
    exit;
}

// 5. Fetch roles for dropdown
$roles = query("SELECT * FROM roles WHERE active=1");

// 6. Handle form submission
if (isset($_POST['btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $language = mysqli_real_escape_string($conn, $_POST['language']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Password handling
    $password_sql = "";
    if (!empty($_POST['password'])) {
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password_sql = ", password='$hashed_password'";
    }

    $sql = "UPDATE users SET 
        name='$name',
        phone='$phone',
        email='$email',
        language='$language',
        role='$role'
        $password_sql
        WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "User details updated successfully.";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error'] = "Update failed: " . mysqli_error($conn);
    }
}
?>

<?php include('../includes/header.php'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-dark m-0">Edit User Profile</h3>
                    <p class="text-muted small mb-0">Modify account details and permissions for <strong><?= htmlspecialchars($user['username'] ?? ''); ?></strong></p>
                </div>
                <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>

            <?php alert_success(); alert_error(); ?>

            <form method="post">
                <div class="row g-4">
                    <div class="col-md-7">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4">
                                <h6 class="text-uppercase fw-bold text-primary mb-4 small">Personal Information</h6>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Full Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                        <input type="text" name="name" class="form-control border-start-0 ps-0 shadow-none" required
                                            value="<?= htmlspecialchars($user['name'] ?? ''); ?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone text-muted"></i></span>
                                            <input type="text" name="phone" class="form-control border-start-0 ps-0 shadow-none"
                                                value="<?= htmlspecialchars($user['phone'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                            <input type="email" name="email" class="form-control border-start-0 ps-0 shadow-none"
                                                value="<?= htmlspecialchars($user['email'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">System Language</label>
                                        <select name="language" class="form-select bg-light shadow-none">
    <option value="en" <?= ($user['language'] ?? '') == 'en' ? 'selected' : ''; ?>>English</option>
    <option value="km" <?= ($user['language'] ?? '') == 'km' ? 'selected' : ''; ?>>ភាសាខ្មែរ</option>
    <option value="ch" <?= ($user['language'] ?? '') == 'ch' ? 'selected' : ''; ?>>Chinese</option>
</select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">Assigned Role</label>
                                        <select name="role" class="form-select bg-light shadow-none">
                                            <?php foreach($roles as $r): ?>
                                                <option value="<?= htmlspecialchars($r['name'] ?? ''); ?>" <?= ($user['role'] ?? '') == $r['name'] ? 'selected' : ''; ?>>
                                                    <?= htmlspecialchars($r['name'] ?? ''); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h6 class="text-uppercase fw-bold text-danger mb-4 small">Account Security</h6>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Username</label>
                                    <input type="text" class="form-control bg-light text-muted border-0 fw-bold" disabled
                                        value="<?= htmlspecialchars($user['username'] ?? ''); ?>">
                                    <div class="form-text smaller text-muted mt-2">Username cannot be changed for audit security.</div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold">Change Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                        <input type="password" name="password" class="form-control border-start-0 ps-0 shadow-none" placeholder="New Password">
                                    </div>
                                    <div class="form-text smaller text-info mt-2">
                                        <i class="fas fa-info-circle me-1"></i> Leave blank to keep current password.
                                    </div>
                                </div>

                                <hr class="opacity-25 my-4">

                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary py-2 rounded-3 fw-bold shadow-sm" type="submit" name="btn">
                                        <i class="fas fa-check-circle me-2"></i>Update Account
                                    </button>
                                    <a href="index.php" class="btn btn-light py-2 rounded-3 border text-secondary fw-bold">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>