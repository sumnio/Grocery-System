<?php 
    include 'connect.php';
    // update query
    if(isset($_POST['update_product_quantity'])){
        $update_value=$_POST['update_quantity'];
        $update_id=$_POST['update_quantity_id'];

        $update_quantity_query=mysqli_query($conn, "update `cart` set qty=$update_value where id=$update_id");
        if($update_quantity_query){
            header('location:cart.php');
        }
    }
    // delete query
    if(isset($_GET['remove'])){
        $remove_id=$_GET['remove'];
        mysqli_query($conn,"Delete from `cart` where id=$remove_id");
        header('location:cart.php');
    }

    // delete all query
    if(isset($_GET['delete_all'])){
        mysqli_query($conn,"Delete from `cart`");
        header('location:cart.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <!-- css file -->
    <link rel="stylesheet" href="css/style.css">

    <!-- font awsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- header -->
    <?php 
        include 'header.php';
    ?>

    <div class="container">
        <section class="shopping_cart">
            <h1 class="heading">My Cart</h1>
            <table>
                <?php
                    $select_cart_products=mysqli_query($conn, "Select * from `cart`");
                    if(mysqli_num_rows($select_cart_products)>0){
                        echo "
                        <thead>
                            <th>#</th>
                            <th>Produt Name</th>
                            <th>Produt Image</th>
                            <th>Produt Price</th>
                            <th>Produt Quantity</th>
                            <th>Total Price</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        ";
                        $count=1;
                        $grand_total=0;
                        while($fetch_cart_products=mysqli_fetch_assoc($select_cart_products)){
                            ?>
                                <tr>
                                    <td><?php echo $count++?></td>
                                    <td><?php echo $fetch_cart_products['nm']?></td>
                                    <td>
                                        <img src="images/<?php echo $fetch_cart_products['img']?>" alt="">
                                    </td>
                                    <td>₱<?php echo $fetch_cart_products['price']?>/~</td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" value="<?php echo $fetch_cart_products['id']?>" 
                                            name="update_quantity_id">
                                            <div class="quantity_box">
                                                <input type="number" min="1" value="<?php echo $fetch_cart_products['qty']?>"
                                                name="update_quantity">
                                                <input type="submit" class="update_quantity" value="Update"
                                                name="update_product_quantity">
                                            </div>
                                        </form>
                                    </td>
                                    <td>₱<?php echo $subtotal=number_format($fetch_cart_products['price'] * $fetch_cart_products['qty'])?></td>
                                    <td>
                                        <a href="cart.php?remove=<?php echo $fetch_cart_products['id']?>"
                                        onclick="return confirm('Delete item?')">
                                            <i class="fa fa-trash"></i>Remove
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            $grand_total+=($fetch_cart_products['price'] * $fetch_cart_products['qty']);
                        }
                    } else {
                        echo "<div class='empty_text'>Cart is Empty</div>";
                    }
                ?>
                </tbody>
            </table>
            <!-- php -->
            <?php 
                if($grand_total>0){
                    echo "
                    <div class='table_bottom'>
                        <a href='shop_products.php' class='bottom_btn'>Continue Shopping</a>
                        <h3 class='bottom_btn'>Grand total: ₱<span>$grand_total/~</span></h3>
                        <a href='checkout.php' class='bottom_btn'>Proceed to checkout</a>
                    </div>";
                
            ?>
                    <a href='cart.php?delete_all' class='delete_all_btn'>
                        <i class='fa fa-trash'></i>Delete All
                    </a>
                    <?php
                } else {
                    echo '';
                }
                ?>
        </section>
    </div>
</body>
</html>