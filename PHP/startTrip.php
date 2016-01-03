<?php
require 'base.php';
/**
 * Created by PhpStorm.
 * User: nikhilkulkarni
 * Date: 1/3/16
 * Time: 1:56 PM
 */
if (!empty($_GET["email"])) {
    $driver_email = $_GET["email"];

    $sql = "DELETE
            FROM Available_Rides
            WHERE driver_email = :email;
            DELETE
            FROM Current_Rides
            WHERE driver_email = :email and is_accepted = false;";
    $st = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    try {
        $st->execute(array(':email' => $driver_email));
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