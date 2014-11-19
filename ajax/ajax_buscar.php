<?PHP
    
   //includes
    header("Content-Type: text/html; charset=iso-8859-1");
	header("Content-Encoding :iso-8859-1");
	include("../include/conexion_bd.php");
	include('../include/funciones_v2.php');
    f_verifica_sesion();

    $id_persona = strtoupper($_GET['id_buscar']);
    echo $opcion=   $_GET['check'];
	$id_persona = str_replace(" ","%",$id_persona);
	$comoabrir = $_GET['como'];
	
	//echo 'id_persona: '.$id_persona .'- id_letra'.$id_letra;
	

	   $sql = "
		SELECT pers_persona AS id     , pers_jerarquia as jerarquia,
			   CONCAT_WS(' ',pers_nombre,pers_apat, pers_amat) AS nombre,
			   ( 
				  SELECT COUNT(*)
					FROM personagrupo 
				   WHERE pers_persona = personas.pers_persona 
				)            AS numgrup
		   FROM personas 
	      WHERE CONCAT_WS(' ',pers_nombre,pers_apat, pers_amat)  LIKE ('%$id_persona%')
		 ORDER BY pers_nombre,pers_apat, pers_amat
		 LIMIT 0,30
		";

		$recursos = mysql_query($sql,$cn) or die(mysql_error());
		$num      = mysql_num_rows($recursos);


	
	
	
?>	

<form name="form_links" method="GET" action="inicio.php" id="form_links" >
    <table align="left" border="0" width="100%"  cellpadding="5" style="left:0px;top:0px;">
	 <?php 
         if( $num>0 ){
			 $INDEX=1;
             while($arreglo=mysql_fetch_array($recursos) ){
			       $bgcolor="#EEEEEE";
				   if($INDEX % 2 == 0) {  $bgcolor="#FDE87F"; }

     ?>
                <tr>
                    <?php if($comoabrir=='directo'){?>
                    <td class="link_lista_directorio" id="<?php echo $arreglo['id']; ?>" valign="top" onclick="javascript:editar('<?php  echo $arreglo['id'];?>');marcaElSeleccionado('<?php echo $arreglo['id']; ?>');"   bgcolor="<?php echo $bgcolor;?>" style="cursor:pointer;"><?php echo $arreglo['nombre'];?></td>
                    <?php }else{ ?>
                     <td class="link_lista_directorio" id="<?php echo $arreglo['id']; ?>" valign="top" onclick="javascript:links_grupos('reporte','<?php echo $arreglo['id']; ?>','<?php echo $arreglo['jerarquia']; ?>');marcaElSeleccionado('<?php echo $arreglo['id']; ?>');"  bgcolor="<?php echo $bgcolor;?>" style="cursor:pointer;"><?php echo $arreglo['nombre'];?></td>
                    <?php } ?> 
                     <td class="link_lista_directorio" style="color:red;" bgcolor="<?php echo $bgcolor;?>"> <?php echo $arreglo['numgrup'];?></td>
                </tr>
	
<?php            $INDEX++;
            } 			
}else{?>
<tr>
	 <td class="link_lista_mensaje"  valign="top"> <img src="../icons/action_delete.gif" width="16" height="16" alt="" />No se encontraron resultados</td>
</tr>
<?php }	?>
</table>
</form>
