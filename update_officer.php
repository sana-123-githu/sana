<?php
include("./auth/adminauth.php");

$conn = new mysqli("localhost", "root", "", "complainreg");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = intval($_POST['request_id']);
    $new_officer_id = intval($_POST['new_officer']);

    $sql1 = "SELECT complaint_id FROM request WHERE id = $request_id";
    $result1 = $conn->query($sql1);
    
    if ($result1->num_rows > 0) {
        $value = $result1->fetch_assoc();
        $cmid = $value['complaint_id'];

        $sql2 = "UPDATE complaints SET officerid = $new_officer_id WHERE complaint_id = $cmid";
        $sql3 = "UPDATE request SET status = 'successful' WHERE id = $request_id";

        if ($conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE) {
            $message = "Officer updated successfully.";
            header('Location: admindashboard.php');
            exit(); 
        } else {
            $message = "Error updating officer: " . $conn->error;
        }
    } else {
        $message = "No corresponding complaint found.";
    }
} else {
    $message = "Invalid request.";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Officer Status</title>
    <link rel="stylesheet" href="admindashboard.css">
</head>
<body>
    <nav class="navbar">
        <h1 class="navheading">YOUR VOICE MATTERS!</h1>
        <ul class="navuladmin">
            <li class="dropdown">
                <a href="#">Complaint Management</a>
                <div class="dropdown-content">
                    <a href="view_complaints.php">View Complaint</a>
                    <a href="review_requests.php">View Requests</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#">Officer Management</a>
                <div class="dropdown-content">
                    <a href="addofficer.php">Add Officer</a>
                    <a href="updateofficer.php">Update Officer</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#">User Management</a>
                <div class="dropdown-content">
                    <a href="adduser.php">Add User</a>
                    <a href="deleteuser.php">Delete User</a>
                </div>
            </li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </nav>

    <div class="adminheading">
        <h1>Update Officer Status</h1>
    </div>

    <div class="message">
        <p><?php echo $message; ?></p>
    </div>

    <a href="review_requests.php">Back to Requests</a>
</body>
</html>
