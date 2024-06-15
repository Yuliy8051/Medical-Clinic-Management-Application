<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medical procedures</title>
</head>
<body>
<table>
    <tr>
        <td>Name</td>
        <td>Description</td>
        <td>Price</td>
        <td>Category</td>
    </tr>
    <?php
    require_once 'Classes/User.php';
    require_once 'functions.php';
    session_start();
    $database = connect_to_database();
    $_SESSION['user']->printProcedures($database);
    ?>
</table>
</body>
</html>