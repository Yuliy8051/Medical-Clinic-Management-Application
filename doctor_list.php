<?php
require_once 'Classes/AbstractUser.php';
require_once 'functions.php';
session_start();
$database = connect_to_database();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor list</title>
    <link rel="stylesheet" href="doctor_listStyle.css">
</head>
<body>
<div class="grid">
        <?php
        $_SESSION['user']->printDoctors($database);
        ?>
</div>
</body>
</html>
