<?php
// contacto_anonimo_envio.php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contacto_anonimo.php');
    exit;
}

// Validación básica
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$asunto = trim($_POST['asunto'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');
$ip = $_SERVER['REMOTE_ADDR'];

// Honeypot: si el campo oculto fue rellenado, es un bot
if (!empty($_POST['website'])) {
    // Redirigir silenciosamente a index
    header('Location: index.php');
    exit;
}

if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
    header('Location: contacto_anonimo.php?error=1');
    exit;
}

// Dirección del administrador (cambiá por la tuya)
$destinatario = 'SEBLASH@GMAIL.COM';

$subject = "Contacto anónimo - $asunto";
$body = "Nombre: $nombre\n";
$body .= "Email: $email\n";
$body .= "IP: $ip\n";
$body .= "Asunto: $asunto\n";
$body .= "Mensaje:\n$mensaje\n";

$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

if (mail($destinatario, $subject, $body, $headers)) {
    header('Location: index.php?enviado=1'); // o mensajeenviado.html
} else {
    header('Location: contacto_anonimo.php?error=1');
}
exit;
?>