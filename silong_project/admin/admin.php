<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}


if(isset($_POST['add_product'])){
    $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];
    $p_image = $_FILES['p_image']['name'];
    $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
    $p_image_folder = 'uploaded_img/'.$p_image;
    $p_stock = $_POST['p_stock'];


    $insert_query = mysqli_query($conn, "INSERT INTO `products` (name, price, image, stock) VALUES ('$p_name', '$p_price', '$p_image', '$p_stock')") or die('query failed');

    if($insert_query){
        move_uploaded_file($p_image_tmp_name, $p_image_folder);
        $message[] = 'Product added successfully';
    }else{
        $message[] = 'Could not add the product';
    }
};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_query = mysqli_query($conn, "DELETE FROM `products` WHERE id = $delete_id ") or die('query failed');

    if($delete_query){
       $message[] = 'Product has been deleted';
    }else{
       $message[] = 'Product could not be deleted';
    }
};

if(isset($_POST['update_product'])){
    $update_p_id = $_POST['update_p_id'];
    $update_p_name = $_POST['update_p_name'];
    $update_p_price = $_POST['update_p_price'];
    $update_p_image = $_FILES['update_p_image']['name'];
    $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
    $update_p_image_folder = 'uploaded_img/'.$update_p_image;
    $update_p_stock = $_POST['update_p_stock'];

    $update_query = mysqli_query($conn, "UPDATE `products` SET name = '$update_p_name', price = '$update_p_price', image = '$update_p_image', stock='$update_p_stock' WHERE id = '$update_p_id'");

    if($update_query){
        move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
        $message[] = 'Product updated successfully';
        header('location:admin.php');
    }else{
        $message[] = 'Product could not be updated';
        header('location:admin.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<?php
if(isset($message)){
    foreach($message as $msg){
        echo '<div class="message"><span>'.$msg.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
    }
}
?>

<?php include 'header.php'; ?>

<div class="container">
    <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
        <h3>Add a New Product</h3>
        <input type="text" name="p_name" min="0" placeholder="Enter the product name" class="box" required>
        <input type="number" name="p_price" min="0" placeholder="Enter the product price" class="box" required>
        <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
        <input type="number" name="p_stock" min="1" placeholder="Enter the product stock" class="box" required>
        <input type="submit" value="Add the Product" name="add_product" class="btn">
    </form>

    <section class="display-product-table">
        <table>
            <thead>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Stock</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products`");
                if(mysqli_num_rows($select_products) > 0){
                    while($row = mysqli_fetch_assoc($select_products)){
                ?>
                <tr>
                    <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>₱<?php echo $row['price']; ?>/-</td>
                    <td><?php echo $row['stock']; ?></td>
                    <td>
                        <a href="admin.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?');"><i class="fas fa-trash"></i> Delete</a>
                        <a href="admin.php?edit=<?php echo $row['id']; ?>" class="option-btn"><i class="fas fa-edit"></i> Update</a>
                    </td>
                </tr>
                <?php
                    }
                }else{
                    echo "<div class='empty'>No products added</div>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <section class="edit-form-container">
        <?php
        if(isset($_GET['edit'])){
            $edit_id = $_GET['edit'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $edit_id");
            if(mysqli_num_rows($edit_query) > 0){
                while($fetch_edit = mysqli_fetch_assoc($edit_query)){
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <img src="uploaded_img/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
            <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
            <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['name']; ?>">
            <input type="number" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['price']; ?>">
            <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
            <input type="number" min="1" class="box" required name="update_p_stock" value="<?php echo $fetch_edit['stock']; ?>">
            <input type="submit" value="Update the Product" name="update_product" class="btn">
            <input type="button" value="Cancel" id="close-edit" class="option-btn">
        </form>
        <?php
                }
            };
            echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
        };
        ?>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('close-edit').addEventListener('click', function() {
            document.querySelector('.edit-form-container').style.display = 'none';
        });
    });
</script>

</body>
</html>