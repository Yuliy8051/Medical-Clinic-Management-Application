<?php
class Patient extends User
{
    public function __construct(string $first_name, string $last_name, string $email, string $password, bool $push)
    {
        parent::__construct($first_name, $last_name, $email, $password, $push, 1);
    }


    public function insertPatient($database): void
    {
        $query = "insert into users (first_name, last_name, email, password, push, role_ID) values ('$this->first_name', '$this->last_name', '$this->email', '$this->password', '$this->push', 1);";
        $database->query($query);
    }
}
?>