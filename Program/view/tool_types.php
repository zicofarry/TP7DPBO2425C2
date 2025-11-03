<link rel="stylesheet" href="../styles.css">
<?php
require_once '../config/Database.php';
require_once '../class/ToolType.php';

$db = (new Database())->conn;
$tool = new ToolType($db);
$action = $_GET['action'] ?? 'list';
?>
<div class="container">
<?php
switch($action){
    case 'create':
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $tool->name = $_POST['name'];
            $tool->description = $_POST['description'];
            $tool->create();
            header('Location: tool_types.php');
        }
        ?>
        <h2>Tambah Tool Type</h2>
        <a href="tool_types.php" class="back-btn">← Kembali</a>
        <form method="POST">
            <label>Nama:</label>
            <input type="text" name="name" required>

            <label>Deskripsi:</label>
            <textarea name="description"></textarea>

            <button type="submit">Tambah</button>
        </form>
        <?php
        break;

    case 'edit':
        $id = $_GET['id'];
        $data = $tool->getById($id);
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $tool->id = $id;
            $tool->name = $_POST['name'];
            $tool->description = $_POST['description'];
            $tool->update();
            header('Location: tool_types.php');
        }
        ?>
        <h2>Edit Tool Type</h2>
        <a href="tool_types.php" class="back-btn">← Kembali</a>
        <form method="POST">
            <label>Nama:</label>
            <input type="text" name="name" required value="<?= $data['name'] ?>">

            <label>Deskripsi:</label>
            <textarea name="description"><?= $data['description'] ?></textarea>

            <button type="submit">Update</button>
        </form>
        <?php
        break;

    case 'delete':
        $id = $_GET['id'];
        $tool->id = $id;
        $tool->delete();
        header('Location: tool_types.php');
        break;

    default:
        $types = $tool->readAll();
        ?>
        <h2>Daftar Tool Types</h2>
        <a href="../index.php" class="back-btn">← Kembali</a>
        <a href="tool_types.php?action=create" class="add-btn">Tambah Tool Type</a>
        <table>
            <tr><th>ID</th><th>Nama</th><th>Deskripsi</th><th>Aksi</th></tr>
            <?php foreach($types as $t): ?>
            <tr>
                <td><?= $t['id'] ?></td>
                <td><?= $t['name'] ?></td>
                <td><?= $t['description'] ?></td>
                <td>
                    <a href="tool_types.php?action=edit&id=<?= $t['id'] ?>" class="edit-btn">Edit</a>
                    <a href="tool_types.php?action=delete&id=<?= $t['id'] ?>" class="delete-btn" onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php
}
?>
</div>
