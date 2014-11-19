<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
 <?php
include('../include/conexion_bd.php');
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="../csstg.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="Thierry Koblentz" />
<meta name="document-rights" content="Copyrighted Work" />
<meta name="Copyright" content="Copyright (c) TJKDesign.com, Thierry Koblentz" />
<link rel="stylesheet" type="text/css" href="../css/table_design.css">
</head>
<body>
<table id="table" cellspacing="1" width="100%">
    <thead>
        <tr>
            <th>FECHA REGISTRO</th>
            <th>HORA REGISTRO</th>
            <th>IP</th>
            <th>NOMBRE</th>
            <th>APELLIDO</th>
        </tr>
    </thead>
    <tbody id="tbody">
<?php
			$sqlcategoria="SELECT
tb_bitacoraacceso.id_bitacora,
tb_bitacoraacceso.fecha_registro,
tb_bitacoraacceso.hora,
tb_bitacoraacceso.ip,
tb_cuentas.nombre,
tb_cuentas.ap_paterno
FROM
tb_bitacoraacceso
left JOIN tb_cuentas ON tb_bitacoraacceso.id_usuario = tb_cuentas.id_usuario
order by tb_bitacoraacceso.id_bitacora desc";
			$recurso=mysql_query($sqlcategoria,$cn);
			while ($aa=mysql_fetch_array($recurso) )
			{?>
			<tr>
                <th width="20%"><?php echo $aa['fecha_registro'];?></th>
			    <td width="20%"><?php echo $aa['hora'];?></td>
                <td width="20%"><?php echo $aa['ip'];?></td>
                <td width="20%"><?php echo $aa['nombre'];?></td>
                <td width="20%"><?php echo $aa['ap_paterno'];?></td>
			</tr>
			<?php } ?>
</tbody>
</table>
</body>
</html>