<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admindashboardd.css">
    <link rel="stylesheet" href="assignofficerss.css">
    <style>
        .complaint-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            background-color: #f9f9f9;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .complaint-box h3 {
            margin: 0 0 10px;
        }
        .complaint-details {
            margin: 5px 0;
        }
        .assign-officer {
            margin-top: 20px;
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

    <h2>Assign Officer to Complaint</h2>

    <?php
    include("./auth/adminauth.php");
    
    $conn = mysqli_connect("localhost", "root", "", "complainreg");
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    
    if (isset($_POST['assignofficer'])) {
        $complaintId = $_POST['assignofficer'];
        $sql = "SELECT * FROM complaints WHERE complaint_id='$complaintId'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $complaint = mysqli_fetch_assoc($result);
            echo "<div class='complaint-box'>";
            echo "<h3>Complaint Details</h3>";
            echo "<div class='complaint-details'><strong>ID:</strong> ".$complaint['complaint_id']."</div>";
            echo "<div class='complaint-details'><strong>Type:</strong> ".$complaint['complaint_type']."</div>";
            echo "<div class='complaint-details'><strong>Date:</strong> ".$complaint['date']."</div>";
            echo "<div class='complaint-details'><strong>Details:</strong> ".$complaint['complaint_detail']."</div>";
            echo "<div class='complaint-details'><strong>Status:</strong> ".$complaint['status']."</div>";
            echo "</div>"; // End of complaint-box

            echo "<div class='assign-officer'>";
            echo "<h3>Assign Officer</h3>";
            echo "<form method='POST' action=''>";
            echo "<input type='hidden' name='complaint_id' value='".$complaint['complaint_id']."'>";
            echo "<select name='officerid'>";

            $officerSql = "SELECT officerid, name FROM officer";
            $officerResult = mysqli_query($conn, $officerSql);
            while ($officer = mysqli_fetch_assoc($officerResult)) {
                echo "<option value='".$officer['officerid']."'>".$officer['name']."</option>";
            }

            echo "</select>";
            echo "<input type='submit' name='submit_assignment' value='Assign'>";
            echo "</form>";
            echo "</div>"; // End of assign-officer
        } else {
            echo "Complaint not found.";
        }
    }

    if (isset($_POST['submit_assignment'])) {
        $complaintId = $_POST['complaint_id'];
        $officerId = $_POST['officerid'];

        $updateSql = "UPDATE complaints SET officerid='$officerId' WHERE complaint_id='$complaintId'";
        if (mysqli_query($conn, $updateSql)) {
            echo "Officer assigned successfully.";
            header('Location: view_complaints.php');
            exit();
        } else {
            echo "Error assigning officer: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
    ?>
</body>
</html>
