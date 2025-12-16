<?php
$db = new Database();
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$data_lama = $db->get('users', "id=" . $id);
$base = $_SERVER['SCRIPT_NAME'];

if ($_POST) {
    $username = trim($_POST['username']);
    $nama = trim($_POST['nama']);
    $pass = (string)($_POST['pass'] ?? '');

    $data_update = [
        'username' => $username,
        'nama' => $nama,
    ];
    if ($pass !== '') {
        $data_update['password'] = password_hash($pass, PASSWORD_DEFAULT);
    }

    $update = $db->update('users', $data_update, "id=" . $id);
    if ($update) {
        header('Location: ' . $base . '/artikel/index');
        exit;
    } else {
        echo "<div style='color:red'>Gagal mengupdate data.</div>";
    }
}
?>
<h3>Form Ubah User</h3>
<form method="POST" action="">
    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data_lama['username'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data_lama['nama'] ?? '') ?>">
    </div>
    <div class="mb-3">
        <label>Password Baru (opsional)</label>
        <input type="password" name="pass" class="form-control" placeholder="Kosongkan jika tidak diubah">
    </div>
    <button type="submit" class="btn btn-primary">Update Data</button>
</form>
