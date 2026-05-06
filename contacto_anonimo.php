<?php
// contacto_anonimo.php – Formulario para usuarios sin login
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto – Profeta Mundial</title>
    <link href="estilo.css" rel="stylesheet" type="text/css">
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <style>
        /* Ajustes específicos para este formulario */
        .contact-card textarea {
            resize: vertical;
        }
        .g-recaptcha {
            display: flex;
            justify-content: center;
            margin: 15px 0;
        }
    </style>
</head>
<body class="login-body">
    <div class="login-card contact-card">
        <img src="imagenes/profetamundial.png" alt="Profeta Mundial" class="logo">
        <h2>Contacto</h2>
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
                <div class="g-recaptcha" data-sitekey="6LfdcFYUAAAAACTMMh-3MOPFBM6WaKEJ0NI7Khcu"></div>
            </div>

            <!-- Campo honeypot anti-spam (opcional, invisible) -->
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