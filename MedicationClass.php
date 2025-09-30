<?php
class MedicationClass {
    private $conn;
    private $table = "medication_classes";

    public $id;
    public $medication_id;
    public $class_name;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                 SET medication_id=:medication_id, class_name=:class_name";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":medication_id", $this->medication_id);
        $stmt->bindParam(":class_name", $this->class_name);

        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function readByMedication($medication_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE medication_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $medication_id);
        $stmt->execute();
        return $stmt;
    }
}
?>
