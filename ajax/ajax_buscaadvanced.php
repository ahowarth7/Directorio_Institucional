<?PHP 
    
   //includes
    header("Content-Type: text/html; charset=iso-8859-1");
	header("Content-Encoding :iso-8859-1");
	
	include('../include/funciones_v2.php');
    f_verifica_sesion();
	
	$path = '../../'; //dirname(__FILE__);
	require_once ("../libs/adodb/adodb-exceptions.inc.php");
	require_once ("../libs/adodb/adodb.inc.php");
	require_once ("../includes/utf8.php");
	require_once ("../includes/config.php");
	require_once ("../includes/conexion.php");
	require_once ("../libs/lib/lib.php");
	require_once('../contactos/contactos.class.php');	  
	  
    //conexion
    $db = Conectar();
    
	$jerarquias = array();
	if($_GET['jera_titulares'])    array_push($jerarquias,$_GET['jera_titulares']);
	if($_GET['jera_subtitulares']) array_push($jerarquias,$_GET['jera_subtitulares']);
	if($_GET['jera_directivo'])     array_push($jerarquias,$_GET['jera_directivo']);
	if($_GET['jera_coordinacion']) array_push($jerarquias,$_GET['jera_coordinacion']);
	if($_GET['jera_jefatura'])     array_push($jerarquias,$_GET['jera_jefatura']);
	
	$str_jerarquias = '';
	if(count($jerarquias) > 0) $str_jerarquias = implode(',',$jerarquias);
	
	
	//Instance
	$contact = new Contacto($db);
	$filters = array(
	   'filt_categoria'  => $_GET['categoria'],
	   'filt_grupo'      => $_GET['grupo'],
	   'filt_dependencia'=> $_GET['dependencia'],	   
	   'filt_jerarquia'  => $_GET['jerarquia'],
	   'filt_jerarquias' => $str_jerarquias ,	   
	   'filt_cargo'      => $_GET['cargo'],
	   'filt_municipio'  => $_GET['municipio'],
	   'filt_ciudad'     => $_GET['ciudad'],
	   'filt_sexo'       => $_GET['sexo'],	   
	   'filt_dm'         => $_GET['dmujer'],
	   'filt_maestra'    => $_GET['vfemenino'],
	   'filt_avf'        => $_GET['violencia'],
	   'filt_dievcm'     => $_GET['imaestra'],
	   'limit'           => 1000000 ,
	   'group'           => 'p.pers_persona',
	   'orderby'        => 'pers_nnombre ASC'
	);
	$rows    = $contact->getByFilters($filters, 'array');
	
	/*echo count($rows);
	echo "<pre>";
	echo print_r($filters);	
	echo "</pre>";*/
	

   
	
	
	
	
?>	

<form name="form_links" method="GET" action="inicio.php" id="form_links" >
    <div style="font-size:11px; text-align:right"> <? if(count($rows) > 0) echo "Contactos encontrados (".count($rows).")"; ?></div>
    <table align="left" border="0" width="100%"  cellpadding="5" style="left:0px;top:0px;">
	 <?php 
         if( count($rows) >0 ){
			 $INDEX=1;
             foreach($rows as $key => $record ){
			       $bgcolor="#EEEEEE";
				   if($INDEX % 2 == 0) {  $bgcolor="#FDE87F"; }

     ?>
                <tr>
                    <?php if($comoabrir=='directo'){?>
                    <td class="link_lista_directorio" id="<?php echo $record['pers_persona']; ?>" valign="top" onclick="javascript:editar('<?php  echo $record['pers_persona'];?>');marcaElSeleccionado('<?php echo $record['pers_persona']; ?>');"   bgcolor="<?php echo $bgcolor;?>" style="cursor:pointer;"><?php echo $arreglo['nombre'];?></td>
                    <?php }else{ ?>
                     <td class="link_lista_directorio" id="<?php echo $record['pers_persona']; ?>" valign="top" onclick="javascript:links_grupos('reporte','<?php echo $record['pers_persona']; ?>','<?php echo $record['pers_jerarquia']; ?>');marcaElSeleccionado('<?php echo $record['pers_persona']; ?>');"  bgcolor="<?php echo $bgcolor;?>" style="cursor:pointer;"><?php echo $record['pers_nnombre'];?></td>
                    <?php } ?> 
                     <td class="link_lista_directorio" style="color:red;" bgcolor="<?php echo $bgcolor;?>"> <?php echo $record['ngroup'];?></td>
                </tr>
	
<?php            $INDEX++;
            } 			
}else{?>
<tr>
	 <td class="link_lista_mensaje"  valign="top" >No se encontraron resultados</td>
</tr>
<?php }	?>
</table>
</form>
