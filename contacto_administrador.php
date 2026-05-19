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

// Obtener lista de usuarios (excepto el admin)
$qUsuarios = "SELECT usuario, nombre, email FROM usuarios WHERE email != '' AND usuario != 'ProfetaMundial' ORDER BY usuario";
$rUsuarios = mysqli_query($conexion, $qUsuarios) or die(mysqli_error($conexion));
$usuarios = [];
while ($u = mysqli_fetch_assoc($rUsuarios)) {
    $usuarios[] = $u;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Determinar si es envío masivo o individual
    $modoMasivo = isset($_POST['seleccionados']) && is_array($_POST['seleccionados']) && count($_POST['seleccionados']) > 0;
    $mensaje = trim($_POST['mensaje'] ?? '');

    if ($mensaje === '') {
        $error = 'El mensaje no puede estar vacío.';
    } else {
        $asunto = "Mensaje de Profeta Mundial";
        $cabeceras  = "MIME-Version: 1.0\r\n";
        $cabeceras .= "Content-type: text/html; charset=UTF-8\r\n";
        $cabeceras .= "From: equipo@profetamundial.com\r\n";
        $cabeceras .= "Reply-To: equipo@profetamundial.com\r\n";

        $destinatarios = [];

        if ($modoMasivo) {
            // Envío masivo: solo a los seleccionados
            foreach ($_POST['seleccionados'] as $usuario) {
                $usuarioEsc = mysqli_real_escape_string($conexion, $usuario);
                $q = "SELECT nombre, email FROM usuarios WHERE usuario = '$usuarioEsc'";
                $r = mysqli_query($conexion, $q);
                if ($row = mysqli_fetch_assoc($r)) {
                    $destinatarios[] = $row;
                }
            }
        } else {
            // Envío individual (fallback)
            $destinatario = trim($_POST['email'] ?? '');
            if ($destinatario === '') {
                $error = 'Debe seleccionar al menos un usuario o ingresar un email.';
            } elseif (!filter_var($destinatario, FILTER_VALIDATE_EMAIL)) {
                $error = 'El email ingresado no es válido.';
            } else {
                $destinatarios[] = ['nombre' => '', 'email' => $destinatario];
            }
        }

        if (empty($error)) {
            $mensajeEsc = nl2br(htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'));
            $enviados = 0;
            $fallos = 0;

            foreach ($destinatarios as $dest) {
                $nombre = $dest['nombre'] ? htmlspecialchars($dest['nombre']) : '';
                $saludo = $nombre ? "Hola, $nombre!" : "Hola,";
                
                $htmlMensaje = <<<EOD
                <div style="background-color:#0a0e17; padding:30px 20px; text-align:center; font-family:Arial, Helvetica, sans-serif;">
                    <a href="http://www.profetamundial.com">
                        <img src="http://www.profetamundial.com/imagenes/profetamundial.png" alt="Profeta Mundial" style="width:250px; margin-bottom:20px;">
                    </a>
                    <div style="background-color:#1e293b; color:#e2e8f0; border:1px solid #334155; border-radius:12px; max-width:500px; margin:0 auto; padding:25px; text-align:left;">
                        <h2 style="color:#22c55e; margin-top:0;">{$saludo}</h2>
                        <p style="line-height:1.5;">{$mensajeEsc}</p>
                        <p style="font-size:0.9rem; color:#94a3b8; margin-top:25px; border-top:1px solid #334155; padding-top:15px;">
                            <strong>IMPORTANTE:</strong> No respondas a este correo. Hacelo desde tu cuenta de usuario o escribiendo a 
                            <a href="mailto:equipo@profetamundial.com" style="color:#3b82f6;">equipo@profetamundial.com</a>.
                        </p>
                    </div>
                    <p style="color:#475569; font-size:0.75rem; margin-top:20px;">
                        Diseño y desarrollo del sitio: <a href="http://www.sebastianporteiro.com/" style="color:#64748b;">Sebastian Porteiro</a> 
                        <img src="http://www.sebastianporteiro.com/favicon.ico" style="vertical-align:middle;" />
                    </p>
                </div>
                EOD;

                if (mail($dest['email'], $asunto, $htmlMensaje, $cabeceras)) {
                    $enviados++;
                } else {
                    $fallos++;
                }
            }

            if ($fallos === 0) {
                $enviado = true;
            } else {
                $error = "Se enviaron $enviados correos, pero $fallos fallaron.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – Email masivos</title>
    <link href="estilo.css" rel="stylesheet" type="text/css">
    <link href="css/mundial2026.css" rel="stylesheet" type="text/css">
    <style>
        .user-list { max-height: 300px; overflow-y: auto; background: #0f172a; border-radius: 10px; padding: 10px; margin-bottom: 15px; text-align: left; }
        .user-list label { display: flex; align-items: center; gap: 8px; padding: 6px 0; color: #cbd5e1; }
        .user-list input[type="checkbox"] { margin: 0; }
        .section-title { color: #22c55e; margin-bottom: 10px; font-size: 1rem; }
        .inline-form { border-top: 1px solid #334155; padding-top: 15px; margin-top: 15px; }
        .toggle-all { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; color: #cbd5e1; }
    </style>
</head>
<body class="login-body">
    <div class="login-card" style="max-width: 600px;">
        <img src="imagenes/profetamundial.png" alt="Profeta Mundial" class="logo">
        <h2>Enviar Email masivos</h2>

        <?php if ($enviado): ?>
            <div class="mensaje-flotante success">Correos enviados correctamente.</div>
        <?php elseif ($error): ?>
            <div class="mensaje-flotante error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post" id="formMasivo">
            <!-- Listado de usuarios con checkboxes -->
            <div class="section-title">Seleccionar destinatarios</div>
            <div class="toggle-all">
                <input type="checkbox" id="selectAll">
                <label for="selectAll">Seleccionar / Deseleccionar todos</label>
            </div>
            <div class="user-list">
                <?php if (count($usuarios) > 0): ?>
                    <?php foreach ($usuarios as $u): ?>
                        <label>
                            <input type="checkbox" name="seleccionados[]" value="<?php echo htmlspecialchars($u['usuario']); ?>"
                                   <?php echo (isset($_POST['seleccionados']) && in_array($u['usuario'], $_POST['seleccionados'])) ? 'checked' : ''; ?>>
                            <span><?php echo htmlspecialchars($u['nombre']); ?> (<?php echo htmlspecialchars($u['email']); ?>)</span>
                        </label>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #94a3b8;">No hay usuarios con email registrado.</p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="mensaje">Mensaje (se enviará a cada usuario con un saludo personalizado)</label>
                <textarea name="mensaje" id="mensaje" rows="6" required
                          style="width:100%; padding:12px; border-radius:10px; border:1px solid #475569;
                                 background:#0f172a; color:#fff; font-size:1rem; box-sizing:border-box;
                                 font-family:inherit;"><?php echo isset($_POST['mensaje']) ? htmlspecialchars($_POST['mensaje']) : ''; ?></textarea>
            </div>

            <button type="submit" class="btn">Enviar a los seleccionados</button>

            <!-- Opción individual (secundaria) -->
            <div class="inline-form">
                <p style="color: #94a3b8; font-size: 0.9rem;">O enviar a un solo email:</p>
                <div class="form-group">
                    <label for="email">Email del destinatario</label>
                    <input type="email" name="email" id="email"
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                           placeholder="Solo si no seleccionaste usuarios arriba">
                </div>
            </div>
        </form>

        <div class="link-footer" style="margin-top:20px;">
            <a href="empezar.php">Volver al panel</a>
        </div>
    </div>

    <script>
    document.getElementById('selectAll').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('input[name="seleccionados[]"]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    });
    </script>
</body>
</html>