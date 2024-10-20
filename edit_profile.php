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

$old_email = $user['email']; // Store old email for the update query

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update user details
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $new_address = mysqli_real_escape_string($conn, $_POST['address']);

    // Update users table
    $update_users_sql = "UPDATE users SET email='$new_email', phno='$new_phone', address='$new_address' WHERE name='$name'";
    
    // Update login table using old email
    $update_login_sql = "UPDATE login SET email='$new_email' WHERE email='$old_email'";

    // Execute both updates in a transaction
    mysqli_begin_transaction($conn);
    try {
        mysqli_query($conn, $update_users_sql);
        mysqli_query($conn, $update_login_sql);
        mysqli_commit($conn);
        echo "<script>alert('Profile updated successfully'); window.location.href='userprofile.php';</script>";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Error updating profile: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="admindashboardd.css">
    <link rel="stylesheet" href="assignofficerss.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(88, 88, 245, 0.203);
            padding: 20px;
        }

        .edit-profile-box {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 10px 5px rgba(0, 0, 0, 0.1);
            width: 40%;
            margin: auto;
            height:300px;
            margin: auto;
            margin-top:170px;
            display: flex;
    align-items: flex-start;
    justify-content: space-evenly;
    flex-direction: column;
        }

        .edit-profile-box h2 {
            margin-top: 0;
        }

        .edit-profile-box input {
            width: 98%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #aa549f; /* Green */
            color: white;
        }

        button:hover {
            background-color: #45a049;
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

    <div class="edit-profile-box">
        <h2>Edit Profile</h2>
        <form method="POST" action="">
            <input type="text" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <input type="text" name="phone" placeholder="Phone" value="<?php echo htmlspecialchars($user['phno']); ?>" required>
            <input type="text" name="address" placeholder="Address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
