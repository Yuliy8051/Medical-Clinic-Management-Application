<?php
require_once 'Classes/User.php';
require_once 'functions.php';
session_start();
$database = connect_to_database();
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Main page</title>
    <body>
    <nav>
        <a href="log/logout.php"><button>Log out</button></a>
        <a href="edit_my_account.php"><button>Edit my account</button></a>
        <a href="medical_procedures.php"><button>Medical procedures</button></a>
        <a href="doctor_list.php"><button>Doctors list</button></a>
        <a href="map/googleMap.html"><button>Our location</button></a>
        <?php
        if ($_SESSION['user']->getRoleID() == 2)
            echo '<a href="administration/administration.php"><button>administration panel</button></a>';
        if ($_SESSION['user']->getRoleID() == 3)
            echo '<a href="doctor.php"><button>Doctor panel</button></a>';
        if ($_SESSION['user']->getRoleID() == 1)
            echo '<a href="cardiology_visits.php"><button>My cardiology visits</button></a>';
        if ($_SESSION['user']->getRoleID() == 1)
            echo '<a href="calendar/choose_doctor_and_specialisation.php"><button>Make an appointment with a doctor</button></a>';
        ?>
    </nav>
    <h1>News Section</h1>
    <?php $_SESSION['user']->printNews($database);?>
    </body>
    </html>