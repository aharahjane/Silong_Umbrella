<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

// Fetch existing user details
$select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_user->execute([$user_id]);

if($select_user->rowCount() > 0){
   $fetch_profile = $select_user->fetch(PDO::FETCH_ASSOC);
} else {
   $fetch_profile = array(); // Initialize an empty array or handle error
}

if(isset($_POST['submit'])){

   // Check if name and email are being modified
   $name = $fetch_profile['fname'] . ' ' . $fetch_profile['lname']; // Maintain existing name
   $email = $fetch_profile['email']; // Maintain existing email

   $prev_pass = $_POST['prev_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $new_pass = sha1($_POST['new_pass']);
   $cpass = sha1($_POST['cpass']);

   // Check if old password is empty or matches the stored password
   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709'; // SHA1 hash of an empty string
   if($old_pass == $empty_pass){
      $message[] = 'Please enter old password!';
   } elseif($old_pass != $prev_pass){
      $message[] = 'Old password does not match!';
   } elseif($new_pass != $cpass){
      $message[] = 'The new passwords do not match!';
   } else {
      if($new_pass != $empty_pass){
         // Update password if new password is not empty
         $update_password = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $update_password->execute([$cpass, $user_id]);
         $message[] = 'Password updated successfully!';
      } else {
         $message[] = 'Please enter a new password!';
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Silong | Update Profile</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/payong.png">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

   <style>
      * {
         font-family: "Lato", sans-serif;
         font-weight: 400;
         font-style: normal;
      }

      h3 {
         font-size: 2.5rem;
         text-transform: uppercase;
         color: black;
      }

      p {
         font-size: 2rem;
         color: grey;
         margin: 1.5rem 0;
      }

      .box {
         margin: 1rem 0;
         background-color: #f0f0f0;
         padding: 1.4rem;
         border: none;
         font-size: 1.8rem;
         color: black;
         width: calc(100% - 2.8rem);
         border-radius: .5rem;
         box-sizing: border-box;
      }

      .btn {
         display: inline-block;
         margin-top: 1rem;
         padding: 1rem 2rem;
         background-color: #1F618D;
         color: white;
         border: none;
         border-radius: .5rem;
         font-size: 1.8rem;
         text-decoration: none;
         width: calc(100% - 2.8rem);
         box-sizing: border-box;
      }

      .btn:hover {
         background-color: #333;
      }
   </style>
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Update Profile</h3>
      <p>Username: <?= $fetch_profile["fname"] . ' ' . $fetch_profile["lname"]; ?></p>
      <p>Email: <?= $fetch_profile["email"]; ?></p>
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile["password"]; ?>">
      <input type="password" name="old_pass" placeholder="Enter your old password" maxlength="20" class="box" required>
      <input type="password" name="new_pass" placeholder="Enter your new password" maxlength="20" class="box" required>
      <input type="password" name="cpass" placeholder="Confirm your new password" maxlength="20" class="box" required>
      <input type="submit" value="Update Password" class="btn" name="submit">
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
