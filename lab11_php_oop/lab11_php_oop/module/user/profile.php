<?php
// Pastikan user sudah login
if (!isset($_SESSION['is_login'])) {
    header('Location: ../user/login');
    exit;
}

$db = new Database();
$username = $_SESSION['username'];

// Ambil data user yang sedang login
$sql = "SELECT username, nama FROM users WHERE username = '{$username}' LIMIT 1";
$result = $db->query($sql);
$user = $result ? $result->fetch_assoc() : null;

$msg_success = '';
$msg_error = '';

// Proses ubah password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_pass = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
    $confirm = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

    if ($new_pass === '' || $confirm === '') {
        $msg_error = 'Password baru dan konfirmasi tidak boleh kosong.';
    } elseif ($new_pass !== $confirm) {
        $msg_error = 'Konfirmasi password tidak cocok.';
    } else {
        $hash = password_hash($new_pass, PASSWORD_BCRYPT);
        $updated = $db->update('users', ['password' => $hash], "username = '{$username}'");
        if ($updated) {
            $msg_success = 'Password berhasil diperbarui.';
        } else {
            $msg_error = 'Gagal memperbarui password.';
        }
    }
}
?>
<div class="card" style="max-width:680px;margin:0 auto;">
    <h3>Profil Pengguna</h3>

    <?php if ($msg_success): ?>
        <div class="alert alert-success"><?= $msg_success ?></div>
    <?php endif; ?>
    <?php if ($msg_error): ?>
        <div class="alert alert-danger"><?= $msg_error ?></div>
    <?php endif; ?>

    <?php if ($user): ?>
        <div class="subcard">
            <table class="table" style="margin:0;">
                <tr>
                    <th>Nama</th>
                    <td><?= htmlspecialchars($user['nama']) ?></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                </tr>
            </table>
        </div>
    <?php endif; ?>

    <h4>Ubah Password</h4>
    <form method="post" action="">
        <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Konfirmasi Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
