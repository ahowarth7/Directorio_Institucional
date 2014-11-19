<?php
$_nivel='../';
// ENCABEZADO
include("encabezado.php");
include ("../include/conexion_bd.php");
include("../include/funciones_v2.php");

// *****  INICIO CONTENIDO ************************************************
?>


<title>IQM - DIRECTORIO INSTITUCIONAL</title>
<P>
<span class="texto_simple">Validando sus Datos espere por favor... <img src="../imagenes/cargando_3.gif"  ></span><SPAN CLASS='texto_simple'>
<P class="texto_simple">
  Si no entra en 5 segundos, <A HREF="<?php echo ("../index.php"); ?>">presione aqui</a>.
</SPAN>

<?php
include ("valida_user.php"); 

?>
<META HTTP-EQUIV=Refresh CONTENT="3; URL=<? echo "inicio.php"; ?>">

