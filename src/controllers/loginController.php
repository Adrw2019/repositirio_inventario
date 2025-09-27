<?php
session_start();
require_once '../../config/db.php';
require_once __DIR__ . '/../../vendor/autoload.php'; // Si usas Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
echo 'PHPMailer cargado correctamente';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validación básica
    if (empty($email) || empty($password)) {
        header('Location: ../views/login.php?error=Campos obligatorios');
        exit();
    }

    // Consulta a la base de datos
    $stmt = $conn->prepare("SELECT id, nombre, email, password FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $usuario = $res->fetch_assoc();
        if (password_verify($password, $usuario['password'])) {
            // Genera código 2FA
            $codigo_2fa = rand(100000, 999999);
            $_SESSION['codigo_2fa'] = $codigo_2fa;
            $_SESSION['usuario_temp'] = $usuario;

            // Envía el código por correo usando PHPMailer
            $mail = new PHPMailer(true);
            try {
                // Configuración SMTP Gmail
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'andrw6382@gmail.com'; // Tu correo Gmail
                $mail->Password = 'biyigbicrzinkmhf';     // App Password de Gmail
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('andrw6382@gmail.com', 'Inventario Tecnológico');
                $mail->addAddress($usuario['email']); // El correo del usuario que inicia sesión

                $mail->Subject = 'Tu codigo de verificacion';
                $mail->Body = "Tu codigo de verificacion es: $codigo_2fa";

                $mail->send();
                // Opcional: echo "Correo enviado correctamente";
            } catch (Exception $e) {
                echo "Error al enviar el correo: {$mail->ErrorInfo}";
            }

            header('Location: ../views/2fa.php');
            exit();
        }
    }
    header('Location: ../views/login.php?error=Credenciales incorrectas');
    exit();
} else {
    header('Location: ../views/login.php');
    exit();
}