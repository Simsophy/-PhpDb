<?php
// START: Added missing includes and session management
// NOTE: Best practice is to have session_start() in header.php or config.php, 
// but it is placed here for completeness if those files are not doing it.
// We must include files that define $conn and the constants.
include('../config.php'); 
include('../function.php');

// Ensure session is started before accessing $_SESSION
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// END: Added missing includes and session management

$title = "Create Units";
// Assuming header.php is included here
?> 
<?php include('../includes/header.php'); ?>
 
<?php  
    if(isset($_POST['btn'])){
        // CRITICAL FIX: Ensure $conn is accessible and sanitize the input to prevent SQL Injection
        global $conn;
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        
        $sql = "INSERT INTO units (name) VALUES ('$name')";

        $x = non_query($sql);
        
        if ($x) {
    $_SESSION['success'] = "Unit created successfully!";
} else {
    $_SESSION['error'] = "Failed to create unit !";
}
            header('Location: index.php'); 
            exit;
        }
        
    
?>

    <div class="container">
        <h3>Create Units</h3>
        <p>
            <a href="index.php" class="btn btn-success btn-sm">Back</a>
        </p>
        <form method="post">
            <?php 
            // FIX: Remove alert calls from here since the page redirects on success 
            // The alerts should only be called on index.php to display the message.
            alert_error(); 
            ?>
            <div class="row">
                <div class="col-sm-6">

                    <div class="form-group">
                        <label for="name">Name
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name" class="form-control" required="required" autofocus>
                    </div>  

                    <div class="form-group mt-3">
                        <button class="btn btn-primary btn-sm" name="btn">Save</button>
                        <a href="index.php" class="btn btn-danger btn-sm">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php include('../includes/footer.php'); ?>