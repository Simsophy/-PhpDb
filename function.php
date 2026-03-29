<?php
// 1. Database Query Functions
function query($sql) {
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

function scalar_query($sql) {
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
    
    if (isset($result) && is_object($result)) {
        mysqli_free_result($result); 
    }
    return $row;
}

function non_query($sql) {
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

// 2. UI Utility Functions
function bind($data, $inputName, $selectedValue = null, $placeholder = "Select Option") {
    $output = '<select name="' . htmlspecialchars($inputName) . '" id="' . htmlspecialchars($inputName) . '" class="form-select">';
    $output .= '<option value="">-- ' . htmlspecialchars($placeholder) . ' --</option>';

    if (is_array($data)) {
        foreach ($data as $row) {
            $id = $row['id'] ?? '';
            $name = $row['name'] ?? '';
            $selected = ($id == $selectedValue) ? 'selected' : '';
            $output .= '<option value="' . htmlspecialchars($id) . '" ' . $selected . '>' . htmlspecialchars($name) . '</option>';
        }
    }
    $output .= '</select>';
    return $output;
}

function alert_success() {
    if (isset($_SESSION['success'])) {
        $txt = htmlspecialchars($_SESSION['success']);
        echo "
            <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                <strong>ព័ត៌មាន!</strong> $txt
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
            </div>
        ";
        unset($_SESSION['success']);
    }
}

function alert_error() {
    if (isset($_SESSION['error'])) {
        $txt = htmlspecialchars($_SESSION['error']);
        echo "
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                <strong>ប្រយ័ត្ន!</strong> $txt
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
            </div>
        ";
        unset($_SESSION['error']);
    }
}

// 3. File Upload Function
function upload($name, $dir) {
    if (!isset($_FILES[$name]) || $_FILES[$name]['error'] !== UPLOAD_ERR_OK) {
        return "";
    }

    $dir = trim($dir, '/') . '/'; 
    $project_root = dirname(__DIR__);
    $upload_dir = $project_root . '/' . $dir; 

    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            return "";
        }
    }

    $ext = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
    $path = $dir . md5(microtime() . uniqid()) . "." . $ext; 
    $target_file = $project_root . '/' . $path;
    
    if (move_uploaded_file($_FILES[$name]['tmp_name'], $target_file)) {
        return $path;
    }
    return "";
}
?>