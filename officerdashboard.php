<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>officerdashboard</title>
    <link rel="stylesheet" href="officerdashboard.css">
</head>
<body>
    <div class="container">
        <div class="navbar">
            <img src="Assets/logowomen.png" alt="" class="logo">
                <ul>
                    <li><a href="officerdashboard.php">HOME</a></li>
                    <li><a href="officercomplaintmanagement.php">COMPLAINT MANAGEMENT</a></li>
                    <li><a href="officer_view_sos.php">View SOS Alert</a></li>
                    <li><a href="logout.php">LOGOUT</a></li>
                </ul>
               
        </div>
        <div class="contain">
        <h1>OFFICER DASHBOARD</h1>
              
        </div>          
    </div>    
</body>
</html>
<?php
include("./auth/staffauth.php");
?>