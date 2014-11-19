<?php
include("../include/conexion_bd.php");
include("../include/funciones_v2.php");
header('<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />');
header('<meta http-equiv="Expires" content="Tue, 01 Dec 1991 06:30:00 GMT">');
?>

<?php

	echo $fecha=date('d - M - Y');
	$nombre=strtoupper($_GET['nombre']);
	//$nombre=utf8_decode($nombre);
	$nombre = str_replace(" ","%",$nombre);
	
	$dependencia=strtoupper($_GET['dependencia']);
	
	$cargo=strtoupper($_GET['cargo']);
	//$cargo=utf8_decode($cargo);
	
    $municipio=strtoupper($_GET['municipio']);
	//$municipio=utf8_decode($municipio);

    $localidad=strtoupper($_GET['localidad']);
    //$localidad=utf8_decode($localidad);
    
	$categoria=strtoupper($_GET['categoria']);
	
    $grupo=strtoupper($_GET['grupo']);
	$evento=strtoupper($_GET['evento']);
	
	$sexo=strtoupper($_GET['sexo']);
    
	$titulo=strtoupper($_GET['titulo']);
    
    $condicion='';
   
	  if ($nombre!=''){
		 $condicion .=" and concat_ws(' ',p_nombre,p_paterno,p_materno) like '%$nombre%'";
		} 	
	  if ($dependencia!=''){
			$condicion .=" and t_dependencia1 like '%$dependencia%' or t_dependencia2 like '%$dependencia%' or t_dependencia3 like '%$dependencia%' or t_dependencia4 like '%$dependencia%'";
		} 	
	  if ($cargo!=''){
			$condicion .=" and t_cargo1 like '%$cargo%' or t_cargo2 like '%$cargo%' or t_cargo3 like '%$cargo%' or t_cargo4 like '%$cargo%'";
		} 	
	  if ($municipio!='' and $municipio!='0' ){
			$condicion .=" and t_municipio like '$municipio'";
		} 	
	  if ($localidad!=''){
			$condicion .=" and t_ciudad ='$localidad'";
		} 	
	  if ($categoria!='0' and $categoria!=''){
			$condicion .=" and id_categoria = '$categoria'";
		} 	
	  if ($grupo!='' && $grupo!='354'){ //CAMBIAR SEGUN LA TABLA
			$condicion .=" and id_grupo1 ='$grupo' or  id_grupo2 ='$grupo' or  id_grupo3 ='$grupo' or id_grupo4 ='$grupo'";
		} 	
	  //--------------------------------
	  if ($evento==0){
		  $condicion .= "";	  
	  }
      if ($evento==1){
		 $condicion .= " and diamujer = '1'";
	  }
	  if ($evento==2){
		 $condicion .= " and maestra = '1'";
	  }
	  //--------------------------------
	  
	  //--------------------------------
	  if ($sexo==0){
		  $condicion .= "";	  
	  }
      if ($sexo==1){
		 $condicion .= " and p_sexo = 'H'";
	  }
	  if ($sexo==2){
		 $condicion .= " and p_sexo = 'M'";
	  }
	  //--------------------------------
	  
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

$sql="SELECT id, id_categoria, id_grupo1, concat_ws(' ',p_titulo,p_nombre,p_paterno,p_materno) as nombre,
			 t_cargo1, t_dependencia1, concat_ws(' ',t_tipocalle,t_calle) as direccion, t_ciudad, t_telefono1, t_ext, t_email1, ruta, t_orden
	  FROM tb_contactos ".$condicion."
	  ORDER BY id_categoria,nombre ASC";

	  /*echo'<p>';
	  echo $sql;
	  echo'<p>';
	  */
$recursos=mysql_query($sql,$cn);
		
?>
		

		
		
		<div style="height:393px;overflow-Y:auto;top:0;vertical-align:top;font-size:11px;font-family:arial;" >
		<table align="center" border="0" width="100%" cellpadding="1" cellspacing="0" >
	<?php 
	$pdf=1;
	$contador=0;
		while ($arreglo=mysql_fetch_array($recursos))
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
				 <td bgcolor="#EEEEEE" colspan="2">  <b> <?php echo $arreglo['nombre']; //utf8_encode agregado por Alejandro Suárez?></b></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				 <td bgcolor="#EEEEEE" colspan="2">   <?php echo $arreglo['t_cargo1'];?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				 <td bgcolor="#EEEEEE" colspan="2">   <?php echo $arreglo['t_dependencia1'];?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				 <td bgcolor="#EEEEEE" colspan="2">   <?php echo $arreglo['t_telefono1']."&nbsp;&nbsp;ext: ".$arreglo['t_ext'];?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				 <td bgcolor="#EEEEEE" colspan="2"><?php echo $arreglo['t_email1'];?></td>
			</tr>
			</tr>
				<td style="border-bottom: dotted  1px #000000" colspan="3"></td>
			</tr>

			
			
			
			
	<?php	} ?>
		</table>
		</div>
