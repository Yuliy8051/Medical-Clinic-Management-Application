<?php
class Doctor extends Assistant
{
    public function __construct(string $first_name, string $last_name, string $email, string $password, bool $push, int $role_ID, int $medical_specialisation_ID)
    {
        parent::__construct($first_name, $last_name, $email, $password, $push, $role_ID);
        $this->medical_specialisation_ID = $medical_specialisation_ID;
    }

}