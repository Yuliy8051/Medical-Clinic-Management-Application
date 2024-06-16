<?php
require_once 'Classes/User.php';
require_once 'functions.php';
session_start();
$database = connect_to_database();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor list</title>
</head>
<body>
<table>
    <tr>
        <td>Name</td>
        <td>Biography</td>
        <td>Qualification</td>
        <td>Photography</td>
        <td>Medical specialisation</td>
        <?php
        $_SESSION['user']->printDoctors($database);
        ?>
    </tr>
</table>
</body>
</html>
