<?php
// products/low.php
// Ensures function.php and config.php are included
include('../config.php');
include('../function.php');

// FIX 1: Initialize the condition variable to an empty string.
$con = "";

// Base SQL query for low stock items
$sql = "SELECT p.*, c.name AS catname, u.name AS unit 
        FROM products p
        INNER JOIN categories c ON p.category_id = c.id
        INNER JOIN units u ON p.unit_id = u.id 
        WHERE p.onhand <= p.low_stock";
        
// NOTE: I removed 'products.active=1' from the base SQL, as this column is often inconsistent
// or missing in your tables based on previous errors. If products has 'active', add it back.

// Fetch categories for the filter dropdown
// NOTE: I also removed 'where active=1' from this query for safety.
$cats = query("SELECT * FROM categories"); 

if(isset($_GET['btn']))
{
    // Sanitize and escape input for security (CRITICAL)
    global $conn; // Assuming $conn is your database connection link
    $cid = mysqli_real_escape_string($conn, $_GET['cid']);
    $q = mysqli_real_escape_string($conn, $_GET['q']);
    
    if($cid != 'all'){
        // Using $con .= since it was initialized to ""
        $con .= " AND p.category_id = '{$cid}'"; 
    }
    
    // Check if the search query is not empty
    if($q != ''){
        $con .= " AND (p.code LIKE '%{$q}%' OR p.name LIKE '%{$q}%')";
    }
    
    // Append the conditional string to the main SQL query
    $sql .= $con;
}

// Execute the final query
$result_array = query($sql); // RENAMED variable to clarify it holds an array, not a result object

$i = 1;

// Title and Header inclusion
$title = "Low-Stock"; 
include('../includes/header.php'); 
?>

<div class="container mt-4">
    <?php alert_success(); ?>
    <?php alert_error(); ?>
    
    <h5 class="mb-4">Low-Stock Products List</h5>
    
    <div class="mb-3">
        <form method="get" class="row g-2 align-items-center">
            <div class="col-auto">
                <label class="col-form-label">Category:</label>
            </div>
            <div class="col-md-3">
                <select name="cid" class="form-select form-select-sm">
                    <option value="all">All Categories</option>
                    <?php 
                    // Populate filter categories from the array fetched earlier
                    foreach ($cats as $cat): 
                        $selected = (isset($_GET['cid']) && $_GET['cid'] == $cat['id']) ? 'selected' : '';
                    ?>
                        <option value="<?=$cat['id'];?>" <?=$selected;?>>
                            <?=$cat['name'];?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="q" placeholder="Code or Name" class="form-control form-control-sm" value="<?=htmlspecialchars($_GET['q'] ?? '');?>">
            </div>
            <div class="col-auto">
                <button type="submit" name="btn" class="btn btn-primary btn-sm">Filter</button>
            </div>
            <div class="col-auto">
                <a href="low.php" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
    
    <div class="row mb-2">
        <div class="col-sm-3">
            <p>
                <a href="index.php" class="btn btn-success btn-sm">Back to Products</a>
            </p> 
        </div>
    </div>
    
    <table class="table table-bordered table-sm table-striped">
        <thead>
            <tr class="table-dark">
                <td>ID</td>
                <td>Code</td>
                <td>Name</td>
                <td>Price</td>
                <td>Categories</td>
                <td>Units</td>
                <td>Low Stock</td>
                <td>On Hand</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            
            <?php 
            // FIX 2: Use PHP's count() and loop directly over the array.
            if(count($result_array) > 0): 
                foreach($result_array as $product): 
            ?>
                    <tr class="<?=($product['onhand'] == 0) ? 'table-danger' : 'table-warning';?>">
                        <td><?=$i++ ;?></td>
                        <td><?=$product['code'] ;?></td>
                        <td>
                            <a href="detail.php?id=<?=$product['id'] ;?>"><?=$product['name'] ;?></a>
                        </td>
                        <td><?=$product['price'] ;?></td>
                        <td><?=$product['catname'] ;?></td>
                        <td><?=$product['unit'] ;?></td>
                        <td><?=$product['low_stock'] ;?></td>
                        <td><strong><?=$product['onhand'];?></strong></td>
                        <td>
                            <a href="edit.php?id=<?=$product['id'];?>" class="btn btn-success btn-sm">Edit</a>
                            <a href="delete.php?id=<?=$product['id'];?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach ;?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">
                        No products are currently at or below the low stock threshold.
                    </td>
                </tr>
            <?php endif ;?>
            
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>