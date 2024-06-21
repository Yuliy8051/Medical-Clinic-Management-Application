<?php
require_once '../Classes/User.php';
require_once '../functions.php';
$database = connect_to_database();
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Make an appointment with a doctor</title>
</head>
<body>
<?php
$_SESSION['user']->chooseDoctor($database);
?>
</body>
</html>
