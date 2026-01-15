<?php
    session_start();
    include('../config.php');
    include('../function.php');
    $id = intval($_GET['id']);
    $sql = "select * from photos where id=$id";
    $photo = scalar_query($sql);
    $x = non_query("delete from photos where id=$id");
    if($x)
    {
        @unlink("../".$photo['file_name']);
        $_SESSION['success'] = DEL_SUCCESS_SMS;
        header('location: detail.php?id='.$photo['product_id']);
    }
    else{
        $_SESSION['error'] = DEL_ERROR_SMS;
        header('location: detail.php?id='.$photo['product_id']);
    }   
?>