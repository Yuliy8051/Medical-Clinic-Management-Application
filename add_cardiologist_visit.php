<?php
require_once 'functions.php';
require_once 'Classes/User.php';
session_start();
$database = connect_to_database();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Visit</title>
</head>
<body>
<form method="post">
    <input type="text" name="meeting_description" placeholder="Meeting Description">
    <input type="text" name="recommendation" placeholder="Recommendations">
    <input type="text" name="patient_ID" list="list">
    <datalist id="list">
        <?php $_SESSION['user']->printPatients($database)?>
    </datalist>
    <input type="submit" name="add_visit" value="Add visit">
</form>
</body>
</html>
<?php
$_SESSION['user']->addVisit($database);