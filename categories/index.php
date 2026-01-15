<?php
   
      include('../config.php');
    include('../function.php');
    
    // The custom query() function returns an array of rows.
    // Let's rename the variable to make that clear:
    $categories = query("select * from categories"); 
?>

<?php include('../includes/header.php');?>
<body>
    <div class="container">
        <?php alert_success(); ?>
    <?php alert_error(); ?>
        <h2>Categories List</h2>
        <p>
            <a href="create.php" class="btn btn-primary btn-sm">Create</a>
            <a href="../index.php" class="btn btn-success btn-sm">Back</a>
        </p>

        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                
                                <?php if(count($categories) > 0): ?>
                
                                        <?php foreach($categories as $row): ?> 
                        <tr>
                            <td><?=htmlspecialchars($row['id']) ;?></td>
                            <td><?=htmlspecialchars($row['name']);?></td>
                            <td><?=htmlspecialchars($row['description']);?></td>
                            <td>
                                <a href="edit.php?id=<?=urlencode($row['id']);?>" class="btn btn-success btn-sm">Edit</a>
                                <a href="delete.php?id=<?=urlencode($row['id']);?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>                 <?php endif; ?>
                
            </tbody>
        </table>  
    </div>
<?php include('../includes/footer.php');?>