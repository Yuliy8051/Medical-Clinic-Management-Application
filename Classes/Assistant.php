<?php

class Assistant extends User
{
    protected int|null $medical_specialisation_ID;
    public function __construct($ID, string $first_name, string $last_name, string $email, string $password, bool $push, int $role_ID)
    {
        parent::__construct($ID, $first_name, $last_name, $email, $password, $push, $role_ID);
    }
}