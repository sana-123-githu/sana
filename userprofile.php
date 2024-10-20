<?php
include("./auth/userauth.php");

// Database connection
$conn = mysqli_connect("localhost", "root", "", "complainreg");
if (!$conn) {
    die("DB not connected");
}

// Fetch user details
$name = $_SESSION['name'];
$sql = "SELECT * FROM users WHERE name='$name'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="admindashboardd.css">
    <link rel="stylesheet" href="assignofficerss.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(88, 88, 245, 0.203);
            padding: 20px;
        }

        .profile-box {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 10px 5px rgba(0, 0, 0, 0.1);
            width: 40%;
            height:300px;
            margin: auto;
            margin-top:170px;
            display: flex;
    align-items: flex-start;
    justify-content: space-evenly;
    flex-direction: column;
        }

        .profile-box h2 {
            margin-top: 0;
        }

        .profile-box p {
            margin: 5px 0;
        }

        button {
            margin-top: 10px;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #aa549f; /* Green */
            color: white;
        }

        button:hover {
            background-color: #aa549f;
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

    <div class="profile-box">
        <h2>User Profile</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phno']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
        
        <form action="edit_profile.php" method="get">
            <button type="submit">Edit Profile</button>
        </form>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
