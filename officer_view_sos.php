<?php
include("./auth/staffauth.php"); // Ensure the officer is authenticated

// Database connection
$conn = new mysqli("localhost", "root", "", "complainreg");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$officer_id = $_SESSION['officerid']; // Adjust based on your session management

$emails_result = $conn->query("SELECT DISTINCT email FROM complaints WHERE officerid = '$officer_id'");
$emails = [];

if ($emails_result->num_rows > 0) {
    while ($row = $emails_result->fetch_assoc()) {
        $emails[] = $row['email'];
    }
}



$sos_alerts = [];
if (!empty($emails)) {
    $emails_string = "'" . implode("','", $emails) . "'"; // Prepare for SQL IN clause
    
    // Fetch user IDs using emails from the users table and get SOS alerts
    $sos_sql = "
        SELECT l.*, u.usid AS user_id 
        FROM locations l 
        JOIN users u ON l.userid = u.usid 
        WHERE u.email IN ($emails_string) 
    ";
    $sos_alerts = $conn->query($sos_sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOS Alerts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        
        nav {
            margin-bottom: 20px;
        }

        nav a {
            margin-right: 15px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        h1 {
            color: #333;
        }

        .box-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px; /* Space between boxes */
            margin-top: 20px;
        }

        .alert-box {
            width: 300px; /* Set width of each box */
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 15px;
            border: 1px solid #ddd;
            transition: transform 0.2s;
        }

        .alert-box:hover {
            transform: scale(1.02); /* Slight scale on hover */
        }

        .alert-box p {
            margin: 5px 0;
        }

        p {
            color: #666;
            text-align: center; /* Center-aligns the no alerts message */
        }
    </style>
</head>
<body>
<nav>
    <a href="officerdashboard.php">Home</a>
    <a href="officer_view_sos.php">View SOS Alerts</a>
    <a href="logout.php">Logout</a>
</nav>

<h1>SOS Alerts</h1>

<div class="box-container">
    <?php if ($sos_alerts && $sos_alerts->num_rows > 0): ?>
        <?php while ($row = $sos_alerts->fetch_assoc()): ?>
            <div class="alert-box">
                <p><strong>Alert ID:</strong> <?php echo $row['id']; ?></p>
                <p><strong>User ID:</strong> <?php echo $row['userid']; ?></p>
                <p><strong>Latitude:</strong> <?php echo $row['latitude']; ?></p>
                <p><strong>Longitude:</strong> <?php echo $row['longitude']; ?></p>
                <p><strong>Timestamp:</strong> <?php echo $row['created_at']; ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No SOS alerts found for your users.</p>
    <?php endif; ?>
</div>

<?php $conn->close(); ?>
</body>
</html>
