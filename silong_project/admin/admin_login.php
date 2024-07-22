<?php
session_start();

include("config.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['pass'];

    if (!empty($username) && !empty($password) && !is_numeric($username)) {
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            if ($result->num_rows > 0) {
                $user_data = $result->fetch_assoc();

                if (password_verify($password, $user_data['password'])) {
                    $_SESSION['admin_id'] = $user_data['id'];
                    $_SESSION['username'] = $user_data['username'];
                    header("location: admin.php");
                    die;
                } else {
                    $message[] = 'Wrong username or password.';
                }
            } else {
                $message[] = 'Wrong username or password.';
            }
        } else {
            $message[] = 'Database query failed.';
        }
    } else {
        $message[] = 'Kindly check if your username is correct.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
</head>
<style>
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
   font: 15px/1.5 Arial, Helvetica,sans-serif;
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

.header{
   position: sticky;
   top:0; left:0; right:0;
   background-color: var(--white);
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
   z-index: 1000;
   border-bottom: var(--border);
}

.header .flex{
   display: flex;
   align-items: center;
   justify-content: space-between;
   position: relative;
}

.header .flex .logo{
   font-size: 2.5rem;
   color:var(--black);
}

.header .flex .logo span{
   color:var(--main-color);
}

.header .flex .navbar a{
   margin:0 1rem;
   font-size: 2rem;
   color:var(--light-color);
}

.header .flex .navbar a:hover{
   color:var(--main-color);
}

.header .flex .icons > *{
   font-size: 2.5rem;
   cursor: pointer;
   color:var(--light-color);
   margin-left: 1.7rem;
}

.header .flex .icons > *:hover{
   color:var(--main-color);
}

.header .flex .profile{
   position: absolute;
   top:125%; right:2rem;
   background-color: var(--white);
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
   border:var(--border);
   border-radius: .5rem;
   padding:2rem;
   padding-top: 1rem;
   width: 30rem;
   display: none;
   animation: fadeIn .2s linear;
}

@keyframes fadeIn {
   0%{
      transform: translateY(1rem);
   }
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
<body>

<?php
if (isset($message)) {
   foreach ($message as $msg) {
       echo '
       <div class="message">
           <span>' . $msg . '</span>
           <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
       </div>
       ';
   }
}
?>

<section class="form-container">
   <form action="" method="POST">
       <h3>login now</h3>
       <p>default username = <span>admin1</span> & password = <span>111</span></p>
       <input type="text" name="username" maxlength="20" required placeholder="Enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
       <input type="password" name="pass" maxlength="20" required placeholder="Enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
       <input type="submit" value="login now" name="submit" class="btn">
   </form>
</section>

</body>
</html>
