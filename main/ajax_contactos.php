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

<body>

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

	 switch ($id_op)
		{
////////////////////////////////////////// BUSQUEDA POR NOMBRE //////////////////////////////////////////////
		case 1:
		
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
	//$nombre=utf8_decode($nombre);
	$nombre = str_replace(" ","%",$nombre);
					
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
    
    
   
	  if ($nombre!=''){
			$condicion .=" and concat_ws(' ',p_nombre,p_paterno,p_materno) like '%$nombre%'";
		} 	
	  if ($dependencia!=''){
			$condicion .=" and t_dependencia like '%$dependencia%'";
		} 	
	  if ($cargo!=''){
			$condicion .=" and t_cargo like '%$cargo%'";
		} 	
	  if ($municipio!='' and $municipio!='0' ){
			$condicion .=" and p_municipio like '$municipio'";
		} 	
	  if ($localidad!=''){
			$condicion .=" and p_ciudad ='$localidad'";
		} 	
	  if ($categoria!='0' and $categoria!=''){
			$condicion .=" and id_categoria = '$categoria'";
		} 	
	  if ($grupo!=''){
			$condicion .=" and id_grupo ='$grupo'";
		} 	

		if($condicion !='')
		{
	    	$condicion=substr($condicion,5);
			$condicion="where $condicion";
		}
				
		 
$sql="select id,id_categoria,id_grupo,concat_ws(' ',p_titulo,p_nombre,p_paterno,p_materno) as nombre,t_dependencia,t_cargo,t_telefono1,t_email,t_ext,
p_municipio,p_ciudad,orden,ruta,gp.d_grupo,gp.id_grup
from tb_contactos 
inner join cat_grupos gp on gp.id_grup=id_grupo
$condicion and diamujer!='0'
order by id_categoria,orden,nombre ASC ";
$recursos=mysql_query($sql,$cn);

		
?>
		

		
		
		<div style="height:293px;overflow-Y:auto;top:0;vertical-align:top;" >
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
			</tr>
				<td style="border-bottom: dotted  1px #000000" colspan="3"></td>
			</tr>

			
			
			
			
	<?php	} ?>
		</table>
		</div>



<?php break;


case 17:///////////////////////////////// VALIDADOR DE NOMBRES  ///////////////////////////////////////////////
$nombre=strtoupper($_GET['nombre']);
$paterno=strtoupper($_GET['paterno']);
//$grupo=strtoupper($_GET['grupo']);
$materno=strtoupper($_GET['materno']);


	
//$sqla="select p_nombre,p_paterno,id_grupo1 from tb_contactos where p_nombre='$nombre' and p_paterno='$paterno' and id_grupo1='$grupo'";
$sqla="select id,p_nombre,p_paterno,p_materno from tb_contactos where p_nombre='$nombre' and p_paterno='$paterno' and p_materno='$materno'";
$result = mysql_query($sqla,$cn);

if($row = mysql_num_rows($result)>0)
{
	//Se obtiene el ID--------------------------
	while ($row = @mysql_fetch_array($result)) {									
					$id_contc = $row["id"];
	}
	//------------------------------------------
	echo '<tr><td bgcolor="red" style="color:#ffffff;" colspan="3">ESTE CONTACTO YA EXISTE  &nbsp;&nbsp;&nbsp;&nbsp; (<a href="../main/contacto_editar.php?operacion=3&id='.$id_contc.'">EDITAR</a>)   </td></tr>';
	echo "<script>alert('USUARIO DADO DE ALTA EN ESTE GRUPO')</script>";
}else{
	echo '<tr><td bgcolor="green" style="color:#ffffff;" colspan="3">CONTACTO DISPONIBLE</td></tr>';
	echo "<script>alert('USUARIO DISPONIBLE')</script>";
}


break;
case 18:///////////////////////////////// VALIDADOR DE NOMBRES  ///////////////////////////////////////////////
$id=strtoupper($_GET['id']);

	
$sqla="select * from tb_cuentas where id_usuario='$id'";
$result = mysql_query($sqla,$cn);
$array=mysql_fetch_array($result);

$tipo=$array['id_tipo'];

if($tipo==0){
	echo $sqlupdate="UPDATE tb_cuentas SET id_tipo='2' WHERE id_usuario='$id'" ;
}else{
	echo $sqlupdate="UPDATE tb_cuentas SET id_tipo='0' WHERE id_usuario='$id'" ;
}
$result = mysql_query($sqlupdate,$cn);
?>
<table align="left" border="0" width="100%"  cellpadding="5" style="left:0px;top:0px;">
			<tr>	
			    <td width="20%"  class="titulo" align="left">Nombre</td>
			    <td width="20%"  class="titulo" align="left">A. Paterno</td>
			    <td width="20%"  class="titulo" align="left">Usuario</td>
			    <td width="20%"  class="titulo" align="left">Altas de Contactos</td>
			    <td width="20%"  class="titulo" align="left">Status</td>
			</tr>
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
				 $sqlcategoria="select count(usuario) as num,usuario from tb_contactos where usuario='$usuario'";
				//$sqlcategoria="select count(usuario) as num,usuario,visible,nombre,username,ap_paterno,id_tipo from tb_contactos inner join tb_cuentas on tb_cuentas.id_usuario=tb_contactos.usuario where tb_contactos.visible='1' group by nombre";
				$recurso11=mysql_query($sqlcategoria,$cn);
				$aa=mysql_fetch_array($recurso11)
			?>
			<tr>	
			    <td width="20%"  class="<?php echo $titulo;?>" align="left"><?php echo $bb['nombre'];?></td>
			    <td width="20%"  class="<?php echo $titulo;?>" align="left"><?php echo $bb['ap_paterno'];?></td>
			    <td width="20%"  class="<?php echo $titulo;?>" align="left"><?php echo $bb['username'];?></td>
			    <td width="20%"  class="<?php echo $titulo;?>" align="center"><?php echo $aa['num'];?></td>
			    <td width="20%" style="cursor:pointer;"  class="<?php echo $titulo;?>" align="left" onclick="javascript:activarusuario('c','<?php echo $bb['id_usuario'];?>');"><?php echo $status;?></td>
			</tr>
			<?php
			 }?>
</table>

<script>
location.reload();
</script>


<?php
break;

//Agregado by Alejandro ya que no contaba con una función la cual cargue los grupos al seleccionar una categoria
case 2:

					  //$aa[trabajo_idgrupo];
      				$qrySgrupos="select * from cat_grupos where id_cat='$id_categoria' order by d_grupo ASC";
      				$qrySgrupos=mysql_query($qrySgrupos,$cn);
				    //f_type_combobox('id_grup',$qrySgrupos,'','d_grupo','id_grup',"$aa[id_grupo1]",'','',$ver,'','430px'); comentado por falta de definicion de $ver
					f_type_combobox('id_grup',$qrySgrupos,'','d_grupo','id_grup',"$id_categoria",'','','','','430px');
					

break;
}


?>

</body>
</html>