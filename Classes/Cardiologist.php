<?php
class Cardiologist extends Doctor
{
    public function __construct(int $ID, string $first_name, string $last_name, string $email, string $password, bool $push, int $role_ID)
    {
        parent::__construct($ID, $first_name, $last_name, $email, $password, $push, $role_ID, 3);
    }
    public function printPatients(PDO $database):void
    {
        $query = "select * from users where role_ID = 1";
        $query_result = $database->query($query);
        while ($result = $query_result->fetch(PDO::FETCH_ASSOC)) {
            printf('<option value="%d">%s</option>', $result['ID'], $result['last_name'] . ' ' . $result['first_name']);
        }
    }
    public function addVisit(PDO $database):void
    {
        if (isset($_POST['add_visit'])){
            $time = strftime("%Y-%m-%d %H:%M:%S", time());         // Skorzystanie z metod dotyczących dat i czasu
            $query = "insert into cardiologist_visits (time, meeting_description, recommendation, doctor_ID, patient_ID) VALUES ('$time', '{$_POST['meeting_description']}', '{$_POST['recommendation']}', $this->ID, {$_POST['patient_ID']})";
            $database->query($query);
        }
    }
}