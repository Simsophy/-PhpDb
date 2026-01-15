<?php
    // --- PHP LOGIC SECTION ---
    include('../config.php');
    $title = "Units";
    include('../function.php');
    
    // The custom query() function returns an array of rows.
    // Let's name the variable clearly:
    $units = query("select * from units"); 
?>

<?php include('../includes/header.php');?>
<body>
    <div class="container">
        <?php alert_success(); ?>
    <?php alert_error(); ?>
        <h2>Units</h2>
        <p>
            <a href="create.php" class="btn btn-primary btn-sm">Create</a>
            <a href="../index.php" class="btn btn-success btn-sm">Back</a>
        </p>

        <?php 
            alert_error();
            alert_success();
        ?>
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($units) > 0): ?>
                    
                    <?php foreach($units as $row): ?> 
                        <tr>
                            <td><?=htmlspecialchars($row['id']) ;?></td>
                            <td><?=htmlspecialchars($row['name']);?></td>
                            <td>
                                <a href="edit.php?id=<?=urlencode($row['id']); ?>" class="btn btn-success btn-sm">Edit</a>
                                <a href="delete.php?id=<?=urlencode($row['id']); ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?> <?php endif; ?>
            </tbody>
        </table> 
    </div>
<?php include('../includes/footer.php');?>