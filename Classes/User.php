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