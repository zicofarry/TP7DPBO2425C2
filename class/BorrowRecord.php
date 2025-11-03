<?php
class BorrowRecord {
    private $conn;
    private $table = "borrow_records";

    public $id;
    public $tool_item_id;
    public $user_id;
    public $borrowed_at;
    public $returned_at;
    public $status;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (tool_item_id, user_id, borrowed_at, status) 
                                      VALUES (:tool_item_id, :user_id, :borrowed_at, :status)");
        $stmt->bindParam(':tool_item_id', $this->tool_item_id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':borrowed_at', $this->borrowed_at);
        $stmt->bindParam(':status', $this->status);
        return $stmt->execute();
    }

    public function readAll() {
        $stmt = $this->conn->prepare("SELECT br.*, u.name as user_name, ti.serial as tool_serial 
                                      FROM {$this->table} br
                                      JOIN users u ON br.user_id = u.id
                                      JOIN tool_items ti ON br.tool_item_id = ti.id
                                      ORDER BY br.id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id){
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id=:id LIMIT 1");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET tool_item_id=:tool_item_id, user_id=:user_id, borrowed_at=:borrowed_at, returned_at=:returned_at, status=:status WHERE id=:id");
        $stmt->bindParam(':tool_item_id', $this->tool_item_id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':borrowed_at', $this->borrowed_at);
        $stmt->bindParam(':returned_at', $this->returned_at);
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
