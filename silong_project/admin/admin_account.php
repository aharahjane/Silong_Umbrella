<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admin = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
   $delete_admin->execute([$delete_id]);
   header('location:admin_account.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin accounts</title>


   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="admin_style.css">

</head>
<body>

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
}

*::selection{
   color:var(--white);
   background-color: var(--main-color);
}

::-webkit-scrollbar{
   width: 1rem;
   height: .5rem;
}

::-webkit-scrollbar-track{
  background-color: none;
}

::-webkit-scrollbar-thumb{
   background-color: var(--main-color);
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
   background-color: var(--main-color);
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

.heading{
   text-align: center;
   margin-bottom: 2rem;
   text-transform: capitalize;
   color:var(--black);
   font-size: 3rem;
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


<section class="accounts">

   <h1 class="heading">ADMIN ACCOUNTS</h1>

   <div class="box-container">

   <div class="box">
      <p>Register New Admin</p>
      <a href="admin_registration.php" class="option-btn">register</a>
   </div>

   
    <?php
    $select_account = mysqli_query($conn,"SELECT * FROM `admins`");
    if(mysqli_num_rows($select_account) > 0){
        while($fetch_account = mysqli_fetch_assoc($select_account)){
    ?>


<div class="box">
      <p> Admin id : <span><?= $fetch_account['id']; ?></span> </p>
      <p> Name : <span><?= $fetch_account['name']; ?></span> </p>
      <p> Username : <span><?= $fetch_account['username']; ?></span> </p>
      <div class="flex-btn">
         <a href="admin_account.php?delete=<?= $fetch_account['id']; ?>" class="delete-btn" onclick="return confirm('delete this account?');">delete</a>
     
      </div>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">no accounts available</p>';
   }
   ?>

   </div>

</section>






<script src="admin_script.js"></script>

</body>
</html>