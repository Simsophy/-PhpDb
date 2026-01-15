<?php
    include('../config.php');
    include('../function.php');
    $title = " Product Detail";
    $id = $_GET['id'];
    $sql = "select products.*, categories.name as cname, units.name as uname from products
    join categories on products.category_id=categories.id 
    join units on products.unit_id=units.id where products.id = $id";
    $pro = scalar_query($sql);
?>
<?php include('../includes/header.php'); ?>
<?php 
    if(isset($_POST['btn']))
    {
        $id = $_POST['product_id'];
        $count = count($_FILES['photo']['name']);
        $status = false;
        for($i=0;$i<$count; $i++){
            $name = $_FILES['photo']['name'][$i];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $path = "uploads/products/" . md5($name . date('Y-m-d-h:i:s')) . ".$ext";
            if(move_uploaded_file($_FILES['photo']['tmp_name'][$i], '../' . $path))
            {
                $insert = "insert into photos (product_id, file_name)
                values($id, '$path')";
                non_query($insert);
                $status = true;
            }else{
                $status = false;
            }
        }
        if($status)
        {
            $_SESSION['success'] ="Product photos have been uploaded.";
        }
        else{
            $_SESSION['error'] ="Product photos haven't been uploaded!";
        }
    }
    $photo = query("select * from photos where product_id=$id");
?>
    <div class="container">
        <h3>Create Product</h3>
        <p>
            <a href="index.php" class="btn btn btn-success btn-sm">Back</a>
            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle='modal' data-bs-target='#uploadModal'>Upload</button>
        </p>
        <?php alert_success(); alert_error(); ?>
        <div class="row">
            <div class="col-sm-6">                    
                <div class="row">
                    <label class="col-sm-3">Code</label>
                    <div class="col-sm-9">
                        <?=$pro['code'];?>
                    </div>
                </div>
                <div class="row mt-2">
                    <label  class="col-sm-3">Name</label>
                    <div class="col-sm-9">
                        <?=$pro['name'];?>
                    </div>
                </div>
                
                <div class="row mt-2">
                    <label class="col-sm-3">Price($)</label>
                    <div class="col-sm-9">
                        <?=$pro['price'];?>
                    </div>
                </div>
                <div class="row mt-2">
                    <label class="col-sm-3">Low Stock</label>
                    <div class="col-sm-9">
                        <?=$pro['low_stock'];?>   <?=$pro['uname'];?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row mt-2">
                    <label class="col-sm-3">Categories</label>
                    <div class="col-sm-9">
                        <?=$pro['cname'];?>   
                    </div>
                </div>
                <div class="row mt-2">
                    <label class="col-sm-3">onhand</label>
                    <div class="col-sm-9">
                        <?=$pro['onhand'];?>  <?=$pro['uname'];?>
                    </div>
                </div>                   
            </div>
        </div>
        <p>
            <strong class="mt-2">Product Photos</strong>
        </p>
        <div class="row">
            <?php while($row=mysqli_fetch_assoc($photo)): ?>
            <div class="col-sm-2">
                <div class="card">
                    <a href="<?=BURL.$row['file_name'];?>" class="gallery">
                        <img src="<?=BURL.$row['file_name'];?>" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <a href="delete-photo.php?id=<?=$row['id'];?>" class="btn btn-danger btn-sm" onclick="return confirm('You want to delete?')">Delete</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
<!-- modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?=$pro['id'];?>">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5">Upload Photo</h3>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="usd">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo[]" required multiple accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary btn-sm" type="submit" name="btn">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include('../includes/footer.php'); ?>