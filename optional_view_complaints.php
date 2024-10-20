<?php
// view_complaints.php

include("./auth/adminauth.php"); // Ensure the user is authenticated
$conn = mysqli_connect("localhost", "root", "", "complainreg");

if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}

// Get the complaint type from the URL
$complaint_type = isset($_GET['type']) ? $_GET['type'] : '';

// Prepare and execute a query to fetch complaints based on the type
$sql = "SELECT * FROM complaints WHERE complaint_type = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 's', $complaint_type);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints: <?php echo ucfirst(str_replace('_', ' ', $complaint_type)); ?></title>
    <link rel="stylesheet" href="admindashboardd.css">
</head>
<body>
    <nav class="navbar">
        <img src="Assets/logowomen.png" alt="Logo" class="logoo">
        <ul class="navuladmin">
            <li><a class="nava" href="admindashboard.php">Home</a></li>
            <li><a class="nava" href="view_complaint.php">View Complaint</a></li>
            <li><a class="nava" href="officer_evaluation.php">Officer Evaluation</a></li>
            <li><a class="nava" href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <h1>Complaints: <?php echo ucfirst(str_replace('_', ' ', $complaint_type)); ?></h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Complaint Detail</th>
            <th>Photo</th>
            <th>Suspect Name</th>
            <th>Details</th>
            <th>Officer ID</th>
            <th>Status</th>
            <th>Voice Recording</th>
            <th>Action</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['complaint_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['complaint_detail']) . "</td>";
                echo "<td><img src='./assets/" . htmlspecialchars($row['photo']) . "' alt='Complaint Photo' style='max-width:100px;'></td>";
                echo "<td>" . htmlspecialchars($row['suspect_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['details']) . "</td>";
                echo "<td>" . htmlspecialchars($row['officerid']) . "</td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "<td>
                        <audio controls>
                            <source src='" . htmlspecialchars($row['voice']) . "' type='audio/mp3'>
                            Your browser does not support the audio element.
                        </audio>
                      </td>";
   
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No complaints found for this type.</td></tr>";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        ?>
    </table>
</body>
</html>
