<?php
require 'base.php';
header("Content-Type: application/json");
if(isset($_GET["destination"]) && !empty($_GET["destination"])) {
    $location = $_GET["destination"];

    $sql = "SELECT *
            FROM Available_Rides JOIN User
            WHERE destination = :destination and driver_email = User.email;";
    $st = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $st->execute(array(':destination' => $location));
    $rides = $st->fetchAll();
    deliver_response(200, "Success", $rides);
} else {
    deliver_response(400, "Invalid request", null);
}

function deliver_response($status, $status_message, $dataarray) {
    //contains status message and actual data
    header("HTTP/1.1 $status $status_message");
    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['rides'] = $dataarray;

    $json_response = json_encode($response);
    echo $json_response;
}

?>