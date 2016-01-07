<?php
require 'base.php';
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    echo $email;
    $password = $_POST["password"];

    $lat = $_POST["lat"];
    echo $lat;
    $lng = $_POST["lng"];
    echo $lng;

    try {
        $sql = "SELECT * FROM User WHERE email= :email AND password= :password";
        $st = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $st->execute(array(':email' => $email, ':password' => $password));
        if ($st->rowCount()) {
            $rows = $st->fetchAll();
            $_SESSION["email"] = $email;
            header('Location: search.html?lat='.$lat.'&lng='.$lng);
        } else {
            print "Invalid username and/or password";
        }
    } catch (PDOException $e) {
        print $e;
    }
}
else if (isset($_POST["r_email"]) && isset($_POST["r_password"]) && isset($_POST["university"]) && isset($_POST["major"])
    && isset($_POST["first_name"]) && isset($_POST["last_name"])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['r_email'];
    $password = $_POST['r_password'];
    $university = $_POST['university'];
    $major = $_POST['major'];

    $sql = "INSERT INTO User (first_name, last_name, email, password, university, major)
        VALUES (:first_name, :last_name, :email, :password, :university,
        :major);";
    $st = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    try {
        $st->execute(array(':first_name' => $first_name, ':last_name' => $last_name, ':email' => $email, ':password' => $password,
            ':university' => $university, ':major' => $major));
    } catch (PDOException $e) {
        print $e;
    }
    if ($st->rowCount()) {
        header('Location: index.php');
    } else {
        print "Invalid parameter";
    }
}
?>