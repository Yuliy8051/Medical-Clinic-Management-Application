<?php
class Patient extends User
{
    public function __construct(int $ID, string $first_name, string $last_name, string $email, string $password, bool $push)
    {
        parent::__construct($ID, $first_name, $last_name, $email, $password, $push, 1);
    }
    public function insertPatient($database): void
    {
        $query = "insert into users (first_name, last_name, email, password, push, role_ID) values ('$this->first_name', '$this->last_name', '$this->email', '$this->password', '$this->push', 1);";
        $database->query($query);
    }
    public function printVisits(PDO $database)
    {
        $query = "select * from cardiologist_visits join employees on cardiologist_visits.doctor_ID = employees.ID join users on employees.ID = users.ID where patient_ID = $this->ID;";
        $query_result = $database->query($query);
        while ($result = $query_result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>{$result["time"]}</td><td>{$result["meeting_description"]}</td><td>{$result["recommendation"]}</td><td>{$result["first_name"]} {$result["last_name"]}</td></tr>";
        }
    }
}
?>