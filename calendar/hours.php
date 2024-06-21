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
if (isset($_POST['hour'])){
    $_SESSION['user']->makeAppointment($database);
}else{
    setcookie('date', $_POST['date'], time() + 24*60*60);
?>
<form method="post">
    <?php $_SESSION['user']->printHours($database) ?>
</form>
<?php }?>
</body>
</html>