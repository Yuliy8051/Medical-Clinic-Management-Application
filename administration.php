<?php
require_once 'functions.php';
require_once 'Classes/User.php';
$database = connect_to_database();
session_start();
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Title</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <form method="post" enctype="multipart/form-data">
        <h2>Add Doctor</h2>
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="password" required>
        <label for="push">Push messages:</label>
        <input type="checkbox" name="push" id="push">
        <input type="text" placeholder="Biography" name="biography" required>
        <input type="text" placeholder="Qualification" name="qualification" required>
        <input type="file" name="photo" required>
        <label for="medical_specialisation_ID">Medical specialisation:</label>
        <select id="medical_specialisation_ID" name="medical_specialisation_ID">
            <?php $_SESSION['user']->printMedicalSpecialisations($database); ?>
        </select>
        <input type="submit" name="add_doctor" value="Add Person">
    </form>
    </body>
    </html>
<?php $_SESSION['user']->check_insert($database);