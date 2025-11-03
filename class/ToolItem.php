<?php
class ToolItem {
    private $conn;
    private $table = "tool_items";

    public $id;
    public $tool_type_id;
    public $serial;
    public $condition;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (tool_type_id, serial, `condition`, status) 
                                      VALUES (:tool_type_id, :serial, :condition, :status)");
        $stmt->bindParam(':tool_type_id', $this->tool_type_id);
        $stmt->bindParam(':serial', $this->serial);
        $stmt->bindParam(':condition', $this->condition);
        $stmt->bindParam(':status', $this->status);
        return $stmt->execute();
    }

    public function readAll() {
        $stmt = $this->conn->prepare("SELECT ti.*, tt.name as tool_name 
                                      FROM {$this->table} ti 
                                      JOIN tool_types tt ON ti.tool_type_id = tt.id 
                                      ORDER BY ti.id ASC");
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
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET tool_type_id=:tool_type_id, serial=:serial, `condition`=:condition, status=:status WHERE id=:id");
        $stmt->bindParam(':tool_type_id', $this->tool_type_id);
        $stmt->bindParam(':serial', $this->serial);
        $stmt->bindParam(':condition', $this->condition);
        $stmt->bindParam(':status', $this->status);
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
