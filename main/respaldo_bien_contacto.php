<?php
    include('../include/funciones_v2.php');
	include('../include/conexion_bd.php');

f_verifica_sesion();

?>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="keywords" content="" />

	<script src="../codebase/dhtmlxcommon.js"></script>  
	<script src="../codebase/dhtmlxcombo.js"></script>  
	<link rel="STYLESHEET" type="text/css" href="../codebase/dhtmlxcombo.css">
	<link rel="STYLESHEET" type="text/css" href="../codebase/dhtmlxtabbar2.css">	
	<script  src="../codebase/dhtmlxtabbar.js"></script>
	<script  src="../codebase/dhtmlxtabbar_start.js"></script>
	
<script src="../codebase/dhtmlxlayout.js"></script>
<link rel="stylesheet" type="text/css" href="../codebase/dhtmlxlayout.css">
<link rel="stylesheet" type="text/css" href="../codebase/skins/dhtmlxlayout_dhx_skyblue.css">
<script src="../codebase/dhtmlxcontainer.js"></script>

	

	<script language="javascript" type="text/javascript" src="../codebase/ajax.js"></script>
	
<!--======================================FUNCIONES==========================================-->
<?php

if(isset($_GET['id_titulo']) && isset($_GET['id_nombre']) && isset($_GET['id_paterno']) && isset($_GET['id_materno']) ){
$id_titulo=strtoupper($_GET['id_titulo']);
$id_nombre=strtoupper($_GET['id_nombre']);
$id_paterno=strtoupper($_GET['id_paterno']);
$id_materno=strtoupper($_GET['id_materno']);
$id_sexo=strtoupper($_GET['id_sexo']);
$id_dia=strtolower($_GET['id_dia']);
$id_mes=strtolower($_GET['id_mes']);
$id_casa=strtoupper($_GET['id_casa']); 
$id_celular=strtoupper($_GET['id_celular']);
$id_email=strtolower($_GET['id_email']); 
$id_aniboda=strtoupper($_GET['id_diaboda']."-".$_GET['id_mesboda']);
$id_esposa=strtoupper($_GET['id_esposa']);
$id_fechaesposa=strtoupper($_GET['id_diaesposa']."-".$_GET['id_mesesposa']);


$id_colonia=strtoupper($_GET['id_colonia']); 
$id_cp=strtoupper($_GET['id_cp']);
$id_tipo=strtoupper($_GET['id_tipo']);
$id_calle=strtoupper($_GET['id_calle']);
$id_sufijo=strtoupper($_GET['id_sufijo']);
$id_numero=strtoupper($_GET['id_numero']); 
$id_lote=strtoupper($_GET['id_lote']); 
$id_manzana=strtoupper($_GET['id_manzana']);
$referencia_domicilio=strtoupper($_GET['referencia_domicilio']);

	if($_GET['diamujer']=='on'){
		$id_diamujer='1';
	}else{
		$id_diamujer='0';
	}
	if($_GET['checkmaestra']=='on'){
		$id_checkmaestra='1';
	}else{
		$id_checkmaestra='0';
	}


$id_grupo1=strtoupper($_GET['id_grupo1']); 

/*id_cat guardar en tabla contactos para facilidad y optimización de búsquedas*/
/*----------------------------------------------------------------------------*/
$sqlidcat = "select id_cat from cat_grupos where id_grup = '".$id_grupo1."'";
																		
					$result = mysql_query($sqlidcat, $cn); 
					if (mysql_num_rows($result)){ 
										while ($row = @mysql_fetch_array($result)) {									
												$id_cat = $row["id_cat"];
										}
					}
/*----------------------------------------------------------------------------*/
/*id_cat guardar en tabla contactos para facilidad y optimización de búsquedas*/

$id_liderazgo=strtoupper($_GET['id_liderazgo']);
$id_dependencia1=strtoupper($_GET['id_dependencia1']);
$id_cargo1=strtoupper($_GET['id_cargo1']);
$id_titular1=strtoupper($_GET['id_titular1']);
$id_grupo2=strtoupper($_GET['id_grupo2']);			
$id_dependencia2=strtoupper($_GET['id_dependencia2']);
$id_cargo2=strtoupper($_GET['id_cargo2']);
$id_titular2=strtoupper($_GET['id_titular2']);
$id_grupo3=strtoupper($_GET['id_grupo3']);			
$id_dependencia3=strtoupper($_GET['id_dependencia3']);
$id_cargo3=strtoupper($_GET['id_cargo3']);
$id_titular3=strtoupper($_GET['id_titular3']);
$id_grupo4=strtoupper($_GET['id_grupo4']);			
$id_dependencia4=strtoupper($_GET['id_dependencia4']);
$id_cargo4=strtoupper($_GET['id_cargo4']);
$id_titular4=strtoupper($_GET['id_titular4']);


$id_telefono_oficina=strtoupper($_GET['id_telefono_oficina']);
$id_telefono_ext=strtoupper($_GET['id_telefono_ext']);
$id_ext_privada=strtoupper($_GET['id_ext_privada']);
$id_telefono_secu=strtoupper($_GET['id_telefono_secu']);
$id_fax=strtoupper($_GET['id_fax']); 
$id_fax_ext=strtoupper($_GET['id_fax_ext']); 
$id_nextel=$_GET['id_nextel'];  
$id_email_oficina=strtolower($_GET['id_email_oficina']);  
$id_web=strtolower($_GET['id_web']); 



$id_trab_colonia=strtoupper($_GET['id_trab_colonia']);
$id_direc_cp=strtoupper($_GET['id_direc_cp']);
$id_direc_tipo=strtoupper($_GET['id_direc_tipo']);
$id_direc_calle=strtoupper($_GET['id_direc_calle']);
$id_direc_sufijo=strtoupper($_GET['id_direc_sufijo']);
$id_direc_numero=strtoupper($_GET['id_direc_numero']);
$id_direc_lote=strtoupper($_GET['id_direc_lote']);
$id_direc_manzana=strtoupper($_GET['id_direc_manzana']);

$id_direc_tipo2=strtoupper($_GET['id_direc_tipo2']);
$id_direc_calle2=strtoupper($_GET['id_direc_calle2']);

$id_direc_tipo3=strtoupper($_GET['id_direc_tipo3']);
$id_direc_calle3=strtoupper($_GET['id_direc_calle3']);

$id_direc_ciudad=strtoupper($_GET['id_direc_ciudad']);
$id_direc_municipio=strtoupper($_GET['id_direc_municipio']);
$id_direc_estado=strtoupper($_GET['id_direc_estado']);
$id_ruta=strtoupper($_GET['id_ruta']);


$id_nota=strtoupper($_GET['id_nota']);

$elemento[1] = strtoupper($_GET['elemento1']);
$elemento[2] = strtoupper($_GET['elemento2']);
$elemento[3] = strtoupper($_GET['elemento3']);
$elemento[4] = strtoupper($_GET['elemento4']);
$elemento[5] = strtoupper($_GET['elemento5']);

}
$usuario=$_SESSION['id_usuario'];
$visible='1';
$fecha_alta = date("Y"."-"."m"."-"."d"); 



if(isset($_GET['id_titulo']) && isset($_GET['id_nombre']) && isset($_GET['id_paterno']) && isset($_GET['id_materno'])){
//===================== VERIFICA SI EL USUARIO EXISTE ======================//
if($id_nombre!=''){

		/*comprueba existencia*/
		$sqlnombre = "SELECT p_nombre, p_paterno, p_materno FROM tb_contactos WHERE p_nombre = '$id_nombre' 
																		and p_paterno = '$id_paterno' 
																		and p_materno = '$id_materno' ";
																		
					$result = mysql_query($sqlnombre, $cn); 
					if (mysql_num_rows($result)){ 
										while ($row = @mysql_fetch_array($result)) {									
												//echo utf8_encode('<option value="'.$u.'">'.$row["seccion"]."</option>");								
												//$u++;						
												//echo '<script>alert("'.$row["p_nombre"]." ".$row["p_paterno"]." ".$row["p_materno"].'")</script>'; 
										}
										//$id_nombre='';												
										echo '<script>alert("Esta persona ya existe!")</script>'; 
										
					}else{
										
		/*comprueba existencia*/
	
		$sql=mysql_query("insert into tb_contactos 
		(id_categoria, p_titulo,p_nombre,p_paterno,p_materno,p_sexo,p_dia,p_mes,p_telcasa,p_celular,p_email,p_aniversarioboda,p_esposa,p_cumple_esposa,
		p_colonia,p_cp,p_tipocalle,p_calle,p_sufijo,p_numero,p_lote,p_manzana,p_referencia_domicilio,diamujer,maestra,
		id_grupo1,id_liderazgo,t_cargo1,t_dependencia1,t_jerarquia1,id_grupo2,t_cargo2,t_dependencia2,t_jerarquia2,id_grupo3,t_cargo3,t_dependencia3,t_jerarquia3,id_grupo4,t_cargo4,t_dependencia4,t_jerarquia4,
		t_telefono1,t_ext,t_extprivada,t_telefono2,t_fax,t_faxext,t_nextel,t_email1,t_web,
		t_colonia,t_cp,t_tipocalle,t_calle,t_sufijo,t_numero,t_lote,t_manzana,t_tipocalle2,t_calle2,t_tipocalle3,t_calle3,t_ciudad,t_municipio,t_estado,ruta,
		nota,fecha_alta,visible,usuario)
		
		values
		
		('$id_cat','$id_titulo','$id_nombre','$id_paterno','$id_materno','$id_sexo','$id_dia','$id_mes','$id_casa','$id_celular','$id_email','$id_aniboda','$id_esposa','$id_fechaesposa',
		'$id_colonia','$id_cp','$id_tipo','$id_calle','$id_sufijo','$id_numero','$id_lote','$id_manzana','$referencia_domicilio','$id_diamujer','$id_checkmaestra',
		'$id_grupo1','$id_liderazgo','$id_cargo1','$id_dependencia1','$id_titular1','$id_grupo2','$id_cargo2','$id_dependencia2','$id_titular2','$id_grupo3','$id_cargo3','$id_dependencia3','$id_titular3','$id_grupo4','$id_cargo4','$id_dependencia4','$id_titular4',
		'$id_telefono_oficina','$id_telefono_ext','$id_ext_privada','$id_telefono_secu','$id_fax','$id_fax_ext','$id_nextel','$id_email_oficina','$id_web',
		'$id_trab_colonia','$id_direc_cp','$id_direc_tipo','$id_direc_calle','$id_direc_sufijo','$id_direc_numero','$id_direc_lote','$id_direc_manzana','$id_direc_tipo2','$id_direc_calle2',
        '$id_direc_tipo3','$id_direc_calle3','$id_direc_ciudad','$id_direc_municipio','$id_direc_estado','$id_ruta',
        '$id_nota','$fecha_alta','$visible','$usuario')",$cn);
		
		echo '<script>alert("Los datos fueron ingresados correctamente y Fueron Guardados");</script>';
		}
		
		
		/*TOMA EL ID DEL RECIEN INGRESADO---------------------------------*/
		$sqlnombre = "select max(id) as ide from tb_contactos";
																		
					$result = mysql_query($sqlnombre, $cn); 
					if (mysql_num_rows($result)){ 
										while ($row = @mysql_fetch_array($result)) {									
												$id_cont_agrem = $row["ide"];
										}
					}					
		/*TOMA EL ID DEL RECIEN INGRESADO---------------------------------*/
		
		if(empty($elemento[1]) && empty($elemento[2]) && empty($elemento[3]) && empty($elemento[4]) && empty($elemento[5])){
			//Sin acciones ya que no introdujeron algún elemento del gremio
		}
		else{
			//Intridujeron elementos en el gremio
			
			for($i=1;$i<=5;$i++){
				if(!empty($elemento[$i])){
							$sql=mysql_query("insert into tb_gremio (id_contacto, nombre_agremiado)
		
							values
		
							('".$id_cont_agrem."','".$elemento[$i]."')",$cn);
							//echo "<script>alert('datos a ingresar ".$elemento[$i]." con id ".$id_cont_agrem."')</script>";
							}
							
			}
			
		}

}
}

?>


<?php 	//Inicio del if para permitir a usuarios  1, 11, y 5 capturar sin validación
		if($_SESSION['id_usuario']==1 || 
		 $_SESSION['id_usuario']==11 ||
		 $_SESSION['id_usuario']==5){ 		 
?>
<script language="javascript"> 
var dhxLayout,dhxTabbar,tabbar,dhtmlXTabBar;

function validar_formulario(){ /* Abrimos la función validar_formulario */ 

if (document.formulario.id_nombre.value.length==0){ 
alert("Debe ingresar su nombre") 
document.formulario.id_nombre.focus() 
return 0; 
} 

if (document.formulario.id_paterno.value.length==0){ 
alert("Debe ingresar Apellido Paterno") 
document.formulario.id_paterno.focus() 
return 0; 
} 

if (document.formulario.id_sexo.selectedIndex==0){ 
alert("Debe seleccionar el sexo.") 
document.formulario.id_sexo.focus() 
return 0; 
}
if (document.formulario.id_grupo1.selectedIndex==0){ 
alert("Debe seleccionar un grupo.") ;
document.formulario.id_grupo1.focus() ;
return 0; 
} 
if (document.formulario.id_cargo1.value.length==0){ 
alert("Debe ingresar el Cargo") 
document.formulario.id_cargo1.focus() 
return 0; 
} 
if (document.formulario.id_dependencia1.selectedIndex==0){ 
alert("Selecciones una dependencia") 
document.formulario.id_dependencia1.focus() 
return 0; 
} 
if (document.formulario.id_titular1.selectedIndex==0){ 
alert("Selecciones si es titular u otro rango") 
document.formulario.id_titular1.focus() 
return 0; 
} 
 
document.formulario.submit(); 
}
</script>

<?php 
}
//Inicio de else para los demás usuarios
else{
?>


<!--======================================SCRIPTS==========================================-->  
<script language="javascript"> 

var dhxLayout,dhxTabbar,tabbar,dhtmlXTabBar;

function validar_formulario(){ /* Abrimos la función validar_formulario */ 
	
if (document.formulario.id_titulo.selectedIndex==0){ 
alert("Debe seleccionar un titulo.") 
document.formulario.id_titulo.focus() 
return 0; 
} 
if (document.formulario.id_nombre.value.length==0){ 
alert("Debe ingresar su nombre") 
document.formulario.id_nombre.focus() 
return 0; 
} 

if (document.formulario.id_paterno.value.length==0){ 
alert("Debe ingresar Apellido Paterno") 
document.formulario.id_paterno.focus() 
return 0; 
} 

if (document.formulario.id_sexo.selectedIndex==0){ 
alert("Debe seleccionar el sexo.") 
document.formulario.id_sexo.focus() 
return 0; 
} 
if (document.formulario.id_grupo1.selectedIndex==0){ 
alert("Debe seleccionar un grupo.") ;
document.formulario.id_grupo1.focus() ;
return 0; 
} 
if (document.formulario.id_cargo1.value.length==0){ 
alert("Debe ingresar el Cargo") 
document.formulario.id_cargo1.focus() 
return 0; 
} 
if (document.formulario.id_dependencia1.selectedIndex==0){ 
alert("Selecciones una dependencia") 
document.formulario.id_dependencia1.focus() 
return 0; 
} 
if (document.formulario.id_titular1.selectedIndex==0){ 
alert("Selecciones si es titular u otro rango") 
document.formulario.id_titular1.focus() 
return 0; 
} 

if (document.formulario.id_telefono_oficina.value.length==0){ 
alert("Debe ingresar el teléfono de oficina") 
document.formulario.id_telefono_oficina.focus() 
return 0; 
} 

if (document.formulario.id_direc_municipio.value.length==0){ 
alert("Debe seleccionar el municipio de dependencia") 
document.formulario.id_direc_municipio.focus() 
return 0; 
} 

if (document.formulario.id_direc_tipo.value.length==0){ 
alert("Debe seleccionar el tipo de calle de la dependencia") 
document.formulario.id_direc_tipo.focus() 
return 0; 
}

if (document.formulario.id_direc_calle.value.length==0){ 
alert("Debe seleccionar la calle de la dependencia") 
document.formulario.id_direc_calle.focus() 
return 0; 
}



if ((document.formulario.id_direc_numero.value.length==0) || 
	(document.formulario.id_direc_lote.value.length==0 &&
	document.formulario.id_direc_manzana.value.length==0)){ 
	
	alert("Debe introducir el número de la dirección de la dependencia") 
	document.formulario.id_direc_calle.focus() 
	return 0; 
}








/* Si paso todas las validaciones, desplegamos un mensaje de éxito y enviamos el formulario */ 
//alert("Los datos fueron ingresados correctamente y Fueron Guardados"); 
document.formulario.submit(); 
} 
</script>


<?php
//fin de else de validación para los demás usuarios
}
?>

<script language="javascript">

function validador(div)
{	
	
if (document.formulario.id_nombre.value.length==0){ 
alert("Debe ingresar su nombre") 
document.formulario.id_nombre.focus() 
return 0; 
} 

	div="validador";
	contenedor = document.getElementById(div);
	nombre=document.formulario.id_nombre.value;		
	paterno=document.formulario.id_paterno.value;
	materno=document.formulario.id_materno.value;
	//grupo=document.formulario.id_grupo1.value;
	
	ajax=nuevoAjax();	
	ajax.open("GET", "ajax_contactos.php?opcion=17&nombre="+nombre+"&paterno="+paterno+"&materno="+materno);
	
		ajax.onreadystatechange=function()
   	{
      if (ajax.readyState==4)
      {
         contenedor.innerHTML = ajax.responseText;
      }
   	}
   	ajax.send(null);
}
</script> 

<style>

th{
	font-family:  Tahoma, Arial, Helvetica, sans-serif;
	font-size: 12px;
    font-weight: bold;
    color: #000000;
    text-transform: uppercase;
    text-align: left;
    background-color:#f9e68a;
	width:140px;
	height:32px
}
td{
	font-family:  Tahoma, Arial, Helvetica, sans-serif;
	font-size: 12px;
    font-weight: bold;
    color: #000000;
    text-transform: uppercase;
    text-align: left;
}
fieldset {
	border:1px dashed #CCC;
	padding:10px;
	margin-top:13px;
	margin-bottom:20px;
	
}
legend {
	font-family:Arial, Helvetica, sans-serif;
	font-size: 90%;
	letter-spacing: -1px;
	font-weight: bold;
	line-height: 1.1;
	color:#fff;
	background: #666;
	border: 1px solid #333;
	padding: 2px 6px;
}

</style>
</head>

<!--======================================BODY==========================================-->
<body >
<FORM NAME="formulario" METHOD="get" onSubmit="return valida(this);">
<input type="hidden" name="operacion">
<input type="hidden" name="tipo">
<input type="hidden" name="id">



<!--==========TAB 1===================================================================================-->
<div id='html_1'>
<!--////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<fieldset>
<table width="100%" border="0">
    <tr> 
	      <th>* TITULO: </th>
		  <td>
		  <table width="100%">
		  <tr>
				<td>
				<?php
				$rdsquery1=mysql_query('select d_titulos from cat_titulos order by d_titulos ASC',$cn);
				f_type_combobox('id_titulo',$rdsquery1,'','d_titulos','d_titulos','','','','','','');
				?>
				</td>
				<th>* SEXO:</th>
		      	<td> 
		        	<select name="id_sexo">
		        	<option selected></option>
		        	<option>H</option>
		        	<option>M</option>
		        	</select>
				</td>
		  </tr>		  
		  </table>  
	      </td>
    </tr>
    <tr> 
	      	<th>* NOMBRE: </th>
	      	<td>
	      	<table width="100%">
	      	<tr>
		      	<td><input type="Text" name="id_nombre" size="30" style="text-transform:uppercase"></td>
				<td><input type="Text" name="id_paterno" size="30" style="text-transform:uppercase"></td>
				<td><input onKeyUp="javascript:validador('validador');"  type="Text"  class="texto" name="id_materno" size="30" style="text-transform:uppercase" ></td>
			</tr>
	      	</table>
	      	
	      	</td>
	     	
    </tr>
    <div id="validador"></div>
    <tr> 
			<td>&nbsp;</td>
			<td>
			<table width="100%">
	      	<tr>
		      	<td width="178px" align="center">Nombre(s)</td>
				<td width="178px" align="center">Apellido Paterno</td>
				<td width="178px" align="center">Apellido Materno</td>
			</tr>
	      	</table>
			</td>
			
    </tr>
    <tr>
    	<th>FECHA DE CUMPLEAÑOS:</th>
      <td>
        <select name="id_dia" style="width:50px">
        <option></option>
			<?php 
			for($i=1;$i<=31;$i++)
			    {
			    	/*if( ((int) substr($aa['personal_bday'],0,2)) == $i )
			    	{
			           if($i<10)	
					   	    echo '<OPTION  selected="selected">0'.$i;   
					   	else 
					   	    echo '<OPTION  selected="selected">'.$i;   
			    	}   	    
					else   	
					{*/
					   	if($i<10)
					   	    echo '<OPTION>0'.$i;   
					   	else 
					   	    echo '<OPTION>'.$i;   
					/* } */
			    }
			 
			?>
        </select>
        <?php
							$conexion_mes=mysql_query('select d_mes from cat_meses',$cn);
							//f_type_combobox('id_mes',$conexion_mes,'-','d_mes','d_mes',$id_bmonth,'','',$ver,'','150px'); por falta de definicion de $ver y $id_bmonth ...se envia una cadena vacia
							f_type_combobox('id_mes',$conexion_mes,'-','d_mes','d_mes','','','','','','150px');
		?> 
      </td>
    </tr>
    <tr> 
				<th>TELEFONO DE CASA:</th>
				<td>
					<table width="100%">
					<tr>
						<td><input type="Text" name="id_casa" size="23" maxlength="15"></td>
						<th>CELULAR:</th>
						<td><input type='text' name="id_celular" size="23" maxlength="15"></td>
					</tr>
					</table>
				
				</td>
    </tr>
  
    <tr> 
		      	<th>@ PERSONAL: </th>
				<td><input type="Text" name="id_email" size="50" ></td>
    </tr>
    <tr>
				<th>ANIVERSARIO DE BODAS</th>  
				<td>
					<select name="id_diaboda" style="width:50px">
        			<option></option>
					<?php 
					for($i=1;$i<=31;$i++)
			    	{
				    	/*if( ((int) substr($aa['personal_bday'],0,2)) == $i )
				    	{
				           if($i<10)	
						   	    echo '<OPTION  selected="selected">0'.$i;   
						   	else 
						   	    echo '<OPTION  selected="selected">'.$i;   
				    	}   	    
						else   	
						{*/
						   	if($i<10)
						   	    echo '<OPTION>0'.$i;   
						   	else 
						   	    echo '<OPTION>'.$i;   
						/*}  	    */
			   		}
					?>
       				</select>
        			<?php
							$conexion_mes=mysql_query('select d_mes from cat_meses',$cn);
							//f_type_combobox('id_mesboda',$conexion_mes,'-','d_mes','d_mes',$id_bmonth,'','',$ver,'','150px'); por falta de definicion de $ver y $id_bmonth se envia una cadena vacia
							f_type_combobox('id_mesboda',$conexion_mes,'-','d_mes','d_mes','','','','','','150px');
					?>
    </tr>
    <tr>
				<th>NOMBRE DE LA ESPOSA(O)</th>  
				<td><input type="text" name="id_esposa" size="50" style="text-transform:uppercase"></td>
    </tr>
    <tr>
				<th>FECHA DE CUMPLEAÑOS</th>  
				<td>
					<select name="id_diaesposa" style="width:50px">
        			<option></option>
					<?php 
					for($i=1;$i<=31;$i++)
			    	{
				    	/*if( ((int) substr($aa['personal_bday'],0,2)) == $i )
				    	{
				           if($i<10)	
						   	    echo '<OPTION  selected="selected">0'.$i;   
						   	else 
						   	    echo '<OPTION  selected="selected">'.$i;   
				    	}   	    
						else   	
						{*/
						   	if($i<10)
						   	    echo '<OPTION>0'.$i;   
						   	else 
						   	    echo '<OPTION>'.$i;   
						/*}  	    */
			   		}
					?>
       				</select>
        			<?php
							$conexion_mes=mysql_query('select d_mes from cat_meses',$cn);
							//f_type_combobox('id_mesesposa',$conexion_mes,'-','d_mes','d_mes',$id_bmonth,'','',$ver,'','150px'); por falta de definicion de $ver y $id_bmonth se envia una cadena vacia
							f_type_combobox('id_mesesposa',$conexion_mes,'-','d_mes','d_mes','','','','','','150px');
					?> 
				</td>
    </tr>

<tr><td colspan="2">
<!--////////////////////////////////   GRUPO 1  //////////////////////////////////////////-->
<div id="html_6" style=" display:block;visibility:visible;">
<table width="100%" border="0">
<tr>     
	<th>*GRUPO:</th>
	<td>
			<?php 
			$sqlgrup1=mysql_query("select id_grup,d_grupo from cat_grupos order by d_grupo ASC",$cn);
			f_type_combobox('id_grupo1',$sqlgrup1,'','d_grupo','id_grup','','','','','','430px');
			?>

	</td>
	<td>
	Liderazgo
			<?php
			$sqllid=mysql_query('select * from cat_liderazgo',$cn);
			f_type_combobox('id_liderazgo',$sqllid,'','nombre','id','0','','','','','');
			?>			
	</td>
</tr>
<tr> 
	<th>*DEPENDENCIA PRINCIPAL:</th>
	<td>
		    <?php
			$con1=mysql_query('select d_dependencia from cat_dependencias order by d_dependencia ASC',$cn);
			f_type_combobox_filter('combo_zone9','id_dependencia1',$con1,'d_dependencia','d_dependencia','','','430','','','');
			?>
	</td>
	<th>*JERARQUIA:</th>
</tr>
<tr> 
	<th>* CARGO:</td>
	<td> 
		<input type="Text" class="texto" name="id_cargo1" style="width:430px;" style="text-transform:uppercase" value="<?php //if ($_GET['operacion']==3){ echo $aa["trabajo_cargo"];}?>" <?php //echo $ver; comentado por falta de definicion ?> >
	</td>
	<td>
			<?php
			$sqltit1=mysql_query('select * from cat_jerarquias',$cn);
			f_type_combobox('id_titular1',$sqltit1,'','nom_jerarquia','id_jerarquia','','','','','','140');
			
			//$sqltit1=mysql_query('select * from cat_titular',$cn);
			//f_type_combobox('id_titular1',$sqltit1,'','titular','id','','','','','','');
			?>			
	</td>
</tr>
</table>
</div>

<!--////////////////////////////////   GRUPO 2  //////////////////////////////////////////-->
<div id='grup2' >
<table width="100%" border="0">
<tr>     
	<th>GRUPO:</th>
	<td>
			<?php 
			$sqlgrup2=mysql_query("select * from cat_grupos order by d_grupo ASC",$cn);
			f_type_combobox('id_grupo2',$sqlgrup2,'','d_grupo','id_grup','','','','','','430px');
			?>
	</td>
</tr>
<tr> 
	<th>DEPENDENCIA:</th>
	<td>
		    <?php
			$con2=mysql_query('select d_dependencia from cat_dependencias order by d_dependencia ASC',$cn);
			f_type_combobox_filter('combo_zone10','id_dependencia2',$con2,'d_dependencia','d_dependencia','','','430','','','');
			?>
	</td>
	<th>JERARQUIA:</th>
</tr>
<tr> 
	<th>* CARGO:</td>
	<td> 
		<input type="Text" class="texto" name="id_cargo2" style="width:430px;" style="text-transform:uppercase" value="<?php 
		//if ($_GET['operacion']==3){ echo $aa["trabajo_cargo"];}?>" <?php //echo $ver; comentado por falta de definicion?> >
	</td>
	<td>
			<?php
			$sqltit1=mysql_query('select * from cat_jerarquias',$cn);
			f_type_combobox('id_titular2',$sqltit1,'','nom_jerarquia','id_jerarquia','','','','','','140');
			
			//$sqltit1=mysql_query('select * from cat_titular',$cn);
			//f_type_combobox('id_titular2',$sqltit1,'','titular','id','','','','','','');
			?>			
	</td>
</tr>
</table>
</div>

<!--////////////////////////////////   GRUPO 3  //////////////////////////////////////////-->
<div id='grup3' >
<table width="100%" border="0">
<tr>     
	<th>GRUPO:</th>
	<td>
			<?php 
			$sqlgrup3=mysql_query("select * from cat_grupos order by d_grupo ASC",$cn);
			f_type_combobox('id_grupo3',$sqlgrup3,'','d_grupo','id_grup','','','','','','430px');
			?>
	</td>
</tr>
<tr> 
	<th>DEPENDENCIA:</th>
	<td>
		    <?php
			$con3=mysql_query('select d_dependencia from cat_dependencias order by d_dependencia ASC',$cn);
			f_type_combobox_filter('combo_zone11','id_dependencia3',$con3,'d_dependencia','d_dependencia','','','430','','','');
			?>
	</td>
	<th>JERARQUIA:</th>
</tr>
<tr> 
	<th>* CARGO:</td>
	<td> 
		<input type="Text" class="texto" name="id_cargo3" style="width:430px;" style="text-transform:uppercase" value="<?php 
		//if ($_GET['operacion']==3){ echo $aa["trabajo_cargo"];}?>" <?php //echo $ver; comentado por falta de definicion?> >
	</td>
	<td>
			<?php
			$sqltit1=mysql_query('select * from cat_jerarquias',$cn);
			f_type_combobox('id_titular3',$sqltit1,'','nom_jerarquia','id_jerarquia','','','','','','140');
			
			//$sqltit1=mysql_query('select * from cat_titular',$cn);
			//f_type_combobox('id_titular3',$sqltit1,'','titular','id','','','','','','');
			?>			
	</td>
</tr>
</table>
</div>

<!--////////////////////////////////   GRUPO 4  //////////////////////////////////////////-->
<div id='grup4' >
<table width="100%" border="0">
<tr>     
	<th>GRUPO:</th>
	<td>
			<?php 
			$sqlgrup4=mysql_query("select * from cat_grupos order by d_grupo ASC",$cn);
			f_type_combobox('id_grupo4',$sqlgrup4,'','d_grupo','id_grup','','','','','','430px');
			?>
	</td>
</tr>
<tr> 
	<th>DEPENDENCIA:</th>
	<td>
			<?php
			$con4=mysql_query('select d_dependencia from cat_dependencias order by d_dependencia ASC',$cn);
			f_type_combobox_filter('combo_zone12','id_dependencia4',$con4,'d_dependencia','d_dependencia','','','430','','','');
			?>
	</td>
	<th>JERARQUIA:</th>
</tr>
<tr> 
	<th>* CARGO:</td>
	<td> 
		<input type="Text" class="texto" name="id_cargo4" style="width:430px;" style="text-transform:uppercase" value="<?php 
		//if ($_GET['operacion']==3){ echo $aa["trabajo_cargo"];}?>" <?php //echo $ver; comentado por falta de definicion?> >
	</td>
	<td>
			<?php
			$sqltit1=mysql_query('select * from cat_jerarquias',$cn);
			f_type_combobox('id_titular4',$sqltit1,'','nom_jerarquia','id_jerarquia','','','','','','140');
			
			//$sqltit1=mysql_query('select * from cat_titular',$cn);
			//f_type_combobox('id_titular4',$sqltit1,'','titular','id','','','','','','');
			?>			
	</td>
</tr>
</table> 
</div>
<div id="b_tabbar" style="width:100%; height:148px;"></div>



</td></tr>
</table>
</fieldset>

<!--///////////<div id='html_1'>-->
</div>

<!--////////////////////////////////   TAB 2   //////////////////////////////////////////-->
<div id='html_2'>	
<fieldset>
<TABLE width="100%" border="0">	
	<tr>
	      	<th>COLONIA:</th>
	      	<td>
		      		<?php
						$conexion=mysql_query('select d_colonia from cat_colonias group by d_colonia ASC',$cn);
						f_type_combobox_filter('combo_zonea','id_colonia',$conexion,'d_colonia','d_colonia','','',350,'','','');
					?>      
	      	</td>
	</tr>
	<tr>
	    	<th>CODIGO POSTAL:</th>
			<td><input type="Text" name="id_cp"></td>
    </tr>
    <tr>
			<th>CALLE:</th>
		    <td>
		      		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		      		<tr>
		      			<td >
		      			<?php				
							$conexion=mysql_query('select d_clase_calle from cat_clase_calle',$cn);
							f_type_combobox_filter('combo_zone1','id_tipo',$conexion,'d_clase_calle','d_clase_calle','','','100','','','');
						?>
		      			</td>
		      			<td><input type="text" name="id_calle" size="50" style="text-transform:uppercase"></td>
		      			<td valign="top">
		      			<?php
							$conexion3=mysql_query('select cve_sufijo from cat_sufijo_calle',$cn);
							//f_type_combobox('id_sufijo',$conexion3,'-','cve_sufijo','cve_sufijo',$sufijo,'','',$ver,'','50px'); comentado por falta de definicion de $ver y sufijo
							f_type_combobox('id_sufijo',$conexion3,'-','cve_sufijo','cve_sufijo','','','','','','50px');
						?> 
		      			</td>
		      		</tr>
		      		<tr>
		      			<td align="center" >Tipo de Calle</td>						
		      			<td align="center" >Nombre</td>
						<td align="center" >Sufijo</td>
		      		</tr>
		      		</table>        
		    </td>
    </tr>
    <tr>
		<th>*Número</th>
	    <td><input type="text" name="id_numero" onkeypress="return validar(event)" size="5" maxlength="6"></td>
	</tr>
	<tr>
		<th>Lote</th>
		<td><input type="text" name="id_lote" size="5" maxlength="3"></td>
	</tr>
	<tr>
		<th>Manzana</th>  
		<td><input type="text" name="id_manzana" size="5" maxlength="3"></td>
    </tr>
	<tr>
		<th>Referencias del domicilio</th>  
		<td><input type="text" name="referencia_domicilio" size="80" maxlength="250"></td>
    </tr>
</TABLE>
</fieldset>
<label>INVITACIONES</label>
<fieldset>

<TABLE width="100%" border="0">	
	<tr>
			<th>DIA INTERNACIONAL DE LA MUJER</th>
			<th>MAESTRA</th>
	</tr>
	<tr>
			<td align="center"><input type="checkbox" name="diamujer" ></td>
			<td align="center"><input type="checkbox" name="checkmaestra"></td>
	</tr>
</table>
</fieldset>

</div>



<!--==========TAB 4===================================================================================--> 
<div id='html_3'>
<fieldset>
<table width="100%" border="0">
<tr> 
			<th>* TELEFONO OFIC.: </th>
			<td align="center"><input type="Text" class="texto" name="id_telefono_oficina" size="50"></td>      
</tr>
<tr>
			<th>EXT: </th>
			<td align="center"><input type="Text" class="texto" name="id_telefono_ext" size="5"></td>
</tr>
<tr> 
			<th>EXT PRIVADA: </th>
			<td align="center"><input type="Text" class="texto" name="id_ext_privada" size="5"></td>      
</tr>
<tr> 
			<th>* TELEFONO SECUNDARIO.: </th>
			<td align="center"><input type="Text" class="texto" name="id_telefono_secu" size="50"></td>	      
</tr>
<tr> 
		    <th>FAX: </th>
		    <td><input type="Text" class="texto" name="id_fax" maxlength="50" size="50"></td>
</tr>
<tr>
		    <th>EXT. FAX. </th>
		    <td><input type="Text" class="texto" name="id_fax_ext" size="5" ></td>
</tr>
<tr> 
		    <th>CLAVE NEXTEL:</th>
			<td><input type="Text" class="texto" name="id_nextel" size="50" style="text-transform:uppercase"></td>
</tr>
<tr> 
		    <th>@ OFICIAL:</th>
		    <td><input type="Text" name="id_email_oficina" size="50" style="text-transform:lowercase"></td>
</tr>
<tr> 
			<th>PAGINA WEB:</th>
			<td><input type="Text" name="id_web" size="50" style="text-transform:lowercase"></td>	    
</tr>
</table>
</fieldset>
</div> 
<!--==========TAB 5===================================================================================-->   
<div id='html_4'>
<fieldset>
<table width="650px" border="0" cellspacing="2" cellpadding="2" >
<tr>
	      <th>COLONIA:</th>
	      <td>
	      		<?php
				$conexion=mysql_query('select d_colonia from cat_colonias group by d_colonia ASC',$cn);
				f_type_combobox_filter('combo_zone13','id_trab_colonia',$conexion,'d_colonia','d_colonia','','','300','','','');
				?> 
	      </td>
</tr>
<tr>
		<th>C.P.:</th>
	    <td><input type="Text" maxlength="7" name="id_direc_cp" size="12" onkeypress="return validar(event)"></td>
</tr>
<tr>
    	<th>* DIRECCIÓN OFIC.:</th>
      	<td>
      		<table border="0" cellpadding="0" cellspacing="0" width="100%">
      		<tr>
      			<td>
      			<?php
					$conexion12=mysql_query('select d_clase_calle from cat_clase_calle order by d_clase_calle ASC',$cn);
					f_type_combobox_filter('combo_zone14','id_direc_tipo',$conexion12,'d_clase_calle','d_clase_calle','','','100','','','');
				?>
      			</td>
      			<td>
      			<?php
					$conexion13=mysql_query('select nombre from cat_calles group by nombre ASC',$cn);
					f_type_combobox_filter('combo_zone15','id_direc_calle',$conexion13,'nombre','nombre','','','255','','','');
				?>
      			</td>
  
      			<td valign="top">
      			<?php
      			
					$conexion14=mysql_query('select cve_sufijo from cat_sufijo_calle',$cn);
					//f_type_combobox('id_direc_sufijo',$conexion14,'-','cve_sufijo','cve_sufijo',"$sufijo4",'','',$ver,'','50px'); comentado por falta de definicion de $ver y $sufijo4 enviando una cadena vacia
					f_type_combobox('id_direc_sufijo',$conexion14,'-','cve_sufijo','cve_sufijo','','','','','','50px');
				?> 
      			</td>
      		</tr>
      		<tr>
      			<td align="center">Tipo de Calle</td>
      			<td align="center">Nombre</td>
      			<td align="center">Sufijo</td>
      		</tr>
      		</table>        
      </td>
</tr>
<tr>
		    <th>*NÚMERO </th>
	    	<TD>
		    	<input type="text" class="texto" name="id_direc_numero" size="5"   maxlength="6" >
		    	&nbsp;&nbsp;LOTE&nbsp;&nbsp;
		    	<input type="text" class="texto" name="id_direc_lote" size="5" maxlength="6" >
		    	&nbsp;&nbsp;MANZANA&nbsp;&nbsp;
		    	<input type="text" class="texto" name="id_direc_manzana" size="5" maxlength="6" >
	    	</TD>
</tr>
<tr>
	    	<th>ENTRE CALLE:</th>
	      	<td>
			      		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			      		<tr>
			      			<td >
			      			<?php
								$conexion4=mysql_query('select d_clase_calle from cat_clase_calle order by d_clase_calle ASC',$cn);
								f_type_combobox_filter('combo_zone16','id_direc_tipo2',$conexion4,'d_clase_calle','d_clase_calle','','','100','','','');
							?>
			      			</td>
			      			<td>
							<?php
								$conexion13=mysql_query('select nombre from cat_calles group by nombre ASC',$cn);
								f_type_combobox_filter('combo_zone15','id_direc_calle2',$conexion13,'nombre','nombre','','','255','','','');
							?>
						<!--<input type="Text" name="id_direc_calle2" size="50" style="text-transform:uppercase"> COMENTADO POR FALTA DE AJAX-->
							
							</td>	      			
		      			</tr>
			      		<tr>
			      			<td align="center">Tipo de Calle</td>
			      			<td align="center">Nombre</td>
			      		</tr>
			      		</table>        
      		</td>
</tr>
<tr>
  			<th>Y CALLE: </th>
		      <td>
		      		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		      		<tr>
		      			<td >
		      			<?php
							$conexion6=mysql_query('select d_clase_calle from cat_clase_calle order by d_clase_calle ASC',$cn);
							f_type_combobox_filter('combo_zone18','id_direc_tipo3',$conexion6,'d_clase_calle','d_clase_calle','','','100','','','');
						?>
		      			</td>
		      			<td>
						<?php
								$conexion13=mysql_query('select nombre from cat_calles group by nombre ASC',$cn);
								f_type_combobox_filter('combo_zone15','id_direc_calle3',$conexion13,'nombre','nombre','','','255','','','');
						?>
						<!--<input type="Text" name="id_direc_calle3" size="50" style="text-transform:uppercase"> COMENTADO POR FALTA DE AJAX-->
						</td>	  
					</tr>
					<tr>
		      			<td align="center">Tipo de Calle</td>
		      			<td align="center">Nombre</td>
		      		</tr>
		      		</table>        
		      </td>
</tr>
<tr> 
	   		<th>CIUDAD: </th>
	    	<td>
	      			<?php
						$conexion8=mysql_query($sql8='select d_localidad from cat_localidad group by d_localidad ASC',$cn);
						f_type_combobox_filter('combo_zone20','id_direc_ciudad',$conexion8,'d_localidad','d_localidad','','','300','','','');
					?> 
	      	</td>
</tr>
<tr> 
			<th>* MUNICIPIO: </th>
	    	<td>
	      			<?php
						$conexion8=mysql_query('select d_municipio from cat_municipios group by d_municipio ASC',$cn);
						f_type_combobox_filter('combo_zone21','id_direc_municipio',$conexion8,'d_municipio','d_municipio','','','300','','','');
					?> 
	      	</td>
</tr>
<tr> 
			<th>ESTADO: </th>
		    <td>
		      		<?php
							$conexion9=mysql_query('select d_estado from cat_estados group by d_estado ASC',$cn);
							f_type_combobox_filter('combo_zone22','id_direc_estado',$conexion9, 'd_estado','d_estado','','','150','','','');
					?>

		    </td>
</tr>
<tr> 
			<th>RUTA:</th>
			<td><input type="Text" name="id_ruta" size="5"></td>	    
</tr>	
</table>
</fieldset>
</div> 


<!--==========TAB 6 ===================================================================================--> 
<div id='html_5'>
<table border="0" width="100%">
<tr>
			<td>CONTENIDO</td>
</tr>
<tr>
			<td><textarea class="texto" name="id_nota" cols="100" rows="15" style="text-transform:uppercase"></textarea></td>
</tr>
<br/>
<tr>
			<td>GREMIO</td>
</tr>
<tr>
			<td>
			1° elemento: <input type="text" name="elemento1" size="50"><br>   
		    2° elemento: <input type="text" name="elemento2"size="50"><br>   
			3° elemento: <input type="text" name="elemento3" size="50"> <br>  
			4° elemento: <input type="text" name="elemento4" size="50"> <br>  
			5° elemento: <input type="text" name="elemento5" size="50"> <br>  
			</td>
</tr>
</table>
</div>

<!--//////////////////////////////////  CUERPO /////////////////////////////////==================--> 
<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td>
	          <div id="a_tabbar" style="width:100%; height:530px;"/>      
		</td>
		<td width="60px" valign=" baseline">
			<br>
			<br>
			<input type="button" onclick="validar_formulario()" value="Guardar">
			<br>
			<br>
			<!--<input type="button" value="Cancelar" onclick="history.back()" src="inicio.php">-->			
		</td>
	</tr>
</table>
</form>
<script>




	var tabbar = new dhtmlXTabBar("a_tabbar");
	tabbar.setSkin('dhx_black');
	tabbar.setImagePath("../codebase/imgs/");
	tabbar.addTab("a1", "Datos Personales", "130px");
	tabbar.addTab("a2", "Dirección Personal", "140px");
	tabbar.addTab("a3", "Dependencia", "100px");
	tabbar.addTab("a4", "Dirección Dependencia", "200px");
	tabbar.addTab("a5", "Notas", "100px");
	tabbar.setContent("a1", "html_1");
	tabbar.setContent("a2", "html_2");
	tabbar.setContent("a3", "html_3");
	tabbar.setContent("a4", "html_4");
	tabbar.setContent("a5", "html_5");
	tabbar.setTabActive("a1");
	tabbar.attachEvent("onSelect", function() {
      e_log("onSelect", arguments);
	
	
	num=arguments[0];
	
	if(num=='a1'){
		mostrar();
	}else{
		cerrar();
		
	}
    return true;
		
	}
	);

function cerrar() {
div = document.getElementById('b_tabbar');
div.style.display='none';

}
function mostrar() {
	
div = document.getElementById('b_tabbar');
div.style.display='';
}


function e_log(name, data) {
    text = "<b>" + name + "</b> :";
    var d = [];
    for (var i = 0; i < data.length; i++);
    d[i] = data[i];
    text += d.join(",");

}


	//dhxLayout = tabbar.cells("a1").attachLayout("2e");
	//dhxTabbar = dhxLayout.cells("b").attachTabbar();

	dhxTabbar = new dhtmlXTabBar("b_tabbar");
	dhxTabbar.setSkin('dhx_black');
	dhxTabbar.setImagePath("../codebase/imgs/");
	dhxTabbar.addTab("b1", "Grupo Principal", "130px");
	dhxTabbar.addTab("b2", "Grupo 2", "100px");
	dhxTabbar.addTab("b3", "Grupo 3", "100px");
	dhxTabbar.addTab("b4", "Grupo 4", "100px");
	dhxTabbar.setContent("b1", "html_6");
	dhxTabbar.setContent("b2", "grup2");
	dhxTabbar.setContent("b3", "grup3");
	dhxTabbar.setContent("b4", "grup4");
	dhxTabbar.setTabActive("b1");

	
	

</script>

</body>
</html>
