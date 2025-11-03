<?php
class ToolType {
    private $conn;
    private $table = "tool_types";

    public $id;
    public $name;
    public $description;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (name, description) VALUES (:name, :description)");
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        return $stmt->execute();
    }

    public function readAll() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id=:id LIMIT 1");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET name=:name, description=:description WHERE id=:id");
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=:id");
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}
?>
