<?php
// Start session or include authentication
session_start(); // Assuming user authentication is handled with sessions

// Database connection
$conn = new mysqli("localhost", "root", "", "complainreg");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch reviews from the database
$sql = "SELECT officer_reviews.id, officer_reviews.review, officer.name AS officer_name, users.name AS user_name 
        FROM officer_reviews
        JOIN officer ON officer_reviews.officer_id = officer.officerid
        JOIN users ON officer_reviews.user_id = users.usid"; // Adjust this line if your user table name or ID column is different
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Officer Reviews</title>
    <link rel="stylesheet" href="admindashboardd.css">
        <link rel="stylesheet" href="assignofficerss.css">
        <style>
        .complaint-box {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 10px 0; /* Space between boxes */
            padding: 15px;
            box-shadow: 0 2px 10px 5px rgba(0, 0, 0, 0.1);
            width: 40%;

        }
        .cbox{
            width:100%;
            height:min-content;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
        }


hr {
    margin: 10px 0;
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
                    <li><a class="nava" href="logout.php">Logout</a></li>
                    
                </ul>
         </nav>



    <h2>Officer Reviews</h2>
    
    <div class="container">
    <?php if ($result->num_rows > 0){
         while ($row = $result->fetch_assoc()){
        
            echo "<div class='cbox'>";
                echo "<div class='complaint-box'>";
                echo "<h3>Review ID: " . htmlspecialchars($row['id']) . "</h3>";
                echo "<p><strong>Officer Name:</strong> " . htmlspecialchars($row['officer_name']) . "</p>";
                echo "<p><strong>User Name:</strong> " . htmlspecialchars($row['user_name']) . "</p>";
                echo "<p><strong>Review:</strong> " . htmlspecialchars($row['review']) . "</p>";
                echo "</div>"; // Close action-buttons
                echo "</div>"; // Close complaint-box
            
            }
        } else {
            echo "<p>No records found.</p>";
        }
        ?>
    </div>
        

    <?php $conn->close(); ?>
</body>
</html>
