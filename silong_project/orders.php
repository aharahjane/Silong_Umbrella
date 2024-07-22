<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silong | Orders</title>
    
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

        h1 {
            font-size: 36px; 
            text-align: center;
        }

        p {
            font-size: 18px; 
            text-align: center;
        }

        .products .box-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, 33rem);
            gap: 1.5rem;
            justify-content: center;
            align-items: flex-start;
        }

        .empty {
            padding: 1.5rem;
            background-color: var(--white);
            border: var(--border);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
            text-align: center;
            color: var(--red);
            border: none;
            border-radius: .5rem;
            font-size: 2rem;
            text-transform: capitalize;
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

        .orders .box-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: flex-start;
        }

        .orders .box-container .box {
            padding: 1rem 2rem;
            flex: 1 1 40rem;
            border: var(--border);
            background-color: var(--white);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
            border-radius: .5rem;
        }

        .orders .box-container .box p {
            margin: .5rem 0;
            line-height: 1.8;
            font-size: 2rem;
            color: var(--light-color);
            text-align: left;
        }

        .orders .box-container .box p span {
            color: var(--main-color);
        }
    </style>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="orders">

    <h1 class="heading">My Orders</h1>

    <div class="box-container">

    <?php
    if ($user_id == '') {
        echo '<p class="empty">Open your account to see your Orders</p>';
    } else {
        $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY `id` DESC");
        $select_orders->execute([$user_id]);

        if ($select_orders->rowCount() > 0) {
            while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                // Format the date and time
                $date_time = new DateTime($fetch_orders['placed_on']);
                $formatted_date = $date_time->format('F j, Y \a\t g:i A');
    ?>
    <div class="box">
        <p>Placed on : <span><?= $formatted_date; ?></span></p>
        <p>Name : <span><?= $fetch_orders['name']; ?></span></p>
        <p>Email : <span><?= $fetch_orders['email']; ?></span></p>
        <p>Phone Number : <span><?= $fetch_orders['number']; ?></span></p>
        <p>Address : <span><?= $fetch_orders['address']; ?></span></p>
        <p>Payment Method : <span><?= $fetch_orders['method']; ?></span></p>
        <p>Your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
        <p>Total price : <span>₱<?= $fetch_orders['total_price']; ?></span></p>
        <p> Order status : <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') { echo 'red'; } else { echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
    </div>
    <?php
            }
        } else {
            echo '<p class="empty">No orders placed yet!</p>';
        }
    }
    ?>

    </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
