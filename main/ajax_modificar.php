<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="es">


<head>





<?php
include("../include/conexion_bd.php");
include("../include/funciones_v2.php");
header('<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />');
header('<meta http-equiv="Expires" content="Tue, 01 Dec 1991 06:30:00 GMT">');
?>

<script src="../codebase/dhtmlxcommon.js"></script>
<script src="../codebase/dhtmlxcombo.js"></script>  
<link rel="STYLESHEET" type="text/css" href="../codebase/dhtmlxcombo.css"> 
<script language="javascript" type="text/javascript" src="../codebase/ajax.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



<style>
.link_lista_directorio{
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	font-weight: bold;
	text-tranform: uppercase;
	color:#3f3f3f;
	text-decoration:underline;
	list-style-type:none;
	vertical-align:bottom;
	cursor:pointer;
	
}
	
.link_lista_mensaje{
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	font-weight: bold;
	text-tranform: uppercase;
	color:#3f3f3f;
	text-decoration:underline;
	list-style-type:none;
	vertical-align:bottom;
}

</style>


</head>

</body>

<?php
//f_verifica_sesion();
//session_start();

//f_imprime_arreglo($_GET);

$evento = $_GET['opcion'];


if (isset($_GET['municipio']))
$id_municipio = $_GET['municipio'];

if (isset($_GET['id_categoria']))
$id_categoria = $_GET['id_categoria'];

$ordenar='';



   switch ($evento)
{
	case 1:
      $qrySLocalidad="select id_localidad,cve_localidad,id_municipio_inegi,id_municipio_ieqroo,d_localidad from cat_localidad 
                     inner join cat_municipios on id_municipio = id_municipio_inegi
                     where id_municipio_ieqroo = '1'  and d_localidad != '' order by d_localidad ASC";

      $rdsSLocalidad= mysql_query($qrySLocalidad,$cn);
      
      f_type_combobox("sel_localidad",$rdsSLocalidad,"Seleccionar...",'d_localidad','id_localidad',"$id_localidad","","","",""); 
    break;

    case 2:
    	if ($id_categoria=="LIDERES"){
    		
		?>	
     	<tr>
			    <td >
					<?php 
      				$qrySgrupos="select * from tb_grupos where d_categoria='$id_categoria' order by d_grupo ASC";
      				$qrySgrupos=mysql_query($qrySgrupos,$cn);
				    f_type_combobox('id_grupo',$qrySgrupos,'','d_grupo','d_grupo',"$grupo",'','',$ver,'','430px');
				    ?>
				</td>
   		</tr>
   		<tr>
			    <td bgcolor="#EEEEEE" width="130px" <?php echo $ver;?>>* NIVEL DE LIDERAZGO: </td>
			    <td> 
			    	<select name="id_liderazgo">
			    		<option></option>
			    		<option>EXCELENTE</option>
			    		<option>MUY BUENO</option>
			    		<option>NORMAL</option>
			    	</select>
			     </td>
		</tr>
    <?php }else{
    	
      				$qrySgrupos="select * from tb_grupos where d_categoria='$id_categoria' order by d_grupo ASC";
      				$qrySgrupos=mysql_query($qrySgrupos,$cn);
				    f_type_combobox('id_grupo',$qrySgrupos,'','d_grupo','d_grupo',"$grupo",'','',$ver,'','430px');
				    
    }
    break;

	case 3: // ELIMINAR//
	     $id_eliminar=$_GET['ids'];
		echo $sql= "update tb_contactos set visible='0' where id ='$id_eliminar'"; 
		mysql_query($sql,$cn);
	
	break;
	
	case 4: // reporte categoria//?>
	   <table align="center" border="0" width="90%" style="display:block">
			<tr>
				<td colspan="2"><h2>REPORTE POR CATEGORIA</h2><br></td>
			</tr>
			<tr>
	 			<td bgcolor="#EEEEEE" width="130px">CATEGORIA </td>
				<td> 
					<?php
					if ($_GET['operacion']==3){
					$clasificacion=$aa['trabajo_categoria'];
					}else{
				      				$grupo='';
				      			}
					$sql10='select * from tb_grupos group by d_categoria order by d_categoria ASC';
					$conexion10=mysql_query($sql10,$cn);
					f_type_combobox('id_categoria',$conexion10,'-','d_categoria','d_categoria',"$clasificacion",'',"OnChange=javascript:cargar_grupos('grupos','id_categoria');",$ver,'','430px');
					?>
				</td>
			</tr>
		</table>
	
	<?php break;
	
	case 5: // reporte grupo//?>
	   <table align="center" border="0" width="90%" style="display:block">
			<tr>
				<td colspan="2"><h2>REPORTE POR CATEGORIA</h2><br></td>
			</tr>
			<tr>
	 			<td bgcolor="#EEEEEE" width="130px">CATEGORIA</td>
				<td> 
					<?php
					if ($_GET['operacion']==3){
					$clasificacion=$aa['trabajo_categoria'];
					}else{
				      				$grupo='';
				      			}
					$sql10='select * from tb_grupos group by d_categoria order by d_categoria ASC';
					$conexion10=mysql_query($sql10,$cn);
					f_type_combobox('id_categoria',$conexion10,'-','d_categoria','d_categoria',"$clasificacion",'',"OnChange=javascript:cargar_grupos('grupos','id_categoria');",$ver,'','430px');
					?>
				</td>
			</tr>
			<tr>		
				<td bgcolor="#EEEEEE" width="130px">GRUPOS</td>
				<td >
					 <div id="grupos"> </div> 
				</td>
			</tr>
		</table>
	<?php break;
	
	case 6: // reporte dependencia//?>
	   <table align="center" border="0" width="90%" style="display:block">
			<tr>
				<td colspan="2"><h2>REPORTE POR DEPENDENCIAS</h2><br></td>
			</tr>
			<tr>
				 <td bgcolor="#EEEEEE" width="130px">DEPENDENCIA</td>
						<td> 
							<?php
							if ($_GET['operacion']==3){
							$clasificacion=$aa['trabajo_dependencia'];
							}else{
						      				$grupo='';
						      			}
							$sql10='select trabajo_dependencia from tb_contactos group by trabajo_dependencia order by trabajo_dependencia ASC';
							$conexion10=mysql_query($sql10,$cn);
							f_type_combobox('id_dependencia',$conexion10,'-','trabajo_dependencia','trabajo_dependencia',"$clasificacion",'','',$ver,'','500px');
							?>
				</td>
			</tr>
		</table>
	<?php break;
	
	
	case 7: // reporte dependencia//?>
	   <table align="center" border="0" width="90%" style="display:block">
			<tr>
				<td colspan="2"><h2>REPORTE POR DEPENDENCIAS</h2><br></td>
			</tr>
			<tr>
				 <td bgcolor="#EEEEEE" width="130px">DEPENDENCIA</td>
						<td> 
							<?php
							if ($_GET['operacion']==3){
							$clasificacion=$aa['trabajo_dependencia'];
							}else{
						      				$grupo='';
						      			}
							$sql10='select trabajo_dependencia from tb_contactos group by trabajo_dependencia order by trabajo_dependencia ASC';
							$conexion10=mysql_query($sql10,$cn);
							f_type_combobox('id_dependencia',$conexion10,'-','trabajo_dependencia','trabajo_dependencia',"$clasificacion",'','',$ver,'','500px');
							?>
				</td>
			</tr>
		</table>
	<?php break;
	
	
case 8: //////////////////////////////// GENERAL   ////////////////////////////////////////////
	  $id_buscar=strtoupper($_GET['id_que']);
	  $id_donde=strtoupper($_GET['id_donde']);
	  
	  if ($id_buscar!=''){
		$condicion="where ( (CONCAT(personal_nombre, ' ' , personal_paterno,' ',personal_materno)  LIKE '%$id_buscar%') or (trabajo_cargo LIKE '$id_buscar%') or  (trabajo_dependencia LIKE '$id_buscar%' ) )";
		} 	
	 if ($id_donde!=''){
		$condicion2="and ( (direccion_ciudad LIKE '%$id_donde%') or (direccion_municipio LIKE '%$donde%') or  (direccion_estado LIKE '%$donde%' ) )";
		} 		
	  
	  
		
		$sql=("select COUNT(personal_nombre) as numero,personal_nombre, personal_paterno,personal_materno,trabajo_cargo,trabajo_dependencia,trabajo_grupo,direccion_ciudad,direccion_municipio,direccion_estado from tb_contactos  $condicion $condicion2 group by trabajo_grupo order by trabajo_grupo ASC");
		$recursos=mysql_query($sql,$cn);
		

	?>
	   <table align="center" border="0" width="100%" style="display:block">
	<?php 
		while ($arreglo=mysql_fetch_array($recursos) )
				{
	?>
			<tr>
				 <td bgcolor="#EEEEEE"><a href="" onclick="javascript:links_grupos('reporte','<?php echo $arreglo['trabajo_grupo'];?>','<?php echo $id_persona;?>');" class="link_lista_directorio"><?php echo $arreglo['trabajo_grupo']."  (".$arreglo['numero'].")";?></a></td>
			</tr>
	<?php	} ?>
		</table>


	<?php break;
		

case 9: //////////////////////////////// BUSCAR PERSONAS  ////////////////////////////////////////////
$id_persona=strtoupper($_GET['id_persona']);
	$id_persona = str_replace(" ","%",$id_persona);
	$id_letra=strtoupper($_GET['id_letra']);
	
	
if ($id_persona=='' ){
			////////////////////////////   no Contiene nombre y presiono sobre una letra   //////////////////////////////////////
			if($id_letra!='UNDEFINED' ){
					
					$condicion="and concat_ws(' ',personal_nombre,personal_paterno,personal_materno) like '$id_letra%'";
					$sql=("select count(id) as numero, id,concat_ws(' ',personal_nombre,personal_paterno,personal_materno) as nombre,contac.trabajo_idgrupo,contac.visible, grup.id_cat_grup,grup.d_grupo
					from tb_contactos contac left join tb_grupos grup on grup.id_cat_grup =  contac.trabajo_idgrupo 
					where contac.visible='1' $condicion group by nombre order by nombre ASC");
					$recursos=mysql_query($sql,$cn);
					
					?>
					
					<form name="form_nombres" method="GET" action="inicio.php" id="form_nombres" >
					<table align="left" border="0" width="100%"  cellpadding="5" style="left:0px;top:0px;">
						<?php 
							$cont_result=0;
								while ($arreglo=mysql_fetch_array($recursos) )
										{
											$cont_result++;
						?>
									<tr>
										 <td class="link_lista_directorio" valign="top" onclick="javascript:lista_nombre('reporte','<?php echo $arreglo['id'];?>');"  bgcolor="#EEEEEE" style="cursor:pointer;"><?php echo $arreglo['nombre'];?></td>
										 <td class="link_lista_directorio" style="color:red;" bgcolor="#EEEEEE"> <?php echo $arreglo['numero'];?></td>
									</tr>
						<?php	} 
								
							if($cont_result==0)
							{
						?>
								<tr>
									 <td class="link_lista_mensaje"  valign="top" >No se encontraron resultados</td>
								</tr>
						<?php }	?>
					</table>
					</form>
					
					
			<?php
			///// else if letra//////
			}else{
					
				
					
			}	
				
}else{
		////////////////////////////   Contiene nombre y presiono sobre una letra   //////////////////////////////////////
			if($id_letra!='UNDEFINED' ){
					
				
					$condicion="and concat_ws(' ',personal_nombre,personal_paterno,personal_materno) like '$id_letra%'";
					$sql=("select count(id) as numero, id,concat_ws(' ',personal_nombre,personal_paterno,personal_materno) as nombre,contac.trabajo_idgrupo,contac.visible, grup.id_cat_grup,grup.d_grupo
					from tb_contactos contac left join tb_grupos grup on grup.id_cat_grup =  contac.trabajo_idgrupo 
					where contac.visible='1' $condicion group by nombre order by nombre ASC");
					$recursos=mysql_query($sql,$cn);
					
					?>
					
					<form name="form_nombres" method="GET" action="inicio.php" id="form_nombres" >
					<table align="left" border="0" width="100%"  cellpadding="5" style="left:0px;top:0px;">
						<?php 
							$cont_result=0;
								while ($arreglo=mysql_fetch_array($recursos) )
										{
											$cont_result++;
						?>
									<tr>
										 <td class="link_lista_directorio" valign="top" onclick="javascript:lista_nombre('reporte','<?php echo $arreglo['id'];?>');"  bgcolor="#EEEEEE" style="cursor:pointer;"><?php echo $arreglo['nombre'];?></td>
										 <td class="link_lista_directorio" style="color:red;" bgcolor="#EEEEEE"> <?php echo $arreglo['numero'];?></td>
									</tr>
						<?php	} 
								
							if($cont_result==0)
							{
						?>
								<tr>
									 <td class="link_lista_mensaje"  valign="top" >No se encontraron resultados</td>
								</tr>
						<?php }	?>
					</table>
					</form>
				<?php
					
				
					
				}else{ ////////////////////////////   buscar   //////////////////////////////////////
					
					$condicion2="and concat_ws(' ',contac.personal_nombre,contac.personal_paterno,contac.personal_materno) like '%$id_persona%'";
					$sql=("select count(id) as numero,contac.id, COUNT(contac.personal_nombre)as numero, contac.personal_nombre,contac.personal_paterno,contac.personal_materno,contac.trabajo_idgrupo,contac.visible, grup.id_cat_grup,grup.d_grupo
					from tb_contactos contac left join tb_grupos grup on grup.id_cat_grup =  contac.trabajo_idgrupo 
					where contac.visible='1' $condicion $condicion2 group by grup.d_grupo order by grup.d_grupo ASC");
					$recursos=mysql_query($sql,$cn);
					?>	
	
	
					<form name="form_links" method="GET" action="inicio.php" id="form_links" >
					<table align="left" border="0" width="100%"  cellpadding="5" style="left:0px;top:0px;">
						<?php 
							$cont_result=0;
								while ($arreglo=mysql_fetch_array($recursos) )
										{
											$cont_result++;
						?>
									<tr>
										 <td class="link_lista_directorio" valign="top" onclick="javascript:links_grupos('reporte','<?php echo $arreglo['trabajo_idgrupo'];?>','<?php echo $id_persona;?>','<?php echo $id_letra;?>','1');"  bgcolor="#EEEEEE" style="cursor:pointer;"><?php echo $arreglo['d_grupo'];?></td>
										 <td class="link_lista_directorio" style="color:red;" bgcolor="#EEEEEE"> <?php echo $arreglo['numero'];?></td>
									</tr>
						<?php	} 
								
							if($cont_result==0)
							{
						?>
								<tr>
									 <td class="link_lista_mensaje"  valign="top" >No se encontraron resultados</td>
								</tr>
						<?php }	?>
					</table>
					</form>
				<?php
				}	
				
	}
break;
case 10: //////////////////////////////// BUSCAR GRUPOS ////////////////////////////////////////////
	$id_grupo=strtoupper($_GET['id_grupo']);
	$id_letra=strtoupper($_GET['id_letra']);

	//f_imprime_arreglo($_GET);
			
		
	
	
if ($id_grupo=='' ){
		if($id_letra!='UNDEFINED' ){
					$condicion='';
					$condicion2="and d_grupo  like '$id_letra%'";
				
					$sql=(" select COUNT(gp.d_grupo) as numero,trabajo_idgrupo,d_grupo,visible from tb_contactos 
					    inner join tb_grupos gp on gp.id_cat_grup=trabajo_idgrupo
					    where visible='1' $condicion $condicion2 group by gp.d_grupo order by gp.d_grupo ASC");
						$recursos=mysql_query($sql,$cn);
					?>
					<form name="form_links" method="GET" action="inicio.php" id="form_links" >
					<table align="center" border="0" width="100%"  cellpadding="5" style="display:block">
					<?php $cont_result=0;
						while ($arreglo=mysql_fetch_array($recursos) )
								{
					       $cont_result++;
					?>
							<tr>
								 <td class="link_lista_directorio"  valign="top" onclick="javascript:links_grupos('reporte','<?php echo $arreglo['trabajo_idgrupo'];?>','','<?php echo $id_letra;?>','2');"  bgcolor="#EEEEEE" style="cursor:pointer;"><font style="cursor: pointer crosshair;""><?php echo $arreglo['d_grupo']."  (".$arreglo['numero'].")";?></font></td>
							</tr>
					<?php	} 
					
					if($cont_result==0)
					{
						?>
						<tr>
							 <td class="link_lista_mensaje"  valign="top" >No se encontraron resultados</td>
						</tr>
					<?php	} ?>
					</table>
					</form>
			<?php }else{
					//nada sucede				
					}
}else{
				if($id_letra!='UNDEFINED' ){
				$condicion="and d_grupo like '$id_letra%'";
				$sql=(" select COUNT(gp.d_grupo) as numero,trabajo_idgrupo,d_grupo,visible from tb_contactos 
					    inner join tb_grupos gp on gp.id_cat_grup=trabajo_idgrupo
					    where visible='1' $condicion $condicion2 group by gp.d_grupo order by gp.d_grupo ASC");
						$recursos=mysql_query($sql,$cn);
					?>
					<form name="form_links" method="GET" action="inicio.php" id="form_links" >
					<table align="center" border="0" width="100%"  cellpadding="5" style="display:block">
					<?php $cont_result=0;
						while ($arreglo=mysql_fetch_array($recursos) )
								{
					       $cont_result++;
					?>
							<tr>
								 <td class="link_lista_directorio"  valign="top" onclick="javascript:links_grupos('reporte','<?php echo $arreglo['trabajo_idgrupo'];?>','','<?php echo $id_letra;?>','2');"  bgcolor="#EEEEEE" style="cursor:pointer;"><font style="cursor: pointer crosshair;""><?php echo $arreglo['d_grupo']."  (".$arreglo['numero'].")";?></font></td>
							</tr>
					<?php	} 
					
					if($cont_result==0)
					{
						?>
						<tr>
							 <td class="link_lista_mensaje"  valign="top" >No se encontraron resultados</td>
						</tr>
					<?php	} ?>
					</table>
					</form>
		<?php 
				}else{
					
				}
				$condicion="and d_grupo  like '%$id_grupo%'";
				$sql=(" select COUNT(gp.d_grupo) as numero,trabajo_idgrupo,d_grupo,visible from tb_contactos 
					    inner join tb_grupos gp on gp.id_cat_grup=trabajo_idgrupo
					    where visible='1' $condicion $condicion2 group by gp.d_grupo order by gp.d_grupo ASC");
						$recursos=mysql_query($sql,$cn);
					?>
					<form name="form_links" method="GET" action="inicio.php" id="form_links" >
					<table align="center" border="0" width="100%"  cellpadding="5" style="display:block">
					<?php $cont_result=0;
						while ($arreglo=mysql_fetch_array($recursos) )
								{
					       $cont_result++;
					?>
							<tr>
								 <td class="link_lista_directorio"  valign="top" onclick="javascript:links_grupos('reporte','<?php echo $arreglo['trabajo_idgrupo'];?>','','<?php echo $id_letra;?>','2');"  bgcolor="#EEEEEE" style="cursor:pointer;"><font style="cursor: pointer crosshair;""><?php echo $arreglo['d_grupo']."  (".$arreglo['numero'].")";?></font></td>
							</tr>
					<?php	} 
					
					if($cont_result==0)
					{
						?>
						<tr>
							 <td class="link_lista_mensaje"  valign="top" >No se encontraron resultados</td>
						</tr>
					<?php	} ?>
					</table>
					</form>
				
					<?php }
	
    
break;

case 11: //////////////////////////////// BUSQUEDA AVANZADA  ////////////////////////////////////////////

	$nombre=strtoupper($_GET['nombre']);
	//$nombre=utf8_decode($nombre);
	
	$dependencia=strtoupper($_GET['dependencia']);
	//$dependencia=utf8_decode($dependencia);
	
	$cargo=strtoupper($_GET['cargo']);
	$cargo=utf8_decode($cargo);
	
    $municipio=strtoupper($_GET['municipio']);
	$municipio=utf8_decode($municipio);
    
    $localidad=strtoupper($_GET['localidad']);
    $localidad=utf8_decode($localidad);
    
	$categoria=strtoupper($_GET['categoria']);
	
    $grupo=strtoupper($_GET['grupo']);
	
    $condicion='';
    
    $grupo=utf8_decode($grupo);
    
	  if ($nombre!=''){
			$condicion .=" and concat_ws(' ',personal_nombre,personal_paterno,personal_materno) like '%$nombre%'";
		} 	
	  if ($dependencia!=''){
			$condicion .=" and trabajo_dependencia like '%$dependencia%'";
		} 	
	  if ($cargo!=''){
			$condicion .=" and trabajo_cargo like '%$cargo%'";
		} 	
	  if ($municipio!='' and $municipio!='0' ){
			$condicion .=" and direccion_municipio like '$municipio'";
		} 	
	  if ($localidad!=''){
			$condicion .=" and direccion_ciudad ='$localidad'";
		} 	
	  if ($categoria!='0' and $categoria!=''){
			$condicion .=" and trabajo_categoria like '%$categoria%'";
		} 	
	  if ($grupo!=''){
			$condicion .=" and d_grupo like '%$grupo%' ";
		} 	


		if($condicion !='')
		{
	    	$condicion=substr($condicion,5);
			$condicion="where $condicion";
		}
				
		 
$sql="select concat_ws(' ',personal_nombre,personal_paterno,personal_materno) as nombre,trabajo_dependencia,trabajo_cargo,trabajo_categoria,
trabajo_idgrupo,trabajo_grupo, direccion_municipio,direccion_ciudad,gp.d_grupo,gp.id_cat_grup as id_grupo,count(id) as numero
from tb_contactos 
inner join tb_grupos gp on gp.id_cat_grup=trabajo_idgrupo
$condicion
group by d_grupo order by d_grupo ASC";
$recursos=mysql_query($sql,$cn);
		
?>
		
		
	   <table align="center" border="0" width="100%" style="display:block">
	<?php 
	$cont_result=0;
		while ($arreglo=mysql_fetch_array($recursos) )
			{
	$cont_result++;
				?>
			<tr>
				 <td class="link_lista_directorio"  onclick="javascript:links_avanzada('reporte','<?php echo $nombre ?>','<?php echo $dependencia ?>','<?php echo $cargo ?>','<?php echo $municipio ?>','<?php echo $localidad ?>','<?php echo $categoria ?>','<?php echo $arreglo['trabajo_idgrupo'];?>');"  bgcolor="#EEEEEE">   <?php echo $arreglo['d_grupo']."  (".$arreglo['numero'].")";?></td>
			</tr>
	<?php	} 
			
	if($cont_result==0)
	{
		?>
		<tr>
			 <td class="link_lista_mensaje"  valign="top" >No se encontraron resultados</td>
		</tr>
		<?php
		
	}
	?>
		</table>

    
<?php break;
case 12: //////////////////////////////// REPORTE DE PERSONAS  ////////////////////////////////////////////
	$id_persona=strtoupper($_GET['id_persona']);
	$id_grupo=strtoupper($_GET['id_grupo']);
	$id_letra=strtoupper($_GET['id_letra']);
	$id_op=strtoupper($_GET['id_op']);
	//f_imprime_arreglo($_GET);
	 switch ($id_op)
		{
////////////////////////////////////////// BUSQUEDA POR NOMBRE //////////////////////////////////////////////
		case 1:
		if ($id_persona!='' ){
				if($id_letra!='UNDEFINED' ){
					$condicion="and trabajo_idgrupo='$id_grupo'";
					$condicion2="and personal_nombre like '$id_letra%'";
					
				}else{
					$condicion="and trabajo_idgrupo='$id_grupo'";
					$condicion2="and concat_ws(' ',personal_nombre,personal_paterno,personal_materno) like '%$id_persona%'";
				}
		}else{
				$condicion="and trabajo_idgrupo='$id_grupo'";
				$condicion2="and personal_nombre like '$id_letra%'";
		}
		
		
			
			
		
				$sql="select id,personal_titulo,personal_nombre,personal_paterno,personal_materno,trabajo_titular,trabajo_idgrupo,trabajo_cargo,trabajo_telefono,trabajo_ext,gp.id_cat_grup,gp.d_grupo
				from tb_contactos inner join tb_grupos gp on gp.id_cat_grup=trabajo_idgrupo
						where visible='1' $condicion $condicion2 ";
				$ordenar=" order by personal_nombre,personal_paterno ASC";
				$recursos=mysql_query($sql,$cn);
		break;
		
////////////////////////////////////////// BUSQUEDA POR GRUPO //////////////////////////////////////////////		
		case 2:
			$sql="select id,personal_titulo,personal_nombre, personal_paterno,personal_materno,trabajo_idgrupo,trabajo_cargo,trabajo_telefono,trabajo_ext from tb_contactos where visible='1' and trabajo_idgrupo='$id_grupo' ";
			
			$ordenar="order by personal_nombre,personal_paterno ASC";
			
			//$recursos=mysql_query($sql,$cn);

		break;
////////////////////////////////////////// BUSQUEDA AVANZADA //////////////////////////////////////////////			
		
		 case 3:
					$nombre=strtoupper($_GET['nombre']);
					//nombre=utf8_decode($nombre);
					
					$dependencia=strtoupper($_GET['dependencia']);
					//$dependencia=utf8_decode($dependencia);
					
					$cargo=strtoupper($_GET['cargo']);
					//$cargo=utf8_decode($cargo);
					
				    $municipio=strtoupper($_GET['municipio']);
					//$municipio=utf8_decode($municipio);
				    
				    $localidad=strtoupper($_GET['localidad']);
				    //$localidad=utf8_decode($localidad);
				    
					$categoria=strtoupper($_GET['categoria']);
					
				    $grupo=strtoupper($_GET['grupo']);
					
				    
				   
				    $condicion=" and visible='1' ";
				    
				    
				    
					  if ($nombre!=''){
							$condicion .=" and concat_ws(' ',personal_nombre,personal_paterno,personal_materno) like '%$nombre%'";
						} 	
					  if ($dependencia!=''){
							$condicion .=" and trabajo_dependencia like '%$dependencia%'";
						} 	
					  if ($cargo!=''){
							$condicion .=" and trabajo_cargo like '%$cargo%'";
						} 	
					  if ($municipio!='' and $municipio!='0' ){
							$condicion .=" and direccion_municipio like '$municipio'";
						} 	
					  if ($localidad!=''){
							$condicion .=" and direccion_ciudad ='$localidad'";
						} 	
					  if ($categoria!='0'){
							$condicion .=" and trabajo_categoria like '%$categoria%'";
						} 	
					  if ($grupo!=''){
							$condicion .=" and trabajo_idgrupo like '%$grupo%' ";
						} 	
				
				
						if($condicion !='')
						{
					    	$condicion=substr($condicion,5);
							$condicion="where $condicion";
						}
								
						 
						$sql="select id,personal_nombre,personal_paterno,personal_materno,trabajo_dependencia,trabajo_telefono,trabajo_ext,trabajo_cargo,trabajo_categoria,trabajo_idgrupo,trabajo_grupo,
						direccion_municipio,direccion_ciudad
						from tb_contactos ";
		
		break;
				
	}
	?>
		

		<?php
		 $condicion0=" and trabajo_titular='TITULAR'";
         $condicion1=" and trabajo_titular='*'";
		//////////////////////////// sql de Titulares  //////////////////////////////
        $sqlt="$sql $condicion0 $ordenar";
		$recursost=mysql_query($sqlt,$cn);
		$resultadost=mysql_num_rows($recursost);
		
		//////////////////////////// sql de Grupos   ////////////////////////////////
		$sqlg="$sql $condicion1 $ordenar";
		$recursosg=mysql_query($sqlg,$cn);
		$resultadosg=mysql_num_rows($recursosg);

				$arreglo=mysql_fetch_array($recursos) 
				 
		
		?>
		
		
<form name="form_links" method="GET" action="inicio.php" id="form_links" >		
<table align="left" border="0" width="100%" cellpadding="0" cellspacing="0" id="barra">
<tr>
<td height="45px">
			<table align="left" border="0" width="100%" cellpadding="0" cellspacing="0" id="barra">
			<tr>
				<td background="imagenes/am1.gif" width="24px" >&nbsp;</td>
				<td background="imagenes/am2.gif" align="center" id="titulo1">
				<?php echo $arreglo['d_grupo']; ?><br>
				<input type="radio" name="rad" id="titulo1" onclick="javascript:document.getElementById('pre_titular').style.visibility='visible';document.getElementById('pre_grupo').style.visibility='hidden';document.getElementById('pre_titular').style.display='block';document.getElementById('pre_grupo').style.display='none';" checked/>Titulares ( <?php echo $resultadost ?> )
				&nbsp;&nbsp;&nbsp;
				<input type="radio" name="rad" onclick="javascript:document.getElementById('pre_titular').style.visibility='hidden';document.getElementById('pre_grupo').style.visibility='visible';document.getElementById('pre_titular').style.display='none';document.getElementById('pre_grupo').style.display='block';" />Personal del grupo ( <?php echo $resultadosg ?> )
				<td background="imagenes/am3.gif" width="24px">&nbsp;</td>
			</tr>
			</table>
</td>			
</tr>
<tr>
	<td valign="top">
		<!--//////////////////////////// TITULARES (titulares)  //////////////////////////////////////-->
	
		<div style="display:block;visibility:visible;width:100%;height:90%;overflow:auto;left:0;" id="pre_titular">
		<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
	   	
		<?php 
			$numero=1;
			while ($arreglo=mysql_fetch_array($recursost) )
				{
					$nombre = $arreglo['personal_titulo']." ".$arreglo['personal_nombre']." ".$arreglo['personal_paterno']." ".$arreglo['personal_materno'];
					$telefono = $arreglo['trabajo_telefono'];
					$ext = $arreglo['trabajo_ext'];
					
		?> 
		
			<tr>
				<td class="contenido" width="30px">&nbsp;<?php echo $numero;?> </td>
				<td >&nbsp;<font class="contacto" onclick="javascript:popup(<?php echo $arreglo['id'];?>);" style="cursor:pointer;"><b><?php echo $nombre;?></b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font class="contenido"><?php echo utf8_encode($telefono);?>&nbsp;Ext. <?php echo utf8_encode($ext);?></font></td>
			</tr>
			<tr>
				 <td colspan="2">&nbsp;<font class="contenido"><?php echo $arreglo['trabajo_cargo'];?></font></td>
			</tr>
			<tr>
				 <td style="border-bottom: dotted  1px #000000" colspan="2">&nbsp;</td>
				 
			</tr>
		<?php	
				$numero++;	
				} ?>
		
		</table>
		</div>
		
		<!--//////////////////////////// NO TITULARES (*)  //////////////////////////////////////-->
		
		<div style="display:none;visibility:hidden; overflow:auto;height:90%;width:100%;left:0;" id="pre_grupo">
		<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">

		<?php 
			$numero=1;
		while ($arreglo1=mysql_fetch_array($recursosg) )
				{
					$nombre = $arreglo1['personal_titulo']." ".$arreglo1['personal_nombre']." ".$arreglo1['personal_paterno']." ".$arreglo1['personal_materno'];
					$telefono = $arreglo1['trabajo_telefono'];
					$ext = $arreglo1['trabajo_ext'];	
					  		
	  	?>		
		<tr>
				<td class="contenido" width="30px">&nbsp;<?php echo $numero;?> </td>
				<td>&nbsp;<font class="contacto" onclick="javascript:popup(<?php echo $arreglo1['id'];?>);" style="cursor:pointer;"><b><?php echo $nombre;?></b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font class="contenido"><?php echo utf8_encode($telefono);?>&nbsp;Ext. <?php echo utf8_encode($ext);?></font></td>
		</tr>
		<tr>
				<td colspan="2">&nbsp;<font class="contenido"><?php echo $arreglo1['trabajo_cargo'];?> </font></td>
		</tr>
		<tr>
				 <td style="border-bottom: dotted  1px #000000" colspan="2">&nbsp;</td>
		</tr>
		<?php	
				$numero++;
		} ?>
		</table>
		</div>
		
</td>
</tr>
</table>
</form>

		
    
<?php break;


case 13: ////////////////////////////////  GRUPO GRID  ////////////////////////////////////////////
	$id_persona=strtoupper($_GET['id_persona']);
	  if ($id_persona!=''){
			$condicion="where CONCAT(personal_nombre, ' ' , personal_paterno,' ',personal_materno) like '%$id_persona%'";
		} 	
	 if ($id_donde!=''){
			$condicion2="and ( (direccion_ciudad LIKE '%$id_donde%') or (direccion_municipio LIKE '%$donde%') or  (direccion_estado LIKE '%$donde%' ) )";
		} 		
		 
		$sql=("select COUNT(personal_nombre) as numero,personal_nombre, personal_paterno,personal_materno,trabajo_grupo from tb_contactos $condicion group by trabajo_grupo order by trabajo_grupo ASC");
		$recursos=mysql_query($sql,$cn);
		
	?>
		
		
	   <table align="center" border="0" width="100%" style="display:block">
	<?php 
		while ($arreglo=mysql_fetch_array($recursos) )
		$nombre = $arreglo['personal_titulo']." ".$arreglo['personal_nombre']." ".$arreglo['personal_paterno']." ".$arreglo['personal_materno'];
				{
	?>
			<tr>
				 <td bgcolor="#EEEEEE"><font class="contacto"><?php echo $nombre;?></font><font><?php echo $arreglo['trabajo_cargo'];?></font></td>
			</tr>
	<?php	} ?>
		</table>

    
<?php break;

case 14: ////////////////////////////////  IMPRIMIR ////////////////////////////////////////////


	$fecha=date('d - M - Y');
	$nombre=strtoupper($_GET['nombre']);
	//$nombre=utf8_decode($nombre);
	$nombre = str_replace(" ","%",$nombre);
	
	$dependencia=strtoupper($_GET['dependencia']);
	//$dependencia=utf8_decode($dependencia);
	
	$cargo=strtoupper($_GET['cargo']);
	$cargo=utf8_decode($cargo);
	
    $municipio=strtoupper($_GET['municipio']);
	$municipio=utf8_decode($municipio);
    
    $localidad=strtoupper($_GET['localidad']);
    $localidad=utf8_decode($localidad);
    
	$categoria=strtoupper($_GET['categoria']);
	
    $grupo=strtoupper($_GET['grupo']);
    
	$titulo=strtoupper($_GET['titulo']);
	
	
    $condicion='';
    
    $grupo=utf8_decode($grupo);
    
    if ($grupo!=''){
			$sqlgrupo="select id_cat_grup, d_grupo from tb_grupos where d_grupo='$grupo'";
			$array=mysql_fetch_array(mysql_query($sqlgrupo,$cn));
			$grupo  =  $array['id_cat_grup'];
		} 	

    
	  if ($nombre!=''){
			$condicion .=" and concat_ws(' ',personal_nombre,personal_paterno,personal_materno) like '%$nombre%'";
		} 	
	  if ($dependencia!=''){
			$condicion .=" and trabajo_dependencia like '%$dependencia%'";
		} 	
	  if ($cargo!=''){
			$condicion .=" and trabajo_cargo like '%$cargo%'";
		} 	
	  if ($municipio!='' and $municipio!='0' ){
			$condicion .=" and direccion_municipio like '$municipio'";
		} 	
	  if ($localidad!=''){
			$condicion .=" and direccion_ciudad ='$localidad'";
		} 	
	  if ($categoria!='0' and $categoria!=''){
			$condicion .=" and trabajo_categoria like '%$categoria%'";
		} 	
	  if ($grupo!=''){
			$condicion .=" and trabajo_idgrupo ='$grupo'";
		} 	


		if($condicion !='')
		{
	    	$condicion=substr($condicion,5);
			$condicion="where $condicion";
		}
				
		 
$sql="select concat_ws(' ',personal_nombre,personal_paterno,personal_materno) as nombre,trabajo_dependencia,trabajo_cargo,trabajo_lada,trabajo_telefono,trabajo_email,trabajo_ext,
trabajo_idgrupo,direccion_municipio,direccion_ciudad,orden,gp.d_categoria,gp.d_grupo,gp.id_cat_grup as id_grupo
from tb_contactos 
inner join tb_grupos gp on gp.id_cat_grup=trabajo_idgrupo
$condicion
order by d_categoria,d_grupo,orden,nombre ASC ";
$recursos=mysql_query($sql,$cn);

		
?>
		
<table align="center" border="0" width="100%" cellpadding="1" cellspacing="0">
	<tr>	   		
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
	   		<td>&nbsp;</td>
	   		<td width="30%" align="left"><img src="../imagenes/iqmlogo.jpg" width="140px"></td>
	   		<td width="40%" align="center" class="titulo">DIRECTORIO INSTITUCIONAL</td>
	   		<td width="30%" align="center" class="cont"><?php echo $fecha;?></td>
	</tr>
	
	<tr>
		<td colspan="4" align="center" bgcolor="#7accff">  <?php echo $titulo;?></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
</table>
		
		
		<div style="height:350px;overflow-Y:auto;top:0;vertical-align:top;" >
		<table align="center" border="0" width="100%" cellpadding="1" cellspacing="0" >
	<?php 
	$pdf=1;
		while ($arreglo=mysql_fetch_array($recursos) )
				{
					
	if($contador ==7){
	  
	  	if ($pdf!=0) {
	  		
	  		$pdf=$pdf;
	  	?>
	  		<tr>
				 <td style="border-bottom: dotted  1px #000000" colspan="3" align="center" valign="top">&nbsp;<br><?php echo "Pagina $pdf";?></td>
				 
			</tr>
	  	<?php
	  	}
	  		$pdf++;
	  	$contador=0;
	  }
	  $contador++;
	?>
			<tr>
				<td width="5px" valign="top">&nbsp;</td>
				 <td bgcolor="#EEEEEE" colspan="2">  <b> <?php echo $arreglo['nombre'];?></b></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				 <td bgcolor="#EEEEEE" colspan="2">   <?php echo $arreglo['trabajo_cargo'];?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				 <td bgcolor="#EEEEEE" colspan="2">   <?php echo $arreglo['trabajo_dependencia'];?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				 <td bgcolor="#EEEEEE" colspan="2">   <?php echo $arreglo['trabajo_lada']." - ".$arreglo['trabajo_telefono']."&nbsp;&nbsp;ext: ".$arreglo['trabajo_ext'];?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				 <td bgcolor="#EEEEEE" colspan="2"><?php echo $arreglo['trabajo_email'];?></td>
			</tr>
			<!--<tr>
				<td>&nbsp;</td>
				 <td bgcolor="#EEEEEE" colspan="2"><?php echo $arreglo['d_categoria']."&nbsp;&nbsp;-&nbsp;&nbsp;".$arreglo['d_grupo'];?></td>
			</tr>-->
			</tr>
				<td>&nbsp;</td>
				<td bgcolor="#EEEEEE" colspan="2">  </td>

			</tr>
			</tr>
				<td style="border-bottom: dotted  1px #000000" colspan="3"> &nbsp;</td>
			</tr>

			
			
			
			
	<?php	} ?>
		</table>
		</div>



<?php break;

case 15:///////////////////////////////// LISTA DE NOMBRES CON GRUPOS  ///////////////////////////////////////////////
	$id_op=strtoupper($_GET['opcion']);
	$id=strtoupper($_GET['id']);
	

	
	$sql="select id,concat_ws(' ',personal_nombre,personal_paterno,personal_materno) as nombre
	from tb_contactos inner join tb_grupos gp on gp.id_cat_grup=trabajo_idgrupo
	where visible='1' and id='$id' order by personal_nombre,personal_paterno ASC";
	$recursos1=mysql_query($sql,$cn);
	$arreglo1=mysql_fetch_array($recursos1);
	$nombre=$arreglo1['nombre'];
	
	$sql2="select id, concat_ws(' ',personal_nombre,personal_paterno,personal_materno) as nombre, trabajo_cargo,trabajo_telefono, trabajo_ext,gp.id_cat_grup,gp.d_categoria,gp.d_grupo
	from tb_contactos inner join tb_grupos gp on gp.id_cat_grup=trabajo_idgrupo
	where visible='1' and concat_ws(' ',personal_nombre,personal_paterno,personal_materno)='$nombre'";
	$recursos2=mysql_query($sql2,$cn);

?>	
	
<!--//////////////////////////// NOMBRE CON GRUPOS  //////////////////////////////////////-->
<table border="0" style="left:0px;top:0px;" width="100%" cellpadding="0" cellspacing="0" id="barra">

<tr>
			<td background="imagenes/am1.gif" width="24px" height="30px">&nbsp;</td>
			<td background="imagenes/am2.gif" align="center">&nbsp;<br>
			<td background="imagenes/am3.gif" width="24px">&nbsp;</td>
</tr>

<tr>
	<td colspan="3" width="100%">
		<!--//////////////////////////// TITULARES (titulares)  //////////////////////////////////////-->
		
	
			<table width="100%"  align="center" border="0" cellpadding="0" cellspacing="0" >
		   	
			<?php 
				$numero=1;
				while ($arreglo=mysql_fetch_array($recursos2) )
					{
						$nombre = $arreglo['nombre'];
						$telefono = $arreglo['trabajo_telefono'];
						$ext = $arreglo['trabajo_ext'];
			?>
				
				<tr>
					 <td class="contenido">&nbsp;<?php echo $numero;?> </td>
					 <td>&nbsp;<font class="contacto" onclick="javascript:popup(<?php echo $arreglo['id'];?>);" style="cursor:pointer;"><b><?php echo $nombre;?></b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font class="contenido"><?php echo utf8_encode($telefono);?>&nbsp;Ext. <?php echo utf8_encode($ext);?></font></td>
				</tr>
				<tr>
					 <td colspan="2">&nbsp;<font class="contenido"><?php echo $arreglo['trabajo_cargo'];?></font></td>
				</tr>
				<tr>
					 <td class="contenido" colspan="2" style="color:red;">&nbsp;<?php echo $arreglo['d_categoria'];?> - <?php echo $arreglo['d_grupo'];?> </td>
					
				</tr>
				<tr>
					 <td style="border-bottom: dotted  1px #000000" colspan="2">&nbsp;</td>
				</tr>
			<?php	
					$numero++;	
					} ?>
			</table>
	</td>
</tr>
</table>
<?php break;
}
?>

</body>
</html>