<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>officer management</title>
    <link rel="stylesheet" href="addofficerss.css">
    <link rel="stylesheet" href="admindashboardd.css">
    
</head>
    <body>
    <nav class="navbar">
         <img src="Assets/logowomen.png" alt="" class="logoo">
                <ul class="navuladmin">
                <li><a class="nava" href="admindashboard.php">Home</a></li>
                    <li class="dropdown">
                        <a href="#" class="nava">Complaint Management</a>
                        <div class="dropdown-content">
                            <a href="view_complaints.php">View Complaint</a>
                            <a href="review_requests.php">View Requests</a>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="nava">Officer Management</a>
                        <div class="dropdown-content">
                            <a href="addofficer.php">Add Officer</a>
                            <a href="updateofficer.php">Update Officer</a>
                            <a href="admin_view_officer_reviews.php">View Review</a>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="nava">User Management</a>
                        <div class="dropdown-content">
                            <a href="deleteuser.php">Delete user</a>
                        </div>
                    </li>
                    <li><a class="nava" href="login.php">Logout</a></li>
                    
                </ul>
         </nav>
        <div class="officermanagementcontainer">
        <form class="officermanagementform" method="post" action="">
            <h2>Add officer</h2>
            <input class="officerregname" type="text" name="officername" placeholder="Name">
            <input  class="officerregname" type="number" name="officernum" placeholder="Mobile number">
            <input  class="officerregname" type="email" name="officeremail" placeholder="Email">
            <input  class="officerregname" type="date" name="officerdob" placeholder="Date of birth">
            <input class="officerregname" type="text" name="officerpos" placeholder="position">
            <input  class="officerregname" type="password" name="officerpassword" placeholder="Password">
            <input class="officerregister" type="submit" name="officerregister" value="Register">
        </form>

        </div>
    </body>
</html>  
<?php
include("./auth/adminauth.php");
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "complainreg"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed");
}

if (isset($_POST['officerregister'])) {  
    $name = $_POST['officername'];
    $dob = $_POST['officerdob'];
    $position = $_POST['officerpos'];
    $phonenum = $_POST['officernum'];
    $passwordoff = $_POST['officerpassword'];
    $email = $_POST['officeremail'];
    $type=1;

    
    $sql_officeradd = "INSERT INTO `officer`(`name`, `dob`, `position`, `phonenum`, `passwordoff`, `email`) VALUES ('$name','$dob','$position','$phonenum','$passwordoff','$email')";
    $officer_add = mysqli_query($conn, $sql_officeradd);

    $sql_officerlog = "INSERT INTO `login`(`email`, `password`, `usertype`) VALUES ('$email','$passwordoff','$type')";
    $officer_log = mysqli_query($conn, $sql_officerlog);

    if($officer_add){
        echo "<script>alert('officer Registered Successfully.')</script>";
    }
}

$conn->close();
?>



