<?php
session_start();
include("db.php");
mysqli_report(MYSQLI_REPORT_OFF);

$pagename = "Sign Up Results";
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";
echo "<title>" . $pagename . "</title>";
echo "<body>";
include("headfile.html");
echo "<h4>" . $pagename . "</h4>";

$fname = trim($_POST['r_firstname']);
$lname = trim($_POST['r_lastname']);
$address = trim($_POST['r_address']);
$postcode = trim($_POST['r_postcode']);
$telno = trim($_POST['r_telno']);
$email = trim($_POST['r_email']);
$password1 = trim($_POST['r_password1']);
$password2 = trim($_POST['r_password2']);

if (!empty($fname) && !empty($lname) && !empty($address) && !empty($postcode) && !empty($telno) && !empty($email) && !empty($password1) && !empty($password2)) {
    if ($password1 != $password2) {
        echo "Error: Passwords do not match.<br>";
        echo "<a href='signup.php'>Go back to sign up page</a>";
    } else {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $regexp = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/";
            if (preg_match($regexp, $email)) {
                $SQL = "INSERT INTO Users (userType, userFName, userSName, userAddress, userPostCode, userTelNo, userEmail, userPassword)
                VALUES ('C','$fname','$lname','$address','$postcode','$telno','$email','$password1')";
                if (mysqli_query($conn, $SQL)) {
                    echo "Sign up successful!<br>";
                    echo "<a href='login.php'>Click here to login</a>";
                } else {
                    $errno = mysqli_errno($conn);
                    if ($errno == 1062) {
                        echo "Error: Email address already taken.<br>";
                    } elseif ($errno == 1064) {
                        echo "Error: Invalid characters entered.<br>";
                    } else {
                        echo "Error: " . mysqli_error($conn) . "<br>";
                    }
                    echo "<a href='signup.php'>Go back to sign up page</a>";
                }
            } else {
                echo "Error: Email not in the right format.<br>";
                echo "<a href='signup.php'>Go back to sign up page</a>";
            }
        } else {
            echo "Error: Email not in the right format.<br>";
            echo "<a href='signup.php'>Go back to sign up page</a>";
        }
    }
} else {
    echo "Error: All mandatory fields need to be filled in.<br>";
    echo "<a href='signup.php'>Go back to sign up page</a>";
}

include("footfile.html");
echo "</body>";
?>
