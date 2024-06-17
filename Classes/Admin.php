<?php
class Admin extends User
{
    public function __construct($ID, string $first_name, string $last_name, string $email, string $password, bool $push, int $role_ID)
    {
        parent::__construct($ID, $first_name, $last_name, $email, $password, $push, $role_ID);
    }
    public function printMedicalSpecialisations(PDO $database):void
    {
        $query = "select * from medical_specialisations";
        $query_result = $database->query($query);
        while ($result = $query_result->fetch(PDO::FETCH_ASSOC)) {
            printf('<option value="%d">%s</option>', $result['ID'], $result['medical_specialisation']);
        }
    }
     public function check_insert($database): void
     {
        if (isset($_POST['add_doctor'])) {
            $email = strtolower($_POST['email']);
            $email = trim($email);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $biography = trim($_POST['biography']);
            $qualification = trim($_POST['qualification']);
            if (isset($_POST['push']))
                $push = 1;
            else
                $push = 0;
            $img = addslashes(file_get_contents($_FILES['photo']['tmp_name']));
            $img_type = substr($_FILES['photo']['type'], 0, 5);
            if ($img_type === 'image'){
                $query = "insert into users (first_name, last_name, email, password, push, role_ID) values ('{$_POST['first_name']}', '{$_POST['last_name']}', '$email', '$password', $push, 3);
insert into employees (ID, biography, qualification, photo, medical_specialisation_ID) values ((select max(ID) from users), '$biography', '$qualification', '$img', {$_POST['medical_specialisation_ID']});";
                $this->insert($database, $query);
            }
            else{
                echo 'The file must be image';
            }
        }
     }
     public function insert($database, $query): void
     {
         try {
            $database->query($query);
            header("Location:administration.php");
         } catch (Exception $exception) {
            echo $exception->getMessage();
         }
     }
}