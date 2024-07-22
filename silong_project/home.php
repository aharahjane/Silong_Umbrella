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
   <title>Silong | Homepage</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="./css/style.css">
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

      h2 {
         font-size: 28px; 
         text-align: center;
      }

      
      p {
         font-size: 18px; 
         text-align: center;
      }

      /* GALLERY */
      .gallery-container {
         display: flex;
         justify-content: center;
         align-items: center;
         flex-direction: column;
         text-align: center;
         padding: 20px;
      }

      .gallery {
         display: flex;
         justify-content: center;
         align-items: center;
         flex-wrap: wrap;
         gap: 20px;
         width: 100%;
         max-width: 1100px; /* Adjust this value as needed */
         margin: 0 auto; /* Center the gallery within the container */
      }

      .gallery .card {
         position: relative;
         max-width: 300px;
         height: 215px;
         background-color: #FFF;
         margin: 30px 10px;
         padding: 20px 15px;
         display: flex;
         flex-direction: column;
         box-shadow: 0 5px 20px rgba(0,0,0,0.5);
         transition: 0.3s ease-in-out;
      }
      .gallery .card:hover {
         height: 420px;
      }
      .gallery .card .imgBx {
         position: relative;
         width: 260px;
         height: 260px;
         top: -60px;
         left: 20px;
         z-index: 1;
         box-shadow: 0 5px 20px rgba(0,0,0,0.5);
      }
      .gallery .card .imgBx img {
         max-width: 100%;
         border-radius: 4px;
      }
      .gallery .card .content {
         position: relative;
         margin-top: -140px;
         padding: 10px 15px;
         text-align: center;
         color: #111;
         visibility: hidden;
         opacity: 0;
         transition: 0.3s ease-in-out;
      }
      .gallery .card:hover .content {
         visibility: visible;
         opacity: 1;
         margin-top: -40px;
         transition-delay: 0.3s;
      }

      .clearfix:after {
         content: "";
         display: table;
         clear: both;
      }

      /* Slider Styles */
      .slider{
         width: 100%;
         height: 80vh;
         margin-top: -8px;
         position: sticky; 
      }
      .slider .list{
         width: 100%;
         height: 100%;
         position: relative;
      }
      .slider .list .item{
         position: absolute;
         inset: 0;
         overflow: hidden;
         opacity: 0;
         transition: .5s;
      }
      .slider .list .item img{
         width: 100%;
         height: 100%;
         object-fit: cover;
      }
      .slider .list .item::after{
         content: '';
         width: 100%;
         height: 100%;
         position: absolute;
         left: 0;
         bottom: 0;
         background-image: linear-gradient(to top, #000 40%, transparent);
      }
      .slider .list .item .content{
         position: absolute;
         left: 10%;
         top: 20%;
         width: 500px;
         max-width: 80%;
         z-index: 1;
      }
      .slider .list .item .content p:nth-child(1){
         text-transform: uppercase;
         letter-spacing: 10px;
      }
      .slider .list .item .content h2{
         font-size: 100px;
         margin: 0;
      }
      .slider .list .item.active{
         opacity: 1;
         z-index: 10;
      }
      @keyframes showContent {
         to{
            transform: translateY(0);
            filter: blur(0);
            opacity: 1;
         }
      }
      .slider .list .item.active p:nth-child(1),
      .slider .list .item.active h2,
      .slider .list .item.active p:nth-child(3){
         transform: translateY(30px);
         filter: blur(20px);
         opacity: 0;
         animation: showContent .5s .7s ease-in-out 1 forwards;
      }
      .slider .list .item.active h2{
         animation-delay: 1s;
      }
      .slider .list .item.active p:nth-child(3){
         animation-duration: 1.3s;
      }
      .arrows{
         position: absolute;
         top: 30%;
         right: 50px;
         z-index: 100;
      }
      .arrows button{
         background-color: #eee5;
         border: none;
         font-family: monospace;
         width: 40px;
         height: 40px;
         border-radius: 5px;
         font-size: x-large;
         color: #eee;
         transition: .5s;
      }
      .arrows button:hover{
         background-color: #eee;
         color: black;
      }
      .thumbnail{
         position: absolute;
         bottom: 50px;
         z-index: 11;
         display: flex;
         gap: 10px;
         width: 100%;
         height: 250px;
         padding: 0 50px;
         box-sizing: border-box;
         overflow: auto;
         justify-content: center;
      }
      .thumbnail::-webkit-scrollbar{
         width: 0;
      }
      .thumbnail .item{
         width: 150px;
         height: 220px;
         filter: brightness(.5);
         transition: .5s;
         flex-shrink: 0;
      }
      .thumbnail .item img{
         width: 100%;
         height: 100%;
         object-fit: cover;
         border-radius: 10px;
      }
      .thumbnail .item.active{
         filter: brightness(1.5);
      }
      .thumbnail .item .content{
         position: absolute;
         inset: auto 10px 10px 10px;
      }
      @media screen and (max-width: 678px) {
         .thumbnail{
            justify-content: start;
         }
         .slider .list .item .content h2{
            font-size: 60px;
         }
         .arrows{
            top: 10%;
         }
      }
   </style>

</head>

<body>
   
<?php include 'components/user_header.php'; ?>

<section class="home">

   <div class="slider">

    
      <div class="list">
         <div class="item active">
            <img src="images/img1.png">
         </div>
         <div class="item">
            <img src="images/img2.png">
         </div>
         <div class="item">
            <img src="images/img3.png">
         </div>
         <div class="item">
            <img src="images/img4.png">
         </div>
         <div class="item">
            <img src="images/img5.png">
         </div>
      </div>
      <!-- button arrows -->
      <div class="arrows">
         <button id="prev"><</button>
         <button id="next">></button>
      </div>
      <!-- thumbnail -->
      <div class="thumbnail">
         <div class="item active">
            <img src="images/img1.png">
         </div>
         <div class="item">
            <img src="images/img2.png">
         </div>
         <div class="item">
            <img src="images/img3.png">
         </div>
         <div class="item">
            <img src="images/img4.png">
         </div>
         <div class="item">
            <img src="images/img5.png">
         </div>
      </div>
   </div>
   <script src="app.js"></script>

</section>

<br><br>
<h1> Silong </h1>

<p>Silong, derived from Filipino for 'shade,' embodies the concept of protection. In a tropical climate </p>
<p>such as the Philippines, an umbrella proves indispensable across all seasons and every single day of </p>
<p> the year. Now is the moment to acquire a durable, premium umbrella designed for longevity. </p>

<br><br><br><br>

<!-- Adding the gallery section here -->
<div class="gallery-container">
   <div data-aos="fade-up" data-aos-anchor-placement="top-center" class="gallery">
      <div class="card">
         <div class="imgBx">
            <img src="images/img6.png" alt="">
         </div>
         <div class="content">
            <h2>Classic Umbrella</h2>
            <p>A Foldable Umbrella which is for heavy duty, with a Maple Wood Handle.</p>
         </div>
      </div>

      <div class="card">
         <div class="imgBx">
            <img src="images/img11.jpg" alt="">
         </div>
         <div class="content">
            <h2>Slim Folding Umbrella</h2>
            <p>Folding umbrella with a wooden handle and a strap. Matching cover.</p>
         </div>
      </div>

      <div class="card">
         <div class="imgBx">
            <img src="images/img12.jpg" alt="">
         </div>
         <div class="content">
            <h2>Printed Style Umbrella</h2>
            <p>A Printed Umbrella in Vintage Check, with a Maple Wood Handle. </p>
         </div>
      </div>
   </div>
</div>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
<script src="js/app.js"></script>

</body>
</html>
