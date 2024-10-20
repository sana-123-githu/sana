<?php
include("./auth/adminauth.php");

// Database connection
$conn = mysqli_connect("localhost", "root", "", "complainreg");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_id = intval($_POST['complaint_id']);
    $action = $_POST['action'];

    if ($action == 'accept') {
        $sql = "UPDATE complaints SET status = 'accepted' WHERE complaint_id = $complaint_id";
    } else if ($action == 'decline') {
        $sql = "UPDATE complaints SET status = 'declined' WHERE complaint_id = $complaint_id";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: view_complaints.php");
        exit();
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
