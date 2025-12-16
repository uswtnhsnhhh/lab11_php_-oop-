<?php
$db = new Database();
$base = $_SERVER['SCRIPT_NAME'];

if ($_POST) {
    $username = trim($_POST['username']);
    $nama = trim($_POST['nama']);
    $pass = (string)($_POST['pass'] ?? '');

    if ($username === '' || $pass === '') {
        echo "<div style='color:red'>Username dan Password wajib diisi.</div>";
    } else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $data = [
            'username' => $username,
            'password' => $hash,
            'nama' => $nama,
        ];
        $simpan = $db->insert('users', $data);
        if ($simpan) {
            header('Location: ' . $base . '/artikel/index');
            exit;
        } else {
            echo "<div style='color:red'>Gagal menyimpan data.</div>";
        }
    }
}
?>
<div class="card">
    <h3>Form Tambah User</h3>
    <form method="POST" action="">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control">
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="pass" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
    </form>
</div>
