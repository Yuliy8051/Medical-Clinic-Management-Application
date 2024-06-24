<?php
require_once '../functions.php';
require_once "../Classes/User.php";
$database = connect_to_database();
if ($database->errorCode())
    die('end');
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = strtolower($_POST['email']);
$password = $_POST['password'];
$pattern = "/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?:{}|<>])[A-Za-z\d!@#$%^&*(),.?:{}|<>]{6,}$/";
if (preg_match($pattern, $password)){
    $password = password_hash($password, PASSWORD_DEFAULT);
    $patient = new Patient(0, $name, $surname, $email, $password);
    $patient->insertPatient($database);
    header('Location:../index.php');
}
else {
    require_once "registration.html";
    echo "The password should consist of at least 6 characters and contain at least 1 uppercase letter, a number and a special character";
}
?>