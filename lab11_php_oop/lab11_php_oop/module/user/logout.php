<?php
$base = $_SERVER['SCRIPT_NAME'];
session_destroy();
header('Location: ' . $base . '/user/login');
exit;
