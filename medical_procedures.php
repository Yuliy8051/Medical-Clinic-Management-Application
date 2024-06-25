<?php
require_once 'Classes/AbstractUser.php';
require_once 'functions.php';
session_start();
$database = connect_to_database();
function cookie():void
{
    if (isset($_POST['selection'])){
        setcookie('category', $_POST['category'], time() + 60*60*24);
        header("Location:medical_procedures.php");
    }
}
cookie();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medical procedures</title>
    <link rel="stylesheet" href="medical_proceduresStyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
<form class="form" method="post">
    <label for="category">Category</label>
    <select id="category" name="category" required>
        <option value="" selected disabled></option>
        <?php
        $_SESSION['user']->printCategories($database);
        ?>
    </select>
    <input type="submit" name="selection" value="select">
</form>
<div>
    <div class="flex label">
        <p class="name">Name</p>
        <p class="description">Description</p>
        <p class="price">Price</p>
        <p class="category">Category</p>
    </div>
    <?php
    $_SESSION['user']->printProcedures($database);
    ?>
</div>
</body>
</html>