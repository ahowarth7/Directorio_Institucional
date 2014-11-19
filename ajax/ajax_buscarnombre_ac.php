<?php 
include("../include/conexion_bd.php");

header('<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1/>');
header('<meta http-equiv="Expires" content="Tue, 01 Dec 1991 06:30:00 GMT">');


	$id_persona=strtoupper($_GET['id_persona']);
	$id_apaterno=strtoupper($_GET['id_apaterno']);
	$id_amaterno=strtoupper($_GET['id_amaterno']);
	
	$id_persona = str_replace(" ","%",$id_persona);
	$id_apaterno = str_replace(" ","%",$id_apaterno);
	$id_amaterno = str_replace(" ","%",$id_amaterno);

	
	
if ($id_persona!=''){
					
	/*$sql=("select id, t_jerarquia1,concat_ws(' ',p_nombre,p_paterno,p_materno) as nombre,id_grupo1,id_grupo2,id_grupo3,id_grupo4 from tb_contactos 
		where concat_ws(' ',p_nombre,p_paterno,p_materno) like '%$id_persona%' group by nombre");*/	
	
	$sql=("select id, t_jerarquia1,concat_ws(' ',p_nombre,p_paterno,p_materno) as nombre,id_grupo1,id_grupo2,id_grupo3,id_grupo4 from tb_contactos 
		where p_nombre like '%$id_persona%' and p_paterno like '%$id_apaterno%' and p_materno like '%$id_amaterno%' group by nombre");
		
		$recursos=mysql_query($sql,$cn);
		$num=mysql_num_rows($recursos);		
	
}
else{
	$recursos = null;
	$num = 0;	
}	
?>	

<form name="form_links" method="GET" action="inicio.php" id="form_links" >
<table align="left" border="0" width="90%"  cellpadding="5" style="left:0px;top:0px;margin-top:0px;">
						<?php 
								$num=1;	
							if($num>0){
								$color='0';
								while ($arreglo=@mysql_fetch_array($recursos) )
										{
											//$cont_result++;
								$numero=0;
								if($arreglo['id_grupo1']!='0'){
									$numero=$numero+1;
								}
								if($arreglo['id_grupo2']!='0'){
									$numero=$numero+1;
								}
								if($arreglo['id_grupo3']!='0'){
									$numero=$numero+1;
								}
								if($arreglo['id_grupo4']!='0'){
									 $numero=$numero+1;
								}						
								if($color==0){
									$bgcolor="#EEEEEE";
									$color='1';
								}else{
									$bgcolor="#FDE87F";
									$color='0';
								}
								
						?>
									<tr>
										
										<!--<td class="link_lista_directorio" id="< ?php echo $arreglo['id']; ?>" valign="top" onclick="javascript:editar('< ?php  echo $arreglo['id'];?>');"   bgcolor="< ?php echo $bgcolor;?>" style="cursor:pointer;color:black;">< ?php echo utf8_encode($arreglo['nombre']);?></td>-->
										<!--<td class="link_lista_directorio" id="< ?php echo $arreglo['id']; ?>" valign="top"   bgcolor="< ?php echo $bgcolor;?>" style="cursor:pointer;color:black;"><a href="contacto_editar_ac.php?operacion=3&id=< ?php  echo $arreglo['id']; ?>">< ?php echo utf8_encode($arreglo['nombre']);?></a></td>-->
										<td class="link_lista_directorio" id="<?php echo $arreglo['id']; ?>" valign="top"   bgcolor="<?php echo $bgcolor;?>" style="cursor:pointer;color:black;"><a href="contacto_editar_ac.php?operacion=3&id=<?php  echo $arreglo['id']; ?>"><?php echo $arreglo['nombre'];?></a></td>
										
										 <td class="link_lista_directorio" style="color:red;" bgcolor="<?php echo $bgcolor;?>"> <?php echo $numero;?></td>
									</tr>
									
									
						<?php							
						}			
							}else{?>
								<tr>
									 <td class="link_lista_mensaje"  valign="top" >No se encontraron resultados</td>									 
								</tr>
						<?php }	?>
</table>
</form>
