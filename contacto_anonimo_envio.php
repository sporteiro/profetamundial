<?php
// contacto_anonimo_envio.php – Procesa el formulario de contacto anónimo con reCAPTCHA
require_once('recaptcha_config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contacto_anonimo.php');
    exit;
}

// Validar reCAPTCHA
$recaptcha = $_POST["g-recaptcha-response"] ?? '';
if (empty($recaptcha)) {
    die("Por favor, completa el captcha.");
}

$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = [
    'secret'   => $recaptcha_secret_key,
    'response' => $recaptcha,
    'remoteip' => $_SERVER['REMOTE_ADDR']
];
$options = [
    'http' => [
        'method'  => 'POST',
        'content' => http_build_query($data),
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n"
    ]
];
$context = stream_context_create($options);
$verify = file_get_contents($url, false, $context);
if ($verify === false) {
    die("Error al verificar el captcha. Intenta de nuevo.");
}
$captcha_success = json_decode($verify);
if (!$captcha_success->success) {
    die("Código de verificación incorrecto. Intenta de nuevo.");
}

// Validación básica del formulario
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$asunto = trim($_POST['asunto'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');
$ip = $_SERVER['REMOTE_ADDR'];

// Honeypot anti-spam
if (!empty($_POST['website'])) {
    header('Location: index.php');
    exit;
}

if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
    header('Location: contacto_anonimo.php?error=1');
    exit;
}

// Enviar correo al administrador
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
    header('Location: index.php?enviado=1');
} else {
    header('Location: contacto_anonimo.php?error=1');
}
exit;
?>