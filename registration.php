<?php
require_once "Patient.php";
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];
$pattern = "/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?:{}|<>])[A-Za-z\d!@#$%^&*(),.?:{}|<>]{6,}$/";
if (preg_match($pattern, $password)){
    $patient = new Patient($name, $surname, $email, $password);
    echo "good";
}
else {
    require_once "registration.html";
    echo "The password should consist of at least 6 characters and contain at least 1 uppercase letter, a number and a special character";
}
?>