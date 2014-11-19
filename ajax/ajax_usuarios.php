<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us">
<head>
 <?php
include('../include/funciones_v2.php');
include('../include/conexion_bd.php');
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="Thierry Koblentz" />
<meta name="document-rights" content="Copyrighted Work" />
<meta name="Copyright" content="Copyright (c) TJKDesign.com, Thierry Koblentz" />
<style>
  /* tables */
table.tablesorter {
	font-family:arial;
	background-color: #CDCDCD;
	margin:10px 0pt 15px;
	font-size: 11pt;
	width: 100%;
	text-align: left;
}
table.tablesorter thead tr th, table.tablesorter tfoot tr th {
	background-color: #585858;
    color: #ffffff;
	border: 1px solid #ff;
	font-size: 8pt;
	padding: 4px;
    text-align: center;
}
.titulorojo{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #ffffff;
	text-shadow: 1px 1px 1px #000;
	background-color:#910000;
}
.tituloverde{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #ffffff;
	text-shadow: 1px 1px 1px #000;
	background-color:#339900;
}
</style>
</head>
<Body>
<table class="tablesorter" cellspacing="1">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>A. Paterno</th>
            <th>Usuario</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>

			<?php

			$sqlcategoria="select * from tb_cuentas order by nombre";
			//$sqlcategoria="select count(usuario) as num,usuario,visible,nombre,username,ap_paterno,id_tipo from tb_contactos inner join tb_cuentas on tb_cuentas.id_usuario=tb_contactos.usuario where tb_contactos.visible='1' group by nombre";
			$recurso=mysql_query($sqlcategoria,$cn);

			while ($bb=mysql_fetch_array($recurso) )
			{
				$usuario=$bb['id_usuario'];
				 if($bb['id_tipo']!=0){
				 	$status="Activo";
				 	$titulo="tituloverde";
				 }else{
				 	$status="No Activo";
				 	$titulo="titulorojo";
				 }
				 $sqlcategoria="select count(usuario) as num,usuario from tb_contactos where usuario='$usuario' order by nombre";
				//$sqlcategoria="select count(usuario) as num,usuario,visible,nombre,username,ap_paterno,id_tipo from tb_contactos inner join tb_cuentas on tb_cuentas.id_usuario=tb_contactos.usuario where tb_contactos.visible='1' group by nombre";
				$recurso11=mysql_query($sqlcategoria,$cn);
				$aa=mysql_fetch_array($recurso11)
			?>
			<tr>
			    <td width="25%"  class="<?php echo $titulo;?>" align="left"><?php echo utf8_encode($bb['nombre']);?></td>
			    <td width="25%"  class="<?php echo $titulo;?>" align="left"><?php echo utf8_encode($bb['ap_paterno']);?></td>
			    <td width="25%"  class="<?php echo $titulo;?>" align="CENTER"><?php echo $bb['username'];?></td>
			    <td width="25%" style="cursor:pointer;"  class="<?php echo $titulo;?>" align="CENTER" onclick="javascript:activarusuario('c','<?php echo $bb['id_usuario'];?>');"><?php echo $status;?></td>
			</tr>
			<?php
			 }?>
</tbody>
</table>
</Body>