<?php

trait printMedicalSpecialisations
{
    public function printMedicalSpecialisations(PDO $database):void
    {
        $query = "select * from medical_specialisations";
        $query_result = $database->query($query);
        while ($result = $query_result->fetch(PDO::FETCH_ASSOC)) {
            printf('<option value="%d">%s</option>', $result['ID'], $result['medical_specialisation']);
        }
    }
}