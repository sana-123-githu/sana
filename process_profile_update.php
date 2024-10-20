<?php
include("./auth/userauth.php");

$conn = mysqli_connect("localhost", "root", "", "complainreg");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $oldemail = mysqli_real_escape_string($conn, $_POST['oldemail']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);

    $updateUserSQL = "UPDATE users SET name='$name', email='$email', phno='$phone', password='$pass' WHERE usid='$user_id'";
    $updateLoginSQL = "UPDATE login SET email='$email', password='$pass' WHERE email='$oldemail'";

    mysqli_begin_transaction($conn);
    try {
        if (!mysqli_query($conn, $updateUserSQL)) {
            throw new Exception("Error updating user: " . mysqli_error($conn));
        }

        if (!mysqli_query($conn, $updateLoginSQL)) {
            throw new Exception("Error updating login: " . mysqli_error($conn));
        }

        mysqli_commit($conn);
        echo "<script>alert('Profile updated successfully'); window.location.href='edit_profile.php';</script>";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}

mysqli_close($conn);
?>
