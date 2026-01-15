<?php
    include('../config.php');
    $title = "Users";
    include('../function.php');  // contains query(), non_query(), alert_success(), alert_error(), etc.
    ?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "php";
$port='3307';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname,$port);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


    // Use only one query call here
   $sql = "SELECT * FROM users"; // your query here
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Query Error: " . mysqli_error($conn);
    exit;
}

echo "Number of rows: " . mysqli_num_rows($result);

        

    $langs = array(
        'en'=> 'English',
        'km'=> 'ភាសាខ្មែរ'
    );

    if(isset($_POST['btn']))
    {
        $pass = $_POST['password'];
        $cpass = $_POST['cpassword'];
        $id = $_POST['user_id'];
        if($pass != $cpass){
            $_SESSION['error'] = "Password and Confirmed password is not matched!";
        } else {
            $sql = "UPDATE users SET password=MD5('$pass') WHERE id=$id";
            $x = non_query($sql);
            if($x){
                $_SESSION['success'] = "Password has been Reset.";
            } else {
                $_SESSION['error'] = "Fail to reset Password!";
            }
        }
    }
    
    
?>
<?php include('../includes/header.php');?>

<div class="container">
    <h2>Users</h2>
    <?php alert_success(); ?>
    <?php alert_error(); ?>
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
                <th>Phone</th>
                <th>Email</th>
                <th>Username</th>
                <th>Role</th>
                <th>Language</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php $i=1; ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?> 
                    <tr>
                        <td><?=$i++;?></td>
                        <td><?=htmlspecialchars($row['name']);?></td>
                        <td><?=htmlspecialchars($row['phone']);?></td>
                        <td><?=htmlspecialchars($row['email']);?></td>
                        <td><?=htmlspecialchars($row['username']);?></td>
                        <td><?=htmlspecialchars($row['role']);?></td>
                        <td><?=htmlspecialchars($langs[$row['language']] ?? 'Unknown');?></td>
                        <td>
                            <a href="edit.php?id=<?=$row['id'];?>" class="btn btn-success btn-sm">Edit</a>
                            <a href="delete.php?id=<?=$row['id'];?>" class="btn btn-danger btn-sm" 
                               onclick="return confirm('You want to delete it?')">Delete</a>
                            <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" 
                                    data-bs-target="#resetModal" onclick="get_user(<?=$row['id'];?>)">Reset</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8" class="text-center">No users found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>  
</div>

<<div class="modal fade" id="resetModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <input type="hidden" name="user_id" id="user_id"> 
                <div class="modal-header">
                    </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary btn-sm" type="submit" name="btn">Reset now</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('../includes/footer.php');?>
