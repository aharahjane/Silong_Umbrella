<?php

include("config.php");

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

$message = [];

if(isset($_POST['update_payment'])){

   $orders_id = $_POST['orders_id'];

   if(isset($_POST['payment_status']) && $_POST['payment_status'] != ""){
       $payment_status = $_POST['payment_status'];
       $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
       $update_status->execute([$payment_status, $orders_id]);
       $message[] = 'Payment status updated!';
   } else {
       $message[] = 'No payment status selected. No update performed.';
   }

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:orders.php');
}


   if(!empty($message)){
      foreach($message as $msg){
         echo '<div class="message"><span>' . $msg . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = \'none\';"></i></div>';
      }
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Placed orders</title>

 
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="admin_style.css">

</head>
<?php include 'header.php'; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400&display=swap');

:root{
   --main-color:#4834d4;
   --red:#e74c3c;
   --orange:#f39c12;
   --black:#34495e;
   --white:#fff;
   --light-bg:#f5f5f5;
   --light-color:#999;
   --border:.2rem solid var(--black);
   --box-shadow:0 .5rem 1rem rgba(0,0,0,.1);
}

*{
   font-family: 'Montserrat', sans-serif;
   margin:0; padding:0;
   box-sizing: border-box;
   text-decoration: none;
   outline: none; border:none;
   text-transform: none;
}

*::selection{
   color:var(--white);
   background-color: var(--main-color);
}

::-webkit-scrollbar{
   width: 1.5rem;
   height: .2rem;
}

::-webkit-scrollbar-track{
  background-color: var(--light-color);
}

::-webkit-scrollbar-thumb{
   background-color: var(--light-color);
}

html{
   font-size: 62.5%;
   overflow-x: hidden;
}

body{
   background-color: var(--light-bg);
   /* padding-bottom: 7rem; */
}

section{
   max-width: 1200px;
   margin:0 auto;
   padding:2rem;
}

.btn,
.delete-btn,
.option-btn{
   display: block;
   margin-top: 1rem;
   border-radius: .5rem;
   cursor: pointer;
   width: 100%;
   font-size: 1.8rem;
   color:var(--white);
   padding:1.2rem 3rem;
   text-transform: capitalize;
   text-align: center;
}

.btn{
   background-color: var(--moonstone:#429ea6);
}

.delete-btn{
   background-color: var(--red);
}

.option-btn{
   background-color: var(--orange);
}

.btn:hover,
.delete-btn:hover,
.option-btn:hover{
   background-color: var(--black);
}

.flex-btn{
   display: flex;
   gap:1rem;
}

.message{
   position: sticky;
   top:0;
   max-width: 1200px;
   margin:0 auto;
   background-color: var(--light-bg);
   padding:2rem;
   display: flex;
   align-items: center;
   gap:1rem;
   justify-content: space-between;
}

.message span{
   font-size: 2rem;
   color:var(--black);
}

.message i{
   font-size: 2.5rem;
   color:var(--red);
   cursor: pointer;
}

.message i:hover{
   color:var(--black);
}


.empty{
   border:var(--border);
   border-radius: .5rem;
   background-color: var(--white);
   padding:1.5rem;
   text-align: center;
   width: 100%;
   font-size: 2rem;
   text-transform: capitalize;
   color:var(--red);
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
}

.form-container{
   display: flex;
   align-items: center;
   justify-content: center;
   min-height: 100vh;
}

.form-container form{
   background-color: var(--white);
   border-radius: .5rem;
   border:var(--border);
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
   padding:2rem;
   text-align: center;
   width: 50rem;
}

.form-container form h3{
   font-size: 2.5rem;
   color:var(--black);
   text-transform: capitalize;
   margin-bottom: 1rem;
}

.form-container form p{
   margin:1rem 0;
   font-size: 2rem;
   color:var(--light-color);
}

.form-container form p span{
   color:var(--main-color);
}

.form-container form .box{
   width: 100%;
   background-color: var(--light-bg);
   padding:1.4rem;
   font-size: 1.4rem;
   color:var(--black);
   margin:1rem 0;
   border:var(--border);
   font-size: 1.8rem;
   border-radius: .5rem;
}


#menu-btn{
   display: none;
}

.dashboard .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(27rem, 1fr));
   gap:1.5rem;
   align-items: flex-start;
}

.dashboard .box-container .box{
   text-align: center;
   background-color: var(--white);
   border:var(--border);
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
   border-radius: .5rem;
   text-align: center;
   padding:1.5rem;
}

.dashboard .box-container .box h3{
   font-size: 2.7rem;
   color:var(--black);
}

.dashboard .box-container .box h3 span{
   font-size: 2rem;
}

.dashboard .box-container .box p{
   padding:1.5rem;
   border-radius: .5rem;
   background-color: var(--light-bg);
   border-radius: .5rem;
   font-size: 1.8rem;
   border:var(--border);
   margin:1rem 0;
   color:var(--light-color);
}

.add-products form{
   margin:0 auto;
   max-width: 50rem;
   background-color: var(--white);
   border-radius: .5rem;
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
   border:var(--border);
   padding:2rem;
   text-align: center;
}

.add-products form h3{
   margin-bottom: 1rem;
   font-size: 2.5rem;
   color:var(--black);
   text-transform: capitalize;
}

.add-products form .box{
   background-color: var(--light-bg);
   border:var(--border);
   width: 100%;
   padding:1.4rem;
   font-size: 1.8rem;
   color:var(--black);
   border-radius: .5rem;
   margin: 1rem 0;
}

.show-products .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, 33rem);
   gap:1.5rem;
   justify-content: center;
   align-items: flex-start;
}

.show-products .box-container .box{
   background-color: var(--white);
   border-radius: .5rem;
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
   border:var(--border);
   padding:1.5rem;
}

.show-products .box-container .box img{
   width: 100%;
   height: 20rem;
   object-fit: contain;
   margin-bottom: 1rem;
}

.show-products .box-container .box .name{
   font-size: 2rem;
   color:var(--black);
   padding:1rem 0;
}

.show-products .box-container .box .flex{
   display: flex;
   align-items: center;
   gap:1rem;
   justify-content: space-between;
}

.show-products .box-container .box .flex .category{
   font-size: 1.8rem;
   color:var(--main-color);
}

.show-products .box-container .box .flex .price{
   font-size: 2rem;
   color:var(--black);
   margin:.5rem 0;
}

.show-products .box-container .box .flex .price span{
   font-size: 1.5rem;
}

.update-product form{
   margin:0 auto;
   max-width: 50rem;
   background-color: var(--white);
   border-radius: .5rem;
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
   border:var(--border);
   padding:2rem;
}

.update-product form img{
   height: 25rem;
   width: 100%;
   object-fit: contain;
}

.update-product form .box{
   background-color: var(--light-bg);
   border:var(--border);
   width: 100%;
   padding:1.4rem;
   font-size: 1.8rem;
   color:var(--black);
   border-radius: .5rem;
   margin: 1rem 0;
}

.update-product form textarea{
   height: 15rem;
   resize: none;
}

.update-product form span{
   font-size: 1.7rem;
   color:var(--black);
}

.placed-orders .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, 33rem);
   gap:1.5rem;
   justify-content: center;
   align-items: flex-start;
}

.placed-orders .box-container .box{
   background-color: var(--white);
   border-radius: .5rem;
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
   border:var(--border);
   padding:2rem;
   padding-top: 1rem;
}

.placed-orders .box-container .box p{
   padding: .5rem 0;
   line-height: 1.5;
   font-size: 1.8rem;
   color:var(--black);
}

.placed-orders .box-container .box p span{
   color:var(--main-color);
}

.placed-orders .box-container .box .drop-down{
   width: 100%;
   margin:1rem 0;
   background-color: var(--light-bg);
   padding:1rem 1.4rem;
   font-size: 2rem;
   color:var(--black);
   border:var(--border);
   border-radius: .5rem;
}

.accounts .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, 33rem);
   gap:1.5rem;
   justify-content: center;
   align-items: flex-start;
}

.accounts .box-container .box{
   background-color: var(--white);
   border-radius: .5rem;
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
   border:var(--border);
   padding:2rem;
   padding-top: 1rem;
   text-align: center;
}

.accounts .box-container .box p{
   padding: .5rem 0;
   font-size: 1.8rem;
   color:var(--black);
}

.accounts .box-container .box p span{
   color:var(--main-color);
}

.messages .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, 33rem);
   gap:1.5rem;
   justify-content: center;
   align-items: flex-start;
}

.messages .box-container .box{
   background-color: var(--white);
   border-radius: .5rem;
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
   border:var(--border);
   padding:2rem;
   padding-top: 1rem;
}

.messages .box-container .box p{
   padding: .5rem 0;
   font-size: 1.8rem;
   color:var(--black);
}

.messages .box-container .box p span{
   color:var(--main-color);
}






/* media queries  */

@media (max-width:991px){

   html{
      font-size: 55%;
   }

}

@media (max-width:768px){

   #menu-btn{
      display: inline-block;
   }

   .header .flex .navbar{
      position: absolute;
      top:99%; left:0; right:0;
      border-top: var(--border);
      border-bottom: var(--border);
      background-color: var(--white);
      clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
      transition: .2s linear;
   }

   .header .flex .navbar.active{
      clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
   }

   .header .flex .navbar a{
      display: block;
      margin:2rem;
   }

}

@media (max-width:450px){

   html{
      font-size: 50%;
   }

   .flex-btn{
      flex-flow: column;
      gap:0;
   }

   .heading{
      font-size: 3rem;
   }

   .show-products .box-container{
      grid-template-columns: 1fr;
   }

   .placed-orders .box-container{
      grid-template-columns: 1fr;
   }

   .accounts .box-container{
      grid-template-columns: 1fr;
   }

}
</style>

<body>



<section class="placed-orders">

   <h1 class="heading">PLACED ORDERS</h1>

   <div class="box-container">

   <?php
    $select_orders = mysqli_query($conn,"SELECT * FROM `orders` ORDER BY `id` DESC");
    if(mysqli_num_rows($select_orders) > 0){
        while($fetch_orders = mysqli_fetch_assoc($select_orders)){

    ?>

   <div class="box">
      <p> Placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> Name : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> Number : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> Email : <span><?= $fetch_orders['email']; ?></span> </p>
      <p> Payment Method : <span><?= $fetch_orders['method']; ?></span> </p>
      <p> Address : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> Total Products : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> Total Price : <span>₱<?= $fetch_orders['total_price']; ?></span> </p>
      <form action="" method="POST">
         <input type="hidden" name="orders_id" value="<?= $fetch_orders['id']; ?>">
         <select name="payment_status" class="drop-down">
            <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
            <option value="Cancelled Order">Cancelled Order</option>
            <option value="Pending">Pending</option>
            <option value="Completed">Completed</option>
         </select>
         <div class="flex-btn">
            <input type="submit" value="update" class="btn" name="update_payment">
            <a href="orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
         </div>
      </form>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">no orders placed yet!</p>';
   }
   ?>

   </div>

</section>




<script src="admin_script.js"></script>

</body>
</html>