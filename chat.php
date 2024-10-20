<?php
session_start(); 

if (!isset($_GET['complaint_id'])) {
    die("No complaint selected.");
}
$complaint_id = $_GET['complaint_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        .chatbox {
            border: 1px solid #ddd;
            padding: 10px;
            max-width: 600px;
            margin: 20px auto;
            background-color: #f9f9f9;
        }
        .chat-messages {
            height: 300px;
            overflow-y: scroll;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: white;
        }
        .user-message {
            text-align: left;
            background-color: #d1f0ff;
            padding: 5px;
            margin: 5px 0;
            border-radius: 5px;
        }
        .officer-message {
            text-align: right;
            background-color: #ffe4b5;
            padding: 5px;
            margin: 5px 0;
            border-radius: 5px;
        }
        .timestamp {
            display: block;
            font-size: 0.8em;
            color: gray;
        }
    </style>
</head>
<body>

<div class="chatbox">
    <?php include 'get_messages.php'; ?>

    <form action="send_message.php" method="post">
        <input type="hidden" name="complaint_id" value="<?php echo $complaint_id; ?>">
        <input type="hidden" name="sender_type" value="<?php echo $_SESSION['userType']; ?>"> 
        <input type="hidden" name="sender_id" value="<?php echo $_SESSION['userid']; ?>"> 
        
        <textarea name="message" placeholder="Type your message..." required></textarea>
        <button type="submit" name="sendMessage">Send</button>
    </form>
</div>

</body>
</html>
