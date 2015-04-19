<?php
//************************************************************
// ASIGNACION DE LAS VARIABLES SEGUN SERVIDOR  ***************
//************************************************************

 $tipo_host = "localhost";	  // Database server
 //$tipo_host = "servidor";

switch ($tipo_host)
{
   case "localhost":
            $database_server = "localhost";	
            $database_user = "root";			 // Database username
            $database_pass = "joenpaco"; //"mastiqr10";					 // Database password
            $database_name = "agenda";			 // Database name
            $maxlifetime = "3600";				 // Cookie max life time in seconds
        break;
     
	/*case "localhost":
            $database_server = "localhost";	
            $database_user = "root";			 // Database username
            $database_pass = "";					 // Database password
            $database_name = "contactos";			 // Database name
            $maxlifetime = "3600";				 // Cookie max life time in seconds
    break;	*/ 
	
   case "servidor":
            $database_server = "localhost";	 // Database server
            $database_user = "root";				    // Database username
            $database_pass = "mastiqr10";					 // Database password
            $database_name = "agenda";			       // Database name
            $maxlifetime = "";				 // Cookie max life time in seconds
    break;
}

//************************************************************
// CONEXION A LA BASE DE DATOS Y SELECION DE BASE DE DATOS
//************************************************************

$cn = @mysql_connect($database_server,$database_user,$database_pass) or die('No se pudo conectar: ' . mysql_error());

if(!$cn){
    echo "<div align='center' class='error'>NO A SE A PODIDO REALIZAR LA CONEXION CON EL SISTEMA</div>";
}elseif(!@mysql_select_db($database_name)){
    mysql_select_db('dbname') or die('No se pudo seleccionar la base de datos'); 
}

?>
