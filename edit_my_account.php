<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit my account</title>
    <link rel="stylesheet" href="edit_my_accountStyle.css">
</head>
<body>
<form class="editEmail" method="post">
    <h1>Edit</h1>
    <label>
        <input type="email" name="new_email" placeholder="New Email" required>
    </label>
    <button type="submit" name="edit_email">Edit email</button>
</form>
<form class="editPassword" method="post">
    <label>
        <input type="password" name="new_password" placeholder="New Password" required>
    </label>
    <button type="submit" name="edit_password">Edit password</button>
</form>
</body>
</html>
<?php
require_once 'functions.php';
require_once 'Classes/AbstractUser.php';
$database = connect_to_database();
session_start();
if(isset($_POST['edit_email']))
    $_SESSION['user']->changeEmail($database);
elseif(isset($_POST['edit_password']))
    $_SESSION['user']->changePassword($database);