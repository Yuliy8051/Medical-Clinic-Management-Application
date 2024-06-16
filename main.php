<?php
require_once 'Classes/User.php';
session_start();
echo '<a href="logout.php"><button>Log out</button></a>';
if ($_SESSION['user']->getRoleID() == 2)
    echo '<a href="administration.php"><button>Administration panel</button></a>';
if ($_SESSION['user']->getRoleID() == 3)
    echo '<a href="doctor.php"><button>Doctor panel</button></a>';
if ($_SESSION['user']->getRoleID() == 1)
    echo '<a href="cardiology_visits.php"><button>My cardiology visits</button></a>';
echo '<a href="edit_my_account.php"><button>Edit my account</button></a>';
echo '<a href="medical_procedures.php"><button>Medical procedures</button></a>';
echo '<a href="doctor_list.php"><button>Doctors list</button></a>';