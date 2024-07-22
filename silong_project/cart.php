<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}

if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
}

if(isset($_POST['update_quantity'])){
   $cart_id = $_POST['cart_id'];
   $quantity = $_POST['quantity'];
   $quantity = filter_var($quantity, FILTER_SANITIZE_STRING);
   $update_quantity = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_quantity->execute([$quantity, $cart_id]);
   $message[] = 'Cart updated';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Silong | Shopping Cart</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/payong.png">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

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

      
.cart-total{
   max-width: 50rem;
   margin:0 auto;
   margin-top: 3rem;
   background-color: var(--white);
   border:none;
   border-radius: .5rem;;
   padding:2rem;
   text-align: center;
}

.cart-total p{
   font-size: 2.5rem;
   color:var(--black);
   margin-bottom: 2rem;
}

.cart-total p span{
   color:var(--red);
}


      .btn,
.delete-btn,
.option-btn{
   display: block;
   width: 100%;
   margin-top: 1rem;
   border-radius: .5rem;
   border: none;
   padding:1rem 0rem;
   font-size: 1.7rem;
   text-transform: capitalize;
   color:var(--white);
   cursor: pointer;
   text-align: center;
}
.btn:hover,
.delete-btn:hover,
.option-btn:hover{
   background-color: var(--black);
}

.btn{
   background-color: #506C32;
}

.option-btn{
   background-color: var(--orange);
}

.delete-btn{
   background-color: var(--red);
}

.flex-btn{
   display: flex;
   gap:1rem;
}


.shopping-cart .fa-edit{
   height: 4.5rem;
   border-radius: .5rem;
   background-color: var(--orange);
   width: 5rem;
   border: none;
   font-size: 2rem;
   color:var(--white);
   cursor: pointer;
}

.shopping-cart .fa-edit:hover{
   background-color: var(--black);
}

.shopping-cart .sub-total{
   margin:2rem 0;
   font-size: 2rem;
   color:var(--light-color);
}

.shopping-cart .sub-total span{
   color:var(--red);
}

.products .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, 33rem);
   gap:1.5rem;
   justify-content: center;
   align-items: flex-start;
}

.products .box-container .box{
   position: relative;
   background-color: var(--white);
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
   border-radius: .5rem;
   border:none;
   padding:2rem;
   overflow: hidden;
}
.empty{
   padding:1.5rem;
   background-color: var(--white);
   border: var(--border);
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
   text-align: center;
   color:var(--red);
   border: none;
   border-radius: .5rem;
   font-size: 2rem;
   text-transform: capitalize;
}
    
   </style>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products shopping-cart">

   <h3 class="heading">Shopping cart</h3>

   <div class="box-container">

   <?php
      $grand_total = 0;
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
      <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
      <div class="name"><?= $fetch_cart['name']; ?></div>
      <div class="flex">
         <div class="price">₱<?= $fetch_cart['price']; ?></div>
         <input type="number" name="quantity" class="quantity" min="1" max="99" onkeypress="if(this.value.length == 5) return false;" value="<?= $fetch_cart['quantity']; ?>">
         <button type="submit" class="fas fa-edit" name="update_quantity"></button>
      </div>
      <div class="sub-total"> Sub Total : <span>₱<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></span> </div>
      <input type="submit" value="delete item" onclick="return confirm('delete this from cart?');" class="delete-btn" name="delete">
   </form>
   <?php
   $grand_total += $sub_total;
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   </div>

   <div class="cart-total">
      <p>Grand Total : <span>₱<?= $grand_total; ?></span></p>
      <a href="products.php" class="btn">Continue Shopping</a>
      <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">Delete All Items</a>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">Proceed to Checkout</a>
   </div>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>