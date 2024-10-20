<?php

$conn = mysqli_connect("localhost", "root", "", "complainreg");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['complaint_id'])) {
    die("No complaint selected.");
}

$complaint_id = $_GET['complaint_id'];

$sql = "SELECT * FROM messages WHERE complaint_id='$complaint_id' ORDER BY timestamp ASC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $messageClass = $row['sender_type'] === 'user' ? 'user-message' : 'officer-message';
        echo "<div class='$messageClass'>";
        echo "<strong>" . ucfirst($row['sender_type']) . ":</strong> ";
        echo htmlspecialchars($row['message']);
        echo "<span class='timestamp'>" . $row['timestamp'] . "</span>";
        echo "</div>";
    }
} else {
    echo "<div>No messages found.</div>";
}

mysqli_close($conn);
?>
