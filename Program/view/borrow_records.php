<link rel="stylesheet" href="../styles.css">
<?php
require_once '../config/Database.php';
require_once '../class/BorrowRecord.php';
require_once '../class/User.php';
require_once '../class/ToolItem.php';

$db = (new Database())->conn;
$br = new BorrowRecord($db);
$user = new User($db);
$tool = new ToolItem($db);
$action = $_GET['action'] ?? 'list';
?>
<div class="container">
<?php
switch($action){
    case 'create':
        $users = $user->readAll();
        $tools = $db->query("SELECT * FROM tool_items WHERE status='available'")->fetchAll(PDO::FETCH_ASSOC);

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $br->user_id = $_POST['user_id'];
            $br->tool_item_id = $_POST['tool_item_id'];
            $br->borrowed_at = date('Y-m-d H:i:s');
            $br->status = 'borrowed';
            $br->create();

            $stmt = $db->prepare("UPDATE tool_items SET status='borrowed' WHERE id=:id");
            $stmt->bindParam(':id', $_POST['tool_item_id']);
            $stmt->execute();

            header('Location: borrow_records.php');
        }
        ?>
        <h2>Pinjam Alat</h2>
        <a href="borrow_records.php" class="back-btn">← Kembali ke List</a>
        <form method="POST">
            <label>User:</label>
            <select name="user_id">
                <?php foreach($users as $u): ?>
                <option value="<?= $u['id'] ?>"><?= $u['name'] ?></option>
                <?php endforeach; ?>
            </select>

            <label>Tool Item:</label>
            <select name="tool_item_id">
                <?php foreach($tools as $t): ?>
                <option value="<?= $t['id'] ?>"><?= $t['serial'] ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Pinjam</button>
        </form>
        <?php
        break;

    case 'return':
        $id = $_GET['id'];
        $data = $br->getById($id);
        $br->id = $id;
        $br->returned_at = date('Y-m-d H:i:s');
        $br->status = 'returned';
        $br->tool_item_id = $data['tool_item_id'];
        $br->user_id = $data['user_id'];
        $br->borrowed_at = $data['borrowed_at'];
        $br->update();

        $stmt = $db->prepare("UPDATE tool_items SET status='available' WHERE id=:id");
        $stmt->bindParam(':id', $data['tool_item_id']);
        $stmt->execute();

        header('Location: borrow_records.php');
        break;

    case 'delete':
        $id = $_GET['id'];
        $br->id = $id;
        $br->delete();
        header('Location: borrow_records.php');
        break;

    default:
        $records = $br->readAll();
        ?>
        <h2>Daftar Borrow Records</h2>
        <a href="../index.php" class="back-btn">← Kembali</a>
        <a href="borrow_records.php?action=create" class="add-btn">Tambah Peminjaman</a>
        <table>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Tool Item</th>
                <th>Borrowed At</th>
                <th>Returned At</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php foreach($records as $r): ?>
            <tr>
                <td><?= $r['id'] ?></td>
                <td><?= $r['user_name'] ?></td>
                <td><?= $r['tool_serial'] ?></td>
                <td><?= $r['borrowed_at'] ?></td>
                <td><?= $r['returned_at'] ?? '-' ?></td>
                <td><?= $r['status'] ?></td>
                <td>
                    <?php if($r['status']=='borrowed'): ?>
                        <a href="borrow_records.php?action=return&id=<?= $r['id'] ?>" class="edit-btn">Kembalikan</a>
                    <?php endif; ?>
                    <a href="borrow_records.php?action=delete&id=<?= $r['id'] ?>" class="delete-btn" onclick="return confirm('Hapus record?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
<?php
}
?>
</div>
