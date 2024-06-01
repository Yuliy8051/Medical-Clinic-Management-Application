<?php
class Patient
{
    private string $name;
    private string $surname;
    private string $email;
    private string $password;
    public function __construct(string $name, string $surname, string $email, string $password)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
    }

}
?>