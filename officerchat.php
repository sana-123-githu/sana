<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="userchat.css">
    <title>Chat with User</title>
</head>
<body>
<nav class="navbar">
    <img src="Assets/logowomen.png" alt="" class="logoo">
    <ul class="navuladmin">
        <li><a class="nava" href="officerdashboard.php">Home</a></li>
        <li><a class="nava" href="view_complaints.php">View Complaints</a></li>
        <li><a class="nava" href="officer_evaluation.php">Evaluation</a></li>
        <li><a class="nava" href="logout.php">Logout</a></li>
    </ul>
</nav>

<!-- Chat container -->
<div class="chat-container">


    <?php
    include('./auth/staffauth.php'); // Include user authentication
    $conn = mysqli_connect("localhost", "root", "", "complainreg");

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    if (isset($_POST['officerChat'])) {
        $id = $_POST['officerChat'];
        $senderId=$_SESSION['officerid'];
  

        // $complaintid="SELECT * FROM `complaints` WHERE officerid='$senderId'";
        // $complaintresult=mysqli_query($conn,$complaintid);
        // $complaintrow=mysqli_fetch_assoc($complaintresult);
        // $cid=$complaintrow['complaint_id'];


        if (isset($_POST['message']) && $_POST['message'] != "") {
            $message = $_POST['message'];
            $timestamp = date("Y-m-d H:i:s"); // Get current timestamp
            
            // Basic SQL insertion without prepared statements for simplicity
            $insertSql = "INSERT INTO `messages` (`message`, `senderid`, `timestamp`,`complaintid`) VALUES ('$message', '$senderId', '$timestamp','$id')";
            
            if (mysqli_query($conn, $insertSql)) {

                } else {
                echo "Error: " . mysqli_error($conn) . "<br>";
            }
        }

        // Fetch all messages between the user and the officer for display
        $fetchMessagesSql = "SELECT * FROM `messages` WHERE `complaintid` ='$id'";
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
        <input type="hidden" name="officerChat" value="1"> <!-- Ensures the if condition is met -->
        <button type="submit">Send Message</button>
    </form>
</div> <!-- End of chat container -->

</body>
</html>
