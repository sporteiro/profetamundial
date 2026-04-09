<?php
if (!isset($_SESSION)) {
  session_start();
}?> 
<div style="width: 100%; height: 100%; background-image:url(imagenes/fondousuario.png); position: fixed;">
<div style="margin:20%; padding: 30px; background-color: #063;">
Gracias por registrarte<br />
Para poder aceder a tu cuenta, es necesario que la actives desde tu correo electronico<br />
Si no encontras el correo, revisa tu bandeja de correo no deseado<br /><br /><br />
<a href="index.php" class="botoneschicos">cerrar </a>
</div>
</div><?php include_once('index.php');
