<?php
require_once '../functions.php';
require_once '../Classes/AbstractUser.php';
$database = connect_to_database();
session_start();
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Administration panel</title>
        <link rel="stylesheet" href="administrationStyle.css">
    </head>
    <body>
    <div class="container">
    <form method="post" enctype="multipart/form-data">
        <h2>Add a Doctor</h2>
        <input class="input" type="text" name="first_name" placeholder="First Name" required>
        <input class="input" type="text" name="last_name" placeholder="Last Name" required>
        <input class="input" type="email" name="email" placeholder="Email" required>
        <input class="input" type="password" name="password" placeholder="password" required>
        <input class="input" type="text" placeholder="Biography" name="biography" required>
        <input class="input" type="text" placeholder="Qualification" name="qualification" required>
        <input class="input" type="file" name="photo" required>
        <select class="input" id="medical_specialisation_ID" name="medical_specialisation_ID" required>
            <option disabled selected>Medical specialisation</option>
            <?php $_SESSION['user']->printMedicalSpecialisations($database); ?>
        </select>
        <input class="submit" type="submit" name="add_doctor" value="Add a Doctor">
    </form>
    <form method="post" enctype="multipart/form-data">
        <h2>Add an Assistant</h2>
        <input class="input" type="text" name="first_name" placeholder="First Name" required>
        <input class="input" type="text" name="last_name" placeholder="Last Name" required>
        <input class="input" type="email" name="email" placeholder="Email" required>
        <input class="input" type="password" name="password" placeholder="password" required>
        <input class="input" type="text" placeholder="Biography" name="biography" required>
        <input class="input" type="text" placeholder="Qualification" name="qualification" required>
        <input class="input" type="file" name="photo" required>
        <select class="input" id="medical_specialisation_ID" name="medical_specialisation_ID" required>
            <option disabled selected>Medical specialisation</option>
            <?php $_SESSION['user']->printMedicalSpecialisations($database); ?>
        </select>
        <input class="submit" type="submit" name="add_assistant" value="Add an Assistant">
    </form>
    <form method="post" enctype="multipart/form-data">
        <h2>Add an Admin</h2>
        <input class="input" type="text" name="first_name" placeholder="First Name" required>
        <input class="input" type="text" name="last_name" placeholder="Last Name" required>
        <input class="input" type="email" name="email" placeholder="Email" required>
        <input class="input" type="password" name="password" placeholder="password" required>
        <input class="input" type="file" name="photo" required>
        <input class="submit" type="submit" name="add_admin" value="Add an Admin">
    </form>
    <form>
        <h2>Add a Patient</h2>
        <input class="input" type="text" name="first_name" placeholder="First Name" required>
        <input class="input" type="text" name="last_name" placeholder="Last Name" required>
        <input class="input" type="email" name="email" placeholder="Email" required>
        <input class="input" type="password" name="password" placeholder="password" required>
        <input class="submit" type="submit" name="add_patient" value="Add a Patient">
    </form>
    <form method="post">
        <h2>Add a news</h2>
        <input class="input" type="text" name="name" placeholder="News Name" required>
        <input class="input" type="text" name="news" placeholder="News property" required>
        <select class="input" id="news_type" name="type" required>
            <option selected disabled>News type</option>
            <?php $_SESSION['user']->printNewsTypes($database); ?>
        </select>
        <input class="submit" type="submit" name="add_news" value="Add a News">
    </form>
    </div>
    </body>
    </html>
<?php $_SESSION['user']->check_insert($database);