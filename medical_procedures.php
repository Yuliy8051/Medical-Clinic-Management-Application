<?php
require_once 'Classes/User.php';
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
</head>
<body>
<form method="post">
    <label for="category">Category</label>
    <select id="category" name="category" required>
        <option value="" selected disabled></option>
        <?php
        $_SESSION['user']->printCategories($database);
        ?>
    </select>
    <input type="submit" name="selection" value="select">
</form>
<table>
    <tr>
        <td>Name</td>
        <td>Description</td>
        <td>Price</td>
        <td>Category</td>
    </tr>
    <?php
    $_SESSION['user']->printProcedures($database);
    ?>
</table>
</body>
</html>