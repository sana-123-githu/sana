<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Watch Store</title>
    <link rel="stylesheet" href="profile.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
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

        <h2>Profile</h2>
    <form action="process_profile_update.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['usid']); ?>">
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>
        <input type="hidden" id="email" name="oldemail" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phno']); ?>" required><br><br>

        <label for="phone">Password::</label>
        <input type="text" id="phone" name="pass" value="<?php echo htmlspecialchars($user['password']); ?>" required><br><br>

        <button type="submit">Update Profile</button>
    </form>
</body>
</html>
