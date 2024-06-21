<?php
require_once ('functions.php');
$database = connect_to_database();
create_database($database);
session_start();
if (isset($_SESSION['user']))
    header('Location:main.php');
else
    header('Location:log/login.html');