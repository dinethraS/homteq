<?php
session_start(); // initiate session
$pagename = "Your Login Results"; // change page name
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>" . $pagename . "</title>"; //display name of the page as window title
echo "<body>";
include("headfile.html"); //include header layout file 
echo "<h4>" . $pagename . "</h4>"; //display name of the page on the web page

// Connect to the database
include("db.php");

// Capture the values entered in the form
$email = $_POST['email'];
$password = $_POST['password'];

// Check if either email or password fields in the form are empty
if (empty($email) || empty($password)) {
    echo "<p><b>Login failed!</b></p>";
    echo "<p>Login form incomplete</p>";
    echo "<p>Make sure you provide all the required details</p>";
    echo "<p>Go back to <a href='login.php'>login</a></p>";
} else {
    // SQL query to retrieve the record from the users table for which the email matches login email
    $SQL = "SELECT * FROM Users WHERE userEmail = '" . $email . "'";
    // Execute SQL query
    $exeSQL = mysqli_query($conn, $SQL) or die (mysqli_error($conn));
    // Retrieve the number of records
    $nbrecs = mysqli_num_rows($exeSQL);
    
    // If no records found for the entered email
    if ($nbrecs == 0) {
        echo "<p><b>Login failed!</b></p>";
        echo "<p>Email not recognised</p>";
        echo "<p>Go back to <a href='login.php'>login</a></p>";
    } else {
        // Fetch user details
        $arrayuser = mysqli_fetch_array($exeSQL);
        
        // If the password retrieved from the database does not match the entered password
        if ($arrayuser['userPassword'] != $password) {
            echo "<p><b>Login failed!</b></p>";
            echo "<p>Password not valid</p>";
            echo "<p>Go back to <a href='login.php'>login</a></p>";
        } else {
            // Login successful
            echo "<p><b>Login success</b></p>";
            // Store user details in session variables
            $_SESSION['userid'] = $arrayuser['userId'];
            $_SESSION['fname'] = $arrayuser['userFName'];
            $_SESSION['sname'] = $arrayuser['userSName'];
            $_SESSION['usertype'] = $arrayuser['userType'];
            // Greet the user
            echo "<p>Welcome, " . $_SESSION['fname'] . " " . $_SESSION['sname'] . "</p>";
            // Display user type
            if ($_SESSION['usertype'] == 'C') {
                echo "<p>User Type: homteq Customer</p>";
            }
            if ($_SESSION['usertype'] == 'A') {
                echo "<p>User type: homteq Administrator</p>";
            }
            echo "<p>Continue shopping for <a href='index.php'>Home Tech</a></p>";
            echo "<p>View your <a href='basket.php'>Smart Basket</a></p>";
        }
    }
}

include("footfile.html"); //include head layout
echo "</body>";
?>
