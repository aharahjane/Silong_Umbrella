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
} else {
   $user_id = '';
   $user_name = '';
   $user_email = '';
}

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   } else {
      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);
      $message[] = 'Sent message successfully!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Silong | Contact Us</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/payong.png">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

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

   .contact form{
   padding:1rem;
   text-align: center;
   background-color: var(--white);
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
   border: none;
   border-radius: .5rem;
   max-width: 50rem;
   margin:0 auto;
}

.contact form h3{
   margin-bottom: 1rem;
   text-transform: capitalize;
   font-size: 2.5rem;
   color:var(--black);
}

.contact form .box {
    margin: 1rem 0;
    width: calc(100% - 2.8rem);
    background-color:#eee;
    padding: 1.4rem;
    font-size: 1.8rem;
    color: black;
    border-radius: .5rem;
    box-sizing: border-box;
    border: none;
}

.contact form textarea{
   height: 15rem;
   resize: none;
}
    
.btn,
.delete-btn,
.option-btn{
   display: block;
   width: 100%;
   margin-top: 1rem;
   border-radius: .5rem;
   border: none;
   padding:1rem 3rem;
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
   background-color:#506C32;
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
.view-link {
  color: black; /* Example color */
  font-weight: bold;
  font-size: 17px; 
}
.option-btn {
    display: inline-block;
    margin-top: 1rem;
    padding: 1rem 2rem;
    background-color: #1F618D; /* green button */
    color: white;
    border: none;
    border-radius: .5rem;
    font-size: 1.8rem;
    text-decoration: none;
    width: calc(100% - 2.8rem); 
    box-sizing: border-box; 
}

.option-btn:hover {
    background-color: #333; /* dark-gray */
}
    
   </style>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>
<section class="about">
   <div class="row">
      <div class="content">
      <h1 class="heading">Contact us</h1>
      <p>Please message us on Facebook: <a href="https://www.facebook.com/aharahjanefaustino"> https://www.facebook.com/aharahjanefaustino/</a>
          . We'll be glad to chat with you between 9:30 AM to 6:30 PM, from Mondays to Fridays. You can also contact us by filling up the form below. Thank you!</p>
   </div>
</section>

<section class="contact">
   <form action="" method="post">
      <h3>Fill up here</h3>
      <input type="text" name="name" placeholder="Enter your name" required maxlength="20" class="box" value="<?= $user_name; ?>" <?= ($user_id != '') ? 'readonly' : ''; ?>>
      <input type="email" name="email" placeholder="Enter your email" required maxlength="50" class="box" value="<?= $user_email; ?>" <?= ($user_id != '') ? 'readonly' : ''; ?>>
      <input type="number" name="number" min="0" max="99999999999" placeholder="Enter your number" required onkeypress="if(this.value.length == 10) return false;" class="box">
      <textarea name="msg" class="box" placeholder="Enter your message" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" name="send" class="btn">
   </form>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
