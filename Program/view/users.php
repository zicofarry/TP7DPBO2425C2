<link rel="stylesheet" href="../styles.css">
<?php
require_once '../config/Database.php';
require_once '../class/User.php';

$db = (new Database())->conn;
$user = new User($db);
$action = $_GET['action'] ?? 'list';
?>
<div class="container">
<?php
switch($action){
    case 'create':
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $user->name = $_POST['name'];
            $user->role = $_POST['role'];
            $user->contact = $_POST['contact'];
            $user->create();
            header('Location: users.php');
        }
        ?>
        <h2>Tambah User</h2>
        <a href="users.php" class="back-btn">← Kembali</a>
        <form method="POST">
            <label>Nama:</label>
            <input type="text" name="name" required>

            <label>Role:</label>
            <select name="role">
                <option value="student">Student</option>
                <option value="assistant">Assistant</option>
                <option value="admin">Admin</option>
            </select>

            <label>Contact:</label>
            <input type="text" name="contact">

            <button type="submit">Tambah</button>
        </form>
        <?php
        break;

    case 'edit':
        $id = $_GET['id'];
        $data = $user->getById($id);
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $user->id = $id;
            $user->name = $_POST['name'];
            $user->role = $_POST['role'];
            $user->contact = $_POST['contact'];
            $user->update();
            header('Location: users.php');
        }
        ?>
        <h2>Edit User</h2>
        <a href="users.php" class="back-btn">← Kembali</a>
        <form method="POST">
            <label>Nama:</label>
            <input type="text" name="name" required value="<?= $data['name'] ?>">

            <label>Role:</label>
            <select name="role">
                <option value="student" <?= $data['role']=='student'?'selected':'' ?>>Student</option>
                <option value="assistant" <?= $data['role']=='assistant'?'selected':'' ?>>Assistant</option>
                <option value="admin" <?= $data['role']=='admin'?'selected':'' ?>>Admin</option>
            </select>

            <label>Contact:</label>
            <input type="text" name="contact" value="<?= $data['contact'] ?>">

            <button type="submit">Update</button>
        </form>
        <?php
        break;

    case 'delete':
        $id = $_GET['id'];
        $user->id = $id;
        $user->delete();
        header('Location: users.php');
        break;

    default:
        $users = $user->readAll();
        ?>
        <h2>Daftar Users</h2>
        <a href="../index.php" class="back-btn">← Kembali</a>
        <a href="users.php?action=create" class="add-btn">Tambah User</a>
        <table>
            <tr><th>ID</th><th>Nama</th><th>Role</th><th>Contact</th><th>Aksi</th></tr>
            <?php foreach($users as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= $u['name'] ?></td>
                <td><?= $u['role'] ?></td>
                <td><?= $u['contact'] ?></td>
                <td>
                    <a href="users.php?action=edit&id=<?= $u['id'] ?>" class="edit-btn">Edit</a>
                    <a href="users.php?action=delete&id=<?= $u['id'] ?>" class="delete-btn" onclick="return confirm('Hapus user?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php
}
?>
</div>
