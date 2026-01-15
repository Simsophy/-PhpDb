<?php
function query($sql)

{
    global $conn;
    if (!$conn) {
        die("Database connection is not established in function.php");
    }

    // Safety: only allow SELECT
    if (stripos(trim($sql), 'SELECT') !== 0) {
        die("Invalid use of query(): only SELECT statements are allowed.");
    }

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("SQL Error: " . mysqli_error($conn));
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}






// Scalar select: returns single row
function scalar_query($sql){
    global $conn;
    if (!$conn) { 
        error_log("FATAL: Database connection is not established.");
        die("System error. Please try again later.");
    }
    
    $row = [];
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
    
    // Free result for memory
    if (isset($result) && is_object($result)) {
        mysqli_free_result($result); 
    }
    return $row;
}

// Non-query (INSERT/UPDATE/DELETE): returns true/false
function non_query($sql){
    global $conn;
    if (!$conn) { 
        error_log("FATAL: Database connection is not established.");
        die("System error. Please try again later.");
    }
    
    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        error_log("Non-query failed: " . mysqli_error($conn) . " SQL: " . $sql);
        return false;
    }
    return true;
}


// --- UI AND UTILITY FUNCTIONS ---

// Success alert display
function alert_success() {
    // Relying on session_start() in the main script now
    $sms = "";
    if (isset($_SESSION['success'])) {
        $txt = htmlspecialchars($_SESSION['success']);
        $sms = "
            <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                <strong>Information!</strong> $txt
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
            </div>
        ";
        unset($_SESSION['success']);
    }
    echo $sms;
}

// Error alert display
function alert_error() {
    // Relying on session_start() in the main script now
    $sms = "";
    if (isset($_SESSION['error'])) {
        $txt = htmlspecialchars($_SESSION['error']);
        $sms = "
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                <strong>Warning!</strong> $txt
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
            </div>
        ";
        unset($_SESSION['error']);
    }
    echo $sms;
}

// Upload function
function upload($name, $dir) {
    if (!isset($_FILES[$name]) || $_FILES[$name]['error'] !== UPLOAD_ERR_OK) {
        return "";
    }

    // Safety check: remove leading/trailing slashes and ensure it ends with one
    $dir = trim($dir, '/') . '/'; 
    
    // Construct the absolute path to the intended upload directory 
    // This assumes the upload directory is relative to the *project root* (one level up from function.php)
    $project_root = dirname(__DIR__);
    $upload_dir = $project_root . '/' . $dir; 

    // Create directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            error_log("Failed to create upload directory: " . $upload_dir);
            return "";
        }
    }

    $ext = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
    $path = $dir . md5(microtime() . uniqid()) . "." . $ext; // Added uniqid for better entropy
    
    $target_file = $project_root . '/' . $path;
    
    if (move_uploaded_file($_FILES[$name]['tmp_name'], $target_file)) {
        return $path;
    }
    error_log("Failed to move uploaded file to: " . $target_file);
    return "";
}


function bind($data, $inputName, $selectedValue = null) {
    // Start the <select> element
    $output = '<select name="' . htmlspecialchars($inputName) . '" id="' . htmlspecialchars($inputName) . '" class="form-control">';
    
    // Add a default or blank option
    $output .= '<option value="">-- Select Role --</option>';

    // Loop through the data array to create <option> tags
    if (is_array($data)) {
        foreach ($data as $row) {
            // Assuming your roles table has 'id' for the value and 'name' for the display text
            $id = $row['id'] ?? '';
            $name = $row['name'] ?? '';
            
            // Determine if the current option should be selected
            $selected = ($id == $selectedValue) ? 'selected' : '';
            
            // Build the option tag
            $output .= '<option value="' . htmlspecialchars($id) . '" ' . $selected . '>' . htmlspecialchars($name) . '</option>';
        }
    }

    // End the <select> element
    $output .= '</select>';
    
    return $output;
}
?>