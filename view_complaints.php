<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admindashboardd.css">
    <link rel="stylesheet" href="assignofficerss.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(88, 88, 245, 0.203);
            padding: 20px;
            margin: 0;
            padding: 0;
        }

        .complaint-box {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 10px 0; /* Space between boxes */
            padding: 15px;
            box-shadow: 0 2px 10px 5px rgba(0, 0, 0, 0.1);
            width: 40%;

        }

        .complaint-box h3 {
            margin-top: 0;
            font-size: 1.5em;
        }

        .complaint-box img {
            max-width: 30%;
            height: auto;
            border-radius: 5px;
        }

        .action-buttons {
            margin-top: 10px;
        }

        button {
            margin-right: 5px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .accept-button {
            background-color: #4CAF50; /* Green */
            color: white;
        }

        .decline-button {
            background-color: #f44336; /* Red */
            color: white;
        }

        .assign-button {
            background-color: #008CBA; /* Blue */
            color: white;
        }
        .cbox{
            width:100%;
            height:min-content;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
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
                    <a href="deleteuser.php">Delete User</a>
                </div>
            </li>
            <li><a class="nava" href="home.html">Logout</a></li>
        </ul>
    </nav>

    <h2>Complaints</h2>

    <div class="container">
        <?php
        include("./auth/adminauth.php");
        $conn = mysqli_connect("localhost", "root", "", "complainreg");
        if (!$conn) {
            echo "DB not connected";
        }

        // Fetch complaints from the database
        $sql = "SELECT * FROM complaints";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['complaint_id'];
                $voice = $row['voice'];
                $status = $row['status'];
echo "<div class='cbox'>";
                echo "<div class='complaint-box'>";
                echo "<h3>Complaint ID: " . htmlspecialchars($row['complaint_id']) . "</h3>";
                echo "<p><strong>Victim Name:</strong> " . htmlspecialchars($row['name']) . "</p>";
                echo "<p><strong>Type:</strong> " . htmlspecialchars($row['complaint_type']) . "</p>";
                echo "<p><strong>Date:</strong> " . htmlspecialchars($row['date']) . "</p>";
                echo "<p><strong>Details:</strong> " . htmlspecialchars($row['complaint_detail']) . "</p>";
                echo "<p><strong>Suspect Name:</strong> " . htmlspecialchars($row['suspect_name']) . "</p>";
                echo "<img src='./assets/" . htmlspecialchars($row['photo']) . "' alt='Complaint Photo'>";
                echo "<p><strong>Status:</strong> " . htmlspecialchars($status) . "</p>";
                echo "<p><strong>Officer ID:</strong> " . htmlspecialchars($row['officerid']) . "</p>";
              

                // Audio player
                echo "<audio controls>
                        <source src='" . htmlspecialchars($voice) . "' type='audio/mp3'>
                        Your browser does not support the audio element.
                      </audio>";

                echo "<div class='action-buttons'>";
                if ($status == 'pending') {
                    echo "<form action='update_status.php' method='post' style='display:inline;'>
                            <input type='hidden' name='complaint_id' value='$id'>
                            <button name='action' value='accept' class='accept-button' type='submit'>ACCEPT</button>
                          </form>
                          <form action='update_status.php' method='post' style='display:inline;'>
                            <input type='hidden' name='complaint_id' value='$id'>
                            <button name='action' value='decline' class='decline-button' type='submit'>DECLINE</button>
                          </form>";
                } elseif ($status == 'accepted') {
                    echo "<form action='assignofficer.php' method='post' style='display:inline;'>
                            <input type='hidden' name='complaint_id' value='$id'>
                            <button class='assign-button' type='submit' name='assignofficer' value='$id'>ASSIGN OFFICER</button>
                          </form>";
                } elseif ($status == 'declined') {
                    echo "<p>Complaint Declined</p>";
                } else {
                    echo "<p>Status: $status</p>";
                }
                echo "</div>"; // Close action-buttons
                echo "</div>"; // Close complaint-box
                echo "</div>"; 
            }
        } else {
            echo "<p>No records found.</p>";
        }
        ?>
    </div>
</body>
</html>
