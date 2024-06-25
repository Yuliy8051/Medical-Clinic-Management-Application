<?php
require_once 'User.php';
require_once 'Admin.php';
require_once 'Assistant.php';
require_once 'Doctor.php';
require_once 'Cardiologist.php';
require_once 'Patient.php';
abstract class AbstractUser
{
    public abstract function changePassword(PDO $database);
}