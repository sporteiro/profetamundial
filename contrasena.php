<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restituir contraseña - Profeta Mundial</title>
    <link href="estilo.css" rel="stylesheet" type="text/css">
    <link href="css/mundial2026.css" rel="stylesheet" type="text/css">
    <!-- Spry assets -->
    <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
    <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
    <script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>
<body class="login-body">
    <div class="login-card">
        <img src="imagenes/profetamundial.png" alt="Profeta Mundial" class="logo">
        <h2>Restituir Contraseña</h2>
        <form id="formcontacto" name="formcontacto" method="post" action="enviarmensaje.php">
            <div class="form-group">
                <span id="sprytextfield1">
                    <label for="usuario">Nombre de usuario</label>
                    <input name="usuario" type="text" id="usuario" />
                    <span class="textfieldRequiredMsg">Campo obligatorio</span>
                </span>
            </div>
            <div class="form-group">
                <span id="sprytextfield4">
                    <label for="email">Email</label>
                    <input name="email" type="text" id="email" />
                    <span class="textfieldRequiredMsg">Campo obligatorio</span>
                    <span class="textfieldInvalidFormatMsg">Tiene que ser un correo electrónico</span>
                </span>
            </div>
            <div class="form-group">
                <label for="mensaje">Comentario <span class="letraschicas">(Opcional)</span></label>
                <span id="sprytextarea1">
                    <textarea name="mensaje" id="mensaje" rows="5"></textarea>
                </span>
            </div>
            <input type="hidden" name="motivo" value="contrasena" />
            <input type="hidden" name="origen" value="Equipo" />
            <button type="submit" class="btn">Solicitar nueva contraseña</button>
        </form>
        <div class="link-footer">
            <p><a href="empezar.php" class="btn-contact-home">VOLVER</a></p>
        </div>
    </div>
    <script type="text/javascript">
        var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
        var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "email");
        var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:1, maxChars:38});
    </script>
</body>
</html>