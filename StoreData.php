<?php
require_once 'Database.php';
require_once 'Medication.php';
require_once 'MedicationClass.php';
require_once 'ClaasNameGroup.php';
require_once 'AssociatedDrug.php';

$database = new Database();
$db = $database->getConnection();

try {
    $db->beginTransaction();

    // Create medication
    $medication = new Medication($db);
    $medication_id = $medication->create();

    // Create medication class
    $medicationClass = new MedicationClass($db);
    $medicationClass->medication_id = $medication_id;
    $medicationClass->class_name = "medicationsClasses";
    $class_id = $medicationClass->create();

    // Define the data structure to match exactly the desired output
    $classGroups = [
        'className' => [
            'associatedDrug' => [
                ['name' => 'asprin', 'dose' => '', 'strength' => '500 mg']
            ],
            'associatedDrug#2' => [
                ['name' => 'somethingElse', 'dose' => '', 'strength' => '500 mg']
            ]
        ],
        'className2' => [
            'associatedDrug' => [
                ['name' => 'asprin', 'dose' => '', 'strength' => '500 mg']
            ],
            'associatedDrug#2' => [
                ['name' => 'somethingElse', 'dose' => '', 'strength' => '500 mg']
            ]
        ]
    ];

    // Store class name groups and associated drugs
    foreach ($classGroups as $groupName => $drugTypes) {
        $classNameGroup = new ClassNameGroup($db);
        $classNameGroup->class_id = $class_id;
        $classNameGroup->group_name = $groupName;
        $group_id = $classNameGroup->create();

        foreach ($drugTypes as $drugType => $drugs) {
            foreach ($drugs as $drug) {
                $associatedDrug = new AssociatedDrug($db);
                $associatedDrug->group_id = $group_id;
                $associatedDrug->drug_type = $drugType;
                $associatedDrug->name = $drug['name'];
                $associatedDrug->dose = $drug['dose'];
                $associatedDrug->strength = $drug['strength'];
                $associatedDrug->create();
            }
        }
    }

    $db->commit();
    echo "Data stored successfully! Medication ID: " . $medication_id . "\n";

} catch (Exception $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
