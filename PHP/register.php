<?php
require 'base.php';
header("Content-Type: application/json");
if (!empty($_GET["first_name"]) && !empty($_GET["last_name"]) && !empty($_GET["email"]) && !empty($_GET["password"])
    && !empty($_GET["university"]) && !empty($_GET["major"])) {
    $first_name = $_GET['first_name'];
    $last_name = $_GET['last_name'];
    $email = $_GET['email'];
    $password = $_GET['password'];
    $university = $_GET['university'];
    $major = $_GET['major'];


    $sql = "INSERT INTO User (first_name, last_name, email, password, university, major)
        VALUES (:first_name, :last_name, :email, :password, :university,
        :major);";
    $st = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    try {
        $st->execute(array(':first_name' => $first_name, ':last_name' => $last_name, ':email' => $email, ':password' => $password,
            ':university' => $university, ':major' => $major));
    } catch (PDOException $e) {
        deliver_response(400, $e->getMessage());
    }
    if($st->rowCount() != 0) {
        deliver_response(200, "Success");
    }
} else {
    deliver_response(400, "Missing a parameter");
}

function deliver_response($status, $status_message) {
    //contains status message and actual data
    header("HTTP/1.1 $status $status_message");
    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $json_response = json_encode($response);
    echo $json_response;
}

?>