<?php
class ClassNameGroup {
    private $conn;
    private $table = "class_name_groups";

    public $id;
    public $class_id;
    public $group_name;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                 SET class_id=:class_id, group_name=:group_name";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":class_id", $this->class_id);
        $stmt->bindParam(":group_name", $this->group_name);

        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function readByClass($class_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE class_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $class_id);
        $stmt->execute();
        return $stmt;
    }
}
?>