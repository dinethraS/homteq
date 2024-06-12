<?php
// Start the session
if(!isset($_SESSION)){
    session_start();
}
// Check if the user is logged in
if (isset($_SESSION['userid'])) {
    // If logged in, display the user's full name
    echo "<p>Welcome, " . $_SESSION['fname'] . " " . $_SESSION['sname'] . "</p>";
} else {
    // If not logged in, redirect to the login page or display a message
    // For example:
    // header("Location: login.php");
    // echo "Please log in to access this page.";
}
?>
