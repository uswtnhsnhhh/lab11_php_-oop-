<?php
require __DIR__ . '/config.php';

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $config['host'], $config['db_name']);
$username = $config['username'];
$password = $config['password'];

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    die('Koneksi gagal: ' . htmlspecialchars($e->getMessage()));
}

try {
    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS users (\n" .
        "  id INT AUTO_INCREMENT PRIMARY KEY,\n" .
        "  username VARCHAR(50) NOT NULL UNIQUE,\n" .
        "  password VARCHAR(255) NOT NULL,\n" .
        "  nama VARCHAR(100)\n" .
        ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    );
    echo "Tabel users siap.<br>";

    $hash = password_hash('admin123', PASSWORD_DEFAULT);

    $stmt = $pdo->prepare(
        "INSERT INTO users (username, password, nama)\n" .
        "VALUES ('admin', :password, 'Administrator')\n" .
        "ON DUPLICATE KEY UPDATE password = VALUES(password), nama = VALUES(nama);"
    );
    $stmt->execute([':password' => $hash]);

    // Cek apakah user admin sudah ada
    $cek = $pdo->prepare("SELECT id, username, nama FROM users WHERE username = 'admin' LIMIT 1");
    $cek->execute();
    $admin = $cek->fetch();

    if ($stmt->rowCount() > 0) {
        echo "User admin dibuat/tersedia. Username: admin, Password: admin123<br>";
    } else {
        echo "User admin sudah ada. Tidak ada perubahan.<br>";
    }

    if ($admin) {
        echo "ID Admin: " . htmlspecialchars((string)$admin['id']) . "<br>";
    }

    echo "Selesai.";
} catch (PDOException $e) {
    http_response_code(500);
    echo 'Terjadi kesalahan: ' . htmlspecialchars($e->getMessage());
}
