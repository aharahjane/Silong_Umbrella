<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}


$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}
if($_SERVER['REQUEST_METHOD'] == "POST")
{
  $name = $_POST['name'];
  $username = $_POST['username'];
  $password =password_hash($_POST['password'], PASSWORD_DEFAULT);
  

  if(!empty($username) && !empty($password) && !is_numeric($username))
  {
    
    
    $query = "insert into admins (name, username, password) values ('$name', '$username', '$password')";
    
    mysqli_query($conn, $query);

    echo "<script type='text/javascript'> alert('Successfully Registered')</script>";
  }
  else
  {
      echo "<script type='text/javascript'> alert('Please enter some valid information')</script>";
  }


}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>admin portal</title>


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="admin_style.css">

</head>
<body>

    <?php include 'header.php'; ?>

    <style>
        

body{
  font: 15px/1.5 Arial, Helvetica,sans-serif;
  padding:0;
  margin:0;
  background-color:#f4f4f4;
}

/* Global */

.container{
  width:80%;
  margin:auto;
  overflow:hidden; 
  justify-content: center;
  align-items: center;
}


.button_1{
  height:38px;
  background:#e8491d;
  border:0;
  padding-left: 20px;
  padding-right:20px;
  color:#ffffff;
}

.dark{
  padding:15px;
  background:#35424a;
  color:#ffffff;
  margin-top:10px;
  margin-bottom:10px;
}

.search-box {
  position: absolute;
  top: 4%;
  left: 86.5%;
  display: flex;
  align-items: center;
  transform: translate(-50%, -50%);
  padding: 5px;
  border-radius: 50px;
  height: 20px;
  background: hsl(0, 0%, 96%);
}

.search-box:hover .search-txt {
  width: 240px;
  padding: 0 6px;
}


.search-box:hover .search-btn {
  background: #f9f9f9;
}

.search-txt {
  border: none;
  background: none;
  outline: none;
  padding: 0;
  color: #000000;
  transition: 0.5s;
  font-size: 1rem;
  width: 0px;
}

.search-btn {
  color: #128ec7;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  transition: 0.5s;
}



.clearfix:after {
  content: "";
  display: table;
  clear: both;
}


/* Sidebar */
aside#sidebar{
  float:right;
  width:30%;
  margin-top:10px;
}

aside#sidebar .quote input, aside#sidebar .quote textarea{
  width:90%;
  padding:5px;
}

/* Main-col */
article#main-col{
  float:left;
  width:1000%;
}

/* Button */
.logout-btn {
  background-color: #1E90FF; /* Dark blue */
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;

  transition: background-color 0.3s ease;
}

.logout-btn:hover {
  background-color: #0056b3; /* Slightly darker blue on hover */
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

/* Media Queries */
@media(max-width: 768px){
  header #branding,
  header nav,
  header nav li,
  #newsletter h1,
  #newsletter form,
  #boxes .box,
  article#main-col,
  aside#sidebar{
    float:none;
    text-align:center;
    width:100%;
  }

}

span{
  font-size: 35px;
  letter-spacing: 7px;
  transition: 5s ;
  cursor: pointer;
}

.form {
  display: flex;
  flex-direction: column;
  gap: 15px;
  max-width: 500px;
  background-color: #fff;
  border-radius: 20px;
  position: absolute;
  top: 20%;
  left: 37%;
  width: 400px;
  padding: 43px;
}

.title {
  font-size: 28px;
  color: royalblue;
  font-weight: 600;
  letter-spacing: -1px;
  position: relative;
  display: flex;
  align-items: center;
  padding-left: 30px;
}

.title::before,.title::after {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  border-radius: 50%;
  left: 0px;
  background-color: royalblue;
}

.title::before {
  width: 18px;
  height: 18px;
  background-color: royalblue;
}

.title::after {
  width: 18px;
  height: 18px;
  animation: pulse 1s linear infinite;
}

.message, .signin {
  color: rgba(88, 87, 87, 0.822);
  font-size: 14px;
}

.signin {
  text-align: center;
}

.signin a {
  color: royalblue;
}

.signin a:hover {
  text-decoration: underline royalblue;
}

.flex {
  display: flex;
  width: 100%;
  gap: 30px;
}

.form label {
  display: flex;
  position: relative;
}

.form label .input {
  width: 100%;
  padding: 10px 10px 20px 10px;
  outline: 0;
  border: 1px solid rgba(105, 105, 105, 0.397);
  border-radius: 10px;
  text-transform: none; 
}


.form label .input + span {
  position: absolute;
  left: 10px;
  top: 15px;
  color: grey;
  font-size: 0.9em;
  cursor: text;
  transition: 0.3s ease;
}

.form label .input:placeholder-shown + span {
  top: 15px;
  font-size: 0.9em;
}

.form label .input:focus + span,.form label .input:valid + span {
  top: 30px;
  font-size: 0.7em;
  font-weight: 700;
}

.form label .input:valid + span {
  color: green;
}

.glow-on-hover {
  width: 318px;
  height: 50px;
  border: none;
  outline: none;
  color: #fff;
  background: royalblue;
  cursor: pointer;
  position: relative;
  z-index: 0;
  border-radius: 10px;
  font-weight: 600;
}

.glow-on-hover:before {
  content: '';
  position: absolute;
  top: -2px;
  left: -2px;
  background-size: 400%;
  z-index: -1;
  filter: blur(5px);
  width: calc(100% + 4px);
  height: calc(100% + 4px);
  animation: glowing_54134 20s linear infinite;
  opacity: 0;
  transition: opacity .3s ease-in-out;
  border-radius: 10px;
}

.glow-on-hover:active {
  color: #000
}

.glow-on-hover:active:after {
  background: transparent;
}

.glow-on-hover:hover:before {
  opacity: 1;
}

.glow-on-hover:after {
  z-index: -1;
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  background: #111;
  left: 0;
  top: 0;
  border-radius: 10px;
}



    </style>

    <form class="form" method="POST">
      <p class="title">New admin account </p>
        <label>
              <input required="" name="name" type="text" class="input">
              <span>Name</span>
        </label>
  
        <label>
              <input required="" name="username" type="text" class="input">
              <span>Username</span>
        </label>
          
      <label>
          <input required="" name="password" type="password" class="input">
          <span>Password</span>
      </label>

      <label>
          <input required="" name="" type="password" class="input">
          <span>Confirm password</span>
      </label>

      <input type="submit" value="Submit" class="glow-on-hover">
     
  </form>
    

  <script>AOS.init();</script>
  <script src="script.js"></script>
    
  
  
  </body>
</html>   



<script src="admin_script.js"></script>


</body>
</html>