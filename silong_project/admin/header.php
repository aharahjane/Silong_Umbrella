<header class="header">

   <div class="flex">


      <a href="#" class="logo">Admin Portal</a>
      
      

      <nav class="navbar">
         

         <a href="admin.php">Products</a>
         <a href="orders.php">Orders</a>
         <a href="admin_account.php">Admins</a>
         <a href="user_account.php">Users</a>
         

         <a href="admin_profile.php" class="nav-item icon-button">
        <i class="fas fa-user"></i>
         </a>

        
      </nav>

      <?php

      $select_rows = mysqli_query($conn,"SELECT * FROM `cart`") or die('query failed');
      $row_count = mysqli_num_rows($select_rows);
   
      ?>

</div>
</header>
