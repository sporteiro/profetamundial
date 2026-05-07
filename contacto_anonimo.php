<?php
// contacto_anonimo.php – Formulario para usuarios sin login
require_once('recaptcha_config.php');

$mensaje = '';
$clase_mensaje = '';

if (isset($_GET['enviado'])) {
    $mensaje = 'Mensaje enviado correctamente. Te responderemos a la brevedad.';
    $clase_mensaje = 'success';
} elseif (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'captcha':
            $mensaje = 'El código de verificación no es correcto.';
            break;
        case 'datos':
            $mensaje = 'Por favor, completa todos los campos.';
            break;
        case 'mail':
            $mensaje = 'Error al enviar el mensaje. Intenta de nuevo más tarde.';
            break;
        default:
            $mensaje = 'Hubo un problema. Intenta de nuevo.';
    }
    $clase_mensaje = 'error';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto – Profeta Mundial</title>
    <link href="estilo.css" rel="stylesheet" type="text/css">
    <link href="css/mundial2026.css" rel="stylesheet" type="text/css">
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
</head>
<body class="login-body">
    <div class="login-card contact-card">
        <img src="imagenes/profetamundial.png" alt="Profeta Mundial" class="logo">
        <h2>Contacto</h2>

        <?php if ($mensaje): ?>
            <div class="mensaje-flotante <?php echo $clase_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="contacto_anonimo_envio.php">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="asunto">Asunto</label>
                <input type="text" name="asunto" id="asunto" required>
            </div>
            <div class="form-group">
                <label for="mensaje">Mensaje</label>
                <textarea name="mensaje" id="mensaje" rows="5" required></textarea>
            </div>

            <!-- reCAPTCHA -->
            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_site_key; ?>"></div>
            </div>

            <!-- Campo honeypot -->
            <div style="display:none;">
                <label for="website">Website</label>
                <input type="text" name="website" id="website">
            </div>

            <button type="submit" class="btn">Enviar mensaje</button>
        </form>
        <div class="link-footer">
            <a href="index.php">Volver al inicio</a>
        </div>
    </div>
</body>
</html>