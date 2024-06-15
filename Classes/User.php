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
    protected bool $push;
    protected int $role_ID;
    public function __construct(int $ID, string $first_name, string $last_name, string $email, string $password, bool $push, int $role_ID)
    {
        $this->ID = $ID;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->push = $push;
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
    public static function create(PDO $database, string $email, string $password)
    {
        $email = strtolower($email);
        $query = "select * from users where email = '{$email}'";
        $query_result = $database->query($query);
        $result = $query_result->fetch(PDO::FETCH_ASSOC);
        if (!isset($result['password']) || !password_verify($password, $result['password']))
            return false;
        else{
            if ($result['role_ID'] == 1)
                return new Patient($result['ID'], $result['first_name'], $result['last_name'], $result['email'], $result['password'], $result['push']);
            elseif($result['role_ID'] == 2)
                return new Admin($result['ID'], $result['first_name'], $result['last_name'], $result['email'], $result['password'], $result['push'], 2);
            elseif($result['role_ID'] == 3) {
                $query = "select medical_specialisation_ID from employees where ID = {$result['ID']}";
                $query_result = $database->query($query);
                $result1 = $query_result->fetch(PDO::FETCH_ASSOC);
                if ($result1['medical_specialisation_ID'] == 3)
                    return new Cardiologist($result['ID'], $result['first_name'], $result['last_name'], $result['email'], $result['password'], $result['push'], 3);
                else
                    return new Doctor($result['ID'], $result['first_name'], $result['last_name'], $result['email'], $result['password'], $result['push'], 3, $result1['medical_specialisation_ID']);
            }else
                return new Assistant($result['ID'], $result['first_name'], $result['last_name'], $result['email'], $result['password'], $result['push'], 4);
        }
    }
}