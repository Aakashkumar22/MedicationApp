<?php
class AssociatedDrug {
    private $conn;
    private $table = "associated_drugs";

    public $id;
    public $group_id;
    public $drug_type;
    public $name;
    public $dose;
    public $strength;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                 SET group_id=:group_id, drug_type=:drug_type, 
                     name=:name, dose=:dose, strength=:strength";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":group_id", $this->group_id);
        $stmt->bindParam(":drug_type", $this->drug_type);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":dose", $this->dose);
        $stmt->bindParam(":strength", $this->strength);

        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function readByGroup($group_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE group_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $group_id);
        $stmt->execute();
        return $stmt;
    }
}
?>
