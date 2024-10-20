<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="admindashboardd.css">
    <link rel="stylesheet" href="assignofficerss.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(88, 88, 245, 0.203);
            padding: 20px;
        }

        .complaint-box {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 10px 0; /* Space between boxes */
            padding: 15px;
            box-shadow: 0 2px 10px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
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

        .chat-button {
            background-color: #008CBA; /* Blue */
            color: white;
        }

        .request-button {
            background-color: #f44336; /* Red */
            color: white;
        }

        .cbox {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <img src="Assets/logowomen.png" alt="" class="logoo">
        <ul class="navuladmin">
            <li><a class="nava" href="userdashboard.php">Home</a></li>
            <li><a class="nava" href="view_complaint.php">View Complaint</a></li>
            <li><a class="nava" href="officer_evaluation.php">Officer Evaluation</a></li>
            <li><a class="nava" href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <h2>Your Complaints</h2>

    <div class="container">
        <?php
        include("./auth/userauth.php");
        $conn = mysqli_connect("localhost", "root", "", "complainreg");
        if (!$conn) {
            echo "DB not connected";
            exit();
        }

        $name = $_SESSION['name'];

        // Fetch complaints along with officer names
        $sql = "
            SELECT c.*, o.name AS name 
            FROM complaints c 
            LEFT JOIN officer o ON c.officerid = o.officerid 
            WHERE c.name='$name'
        ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['complaint_id'];
                $officer = $row['name'];
                echo "<div class='cbox'>";
                echo "<div class='complaint-box'>";
                echo "<h3>Complaint ID: " . htmlspecialchars($row['complaint_id']) . "</h3>";
                echo "<p><strong>Type:</strong> " . htmlspecialchars($row['complaint_type']) . "</p>";
                echo "<p><strong>Date:</strong> " . htmlspecialchars($row['date']) . "</p>";
                echo "<p><strong>Details:</strong> " . htmlspecialchars($row['complaint_detail']) . "</p>";
                echo "<p><strong>Suspect Name:</strong> " . htmlspecialchars($row['suspect_name']) . "</p>";
                echo "<p><strong>Officer Name:</strong> " . htmlspecialchars($row['name']) . "</p>"; // Officer's name
                echo "<p><strong>Status:</strong> " . htmlspecialchars($row['status']) . "</p>";

                // Action buttons
                echo "<div class='action-buttons'>";
                echo "<form action='userchat.php' method='post' style='display:inline;'>
                        <input type='hidden' name='complaint_id' value='" . $officer . "'>
                        <button type='submit' name='userChat' class='chat-button'>Chat</button>
                      </form>";
                echo "<form action='request_officer_change.php' method='post' style='display:inline;'>
                        <input type='hidden' name='complaint_id' value='" . $id . "'>
                        <input type='hidden' name='officer_id' value='" . htmlspecialchars($row['officerid']) . "'>
                        <button type='submit' name='requestChange' class='request-button'>Request Officer Change</button>
                      </form>";
                echo "</div>"; // Close action-buttons
                echo "</div>"; // Close complaint-box
                echo "</div>"; // Close cbox
            }
        } else {
            echo "<p>No records found.</p>";
        }

        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
