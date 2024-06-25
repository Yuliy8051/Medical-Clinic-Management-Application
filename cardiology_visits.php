<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My cardiology visits</title>
    <link rel="stylesheet" href="cardiology_visitsStyle.css">
</head>
<body>
<table>
    <tr>
        <td>Date and time of adding</td>
        <td>Meeting Description</td>
        <td>Recommendations</td>
        <td>Cardiologist</td>
    </tr>
<?php
require_once 'functions.php';
require_once 'Classes/AbstractUser.php';
session_start();
$database = connect_to_database();
$_SESSION['user']->printVisits($database);
?>
</table>
</body>
</html>