<?php
// require('Connection.php');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

$servername = "gopool.cklcxx7fvgfc.us-west-2.rds.amazonaws.com:3306";
$username = "gopool_master";
$password = "saltyswoleman18";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$db_selected = mysqli_select_db($conn,'gopooldb');


$result = mysqli_query($conn, "SELECT * FROM test");

if (!$result) {
    $message  = 'Invalid query: ' . mysqli_error($conn) . "\n";
    $message .= 'Whole query: ' . $result;
    die($message);
}

// //fetch tha data from the database
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
   echo "Test ID: ".$row['test_id'];
}

?>