<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lab 11 PHP OPP</title>
    <?php $project = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
    <link rel="stylesheet" href="<?= $project ?>/assets/style.css">
</head>
<body>
<div class="page-wrapper">
    <div class="header">
        <h2>Lab 11 PHP OPP</h2>
        <small>Praktikum 11 &amp; OOP dan Routing</small>
    </div>
    <div class="navbar">
        <?php $base = $_SERVER['SCRIPT_NAME']; ?>
        <div class="sidebar">
            <a href="<?= $base ?>/home/index">Home</a>
            <?php if (isset($_SESSION['is_login'])): ?>
                <a href="<?= $base ?>/artikel/index">Data Artikel</a>
                <a href="<?= $base ?>/user/profile">Profil</a>
                <a href="<?= $base ?>/user/logout">Logout (<?= $_SESSION['nama'] ?>)</a>
            <?php else: ?>
                <a href="<?= $base ?>/user/login">Login</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="content">
