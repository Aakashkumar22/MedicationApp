<?php
require_once 'Database.php';
require_once 'Medication.php';
require_once 'MedicationClass.php';
require_once 'ClaasNameGroup.php';
require_once 'AssociatedDrug.php';

$database = new Database();
$db = $database->getConnection();

function buildMedicationsOutput($db) {
    $output = [
        "medications" => []
    ];

    $medication = new Medication($db);
    $stmt = $medication->read();

    while ($medRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $medicationData = [
            "medicationsClasses" => []
        ];

        $medicationClass = new MedicationClass($db);
        $classStmt = $medicationClass->readByMedication($medRow['id']);

        while ($classRow = $classStmt->fetch(PDO::FETCH_ASSOC)) {
            $classData = [];

            $classNameGroup = new ClassNameGroup($db);
            $groupStmt = $classNameGroup->readByClass($classRow['id']);

            while ($groupRow = $groupStmt->fetch(PDO::FETCH_ASSOC)) {
                $groupData = [];

                $associatedDrug = new AssociatedDrug($db);
                $drugStmt = $associatedDrug->readByGroup($groupRow['id']);

                $drugsByType = [];
                while ($drugRow = $drugStmt->fetch(PDO::FETCH_ASSOC)) {
                    $drugData = [
                        "name" => $drugRow['name'],
                        "dose" => $drugRow['dose'],
                        "strength" => $drugRow['strength']
                    ];

                    if (!isset($drugsByType[$drugRow['drug_type']])) {
                        $drugsByType[$drugRow['drug_type']] = [];
                    }
                    $drugsByType[$drugRow['drug_type']][] = $drugData;
                }

                // Build the object structure exactly as required
                $groupData = $drugsByType;
                $classData[$groupRow['group_name']] = [$groupData];
            }

            $medicationData["medicationsClasses"][] = $classData;
        }

        $output["medications"][] = $medicationData;
    }

    return $output;
}

$result = buildMedicationsOutput($db);
header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);
?>
