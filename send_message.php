<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "complainreg");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_POST['sendMessage'])) {
    $message = $_POST['message'];
    $sender_type = $_POST['sender_type'];
    $sender_id = $_POST['sender_id'];
    $complaint_id = $_POST['complaint_id'];

    $sql = "INSERT INTO messages (complaint_id, sender_type, sender_id, message) 
            VALUES ('$complaint_id', '$sender_type', '$sender_id', '$message')";

    if (mysqli_query($conn, $sql)) {
        header("Location: chat.php?complaint_id=$complaint_id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
