<?php

if(isset($_POST['add_to_cart'])){

   if($user_id == ''){
      header('location:user_login.php');
   } else {

      $product_id = $_POST['product_id'];
      $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $quantity = $_POST['quantity'];
      $quantity = filter_var($quantity, FILTER_SANITIZE_STRING);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE product_id = ? AND user_id = ?");
      $check_cart_numbers->execute([$product_id, $user_id]);

      if($check_cart_numbers->rowCount() > 0){
         $fetch_cart = $check_cart_numbers->fetch(PDO::FETCH_ASSOC);
         $new_quantity = $fetch_cart['quantity'] + $quantity;

         $update_cart = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE product_id = ? AND user_id = ?");
         $update_cart->execute([$new_quantity, $product_id, $user_id]);

         $message[] = 'Cart updated!';
      } else {

         $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, product_id, name, price, image, quantity) VALUES(?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $product_id, $name, $price, $image, $quantity]);

         $message[] = 'Added to cart!';
      }
   }
}

?>
