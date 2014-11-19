<?php
$_nivel='../';
session_name("contacto");
session_start();
 session_unset();
     session_destroy();

// ENCABEZADO
//include("../includes/header.php");
// *****  INICIO CONTENIDO ************************************************


include($_nivel."login/login_form.php");


?>