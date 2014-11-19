<?php 
include("../include/conexion_bd.php");

header('<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />');
header('<meta http-equiv="Expires" content="Tue, 01 Dec 1991 06:30:00 GMT">');
		
$id_eliminar=$_GET['ids'];

		$sql= "delete from tb_contactos where id ='$id_eliminar'"; 
		mysql_query($sql,$cn);
			
?>