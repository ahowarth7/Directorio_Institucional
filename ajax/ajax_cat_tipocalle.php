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
            <th>ID</th>
            <th>CLASE CALLE</th>
            <th>CVE CALLE</th>
            <th>EDITAR</th>
            <th>ELIMINAR</th>
        </tr>
    </thead>
    <tbody id="tbody">
<?php
			$sqlcategoria="select * from cat_clase_calle order by d_clase_calle";
			$recurso=mysql_query($sqlcategoria,$cn);
			while ($aa=mysql_fetch_array($recurso) )
			{?>
			<tr>
                <th width="35%"><?php echo $aa['id_clase_calle'];?></th>
			    <td width="35%"><?php echo $aa['d_clase_calle'];?></td>
                <td width="35%"><?php echo $aa['cve_clase_calle'];?></td>
			    <td width="15%" align="center"><img src="../icons/2.png" width="16" height="16" alt="" /></td>
                <td width="15%" align="center"><img src="../icons/cross_48.png" width="16" height="16" alt="" /></td>
			</tr>
			<?php } ?>
</tbody>
</table>
</body>
</html>