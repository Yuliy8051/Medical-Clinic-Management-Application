<?php
class Doctor extends Assistant
{
    public function __construct($ID, string $first_name, string $last_name, string $email, string $password, int $role_ID, int $medical_specialisation_ID)
    {
        parent::__construct($ID, $first_name, $last_name, $email, $password, $role_ID);
        $this->medical_specialisation_ID = $medical_specialisation_ID;
    }

    public function getMedicalSpecialisationID(): int
    {
        return $this->medical_specialisation_ID;
    }
}