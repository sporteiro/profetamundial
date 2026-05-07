<?php
$mail = 'SEBLASH@GMAIL.COM';

$motivo = $_POST['motivo'] ?? '';
$usuario = $_POST['usuario'] ?? '';
$email = $_POST['email'] ?? '';
$mensaje = $_POST['mensaje'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'];
$origen = $_POST['origen'] ?? '';

$message = "
<html><body>
<div style='background-image:url(http://www.profetamundial.com/imagenes/fondo.jpg); background-repeat:repeat; text-align:center; background-color:#9C6;'>
<p><img src='http://www.profetamundial.com/imagenes/profetamundial.png' alt='Profeta Mundial' width='310' height='103' /></p>
<div style='background-color: #336600; color: #ffffff; border: 2px solid #ffffff; width: 500px; margin: 0pt auto; padding: 10px;'>
<p>Hola Administrador</p>
<p><b>Motivo del mensaje:</b> " . $motivo . "</p>
<p><b>Usuario que lo envio:</b> " . $usuario . "</p>
<p><b>Direccion de correo electronico:</b> " . $email . "</p>
<p><b>Mensaje:</b> " . $mensaje . "</p>
<p><b>Direccion IP:</b> " . $ip . "</p>
</div>
<p><br /> Dise&ntilde;o y desarrollo del sitio: <a href='http://www.sebastianporteiro.com/'>Sebastian Porteiro</a> <img src='http://www.sebastianporteiro.com/favicon.ico' alt='' /></p>
</div>
</body>
</html>";

$remitente = "MIME-Version: 1.0\r\n";
$remitente .= "Content-type: text/html; charset=iso-8859-1\r\n";
$remitente .= "From: $origen <equipo@profetamundial.com>";

$_SESSION['MM_Username'] = $usuario;

// Enviar correo de aviso al administrador (si falla, no importa)
@mail($mail, "PROFETAMUNDIAL.com", $message, $remitente);

if ($motivo == 'contrasena') {
    require_once('Connections/conexion.php');

    $aleatorio = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 105)), 6, 6);

    $LoginRS__query = "SELECT usuario, email FROM usuarios WHERE (usuario='" . mysqli_real_escape_string($conexion, $usuario) . "' AND email='" . mysqli_real_escape_string($conexion, $email) . "') AND activo='si'";
    $LoginRS = mysqli_query($conexion, $LoginRS__query) or die(mysqli_error($conexion));
    $loginFoundUser = mysqli_num_rows($LoginRS);

    if ($loginFoundUser > 0) {
        $update = "UPDATE usuarios SET contrasena='" . sha1($aleatorio) . "' WHERE usuario='" . mysqli_real_escape_string($conexion, $usuario) . "' AND email='" . mysqli_real_escape_string($conexion, $email) . "'";
        mysqli_query($conexion, $update) or die(mysqli_error($conexion));

        $message_user = "
        <div style='background-color: #9c6; text-align:center'>
        <p><a href='http://www.profetamundial.com'><img src='http://www.profetamundial.com/imagenes/profetamundial.png' alt='Profeta Mundial'></a></p>
        <div style='background-color:#360; color:#FFF; border:2px solid #FFF; width:500px; margin:0 auto; padding:10px;'>
        Hola " . $usuario . "<br />
        Hemos recibido un pedido de nueva contraseña.<br />
        Si se trata de un error, contacta con el equipo de desarrollo.<br /><br />
        Tu nueva contraseña es:<br />
        " . $aleatorio . "<br /><br />
        Por favor, cambiala en cuanto entres de nuevo en Profeta Mundial<br />
        <p>No olvides que las contrase&ntilde;as son sensibles de Mayusculas y minusculas</p>
        <p><strong>IMPORTANTE</strong>:</p>
        <p>No respondas a este correo. Hacelo desde tu cuenta de usuario o a esta direccion: <a href='mailto:equipo@profetamundial.com'>equipo@profetamundial.com</a></p>
        </div>
        <p><br />Diseño y desarrollo del sitio: <a href='http://www.sebastianporteiro.com/'>Sebastian Porteiro</a> <img src='http://www.sebastianporteiro.com/favicon.ico'/></p>
        </div>";
        $mail_user = $email;
        @mail($mail_user, "PROFETAMUNDIAL.com", $message_user, $remitente);
        header("Location: mensajenviado.php");
        exit;
    } else {
        // Usuario no encontrado o cuenta no activa
        $mail_admin_error = 'SEBLASH@GMAIL.COM';
        @mail($mail_admin_error, "PROFETAMUNDIAL.com - Usuario no existe", $message, $remitente);
        header("Location: usuarionoexiste.php");
        exit;
    }
} else {
    header("Location: mensajenviado.php");
    exit;
}
?>