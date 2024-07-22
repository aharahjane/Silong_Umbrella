<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv= "X-UA-Compatible" content ="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin_style.css">

</head>

<?php include 'header.php'; ?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');

:root{
   --blue:#2980b9;
   --royalblue: #4169e1;
   --red:tomato;
   --orange:orange;
   --black:#333;
   --moonstone:#429ea6;
   --feldgrau:#475841;
   --onyx:#3f403f;
   --white:#fff;
   --bg-color:#eee;
   --dark-bg:rgba(0,0,0,.7);
   --box-shadow:0 .5rem 1rem rgba(0,0,0,.1);
   --border:.1rem solid #999;
}

*{
   font-family: 'Poppins', sans-serif;
   margin:0; padding:0;
   box-sizing: border-box;
   outline: none; border:none;
   text-decoration: none;
}

html{
   font-size: 62.5%;
   overflow-x: hidden;
}

.container{
   max-width: 1200px;
   margin:0 auto;
   /* padding-bottom: 5rem; */
}

section{
   padding:2rem;
}

.heading{
   text-align: center;
   font-size: 3.5rem;
   text-transform: uppercase;
   color:var(--);
   margin-bottom: 2rem;
}

.btn,
.editacc-btn,
.logout-btn{
   display: absolute;
   width: 100%;
   text-align: center;
   background-color: var(--feldgrau);
   color:var(--white);
   font-size: 1.7rem;
   padding:1.5rem 1rem;
   border-radius: .5rem;
   cursor: pointer;
   margin-top: 1rem;
}

.btn:hover,
.editacc-btn:hover,
.logout-btn:hover{
   background-color: var(--black);
}

.editacc-btn i,
.logout-btn i{
   padding-right: .5rem;
}

.editacc-btn{
   background-color: var(--moonstone);
}

.logout-btn{
   margin-top: 0;
   background-color: var(--red);
}

.message{
   background-color: var(--feldgrau);
   position: sticky;
   top:0; left:0;
   z-index: 10000;
   border-radius: .5rem;
   background-color: var(--white);
   padding:1.5rem 2rem;
   margin:0 auto;
   max-width: 1200px;
   display: flex;
   align-items: center;
   justify-content: space-between;
   gap:1.5rem;
}

.greeting {
    font-size: 2.5rem; /* Adjust the font size as needed */
}


.message span{
   font-size: 2rem;
   color:var(--black);
}

.message i{
   font-size: 2.5rem;
   color:var(--black);
   cursor: pointer;
}

.message i:hover{
   color:var(--red);
}

.header{
   background-color: var(--feldgrau);
   position: sticky;
   top:0; left:0;
   z-index: 1000;
}

.header .flex{
   display: flex;
   align-items: center;
   padding:1.5rem 2rem;
   max-width: 1200px;
   margin:0 auto;
}

.header .flex .logo{
   margin-right: auto;
   font-size: 2.5rem;
   color:var(--white);
}

.header .flex .navbar a{
   margin-left: 2rem;
   font-size: 2rem;
   color:var(--white);
}

.header .flex .navbar a:hover{
   color:yellow;
}

.header .flex .cart{
   margin-left: 2rem;
   font-size: 2rem;
   color:var(--white);
}

.header .flex .cart:hover{
   color:yellow;
}

.header .flex .cart span{
   padding:.1rem .5rem;
   border-radius: .5rem;
   background-color: var(--white);
   color:var(--feldgrau);
   font-size: 2rem;
}

#menu-btn{
   margin-left: 2rem;
   font-size: 3rem;
   cursor: pointer;
   color:var(--white);
   display: none;
}









/* media queries  */

@media (max-width:1200px){

   .shopping-cart{
      overflow-x: scroll;
   }

   .shopping-cart table{
      width: 120rem;
   }

   .shopping-cart .heading{
      text-align: left;
   }

   .shopping-cart .checkout-btn{
      text-align: left;
   }

}

@media (max-width:991px){

   html{
      font-size: 55%;
   }

}

@media (max-width:768px){

   #menu-btn{
      display: inline-block;
      transition: .2s linear;
   }

   #menu-btn.fa-times{
      transform: rotate(180deg);
   }

   .header .flex .navbar{
      position: absolute;
      top:99%; left:0; right:0;
      background-color: var(--feldgrau);
      clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
      transition: .2s linear;
   }

   .header .flex .navbar.active{
      clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);
   }

   .header .flex .navbar a{
      margin:2rem;
      display: block;
      text-align: center;
      font-size: 2.5rem;
   }

   .display-product-table{
      overflow-x: scroll;
   }

   .display-product-table table{
      width: 90rem;
   }

}

@media (max-width:450px){

   html{
      font-size: 50%;
   }

   .heading{
      font-size: 3rem;
   }

   .products .box-container{
      grid-template-columns: 1fr;
   }

}
</style>

<body>
<section id="main">
  <div class="container">
    <article id="main-col">

    <?php
if(isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
    $select_admin = $conn->prepare("SELECT name FROM `admins` WHERE id = ?");
    $select_admin->bind_param("i", $admin_id);
    $select_admin->execute();
    $result = $select_admin->get_result();

    if($result->num_rows > 0) {
        $admin_info = $result->fetch_assoc();
        $name = $admin_info['name'];
        echo "<span class='greeting'>Hello, Admin $name!</span>";
    } else {
        echo "<span class='greeting'>Hello, User!</span>";
    }
}
?>

<br></br>

    <br></br>

         <a href="admin_logout.php" class="logout-btn" onclick="return confirm('logout from the website?');">LOG OUT</a> 

      
    
      <br></br>
      <br></br>
      <br></br>
      <br></br>



    </article>
  </div>
</section>




</div>


<script src="admin_script.js"></script>

</body>
</html>
