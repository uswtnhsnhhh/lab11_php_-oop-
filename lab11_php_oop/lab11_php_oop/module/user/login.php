<?php
// Cek jika sudah login, langsung ke home
$base = $_SERVER['SCRIPT_NAME'];
if (isset($_SESSION['is_login'])) {
    header('Location: ' . $base . '/home/index');
    exit;
}

$message = "";

if ($_POST) {
    $db = new Database();
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '{$username}' LIMIT 1";
    $result = $db->query($sql);
    $data = $result ? $result->fetch_assoc() : null;

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['is_login'] = true;
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama'] = $data['nama'];
        header('Location: ' . $base . '/artikel/index');
        exit;
    } else {
        $message = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            max-width: 420px;
            margin: 100px auto;
            padding: 22px 20px;
            border-radius: 14px;
            background: #eef2ff; /* soft blue */
            border: 1px solid rgba(29, 78, 216, 0.2);
            box-shadow: 0 12px 30px rgba(15,23,42,0.08);
        }
        .login-container h3 { color: #0f172a; }
        .login-container .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, 0.18);
        }
        .login-container .btn-primary {
            background-color: #2563eb;
            border-color: #1d4ed8;
        }
        .login-container .btn-primary:hover { background-color: #1d4ed8; }
    </style>
</head>
<body>
<div class="login-container">
    <h3 class="text-center mb-4">Login User</h3>
    <?php if ($message): ?>
        <div class="alert alert-danger"><?= $message ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
    <div class="mt-3 text-center">
        <a href="<?= $base ?>/home/index">Kembali ke Home</a>
    </div>
</div>
</body>
</html>
