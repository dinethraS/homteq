<?php
session_start();
include("db.php"); //include db.php file to connect to DB
$pagename = "Smart Basket"; //Create and populate a variable called $pagename
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>" . $pagename . "</title>"; //display name of the page as window title
echo "<body>";
include("headfile.html"); //include header layout file 
include("detectlogin.php"); //include detectlogin script
echo "<h4>" . $pagename . "</h4>"; //display name of the page on the web page

$total = 0;

// Check if the posted ID of the product to be removed is set
if (isset($_POST['h_delprodid'])) {
    // Capture the posted product id to be removed
    $delprodid = $_POST['h_delprodid'];
    // Unset the cell of the session for the posted product id
    unset($_SESSION['basket'][$delprodid]);
    // Display "1 item removed from the basket" message
    echo "<p>1 item removed from the basket</p>";
}

// Check if the posted ID of the new product is set
if (isset($_POST['h_prodid']) && isset($_POST['p_quantity'])) {
    // Capture the ID of selected product
    $newprodid = $_POST['h_prodid'];
    // Capture the required quantity of selected product
    $reququantity = $_POST['p_quantity'];

    // Create a new cell in the basket session array. Index this cell with the new product id.
    // Inside the cell store the required product quantity
    $_SESSION['basket'][$newprodid] = $reququantity;

    // Display "1 item added to the basket" message
    echo "<p>1 item added to the basket</p>";
}

echo "<h2>Your Shopping Basket</h2>";

// Check if the basket session array is set and is not empty
if (isset($_SESSION['basket']) && count($_SESSION['basket']) > 0) {
    // Start of the HTML table for the shopping basket items
    echo "<form action='basket.php' method='post'>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Remove</th>
          </tr>";

    // Loop through the basket session array
    foreach ($_SESSION['basket'] as $index => $value) {
        // SQL query to retrieve from Product table details of selected product for which id matches $index
        $sql = "SELECT prodName, prodPrice FROM Product WHERE prodId = '$index'";
        // Execute query
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn)); // added the " or die(mysqli_error($conn)) " incase of bug remove!!
        // Fetch the product details
        if ($arrayp = mysqli_fetch_array($result)) {
            // Create a new HTML table row
            echo "<tr>";
            // Display product name
            echo "<td>" . $arrayp['prodName'] . "</td>";
            // Display product price
            echo "<td>" . $arrayp['prodPrice'] . "</td>";
            // Display selected quantity of product
            echo "<td>" . $value . "</td>";
            // Calculate subtotal, store it in a local variable $subtotal and display it
            $subtotal = $arrayp['prodPrice'] * $value;
            echo "<td>" . $subtotal . "</td>";
            // Increase total by adding the subtotal to the current total
            $total += $subtotal;
            // Add a form with a hidden input for product id to be removed and a Remove button
            echo "<td>
                    <form action='basket.php' method='post'>
                        <input type='hidden' name='h_delprodid' value='$index'>
                        <input type='submit' value='Remove'>
                    </form>
                  </td>";
            echo "</tr>";
        }
    }
    // Display total
    echo "<tr>
            <th colspan='3'>Total</th>
            <th>" . $total . "</th>
            <th></th>
          </tr>";
    echo "</table>";
    echo "</form>";
} else {
    // Display empty basket message
    echo "<p>Your basket is empty.</p>";
}
echo "<br>";
echo "<p><a href='clearbasket.php'>Clear Basket</a></p>";
echo "<p>New homteq customers: <a href='signup.php'>Sign up</a></p>";
echo "<p>returning homteq customers: <a href='login.php'>Log in</a></P>";
// Continue with the rest of the page (e.g., include footfile.html)
include("footfile.html"); //include head layout
echo "</body>";
?>
