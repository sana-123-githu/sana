<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Officer Dashboard</title>
    <link rel="stylesheet" href="officercomplaintsmanagement.css">
    <style>
     * {
    margin: 0;
    padding: 0;
    box-sizing: border-box; /* Added for consistent box sizing */
    font-family: 'Roboto', sans-serif;
}

.navbar {
    width: 100%;
    background-color: #333;
    color: rgb(221, 212, 212);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 45px; /* Added padding for better spacing */
}

.navbar ul {
    display: flex;
    align-items: center; /* Center items vertically */
}

.navbar ul li {
    list-style: none;
    margin: 0 20px;
    position: relative;
}

.navbar ul li a {
    text-decoration: none;
    color: rgb(221, 212, 212);
    letter-spacing: 1px; /* Reduced letter spacing for better readability */
    font-weight: bold;
    font-size: 14px; /* Increased font size slightly */
    transition: color 0.3s; /* Added transition for hover effect */
}

.navbar ul li:hover a {
    color: #fff; /* Change text color on hover */
}

.navbar ul li::after {
    content: '';
    height: 3px;
    width: 0;
    background: black;
    position: absolute;
    left: 0;
    bottom: -10px;
    transition: 0.5s;
}

.navbar ul li:hover::after {
    width: 100%;
}

.logo {
    width: 125px;
    cursor: pointer;
}


.complaint-box {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 10px 0; /* Space between boxes */
            padding: 15px;
            box-shadow: 0 2px 10px 5px rgba(0, 0, 0, 0.1);
            width: 40%;
            height:400px;
            display: flex;
    align-items: flex-start;
    justify-content: space-evenly;
    flex-direction: column;
        }

        .complaint-box h3 {
            margin-top: 0;
        }

        .complaint-box img {
            max-width: 100px;
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
            background-color: #9b0d88; /* Green */
            color: white;
        }

        button:hover {
            background-color: #9b0d88;
        }

        .container {
            margin-top: 20px;
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
    <div class="navbar">
        <img src="Assets/logowomen.png" alt="" class="logo">
        <ul>
            <li><a href="officerdashboard.php">HOME</a></li>
            <li><a href="officercomplaintmanagement.php">COMPLAINT MANAGEMENT</a></li>
            <li><a href="logout.php">LOGOUT</a></li>
        </ul>
    </div>

    <h2>Assigned Complaints</h2>

    <div class="container">
        <?php
        include("./auth/staffauth.php");
        $conn = mysqli_connect("localhost", "root", "", "complainreg");
        if (!$conn) {
            echo "DB not connected";
            exit();
        }

        $ofid = $_SESSION['officerid'];
        $sql = "SELECT * FROM complaints WHERE `officerid`='$ofid'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['complaint_id'];
                $ofid = $row['officerid'];
                $rcemail = $row['email'];
                echo "<div class='cbox'>";
                echo "<div class='complaint-box'>";
                echo "<h3>Complaint ID: " . htmlspecialchars($row['complaint_id']) . "</h3>";
                echo "<p><strong>Type:</strong> " . htmlspecialchars($row['complaint_type']) . "</p>";
                echo "<p><strong>user email:</strong> " . htmlspecialchars($row['email']) . "</p>";
                echo "<p><strong>Date:</strong> " . htmlspecialchars($row['date']) . "</p>";
                echo "<p><strong>Details:</strong> " . htmlspecialchars($row['complaint_detail']) . "</p>";
                echo "<p><strong>Suspect Name:</strong> " . htmlspecialchars($row['suspect_name']) . "</p>";
                echo "<img src='./assets/" . htmlspecialchars($row['photo']) . "' alt='Complaint Photo'>";
                echo "<p><strong>Status:</strong> " . htmlspecialchars($row['status']) . "</p>";

                // Update Status Form
                echo "<div class='action-buttons'>
                        <form action='' method='post' style='display:inline;'>
                            <input type='text' name='status' value='" . htmlspecialchars($row['status']) . "' required>
                            <input type='hidden' name='complaint_id' value='" . $id . "'>
                            <button type='submit' name='updatestatus'>Update</button>
                        </form>
                      </div>";

                // Chat Form
                echo "<div class='action-buttons'>
                  <form action='officerchat.php' method='post' style='display:inline;'>
    <input type='hidden' name='complaint_id' value='<?php echo $id; ?>'> <!-- Use PHP to echo the value -->
    <button type='submit' name='officerChat' value='{$id}' class='chat-button'>Chat</button>
</form>

                      </div>";

                echo "</div>"; // Close complaint-box
                echo "</div>"; // Close complaint-box
            }
        } else {
            echo "<p>No records found.</p>";
        }

        mysqli_close($conn);
        ?>
    </div>

    <?php
    if (isset($_POST['updatestatus'])) {
        $id = $_POST['complaint_id'];
        $new_status = $_POST['status'];

        $conn = mysqli_connect("localhost", "root", "", "complainreg");
        $sql = "UPDATE complaints SET status='$new_status' WHERE complaint_id='$id'";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Status updated successfully');</script>";
            header('Location: officercomplaintmanagement.php');
            exit();
        } else {
            echo "<script>alert('Error updating status');</script>";
        }

        mysqli_close($conn);
    }
    ?>
</body>

</html>
