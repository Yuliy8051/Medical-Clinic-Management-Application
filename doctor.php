<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Page</title>
</head>
<body>
<?php
require_once 'Classes/User.php';
session_start();
if ($_SESSION['user']->getMedicalSpecialisationID() == 3)
    echo '<a href="add_cardiologist_visit.php"><button>Add visit</button></a>';
?>
</body>
</html>