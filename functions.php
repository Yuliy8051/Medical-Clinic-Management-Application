<?php
function connect_to_database(): PDO
{
    return new PDO('mysql:host=localhost;dbname=medical_clinic_management_application', 'root', '');
}
function create_database(PDO $database): void
{
    $database->beginTransaction();
    try {
        $query = file_get_contents('create.sql');
        $database->query($query);
        $query = file_get_contents('insertProcedures.sql');
        $database->query($query);
    }catch (Exception $exception){
        $database->rollBack();
    }
}