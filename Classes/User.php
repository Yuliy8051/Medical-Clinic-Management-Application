<?php
require_once 'Patient.php';
require_once 'Assistant.php';
require_once 'Doctor.php';
require_once 'Cardiologist.php';
require_once 'Admin.php';
class User
{
    protected int $ID;
    protected string $first_name;
    protected string $last_name;
    protected string $email;
    protected string $password;
    protected int $role_ID;
    public function __construct(int $ID, string $first_name, string $last_name, string $email, string $password, int $role_ID)
    {
        $this->ID = $ID;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->role_ID = $role_ID;
    }
    public function getRoleID(): int
    {
        return $this->role_ID;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function changeEmail(PDO $database):void
    {
        $email = strtolower($_POST['new_email']);
        $query = "update users set email = '$email' where ID = $this->ID;";
        $database->query($query);
        $this->setEmail($email);
    }
    public function changePassword(PDO $database)
    {
        $password = $_POST['new_password'];
        $pattern = "/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?:{}|<>])[A-Za-z\d!@#$%^&*(),.?:{}|<>]{6,}$/";
        if (preg_match($pattern, $password)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query = "update users set password = '$password' where ID = $this->ID;";
            $database->query($query);
            $this->setPassword($password);
        }
        else
            echo "The password should consist of at least 6 characters and contain at least 1 uppercase letter, a number and a special character";
    }
    public function printDoctors(PDO $database):void
    {
        if(isset($_POST['specialisation'])){
            $query = "select employees.ID, first_name, last_name from users join employees on users.ID = employees.ID where medical_specialisation_ID = {$_POST['specialisation']}";
            $query_result = $database->query($query);
            while ($result = $query_result->fetch(PDO::FETCH_ASSOC)){
                printf('<option value="%d">%s</option>', $result['ID'], $result['first_name'] . " " . $result['last_name']);
            }

        }
        else{
            $query = "select users.first_name, users.last_name, employees.biography, employees.qualification, employees.photo, medical_specialisations.medical_specialisation 
from users join employees on users.ID = employees.ID join medical_specialisations on employees.medical_specialisation_ID = medical_specialisations.ID where role_ID = 3;";
            $query_result = $database->query($query);
            while ($result = $query_result->fetch(PDO::FETCH_ASSOC)){
                $img = base64_encode($result['photo']);
                echo "<tr><td>{$result['first_name']} {$result['last_name']}</td><td>{$result['biography']}</td><td>{$result['qualification']}</td><td><img src='data:image/jpeg;base64, $img' alt=''></td><td>{$result['medical_specialisation']}</td></tr>";
            }
        }
    }
    public function printProcedures(PDO $database):void
    {
        if (isset($_COOKIE['category'])){
            $query = "select * from procedures join categories on procedures.category_ID = categories.ID where procedures.category_ID = {$_COOKIE['category']}";
            setcookie('category', 0, time() - 60*60*24);
        }
        else{
            $query = "select * from procedures join categories on procedures.category_ID = categories.ID";
        }
        $query_result = $database->query($query);
        while ($result = $query_result->fetch(PDO::FETCH_ASSOC)){
            echo "<tr><td>{$result['name']}</td><td>{$result['description']}</td><td>{$result['price']} zł</td><td>{$result['category']}</td></tr>";
        }

    }
    public function printCategories(PDO $database):void
    {
        $query = "select * from categories;";
        $query_result = $database->query($query);
        while ($result = $query_result->fetch(PDO::FETCH_ASSOC)){
            printf("<option value='%d'>%s</option>", $result['ID'], $result['category']);
        }
    }
    public function printNews(PDO $database):void
    {
        $query = "select * from news order by time desc;";
        $query_result = $database->query($query);
        while ($result = $query_result->fetch(PDO::FETCH_ASSOC)){
            $time = substr($result['time'], 0, 16);
            echo "<h2>{$result['name']}</h2>";
            echo "<p>$time</p>";
            echo "<p>{$result['news']}</p>";
            echo "<hr>";
        }
    }
    public static function create(PDO $database, string $email, string $password)
    {
        $email = strtolower($email);
        $query = "select * from users where email = '$email'";
        $query_result = $database->query($query);
        $result = $query_result->fetch(PDO::FETCH_ASSOC);
        if (!isset($result['password']) || !password_verify($password, $result['password']))
            return false;
        else{
            if ($result['role_ID'] == 1)
                return new Patient($result['ID'], $result['first_name'], $result['last_name'], $result['email'], $result['password']);
            elseif($result['role_ID'] == 2)
                return new Admin($result['ID'], $result['first_name'], $result['last_name'], $result['email'], $result['password'], 2);
            elseif($result['role_ID'] == 3) {
                $query = "select medical_specialisation_ID from employees where ID = {$result['ID']}";
                $query_result = $database->query($query);
                $result1 = $query_result->fetch(PDO::FETCH_ASSOC);
                if ($result1['medical_specialisation_ID'] == 3)
                    return new Cardiologist($result['ID'], $result['first_name'], $result['last_name'], $result['email'], $result['password'], 3);
                else
                    return new Doctor($result['ID'], $result['first_name'], $result['last_name'], $result['email'], $result['password'], 3, $result1['medical_specialisation_ID']);
            }else
                return new Assistant($result['ID'], $result['first_name'], $result['last_name'], $result['email'], $result['password'], 4);
        }
    }
}