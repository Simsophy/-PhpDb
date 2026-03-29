<?php
require_once('../config.php');
require_once('../function.php');

$title = "Edit Companies Info";

// Ensure session started
if (session_status() == PHP_SESSION_NONE) session_start();

// Fetch company info
$com = scalar_query("SELECT * FROM companies WHERE id=1");

if (!$com) {
    $_SESSION['error'] = "Company record not found!";
    header("Location: index.php");
    exit();
}

// Handle form submission
if (isset($_POST['btn'])) {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $description = trim($_POST['description']);
    $txt = "";

    // Upload logo if selected
    $path = upload('logo', 'uploads/companies/');
    if ($path != '') {
        $txt = ", logo='$path'";
    }

    $update = "UPDATE companies SET 
                name='$name', 
                phone='$phone', 
                email='$email', 
                address='$address', 
                description='$description' 
                $txt 
               WHERE id=1";

    $x = non_query($update);

    if ($x) {
        $_SESSION['success'] = SUCCESS_SMS;
        header('Location: index.php');
        exit();
    } else {
        $_SESSION['error'] = ERROR_SMS;
    }
}

?>
<?php
require_once('../config.php');
require_once('../function.php');

$title = "Edit Companies Info";

if (session_status() == PHP_SESSION_NONE) session_start();

$com = scalar_query("SELECT * FROM companies WHERE id=1");

if (!$com) {
    $_SESSION['error'] = "Company record not found!";
    header("Location: index.php");
    exit();
}

if (isset($_POST['btn'])) {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $description = trim($_POST['description']);
    $txt = "";

    $path = upload('logo', 'uploads/companies/');
    if ($path != '') {
        $txt = ", logo='$path'";
    }

    $update = "UPDATE companies SET 
                name='$name', 
                phone='$phone', 
                email='$email', 
                address='$address', 
                description='$description' 
                $txt 
               WHERE id=1";

    $x = non_query($update);

    if ($x) {
        $_SESSION['success'] = "Updated successfully!";
        header('Location: index.php');
        exit();
    } else {
        $_SESSION['error'] = "Failed to update!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        <style>
body { 
    background-color: #f8f9fa; 
    font-family: 'Segoe UI', sans-serif; 
}

h4 {
    font-weight: 600;
    margin-bottom: 20px;
    color: #1e293b;
}

.btn {
    font-weight: 500;
    border-radius: 8px;
}

form {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}

.form-label {
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #475569;
}

.form-control {
    border-radius: 8px;
    padding: 10px 12px;
    border: 1px solid #cbd5e1;
}

.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}

.img-container {
    background: #f1f5f9;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 15px;
    text-align: center;
}

#imgPreview {
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    max-width: 100%;
    max-height: 200px;
    object-fit: contain;
}

.btn-save {
    padding: 10px 25px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    background-color: #3b82f6;
    border-color: #3b82f6;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(59, 130, 246, 0.3);
}

.row.mb-3 {
    margin-bottom: 15px !important;
}

.cancel-btn {
    background-color: #ef4444;
    border-color: #ef4444;
    margin-right: 10px;
}
</style>

    </style>
<div class="container mt-4">
    <h4>Edit Company Info</h4>
    <p>
        <a href="index.php" class="btn btn-success btn-sm">Back</a>
    </p>
    
    <form method="post" enctype="multipart/form-data">
        <?php alert_error(); ?>
        <div class="row">
            <!-- Left side -->
            <div class="col-sm-6">
                <div class="mb-3 row">
                    <label for="name" class="col-sm-3 col-form-label">Name <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" id="name" required value="<?= htmlspecialchars($com['name']); ?>">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="phone" id="phone" value="<?= htmlspecialchars($com['phone']); ?>">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-sm-3 col-form-label">Email <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" name="email" id="email" required value="<?= htmlspecialchars($com['email']); ?>">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="address" class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="address" id="address" value="<?= htmlspecialchars($com['address']); ?>">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="description" class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" rows="3" name="description" id="description"><?= htmlspecialchars($com['description']); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Right side -->
           <div class="col-sm-6">
    <div class="mb-3 row">
        <label for="logo" class="col-sm-3 col-form-label">Logo</label>
        <div class="col-sm-9">
            <input type="file" class="form-control" name="logo" accept="image/*" id="logo" onchange="preview(event)">
            <div class="img-container mt-3">
                <img src="<?= htmlspecialchars(BURL . $com['logo']); ?>" alt="Logo" width="120" id="imgPreview">
            </div>
             <div class="mt-3">
        <a href="index.php" class="btn btn-danger btn-sm cancel-btn">Cancel</a>
        <button type="submit" class="btn btn-primary btn-sm btn-save" name="btn">Save</button>
    </div>
        </div>
    </div>
   
</div>
        </div>            
    </form>
    
</div>

<script>
function preview(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('imgPreview');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<?php include('../includes/footer.php'); ?>
