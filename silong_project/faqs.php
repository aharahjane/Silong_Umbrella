<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Silong | FAQS</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
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
         font-size: 24px; 
         text-align: left;
      }
      h2 {
         font-size: 20px;
         text-align: left;
      }
      
      p {
         font-size: 18px; 
         text-align: left;
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
      <h1 class="heading">FREQUENTLY ASKED QUESTIONS</h1>
      <h1>SHIPPING</h1>
      <br></br>
      <h2>How long will it take?</h2>
    <p>Within Metro Manila: 1-3 working days </p>
    <p>Outside Metro Manila: 3-7 working days </p>
    <br></br>
    <h2>How much does shipping cost?</h2>
    <p>Shipping is FREE nationwide for orders ₱1,500 and up. For orders below ₱1,500, there is a ₱150 small order delivery charge.</p>
    <br></br>
    <h2>Policy</h2>
    <p>You can check the Privacy Policy, Return and Refund Policy, and Terms of service in the footer section.</p>

   </div>

</section>

<section class="reviews">


</section>









<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
        slidesPerView:1,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>