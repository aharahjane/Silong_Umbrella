<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>
<style>

html, body {
  margin: 0;
  padding: 0;
}

header {
  width: 100%;
  background: hsl(120, 20%, 99%);
  color: #120585;
  padding-top: 1px;
  min-height: 1px;
  border-bottom: hsl(125, 88%, 23%) 3px solid;
  box-sizing: border-box; 
}

.logo{
  width: 230px;
  cursor: pointer; 
  height: 60px; 
  margin-bottom:0;
}

.logo-show{
  display: flex;
  justify-content: flex-end;
  cursor: pointer; 
  width: 990px;
  height: 500px;
}

.logo-show img{
 max-width: 390px;
}

header a{
  color:#227218;
  text-decoration:none;
  text-transform: uppercase;
  font-size:16px;
}

header li{
  margin-left: 40;
  margin-top:20px;
  display:inline-block;
  padding: 0 20px 0 20px; 
}

header #branding{
  float:left;
}

header #branding h1{
  margin:0;
}

header nav{
  float:right;
  margin-top:10px;
}

header a {
   color: #120585;
   text-decoration: none;
   text-transform: uppercase;
   font-size: 14px; 
   margin: 0 10px; 
}

header li {
   display: inline-block;
   padding: 0 10px; 
}

header .highlight, header .current a{
  color:hsl(16, 93%, 48%);
  font-weight:bold;
}

header a:hover{
  color:#cccccc;
  font-weight:bold;
}

.header .flex .navbar a{
   margin:0 1rem;
   font-size: 2rem;
   color:#8B8B8B;
}

.header .flex .navbar a:hover{
   color:#506C32;
   text-decoration: underline;
}


.header .flex .icons > *{
   margin-left: 1rem;
   font-size: 2rem;
   cursor: pointer;
   color:#8B8B8B;
}

.header .flex .icons > *:hover{
   color:#506C32;
}

.header .flex .icons a span{
   font-size: 2rem;
}

.option-btn {
    display: inline-block;
    margin-top: 1rem;
    padding: 1rem 2rem;
    background-color: #1F618D; /* blue button */
    color: white;
    border: none;
    border-radius: .5rem;
    font-size: 1.8rem;
    text-decoration: none;
    width: calc(100% - 2.8rem); 
    box-sizing: border-box; 
}

.option-btn:hover {
    background-color: #719B52; /* dark-gray */
    color: white;
}

</style>


<header class="header">

   <section class="flex">

   <div id="branding">
           <img src="images/silong.png" class = "logo">
        </div>

      <nav class="navbar">
         <a href="home.php">Home</a>
         <a href="products.php">Products</a>
         <a href="orders.php">Orders</a>
         <a href="faqs.php">FAQS</a>
         <a href="contact.php">Contact Us</a>
      </nav>

      <div class="icons">
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
         ?>
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="search_page.php"><i class="fas fa-search"></i></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span> <?= $total_cart_counts; ?> </span></a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile["fname"] . " " . $fetch_profile["lname"]; ?></p>

         <a href="update_user.php" class="option-btn">Update Profile</a>
         <div class="flex-btn">
         
         <a href="user_address.php" class="option-btn">My Address</a>
            
         </div>
         <a href="components/user_logout.php" class="option-btn" onclick="return confirm('Logout from the website?');">Log out</a> 
         <?php
            }else{
         ?>
         <p>Please Login Or Register First to proceed !</p>
         <div class="flex-btn">
            <a href="user_register.php" class="option-btn">Register</a>
            <a href="user_login.php" class="option-btn">Login</a>
         </div>
         <?php
            }
         ?>      
         
         
      </div>

   </section>

</header>