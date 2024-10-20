<?php
include("./auth/userauth.php");

$conn = mysqli_connect("localhost", "root", "", "complainreg");
if (!$conn) {
    die("DB not connected");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $complaint_id = $_POST['complaint_id'];
    $officer_id = $_POST['officer_id'];
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);
    $user_id = $_SESSION['userid']; 

    $sql = "INSERT INTO request (complaint_id, officer_id, user_id, reason) VALUES ('$complaint_id', '$officer_id', '$user_id', '$reason')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Request submitted successfully'); window.location.href='view_complaint.php';</script>";
    } else {
        echo "<script>alert('Error submitting request: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}

mysqli_close($conn);
?>
