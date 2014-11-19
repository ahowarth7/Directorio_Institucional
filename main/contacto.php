<?php
    include('../include/funciones_v2.php');
	include('../include/conexion_bd.php');

//f_verifica_sesion();

$tipousuario=$_SESSION['d_tipo'];

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="keywords" content="" />
	
	<script src="tabs/jquery.min.js"></script>
	

	
	
	<script src="../codebase/dhtmlxcommon.js"></script>  
	<script src="../codebase/dhtmlxcombo.js"></script>  
	<link rel="STYLESHEET" type="text/css" href="../codebase/dhtmlxcombo.css">
	<link rel="STYLESHEET" type="text/css" href="../codebase/dhtmlxtabbar2.css">	
	<script src="../codebase/dhtmlxwindows.js"></script>
	<script src="../codebase/dhtmlxcontainer.js"></script>
	<link rel="stylesheet" type="text/css" href="../codebase/dhtmlxwindows.css">
	<link rel="stylesheet" type="text/css" href="../codebase/skins/dhtmlxwindows_dhx_black.css">

	
	<script language="javascript" type="text/javascript" src="../codebase/ajax.js"></script>
	
	
	
	<!-- For the tabs -->
	<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->	
	<link href="tabs/jquery-ui.css" rel="stylesheet" type="text/css"/>
	   <script src="tabs/jquery-ui.min.js"></script>
	  <script src="ajax/ajax.js"></script>
	  
	<script>
	  $(document).ready(function() {
		$("#tabs").tabs();
		
		$("#tabsgrupos").tabs();
		
		});	 
		
	function transcribirdp(){
		$("input[name$='id_nombre']").attr("value",$("input[name$='personaQry']").val());
		$("input[name$='id_paterno']").attr("value",$("input[name$='ap_paternoQry']").val());
		$("input[name$='id_materno']").attr("value",$("input[name$='ap_maternoQry']").val());		
		$('.resultadobusqueda').slideUp();
	}		  
	</script>
	<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->  
	<!-- For the tabs -->
	
	
	
	
	
<?php

if(isset($_GET['id_titulo']) && isset($_GET['id_nombre']) && isset($_GET['id_paterno']) && isset($_GET['id_materno']) ){
$id_titulo=optimizar_texto(fullUpper($_GET['id_titulo']));
$id_nombre=strtoupper($_GET['id_nombre']);
$id_paterno=strtoupper($_GET['id_paterno']);
$id_materno=strtoupper($_GET['id_materno']);
$id_sexo=strtoupper($_GET['id_sexo']);
$id_dia=strtolower($_GET['id_dia']);
$id_mes=strtolower($_GET['id_mes']);
$id_casa=strtoupper($_GET['id_casa']); 
$id_celular=strtoupper($_GET['id_celular']);
$id_email=strtolower($_GET['id_email']); 
$id_aniboda=$_GET['id_diaboda']."-".$_GET['id_mesboda'];
$id_esposa=strtoupper($_GET['id_esposa']);
$id_fechaesposa=$_GET['id_diaesposa']."-".$_GET['id_mesesposa'];


$id_colonia=optimizar_texto(fullUpper($_GET['id_colonia'])); 
$id_cp=strtoupper($_GET['id_cp']);
$id_tipo=optimizar_texto(fullUpper($_GET['id_tipo']));
$id_calle=optimizar_texto(fullUpper($_GET['id_calle']));
$id_sufijo=strtoupper($_GET['id_sufijo']);
$id_numero=strtoupper($_GET['id_numero']); 
$id_lote=strtoupper($_GET['id_lote']); 
$id_manzana=strtoupper($_GET['id_manzana']);

if($_GET['referencia_domicilio']=='UNDEFINED'){
	$referencia_domicilio="";
}else{
	$referencia_domicilio=strtoupper($_GET['referencia_domicilio']);
}

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


if($id_grupo1 == '354')	{
	$id_grupo1=0;
}else{
	$id_grupo1=strtoupper($_GET['id_grupo1']); 
}


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
$id_dependencia1=optimizar_texto(fullUpper($_GET['id_dependencia1']));
$id_cargo1=strtoupper($_GET['id_cargo1']);
$id_titular1=strtoupper($_GET['id_titular1']);
$id_grupo2=strtoupper($_GET['id_grupo2']);			
$id_dependencia2=optimizar_texto(fullUpper($_GET['id_dependencia2']));
$id_cargo2=strtoupper($_GET['id_cargo2']);
$id_titular2=strtoupper($_GET['id_titular2']);
$id_grupo3=strtoupper($_GET['id_grupo3']);			
$id_dependencia3=optimizar_texto(fullUpper($_GET['id_dependencia3']));
$id_cargo3=strtoupper($_GET['id_cargo3']);
$id_titular3=strtoupper($_GET['id_titular3']);
$id_grupo4=strtoupper($_GET['id_grupo4']);			
$id_dependencia4=optimizar_texto(fullUpper($_GET['id_dependencia4']));
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



$id_trab_colonia=optimizar_texto(fullUpper($_GET['id_trab_colonia']));
$id_direc_cp=strtoupper($_GET['id_direc_cp']);
$id_direc_tipo=optimizar_texto(fullUpper($_GET['id_direc_tipo']));
$id_direc_calle=optimizar_texto(fullUpper($_GET['id_direc_calle']));
$id_direc_sufijo=strtoupper($_GET['id_direc_sufijo']);
$id_direc_numero=strtoupper($_GET['id_direc_numero']);
$id_direc_lote=strtoupper($_GET['id_direc_lote']);
$id_direc_manzana = strtoupper($_GET['id_direc_manzana']);

$id_direc_tipo2=optimizar_texto(fullUpper($_GET['id_direc_tipo2']));
$id_direc_calle2=optimizar_texto(fullUpper($_GET['id_direc_calle2']));

$id_direc_tipo3=optimizar_texto(fullUpper($_GET['id_direc_tipo3']));
$id_direc_calle3=optimizar_texto(fullUpper($_GET['id_direc_calle3']));

$id_direc_ciudad=optimizar_texto(fullUpper($_GET['id_direc_ciudad']));
$id_direc_municipio=optimizar_texto(fullUpper($_GET['id_direc_municipio']));
$id_direc_estado=optimizar_texto(fullUpper($_GET['id_direc_estado']));
$id_ruta=strtoupper($_GET['id_ruta']);
$referencia_domicilio_trabajo =strtoupper($_GET['referencia_domicilio_trabajo']);


if($_GET['id_nota']=='UNDEFINED'){
	$id_nota='';
}else{
	$id_nota=strtoupper($_GET['id_nota']);
}

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
		nota, t_referencia_domicilio,fecha_alta,visible,usuario)
		
		values
		
		('$id_cat','$id_titulo','$id_nombre','$id_paterno','$id_materno','$id_sexo','$id_dia','$id_mes','$id_casa','$id_celular','$id_email','$id_aniboda','$id_esposa','$id_fechaesposa',
		'$id_colonia','$id_cp','$id_tipo','$id_calle','$id_sufijo','$id_numero','$id_lote','$id_manzana','$referencia_domicilio','$id_diamujer','$id_checkmaestra',
		'$id_grupo1','$id_liderazgo','$id_cargo1','$id_dependencia1','$id_titular1','$id_grupo2','$id_cargo2','$id_dependencia2','$id_titular2','$id_grupo3','$id_cargo3','$id_dependencia3','$id_titular3','$id_grupo4','$id_cargo4','$id_dependencia4','$id_titular4',
		'$id_telefono_oficina','$id_telefono_ext','$id_ext_privada','$id_telefono_secu','$id_fax','$id_fax_ext','$id_nextel','$id_email_oficina','$id_web',
		'$id_trab_colonia','$id_direc_cp','$id_direc_tipo','$id_direc_calle','$id_direc_sufijo','$id_direc_numero','$id_direc_lote','$id_direc_manzana','$id_direc_tipo2','$id_direc_calle2',
        '$id_direc_tipo3','$id_direc_calle3','$id_direc_ciudad','$id_direc_municipio','$id_direc_estado','$id_ruta',
        '$id_nota','$referencia_domicilio_trabajo','$fecha_alta','$visible','$usuario')",$cn);
		
		echo "<script>
				alert('Los datos fueron ingresados correctamente y Fueron Guardados');
				$('#formulario').each (function(){
						this.reset();
				});
				</script>";
		//echo '<script>alert("->'.$_GET['referencia_domicilio'].'<-")</script>';
		
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
if ($("input[name$='id_grupo1']").val()==354){ 
alert("Debe seleccionar un grupo.") ;
document.formulario.id_grupo1.focus() ;
return 0; 
} 
 
if (document.formulario.id_cargo1.value.length==0){ 
alert("Debe ingresar el Cargo") 
document.formulario.id_cargo1.focus() 
return 0; 
} 
if ($("input[name$='id_dependencia1']").val()==''){ 
alert("Selecciones una dependencia") 
document.formulario.id_dependencia1.focus() 
return 0; 
}  
if (document.formulario.id_titular1.selectedIndex==0){ 
alert("Selecciones si es titular u otro rango") 
document.formulario.id_titular1.focus() 
return 0; 
} 
 
//document.formulario.submit(); 

id_nombre = $("input[name$='id_nombre']").val();
id_paterno = $("input[name$='id_paterno']").val();
id_sexo = $("select[name$='id_sexo'] option:selected").val();

id_grupo1 = $("input[name$='id_grupo1']").val();
id_cargo1 = $("input[name$='id_cargo1']").val();

id_dependencia1 = $("input[name$='id_dependencia1']").val();
id_titular1 = $("select[name$='id_titular1'] option:selected").val();

ajax=nuevoAjax();	
	ajax.open("GET", "contacto.php?id_titulo="+id_titulo+"&id_nombre="+id_nombre+
								 "&id_paterno="+id_paterno+"&id_materno="+id_materno+
								 "&id_sexo="+id_sexo+"&id_dia="+id_dia+
								 "&id_mes="+id_mes+"&id_casa="+id_casa+
								 "&id_celular="+id_celular+"&id_email="+id_email+
								 "&id_diaboda="+id_diaboda+"&id_mesboda="+id_mesboda+
								 "&id_esposa="+id_esposa+"&id_diaesposa="+id_diaesposa+
								 "&id_mesesposa="+id_mesesposa+
								 
								 "&id_colonia="+id_colonia+"&id_cp="+id_cp+
								 "&id_tipo="+id_tipo+"&id_calle="+id_calle+								 
								 "&id_sufijo="+id_sufijo+"&id_numero="+id_numero+
								 "&id_lote="+id_lote+"&id_manzana="+id_manzana+
								 "&referencia_domicilio="+referencia_domicilio+
								 "&diamujer="+diamujer+"&checkmaestra="+checkmaestra+
								 
								 "&id_grupo1="+id_grupo1+"&id_liderazgo="+id_liderazgo+
								 "&id_dependencia1="+id_dependencia1+"&id_cargo1="+id_cargo1+
								 "&id_titular1="+id_titular1+"&id_grupo2="+id_grupo2+
								 "&id_dependencia2="+id_dependencia2+"&id_cargo2="+id_cargo2+
								 "&id_grupo3="+id_grupo3+"&id_dependencia3="+id_dependencia3+
								 "&id_cargo3="+id_cargo3+"&id_titular3="+id_titular3+
								 "&id_grupo4="+id_grupo4+"&id_dependencia4="+id_dependencia4+
								 "&id_cargo4="+id_cargo4+"&id_titular4="+id_titular4+
								 
								 "&id_telefono_oficina="+id_telefono_oficina+
								 "&id_telefono_ext="+id_telefono_ext+
								 "&id_ext_privada="+id_ext_privada+
								 "&id_telefono_secu="+id_telefono_secu+
								 "&id_fax="+id_fax+"&id_fax_ext="+id_fax_ext+
								 "&id_nextel="+id_nextel+"&id_email_oficina="+id_email_oficina+								 
								 "&id_web="+id_web+
								 
								 "&id_trab_colonia="+id_trab_colonia+"&id_direc_cp="+id_direc_cp+
								 "&id_direc_tipo="+id_direc_tipo+"&id_direc_calle="+id_direc_calle+
								 "&id_direc_sufijo="+id_direc_sufijo+"&id_direc_numero="+id_direc_numero+
								 "&id_direc_lote="+id_direc_lote+"&id_direc_manzana="+id_direc_manzana+
								 
								 "&id_direc_tipo2="+id_direc_tipo2+"&id_direc_calle2="+id_direc_calle2+
								 
								 "&id_direc_tipo3="+id_direc_tipo3+"&id_direc_calle3="+id_direc_calle3+
								 
								 "&id_direc_ciudad="+id_direc_ciudad+"&id_direc_municipio="+id_direc_municipio+
								 "&id_direc_estado="+id_direc_estado+"&id_ruta="+id_ruta+
								 "&referencia_domicilio_trabajo="+referencia_domicilio_trabajo+
								 "&id_nota="+id_nota);
	
		ajax.onreadystatechange=function()
   	{
      if (ajax.readyState==4)
      {
         //contenedor.innerHTML = ajax.responseText;
		 //$('.resultadobusqueda').slideDown(); 
		 //$("form[name$='formulario']").reset();
		 alert('Los datos han sido guardados correctamente');
		  $("form[name$='formulario']").each (function(){
						this.reset();
						$("input").attr("value","");
						$("input[name$='btnguardar']").attr("value","Guardar");
						$("input[name$='btncancelar']").attr("value","Cancelar");
						//alert('entra pero no resetea');
				});
      }
   	}
   	ajax.send(null);

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

//alert($("input[name$='id_grupo1']").val());

if ($("input[name$='id_grupo1']").val()==354){ 
alert("Debe seleccionar un grupo.") ;
document.formulario.id_grupo1.focus() ;
return 0; 
} 

//alert($("input[name$='id_dependencia1']").val());

if ($("input[name$='id_dependencia1']").val()==''){ 
alert("Selecciones una dependencia") 
document.formulario.id_dependencia1.focus() 
return 0; 
} 

if (document.formulario.id_cargo1.value.length==0){ 
alert("Debe ingresar el Cargo") 
document.formulario.id_cargo1.focus() 
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

//alert($("input[name$='id_direc_tipo']").val());
if ($("input[name$='id_direc_tipo']").val()==''){ 
alert("Debe seleccionar el tipo de calle de la dependencia") 
document.formulario.id_direc_tipo.focus() 
return 0; 
}

//alert($("input[name$='id_direc_calle']").val());
if ($("input[name$='id_direc_calle']").val()==''){ 
alert("Debe seleccionar la calle de la dependencia") 
document.formulario.id_direc_calle.focus() 
return 0; 
}

if (document.formulario.id_direc_numero.value.length==0 && 
	(document.formulario.id_direc_lote.value.length==0 ||
	document.formulario.id_direc_manzana.value.length==0)){ 
	
	alert("Debe introducir el número de la dirección de la dependencia") 
	document.formulario.id_direc_calle.focus() 
	return 0; 
}

//alert($("input[name$='id_direc_municipio']").val());
if ($("input[name$='id_direc_municipio']").val()==''){ 
alert("Debe seleccionar el municipio de dependencia") 
document.formulario.id_direc_municipio.focus() 
return 0; 
} 





id_titulo = $("select[name$='id_titulo'] option:selected").val(); //$('select.foo option:selected').val(); 
id_nombre = $("input[name$='id_nombre']").val();
id_paterno = $("input[name$='id_paterno']").val();
id_materno = $("input[name$='id_materno']").val();
id_sexo = $("select[name$='id_sexo'] option:selected").val()
id_dia = $("select[name$='id_dia'] option:selected").val()
id_mes = $("select[name$='id_mes'] option:selected").val()
id_casa = $("input[name$='id_casa']").val();
id_celular = $("input[name$='id_celular']").val();
id_email = $("input[name$='id_email']").val();
id_diaboda = $("select[name$='id_diaboda'] option:selected").val()
id_mesboda = $("select[name$='id_mesboda'] option:selected").val()

id_esposa = $("input[name$='id_esposa']").val();
id_diaesposa = $("select[name$='id_diaesposa'] option:selected").val()
id_mesesposa = $("select[name$='id_mesesposa'] option:selected").val()


//--------------------------


id_colonia = $("input[name$='id_colonia']").val();
id_cp = $("input[name$='id_cp']").val();
id_tipo = $("input[name$='id_tipo']").val();
id_calle = $("input[name$='id_calle']").val();
id_sufijo = $("select[name$='id_sufijo'] option:selected").val()
id_numero = $("input[name$='id_numero']").val();
id_lote = $("input[name$='id_lote']").val();
id_manzana = $("input[name$='id_manzana']").val();
referencia_domicilio = $("input[name$='referencia_domicilio']").val();
diamujer = $("input[name$='diamujer']:checked").val()
checkmaestra = $("input[name$='checkmaestra']:checked").val()

//--------------------------

//alert('tan siquiera jalo la segunda pantalla');

id_grupo1 = $("input[name$='id_grupo1']").val();
id_liderazgo = $("select[name$='id_liderazgo'] option:selected").val()
id_dependencia1 = $("input[name$='id_dependencia1']").val();
id_cargo1 = $("input[name$='id_cargo1']").val();
id_titular1 = $("select[name$='id_titular1'] option:selected").val()
id_grupo2 = $("input[name$='id_grupo2']").val();
id_dependencia2 = $("input[name$='id_dependencia2']").val();
id_cargo2 = $("input[name$='id_cargo2']").val();
id_titular2 = $("select[name$='id_titular2'] option:selected").val()
id_grupo3 = $("input[name$='id_grupo3']").val();
id_dependencia3 = $("input[name$='id_dependencia3']").val();
id_cargo3 = $("input[name$='id_cargo3']").val();
id_titular3 = $("select[name$='id_titular3'] option:selected").val()
id_grupo4 = $("input[name$='id_grupo4']").val();
id_dependencia4 = $("input[name$='id_dependencia4']").val();
id_cargo4 = $("input[name$='id_cargo4']").val();
id_titular4 = $("select[name$='id_titular4'] option:selected").val()

//----------------------------


id_telefono_oficina = $("input[name$='id_telefono_oficina']").val();
id_telefono_ext = $("input[name$='id_telefono_ext']").val();
id_ext_privada = $("input[name$='id_ext_privada']").val();
id_telefono_secu = $("input[name$='id_telefono_secu']").val();
id_fax = $("input[name$='id_fax']").val();
id_fax_ext = $("input[name$='id_fax_ext']").val();
id_nextel = $("input[name$='id_nextel']").val();
id_email_oficina = $("input[name$='id_email_oficina']").val();
id_web = $("input[name$='id_web']").val();

//-----------------------------

id_trab_colonia = $("input[name$='id_trab_colonia']").val();
id_direc_cp = $("input[name$='id_direc_cp']").val();
id_direc_tipo = $("input[name$='id_direc_tipo']").val();
id_direc_calle = $("input[name$='id_direc_calle']").val();
id_direc_sufijo = $("select[name$='id_direc_sufijo'] option:selected").val()
id_direc_numero = $("input[name$='id_direc_numero']").val();
id_direc_lote = $("input[name$='id_direc_lote']").val();
id_direc_manzana = $("input[name$='id_direc_manzana']").val();

//----------------------------
id_direc_tipo2 = $("input[name$='id_direc_tipo2']").val();
id_direc_calle2 = $("input[name$='id_direc_calle2']").val();

//------------------------

id_direc_tipo3 = $("input[name$='id_direc_tipo3']").val();
id_direc_calle3 = $("input[name$='id_direc_calle3']").val();

//-----------------------
id_direc_ciudad = $("input[name$='id_direc_ciudad']").val();
id_direc_municipio = $("input[name$='id_direc_municipio']").val();
id_direc_estado = $("input[name$='id_direc_estado']").val();
id_ruta = $("input[name$='id_ruta']").val();
referencia_domicilio_trabajo = $("input[name$='referencia_domicilio_trabajo']").val();

//---------------------
id_nota = $("textarea[name$='id_nota']").val();




	ajax=nuevoAjax();	
	ajax.open("GET", "contacto.php?id_titulo="+id_titulo+"&id_nombre="+id_nombre+
								 "&id_paterno="+id_paterno+"&id_materno="+id_materno+
								 "&id_sexo="+id_sexo+"&id_dia="+id_dia+
								 "&id_mes="+id_mes+"&id_casa="+id_casa+
								 "&id_celular="+id_celular+"&id_email="+id_email+
								 "&id_diaboda="+id_diaboda+"&id_mesboda="+id_mesboda+
								 "&id_esposa="+id_esposa+"&id_diaesposa="+id_diaesposa+
								 "&id_mesesposa="+id_mesesposa+
								 
								 "&id_colonia="+id_colonia+"&id_cp="+id_cp+
								 "&id_tipo="+id_tipo+"&id_calle="+id_calle+								 
								 "&id_sufijo="+id_sufijo+"&id_numero="+id_numero+
								 "&id_lote="+id_lote+"&id_manzana="+id_manzana+
								 "&referencia_domicilio="+referencia_domicilio+
								 "&diamujer="+diamujer+"&checkmaestra="+checkmaestra+
								 
								 "&id_grupo1="+id_grupo1+"&id_liderazgo="+id_liderazgo+
								 "&id_dependencia1="+id_dependencia1+"&id_cargo1="+id_cargo1+
								 "&id_titular1="+id_titular1+"&id_grupo2="+id_grupo2+
								 "&id_dependencia2="+id_dependencia2+"&id_cargo2="+id_cargo2+
								 "&id_grupo3="+id_grupo3+"&id_dependencia3="+id_dependencia3+
								 "&id_cargo3="+id_cargo3+"&id_titular3="+id_titular3+
								 "&id_grupo4="+id_grupo4+"&id_dependencia4="+id_dependencia4+
								 "&id_cargo4="+id_cargo4+"&id_titular4="+id_titular4+
								 
								 "&id_telefono_oficina="+id_telefono_oficina+
								 "&id_telefono_ext="+id_telefono_ext+
								 "&id_ext_privada="+id_ext_privada+
								 "&id_telefono_secu="+id_telefono_secu+
								 "&id_fax="+id_fax+"&id_fax_ext="+id_fax_ext+
								 "&id_nextel="+id_nextel+"&id_email_oficina="+id_email_oficina+								 
								 "&id_web="+id_web+
								 
								 "&id_trab_colonia="+id_trab_colonia+"&id_direc_cp="+id_direc_cp+
								 "&id_direc_tipo="+id_direc_tipo+"&id_direc_calle="+id_direc_calle+
								 "&id_direc_sufijo="+id_direc_sufijo+"&id_direc_numero="+id_direc_numero+
								 "&id_direc_lote="+id_direc_lote+"&id_direc_manzana="+id_direc_manzana+
								 
								 "&id_direc_tipo2="+id_direc_tipo2+"&id_direc_calle2="+id_direc_calle2+
								 
								 "&id_direc_tipo3="+id_direc_tipo3+"&id_direc_calle3="+id_direc_calle3+
								 
								 "&id_direc_ciudad="+id_direc_ciudad+"&id_direc_municipio="+id_direc_municipio+
								 "&id_direc_estado="+id_direc_estado+"&id_ruta="+id_ruta+
								 "&referencia_domicilio_trabajo="+referencia_domicilio_trabajo+								 
								 "&id_nota="+id_nota);
	
		ajax.onreadystatechange=function()
   	{
      if (ajax.readyState==4)
      {
         //contenedor.innerHTML = ajax.responseText;
		 //$('.resultadobusqueda').slideDown(); 
		 //$("form[name$='formulario']").reset();
		 alert('Los datos han sido guardados correctamente');
		 $("form[name$='formulario']").each (function(){
						this.reset();
						$("input").attr("value","");
						$("input[name$='btnguardar']").attr("value","Guardar");
						$("input[name$='btncancelar']").attr("value","Cancelar");
						//alert('entra pero no resetea');
				});
      }
   	}
   	ajax.send(null);
} 
</script>


<?php
//fin de else de validación para los demás usuarios
}
?>

<script language="javascript">

function validador(div)
{	

if (document.getElementById('idnombre').value.length==0){ 
alert("Debe ingresar su nombre") 
document.formulario.id_nombre.focus() 
return 0; 
} 
	 
	div="resultadobusqueda";
	contenedor = document.getElementById(div);
	nombre=document.getElementById('idnombre').value;		
	paterno=document.getElementById('idpaterno').value;
	materno=document.getElementById('idmaterno').value;
	//grupo=document.formulario.id_grupo1.value;	
	
	
	ajax=nuevoAjax();	
	ajax.open("GET", "ajax_contactos.php?opcion=17&nombre="+nombre+"&paterno="+paterno+"&materno="+materno);
	
		ajax.onreadystatechange=function()
   	{
      if (ajax.readyState==4)
      {
         contenedor.innerHTML = ajax.responseText;
		 $('.resultadobusqueda').slideDown(); 
      }
   	}
   	ajax.send(null);
}
</script> 

<style>
body{
	margin-left:auto;
	margin-right:auto;
	text-align:center;
	margin-top:0px;
}
.menu{
	width:1000px;
	height:50px;
	background-image:url('../imagenes/menuTop_button.jpg');
	margin-left:auto;
	margin-right:auto;
	font-size:12px;
	font-family:tahoma;
	font-weight:bold;	
	
}
					.menu ul
					{
					margin: 0;
					padding: 0;
					list-style-type: none;
					text-align: center;
					}

					.menu ul li { display: inline;  margin-right:30px;  }

					.menu ul li a
					{
					text-decoration: none;
					/*padding: .2em 1em;*/					
					color: #fff;
					/*background-color: #036;*/
					
					}

					.menu ul li a:hover
					{
					color: #fff;
					
					}
					table{
					font-family: Arial, Helvetica, sans-serif;
					font-size:10px;
					color:#ffffff;
					float:left;
					margin-left:90px;
					text-align:center;
					font-weight:bold;
					padding-top:10px;
					}

.busqueda{
	width:1000px;
	height:40px;
	background-color:#cccaca;
	margin-left:auto;
	margin-right:auto;
	font-family:arial;
	font-size:12px;
	font-weight:bold;	
}

	.inputgrande{
		width:400px !important;
	}

	.inputmediano{
		width:200px !important;
	}
	.inputpeque{
		width:100px !important;
	}
	
	.inputpequepk{
		width:50px !important;
	}
	

.formagregar{
	width:1000px;
	height:400px;
	/*background-color:green;*/
	margin-left:auto;
	margin-right:auto;
	font-size:12px !important;	
}

.div_grupos{
	margin:1px solid #eee; 
	float:right; 
	width:350px; 
	height:310px; 
	
	position:absolute; 
	display: inline;
	top:50px; 
	left:640px;
}

.resultadobusqueda{
	width:1000px;
	height:100px;
	background-color:#e8e8e8;	
	margin-left:auto;
	margin-right:auto;
	display:none;
	overflow:auto;
	font-family:tahoma;
	font-size:11px;
	border: 1px solid #aaa;
}

.izq{
	text-align: left;
	width: 100px;
	height: 40px;
	float: left;
	
	}
.der{
	text-align: left;
	width: 240px;
	height: 40px;
	float: left;

}

.botonescontrol{
	margin-left:auto;
	margin-right:auto;
	text-align:center;
	width:120px;
	height:20px;
	/*background-color:orange;	*/
	display: inline;
	float:left;
	position:absolute;
	top:100px;
	/*background-color:orange;*/
	right:250px;
}

.botonescontrol input{
	margin-left:10px;
	margin-right:auto;		
}
.botonescontrol img{
	border:0px;
	cursor: pointer;
}

</style>

<script type="text/javascript" charset="utf-8">

//Muestra y oculta el div de los resultados de búsqueda
function showandhide(){

	var objeto = document.getElementById('resultadobusqueda');

	if(objeto.style.display=='block'){		
		$('.resultadobusqueda').slideUp(); 
	}
	else{
		$('.resultadobusqueda').slideDown(); 
	}
	
	

}

///////////////////////////  BUSCAR NOMBRES /////////////////////
function cargar_grupos(div)
{	
	
   	var contenedor;
   	contenedor = document.getElementById(div);
	//id_persona= document.form.persona.value;	
	
	id_persona= document.getElementById('personaQry').value;	
	id_apaterno= document.getElementById('ap_paternoQry').value;	
	id_amaterno= document.getElementById('ap_maternoQry').value;	
	
	//Hide if haven´t text
	if(id_persona=='' && id_apaterno == '' && id_amaterno== ''){
		$('.resultadobusqueda').slideUp(); 			
		//Simplemente ocultar en dado caso que esten vacios los campos
		
	//Show if it have text
	}else{
		var aleatorio = Math.random();
		
		ajax=nuevoAjax();
		ajax.open("GET", "../ajax/ajax_buscarnombre_ac.php?id_persona="+id_persona+"&id_apaterno="+id_apaterno+"&id_amaterno="+id_amaterno+"&ale="+aleatorio);

		ajax.onreadystatechange=function()
		{
		  if (ajax.readyState==4)
		  {
			 contenedor.innerHTML = ajax.responseText;			 
			 //$('.resultadobusqueda').slideDown(); 
			 
			 
			 //Validación donde si encuentra algún registro pone el botón para nuevo registro
			var stringer = ajax.responseText;
			if (stringer.indexOf("td") == -1){
				$('#btnshow').html("<input value='nuevo' style='background-color:#7DB1FF' size='5' type='button' onClick='javascript:transcribirdp()' />");
				$('.resultadobusqueda').slideUp();		
			}
			else{						
				$('#btnshow').html('<a  onclick="javascript:showandhide();" href="#">(ver/esconder)</a>');
				$('.resultadobusqueda').slideDown(); 
			}
			

			 
		  }
		}
		ajax.send(null);
	}
}

</script>

<script type="text/javascript">
function editar(id)
	{				
		window.open("contacto_editar.php?operacion=3&id="+id+"","ventana1","width=1000, height=530, scrollbars=no, menubar=no, location=no, resizable=no");
		window.close();
		self.close();
		
	}
	
function panel()
	{
		window.location="../main/tablerodecontrol.php";
	}	
</script>



<!-- Pretty Forms -->
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->  

	<script type="text/javascript">
	/*
	function showFormData(frm){
		message="The values of the form are: \n-------------------------------------\n";
		message+="text area = \t" + frm.textarea.value + "\n\n";
		message+="textbox = \t" + frm.textbox.value + "\n\n";
		message+="select box = \t" + frm.selectMenu[frm.selectMenu.selectedIndex].innerHTML + "\n\n";
		message+="checkboxes = \t" + frm.checkbox1.checked + ", " + frm.checkbox2.checked + ", " + frm.checkbox3.checked + "\n\n";
		if(frm.radioButtons[0].checked){
			message+="radio buttons = \t" + frm.radioButtons[0].value + "\n\n";
		}else if(frm.radioButtons[1].checked){
			message+="radio buttons = \t" + frm.radioButtons[1].value + "\n\n";
		}else if(frm.radioButtons[2].checked){
			message+="radio buttons = \t" + frm.radioButtons[2].value + "\n\n";
		}
		window.alert(message);
		return false;
	}
	
	function doSomething(){
		showText = document.getElementById("signalEvent");
		showText.innerHTML = "You triggered an event";
		setTimeout("showText.innerHTML = '&nbsp;'",1000)
	}
	
	*/
	</script>
	<!--<script type="text/javascript" src="prettyForms/prettyForms.js"></script>-->
	<link rel="stylesheet" href="prettyForms/prettyForms.css" type="text/css" media="screen" />
	<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->  
	<!-- Pretty Forms -->
	
	<script>
	function mostrartodo(){		
		$("#body").css("display","block");
		$("#cargador").css("display","none");
	}
	</script>

</head>
<!--<body>-->
<body onLoad="mostrartodo()" >

<div id="cargador" style="margin-top:100px;font-family:tahoma;font-size:16px;font-weight:bold;"><center><img src="images/zoomloader.gif" /> Cargando...</center></div>
<div id="body" style="display:none">



<?php $call="../"; ?>

<!-- MENU -->
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<div class="menu">
	
	<ul>
		<!--<li style="background-image:url('../imagenes/menuTop_button_on.png');"><a href="<?php echo $call; ?>main/contacto.php">AGREGAR CONTACTOS</a></li>-->
		<li><a href="contacto.php"><table style="color:yellow;" ><tr><td>AGREGAR</td></tr><tr><td>CONTACTOS</td></tr></table></a></li>
		
		<li><a href="../modificar.php"><table><tr><td>MODIFICAR</td></tr><tr><td>EL DIRECTORIO</td></tr></table></a></li>
		<li><a href="#" onClick="javascript:w_imrpimir();"><table><tr><td>REPORTES</td></tr></table></a></li>
		<?php if($tipousuario=="Administrador"){?>
		<li><a href="#" onClick="javascript:panel();" style="cursor:hand;"><table class="table"><tr><td>PANEL</td></tr><tr><td>DE USUARIOS</td></tr></table></a></li>
		<?php }	?>
		<li><a href="#" onClick="javascript:catalogo();"><table><tr><td>CATÁLOGOS</td></tr></table></a></li>
		<li><a href="../inicio.php"><table><tr><td>INICIO</td></tr></table></a></li>
	</ul>
</div>
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<!-- MENU -->

<!-- FORM DE BUSQUEDA -->
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<div class="busqueda">
<br/>
<!--	
	<label>Nombre :</label> <input name="idnombre" id="idnombre" style="text-transform:uppercase;" />&nbsp;&nbsp;&nbsp;&nbsp;
	<label>A. Paterno:</label><input name="idpaterno" id="idpaterno" style="text-transform:uppercase;" onKeyUp="javascript:validador('resultadobusqueda');"/>&nbsp;&nbsp;&nbsp;&nbsp;
	<label>A. Materno:</label><input name="idmaterno" id="idmaterno" style="text-transform:uppercase;" onKeyUp="javascript:validador('resultadobusqueda');"/>&nbsp;&nbsp;&nbsp;&nbsp;	
-->	
<label style="width:30px !important;">&nbsp;</label>
<label class="labelpeque" style="height:20px !important;width:100px !important;">Nombre :</label>
<input type="text" size="32" name="personaQry" id="personaQry" style="text-transform:uppercase;widht:100px;" onKeyUp="javascript:cargar_grupos('resultadobusqueda');" autocomplete="off">
<label class="labelpeque" style="height:20px !important;width:100px !important;">A. Paterno :</label>
<input type="text" size="32" name="ap_paternoQry" id="ap_paternoQry" style="text-transform:uppercase;widht:100px;" onKeyUp="javascript:cargar_grupos('resultadobusqueda');" autocomplete="off">
<label class="labelpeque" style="height:20px !important;width:100px !important;">A. Materno :</label>
<input type="text" size="32" name="ap_maternoQry" id="ap_maternoQry" style="text-transform:uppercase;widht:100px;" onKeyUp="javascript:cargar_grupos('resultadobusqueda');" autocomplete="off">

<div id="btnshow"><a  onclick="javascript:showandhide();" href="#">(ver/esconder)</a></div>
</div>
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<!-- FORM DE BUSQUEDA -->






<!--FORM Y TABS-->
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<div class="formagregar" >
		<div id="tabs">
		<ul>	
			<li><a href="#fragment-1"><span>Datos generales</span></a></li>
			<li><a href="#fragment-2"><span>Dirección personal</span></a></li>
			<li><a href="#fragment-3"><span>Dependencia</span></a></li>
			<li><a href="#fragment-4"><span>Dirección dependencia</span></a></li>
			<li><a href="#fragment-5"><span>Notas</span></a></li>
		</ul>
		
		
		<div id="fragment-1">
        	<div id="form_container">
				<FORM NAME="formulario" METHOD="get" onSubmit="return valida(this);">
					<input type="hidden" name="operacion">
					<input type="hidden" name="tipo">
					<input type="hidden" name="id">
	
			
		
			<label><strong>Titulo:</strong> </label>			
			<?php
				$rdsquery1=mysql_query('select d_titulos from cat_titulos order by d_titulos ASC',$cn);
				f_type_combobox('id_titulo',$rdsquery1,'','d_titulos','d_titulos','','','onchange="doSomething()"','','','');
			?>
			
		
		
		
			<label class="labelpeque"><strong>Nombre: </strong></label>
			<input name="id_nombre" type="text" style="text-transform:uppercase;"  value="" />
			<input name="id_paterno" type="text" style="text-transform:uppercase;"  value="" />
			<input name="id_materno" type="text" style="text-transform:uppercase;"   value="" />
			<br class="clearAll" /><br />
	
		
		
			<label ><strong>Sexo:</strong> </label>
			<select name="id_sexo">
		        	<option selected></option>
		        	<option>H</option>
		        	<option>M</option>
			</select>	
			
			<br class="clearAll" /><br />
		
		
			<label><strong>Fecha de cumpleaños:</strong> </label>
			<select name="id_dia" onChange="doSomething()">
				<option selected="selected"></option>
			<?php 
			for($i=1;$i<=31;$i++)
			    {
			    	   	if($i<10)
					   	    echo '<option>0'.$i.'</option>';   
					   	else 
					   	    echo '<option>'.$i.'</option>';   
					
			    }		 
			?>
			</select>
			<?php
							$conexion_mes=mysql_query('select d_mes from cat_meses',$cn);
							//f_type_combobox('id_mes',$conexion_mes,'-','d_mes','d_mes',$id_bmonth,'','',$ver,'','150px'); por falta de definicion de $ver y $id_bmonth ...se envia una cadena vacia
							f_type_combobox('id_mes',$conexion_mes,'-','d_mes','d_mes','','','','','','150px');
			?> 
			<br class="clearAll" /><br />
		
		
		
			<label><strong>Teléfono de casa: </strong></label>
			<input name="id_casa" type="text" onFocus="doSomething()" value="" />
			<label class="labelpeque"><strong>Celular: </strong></label>
			<input name="id_celular" type="text" onFocus="doSomething()" value="" />
			
		
			<label class="labelpeque"><strong>E-mail Personal: </strong></label>
			<input name="id_email" type="text" onFocus="doSomething()" value="" />			
			<br class="clearAll" /><br />
		
			<label><strong>Aniversario de bodas:</strong> </label>
			<select name="id_diaboda" onChange="doSomething()">
				<option></option>
				<?php 
					for($i=1;$i<=31;$i++)
			    	{			    	
						   	if($i<10)
						   	    echo '<OPTION value="0'.$i.'">0'.$i.'</option>';   
						   	else 
						   	    echo '<OPTION value="'.$i.'">'.$i.'</option>';   
			   		}
					?>
			</select>
					<?php
							$conexion_mes=mysql_query('select d_mes from cat_meses',$cn);
							//f_type_combobox('id_mesboda',$conexion_mes,'-','d_mes','d_mes',$id_bmonth,'','',$ver,'','150px'); por falta de definicion de $ver y $id_bmonth se envia una cadena vacia
							f_type_combobox('id_mesboda',$conexion_mes,'-','d_mes','d_mes','','','','','','150px');
					?>
			<br class="clearAll" /><br />
			
			<label><strong>Nombre de esposa: </strong></label>
			<input name="id_esposa" type="text" onFocus="doSomething()" value="" />			
			<br class="clearAll" /><br />
			
			<label><strong>Fecha de cumpleaños:</strong> </label>
			<select name="id_diaesposa" onChange="doSomething()">
				<option></option>
				<?php 
					for($i=1;$i<=31;$i++)
			    	{			    	
						   	if($i<10)
						   	    echo '<OPTION value="0'.$i.'">0'.$i.'</option>';   
						   	else 
						   	    echo '<OPTION value="'.$i.'">'.$i.'</option>';   
			   		}
					?>
				
			</select>
			<?php
							$conexion_mes=mysql_query('select d_mes from cat_meses',$cn);
							//f_type_combobox('id_mesesposa',$conexion_mes,'-','d_mes','d_mes',$id_bmonth,'','',$ver,'','150px'); por falta de definicion de $ver y $id_bmonth se envia una cadena vacia
							f_type_combobox('id_mesesposa',$conexion_mes,'-','d_mes','d_mes','','','','','','150px');
			?> 
			
	
						
		
					
			</div>
			<!--espacio para mantener una medida estandar del frame -->
			<div style="height:30px; width:200px;"></div>		
		</div>
			
		<div id="fragment-2">
        	<div id="form_container">
				

		<label><strong>Colonia:</strong> </label>
			<?php
					$conexion=mysql_query('select d_colonia from cat_colonias group by d_colonia ASC',$cn);
					f_type_combobox_filter('combo_zonea','id_colonia',$conexion,'d_colonia','d_colonia','','',350,'','','');
			?>   
			<br class="clearAll" /><br />
		
		
			<label><strong>Código postal: </strong></label><input name="id_cp" type="text" onFocus="doSomething()" value="" />
			<br class="clearAll" /><br />
		
		<div style="width:300px; height:30px; float:left;">
		<label><strong>Tipo calle:</strong> </label>
			<?php				
					$conexion=mysql_query('select d_clase_calle from cat_clase_calle',$cn);
					f_type_combobox_filter('combo_zone1','id_tipo',$conexion,'d_clase_calle','d_clase_calle','','','100','','','');
			?>
		</div>		
		<div style="width:300px; height:30px; float:left;">
		<label class="labelpeque"><strong>Nombre:</strong> </label>
			<?php
					$conexion13=mysql_query('select nombre from cat_calles group by nombre ASC',$cn);
					f_type_combobox_filter('combo_zone15','id_calle',$conexion13,'nombre','nombre','','','255','','','');
			?>
		</div>
		<div style="width:300px; height:30px; float:left;">		
		<label ><strong>Sufijo:</strong> </label>
			<?php
					$conexion3=mysql_query('select cve_sufijo from cat_sufijo_calle',$cn);
					//f_type_combobox('id_sufijo',$conexion3,'-','cve_sufijo','cve_sufijo',$sufijo,'','',$ver,'','50px'); comentado por falta de definicion de $ver y sufijo
					f_type_combobox('id_sufijo',$conexion3,'-','cve_sufijo','cve_sufijo','','','','','','50px');
			?> 
		</div>
		
			<br class="clearAll" /><br />
	
		<label><strong>Número: </strong></label><input name="id_numero" type="text" onFocus="doSomething()" value="" />
			
			
		<label class="labelpeque"><strong>Lote: </strong></label><input name="id_lote" type="text" onFocus="doSomething()" value="" />
			

		<label class="labelpeque"><strong>Manzana: </strong></label><input name="id_manzana" type="text" onFocus="doSomething()" value="" />
			<br class="clearAll" /><br />		
			
		<label><strong>Referencias de domicilio: </strong></label><input name="referencia_domicilio" type="text" onFocus="doSomething()" value="" />
			<br class="clearAll" /><br />		
			
		<label><strong>Invitaciones: </strong></label>
			<input type="checkbox" name="diamujer" /><label class="labelcheckmed">Día internacional de la mujer</label>
			<input type="checkbox" name="checkmaestra" onChange="doSomething()" /><label class="labelcheckmed">Día de la maestra</label>
			<br class="clearAll" />		
						
			</div>
			
		<div style="height:75px; width:200px;"></div>		
		</div>	
		
		<div id="fragment-3">
        	<div id="form_container">
				
				
				<label><strong>Grupo:</strong> </label>
					<?php 
					$sqlgrup1=mysql_query("select id_grup,d_grupo from cat_grupos order by d_grupo ASC",$cn);
					//f_type_combobox('id_grupo1',$sqlgrup1,'','d_grupo','id_grup','','','','','','430px');
					f_type_combobox_filter('id_grupo1','id_grupo1',$sqlgrup1,'d_grupo','id_grup','','','280','','','');					
					?>
					<br class="clearAll" /><br />
								
				<label><strong>Dependencia:</strong> </label>
				
					<?php
					$con1=mysql_query('select d_dependencia from cat_dependencias order by d_dependencia ASC',$cn);
					f_type_combobox_filter('id_dependencia1','id_dependencia1',$con1,'d_dependencia','d_dependencia','','','280','','','');
					?>				
					<br class="clearAll" /><br />	
					
				<label><strong>Cargo: </strong></label><input  class="inputpeque" name="id_cargo1" type="text" onFocus="doSomething()" value="" />
					
					
				<label class="labelpeque"><strong>Jerarquia:</strong> </label>
					<?php
					$sqltit1=mysql_query('select * from cat_jerarquias',$cn);
					f_type_combobox('id_titular1',$sqltit1,'','nom_jerarquia','id_jerarquia','','','','','','140');					

					?>					
					
				
				<label class="labelpeque"><strong>Liderazgo:</strong> </label>
					<?php
					$sqllid=mysql_query('select * from cat_liderazgo',$cn);
					f_type_combobox('id_liderazgo',$sqllid,'','nombre','id','0','','','','','');
					?>				
					<br class="clearAll" /><br />				
				
				<label><strong>Teléfono oficina: </strong></label><input  class="inputmediano" name="id_telefono_oficina" type="text" onFocus="doSomething()" value="" />
				
				
				<label class="labelpeque"><strong>Ext: </strong></label><input class="inputpequepk" name="id_telefono_ext" type="text" onFocus="doSomething()" value="" />
					

				<label class="labelpeque"><strong>Ext Privada: </strong></label><input class="inputpequepk" name="id_ext_privada" type="text" onFocus="doSomething()" value="" />
					<br class="clearAll" /><br />	
				
				<label><strong>Teléfono secundario: </strong></label><input  class="inputpeque" name="id_telefono_secu" type="text" onFocus="doSomething()" value="" />
					
				
				<label class="labelpeque"><strong>Fax: </strong></label><input class="inputpeque" name="id_fax" type="text" onFocus="doSomething()" value="" />
				
				<br class="clearAll" /><br />	
				
				<label ><strong>Ext Fax: </strong></label><input class="inputpequepk" name="id_fax_ext" type="text" onFocus="doSomething()" value="" />
					
				
				<label ><strong>NEXTEL: </strong></label><input class="inputpeque" name="id_nextel" type="text" onFocus="doSomething()" value="" />
					<br class="clearAll" /><br />		
				
				<label><strong>Email Oficial: </strong></label><input name="id_email_oficina" type="text" onFocus="doSomething()" value="" />
					

				<label><strong>Página web: </strong></label><input class="inputpeque" name="id_web" type="text" onFocus="doSomething()" value="" />
					
				
			</div>
			<!-- DIVISION DE PRIMERA DEPENDENCIA Y DE LAS OTRAS 3 DEPDENCIAS-->
			
			<!-- GRUPOS -->
			<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
			<div class="div_grupos">
					<div id="tabsgrupos">
					<ul>	
						<li><a href="#grupo-2"><span>Grupo 2</span></a></li>
						<li><a href="#grupo-3"><span>Grupo 3</span></a></li>
						<li><a href="#grupo-4"><span>Grupo 4</span></a></li>
						
					</ul>
					
					
					<div id="grupo-2">
										<label class="labelpeque"><strong>Grupo:</strong> </label>
										<br/>
												<?php 
													$sqlgrup2=mysql_query("select * from cat_grupos order by d_grupo ASC",$cn);
													//f_type_combobox('id_grupo2',$sqlgrup2,'','d_grupo','id_grup','','','','','','300px');
													f_type_combobox_filter('id_grupo2','id_grupo2',$sqlgrup2,'d_grupo','id_grup','','','280','','','');					
												?>
											<br class="clearAll" /><br />
														
										<label class="labelpeque"><strong>Dependencia:</strong> </label>
										<br/>
												<?php
												$con2=mysql_query('select d_dependencia from cat_dependencias order by d_dependencia ASC',$cn);
												f_type_combobox_filter('combo_zone10','id_dependencia2',$con2,'d_dependencia','d_dependencia','','','280','','','');
												?>			
											<br class="clearAll" /><br />	
											
										<label class="labelpeque"><strong>Cargo: </strong></label>
										<br/>
										<input  class="inputmediano" name="id_cargo2" type="text" onFocus="doSomething()" value="" />
										
											<br class="clearAll" /><br />	
											
										<label class="labelpeque"><strong>Jerarquia:</strong> </label>
										<br/>
											<?php
											$sqltit1=mysql_query('select * from cat_jerarquias',$cn);
											f_type_combobox('id_titular2',$sqltit1,'','nom_jerarquia','id_jerarquia','','','','','','200');
											
											//$sqltit1=mysql_query('select * from cat_titular',$cn);
											//f_type_combobox('id_titular2',$sqltit1,'','titular','id','','','','','','');
											?>	
				
											<br class="clearAll" /><br />	
												
											
					</div>
					
					<div id="grupo-3">
										<label class="labelpeque"><strong>Grupo:</strong> </label>
										<br/>
												<?php 
													$sqlgrup3=mysql_query("select * from cat_grupos order by d_grupo ASC",$cn);
													//f_type_combobox('id_grupo3',$sqlgrup3,'','d_grupo','id_grup','','','','','','300px');
													f_type_combobox_filter('id_grupo3','id_grupo3',$sqlgrup3,'d_grupo','id_grup','','','280','','','');					
												?>
											<br class="clearAll" /><br />
														
										<label class="labelpeque"><strong>Dependencia:</strong> </label>
										<br/>
												<?php
												$con3=mysql_query('select d_dependencia from cat_dependencias order by d_dependencia ASC',$cn);
												f_type_combobox_filter('combo_zone10','id_dependencia3',$con3,'d_dependencia','d_dependencia','','','280','','','');
												?>			
											<br class="clearAll" /><br />	
											
										<label class="labelpeque"><strong>Cargo: </strong></label>
										<br/>
										<input  class="inputmediano" name="id_cargo3" type="text" onFocus="doSomething()" value="" />
											<br class="clearAll" /><br />	
											
										<label class="labelpeque"><strong>Jerarquia:</strong> </label>
										<br/>
											<?php
											$sqltit3=mysql_query('select * from cat_jerarquias',$cn);
											f_type_combobox('id_titular3',$sqltit3,'','nom_jerarquia','id_jerarquia','','','','','','200');
											
											//$sqltit1=mysql_query('select * from cat_titular',$cn);
											//f_type_combobox('id_titular2',$sqltit1,'','titular','id','','','','','','');
											?>	
											<br class="clearAll" /><br />	
												
																						
					</div>
					
					<div id="grupo-4">
										<label class="labelpeque"><strong>Grupo:</strong> </label>
										<br/>
												<?php 
													$sqlgrup4=mysql_query("select * from cat_grupos order by d_grupo ASC",$cn);
													//f_type_combobox('id_grupo4',$sqlgrup4,'','d_grupo','id_grup','','','','','','300px');
													f_type_combobox_filter('id_grupo4','id_grupo4',$sqlgrup4,'d_grupo','id_grup','','','280','','','');					
												?>
											<br class="clearAll" /><br />
														
										<label class="labelpeque"><strong>Dependencia:</strong> </label>
										<br/>
												<?php
												$con4=mysql_query('select d_dependencia from cat_dependencias order by d_dependencia ASC',$cn);
												f_type_combobox_filter('combo_zone10','id_dependencia4',$con4,'d_dependencia','d_dependencia','','','280','','','');
												?>			
											<br class="clearAll" /><br />	
											
										<label class="labelpeque"><strong>Cargo: </strong></label>
										<br/>
										<input  class="inputmediano" name="id_cargo4" type="text" onFocus="doSomething()" value="" />
											<br class="clearAll" /><br />	
											
										<label class="labelpeque"><strong>Jerarquia:</strong> </label>
										<br/>
											<?php
											$sqltit4=mysql_query('select * from cat_jerarquias',$cn);
											f_type_combobox('id_titular4',$sqltit4,'','nom_jerarquia','id_jerarquia','','','','','','200');
											
											//$sqltit1=mysql_query('select * from cat_titular',$cn);
											//f_type_combobox('id_titular2',$sqltit1,'','titular','id','','','','','','');
											?>	
											<br class="clearAll" /><br />	
											<br/>								
											
					</div>
					
					</div>
			</div>
			<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
			<!-- GRUPOS -->
			
			<div style="height:30px; width:200px;"></div>	
		</div>
		
		<div id="fragment-4">
        	<div id="form_container">
				
			<div style="width:500px; height:20px; float:left;">
			<label><strong>Colonia:</strong> </label>
				<?php
				$conexion=mysql_query('select d_colonia from cat_colonias group by d_colonia ASC',$cn);
				f_type_combobox_filter('combo_zone13','id_trab_colonia',$conexion,'d_colonia','d_colonia','','','300','','','');
				?> 
			</div>
		
		
		
			<label><strong>C.P.: </strong></label>
			<input name="id_direc_cp" type="text" onFocus="doSomething()" value="" />
			<br class="clearAll" /><br />
	
		
		
			
		
		
			<div style="width:200px; height:30px; float:left;">
			<label><strong>Tipo calle de oficina:</strong> </label>
			<?php
					$conexion12=mysql_query('select d_clase_calle from cat_clase_calle order by d_clase_calle ASC',$cn);
					f_type_combobox_filter('id_direc_tipo','id_direc_tipo',$conexion12,'d_clase_calle','d_clase_calle','','','100','','','');
			?>
			</div>
			
			<div style="width:400px; height:30px; float:left;">
			<label><strong>Nombre calle:</strong> </label>
			<?php
					$conexion13=mysql_query('select nombre from cat_calles group by nombre ASC',$cn);
					f_type_combobox_filter('id_direc_calle','id_direc_calle',$conexion13,'nombre','nombre','','','255','','','');
			?>
			</div>
			
			<div style="width:100px; height:30px; float:left;">
			<label class="labelpeque"><strong>Sufijo:</strong> </label>
			<?php      			
					$conexion14=mysql_query('select cve_sufijo from cat_sufijo_calle',$cn);
					//f_type_combobox('id_direc_sufijo',$conexion14,'-','cve_sufijo','cve_sufijo',"$sufijo4",'','',$ver,'','50px'); comentado por falta de definicion de $ver y $sufijo4 enviando una cadena vacia
					f_type_combobox('id_direc_sufijo',$conexion14,'-','cve_sufijo','cve_sufijo','','','','','','50px');
			?>
			</div>
			<br class="clearAll" /><br />
		
			<label><strong>Número: </strong></label>
			<input name="id_direc_numero" type="text" onFocus="doSomething()" value="" />
			<label class="labelpeque"><strong>Lote: </strong></label>
			<input name="id_direc_lote" type="text" value="" />
			<label class="labelpeque"><strong>Manzana: </strong></label>
			<input name="id_direc_manzana" type="text"  value="" />
			<br class="clearAll" /><br />
	
			<div style="width:200px; height:30px; float:left; ">
			<label><strong>Entre  :</strong> </label>
			<?php
					$conexion4=mysql_query('select d_clase_calle from cat_clase_calle order by d_clase_calle ASC',$cn);
					f_type_combobox_filter('combo_zone16','id_direc_tipo2',$conexion4,'d_clase_calle','d_clase_calle','','','100','','','');
			?>
			</div>
			
			<div style="width:200px; height:30px; float:left; ">
			<label><strong>Nombre calle:</strong> </label>
			<?php
					$conexion13=mysql_query('select nombre from cat_calles group by nombre ASC',$cn);
					f_type_combobox_filter('combo_zone15','id_direc_calle2',$conexion13,'nombre','nombre','','','255','','','');
			?>
			</div>
			
			<br class="clearAll" /><br />			
			
			<div style="width:200px; height:30px; float:left;">
			<label><strong>Y  :</strong> </label>
			<?php
					$conexion6=mysql_query('select d_clase_calle from cat_clase_calle order by d_clase_calle ASC',$cn);
					f_type_combobox_filter('combo_zone18','id_direc_tipo3',$conexion6,'d_clase_calle','d_clase_calle','','','100','','','');
			?>
			</div>
			
			<div style="width:200px; height:30px; float:left; ">
			<label><strong>Nombre calle:</strong> </label>
			<?php
					$conexion13=mysql_query('select nombre from cat_calles group by nombre ASC',$cn);
					f_type_combobox_filter('combo_zone15','id_direc_calle3',$conexion13,'nombre','nombre','','','255','','','');
			?>			
			</div>
			<br class="clearAll" /><br />
			
			<div style="width:300px; height:20px; float:left;">
			<label><strong>Ciudad:</strong> </label>
			<?php
					$conexion7=mysql_query('select d_localidad from cat_localidad group by d_localidad ASC',$cn);
					f_type_combobox_filter('id_direc_ciudad','id_direc_ciudad',$conexion7,'d_localidad','d_localidad','','','300','','','');
			?> 
			</div>
			
			<div style="margin-left:80px;width:500px; height:20px; float:left">
			<label><strong>Municipio:</strong> </label>
			<?php
					$conexion8=mysql_query('select d_municipio from cat_municipios group by d_municipio ASC',$cn);
					f_type_combobox_filter('id_direc_municipio','id_direc_municipio',$conexion8,'d_municipio','d_municipio','','','300','','','');
			?> 
			</div>
			<br class="clearAll" /><br />
			
			<div style="width:300px; height:20px; float:left;">
			<label><strong>Estado:</strong> </label>
			<?php
					$conexion9=mysql_query('select d_estado from cat_estados group by d_estado ASC',$cn);
					f_type_combobox_filter('combo_zone22','id_direc_estado',$conexion9, 'd_estado','d_estado','','','150','','','');
			?>
			</div>
			
			
			<label class="labelpeque"><strong>Ruta: </strong></label>
			<input name="id_ruta" type="text" onFocus="doSomething()" value="" />			
			
			
			<label class="labelpeque"><strong>Referencia domicilio: </strong></label>
			<input name="referencia_domicilio_trabajo" type="text" onFocus="doSomething()" value="" />			
			<br/>
	
				
			</div>
			
			<div style="height:45px; width:200px;"></div>	
		</div>
		
		<div id="fragment-5">
        	<div id="form_container">
					<form>
								<p>
										<label><strong>Contenido: </strong></label><textarea name="id_nota" cols="60" rows="10"> </textarea>
										<br class="clearAll" /><br />
								</p>
					</form>
			</div>
			
			<div style="height:10px; width:200px;"></div>
			
		</div>
		
		
		</div>


</div>
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<!--FORM Y TABS-->

<!-- Botones del form -->
						
						<div class="botonescontrol">
						
						<div class="rowElem">							
						
							<!--<input id="anterior "type="button" value="Anterior" />
						    <input id="siguiente" type="button" value="Siguiente"/>-->
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<!--<input name="btnguardar" type="button"  onclick="validar_formulario()" value="Guardar" />-->
							<img src="../icons/Floppy.png" onClick="validar_formulario()"/>
							<a href="../inicio.php"><img src="../icons/return.png" /></a>						
							<!--<a href="../inicio.php"><input name="btncancelar" type="submit" value="Cancelar" /></a>-->
						
							<!--<input type="submit" value="Eliminar" />-->
							
						</div>
						</form>
						</div>
<!-- Botones del form -->


<script>
function w_imrpimir() {
		dhxWins = new dhtmlXWindows();
		
		dhxWins.setImagePath("codebase/imgs/");
		dhxWins.setSkin('dhx_black');
		w1 = dhxWins.createWindow("w1", 30, 40, 990, 480);
		w1.setText("Imprimir");
		w1.setModal(true);
		w1.centerOnScreen();
    	//w1.attachURL("hoy.php", true);
    	w1.button("park").disable();
    	w1.button("minmax1").disable();
    	w1.attachURL("../reportes/imprimir.php");
    	
}


function catalogo()
{
		dhxWins = new dhtmlXWindows();
		dhxWins.setImagePath("codebase/imgs/");
		dhxWins.setSkin('dhx_black');
		w1 = dhxWins.createWindow("w1", 30, 40, 990, 500);
		w1.setText("Catalogo de Categorias y Grupos");
		w1.setModal(true);
		w1.centerOnScreen();
    	//w1.attachURL("hoy.php", true);
    	w1.button("park").disable();
    	w1.button("minmax1").disable();
    	w1.attachURL("../main/catalogogrupos.php");
}

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
function reporte_grupos() {
		dhxWins = new dhtmlXWindows();
		
		dhxWins.setImagePath("codebase/imgs/");
		dhxWins.setSkin('dhx_black');
		w1 = dhxWins.createWindow("w1", 30, 40, 990, 480);
		w1.setText("Reporte por grupos");
		w1.setModal(true);
		w1.centerOnScreen();
    	//w1.attachURL("hoy.php", true);
    	w1.button("park").disable();
    	w1.button("minmax1").disable();
    	w1.attachURL("../reportes/reporte_grupos.php");
    	
}
function imprimir_invitaciones() {
		dhxWins = new dhtmlXWindows();
		
		dhxWins.setImagePath("codebase/imgs/");
		dhxWins.setSkin('dhx_black');
		w1 = dhxWins.createWindow("w1", 30, 40, 990, 480);
		w1.setText("Invitaciones");
		w1.setModal(true);
		w1.centerOnScreen();
    	//w1.attachURL("hoy.php", true);
    	w1.button("park").disable();
    	w1.button("minmax1").disable();
    	w1.attachURL("../reportes/imprimir_invitaciones.php");
    	
}
function acuse_recibo() {
		dhxWins = new dhtmlXWindows();
		
		dhxWins.setImagePath("codebase/imgs/");
		dhxWins.setSkin('dhx_black');
		w1 = dhxWins.createWindow("w1", 30, 40, 990, 480);
		w1.setText("Acuse de recibo");
		w1.setModal(true);
		w1.centerOnScreen();
    	//w1.attachURL("hoy.php", true);
    	w1.button("park").disable();
    	w1.button("minmax1").disable();
    	w1.attachURL("../reportes/acuse_recibo.php");
    	
}
function confirmaciones() {
		dhxWins = new dhtmlXWindows();
		
		dhxWins.setImagePath("codebase/imgs/");
		dhxWins.setSkin('dhx_black');
		w1 = dhxWins.createWindow("w1", 30, 40, 990, 480);
		w1.setText("Confirmaciones");
		w1.setModal(true);
		w1.centerOnScreen();
    	//w1.attachURL("hoy.php", true);
    	w1.button("park").disable();
    	w1.button("minmax1").disable();
    	w1.attachURL("../reportes/confirmaciones.php");
    	
}
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

</script>	
<!-- RESULTADOS -->
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<div class="resultadobusqueda" id="resultadobusqueda">
<br/>
<br/>
<br/>
NO EXISTEN COINCIDENCIAS
</div>
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<!-- RESULTADOS -->	


</div><!--div body-->
<body>
</html>
