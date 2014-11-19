<?php 
	    header("Content-Type: text/html; charset=iso-8859-1");
	    header("Content-Encoding :iso-8859-1");
	 
		include("../include/conexion_bd.php");
		include('../include/funciones_v2.php');
    	f_verifica_sesion();
		
		$pid  = $_GET['id'];
	        
    	$sql="
		SELECT personas.* ,
		       ( SELECT d_grupo FROM cat_grupos WHERE id_grup = pers_grupo ) AS ngrupo ,
			   ( SELECT depe_nombre FROM cat_dependencias WHERE depe_dependencia = pers_dependencia) pers_ndependencia,
			   ( SELECT d_colonia FROM cat_colonias WHERE id_colonia = pers_colonia ) pers_ncolonia,
		       CONCAT_WS(' ',pers_nombre,pers_apat, pers_amat) as nombre 
		   FROM personas 
		  WHERE pers_persona = '$pid'";
		
		$resource = mysql_query($sql,$cn) or die(mysql_error());
		$row      = mysql_fetch_array($resource, MYSQL_ASSOC); 
		
		//buscamos la direccion de la dependencia
		$sql  = "
		SELECT cat_dependencias.*,
		       ( SELECT nombre FROM cat_calles WHERE id_calle = depe_calle ) ncalle,
		       ( SELECT d_colonia FROM cat_colonias WHERE id_colonia = depe_colonia ) ncolonia
		  FROM cat_dependencias 
		 WHERE depe_dependencia='".$row['pers_dependencia']."'";
		$rs   = mysql_query($sql,$cn);
		$rdep = mysql_fetch_array($rs,MYSQL_ASSOC); 
		
		//buscamos datos de domicilio			
		$sql = "
		SELECT id_localidad, d_localidad, id_municipio_inegi, d_municipio, e.id_estado, e.d_estado
		  FROM cat_localidad, cat_municipios m, cat_estados e
		 WHERE id_municipio   = id_municipio_inegi
           AND m.id_estado    = e.id_estado
		   AND id_localidad   = '".$rdep['depe_ciudad']."'";
		$exe     = mysql_query($sql,$cn);
		$rciudad = mysql_fetch_array($exe); 
		
	
		
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>FICHA DE CONTACTO</title>

	<link rel="shortcut icon" type="image/x-png" href="../icons/address_book.gif">
	<link rel="stylesheet" href='../codebase/estilodirectorio.css' type='text/css'>
    
    <script type="text/javascript" src="../jquery/jquery-1.3.2.min.js"></script>

    <script language="JavaScript" type="text/JavaScript">
	function eliminar(pim)
	{
		var resp =confirm("¿Realmente deseas eliminar este registro? \n Se eliminara permanentemente de la base de datos");
		if (resp){
			//intentamos eliminar el contacto
			$.ajax({
		      url  : '../contactos/process.php',
			  data :  { action:'contact.delete', pers_persona : pim},
			  type : "POST",
			  success: function(data) {
			      try { var json = eval('(' + data + ')'); }catch(e){ json = false; }								
				  if(!json){ alert (data); return false }
				  
				  if(json.success==true){
			         alert(json.message);
				     window.close();
				  }else{
				     alert(json.message);
				  }
				
			  }
		    });
		}
	}
	function editar(id)
	{
		//window.location.href="contacto_editar.php?operacion=3&id='<?php echo $ids;?>'";
		var win = window.open("../contactos/edit.php?operacion=3&id=<?php echo $pid;?>","ventana1","width=950,height=800, scrollbars=yes, menubar=no, location=no, resizable=no");
		win.focus();
		window.close();
		
	}
</script>


<style type="text/css"> 
html{background-color:#E3DED1;}
div.rounded-box {position: relative;width: 19em;background-color: #ffffff;margin: 10px auto;}

/*********************
Caja Exterior
*********************/
div.top-left-corner, div.bottom-left-corner, div.top-right-corner, div.bottom-right-corner {position: absolute;width: 20px;height: 20px;	background-color: #e3ded1;	overflow: hidden;	z-index: 0;}
div.top-left-inside, div.bottom-left-inside, div.top-right-inside, div.bottom-right-inside {position: relative;font-size: 150px;font-family: arial;color: #ffffff;	line-height: 40px;	z-index: 0;}
div.top-left-corner { top: 0px; left: 0px; }
div.bottom-left-corner {bottom: 0px; left: 0px;}
div.top-right-corner {top: 0px; right: 0px;}
div.bottom-right-corner {bottom: 0px; right: 0px;}
div.top-left-inside {left: -8px;}
div.bottom-left-inside {left: -8px; top: -17px;}
div.top-right-inside {left: -25px;}
div.bottom-right-inside {left: -25px; top: -17px;}

/*********************
Contenido (txt)
*********************/

div.box-contents {
	position: relative;
	padding: 10px;
	color:#000;
	font-weight: bolder;
	z-index: 1;
}


}
</style>



</head>

<body>
<FORM NAME="formulario_ficha" METHOD="POST" onSubmit="return valida(this);">
<input type="hidden" name="operacion">
    <input type="hidden" name="tipo">
    <input type="hidden" name="id">

    <div class="rounded-box" style="width: 95%;">
        <div class="top-left-corner"><div class="top-left-inside">&bull;</div></div>
        <div class="bottom-left-corner"><div class="bottom-left-inside">&bull;</div></div>
        <div class="top-right-corner"><div class="top-right-inside">&bull;</div></div>
        <div class="bottom-right-corner"><div class="bottom-right-inside">&bull;</div></div>
        <!-- Aquí va el contenido -->
        <div class="box-contents">
	<p style="font-size: 12px; font-weight: lighter;">
	
	
<!--==================   CONTENIDO DE EL CUADRO =====================================-->

<table border="0" id="table" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff">
	<tr>
		<td align="center" class="h1" > <?php echo $row['pers_ndependencia'];?></td>
	</tr>
	<tr>
		<td align="center"  class="h1" > <?php echo $row['nombre'];?></td>
	</tr>
	<tr>
		<td align="center" class="h2"  > <?php echo $row['pers_cargo'];?></td>
	</tr>
	<tr>
		
		<td width="33.3%" align="center"><?php 
		if ($row['pers_email']=="NO DISPONIBLE" || $row['pers_email']=='' ){
			echo $row['pers_email'];
			
		}else{
			echo $row['pers_email'];
		}
		?></td>
		
	</tr>
</table>

<hr width="90%"> 

<table border="0" id="table" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff">
	<tr>
		<td align="center" class="h3">Datos de Trabajo</td>
	</tr>
	<tr>
		<td > 
			<table border="0" width="100%" id="table1"> 
				<tr><td><b>Tel Oficina:</b>&nbsp;<?php if ($row['pers_tel_dep']) { echo '('.substr($row['pers_tel_dep'],0,3).') '.substr($row['pers_tel_dep'],3,3).'-'.substr($row['pers_tel_dep'],6,4). "&nbsp; <b>Ext.</b> ".$row['pers_ext_dep']; } ?> </td></tr>
				<tr><td><b>Fax:</b>&nbsp;<?php echo $row['pers_fax_dep']."&nbsp;&nbsp; <b>Ext. Fax.</b> ".$row['pers_fax_ext_dep'];?> </td></tr>
				<tr><td><b>Colonia:</b>&nbsp;<?php echo $rdep['ncolonia'].", <b>C.P.</b> ".$rdep['depe_cp'];?> </td></tr>
				<tr><td><b>Direccion:</b>&nbsp;<?php echo $rdep['ncalle'];?> </td></tr>
				<tr><td><?php  if(strlen($rdep['depe_numero'])>0) echo "<b>No. </b>".$rdep['depe_numero']; if($rdep['depe_lote']) echo ", <b>Lote: </b> ".$rdep['depe_lote']; if($rdep['depe_manzana']) echo ", <b> Manzana:</b> ".$rdep['depe_manzana']; ?> </td></tr>
				<tr><td><?php echo $rciudad['d_localidad'].", ".$rciudad['d_municipio'].", ".$rciudad['d_estado'];?> </td></tr>
			</table>
		</td>
	</tr>
    </table>
</div>
    
    </div>
</form>

<div align="center">
    <div>
       <table border="0" width="100%">
        <tr>
            <td align="right"><button onclick="editar('<?php echo $pid;?>');"><img src="../icons/2.png" width="16px" height="16px"> Editar</button></td>
            <td align="left"><button onclick="eliminar('<?php echo $pid;?>');"><img src="../icons/4.png" width="16px" height="16px"> Eliminar </button> </td>
        </tr>
       </table>
    </div>
</div>
</body>
</html>