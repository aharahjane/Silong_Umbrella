<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
   }else{
      $message[] = 'Your username or password is incorrect.';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Silong | Login</title>
   

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
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

h1 {
    font-size: 36px;
    text-align: center;
}

p {
    font-size: 18px;
    text-align: center;
}

.form-container form {
    background-color: white;
    padding: 2rem;
    border-radius: .5rem;
    border: none;
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.1); /* Assuming this is var(--box-shadow) */
    text-align: center;
    margin: 0 auto;
    max-width: 50rem;
    box-sizing: border-box; /* Include padding in width calculation */
}

.form-container form h3 {
    font-size: 2.5rem;
    text-transform: uppercase;
    color: black; /* Assuming this is var(--black) */
}

.form-container form p {
    font-size: 2rem;
    color: grey; /* Assuming this is var(--light-color) */
    margin: 1.5rem 0;
}

.form-container form .box {
    margin: 1rem 0;
    background-color: #f0f0f0; /* Assuming this is var(--light-bg) */
    padding: 1.4rem;
    border: none;
    font-size: 1.8rem;
    color: black; /* Assuming this is var(--black) */
    width: calc(100% - 2.8rem); /* Adjust width to include padding */
    border-radius: .5rem;
    box-sizing: border-box; /* Include padding in width calculation */
}

.form-container form .btn {
   display: inline-block;
    margin-top: 1rem;
    padding: 1rem 2rem;
    background-color: #1F618D; /*blue */
    color: white; 
    border: none;
    border-radius: .5rem;
    font-size: 1.8rem;
    text-decoration: none;
    width: calc(100% - 2.8rem); 
    box-sizing: border-box; 
}

.form-container form .btn:hover {
    background-color: #333; 
}

.option-btn {
    display: inline-block;
    margin-top: 1rem;
    padding: 1rem 2rem;
    background-color: #506C32; /* green button */
    color: white;
    border: none;
    border-radius: .5rem;
    font-size: 1.8rem;
    text-decoration: none;
    width: calc(100% - 2.8rem); 
    box-sizing: border-box; 
}

.option-btn:hover {
    background-color: #333; /* Assuming this is var(--dark-gray) */
}

   </style>



</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Login</h3>
      <input type="email" name="email" required placeholder="Enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" class="btn" name="submit">
      <p>Don't have an account?</p>
      <a href="user_register.php" class="option-btn">Register Now</a>
   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>