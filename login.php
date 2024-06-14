<?php
require_once 'functions.php';
require_once 'Classes/User.php';
$database = connect_to_database();
session_start();
$user = User::create($database, $_POST['email'], $_POST['password']);
if (!$user){
    require_once 'login.html';
    echo "Wrong email or password!";
}else{
    $_SESSION['user'] = $user;
    header('Location:main.php');
}
