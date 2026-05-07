<?php
require_once('Connections/conexion.php');
// No es necesario consultar base de datos, solo mostrar mensaje
?>
<?php require_once('header.php'); ?>

<div class="modern-card welcome-card" style="text-align: center; max-width: 600px; margin: 40px auto;">
    <h2>¡MENSAJE ENVIADO!</h2>
    <p>Esperamos poder solucionar tu problema lo mas rapido posible.</p>
    <p>La respuesta a tu mensaje va a ser enviada al email que nos proporcionaste.</p>
    <p>Por las dudas, no te olvides de revisar la casilla de spam de tu servidor de correo electrónico.</p>
    <p>¡Gracias por participar en Profeta Mundial!</p>
    <div style="margin-top: 20px;">
        <a href="empezar.php" class="btn-small">Volver a mi cuenta</a>
    </div>
</div>

<?php require_once('footer.php'); ?>