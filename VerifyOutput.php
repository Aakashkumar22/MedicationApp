<?php
require_once 'Database.php';
require_once 'Medication.php';
require_once 'MedicationClass.php';
require_once 'ClaasNameGroup.php';
require_once 'AssociatedDrug.php';

$database = new Database();
$db = $database->getConnection();

function buildMedicationsOutput($db) {
    $output = ["medications" => []];

    $medication = new Medication($db);
    $stmt = $medication->read();

    while ($medRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $medicationData = ["medicationsClasses" => []];

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

                $groupData = $drugsByType;
                $classData[$groupRow['group_name']] = [$groupData];
            }

            $medicationData["medicationsClasses"][] = $classData;
        }

        $output["medications"][] = $medicationData;
    }

    return $output;
}

// Expected output
$expected = [
    "medications" => [
        [
            "medicationsClasses" => [
                [
                    "className" => [
                        [
                            "associatedDrug" => [
                                [
                                    "name" => "asprin",
                                    "dose" => "",
                                    "strength" => "500 mg"
                                ]
                            ],
                            "associatedDrug#2" => [
                                [
                                    "name" => "somethingElse",
                                    "dose" => "",
                                    "strength" => "500 mg"
                                ]
                            ]
                        ]
                    ],
                    "className2" => [
                        [
                            "associatedDrug" => [
                                [
                                    "name" => "asprin",
                                    "dose" => "",
                                    "strength" => "500 mg"
                                ]
                            ],
                            "associatedDrug#2" => [
                                [
                                    "name" => "somethingElse",
                                    "dose" => "",
                                    "strength" => "500 mg"
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];

// Get actual output from database
$actual = buildMedicationsOutput($db);

// Compare
$expectedJson = json_encode($expected, JSON_PRETTY_PRINT);
$actualJson = json_encode($actual, JSON_PRETTY_PRINT);

echo "<h2>Expected Output:</h2>";
echo "<pre>" . $expectedJson . "</pre>";

echo "<h2>Actual Output from Database:</h2>";
echo "<pre>" . $actualJson . "</pre>";

echo "<h2>Verification Result:</h2>";
if ($expectedJson === $actualJson) {
    echo "<p style='color: green; font-weight: bold;'>SUCCESS: Output matches exactly!</p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>FAILED: Output does not match!</p>";

    // Show differences
    echo "<h3>Differences:</h3>";
    $expectedArray = json_decode($expectedJson, true);
    $actualArray = json_decode($actualJson, true);

    function array_diff_recursive($a1, $a2) {
        $result = [];
        foreach ($a1 as $key => $value) {
            if (!array_key_exists($key, $a2)) {
                $result[$key] = $value;
            } elseif (is_array($value) && is_array($a2[$key])) {
                $diff = array_diff_recursive($value, $a2[$key]);
                if (!empty($diff)) {
                    $result[$key] = $diff;
                }
            } elseif ($value !== $a2[$key]) {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    $diff = array_diff_recursive($expectedArray, $actualArray);
    echo "<pre>Differences: " . json_encode($diff, JSON_PRETTY_PRINT) . "</pre>";
}
?>
