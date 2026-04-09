<?php
if (!isset($_SESSION)) {
  session_start();
}?> 
<div style="width: 100%; height: 100%; background-image:url(imagenes/fondousuario.png); position: fixed;">
<div style="margin:20%; padding: 30px; background-color: #063;">
El captcha introducido no era correcto
<a href="registrarse.php" class="botoneschicos">Volver a intentarlo </a>
</div>
</div><?php include_once('registrarse.php');?>