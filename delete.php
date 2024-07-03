<?php 
    include 'connect.php';

    if(isset($_GET['delete'])){
        $delete_id=$_GET['delete'];
        $delete_query=mysqli_query($conn, "DELETE FROM `products` WHERE id=$delete_id");

        if($delete_query){
            header('location:view_products.php');
        } else {
            header('location:view_products.php');
        }
    }
?>
