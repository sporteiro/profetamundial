<?php require_once('Connections/conexion.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_recordusuarios = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_recordusuarios = $_SESSION['MM_Username'];
}
mysql_select_db($database_conexion, $conexion);
$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$recordusuarios = mysql_query($query_recordusuarios, $conexion) or die(mysql_error());
$row_recordusuarios = mysql_fetch_assoc($recordusuarios);
$totalRows_recordusuarios = mysql_num_rows($recordusuarios);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reglas del juego</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
</head>

<body>
<div id="titulo"><img src="imagenes/profetamundial.png" width="310" height="103" alt="Profeta Mundial" /></div>
<div class="contenedora">
<div style="padding:10px;">
  <p><strong>Reglas de la Eurocopa:</strong></p>
  <p class="letraschicas">Usted, <?php echo $row_recordusuarios['nombre']; ?>, usuario de nombre <?php echo $row_recordusuarios['usuario']; ?>, al ingresar como usuario en Profeta Mundial  (profetamundial.com) , admite haber le&iacute;do, entendido y aceptado sin ning&uacute;n  tipo de excepci&oacute;n, las siguientes Reglas del Juego (en adelante, Reglas), as&iacute;  como sus posibles futuras modificaciones en el mismo momento en que ellas se  produjeren, y se declara responsable en caso de cualquier problema que surgiese  debido a cualquier tipo de malentendido relacionado con las Reglas mencionadas.  </p>
  <p class="letraschicas"><strong>GANADOR DEL JUEGO:</strong></p>
  <p class="letraschicas">El/la ganador/a o los/las ganadores/as del juego ser&aacute;n  aquellos usuarios que consigan mas puntos al termino de la Eurocopa Polonia Ucrania 2012. Para determinar los puntos de un usuario, se utilizaran  los criterios de puntuaci&oacute;n que se detallan en el Sistema de puntuaci&oacute;n.  </p>
  <p class="letraschicas"><strong>SISTEMA DE PUNTUACION:</strong></p>
  <p class="letraschicas">Se  entiende a partir de ahora como Resultado exacto, al n&uacute;mero  de goles que el local y el visitante tienen en ese partido siempre ligado a los  seleccionados correspondientes. Por ejemplo, el resultado exacto para el  partido Holanda-Alemania, tendr&iacute;a la forma: &quot;Holanda 0 Alemania 3&quot;;  de ninguna manera el Resultado exacto se refiere solamente al 0-3, como numero  de goles independiente de cualquier selecci&oacute;n (tener en cuenta para los  partidos de la segunda fase). <br />
    Por Resultado del partido, se entender&aacute; a partir de ahora, a  una de las tres variables posibles en un partido de futbol, es decir, a la  victoria local, la victoria visitante, o el empate. Para este resultado, se tendr&aacute;  en cuenta la posici&oacute;n izquierda o derecha en la misma l&iacute;nea de 2 equipos. Si el  equipo situado m&aacute;s a la izquierda tiene un n&uacute;mero de goles mayor que el que se  encuentra a su derecha, se tratara de una victoria local. Si el hecho es a la  inversa, ser&aacute; una victoria visitante, y si el n&uacute;mero de goles de ambos equipos  es el mismo, se tratara de un empate. &iexcl;IMPORTANTE! en la segunda ronda, el  Resultado del partido se refiere al resultado final de los 90 minutos de juego,  mas las adiciones y las prorrogas, si se produjeren; LA TANDA DE PENALES NO SE  TIENE EN CUENTA para el Resultado del partido, ni para el Resultado exacto. Es  decir que si un partido termina 0-0 en cuartos de final, tras los 90 minutos y  las prorrogas correspondientes, el Resultado exacto de este partido ser&aacute;  &quot;equipoA 0 equipoB 0&quot; y el Resultado del partido ser&aacute;  &quot;empate&quot;.<br />
    Por Resultado exacto real, se entiende a partir de ahora a  los equipos y sus respectivos goles en un partido determinado que se produzcan  en la Euro 2012 Polonia-Ucrania. Resultado real del partido ser&aacute;  la variante correspondiente a victoria local, victoria visitante o empate que  se produzca en la Euro 2012 Polonia-Ucrania.</p>
<p class="letraschicas">&nbsp;</p>
  <p class="letrasgrandes">FASE DE GRUPOS:</p>
  <p class="letraschicas">Se entiende que Fase de grupos se refiere a todos aquellos partidos disputados en forma de campeonato, en agrupaciones de cuatro selecciones, numeradas de la A a la D , que deben jugar entre si. Pasaran a la siguiente ronda los 2 primeros de cada grupo (en orden de puntos, diferencia de gol, goles a favor, orden alfabetico).</p>
<div>
<p class="letrasgrandesnaranjas"><b>&iexcl;IMPORTANTE!</b></p>
<p>El <a href="http://es.uefa.com/MultimediaFiles/Download/Regulations/competitions/Regulations/91/48/36/914836_DOWNLOAD.pdf">reglamento oficial de la Euro 2012 de la UEFA</a> <u>DIFIERE de este reglamento</u>,</p><p> en lo que se refiere a la resolucion de empates a puntos entre dos o mas equipos de un mismo grupo: <span class="letraschicas">(fragmento del reglamento Oficial)</span></p>
<div class="tablaclasificacion">
<i>
<p><b>Equality of points after the group matches </b></p>
<p>8.07 If two or more teams are equal on points on completion of the group matches, the 
following criteria are applied, in the order given; to determine the rankings:
<ul> 
<li>a) higher number of points obtained in the matches among the teams in question;</li> 
<li>b) superior goal difference in the matches among the teams in question (if more 
than two teams finish equal on points); </li>
<li>c) higher number of goals scored in the matches among the teams in question (if 
more than two teams finish equal on points); </li>
<li>d) superior goal difference in all the group matches; </li>
<li>e) higher number of goals scored in all the group matches; </li>
<li>f) position in the UEFA national team  coefficient ranking system (see Annex I, 
paragraph 1.2.2); </li>
<li>g) fair play conduct of the teams (final tournament); </li>
<li>h) drawing of lots. </li>
</ul>
8.08 If two teams which have the same number of points, the same number of goals 
scored and conceded play their last group match against each other and are still 
equal at the end of that match, the ranking of the two teams in question is 
determined by kicks from the penalty mark (Article 16), provided no other teams 
within the group have the same number of points on completion of all group 
matches. Should more than two teams have the same number of points, the criteria 
listed under paragraph 8.07 apply.  
</p>
</i>
</div>
<br />
 <p class="letraschicas">Los jugadores podran por este motivo, en caso de empates entre los 3 primeros, elegir a su voluntad a los dos equipos que quieren que pasen de grupo y el orden en el que lo hacen, o ponerse en contacto con el equipo de Profeta Mundial para aclarar dudas al respecto, a traves del formulario de Solucion de Problemas.</p>
</div>
  <p class="letraschicas"><strong>PUNTUACION PARA LA FASE DE GRUPOS:</strong></p>
  <table width="500" border="0" cellspacing="3" cellpadding="0" class="tablaclasificacion">
    <tr>
      <td><strong>Tipo de acierto:</strong></td>
      <td><strong>Puntos:</strong></td>
    </tr>
    <tr>
      <td class="letraschicas">Resultado exacto (goles que metio cada equipo)</td>
      <td class="letraschicas">5</td>
    </tr>
    <tr>
      <td class="letraschicas">Resultado del partido (Local, visitante o empate)</td>
      <td class="letraschicas">1</td>
    </tr>
  </table>
  <p class="letraschicas">Ejemplo: Si el Resultado exacto real del partido entre  Holanda y Alemania es:<br />
    Holanda 0 Alemania 2<br />
    Y el usuario introdujo en su pron&oacute;stico el resultado:<br />
    Holanda 0 Alemania 5<br />
    La puntuaci&oacute;n referente a este partido seria de 1 punto, por  acertar que el visitante fue quien gano.  </p>
  <p class="letraschicas">Ejemplo 2: Si el Resultado exacto real del partido entre  Holanda y Dinamarca es:<br />
    Holanda 3 Dinamarca 0<br />
    Y el usuario introdujo en su pron&oacute;stico el resultado:<br />
    Holanda 3 Dinamarca 0<br />
    La puntuaci&oacute;n referente a este partido seria de 5 puntos,  por acertar el Resultado exacto del partido. Esa seria la puntuaci&oacute;n TOTAL por  ese partido, NO se le otorgar&iacute;a un punto extra por acertar que el local es  quien gano, ya que se asume que al coincidir el Resultado exacto, tambi&eacute;n coincidir&aacute;  el Resultado del partido.</p>
<p class="letrasgrandes">SEGUNDA RONDA:</p>
<p class="letraschicas">Se entiende por Segunda Ronda, a la fase final del campeonato, (cuartos de final, las 2 semifinales y la final). Esta fase comenzar&aacute; con una serie de enfrentamientos de la que formaran parte los 2 primeros equipos clasificados de cada grupo,  en un orden determinado en una serie de partidos, de los cuales siempre uno de los 2 equipos resultara ganador y otro perdedor (cuartos). Los ganadores se enfrentaran entre si en otra serie de partidos (semifinales). Los ganadores de cada una de las 2 semifinales, jugaran la final. El ganador de la final sera el campe&oacute;n del torneo.</p>
  <table width="500" border="0" cellpadding="0" cellspacing="3" class="tablaclasificacion">
    <tr>
      <td><strong>Tipo de acierto:</strong></td>
      <td><strong>Puntos:</strong></td>
    </tr>
    <tr>
      <td class="letraschicas">Resultado exacto (goles que metio cada equipo)</td>
      <td class="letraschicas">5</td>
    </tr>
    <tr>
      <td class="letraschicas">Resultado del partido (Local, visitante, empate)</td>
      <td class="letraschicas">2</td>
    </tr>
  </table>
  <p class="letraschicas">Ejemplo: Si el Resultado exacto real del partido entre el  primero del Grupo A y el segundo del Grupo B:<br />
    Grecia 3 Dinamarca 0<br />
    Y el usuario introdujo en su pron&oacute;stico el resultado:<br />
    Grecia 1 Dinamarca 0<br />
    La puntuaci&oacute;n TOTAL referente a este partido seria de 2  puntos, por acertar que el local fue quien gano.  </p>
  <p class="letraschicas">Ejemplo: Si el Resultado exacto real del partido entre el  primero del Grupo B y el segundo del Grupo A:<br />
    Holanda 3 Rusia 0<br />
    Y el usuario introdujo en su pron&oacute;stico el resultado:<br />
    Holanda 0 Rusia 0<br />
    Pero eligi&oacute; adem&aacute;s que el equipo clasificado despu&eacute;s de ese  enfrentamiento fue Holanda, la puntuaci&oacute;n TOTAL referente a ese partido seria  de 0 puntos, porque el partido fue victoria local, y el resultado exacto no coincide. </p>
  <p class="letraschicas">Ejemplo: Si el Resultado exacto real del partido entre el  primero del Grupo D y el Segundo del C:<br />
Francia 3 Italia 0<br />
Y el usuario introdujo en su pron&oacute;stico sobre el primero del Grupo C y el Segundo del Grupo D:<br />Italia 0 Francia 3<br />
La puntuaci&oacute;n TOTAL referente a ese partido seria  de 0 puntos, porque el partido NO COINCIDE CON EL PARTIDO REAL</p>
  
  <p class="letraschicas">En caso de empates en semifinales, el usuario deber&aacute; preocupase de que los  Resultados exactos en los partidos de semifinales guarden relaci&oacute;n con los  posteriores equipos seleccionados para el partido de la final.</p>
<p class="letraschicas">&nbsp;</p>
  <p>EXTRAS:</p>

  <p class="letraschicas">Los extras son puntos que se deben sumar al total de la puntuaci&oacute;n de cada usuario INDEPENDIENTEMENTE de los puntos otorgados por los aciertos en cada partido.</p>
  <table width="630" border="0" cellpadding="0" cellspacing="3" class="tablaclasificacion">
    <tr>
      <td width="495"><strong>Tipo de acierto:</strong></td>
      <td width="61"><strong>Puntos:</strong></td>
    </tr>
    <tr>
      <td class="letraschicas">Equipo campeon</td>
      <td class="letraschicas">15</td>
    </tr>
    <tr>
      <td class="letraschicas">Goleador</td>
      <td class="letraschicas">10</td>
    </tr>
    <tr>
      <td class="letraschicas">Equipo que coincide en una fase (cuartos, semifinales, final)</td>
      <td class="letraschicas">1</td>
    </tr>
  </table>
  <p class="letraschicas">Independientemente de los puntos otorgados por los aciertos  descritos anteriormente, por cada selecci&oacute;n que dispute la fase en la que el usuario la incluyo (cuartos de final, semifinales, y partido de la final), este se llevara 1 punto, sea en el orden que sea, en el enfrentamiento que sea y contra la selecci&oacute;n que sea:</p>
  <p class="letraschicas">EJEMPLO: si el usuario incluyo en los cuartos de final a la seleccion de Alemania y en la Euro 2012 Polonia-Ucrania, Alemania clasifica para los cuartos de final como primero o segundo de su grupo, el usuario se llevara 1 punto por esa selecci&oacute;n.</p>
  <p class="letraschicas">El usuario que acierte el equipo campe&oacute;n del torneo,  sumara 15 puntos a su resultado final. De la misma forma, el usuario que  inscriba como goleador el apellido del jugador, o UNO DE LOS JUGADORES que se adjudique mas goles en la  Euro 2012 Polonia-Ucrania, incrementara su puntuaci&oacute;n en 10  unidades.</p>
  <p class="letraschicas">Ejemplo: Si el Resultado exacto real del partido de la final  es:<br />
    Alemania 1 Holanda 0 (campe&oacute;n Alemania)<br />
    Y el usuario inscribi&oacute; para dicho partido lo siguiente:<br />
    Alemania 1 Holanda 0 (campe&oacute;n Alemania)<br />
    Su puntuaci&oacute;n referente a este partido seria de: 5 puntos  por acertar el Resultado exacto MAS 15 puntos por acertar el campe&oacute;n</p>
  <p class="letraschicas">Ejemplo 2: Si el Resultado exacto real del partido de la final  es:<br />
    Alemania 1 Holanda 0 (campe&oacute;n Alemania)<br />
    Y el usuario inscribi&oacute; para dicho partido lo siguiente:<br />
    Alemania 0 Holanda 0 campe&oacute;n: Alemania<br />
    Su puntuaci&oacute;n referente a este partido seria de: 1 punto por  acertar el equipo ganador de la eliminatoria MAS 15 puntos por acertar el campe&oacute;n</p>
  <p class="letraschicas">Ejemplo 3: Si el Resultado exacto real del partido de la  final es:<br />
    Alemania 1 Holanda 0 (campe&oacute;n Alemania)<br />
    Y el usuario inscribi&oacute; para dicho partido lo siguiente:<br />
    Holanda 0 Alemania 1 (campe&oacute;n Alemania)<br />
    Su puntuaci&oacute;n referente a este partido seria SOLO de 15  puntos por acertar el campe&oacute;n, ya que el local y visitante no se corresponder&iacute;an  con los Resultados reales.</p>
<p class="letraschicas">&nbsp;</p>
  <p class="letraschicas"><strong>Fecha limite de participaci&oacute;n:</strong></p>
  <p class="letraschicas">El Miercoles 6 de Junio de 2012 a las 23:00 horas (GMT)  finalizara el plazo de admisi&oacute;n y/o modificaci&oacute;n para el juego. A partir de ese  momento, los usuarios ya registrados podr&aacute;n acceder a su cuenta, pero ya no  podr&aacute;n realizar modificaciones en la misma.</p>
<p class="letraschicas">&nbsp;</p>
  <p class="letraschicas">&nbsp;</p>
<p><a href="empezar.php" class="botones">VOLVER</a></p></div>
</div>
<div id="final" class="final">
Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com/favicon.ico"/><br />
Alojado en: <a href="http://www.000webhost.com/">000webhost.com</a></div>
</body>
</html>
