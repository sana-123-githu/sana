<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="userchat.css">
    <title>Chat with Officer</title>
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

<!-- Chat container -->
<div class="chat-container">

    <?php
    include('./auth/userauth.php'); // Include user authentication
    $conn = mysqli_connect("localhost", "root", "", "complainreg");

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    if (isset($_POST['userChat'])) {
        $name = $_SESSION['name']; // User's name

        // Fetch user details
        $userSql = "SELECT * FROM `users` WHERE `name` ='$name'";
        $userResult = mysqli_query($conn, $userSql);
        $userValue = mysqli_fetch_assoc($userResult);
        
        $senderId = $userValue['usid'];

        $complaintid = "SELECT * FROM `complaints` WHERE `name` ='$name'";
        $complaintresult = mysqli_query($conn, $complaintid);
        $complaintvalue = mysqli_fetch_assoc($complaintresult);

        $cid = $complaintvalue['complaint_id'];

        // Display officer's name before the messages

        // Insert message into the messages table
        if (isset($_POST['message']) && $_POST['message'] != "") {
            $message = $_POST['message'];
            $timestamp = date("Y-m-d H:i:s"); // Get current timestamp
            
            // Basic SQL insertion without prepared statements for simplicity
            $insertSql = "INSERT INTO `messages` (`message`, `senderid`, `complaintid`, `timestamp`) VALUES ('$message', '$senderId', '$cid', '$timestamp')";
            
            if (mysqli_query($conn, $insertSql)) {
                echo "Message sent successfully.<br>";
            } else {
                echo "Error: " . mysqli_error($conn) . "<br>";
            }
        }

        // Fetch all messages between the user and the officer for display
        $fetchMessagesSql = "SELECT * FROM `messages` WHERE `complaintid` = '$cid'";
        $messagesResult = mysqli_query($conn, $fetchMessagesSql);

        echo "<h2>Chat Messages:</h2>";
    while ($messageRow = mysqli_fetch_assoc($messagesResult)) {
        if ($messageRow['senderid'] == $senderId) {
            echo "<div class='message' style='background-color: lightblue; padding: 10px; margin-bottom: 10px; border-radius: 5px;'><strong>" . $messageRow['message'] . " <em>(" . $messageRow['timestamp'] . ")</em></strong></div>";
        } else {
            echo "<div class='message' style='padding: 10px; margin-bottom: 10px; border-radius: 5px;'><strong>" . $messageRow['message'] . " <em>(" . $messageRow['timestamp'] . ")</em></strong></div>";
        }
    }
    }

    mysqli_close($conn);
    ?>
        <form method="POST">
        <input type="text" name="message" placeholder="Type your message here..." required>
        <input type="hidden" name="userChat" value="1"> <!-- Ensures the if condition is met -->
        <input type="hidden" name="complaint_id" value="<?php echo $officer; ?>"> <!-- Officer ID -->
        <button type="submit">Send Message</button>
    </form>
</div> <!-- End of chat container -->

</body>
</html>
