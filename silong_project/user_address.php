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

    // Fetch all addresses of the user
    $select_addresses = $conn->prepare("SELECT * FROM `addresses` WHERE user_id = ?");
    $select_addresses->execute([$user_id]);
    $addresses = $select_addresses->fetchAll(PDO::FETCH_ASSOC);

    // Handle form submission to add a new address
    if(isset($_POST['add_address'])){
       $house_no = $_POST['house_no'];
       $street = $_POST['street'];
       $brgy = $_POST['brgy'];
       $city = $_POST['city'];
       $province = $_POST['province'];
       $zip_code = $_POST['zip_code'];

       // Check if there are existing addresses
       $select_existing_addresses = $conn->prepare("SELECT COUNT(*) FROM `addresses` WHERE user_id = ?");
       $select_existing_addresses->execute([$user_id]);
       $address_count = $select_existing_addresses->fetchColumn();

       // If no addresses exist, set this one as default
       $is_default = ($address_count == 0) ? 1 : ((isset($_POST['is_default']) && $_POST['is_default'] == 'on') ? 1 : 0);
       if ($is_default) {
          $update_default = $conn->prepare("UPDATE `addresses` SET is_default = 0 WHERE user_id = ?");
          $update_default->execute([$user_id]);
       }

       // Insert new address into the database
       $insert_address = $conn->prepare("INSERT INTO `addresses`(user_id, house_no, street, brgy, city, province, zip_code, is_default) VALUES(?,?,?,?,?,?,?,?)");
       $insert_address->execute([$user_id, $house_no, $street, $brgy, $city, $province, $zip_code, $is_default]);

       // Redirect to prevent form resubmission
       header('location:user_address.php');
       exit;
    }

    // Handle delete address
    if(isset($_POST['delete_address'])){
        $address_id = $_POST['address_id'];

        // Delete address from the database
        $delete_address = $conn->prepare("DELETE FROM `addresses` WHERE id = ?");
        $delete_address->execute([$address_id]);

        // Redirect to prevent form resubmission
        header('location:user_address.php');
        exit;
    }

    // Handle set default address
    if(isset($_POST['set_default_address'])){
        $address_id = $_POST['address_id'];

        // Unset all default addresses first
        $unset_default = $conn->prepare("UPDATE `addresses` SET is_default = 0 WHERE user_id = ?");
        $unset_default->execute([$user_id]);

        // Set the selected address as default
        $set_default = $conn->prepare("UPDATE `addresses` SET is_default = 1 WHERE id = ?");
        $set_default->execute([$address_id]);

        // Redirect to prevent form resubmission
        header('location:user_address.php');
        exit;
    }

    // Handle edit address
    if(isset($_POST['edit_address'])){
        $address_id = $_POST['address_id'];
        $house_no = $_POST['house_no'];
        $street = $_POST['street'];
        $brgy = $_POST['brgy'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $zip_code = $_POST['zip_code'];
        $is_default = (isset($_POST['is_default']) && $_POST['is_default'] == 'on') ? 1 : 0;

        if ($is_default) {
            $update_default = $conn->prepare("UPDATE `addresses` SET is_default = 0 WHERE user_id = ?");
            $update_default->execute([$user_id]);
        }

        $update_address = $conn->prepare("UPDATE `addresses` SET house_no = ?, street = ?, brgy = ?, city = ?, province = ?, zip_code = ?, is_default = ? WHERE id = ?");
        $update_address->execute([$house_no, $street, $brgy, $city, $province, $zip_code, $is_default, $address_id]);

        header('location:user_address.php');
        exit;
    }
} else {
    header('location:user_login.php');
    exit; // Ensure script stops execution if user is not logged in
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Addresses</title>
   <!-- Add your CSS links and styles here -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/payong.png">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
   <style>
      * {
         font-family: "Lato", sans-serif;
         font-weight: 400;
         font-style: normal;
         box-sizing: border-box;
      }
      body {
         margin: 0;
         padding: 0;
         background-color: #f0f0f0;
         font-size: 16px; /* Base font size */
      }
      .container {
         max-width: 800px;
         margin: 20px auto;
         padding: 20px;
         background-color: #fff;
         border-radius: 8px;
         box-shadow: 0 0 10px rgba(0,0,0,0.1);
      }
      h1 {
         font-size: 28px; /* Larger heading font size */
         margin-bottom: 20px;
      }
      h2 {
         font-size: 24px; /* Larger sub-heading font size */
         margin-bottom: 15px;
      }
      ul {
         list-style: none;
         padding: 0;
         margin: 0;
      }
      li {
         margin-bottom: 40px;
         padding: 10px;
         background-color: #f9f9f9;
         border-radius: 4px;
         box-shadow: 0 1px 2px rgba(0,0,0,0.1);
         position: relative;
      }
      li:last-child {
         margin-bottom: 0;
      }
      .default-address {
         color: #1F618D;
         font-weight: bold;
      }
      
      .option-btn {
        display: inline-block;
        margin-top: 1rem;
        padding: 1rem 2rem;
        background-color: #1F618D; /* blue button */
        color: white;
        border: none;
        border-radius: .5rem;
        font-size: 1.8rem;
        text-decoration: none;
        width: calc(100% - 2.8rem); 
        box-sizing: border-box; 
        }

      .edit-btn:hover, .delete-btn:hover {
         color: #1F618D; /* Change color on hover */
      }
      .default-checkbox {
         top: 35px;
      }
      .add-address-form {
         margin-top: 30px;
         padding: 20px;
         background-color: #f9f9f9;
         border-radius: 8px;
         box-shadow: 0 1px 2px rgba(0,0,0,0.1);
      }
      .add-address-form label {
         display: block;
         margin-bottom: 5px;
         font-size: 18px; /* Larger label font size */
      }
      .add-address-form input[type="text"], .add-address-form input[type="checkbox"] {
         width: calc(100% - 22px);
         padding: 8px;
         margin-bottom: 10px;
         border: 1px solid #ccc;
         border-radius: 4px;
         font-size: 18px; 
         box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
         background-color: #f9f9f9;
      }
      .add-address-form input[type="checkbox"] {
         width: auto;
         margin-top: 5px;
      }
      .add-address-form input[type="submit"] {
         padding: 12px 20px;
         background-color: #1F618D;
         color: #fff;
         border: none;
         border-radius: 4px;
         font-size: 18px; 
         cursor: pointer;
      }
      .add-address-form input[type="submit"]:hover {
         background-color: #333;
      }
   </style>
</head>
<body>

<?php include 'components/user_header.php'; ?>

<div class="container">
   <h1>My Addresses</h1>

   <?php if (!empty($addresses)): ?>
      <ul>
         <?php foreach ($addresses as $address): ?>
            <li>
               <strong>Address:</strong> <?= $address['house_no'] ?>, <?= $address['street'] ?>, <?= $address['brgy'] ?>, <?= $address['city'] ?>, <?= $address['province'] ?> - <?= $address['zip_code'] ?>
               <?php if ($address['is_default']): ?>
                  <span class="default-address">(Default)</span>
               <?php endif; ?>
               <form action="" method="POST" style="display: inline;">
                  <input type="hidden" name="address_id" value="<?= $address['id'] ?>">
                  
                  <?php if (!$address['is_default']): ?>
                    <br></br>
                     <label>Tick the check box if you want to set this as your default address:  </label>
                     <button type="submit" name="set_default_address"><i class="fas fa-check"></i></button>
                  <?php endif; ?>
               </form>
               <form action="" method="POST" style="display: inline;">
                  <input type="hidden" name="address_id" value="<?= $address['id'] ?>">
                  <button type="submit" name="delete_address" class="option-btn"><i class="fas fa-trash"></i></button>
               </form>
               <button class="option-btn" onclick="showEditForm(<?= $address['id'] ?>, '<?= $address['house_no'] ?>', '<?= $address['street'] ?>', '<?= $address['brgy'] ?>', '<?= $address['city'] ?>', '<?= $address['province'] ?>', '<?= $address['zip_code'] ?>', <?= $address['is_default'] ?>)"><i class="fas fa-edit"></i></button>
            </li>
         <?php endforeach; ?>
      </ul>
   <?php else: ?>
      <p>No addresses found.</p>
   <?php endif; ?>

   <div class="add-address-form">
      <h2>Add New Address</h2>
      <form action="" method="POST">
         <label>House No:</label>
         <input type="text" name="house_no" required><br>
         <label>Street:</label>
         <input type="text" name="street" required><br>
         <label>Barangay:</label>
         <input type="text" name="brgy" required><br>
         <label>City:</label>
         <input type="text" name="city" required><br>
         <label>Province:</label>
         <input type="text" name="province" required><br>
         <label>ZIP Code:</label>
         <input type="text" name="zip_code" required><br>
         <label>Set as default:</label>
         <input type="checkbox" name="is_default"><br>
         <input type="submit" name="add_address" value="Add Address">
      </form>
   </div>
</div>

<!-- Edit Address Form -->
<div id="edit-address-form" class="add-address-form" style="display: none;">
   <h2>Edit Address</h2>
   <form action="" method="POST">
      <input type="hidden" name="address_id" id="edit-address-id">
      <label>House No:</label>
      <input type="text" name="house_no" id="edit-house-no" required><br>
      <label>Street:</label>
      <input type="text" name="street" id="edit-street" required><br>
      <label>Barangay:</label>
      <input type="text" name="brgy" id="edit-brgy" required><br>
      <label>City:</label>
      <input type="text" name="city" id="edit-city" required><br>
      <label>Province:</label>
      <input type="text" name="province" id="edit-province" required><br>
      <label>ZIP Code:</label>
      <input type="text" name="zip_code" id="edit-zip-code" required><br>
      <label>Set as default:</label>
      <input type="checkbox" name="is_default" id="edit-is-default"><br>
      <input type="submit" name="edit_address" value="Update Address">
   </form>
</div>

<?php include 'components/footer.php'; ?>

<script>
function showEditForm(id, house_no, street, brgy, city, province, zip_code, is_default) {
    document.getElementById('edit-address-id').value = id;
    document.getElementById('edit-house-no').value = house_no;
    document.getElementById('edit-street').value = street;
    document.getElementById('edit-brgy').value = brgy;
    document.getElementById('edit-city').value = city;
    document.getElementById('edit-province').value = province;
    document.getElementById('edit-zip-code').value = zip_code;
    document.getElementById('edit-is-default').checked = is_default;
    document.getElementById('edit-address-form').style.display = 'block';
}
</script>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>
