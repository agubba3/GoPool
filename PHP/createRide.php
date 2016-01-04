<?php
/**
 * Created by PhpStorm.
 * User: nikhilkulkarni
 * Date: 1/3/16
 * Time: 1:56 PM
 */
require 'base.php';

$parameters = array();
$body = file_get_contents('php://input');
$body_params = json_decode($body);
if ($body_params) {
    foreach ($body_params as $param_name => $param_value) {
        $parameters[$param_name] = $param_value;
    }
    $sql = "INSERT INTO Available_Rides
            VALUES (:destination, :origin, :email);";
    $st = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    try {
        $st->execute(array(':destination' => $parameters["destination"], ':email' => $parameters["email"], ':origin' => $parameters["origin"]));
    } catch (PDOException $e) {
        deliver_response(400, $e->getMessage());
    }
    if ($st->rowCount() != 0) {
        deliver_response(200, "Success");
    }
} else {
    deliver_response(400, "Invalid Request");
}

function deliver_response($status, $status_message) {
    //contains status message and actual data
    $response['status'] = $status;
    $response['status_message'] = $status_message;

    $json_response = json_encode($response);
    echo $json_response;
}
?>