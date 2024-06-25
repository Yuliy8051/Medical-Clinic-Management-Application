<?php
require_once 'printMedicalSpecialisations.php';
class Patient extends User
{
    use printMedicalSpecialisations;
    public function __construct(int $ID, string $first_name, string $last_name, string $email, string $password)
    {
        parent::__construct($ID, $first_name, $last_name, $email, $password, 1);
    }
    public function insertPatient($database): void
    {
        $query = "insert into users (first_name, last_name, email, password, role_ID) values ('$this->first_name', '$this->last_name', '$this->email', '$this->password', 1);";
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
    public function chooseDoctor(PDO $database)
    {
        if (isset($_POST['specialisation'])){
            $query = "select medical_specialisation from medical_specialisations where ID = {$_POST['specialisation']}";
            $query_result = $database->query($query);
            $result = $query_result->fetch(PDO::FETCH_ASSOC);
            ?>
            <form class="flex" method="post" action="../calendar/calendar.php">
                <div class="specialisation">Choose a specialisation you need: <?php echo $result['medical_specialisation']?></div>
                <div>
                    <label for="doctor">Choose a specialisation you need: </label>
                    <select id="doctor" name="doctor">
                        <?php $this->printDoctors($database); ?>
                    </select>
                    <input type="submit" value="Choose">
                </div>
            </form>
            <?php
        }else{
            ?>
            <form class="flex" method="post">
                <div class="specialisation">
                    <label for="specialisation">Choose a specialisation you need: </label>
                    <select id="specialisation" name="specialisation">
                        <?php $this->printMedicalSpecialisations($database); ?>
                    </select>
                    <input type="submit" value="Choose">
                </div>
            </form>
            <?php
        }
    }
    public function printHours(PDO $database)
    {
        $query = "select time from visits where time > now() and doctor_ID = {$_COOKIE['doctor']}";
        $query_result = $database->query($query);
        $result = $query_result->fetchAll(PDO::FETCH_COLUMN);
        for ($k = 0; $k < count($result); $k++) {
            $result[$k] = substr($result[$k], 0, 16);
        }
        for ($i = 8; $i < 17; $i++) {
            for ($j = 0; $j < 60; $j += 30) {
                $time = sprintf("{$_POST['date']} $i:%02d", $j);
                if (in_array($time, $result)){
                    printf("<input type='submit' style='background-color: red; color: black' value='$i:%02d' disabled>", $j);
                }
                else{
                    printf("<input type='submit' name='hour' value='$i:%02d'>", $j);
                }
            }
        }
    }
    public function makeAppointment(PDO $database)
    {
        $query = "insert into visits (time, patient_ID, doctor_ID) VALUES ('{$_COOKIE['date']} {$_POST['hour']}:00', $this->ID, {$_COOKIE['doctor']})";
        $database->query($query);
        header('Location:../main.php');
    }
}
?>