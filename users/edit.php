<?php
// edit.php (TOP OF FILE)

include('../config.php');
include('../function.php');

// Database Connection Setup (Assumed to be here or in config.php)
// NOTE: Ideally, $conn should be defined once in config.php.
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "php"; // Ensure this is the correct database name
$port='3307'; 

// Create connection (Using mysqli procedural style)
$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// End of connection setup

// 2. Define and Sanitize $id
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0; 

// Stop execution if the ID is missing or invalid before proceeding to database operations.
if ($id <= 0) {
    die("Invalid or Missing User ID for Edit.");
}

// 3. Fetch Roles
// NOTE: Assuming your 'roles' table now has the 'active' column, or you fixed the query.
$roles = query("select * from roles where active=1");

?>
<?php include('../includes/header.php'); ?>

<div class="container">
    <h3><?= $title; ?> List</h3>
    
    <?php alert_success(); ?>
    <?php alert_error(); ?> 
<?php $title = "Edit Users"; ?>
<?php include('../includes/header.php'); ?>
<?php

    if(isset($_POST['btn']))
    {
        // 1. Sanitize all user-provided strings using mysqli_real_escape_string
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $language = mysqli_real_escape_string($conn, $_POST['language']);
        
        // 2. Cast role_id to integer (for added safety if not using prepared statements)
        $role_id = (int)$_POST['role_id']; 
        
        $password = $_POST['password'];

        $psw = "";
        if($password!=''){
            // 3. CRITICAL FIX: Use password_hash() instead of MD5()
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); 
            $psw = ",password='$hashed_password'";
        }

        // 4. Secure SQL Query Construction (using sanitized variables and casting)
        $sql = "UPDATE users SET
            name='$name', phone='$phone', email='$email', language='$language', role_id=$role_id $psw 
            WHERE id=$id";

        $x = non_query($sql);
        if ($x) {
            $_SESSION['success'] = SUCCESS_SMS;
        }
        else{
            // Include MySQL error for easier debugging (remove in production)
            $_SESSION['error'] = ERROR_SMS . " | SQL Error: " . mysqli_error($conn); 
        }
    }
    
    // 5. Secure Data Fetching for form display
    // CRITICAL FIX: Ensuring $id is cast to int for safe query
    $user = scalar_query("select * from users where id = $id");
    
    // Safety check after fetch
    if (!$user) {
        $_SESSION['error'] = "User data not found.";
        header('Location: index.php');
        exit;
    }
    
?>

    <div class="container">

        <h3>Edit Users</h3>
        <p>
            <a href="index.php" class="btn btn-success btn-sm">Back</a>
        </p>

        <form method = "post">
            <?php alert_success(); alert_error(); ?>

            <div class="row">
                <div class="col-sm-6">

                    <div class="row">
                        <label for="name" class="col-sm-3" >Name
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="name" class= "form-control" required
                            value="<?=htmlspecialchars($user['name']);?>">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <label for="phone" class="col-sm-3" >Phone</label>
                        <div class="col-sm-9">
                            <input type="text" name="phone" id="phone" class="form-control"
                            value="<?=htmlspecialchars($user['phone']);?>">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <label for="email" class="col-sm-3">Email</label>
                        <div class="col-sm-9">
                            <input type="email" name="email" id="email" class="form-control"
                            value="<?=htmlspecialchars($user['email']);?>">
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <label for="language" class="col-sm-3" >Language</label>
                        <div class="col-sm-9">
                            <select name="language" id="language" class="form-control">
                                <option value="en" <?= ($user['language'] ?? '') == 'en' ? 'selected' : '' ;?>>English</option>
                                <option value="km" <?= ($user['language'] ?? '') == 'km' ? 'selected' : '' ;?>>ភាសាខ្មែរ</option>
                                </select>
                        </div>
                    </div> 

                    <div class="row mt-2">
                        <label for="role_id" class="col-sm-3" >Role</label>
                        <div class="col-sm-9">
                            <?=bind($roles, 'role_id', $user['role']);?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="row">
                        <label for="username" class="col-sm-3">Username</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="username" id="username" disabled
                            value="<?=htmlspecialchars($user['username']);?>">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <label for="password" class="col-sm-3">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password" id="password">
                            <small>keep it blank to use the old password.</small>
                            <div class="col-sm-3 mt-2">
                                <button class="btn btn-primary btn-sm" name="btn" >Save</button>
                                
                                <a href="edit.php?id=<?=$id;?>" class="btn btn-danger btn-sm" >Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php include('../includes/footer.php'); ?>