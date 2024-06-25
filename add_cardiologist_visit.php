<?php
require_once 'functions.php';
require_once 'Classes/AbstractUser.php';
session_start();
$database = connect_to_database();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Visit</title>
    <link rel="stylesheet" href="add_cardiologist_visitStyle.css">
</head>
<body>
<div class="container">
<form method="post">
    <h1>Add a visit</h1>
    <textarea name="meeting_description" placeholder="Meeting Description" required></textarea>
    <textarea name="recommendation" placeholder="Recommendations" required></textarea>
    <input class="patient" type="text" name="patient_ID" placeholder="Patient" list="list">
    <datalist id="list">
        <?php $_SESSION['user']->printPatients($database)?>
    </datalist>
    <input class="submit" type="submit" name="add_visit" value="Add visit">
</form>
</div>
</body>
</html>
<?php
$_SESSION['user']->addVisit($database);