<style>
   .footer {
  background-color:#35424a;
  width: 100%;
  text-align: left;
  font-family: sans-serif;
  font-weight: bold;
  font-size: 16px;
  padding: 50px;
  margin-top: 50px;
}

.footer .footer-left,
.footer .footer-center,
.footer .footer-right {
  display: inline-block;
  vertical-align: top;
}



/* footer left*/

.footer .footer-left {
  width: 33%;
  padding-right: 15px;
}

.footer .about {
  line-height: 20px;
  color: #ffffff;
  font-size: 13px;
  font-weight: normal;
  margin: 0;
}

.footer .about span {
  display: block;
  text-align: left;
  color: #ffffff;
  font-size: 14px;
  font-weight: bold;
  margin-bottom: 20px;
}

.footer .icons {
  margin-top: 25px;
}

.footer .icons a {
  display: inline-block;
  width: 35px;
  height: 35px;
  cursor: pointer;
  background-color: #333b34;
  border-radius: 2px;
  font-size: 20px;
  color: #ffffff;
  text-align: center;
  line-height: 35px;
  margin-right: 3px;
  margin-bottom: 5px;
}


/* footer center*/

.footer .footer-center {
  width: 30%;
}

.footer .footer-center i {
  background-color: #333b34;
  color: #ffffff;
  font-size: 25px;
  width: 38px;
  height: 38px;
  border-radius: 50%;
  text-align: center;
  line-height: 42px;
  margin: 10px 15px;
  vertical-align: middle;
}

.footer .footer-center i.fa-envelope {
  font-size: 17px;
  line-height: 38px;
}

.footer .footer-center p {
  display: inline-block;
  color: #ffffff;
  vertical-align: middle;
  margin: 0;
}

.footer .footer-center p span {
  display: block;
  text-align: left;
  font-weight: normal;
  font-size: 14px;
  line-height: 2;
}

.footer .footer-center p a {
  color: #0099ff;
  text-decoration: none;
}


/* footer right*/

.footer .footer-right {
  width: 35%;
}

.footer .menu {
  color: #ffffff;
  margin: 20px 0 12px;
  padding: 0;
}

.footer .menu a {
  display: inline-block;
  line-height: 1.8;
  text-decoration: none;
  color: inherit;
}

.footer .menu a:hover {
  color: #0099ff;
}

.footer .name {
  color: #0099ff;
  text-align: left;
  font-size: 14px;
  font-weight: normal;
  margin: 0;
}

@media (max-width: 900px) {
  .footer {
    font-size: 14px;
  }
  .footer .footer-left,
  .footer .footer-center,
  .footer .footer-right {
    display: block;
    width: 100%;
    margin-bottom: 40px;
    text-align: center;
  }
  .footer .footer-center i {
    margin-left: 0;
  }
}
</style>


<footer class="footer">
    <div class="footer-left col-md-4 col-sm-6">
      <p class="about">
        <a href="#"><span> Privacy Policy</span></a>
        <a href="#"><span> Return and Refund Policy</span></a>
        <a href="#"><span> Terms of Service</span></a>
      </p>

      <div class="icons">
        <a href="facebook.com/aharahjanefaustino"><i class="fa-brands fa-facebook"></i></a>
        <a href="#"><i class="fa-brands fa-twitter"></i></a>
        <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
        <a href="#"><i class="fa-brands fa-google-plus-g"></i></a>
        <a href="#"><i class="fa-brands fa-instagram"></i></a>
      </div>
    </div>
    <div class="footer-center col-md-4 col-sm-6">
      <div>
        <i class="fa-solid fa-location-dot"></i>
        <p><span> Salawag, Dasmarinas </span> Cavite, Philippines </p>
      </div>
      <div>
        <i class="fa-solid fa-phone"></i>
        <p> (+63) 9369 057 086</p>
      </div>
      <div>
        <i class="fa-solid fa-envelope"></i>
        <p><a href="#"> silong_ph@yahoo.com</a></p>
      </div>
    </div>
    <div class="footer-right col-md-4 col-sm-6">
      <div id="branding">
        <img src="images/silong.png" class = "logo">
     </div>
      <p class="menu">
        <a href="home.php">HOME</a> |
        <a href="products.php">PRODUCTS</a> |

        <a href="products.php">MY ORDERS</a> |
        <a href="faqs.php">FAQS</a> |
        <a href="contact.php">CONTACT US</a> |
        <a href="user_login.php">LOGIN</a> |
      </p>
      <p class="name"> Silong Umbrella &copy; 2024</p>
    </div>
  </footer>
