<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
   
   // Fetch user details from the database
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
   $select_user->execute([$user_id]);
   
   if($select_user->rowCount() > 0){
      $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
      $user_fname = $fetch_user['fname'];
      $user_lname = $fetch_user['lname'];
      $user_email = $fetch_user['email'];
      $user_name = $user_fname . ' ' . $user_lname;
   } else {
      $user_name = '';
      $user_email = '';
   }

   // Fetch user's default address
   $select_address = $conn->prepare("SELECT * FROM `addresses` WHERE user_id = ? AND is_default = 1");
   $select_address->execute([$user_id]);
   
   if($select_address->rowCount() > 0){
      $fetch_address = $select_address->fetch(PDO::FETCH_ASSOC);
      $default_address = $fetch_address['house_no'] .', '. $fetch_address['street'] .', '. $fetch_address['brgy'] .', '. $fetch_address['city'] .', '. $fetch_address['province'] .' - '. $fetch_address['zip_code'];
   } else {
      $default_address = '';
   }
} else {
   $user_id = '';
   $user_name = '';
   $user_email = '';
   header('location:user_login.php');
}

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);

   if (isset($_POST['use_new_address'])) {
      $house_no = $_POST['house_no'];
      $house_no = filter_var($house_no, FILTER_SANITIZE_STRING);
      $street = $_POST['street'];
      $street = filter_var($street, FILTER_SANITIZE_STRING);
      $brgy = $_POST['brgy'];
      $brgy = filter_var($brgy, FILTER_SANITIZE_STRING);
      $city = $_POST['city'];
      $city = filter_var($city, FILTER_SANITIZE_STRING);
      $province = $_POST['province'];
      $province = filter_var($province, FILTER_SANITIZE_STRING);
      $zip_code = $_POST['zip_code'];
      $zip_code = filter_var($zip_code, FILTER_SANITIZE_STRING);
      $address = $house_no .', '. $street .', '. $brgy .', '. $city .', '. $province .' - '. $zip_code;
      $address = filter_var($address, FILTER_SANITIZE_STRING);
   } else {
      $address = $default_address;
   }

   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Order placed successfully!';
   }else{
      $message[] = 'Your cart is empty';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Silong | Checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/payong.png">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

   <style>
        *{
            font-family: "Lato", sans-serif;
            font-weight: 400;
            font-style: normal;
        }
    
   
      h1 {
         font-size: 36px; 
         text-align: center;
      }

      
      p {
         font-size: 18px; 
         text-align: center;
      }

      
.checkout-orders form{
   padding:2rem;
   border:var(--border);
   background-color: var(--white);
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
   border-radius: .5rem;
}

.checkout-orders form h3{
   border-radius: .5rem;
   background-color: var(--black);
   color:var(--white);
   padding:1.5rem 1rem;
   text-align: center;
   text-transform: uppercase;
   margin-bottom: 2rem;
   font-size: 2.5rem;
}

.checkout-orders form .flex{
   display: flex;
   flex-wrap: wrap;
   gap:1.5rem;
   justify-content: space-between;
}

.checkout-orders form .flex .inputBox{
   width: 49%;
}

.checkout-orders form .flex .inputBox .box {
   width: 90%; 
   border: none;
   border-radius: .5rem;
   font-size: 1.8rem;
   color: var(--black);
   padding: 1.2rem 1.4rem;
   margin: 1rem 0;
   background-color: var(--light-bg);
}

.checkout-orders form .flex .inputBox span{
   font-size: 1.8rem;
   color:var(--light-color);
}
    
   </style>
   <script>
      function toggleAddressFields() {
         const newAddressSection = document.getElementById('new-address');
         const useNewAddressCheckbox = document.getElementById('use-new-address');
         if (useNewAddressCheckbox.checked) {
            newAddressSection.style.display = 'block';
         } else {
            newAddressSection.style.display = 'none';
         }
      }
   </script>
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>Your Orders</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= '₱'.$fetch_cart['price'].' x '. $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">Grand Total : <span>₱<?= $grand_total; ?></span></div>
      </div>

      <h3>Place your orders</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Full Name :</span>
            <input type="text" name="name" placeholder="Enter your full name" class="box" maxlength="20" value="<?= $user_name; ?>" readonly>
         </div>
         <div class="inputBox">
            <span>Contact Number :</span>
            <input type="number" name="number" placeholder="Enter your contact number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 11) return false;" required>
         </div>
         <div class="inputBox">
            <span>Email Address :</span>
            <input type="email" name="email" placeholder="Enter your email address" class="box" maxlength="50" value="<?= $user_email; ?>" readonly>
         </div>
         <div class="inputBox">
            <span>Payment Method :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">Cash on Delivery</option>
               <option value="gcash">GCash</option>
               <option value="paymaya">PayMaya</option>
            </select>
         </div>
         <div class="inputBox">
            <span>
               Delivery Address :
               <small><em>You can add/edit your default address in <a href="user_address.php">My Address</a></em></small>
            </span>
            <input type="text" name="default_address" value="<?= $default_address; ?>" class="box" readonly>
         </div>
         <div class="inputBox">
            <span>Use a new address?</span>
            <input type="checkbox" id="use-new-address" name="use_new_address" onclick="toggleAddressFields()">
         </div>
      </div>

      <div id="new-address" style="display:none;">
         <h3>New Address</h3>
         <div class="flex">
            <div class="inputBox">
               <span>House Number :</span>
               <input type="text" name="house_no" placeholder="Enter house number" class="box" maxlength="50">
            </div>
            <div class="inputBox">
               <span>Street :</span>
               <input type="text" name="street" placeholder="Enter street" class="box" maxlength="50">
            </div>
            <div class="inputBox">
               <span>Barangay :</span>
               <input type="text" name="brgy" placeholder="Enter barangay" class="box" maxlength="50">
            </div>
            <div class="inputBox">
               <span>City :</span>
               <input type="text" name="city" placeholder="Enter city" class="box" maxlength="50">
            </div>
            <div class="inputBox">
               <span>Province :</span>
               <input type="text" name="province" placeholder="Enter province" class="box" maxlength="50">
            </div>
            <div class="inputBox">
               <span>Zip Code :</span>
               <input type="text" name="zip_code" placeholder="Enter zip code" class="box" maxlength="10">
            </div>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="Place Order">

   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
