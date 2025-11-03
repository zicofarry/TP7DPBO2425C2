<?php
class User {
    private $conn;
    private $table = "users";

    public $id;
    public $name;
    public $role;
    public $contact;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO {$this->table} (name, role, contact) VALUES (:name, :role, :contact)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':contact', $this->contact);
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
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET name=:name, role=:role, contact=:contact WHERE id=:id");
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':contact', $this->contact);
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
