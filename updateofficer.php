<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Officer</title>
    <link rel="stylesheet" href="assignofficerss.css">
    <link rel="stylesheet" href="admindashboardd.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .officer-container {
            display: flex;
            flex-direction: column; /* Changed to column for single box in a row */
            gap: 20px;
            margin-top: 20px;
        }
        .officer-card {
            background-color: white; /* White background for cards */
            border: 1px solid rgba(88, 88, 245, 0.5);
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 60%; /* 60% width for each box */
            height: 290px;
            margin: 0 auto; /* Center the boxes */
            display: flex;
            align-items: flex-start;
            flex-direction: column;
            justify-content: space-evenly;
        }
        .officer-card h3 {
            margin: 0 0 10px;
            color: rgba(88, 88, 245, 1);
        }
        .officer-card p {
            margin: 5px 0;
        }
        .delete-button {
            background-color: rgba(245, 88, 88, 0.8);
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        .delete-button:hover {
            background-color: rgba(245, 88, 88, 1);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <img src="Assets/logowomen.png" alt="" class="logoo">
        <ul class="navuladmin">
            <li><a class="nava" href="admindashboard.php">Home</a></li>
            <li class="dropdown">
                <a href="#" class="nava">Complaint Management</a>
                <div class="dropdown-content">
                    <a href="view_complaints.php">View Complaint</a>
                    <a href="review_requests.php">View Requests</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="nava">Officer Management</a>
                <div class="dropdown-content">
                    <a href="addofficer.php">Add Officer</a>
                    <a href="updateofficer.php">Update Officer</a>
                    <a href="admin_view_officer_reviews.php">View Review</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="nava">User Management</a>
                <div class="dropdown-content">
                    <a href="deleteuser.php">Delete user</a>
                </div>
            </li>
            <li><a class="nava" href="login.php">Logout</a></li>
        </ul>
    </nav>

    <h2>Delete Officer</h2>
    <div class="officer-container">
        <?php
        include("./auth/adminauth.php");
        $conn = mysqli_connect("localhost", "root", "", "complainreg");
        if (!$conn) {
            echo "Database not connected";
        }
        $sql = "SELECT * FROM officer";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['officerid'];
                echo "<div class='officer-card'>";
                echo "<h3>Officer ID: ".$row['officerid']."</h3>";
                echo "<p><strong>Name:</strong> ".$row['name']."</p>";
                echo "<p><strong>Position:</strong> ".$row['position']."</p>";
                echo "<p><strong>DOB:</strong> ".$row['dob']."</p>";
                echo "<p><strong>Mobile:</strong> ".$row['phonenum']."</p>";
                echo "<p><strong>Email:</strong> ".$row['email']."</p>";
                echo "<form method='post'><button class='delete-button' value='{$id}' name='delofficer' type='submit'>DELETE</button></form>";
                echo "</div>";
            }
        } else {
            echo "<p>Record not found</p>";
        }
        ?>
    </div>
    
</body>
</html>

<?php
if (isset($_POST['delofficer'])) {
    $id = $_POST['delofficer'];
    if (!empty($_POST['delofficer'])) {
        $sql = "DELETE FROM `officer` WHERE `officerid` = '$id'";
        $data = mysqli_query($conn, $sql);
        echo "<script>alert('Officer deleted successfully'); window.location.href='updateofficer.php';</script>";
    }
}
?>
