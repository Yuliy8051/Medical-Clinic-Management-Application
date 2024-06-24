<?php
require_once '../functions.php';
require_once '../Classes/User.php';
$database = connect_to_database();
session_start();
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Administration panel</title>
    </head>
    <body>
    <form method="post" enctype="multipart/form-data">
        <h2>Add a Doctor</h2>
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="password" required>
        <input type="text" placeholder="Biography" name="biography" required>
        <input type="text" placeholder="Qualification" name="qualification" required>
        <input type="file" name="photo" required>
        <label for="medical_specialisation_ID">Medical specialisation:</label>
        <select id="medical_specialisation_ID" name="medical_specialisation_ID">
            <?php $_SESSION['user']->printMedicalSpecialisations($database); ?>
        </select>
        <input type="submit" name="add_doctor" value="Add a Doctor">
    </form>
    <form method="post" enctype="multipart/form-data">
        <h2>Add an Assistant</h2>
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="password" required>
        <input type="text" placeholder="Biography" name="biography" required>
        <input type="text" placeholder="Qualification" name="qualification" required>
        <input type="file" name="photo" required>
        <label for="medical_specialisation_ID">Medical specialisation:</label>
        <select id="medical_specialisation_ID" name="medical_specialisation_ID">
            <?php $_SESSION['user']->printMedicalSpecialisations($database); ?>
        </select>
        <input type="submit" name="add_assistant" value="Add an Assistant">
    </form>
    <form method="post" enctype="multipart/form-data">
        <h2>Add an Admin</h2>
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="password" required>
        <input type="file" name="photo" required>
        <input type="submit" name="add_admin" value="Add an Admin">
    </form>
    <form>
        <h2>Add a Patient</h2>
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="password" required>
        <input type="submit" name="add_patient" value="Add a Patient">
    </form>
    <form method="post">
        <h2>Add a news</h2>
        <input type="text" name="name" placeholder="News Name" required>
        <input type="text" name="news" placeholder="News property" required>
        <label for="news_type">News type:</label>
        <select id="news_type" name="type">
            <?php $_SESSION['user']->printNewsTypes($database); ?>
        </select>
        <input type="submit" name="add_news" value="Add a News">
    </form>
    <form method="post">
        <label for="search">How do you want to look for?</label>
        <select id="search" name="search" required>
            <option value="1">Patient</option>
            <option value="2">Admin</option>
            <option value="3">Doctor</option>
            <option value="4">Assistant</option>
        </select>
        <input type="submit" value="Search">
    </form>
    </body>
    </html>
<?php $_SESSION['user']->check_insert($database);