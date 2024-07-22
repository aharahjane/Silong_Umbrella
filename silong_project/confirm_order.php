<?php
// Include database connection and start session
include 'components/connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
   header('location:user_login.php');
   exit;
}

$user_id = $_SESSION['user_id'];

// Retrieve stored form data from session
if (!isset($_SESSION['order_data'])) {
   header('location:checkout.php'); // Redirect if no data found
   exit;
}

$order_data = $_SESSION['order_data'];

// Extract form data
$name = isset($order_data['name']) ? $order_data['name'] : '';
$number = isset($order_data['number']) ? $order_data['number'] : '';
$email = isset($order_data['email']) ? $order_data['email'] : '';
$method = isset($order_data['method']) ? $order_data['method'] : '';
$use_new_address = isset($order_data['use_new_address']) ? true : false;
$default_address = isset($order_data['default_address']) ? $order_data['default_address'] : '';
$new_address = '';

if ($use_new_address) {
   // If using new address, fetch new address details
   $house_no = isset($order_data['house_no']) ? $order_data['house_no'] : '';
   $street = isset($order_data['street']) ? $order_data['street'] : '';
   $brgy = isset($order_data['brgy']) ? $order_data['brgy'] : '';
   $city = isset($order_data['city']) ? $order_data['city'] : '';
   $province = isset($order_data['province']) ? $order_data['province'] : '';
   $zip_code = isset($order_data['zip_code']) ? $order_data['zip_code'] : '';

   // Construct new address string
   $new_address = "$house_no, $street, $brgy, $city, $province - $zip_code";
} else {
   // Use default address
   $new_address = $default_address;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Order Confirmation</title>
   
   <!-- CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/payong.png">
   <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
   
   <style>
      * {
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

      .confirmation-form {
         padding: 2rem;
         border: var(--border);
         background-color: var(--white);
         box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
         border-radius: .5rem;
         max-width: 600px;
         margin: 0 auto;
      }

      .confirmation-form h3 {
         border-radius: .5rem;
         background-color: var(--black);
         color: var(--white);
         padding: 1.5rem 1rem;
         text-align: center;
         text-transform: uppercase;
         margin-bottom: 2rem;
         font-size: 2.5rem;
      }

      .confirmation-form .flex {
         display: flex;
         flex-wrap: wrap;
         gap: 1.5rem;
         justify-content: space-between;
      }

      .confirmation-form .flex .inputBox {
         width: 49%;
      }

      .confirmation-form .flex .inputBox .box {
         width: 90%; 
         border: none;
         border-radius: .5rem;
         font-size: 1.8rem;
         color: var(--black);
         padding: 1.2rem 1.4rem;
         margin: 1rem 0;
         background-color: var(--light-bg);
      }

      .confirmation-form .flex .inputBox span {
         font-size: 1.8rem;
         color: var(--light-color);
      }

      .confirmation-form .edit-link {
         text-align: center;
         margin-top: 1rem;
      }

      .confirmation-form .edit-link a {
         text-decoration: none;
         color: var(--primary-color);
         font-weight: bold;
      }
   </style>
</head>
<body>
   
   <?php include 'components/user_header.php'; ?>

   <section class="confirmation-form">
      <h3>Order Confirmation</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Full Name :</span>
            <input type="text" name="name" placeholder="Enter your full name" class="box" maxlength="20" value="<?= htmlspecialchars($name); ?>" readonly>
         </div>
         <div class="inputBox">
            <span>Contact Number :</span>
            <input type="text" name="number" placeholder="Enter your contact number" class="box" value="<?= htmlspecialchars($number); ?>" readonly>
         </div>
         <div class="inputBox">
            <span>Email Address :</span>
            <input type="email" name="email" placeholder="Enter your email address" class="box" value="<?= htmlspecialchars($email); ?>" readonly>
         </div>
         <div class="inputBox">
            <span>Payment Method :</span>
            <input type="text" name="method" class="box" value="<?= htmlspecialchars($method); ?>" readonly>
         </div>
         <div class="inputBox">
            <span>Delivery Address :</span>
            <input type="text" name="address" class="box" value="<?= htmlspecialchars($new_address); ?>" readonly>
         </div>
      </div>

      <!-- Edit details link -->
      <div class="edit-link">
         <a href="checkout.php">Edit Details</a>
      </div>

      <!-- Final confirmation button -->
      <form action="place_order.php" method="POST">
         <input type="hidden" name="name" value="<?= htmlspecialchars($name); ?>">
         <input type="hidden" name="number" value="<?= htmlspecialchars($number); ?>">
         <input type="hidden" name="email" value="<?= htmlspecialchars($email); ?>">
         <input type="hidden" name="method" value="<?= htmlspecialchars($method); ?>">
         <input type="hidden" name="address" value="<?= htmlspecialchars($new_address); ?>">
         <input type="submit" name="confirm_order" class="btn" value="Confirm Order">
      </form>
   </section>

   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>

</body>
</html>
