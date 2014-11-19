<?php 
		include("../include/conexion_bd.php");
	    include('../include/funciones_v2.php');
        f_verifica_sesion();
		
		header('<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />');
		header('<meta http-equiv="Expires" content="Tue, 01 Dec 1991 06:30:00 GMT">');
		
		
		$id_persona  = strtoupper($_GET['id_persona']);
		$id_persona  = str_replace(" ","%",$id_persona);
		$id_letra    = strtoupper($_GET['id_letra']);
	
	
		if ($id_persona!='' && $id_letra=='UNDEFINED' ){
			$sql = "
			SELECT id_grup  AS id_grup,
			       d_grupo  AS d_grupo,
				   COUNT(grupo) AS numgrupo 
		     FROM  ( SELECT pers_persona, pers_grupo grupo
			           FROM personas
					  UNION ALL
					 SELECT pins_persona,pins_grupo grupo
					   FROM contact_institutions
				   ) p, cat_grupos g
			 WHERE p.grupo  = g.id_grup
			   AND g.d_grupo LIKE '%$id_persona%'
			 GROUP BY id_grup";
			 
			$sql = "
			SELECT id_grup  AS id_grup,
				   d_grupo  AS d_grupo,
				   ( SELECT COUNT(grupo) ngrupo
					   FROM ( SELECT pers_persona, pers_grupo grupo
								FROM personas
							   UNION ALL
							  SELECT pins_persona,pins_grupo grupo
								FROM contact_institutions
							) p
					  WHERE p.grupo = id_grup          
					)      AS numgrupo
			   FROM cat_grupos
			  WHERE d_grupo LIKE '%$id_persona%'
			  ORDER BY d_grupo
			";
			$recursos=mysql_query($sql,$cn);
			$num=mysql_num_rows($recursos);
				
		}else{
			$sql = "
			SELECT id_grup  AS id_grup,
			       d_grupo  AS d_grupo,
				   COUNT(grupo) AS numgrupo 
		     FROM  ( SELECT pers_persona, pers_grupo grupo
			           FROM personas
					  UNION ALL
					 SELECT pins_persona,pins_grupo grupo
					   FROM contact_institutions
				   ) p, cat_grupos g
			 WHERE p.grupo  = g.id_grup
			   AND g.d_grupo LIKE '$id_letra%'
			 GROUP BY id_grup";
			 
			$sql = "
			SELECT id_grup  AS id_grup,
				   d_grupo  AS d_grupo,
				   ( SELECT COUNT(grupo)
					   FROM ( SELECT pers_persona, pers_grupo grupo
								FROM personas
							   UNION ALL
							  SELECT pins_persona,pins_grupo grupo
								FROM contact_institutions
							) p
					  WHERE p.grupo = id_grup          
					)       AS numgrupo
			   FROM cat_grupos
			  WHERE d_grupo LIKE '$id_letra%'
			  ORDER BY d_grupo
			";
			$recursos = mysql_query($sql,$cn);
			$num      = mysql_num_rows($recursos);
		}
	
?>	
<form name="form_links" method="GET" action="inicio.php" id="form_links" >
<table align="left" border="0" width="100%"  cellpadding="5" style="left:0px;top:0px;">
						<?php 
							if($num>0){
								$color='0';
								while ($arreglo=mysql_fetch_array($recursos) )
										{
											//$cont_result++;
								if($color==0){
									$bgcolor="#EEEEEE";
									$color='1';
								}else{
									$bgcolor="#FDE87F";
									$color='0';
								}
						?>
									<tr>
										 <td class="link_lista_directorio" id="<?php echo $arreglo['id_grup']; ?>" onclick="javascript:lista_nombresgrupos('reporte','<?php echo $arreglo['id_grup'];?>','<?php echo $arreglo['t_jerarquia1'];?>');marcaElSeleccionado('<?php echo $arreglo['id_grup']; ?>');"  bgcolor="<?php echo $bgcolor;?>" style="cursor:pointer;"><?php echo $arreglo['d_grupo'];?></td>
										 <td class="link_lista_directorio" style="color:red;" bgcolor="<?php echo $bgcolor;?>"> <?php echo $arreglo['numgrupo'];?></td>
									</tr>
						<?php	} 
							}else{?>
								<tr>
									 <td class="link_lista_mensaje">No se encontraron resultados</td>
								</tr>
						<?php }	?>
</table>
</form>