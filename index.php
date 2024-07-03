<?php
    include 'connect.php';

    if(isset($_POST['add_product'])){
        $product_name=$_POST['product_name'];
        $product_price=$_POST['product_price'];
        $product_image=$_FILES['product_image']['name'];
        $product_image_temp_name=$_FILES['product_image']['tmp_name'];
        $product_image_folder='images/'.$product_image;

        $insert_query=mysqli_query($conn, "insert into `products` (nm,price,img) values('$product_name', '$product_price', '$product_image')") or die("Insert query failed");

        if($insert_query){
            move_uploaded_file($product_image_temp_name, $product_image_folder);
            $display_message = "Success";
        } else {
            $display_message = "Error";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping System</title>

    <!-- css file -->
    <link rel="stylesheet" href="css/style.css">

    <!-- font awsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<!-- include header -->
<?php include('header.php')?>

<!-- form -->
<div class="container">
    <!-- message display -->
    <?php 
    if(isset($display_message)){
        echo "
        <div class='display_message'>
        <span>".$display_message."</span>
        <i class='fa fa-times' onclick='this.parentElement.style.display=`none`';></i>
        </div>";
    }
    ?> 
    <section>
        <h3 class="heading">Add Products</h3>
        <form action="" class="add_product" method="post" enctype="multipart/form-data">
            <input type="text" name="product_name" placeholder="Enter product" class="input_fields" required>
            <input type="number" name="product_price" min="0" placeholder="Enter price" class="input_fields" required>
            <input type="file" name="product_image" class="input_fields" required accept="image/png, image/jpg, image/jpeg">
            <input type="submit" name="add_product" class="submit_btn" value="Add Product">
        </form>
    </section>
</div>


<!-- js file -->
<script src="js/script.js"></script>
</body>
</html>