<?php
    // Include config and function files
    include('../config.php');
    include('../function.php');

    // Ensure the database connection ($conn) is available in function.php via global.
    // If not, you may need to add 'global $conn;' at the top of this script.

    // 1. Get filter variables safely
    $cid = $_GET['cid'] ?? 'all'; // PHP Null Coalescing Operator for safety
    $q = $_GET['q'] ?? '';
    
    // Use mysqli_real_escape_string to prevent SQL Injection
    // The $conn variable MUST be available (either globally or passed).
    $safe_cid = ($cid !== 'all') ? mysqli_real_escape_string($conn, $cid) : 'all';
    $safe_q = mysqli_real_escape_string($conn, $q);

    // 2. Query categories (Fix for 'active' column and database function return type)
    // Assuming you REMOVED the 'active=1' from this query, 
    // or you ADDED the 'active' column to the 'categories' table.
    // We also use a standard PHP array loop in the HTML.
    $cats = query("select * from categories"); 
    
    // 3. Build the main product SQL query
    $sql = "select products.*, categories.name as catname, units.name as unit from products
    inner join categories on products.category_id = categories.id
    join units on products.unit_id = units.id 
    where products.active=1"; // This WHERE clause still assumes 'active' column in 'products' table

    $con = ''; // Condition string
    if ($safe_cid !== 'all') {
        // Condition 1: Filter by Category ID (safely using $safe_cid)
        $con .= " and products.category_id = '{$safe_cid}'";
    }

    if (!empty($safe_q)) {
        // Condition 2: Filter by Keyword (safely using $safe_q)
        $con .= " and (products.code LIKE '%{$safe_q}%' OR products.name LIKE '%{$safe_q}%')";
    }
    
    $sql .= $con;

    // 4. Execute the final product query
    $result_array = query($sql); // Renamed to clarify it returns an ARRAY
    
    $i = 1;
?>
<?php $title = "Products"; ?>
<?php include('../includes/header.php'); ?>
<body>
    <div class="container">
       
    <?php alert_success(); ?>
    <?php alert_error(); ?>
        <h5> Products List</h5>
        <div class="row-mb-2">
            <div class="col-sm-3">
               <p>
                    <a href="create.php" class="btn btn-primary btn-sm">Create</a>
                    <a href="../index.php" class="btn btn-success btn-sm">Back</a>
                </p> 
            </div>
            <div class="col-sm-9">
                <form method="GET"> 
                    Category:
                    <select name="cid" id="cid">
                        <option value="all">All</option>
                        
                        <?php foreach($cats as $row): ?>
                            <option value="<?=htmlspecialchars($row['id']);?>" 
                                <?=$row['id'] == $cid ? 'selected' : '';?>>
                                <?=htmlspecialchars($row['name']);?>
                            </option>
                        <?php endforeach; ?>
                        
                    </select>
                    keyword:
                    <input type="text" name="q" value="<?=htmlspecialchars($q);?>">
                    <button name="btn">Search</button>
                </form>
            </div>
        </div>
        
        <?php 
            alert_error();
            alert_success();
        ?>
        <table class = "table table-bordered table-sm">
            <thead>
                <tr>
                    <td>No.</td> <td>Code</td>
                    <td>Name</td>
                    <td>Price</td>
                    <td>Categories</td>
                    <td>Units</td>
                    <td>Low Stock</td>
                    <td>onhand</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                <?php if(count($result_array) > 0): ?>
                    <?php foreach($result_array as $product): ?>
                        <tr>
                            <td><?=$i++ ;?></td>
                            <td><?=htmlspecialchars($product['code']) ;?></td>
                            <td>
                                <a href="detail.php?id=<?=urlencode($product['id']) ;?>">
                                    <?=htmlspecialchars($product['name']) ;?>
                                </a>
                            </td>
                            <td><?=htmlspecialchars($product['price']) ;?></td>
                            <td><?=htmlspecialchars($product['catname']) ;?></td>
                            <td><?=htmlspecialchars($product['unit']) ;?></td>
                            <td><?=htmlspecialchars($product['low_stock']) ;?></td>
                            <td><?=htmlspecialchars($product['onhand']);?></td>
                            <td>
                                <a href="edit.php?id=<?=urlencode($product['id']);?>" class="btn btn-success btn-sm">Edit</a>
                                <a href="delete.php?id=<?=urlencode($product['id']);?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('You want to delete?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach ;?>
                <?php endif ;?>
            </tbody>
        </table>
    </div>
</body>
<?php include('../includes/footer.php');