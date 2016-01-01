<?php  
	header("Content-Tyoe: application/json");

	if(!empty($_GET['user']) && !empty($_GET['pass'])) {
		$arrvar = get_profile($_GET['user'], $_GET['pass']);
		if(empty($arrvar)) {
			//user not found
			deliver_response(200, "User not found", NULL);
		} else {
			//respond with user info
			deliver_response(200, "User found", $arrvar);
		}
	} else {
		//invalid request
		deliver_response(400, "Invalid request", NULL);
	}
	
	function get_profile($user, $pass) {
		
		$profiles = array(
			array("user","pass","Goon","Georgia Tech","CS"),
			array("user1","pass1","Hoe","Georgia Tech","BME"),
			array("user1","pass1","Hoe","UMD","BME"),
			array("user2","pass2","Trifla","Georgia Tech","ME"),
			array("user3","pass3","Nig","Georgia Tech","Business")	
		);
		
		$userandpass = $user.$pass;
		$ret = array();
		for($x = 0; $x < count($profiles); $x++) {
			if($profiles[$x][0].$profiles[$x][1] == $userandpass) {
				$temp = array($profiles[$x][2],$profiles[$x][3],$profiles[$x][4]);
				array_push($ret, $temp); //push actual profile
			}	
		}
		return $ret;
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