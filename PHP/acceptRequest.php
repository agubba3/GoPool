<?php
require 'base.php';
/**
 * Created by PhpStorm.
 * User: nikhilkulkarni
 * Date: 1/3/16
 * Time: 2:08 PM
 */
if (!empty($_GET["driverEmail"]) && !empty($_GET["riderEmail"])) {
    $driver_email = $_GET["driverEmail"];
    $rider_email = $_GET["riderEmail"];

    $sql = "UPDATE Current_Rides
            SET is_accepted = True
            WHERE rider_email = :rider_email and driver_email = :driver_email;";
    $st = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    try {
        $st->execute(array(':driver_email' => $driver_email, ':rider_email' => $rider_email));
    } catch (PDOException $e) {
        deliver_response(400, $e->getMessage());
    }
    if ($st->rowCount() != 0) {
        deliver_response(200, "Success");
    }
} else {
    deliver_response(400, "Invalid request");
}

function deliver_response($status, $status_message) {
    //contains status message and actual data
    $response['status'] = $status;
    $response['status_message'] = $status_message;

    $json_response = json_encode($response);
    echo $json_response;
}
?>