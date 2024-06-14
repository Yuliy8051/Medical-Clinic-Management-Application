<?php
class Cardiologist extends Doctor
{
    public function __construct(string $first_name, string $last_name, string $email, string $password, bool $push, int $role_ID)
    {
        parent::__construct($first_name, $last_name, $email, $password, $push, $role_ID, 3);
    }

}