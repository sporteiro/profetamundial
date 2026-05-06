<?php
require_once('Connections/conexion.php');

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }
        global $conexion;
        $theValue = mysqli_real_escape_string($conexion, $theValue);
        switch ($theType) {
            case "text":
                return ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            case "long":
            case "int":
                return ($theValue != "") ? intval($theValue) : "NULL";
            case "double":
                return ($theValue != "") ? doubleval($theValue) : "NULL";
            case "date":
                return ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            case "defined":
                return ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
        }
        return "NULL";
    }
}

$error_captcha = "";

if (isset($_POST["MM_insert"]) && $_POST["MM_insert"] == "formregistrarse") {

    // Validar reCAPTCHA
    $recaptcha = $_POST["g-recaptcha-response"] ?? '';
    if (empty($recaptcha)) {
        $error_captcha = "Por favor, completa el captcha.";
    } else {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret'   => '6LfdcFYUAAAAALRvVzEnzUccaJkyu7rjtoprB8Hh',
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
            $error_captcha = "Error al verificar el captcha. Intenta de nuevo.";
        } else {
            $captcha_success = json_decode($verify);
            if (!$captcha_success->success) {
                $error_captcha = "Código de verificación incorrecto. Intenta de nuevo.";
            }
        }
    }

    // Verificar si el usuario ya existe
    $loginUsername = trim($_POST['usuario']);
    $LoginRS__query = sprintf("SELECT usuario FROM usuarios WHERE usuario = %s", GetSQLValueString($loginUsername, "text"));
    $LoginRS = mysqli_query($conexion, $LoginRS__query) or die(mysqli_error($conexion));
    $loginFoundUser = mysqli_num_rows($LoginRS);

    if ($loginFoundUser) {
        header("Location: yaexiste.php?requsername=" . urlencode($loginUsername));
        exit;
    }

    // Validar que las contraseñas coincidan
    if ($_POST['contrasena'] !== $_POST['contrasena2']) {
        $error_captcha = "Las contraseñas no coinciden.";
    }

    // Si no hay errores, insertar usuario
    if (empty($error_captcha)) {
        $insertSQL = sprintf(
            "INSERT INTO usuarios (usuario, contrasena, nombre, email, puntos, ip, activo) VALUES (%s, %s, %s, %s, '0', %s, 'no')",
            GetSQLValueString($_POST['usuario'], "text"),
            GetSQLValueString(sha1($_POST['contrasena']), "text"),
            GetSQLValueString($_POST['nombre'], "text"),
            GetSQLValueString($_POST['email'], "text"),
            GetSQLValueString($_SERVER['REMOTE_ADDR'], "text")
        );
        mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));

        // Correo al administrador
        $mail_admin = 'SEBLASH@GMAIL.COM';
        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $origen = $_POST['origen'] ?? 'ProfetaMundial';
        $msg_admin = "usuario: $usuario\nnombre: $nombre\nemail: $email\nip: $ip";
        $headers_admin = "From: $origen\r\n";
        mail($mail_admin, "PROFETAMUNDIAL.com - Nuevo registro", $msg_admin, $headers_admin);

        // Correo al usuario (activación)
        $mail_user = $_POST['email'];
        $asunto = "Bienvenido a Profeta Mundial";
        $codigo_activacion = urlencode($usuario . "profeta" . $ip);
        $mensaje_html = "
        <html>
        <body>
        <div style='background-image:url(http://www.profetamundial.com/imagenes/fondo.jpg); background-repeat:repeat; text-align:center; background-color:#9C6;'>
        <p><img src='http://www.profetamundial.com/imagenes/profetamundial.png' alt='Profeta Mundial' width='310' height='103' /></p>
        <div style='background-color: #336600; color: #ffffff; border: 2px solid #ffffff; width: 500px; margin: 0pt auto; padding: 10px;'>
        <p>Bienvenido " . htmlspecialchars($nombre) . "</p>
        <p>Gracias por registrarte en Profeta Mundial</p>
        <p>Tus datos de acceso son:</p>
        usuario: " . htmlspecialchars($usuario) . "<br />
        contraseña: " . htmlspecialchars($_POST['contrasena']) . "<br />
        email: " . htmlspecialchars($email) . "<br />
        IP de registro: " . $ip . "<br />
        <p>Para ingresar, es necesario que actives tu cuenta</p>
        <p><a href='http://profetamundial.com/activarcuenta.php?codigo=$codigo_activacion'>ACTIVAR CUENTA AHORA</a></p>
        <p>Gracias por tu registro, ¡que te diviertas pronosticando!</p>
        </div>
        <p><br />Diseño y desarrollo del sitio: <a href='http://www.sebastianporteiro.com/'>Sebastian Porteiro</a> <img src='http://www.sebastianporteiro.com/favicon.ico' /></p>
        </div>
        </body>
        </html>";
        $headers_user = "MIME-Version: 1.0\r\n";
        $headers_user .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers_user .= "From: ProfetaMundial <equipo@profetamundial.com>\r\n";
        mail($mail_user, $asunto, $mensaje_html, $headers_user);

        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Profeta Mundial</title>
    <link href="estilo.css" rel="stylesheet" type="text/css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <style>
        /* Pequeños ajustes adicionales para los mensajes de error de HTML5 */
        input:invalid {
            border-color: #f87171 !important;
        }
        .error-message {
            color: #f87171;
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="register-body">
    <div class="register-card">
        <img src="imagenes/profetamundial.png" alt="Profeta Mundial" class="logo">
        <h2>Registrarse</h2>

        <?php if (!empty($error_captcha)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error_captcha); ?></p>
        <?php endif; ?>

        <form method="POST" action="" novalidate>
            <input name="origen" type="hidden" value="ProfetaMundial">
            <input type="hidden" name="MM_insert" value="formregistrarse">

            <div class="form-group">
                <label for="usuario">Nombre de usuario</label>
                <input type="text" name="usuario" id="usuario" required minlength="4" maxlength="18" pattern="[A-Za-z0-9_]+" title="Solo letras, números y guion bajo">
            </div>

            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" required minlength="6" maxlength="18">
            </div>

            <div class="form-group">
                <label for="contrasena2">Repetir contraseña</label>
                <input type="password" name="contrasena2" id="contrasena2" required>
            </div>

            <div class="form-group">
                <label for="nombre">Nombre real</label>
                <input type="text" name="nombre" id="nombre" required minlength="4" maxlength="30">
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="6LfdcFYUAAAAACTMMh-3MOPFBM6WaKEJ0NI7Khcu"></div>
            </div>

            <button type="submit" class="btn">Registrarse</button>

            <div class="link-footer">
                <p><a href="index.php">Ya soy un usuario registrado</a></p>
            </div>
        </form>
    </div>

    <!-- Validación simple de coincidencia de contraseñas (cliente) -->
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            var pass1 = document.getElementById('contrasena');
            var pass2 = document.getElementById('contrasena2');
            if (pass1.value !== pass2.value) {
                e.preventDefault();
                alert('Las contraseñas no coinciden.');
            }
        });
    </script>
</body>
</html>