<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Catalogo de Grupos</title>
<script language="javascript" type="text/javascript" src="../codebase/ajax.js"></script>
<?php 
	include('../include/funciones_v2.php');
	include('../include/conexion_bd.php');
?>

<style>
html, body 
{
	top:0;left: 0;
	font: 11px/1.4 Tahoma, Arial, Helvetica, sans-serif;
	
}
				

.titulo{
	font-family:  Tahoma, Arial, Helvetica, sans-serif;
	font-size: 14px;
    font-weight: bold;
    color: #e11c23;
    text-shadow: 1px 1px 1px #ccc;
}

.cont{
	font-family:  Tahoma, Arial, Helvetica, sans-serif;
	font-size: 12px;
    font-weight: normal;
    color: #044a72;
}

H1 { word-spacing: 1em }


</style>
</head>
<body leftmargin="0" topmargin="0" >

<form name="frm-categ" method="POST" id="frm-categ" action="../reports/process.php" >
    <input type="hidden" name="doaction" value="categorias.getReport" />
    <input type="button" value="Imprimir catálogo" onClick="document.getElementById('frm-categ').submit();" />
<p>

<table border="0" width="100%">	
			<?php 
			$sqlcategoria="select id_categoria,d_categoria from cat_categorias";
			$recurso=mysql_query($sqlcategoria,$cn);
			
			
			
			
			while ($bb=mysql_fetch_array($recurso) )	
			{
					$cat=$bb['id_categoria'];
					$sqlgrupos="
					SELECT id_categoria,
					       d_categoria, 
						   id_cat , 
						   id_grup,d_grupo,       
						   ( SELECT COUNT(*) 
						       FROM vpersonas
							  WHERE pers_grupo = id_grup 
							  GROUP BY pers_grupo 
						   ) num
					  FROM cat_categorias , cat_grupos 
					 WHERE id_categoria = id_cat 
					  AND id_cat = '$cat'";
					  
					$rgrupos=mysql_query($sqlgrupos,$cn);
					$numcat = mysql_num_rows($rgrupos);
				
				?>
				<tr>	
				    <td class="titulo" align="left" valign="top" colspan="2"><?php echo $bb['d_categoria']." (".$numcat.")";?><hr></td>
				</tr>
					<?php 
					
					
					while ($gg=mysql_fetch_array($rgrupos) ){
					$grupo=$gg['id_grup'];
					$nom_grup=$gg['d_grupo'];
					$num = $gg['num'];
					
					if(!$num) $num=0;
					
									
						?>
						<tr>
							<td width="20px">&nbsp;</td>	
				    		<td class="cont" align="left" valign="top">&nbsp;<?php echo $nom_grup." (<b>".$num."</b>)";?></td>
						</tr>
						
					<?php }
				
				echo '<tr> <td>&nbsp;</td></tr>';
			
				
			 }?>
</table>
</form>
</body>
</html>