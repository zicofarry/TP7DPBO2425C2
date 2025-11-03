<link rel="stylesheet" href="../styles.css">
<?php
require_once '../config/Database.php';
require_once '../class/ToolItem.php';
require_once '../class/ToolType.php';

$db = (new Database())->conn;
$toolItem = new ToolItem($db);
$toolType = new ToolType($db);
$action = $_GET['action'] ?? 'list';
?>
<div class="container">
<?php
switch($action){
    case 'create':
        $types = $toolType->readAll();
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $toolItem->tool_type_id = $_POST['tool_type_id'];
            $toolItem->serial = $_POST['serial'];
            $toolItem->condition = $_POST['condition'];
            $toolItem->status = $_POST['status'];
            $toolItem->create();
            header('Location: tool_items.php');
        }
        ?>
        <h2>Tambah Tool Item</h2>
        <a href="tool_items.php" class="back-btn">← Kembali</a>
        <form method="POST">
            <label>Tool Type:</label>
            <select name="tool_type_id">
                <?php foreach($types as $t): ?>
                <option value="<?= $t['id'] ?>"><?= $t['name'] ?></option>
                <?php endforeach; ?>
            </select>

            <label>Serial:</label>
            <input type="text" name="serial" required>

            <label>Condition:</label>
            <select name="condition">
                <option value="baik">Baik</option>
                <option value="rusak">Rusak</option>
                <option value="hilang">Hilang</option>
            </select>

            <label>Status:</label>
            <select name="status">
                <option value="available">Available</option>
                <option value="borrowed">Borrowed</option>
                <option value="unavailable">Unavailable</option>
            </select>

            <button type="submit">Tambah</button>
        </form>
        <?php
        break;

    case 'edit':
        $id = $_GET['id'];
        $data = $toolItem->getById($id);
        $types = $toolType->readAll(); // Ambil semua tool types untuk dropdown

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $toolItem->id = $id;
            $toolItem->tool_type_id = $_POST['tool_type_id'];
            $toolItem->serial = $_POST['serial'];
            $toolItem->condition = $_POST['condition'];
            $toolItem->status = $_POST['status'];
            $toolItem->update();
            header('Location: tool_items.php');
        }
        ?>
        <h2>Edit Tool Item</h2>
        <a href="tool_items.php" class="back-btn">← Kembali</a>
        <form method="POST">
            <label>Tool Type:</label>
            <select name="tool_type_id">
                <?php foreach($types as $t): ?>
                <option value="<?= $t['id'] ?>" <?= $data['tool_type_id']==$t['id']?'selected':'' ?>><?= $t['name'] ?></option>
                <?php endforeach; ?>
            </select>

            <label>Serial:</label>
            <input type="text" name="serial" required value="<?= $data['serial'] ?>">

            <label>Condition:</label>
            <select name="condition">
                <option value="baik" <?= $data['condition']=='baik'?'selected':'' ?>>Baik</option>
                <option value="rusak" <?= $data['condition']=='rusak'?'selected':'' ?>>Rusak</option>
                <option value="hilang" <?= $data['condition']=='hilang'?'selected':'' ?>>Hilang</option>
            </select>

            <label>Status:</label>
            <select name="status">
                <option value="available" <?= $data['status']=='available'?'selected':'' ?>>Available</option>
                <option value="borrowed" <?= $data['status']=='borrowed'?'selected':'' ?>>Borrowed</option>
                <option value="unavailable" <?= $data['status']=='unavailable'?'selected':'' ?>>Unavailable</option>
            </select>

            <button type="submit">Update</button>
        </form>
        <?php
        break;

    case 'delete':
        $id = $_GET['id'];
        $toolItem->id = $id;
        $toolItem->delete();
        header('Location: tool_items.php');
        break;

    default:
        $items = $toolItem->readAll();
        ?>
        <h2>Daftar Tool Items</h2>
        <a href="../index.php" class="back-btn">← Kembali</a>
        <a href="tool_items.php?action=create" class="add-btn">Tambah Tool Item</a>
        <table>
            <tr><th>ID</th><th>Tool Type</th><th>Serial</th><th>Condition</th><th>Status</th><th>Aksi</th></tr>
            <?php foreach($items as $i): ?>
            <tr>
                <td><?= $i['id'] ?></td>
                <td><?= $i['tool_name'] ?></td>
                <td><?= $i['serial'] ?></td>
                <td><?= $i['condition'] ?></td>
                <td><?= $i['status'] ?></td>
                <td>
                    <a href="tool_items.php?action=edit&id=<?= $i['id'] ?>" class="edit-btn">Edit</a> 
                    <a href="tool_items.php?action=delete&id=<?= $i['id'] ?>" class="delete-btn" onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php
}
?>
</div>
