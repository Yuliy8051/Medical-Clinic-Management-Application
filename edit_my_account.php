<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit my account</title>
</head>
<body>
<form method="post">
  <input type="email" name="new_email" placeholder="New Email" required>
  <input type="submit" name="edit_email" value="Edit email">
</form>
<form method="post">
    <input type="password" name="new_password" placeholder="New Password" required>
    <input type="submit" name="edit_password" value="Edit password">
</form>
</body>
</html>
<?php
require_once 'functions.php';
require_once 'Classes/User.php';
$database = connect_to_database();
session_start();
if(isset($_POST['edit_email']))
    $_SESSION['user']->changeEmail($database);
elseif(isset($_POST['edit_password']))
    $_SESSION['user']->changePassword($database);