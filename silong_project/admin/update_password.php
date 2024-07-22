<?php
// Include the config file to connect to the database
include("config.php");

// Hash the password
$plain_password = '111';
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

// Update the password in the database
$query = "UPDATE admins SET password = '$hashed_password' WHERE name = 'admin1'";
mysqli_query($conn, $query);

if (mysqli_affected_rows($conn) > 0) {
    echo "Password has been updated to a hashed version.";
} else {
    echo "Error updating password: " . mysqli_error($conn);
}
?>
