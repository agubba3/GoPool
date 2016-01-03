<?php
require 'base.php';
	// require('Connection.php');
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	
	header("Content-Type: application/json");
	
	if(!empty($_GET['email']) && !empty($_GET['pass'])) {
		$arrvar = get_profile($_GET['email'], $_GET['pass']);
		if(empty($arrvar)) {
			//user not found
			deliver_response(400, "Invalid username or password", NULL);
		} else {
			//respond with user info
            $_SESSION["email"] = $_GET["email"];
			deliver_response(200, "User found", $arrvar);
		}
	} else {
		//invalid request
		deliver_response(400, "Invalid request", NULL);
	}

	function get_profile($email, $pass) {
		
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
			
		$result = mysqli_query($conn, "SELECT * FROM User WHERE email='$email' AND password='$pass'");
		
		if (!$result) {
			$message  = 'Invalid query: ' . mysqli_error($conn) . "\n";
			$message .= 'Whole query: ' . $result;
			die($message);
		}
		
		// //fetch tha data from the database
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$ret = array($row['first_name'], $row['last_name'], $row['email'], $row['university'], $row['major'], $row['vehicle_model'], $row['vehicle_color'], $row['vehicle_year'], $row['vehicle_image'], $row['vehicle_capacity'], $row['is_available']);
			return $ret;
		}
		
		return array();
			
		// for($x = 0; $x < count($profiles); $x++) {
		// 	if($profiles[$x][0].$profiles[$x][1] == $userandpass) {
		// 		$temp = array($profiles[$x][2],$profiles[$x][3],$profiles[$x][4]);
		// 		array_push($ret, $temp); //push actual profile
		// 	}	
		// }
		// return $ret;
	}
	
	function deliver_response($status, $status_message, $dataarray) {
		//contains status message and actual data
		header("HTTP/1.1 $status $status_message");
		$response['status'] = $status;
		$response['status_message'] = $status_message;
		$response['profile'] = $dataarray;
		
		$json_response = json_encode($response);
		echo $json_response; 
	}

 ?>