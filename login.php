<?php
session_start(); // initiate session
$pagename = "Sign Up"; // change page name
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>" . $pagename . "</title>"; //display name of the page as window title
echo "<body>";
include ("headfile.html"); //include header layout file 
echo "<h4>" . $pagename . "</h4>"; //display name of the page on the web page

// Display login form
echo "<form action='login_process.php' method='post'>";
echo "<table>";
echo "<tr><td>Email:</td><td><input type='text' name='email'></td></tr>";
echo "<tr><td>Password:</td><td><input type='password' name='password'></td></tr>";
echo "<tr><td colspan='2' align='center'><input type='submit' value='Login'></td></tr>";
echo "</table>";
echo "</form>";

include ("footfile.html"); //include head layout
echo "</body>";
?>