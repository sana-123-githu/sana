<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
  
    <link rel="stylesheet" href="adminn.css">
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
        <div class="contain">
            <h1>ADMIN DASHBOARD</h1>
            
    </div>
    <?php
    include("./auth/adminauth.php");
    ?>
</body>
</html>
