<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'] ?? '';
    if (isset($_SESSION['codigo_2fa']) && $codigo == $_SESSION['codigo_2fa']) {
        $_SESSION['usuario'] = $_SESSION['usuario_temp'];
        unset($_SESSION['codigo_2fa'], $_SESSION['usuario_temp']);
        header('Location: ../views/dashboard.php');
        exit();
    } else {
        header('Location: ../views/2fa.php?error=1');
        exit();
    }
} else {
    header('Location: ../views/login.php');
    exit();
}