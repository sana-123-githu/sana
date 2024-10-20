<?php
include("./auth/adminauth.php");

// Database connection
$conn = new mysqli("localhost", "root", "", "complainreg");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch SOS alerts from the locations table
$sql = "SELECT * FROM locations "; // Assuming alert_type indicates SOS
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOS Alerts</title>
    <link rel="stylesheet" href="styles.css"> <!-- Adjust to your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(88, 88, 245, 0.2);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .navbar {
    width: 100%;
    background-color: #5c6bc0; /* Darker blue for navbar background */
    display: flex;
    justify-content: space-between;
    align-items: center; /* Center items vertically */
    padding: 10px 20px; /* Padding for spacing */
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    height: 70px;
}

.navuladmin {
    display: flex;
    width: 60%;
    justify-content: space-evenly;
    align-items: center;
    list-style: none;
    margin: 0; /* Reset margin for list */
}

.navheading {
    height: 100%;
    display: flex;
    align-items: center;
    padding-left: 20px;
}

.adminheading {
    display: flex;
    justify-content: center;
    margin-top: 50px; /* Adjusted for better positioning */
}

.nava {
    color: rgb(221, 212, 212); /* Light text color */
    padding: 10px 15px; /* Padding for clickable area */
    border-radius: 4px; /* Rounded corners */
    transition: background-color 0.3s; /* Smooth transition for hover effect */
    text-decoration: none;
}

.nava:hover {
    background-color: rgba(255, 255, 255, 0.2); /* Light hover effect */
}

.dropdown {
    position: relative; /* Positioning for dropdown */
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #333; /* Dark background for dropdown */
    min-width: 160px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.dropdown-content a {
    color: rgb(221, 212, 212);
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {
    background-color: #454343; /* Darker hover effect for dropdown items */
}

.dropdown:hover .dropdown-content {
    display: block; /* Show dropdown on hover */
}

.logoo {
    margin-left: 20px; /* Adjusted for better alignment */
    width: 125px;
    cursor: pointer;
}

        .sos-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            width: 80%;
        }
        .sos-card {
            background-color: white;
            border: 1px solid rgba(88, 88, 245, 0.5);
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 300px; /* Fixed width for each card */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 200px; /* Fixed height for uniformity */
        }
        .sos-card h3 {
            margin: 0;
            color: rgba(88, 88, 245, 1);
        }
        .sos-card p {
            margin: 5px 0;
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
                    <li><a class="nava" href="admin_view_sos.php">View SOS Alerts</a></li>
                    <li><a class="nava" href="login.php">Logout</a></li>
                </ul>
         </nav>
<div class="adminheading">
    <h1>SOS Alerts</h1>
</div>

<div class="sos-container">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="sos-card">
                <h3>Alert ID: <?php echo $row['id']; ?></h3>
                <p><strong>User ID:</strong> <?php echo $row['userid']; ?></p>
                <p><strong>Latitude:</strong> <?php echo $row['latiitude']; ?></p>
                <p><strong>Longitude:</strong> <?php echo $row['longitude']; ?></p>
                <p><strong>Timestamp:</strong> <?php echo $row['created_at']; ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No SOS alerts found.</p>
    <?php endif; ?>
</div>

<?php $conn->close(); ?>
</body>
</html>
