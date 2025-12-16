<?php
session_start();
include "config.php";
include "class/database.php";
include "class/form.php";

$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/home/index';
$segments = explode('/', trim($path, '/'));
$mod = isset($segments[0]) && $segments[0] !== '' ? $segments[0] : 'home';
$page = isset($segments[1]) && $segments[1] !== '' ? $segments[1] : 'index';

// Halaman publik yang boleh diakses tanpa login
$public_pages = ['home', 'user'];
if (!in_array($mod, $public_pages)) {
    if (!isset($_SESSION['is_login'])) {
        header('Location: ' . $_SERVER['SCRIPT_NAME'] . '/user/login');
        exit();
    }
}

$file = "module/{$mod}/{$page}.php";

if (file_exists($file)) {
    // Jangan load header/footer jika sedang di halaman login
    if ($mod === 'user' && $page === 'login') {
        include $file;
    } else {
        include "template/header.php";
        include $file;
        include "template/footer.php";
    }
} else {
    include "template/header.php";
    echo '<div class="alert alert-danger">Modul tidak ditemukan: ' . $mod . '/' . $page . '</div>';
    include "template/footer.php";
}

