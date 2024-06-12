<?php
class Patient
{
    private string $name;
    private string $surname;
    private string $email;
    private string $password;
    private bool $push;
    public function __construct(string $name, string $surname, string $email, string $password, bool $push)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
        $this->push = $push;
    }
    public function insert_patient($database)
    {
        $query = "insert into users (first_name, last_name, email, password, push, role_ID) values ('$this->name', '$this->surname', '$this->email', '$this->password', '$this->push', 1);";
        $database->query($query);
    }
}
?>