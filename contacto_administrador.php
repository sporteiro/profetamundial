<?php
require_once('Connections/conexion.php');
session_start();

// Solo el administrador puede acceder
if (!isset($_SESSION['MM_Username']) || $_SESSION['MM_Username'] !== 'ProfetaMundial') {
    header('Location: index.php');
    exit;
}

$enviado = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $destinatario = trim($_POST['email'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if ($destinatario === '' || $mensaje === '') {
        $error = 'Todos los campos son obligatorios.';
    } elseif (!filter_var($destinatario, FILTER_VALIDATE_EMAIL)) {
        $error = 'El email ingresado no es válido.';
    } else {
        $asunto = "Mensaje de Profeta Mundial";
        $cabeceras = "From: equipo@profetamundial.com\r\n";
        $cabeceras .= "Reply-To: equipo@profetamundial.com\r\n";
        $cabeceras .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($destinatario, $asunto, $mensaje, $cabeceras)) {
            $enviado = true;
        } else {
            $error = 'Error al enviar el correo. Intentalo de nuevo.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – Contactar usuario</title>
    <link href="estilo.css" rel="stylesheet" type="text/css">
    <link href="css/mundial2026.css" rel="stylesheet" type="text/css">
</head>
<body class="login-body">
    <div class="login-card">
        <img src="imagenes/profetamundial.png" alt="Profeta Mundial" class="logo">
        <h2>Contactar usuario</h2>

        <?php if ($enviado): ?>
            <div class="mensaje-flotante success">Correo enviado correctamente.</div>
        <?php elseif ($error): ?>
            <div class="mensaje-flotante error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="email">Email del destinatario</label>
                <input type="email" name="email" id="email" required
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="mensaje">Mensaje</label>
                <textarea name="mensaje" id="mensaje" rows="6" required
                          style="width:100%; padding:12px; border-radius:10px; border:1px solid #475569;
                                 background:#0f172a; color:#fff; font-size:1rem; box-sizing:border-box;
                                 font-family:inherit;"><?php echo isset($_POST['mensaje']) ? htmlspecialchars($_POST['mensaje']) : ''; ?></textarea>
            </div>
            <button type="submit" class="btn">Enviar mensaje</button>
        </form>

        <div class="link-footer" style="margin-top:20px;">
            <a href="empezar.php">← Volver al panel</a>
        </div>
    </div>
</body>
</html>