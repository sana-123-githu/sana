<?php
session_start(); 

// Assuming the user ID is stored in the session
$user_id = $_SESSION['userid']; // Ensure this is set during user authentication

$conn = new mysqli("localhost", "root", "", "complainreg");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $officer_id = intval($_POST['officer_id']);
    $review = $_POST['review'];
    
    // Insert review into the database, including user ID
    $sql = "INSERT INTO officer_reviews (officer_id, user_id, review) VALUES ('$officer_id', '$user_id', '$review')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Review submitted successfully.";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$officers = $conn->query("SELECT officerid, name FROM officer");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Officer Evaluation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        nav {
            background-color: #333;
            color: #fff;
            padding: 15px;
        }
        nav h1 {
            margin: 0;
        }
        nav ul {
            list-style: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 15px;
        }
        nav a {
            color: #fff;
            text-decoration: none;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }
        form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .message {
            text-align: center;
            margin: 20px;
            font-weight: bold;
            color: #5cb85c;
        }
    </style>
    <link rel="stylesheet" href="admindashboardd.css">
    <link rel="stylesheet" href="assignofficerss.css">
</head>
<body>
    <nav class="navbar">
    <img src="Assets/logowomen.png" alt="" class="logoo">
        <ul class="navuladmin">
            <li><a class="nava" href="userdashboard.php">Home</a></li>
            <li><a class="nava" href="view_complaint.php">View Complaint</a></li>
            <li><a class="nava" href="officer_evaluation.php">Officer evaluation</a></li>
            <li><a class="nava" href="logout.php">logout</a></li>
        </ul>
    </nav>

    <h2>Officer Evaluation</h2>
    <div class="message"><?php echo $message; ?></div>

    <form action="" method="POST">
        <label for="officer">Select Officer:</label>
        <select name="officer_id" required>
            <option value="">Select Officer</option>
            <?php while ($officer = $officers->fetch_assoc()): ?>
                <option value="<?php echo $officer['officerid']; ?>"><?php echo $officer['name']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="review">Your Review:</label>
        <textarea name="review" rows="5" required></textarea>

        <button type="submit">Submit Review</button>
    </form>

    <?php $conn->close(); ?>
</body>
</html>
