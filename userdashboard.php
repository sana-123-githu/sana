<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="userdashboard.css">
</head>
<body>
<div class="container">
    <div class="navbar">
        <img src="Assets/logowomen.png" alt="" class="logo">
        <ul>    
            <li><a class="nava" href="userdashboard.php">HOME</a></li>
            <li><a class="nava" href="view_complaint.php">VIEW COMPLAINT</a></li>
            <li><a class="nava" href="officer_evaluation.php">OFFICER EVALUATION</a></li>
            <li><a class="nava" href="logout.php">LOGOUT</a></li>
        </ul>
    </div>
    
    <div class="contain">
        <h1>User Dashboard</h1>
        <p>Click here to edit your profile!</p>
        
        <a href="userprofile.php">
            <button type="button">Profile</button>
        </a>    
          
    </div>
</div>

<?php
include("./auth/userauth.php");
$userid = $_SESSION['userid']; 
echo "<script>var userid = " . json_encode($userid) . ";</script>";
?>

<script>
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(sendLocation, handleError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function sendLocation(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    console.log("Latitude: " + latitude); // Log latitude
    console.log("Longitude: " + longitude); // Log longitude
    console.log("User ID: " + userid); // Log user ID

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./save_location.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                alert("Location sent successfully!");
            } else {
                alert("Error sending location.");
            }
        }
    };
    xhr.send("latitude=" + latitude + "&longitude=" + longitude + "&userid=" + userid);
}

function handleError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}
</script>

</body>
</html>
