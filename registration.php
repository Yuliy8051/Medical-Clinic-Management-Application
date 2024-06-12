<?php
require_once ('functions.php');
require_once "Patient.php";
$database = connect_to_database();
if ($database->errorCode())
    die('end');
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];
$pattern = "/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?:{}|<>])[A-Za-z\d!@#$%^&*(),.?:{}|<>]{6,}$/";
if (isset($_POST['push']))
    $push = true;
else
    $push = false;
if (preg_match($pattern, $password)){
    $password = password_hash($password, PASSWORD_DEFAULT);
    $patient = new Patient($name, $surname, $email, $password, $push);
    $patient->insert_patient($database);
    echo "good";
}
else {
    require_once "registration.html";
    echo "The password should consist of at least 6 characters and contain at least 1 uppercase letter, a number and a special character";
}
?>