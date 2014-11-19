<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<script language="javascript" type="text/javascript" src="../codebase/ajax.js"></script>
        
		
<!--======================================FUNCIONES==========================================-->
<?php
	include('../include/funciones_v2.php');
	include('../include/conexion_bd.php');

	f_verifica_sesion();
//f_verifica_sesion_v2();	

$tipousuario=$_SESSION['d_tipo'];

$id=$_GET['id'];

//$usuario=$_SESSION['id_usuario'];
//$fecha_actualizacion = date(d."-".m."-".Y); 

?>

<!--======================================FUNCIONES==========================================-->
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="keywords" content="" />

	
	<script src="../codebase/dhtmlxcommon.js"></script>  
	<script src="../codebase/dhtmlxcombo.js"></script>  
	<link rel="STYLESHEET" type="text/css" href="../codebase/dhtmlxcombo.css">
	<link rel="STYLESHEET" type="text/css" href="../codebase/dhtmlxtabbar2.css">	
	
	<script language="javascript" type="text/javascript" src="../codebase/ajax.js"></script>
	
	<!-- For the tabs -->
	<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
	<link href="tabs/jquery-ui.css" rel="stylesheet" type="text/css"/>
	  <script src="tabs/jquery.min.js"></script>
	  <script src="tabs/jquery-ui.min.js"></script>
	  <script src="ajax/ajax.js"></script>
	  
	<script>
	  $(document).ready(function() {
		$("#tabs").tabs();
		
		$("#tabsgrupos").tabs();
		
		});	 
	  
	</script>
	<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->  
	<!-- For the tabs -->
	

	
	
	
	
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
if (document.formulario.id_jerarquia.selectedIndex==0){ 
alert("Selecciones si es titular u otro rango") 
document.formulario.id_jerarquia.focus() 
return 0; 
} 
 
//document.formulario.submit(); 
id = $("input[name$='id']").val();

id_nombre = $("input[name$='id_nombre']").val();
id_paterno = $("input[name$='id_paterno']").val();
id_sexo = $("select[name$='id_sexo'] option:selected").val();

id_grupo1 = $("input[name$='id_grupo1']").val();
id_cargo1 = $("input[name$='id_cargo1']").val();

id_dependencia1 = $("input[name$='id_dependencia1']").val();
id_jerarquia = $("select[name$='id_jerarquia'] option:selected").val();

ajax=nuevoAjax();	
	ajax.open("GET", "contacto_editar.php?id="+id+"&id_titulo="+id_titulo+"&id_nombre="+id_nombre+
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
								 "&id_jerarquia="+id_jerarquia+"&id_grupo2="+id_grupo2+
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
								 
								 "&operacion=6"+
								 
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
<script language="javascript" charset="utf-8"> 

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



if (document.formulario.id_jerarquia.selectedIndex==0){ 
alert("Selecciones si es titular u otro rango") 
document.formulario.id_jerarquia.focus() 
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




id = $("input[name$='id']").val();

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


id_grupo1 = $("select[name$='id_grupo1'] option:selected").val();
id_liderazgo = $("select[name$='id_liderazgo'] option:selected").val()
id_dependencia1 = $("input[name$='id_dependencia1']").val();
id_cargo1 = $("input[name$='id_cargo1']").val();
id_jerarquia = $("select[name$='id_jerarquia'] option:selected").val()
id_grupo2 = $("input[name$='id_grupo2']").val();
id_dependencia2 = $("input[name$='id_dependencia2']").val();
id_cargo2 = $("input[name$='id_cargo2']").val();
id_jerarquia2 = $("select[name$='id_jerarquia2'] option:selected").val()
id_grupo3 = $("input[name$='id_grupo3']").val();
id_dependencia3 = $("input[name$='id_dependencia3']").val();
id_cargo3 = $("input[name$='id_cargo3']").val();
id_jerarquia3 = $("select[name$='id_jerarquia3'] option:selected").val()
id_grupo4 = $("input[name$='id_grupo4']").val();
id_dependencia4 = $("input[name$='id_dependencia4']").val();
id_cargo4 = $("input[name$='id_cargo4']").val();
id_jerarquia4 = $("select[name$='id_jerarquia4'] option:selected").val()

//----------------------------


id_telefono_oficina = $("input[name$='id_telefono_oficina']").val();
id_telefono_ext = $("input[name$='id_telefono_ext']").val();
id_ext_privada = $("input[name$='id_ext_privada']").val();
id_telefono_secu = $("input[name$='id_telefono_secu']").val();
id_fax = $("input[name$='id_fax']").val();
id_fax_ext = $("input[name$='id_fax_ext']").val();
id_nextel = $("input[name$='id_nextel']").val();
id_email_oficina = $("input[name$='id_email_oficina']").val();
id_web = $("input[name$='id_trab_web']").val();

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

//alert('entra pero haber q royo con el code')


	ajax=nuevoAjax();	
	ajax.open("GET", "contacto_editar.php?id="+id+"&id_titulo="+id_titulo+"&id_nombre="+id_nombre+
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
								 "&id_jerarquia="+id_jerarquia+
								 "&id_grupo2="+id_grupo2+"&id_dependencia2="+id_dependencia2+
								 "&id_cargo2="+id_cargo2+"&id_jerarquia2="+id_jerarquia2+
								 "&id_grupo3="+id_grupo3+"&id_dependencia3="+id_dependencia3+
								 "&id_cargo3="+id_cargo3+"&id_jerarquia3="+id_jerarquia3+
								 "&id_grupo4="+id_grupo4+"&id_dependencia4="+id_dependencia4+
								 "&id_cargo4="+id_cargo4+"&id_jerarquia4="+id_jerarquia4+
								 
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
								 
								 "&operacion=6"+
								 
								 "&id_nota="+id_nota);
	
		ajax.onreadystatechange=function()
   	{
      if (ajax.readyState==4)
      {
         //contenedor.innerHTML = ajax.responseText;
		 //$('.resultadobusqueda').slideDown(); 
		 //$("form[name$='formulario']").reset();
		 alert('Los datos han sido guardados correctamente');
		 //alert(ajax.responseText);
		 
		 /*$("form[name$='formulario']").each (function(){
						this.reset();
						$("input").attr("value","");
						$('select').find('option:first').attr('selected', 'selected').parent('select');
						$("input[name$='btnguardar']").attr("value","Guardar");
						$("input[name$='btncancelar']").attr("value","Cancelar");						
				});*/
      }
   	}
   	ajax.send(null);
} 
</script>


<?php
//fin de else de validación para los demás usuarios
}
?>	
	
	
	
        	
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

	

.formagregar{
	width:1000px;
	height:490px;
	/*background-color:green;	*/
	margin-left:auto;
	margin-right:auto;
	font-size:12px !important;
}

.div_grupos{
	margin:1px solid #eee; 
	float:right; 
	width:350px; 
	height:410px; 
	
	position:absolute; 
	display: inline;
	top:50px; 
	left:640px;
}

.resultadobusqueda{
	width:1000px;
	height:200px;
	background-color:#e8e8e8;	
	margin-left:auto;
	margin-right:auto;
	display:none;
	overflow:auto;
	font-family:tahoma;
	font-size:11px;
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
	width:500px;
	height:100px;
}

</style>

<script type="text/javascript" charset="utf-8">


///////////////////////////  BUSCAR NOMBRES /////////////////////
function cargar_grupos(div)
{	
	
   	var contenedor;
   	contenedor = document.getElementById(div);
	//id_persona= document.form.persona.value;	
	id_persona= document.getElementById('persona').value;	
	
	//Hide if haven´t text
	if(id_persona==''){
		$('.resultadobusqueda').slideUp(); 	
		
	//Show if it have text
	}else{
		var aleatorio = Math.random();
		
		ajax=nuevoAjax();
		ajax.open("GET", "../ajax/ajax_buscarnombre_ac.php?id_persona="+id_persona+"&ale="+aleatorio);

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
}

</script>

  
<script language="javascript" charset="utf-8">

function cargar_grupos(div,opcion)
{
   var contenedor;

   contenedor = document.getElementById(div);
   id_categoria= document.formulario.id_categoria.value;
   ajax=nuevoAjax();
   ajax.open("GET", "ajax_contactos.php?opcion="+2+"&id_categoria="+id_categoria);

   ajax.onreadystatechange=function()
   {
      if (ajax.readyState==4)
      {
         contenedor.innerHTML = ajax.responseText
      }
   }
   ajax.send(null)
}
</script> 

<script language="JavaScript" type="text/JavaScript">
	function eliminar(id)
	{
		eliminar=confirm("¿Deseas eliminar este registro?");
		if (eliminar){
			window.location.href = "../ajax/ajax_eliminar.php?ids="+id
			window.close() ;
		}else{
			alert('No se ha podido eliminar el registro...')
			window.close() ;
		}
	}

</script>


<!-- Pretty Forms -->
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->  
<style type="text/css">	
	form{
		margin:20px;
		font:12px "Trebuchet MS", "Lucida Grande", "Bitstream Vera Sans", Arial, Helvetica, sans-serif;
		color:#666666;		
	}
	</style>	
	
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

<body onload="mostrartodo()">
<div id="cargador" style="margin-top:100px;font-family:tahoma;font-size:16px;font-weight:bold;"><center><img src="images/zoomloader.gif" /> Cargando...</center></div>
<div id="body" style="display:none">


<?php $call="../"; ?>

<!-- MENU -->
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<div class="menu">
	
	<ul>
		<!--<li style="background-image:url('../imagenes/menuTop_button_on.png');"><a href="<?php echo $call; ?>main/contacto.php">AGREGAR CONTACTOS</a></li>-->
		<li><a href="contacto.php"><table><tr><td>AGREGAR</td></tr><tr><td>CONTACTOS</td></tr></table></a></li>
		
		<li><a href="../modificar.php"><table style="color:yellow;" ><tr><td>MODIFICAR</td></tr><tr><td>EL DIRECTORIO</td></tr></table></a></li>
		<li><a href="#" onclick="javascript:w_imrpimir();"><table><tr><td>REPORTES</td></tr></table></a></li>
		<?php if($tipousuario=="Administrador"){?>
		<li><a href="#" onclick="javascript:panel();" style="cursor:hand;"><table class="table"><tr><td>PANEL</td></tr><tr><td>DE USUARIOS</td></tr></table></a></li>
		<?php }	?>
		<li><a href="#" onclick="javascript:catalogo();"><table><tr><td>CATÁLOGOS</td></tr></table></a></li>
		<li><a href="../inicio.php"><table><tr><td>INICIO</td></tr></table></a></li>
	</ul>
</div>
<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
<!-- MENU -->

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
					<?php 
					$id=$_GET['id'];
					$sql00="select * from tb_contactos where id=$id";
					$recurso=mysql_query($sql00,$cn);
					$aa=mysql_fetch_assoc($recurso);

					//print_r($aa);
					$_GET['operacion']=3;
					?>
					<input type="hidden" name="operacion">
					<input type="hidden" name="tipo">
					<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
	
			
		
			<label><strong>Titulo:</strong> </label>			
			<?php
	        if ($_GET['operacion']==3){ 
	        $personal_titulo= $aa['p_titulo'];
	        }else{
	        	$personal_titulo='';
	        }
	        $query_1='select d_titulos from cat_titulos order by d_titulos ASC';
			$rdsquery1=mysql_query($query_1,$cn);
			
	        //f_type_combobox('id_titulo',$rdsquery1,'','d_titulos','d_titulos',$personal_titulo,'','',$ver,'',''); Comentado por la variable $ver  no definida ó ¿?, por lo tanto en vez de ello se envia una cadena vacia ''
			f_type_combobox('id_titulo',$rdsquery1,'','d_titulos','d_titulos',$personal_titulo,'','','','','');
	        ?>
			<br class="clearAll" /><br />
		
		
		
			<label><strong>Nombre: </strong></label>
			<input name="id_nombre" type="text" style="text-transform:uppercase;"  value="<?php if ($_GET['operacion']==3){echo $aa['p_nombre'];}?>" />
			<input name="id_paterno" type="text" style="text-transform:uppercase;"  value="<?php  if ($_GET['operacion']==3){echo $aa['p_paterno'];}?>" />
			<input name="id_materno" type="text" style="text-transform:uppercase;"   value="<?php  if ($_GET['operacion']==3){echo $aa['p_materno'];}?>" />
			<br class="clearAll" /><br />
	
		
		
			<label><strong>Sexo:</strong> </label>
			<?php
	        if ($_GET['operacion']==3){ 
	        $personal_sexo= $aa['p_sexo'];
	        }else{
	        	$personal_titulo='';
	        }
	        $query_1='select * from cat_sexos';
			$rdsquery1=mysql_query($query_1,$cn);
			
	        //f_type_combobox('id_sexo',$rdsquery1,'','sexos','sexos',$personal_sexo,'','',$ver,'',''); Comentado por falta de definicion de la variable $ver .. en su lugar se envia una cadena vacia
			f_type_combobox('id_sexo',$rdsquery1,'','sexos','sexos',$personal_sexo,'','','','','');
	        ?>	
			
			<br class="clearAll" /><br />
		
		
			<label><strong>Fecha de cumpleaños:</strong> </label>
			<select name="id_dia" <?php //echo $ver; variable comentada por falta de definición ?> style="width:50px">
			<option></option>
			<?php
			 
			for($i=1;$i<=31;$i++)
				{
					if( ((int) substr($aa['p_dia'],0,2)) == $i )
					{
					   if($i<10)	
							echo '<OPTION  selected="selected">0'.$i;   
						else 
							echo '<OPTION  selected="selected">'.$i;   
					}   	    
					else   	
					{
						if($i<10)
							echo '<OPTION>0'.$i;   
						else 
							echo '<OPTION>'.$i;   
					}  	    
				}
			 
			?>
			</select>
			
			<?php
		      			if ($_GET['operacion']==3){
		      				$id_bmonth = strtoupper($aa['p_mes']); //Amayúsculas para comprobación
		      			}else{
			      				$id_bmonth='';
			      		}
							$sqlmes='select d_mes from cat_meses';
							$conexion_mes=mysql_query($sqlmes,$cn);
							//f_type_combobox('id_bmonth',$conexion_mes,'-','d_mes','d_mes',$id_bmonth,'','',$ver,'','150px'); Comentado por falta de definicion de $var... en su lugar se envia una cadena vacia
							f_type_combobox('id_mes',$conexion_mes,'-','d_mes','d_mes',$id_bmonth,'','','','','150px');
							
			?>  
			<br class="clearAll" /><br />
		
		
		
			<label><strong>Teléfono de casa: </strong></label>
			<input name="id_casa" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){ echo $aa['p_telcasa'];}?>" />
			<label><strong>Celular: </strong></label>
			<input name="id_celular" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){echo $aa['p_celular'];}?>" />
			<br class="clearAll" /><br />
		
			<label><strong>E-mail Personal: </strong></label>
			<input name="id_email" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){ echo $aa['p_email'];}?>" />			
			<br class="clearAll" /><br />
		
			<label><strong>Aniversario de bodas:</strong> </label>
			<select name="id_diaboda" onchange="doSomething()">
				<option></option>
				<?php
			 
				for($i=1;$i<=31;$i++)
					{
						if( ((int) substr($aa['p_aniversarioboda'],0,2)) == $i )
						{
						   if($i<10)	
								echo '<OPTION  selected="selected">0'.$i;   
							else 
								echo '<OPTION  selected="selected">'.$i;   
						}   	    
						else   	
						{
							if($i<10)
								echo '<OPTION>0'.$i;   
							else 
								echo '<OPTION>'.$i;   
						}  	    
					}
				 
				?>
			</select>
					<?php
		      			if ($_GET['operacion']==3){
		      				$id_bmonth = substr($aa['p_aniversarioboda'],3); //Amayúsculas para comprobación
		      			}else{
			      				$id_bmonth='';
			      		}
							$sqlmes='select d_mes from cat_meses';
							$conexion_mes=mysql_query($sqlmes,$cn);
							//f_type_combobox('id_bmonth',$conexion_mes,'-','d_mes','d_mes',$id_bmonth,'','',$ver,'','150px'); Comentado por falta de definicion de $var... en su lugar se envia una cadena vacia
							f_type_combobox('id_mesboda',$conexion_mes,'-','d_mes','d_mes',$id_bmonth,'','','','','150px');
							
					?> 
			<br class="clearAll" /><br />
			
			
			
			
			
			
			
			<label><strong>Nombre de esposa: </strong></label>
			<input name="id_esposa" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){ echo $aa['p_esposa'];}?>" />			
			<br class="clearAll" /><br />
			
			<label><strong>Fecha de cumpleaños:</strong> </label>
			<select name="id_diaesposa" onchange="doSomething()">
				<option></option>
				<?php
			 
			for($i=1;$i<=31;$i++)
				{
					if( ((int) substr($aa['p_cumple_esposa'],1,2)) == $i )
					{
					   if($i<10)	
							echo '<OPTION  selected="selected">0'.$i;   
						else 
							echo '<OPTION  selected="selected">'.$i;   
					}   	    
					else   	
					{
						if($i<10)
							echo '<OPTION>0'.$i;   
						else 
							echo '<OPTION>'.$i;   
					}  	    
				}
			 
			?>
			</select>
			
			<?php
		      			if ($_GET['operacion']==3){
		      				$id_bmonth = substr($aa['p_cumple_esposa'],3); //Amayúsculas para comprobación
		      			}else{
			      				$id_bmonth='';
			      		}
							$sqlmes='select d_mes from cat_meses';
							$conexion_mes=mysql_query($sqlmes,$cn);
							//f_type_combobox('id_bmonth',$conexion_mes,'-','d_mes','d_mes',$id_bmonth,'','',$ver,'','150px'); Comentado por falta de definicion de $var... en su lugar se envia una cadena vacia
							f_type_combobox('id_mes',$conexion_mes,'-','d_mes','d_mes',$id_bmonth,'','','','','150px');
							
			?>  
			
	
						
		
					
			</div>
			<br/>
		</div>
			
		<div id="fragment-2">
        	<div id="form_container">
				

		<label><strong>Colonia:</strong> </label>
			<?php
		      			if ($_GET['operacion']=="3"){
		      			$colonia=$aa['p_colonia'];
		      			}else{
		      				$colonia='';
		      			}
	      				$tamaño="350px";
						$sql='select d_colonia from cat_colonias group by d_colonia ASC';
						$conexion=mysql_query($sql,$cn);
						//f_type_combobox_filter('combo_zonea','id_colonia',$conexion,'d_colonia','d_colonia','',$ver,$tamaño,$colonia,'',$ver2); comentado por falta de definicion de $ver y $ver2 ..en su lugar se envia cadenas vacias 
						f_type_combobox_filter('id_colonia','id_colonia',$conexion,'d_colonia','d_colonia','','',$tamaño,$colonia,'','');
						
			?>  
			<br class="clearAll" /><br />
		
		
			<label><strong>Código postal: </strong></label><input name="id_cp" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){ echo $aa["p_cp"];}?>" />
			<br class="clearAll" /><br />
		
		<div style="width:300px; height:30px; float:left;">
		<label><strong>Tipo calle:</strong> </label>
			<?php
		      				if ($_GET['operacion']==3){
		      				$clase_calle=$aa['p_tipocalle'];
		      				}else{
			      				$clase_calle='';
			      			}			
		      							
		      				$tamaño="100px";
							$sql='select d_clase_calle from cat_clase_calle';
							$conexion=mysql_query($sql,$cn);
							//f_type_combobox_filter('combo_zone1','id_tipo',$conexion,'d_clase_calle','d_clase_calle','',$ver,$tamaño,$clase_calle,'',$ver2); comentado por falta de definicion de $ver y $ver2
							
							f_type_combobox_filter('id_tipo','id_tipo',$conexion,'d_clase_calle','d_clase_calle','','',$tamaño,$clase_calle,'','');
		    ?>
		</div>		
		<div style="width:300px; height:30px; float:left;">
		<label class="labelpeque"><strong>Nombre:</strong> </label>
			<?php
		      			if ($_GET['operacion']==3){
		      				$calle=strtoupper($aa['p_calle']);
		      			}else{
			      				$calle='';
			      			}
		      				$tamaño2="255px";
							$sql2='select nombre from cat_calles group by nombre ASC';
							$conexion2=mysql_query($sql2,$cn);
							//f_type_combobox_filter('combo_zone2','id_calle',$conexion2,'nombre','nombre','','',$tamaño2,$calle,'',$ver2); comentado por falta de definicion de $ver
							f_type_combobox_filter('id_calle','id_calle',$conexion2,'nombre','nombre','','',$tamaño2,$calle,'','');
			?>
		</div>
		<div style="width:300px; height:30px; float:left;">		
		<label ><strong>Sufijo:</strong> </label>
			<?php
		      			if ($_GET['operacion']==3){
		      				$sufijo=$aa['p_sufijo'];
		      			}else{
			      				$sufijo='';
			      			}
							$sql3='select cve_sufijo from cat_sufijo_calle';
							$conexion3=mysql_query($sql3,$cn);
							//f_type_combobox('id_sufijo',$conexion3,'-','cve_sufijo','cve_sufijo',$sufijo,'','',$ver,'','50px'); comentado por falta de definicion de $ver
							f_type_combobox('id_sufijo',$conexion3,'-','cve_sufijo','cve_sufijo',$sufijo,'','','','','50px');
			?> 
		</div>
		
			<br class="clearAll" /><br />
	
		<label><strong>Número: </strong></label><input name="id_numero" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){ echo $aa['p_numero'];}?>" />
			<br class="clearAll" /><br />
			
		<label><strong>Lote: </strong></label><input name="id_lote" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){ echo $aa['p_lote'];}?>" />
			<br class="clearAll" /><br />

		<label><strong>Manzana: </strong></label><input name="id_manzana" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){ echo $aa['p_manzana'];}?>" />
			<br class="clearAll" /><br />		
			
		<label><strong>Referencias de domicilio: </strong></label><input name="referencia_domicilio" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){ echo $aa['p_referencia_domicilio'];}?>" />
			<br class="clearAll" /><br />		
			
		<label><strong>Invitaciones: </strong></label>
			<input type="checkbox" name="diamujer" <?php  if ($_GET['operacion']==3){ if($aa['diamujer']=="1")echo "checked='checked' value='on' ";} ?> /><label class="labelcheck">Día internacional de la mujer</label>
			<input type="checkbox" name="checkmaestra" <?php  if ($_GET['operacion']==3){ if($aa['maestra']=="1")echo "checked='checked' value='on'";} ?> /><label class="labelcheck">Día de la maestra</label>
			<br class="clearAll" /><br />
		
			<br/><br/><br/>
				
						
			</div>
		</div>	
		
		<div id="fragment-3">
        	<div id="form_container">
				
				
				<label><strong>Grupo:</strong> </label>
					<?php
					//by alejandro
					$myquery = "SELECT id_cat FROM cat_grupos WHERE id_grup = ".$aa['id_grupo1'];
					$konekt=mysql_query($myquery,$cn);
					$row = mysql_fetch_array($konekt);
					//echo $row["id_cat"];
					//by alejandro
					
					if ($_GET['operacion']==3){
					//$clasificacion=$aa['id_grupo1'];
					$clasificacion=$row["id_cat"];
					}					
					
					  //$aa[trabajo_idgrupo];
      				$qrySgrupos="select * from cat_grupos where id_cat='$clasificacion' order by d_grupo ASC";
      				$qrySgrupos=mysql_query($qrySgrupos,$cn);
				    //f_type_combobox('id_grup',$qrySgrupos,'','d_grupo','id_grup',"$aa[id_grupo1]",'','',$ver,'','430px'); comentado por falta de definicion de $ver
					f_type_combobox('id_grupo1',$qrySgrupos,'','d_grupo','id_grup',"$aa[id_grupo1]",'','','','','430px');
					
				    ?>
					<br class="clearAll" /><br />
								
				<label><strong>Dependencia:</strong> </label>
				
					<?php
		      			if ($_GET['operacion']==3){
		      				$compania=$aa['t_dependencia1'];
		      			}else{
			      				$compania='';
			      			}
		      				$tamaño11="430px";
							$sql_a='select d_dependencia from cat_dependencias group by d_dependencia ASC';
							$conexion11=mysql_query($sql_a,$cn);
							//f_type_combobox_filter('combo_zone9','id_dependencia',$conexion11,'d_dependencia','d_dependencia','','',$tamaño11,$compania,'',$ver2); comentado por falta de definición de $ver2
							f_type_combobox_filter('id_dependencia1','id_dependencia1',$conexion11,'d_dependencia','d_dependencia','','',$tamaño11,$compania,'',''); 
					?>				
					<br class="clearAll" /><br />	
					
				<label><strong>Cargo: </strong></label><input  class="inputmediano" name="id_cargo1" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){ echo $aa["t_cargo1"];}?>" />
					<br class="clearAll" /><br />	
					
				<label><strong>Liderazgo:</strong> </label>
					<?php
									if ($_GET['operacion']==3){ 
									$liderazgo= $aa['id_liderazgo'];
									}else{
										$liderazgo='';
									}
									$query_1='select * from cat_liderazgo';
									$rdsquery1=mysql_query($query_1,$cn);
									
									//f_type_combobox('id_jerarquia',$rdsquery1,'','nom_jerarquia','id_jerarquia',$titular_ver,'','',$ver,'',''); comentado por falta de definicion de variable $ver ..en su lugar se envia una cadena vacia
									f_type_combobox('id_liderazgo',$rdsquery1,'','nombre','id',$liderazgo,'','','','','');
									
					?>			
					<br class="clearAll" /><br />
					
				<label><strong>Jerarquia:</strong> </label>
					<?php
				        if ($_GET['operacion']==3){ 
				        $titular_ver= $aa['t_jerarquia1'];
				        }else{
				        	$titular_ver='';
				        }
				        $query_1='select * from cat_jerarquias';
						$rdsquery1=mysql_query($query_1,$cn);
						
				        //f_type_combobox('id_jerarquia',$rdsquery1,'','nom_jerarquia','id_jerarquia',$titular_ver,'','',$ver,'',''); comentado por falta de definicion de variable $ver ..en su lugar se envia una cadena vacia
						f_type_combobox('id_jerarquia',$rdsquery1,'','nom_jerarquia','id_jerarquia',$titular_ver,'','','','','');
						
				    ?>					
					<br class="clearAll" /><br />	
				
				<label><strong>Teléfono oficina: </strong></label><input  class="inputmediano" name="id_telefono_oficina" type="text"  value="<?php if ($_GET['operacion']==3){echo $aa["t_telefono1"];}?>" />
				
				
				<label class="labelpeque"><strong>Ext: </strong></label><input class="inputpeque" name="id_telefono_ext" type="text"  value="<?php if ($_GET['operacion']==3){echo $aa["t_ext"];}?>" />
					<br class="clearAll" /><br />

				<label><strong>Ext Privada: </strong></label><input class="inputpeque" name="id_ext_privada" type="text"  value="<?php if ($_GET['operacion']==3){echo $aa["t_extprivada"];}?>" />
					<br class="clearAll" /><br />	
				
				<label><strong>Teléfono secundario: </strong></label><input name="id_telefono_secu" type="text"  value="<?php if ($_GET['operacion']==3){ echo $aa["t_telefono2"];}?>" />
					
				
				<label class="labelpeque"><strong>Fax: </strong></label><input name="id_fax" type="text"  value="<?php if ($_GET['operacion']==3){ echo $aa["t_fax"];}?>" />
					<br class="clearAll" /><br />	
				
				<label><strong>Ext Fax: </strong></label><input name="id_fax_ext" type="text"  value="<?php if ($_GET['operacion']==3){ echo $aa["t_faxext"];}?>" />
					
				
				<label ><strong>Clave NEXTEL: </strong></label><input class="inputpeque" name="id_nextel" type="text"  value="<?php if ($_GET['operacion']==3){echo $aa["t_nextel"];}?>" />
					<br class="clearAll" /><br />		
				
				<label><strong>@ Oficial: </strong></label>
						<?php
		      			if ($_GET['operacion']==3){
		      				$sql_a='select * from tb_contactos';
		      				$email_trabajo=$aa['t_email1'];
		      				$campo='t_email1';
		      						      				
		      			}else{
			      				$email_trabajo='';
			      				$sql_a='select * from tb_vacia order by id_vacio ASC';
			      				$campo='id_vacio';
			      			}
		      				$tamaño22="300px";
							
							$conexion198=mysql_query($sql_a,$cn);
							//f_type_combobox_filter('combo_zone198','id_trabajo_email',$conexion198,$campo,$campo,'','',$tamaño11,$email_trabajo,'',$ver2); comentado por falta de definición de $ver ...en su lugar se envia una cadena vacia
							f_type_combobox_filter('id_email_oficina','id_email_oficina',$conexion198,$campo,$campo,'','',$tamaño11,$email_trabajo,'','');
						?>
					

				<label><strong>Página web: </strong></label>
						<?php
		      			if ($_GET['operacion']==3){
		      				$sql_a='select * from tb_contactos';
		      				$web_trabajo=$aa['t_web'];
		      				$campo='t_web';
		      						      				
		      			}else{
			      				$web_trabajo='';
			      				$sql_a='select * from tb_vacia order by id_vacio ASC';
			      				$campo='id_vacio';
			      			}
		      				$tamaño22="300px";
							
							$conexion98=mysql_query($sql_a,$cn);
							//f_type_combobox_filter('combo_zone98','id_trab_web',$conexion98,$campo,$campo,'','',$tamaño11,$web_trabajo,'',$ver2); comentado por falta de definicion de variable $ver  ....en su lugar se envia una cadena vacia
							f_type_combobox_filter('id_trab_web','id_trab_web',$conexion98,$campo,$campo,'','',$tamaño11,$web_trabajo,'','');
						?>
					
				
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
												  //$aa[trabajo_idgrupo];
												/*$qrySgrupos="select * from cat_grupos where id_cat='$clasificacion' order by d_grupo ASC";*/
												$qrySgrupos="select * from cat_grupos order by d_grupo ASC";
												$qrySgrupos=mysql_query($qrySgrupos,$cn);
												//f_type_combobox('id_grup',$qrySgrupos,'','d_grupo','id_grup',"$aa[id_grupo1]",'','',$ver,'','430px'); comentado por falta de definicion de $ver
												f_type_combobox('id_grupo2',$qrySgrupos,'','d_grupo','id_grup',"$aa[id_grupo2]",'','','','','280px');												
												?>
												
											<br class="clearAll" /><br />
														
										<label class="labelpeque"><strong>Dependencia:</strong> </label>
										<br/>
												<?php
												if ($_GET['operacion']==3){
													$compania=$aa['t_dependencia2'];
												}else{
														$compania='';
													}
													$tamaño11="280px";
													$sql_a='select d_dependencia from cat_dependencias group by d_dependencia ASC';
													$conexion11=mysql_query($sql_a,$cn);
													//f_type_combobox_filter('combo_zone9','id_dependencia',$conexion11,'d_dependencia','d_dependencia','','',$tamaño11,$compania,'',$ver2); comentado por falta de definición de $ver2
													f_type_combobox_filter('id_dependencia2','id_dependencia2',$conexion11,'d_dependencia','d_dependencia','','',$tamaño11,$compania,'',''); 
												?>			
											<br class="clearAll" /><br />	
											
										<label class="labelpeque"><strong>Cargo: </strong></label>
										<br/>
										<input  class="inputmediano" name="id_cargo2" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){ echo $aa["t_cargo2"];}?>" />
										
											<br class="clearAll" /><br />	
											
										<label class="labelpeque"><strong>Jerarquia:</strong> </label>
										<br/>
											<?php
											if ($_GET['operacion']==3){ 
											$titular_ver= $aa['t_jerarquia2'];
											}else{
												$titular_ver='';
											}
											$query_1='select * from cat_jerarquias';
											$rdsquery1=mysql_query($query_1,$cn);
											
											//f_type_combobox('id_jerarquia',$rdsquery1,'','nom_jerarquia','id_jerarquia',$titular_ver,'','',$ver,'',''); comentado por falta de definicion de variable $ver ..en su lugar se envia una cadena vacia
											f_type_combobox('id_jerarquia2',$rdsquery1,'','nom_jerarquia','id_jerarquia',$titular_ver,'','','','','');
											
											?>	
				
											<br class="clearAll" /><br />	
											<br class="clearAll" /><br />	
											<br class="clearAll" /><br />	
											<br class="clearAll" /><br />	
					</div>
					
					<div id="grupo-3">
										<label class="labelpeque"><strong>Grupo:</strong> </label>
										<br/>
												<?php 
												  //$aa[trabajo_idgrupo];
												/*$qrySgrupos="select * from cat_grupos where id_cat='$clasificacion' order by d_grupo ASC";*/
												$qrySgrupos="select * from cat_grupos  order by d_grupo ASC";
												$qrySgrupos=mysql_query($qrySgrupos,$cn);
												//f_type_combobox('id_grup',$qrySgrupos,'','d_grupo','id_grup',"$aa[id_grupo1]",'','',$ver,'','430px'); comentado por falta de definicion de $ver
												f_type_combobox('id_grupo3',$qrySgrupos,'','d_grupo','id_grup',"$aa[id_grupo3]",'','','','','280px');
												
												?>
											<br class="clearAll" /><br />
														
										<label class="labelpeque"><strong>Dependencia:</strong> </label>
										<br/>
												<?php
												if ($_GET['operacion']==3){
													$compania=$aa['t_dependencia3'];
												}else{
														$compania='';
													}
													$tamaño11="280px";
													$sql_a='select d_dependencia from cat_dependencias group by d_dependencia ASC';
													$conexion11=mysql_query($sql_a,$cn);
													//f_type_combobox_filter('combo_zone9','id_dependencia',$conexion11,'d_dependencia','d_dependencia','','',$tamaño11,$compania,'',$ver2); comentado por falta de definición de $ver2
													f_type_combobox_filter('id_dependencia3','id_dependencia3',$conexion11,'d_dependencia','d_dependencia','','',$tamaño11,$compania,'',''); 
												?>			
											<br class="clearAll" /><br />	
											
										<label class="labelpeque"><strong>Cargo: </strong></label>
										<br/>
										<input  class="inputmediano" name="id_cargo3" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){ echo $aa["t_cargo3"];}?>" />
											<br class="clearAll" /><br />	
											
										<label class="labelpeque"><strong>Jerarquia:</strong> </label>
										<br/>
											<?php
												if ($_GET['operacion']==3){ 
												$titular_ver= $aa['t_jerarquia3'];
												}else{
													$titular_ver='';
												}
												$query_1='select * from cat_jerarquias';
												$rdsquery1=mysql_query($query_1,$cn);
												
												//f_type_combobox('id_jerarquia',$rdsquery1,'','nom_jerarquia','id_jerarquia',$titular_ver,'','',$ver,'',''); comentado por falta de definicion de variable $ver ..en su lugar se envia una cadena vacia
												f_type_combobox('id_jerarquia3',$rdsquery1,'','nom_jerarquia','id_jerarquia',$titular_ver,'','','','','');
												
											?>	
											<br class="clearAll" /><br />	
											<br class="clearAll" /><br />	
											<br class="clearAll" /><br />	
											<br class="clearAll" /><br />												
					</div>
					
					<div id="grupo-4">
										<label class="labelpeque"><strong>Grupo:</strong> </label>
										<br/>
												<?php 
												  //$aa[trabajo_idgrupo];
												/*$qrySgrupos="select * from cat_grupos where id_cat='$clasificacion' order by d_grupo ASC";*/
												$qrySgrupos="select * from cat_grupos order by d_grupo ASC";
												$qrySgrupos=mysql_query($qrySgrupos,$cn);
												//f_type_combobox('id_grup',$qrySgrupos,'','d_grupo','id_grup',"$aa[id_grupo1]",'','',$ver,'','430px'); comentado por falta de definicion de $ver
												f_type_combobox('id_grupo4',$qrySgrupos,'','d_grupo','id_grup',"$aa[id_grupo4]",'','','','','280px');
												
												?>
											<br class="clearAll" /><br />
														
										<label class="labelpeque"><strong>Dependencia:</strong> </label>
										<br/>
												<?php
												if ($_GET['operacion']==3){
													$compania=$aa['t_dependencia4'];
												}else{
														$compania='';
													}
													$tamaño11="280px";
													$sql_a='select d_dependencia from cat_dependencias group by d_dependencia ASC';
													$conexion11=mysql_query($sql_a,$cn);
													//f_type_combobox_filter('combo_zone9','id_dependencia',$conexion11,'d_dependencia','d_dependencia','','',$tamaño11,$compania,'',$ver2); comentado por falta de definición de $ver2
													f_type_combobox_filter('id_dependencia4','id_dependencia4',$conexion11,'d_dependencia','d_dependencia','','',$tamaño11,$compania,'',''); 
												?>			
											<br class="clearAll" /><br />	
											
										<label class="labelpeque"><strong>Cargo: </strong></label>
										<br/>
										<input  class="inputmediano" name="id_cargo4" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){ echo $aa["t_cargo4"];}?>" />
											<br class="clearAll" /><br />	
											
										<label class="labelpeque"><strong>Jerarquia:</strong> </label>
										<br/>
											<?php
											if ($_GET['operacion']==3){ 
											$titular_ver= $aa['t_jerarquia4'];
											}else{
												$titular_ver='';
											}
											$query_1='select * from cat_jerarquias';
											$rdsquery1=mysql_query($query_1,$cn);
											
											//f_type_combobox('id_jerarquia',$rdsquery1,'','nom_jerarquia','id_jerarquia',$titular_ver,'','',$ver,'',''); comentado por falta de definicion de variable $ver ..en su lugar se envia una cadena vacia
											f_type_combobox('id_jerarquia4',$rdsquery1,'','nom_jerarquia','id_jerarquia',$titular_ver,'','','','','');
											
											?>	
											<br class="clearAll" /><br />	
											<br/><br/><br/><br/><br/><br/>											
											
					</div>
					
					</div>
			</div>
			<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
			<!-- GRUPOS -->
			
			<br/>	
		</div>
		
		<div id="fragment-4">
        	<div id="form_container">
				
		
			<label><strong>Colonia:</strong> </label>
				<?php
			      			if ($_GET['operacion']=="3"){
			      			$colonia=$aa['t_colonia'];
			      			}else{
			      				$colonia='';
			      			}
		      				$tamaño="300px";
							$sql='select d_colonia from cat_colonias group by d_colonia ASC';
							$conexion=mysql_query($sql,$cn);
							//f_type_combobox_filter('combo_zonea','id_trab_colonia',$conexion,'d_colonia','d_colonia','',$ver,$tamaño,$colonia,'',$ver2); comentado por falta de definicion de $ver y $ver2..en su lugar se envia una cadena vacia
							f_type_combobox_filter('id_trab_colonia','id_trab_colonia',$conexion,'d_colonia','d_colonia','','',$tamaño,$colonia,'','');
				?>  
			<br class="clearAll" /><br />
		
		
		
			<label><strong>C.P.: </strong></label>
			<input name="id_direc_cp" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){echo $aa["t_cp"];}?>" />
			<br class="clearAll" /><br />
	
		
		
			
		
		
			<div style="width:200px; height:30px; float:left;">
			<label><strong>Tipo calle de oficina:</strong> </label>
			<?php
      			if ($_GET['operacion']==3){
      				$tipo_calle_oficina=$aa['t_tipocalle'];
      			}else{
	      				$tipo_calle_oficina='';
	      			}
      				$tamaño12="100px";
					$sql_b='select d_clase_calle from cat_clase_calle order by d_clase_calle ASC';
					$conexion12=mysql_query($sql_b,$cn);
					//f_type_combobox_filter('combo_zone10','id_direc_tipo',$conexion12,'d_clase_calle','d_clase_calle','','',$tamaño12,$tipo_calle_oficina,'',$ver2); comentado por falta de definicion de $ver2
					f_type_combobox_filter('id_direc_tipo','id_direc_tipo',$conexion12,'d_clase_calle','d_clase_calle','','',$tamaño12,$tipo_calle_oficina,'','');
			?>
			</div>
			
			<div style="width:400px; height:30px; float:left;">
			<label><strong>Nombre calle:</strong> </label>
			<?php
      			if ($_GET['operacion']==3){
      				$calle_oficina=$aa['t_calle'];
      			}else{
	      				$calle_oficina='';
	      			}
      				$tamaño13="255px";
					$sql_c='select nombre from cat_calles group by nombre ASC';
					$conexion13=mysql_query($sql_c,$cn);
					//f_type_combobox_filter('combo_zone10','id_direc_calle',$conexion13,'nombre','nombre','','',$tamaño13,$calle_oficina,'',$ver2); comentado por falta de definicion de $ver2 ...en su lugar se envia una cadena vacia
					f_type_combobox_filter('id_direc_calle','id_direc_calle',$conexion13,'nombre','nombre','','',$tamaño13,$calle_oficina,'','');
			?>
			</div>
			
			<div style="width:100px; height:30px; float:left;">
			<label class="labelpeque"><strong>Sufijo:</strong> </label>
			<?php
      			if ($_GET['operacion']==3){
      				$sufijo4=$aa['t_sufijo'];
      			}else{
	      				$sufijo4='';
	      			}
					$sql_d='select cve_sufijo from cat_sufijo_calle';
					$conexion14=mysql_query($sql_d,$cn);
					//f_type_combobox('id_direc_sufijo',$conexion14,'-','cve_sufijo','cve_sufijo',"$sufijo4",'','',$ver,'','50px');  comentado por falta de definicion de $ver ...en su lugar se envia una cadena vacia
					f_type_combobox('id_direc_sufijo',$conexion14,'-','cve_sufijo','cve_sufijo',"$sufijo4",'','','','','50px');
			?> 
			</div>
			<br class="clearAll" /><br />
		
			<label><strong>Número: </strong></label>
			<input name="id_direc_numero" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){echo $aa["t_numero"];}?>" />
			<input name="id_direc_lote" type="text" onfocus="javascript:this.value='';" value="<?php if ($_GET['operacion']==3){echo $aa["t_lote"];}?>" />
			<input name="id_direc_manzana" type="text" onfocus="javascript:this.value='';" value="<?php if ($_GET['operacion']==3){echo $aa["t_manzana"];}?>" />
			<br class="clearAll" /><br />
	
			<div style="width:200px; height:30px; float:left; ">
			<label><strong>Entre  :</strong> </label>
			<?php
			      			if ($_GET['operacion']==3){
			      				$clase_calle2=$aa['t_tipocalle2'];
			      			}else{
				      				$clase_calle2='';
				      			}
			      				$tamaño4="100px";
								$sql4='select d_clase_calle from cat_clase_calle order by d_clase_calle ASC';
								$conexion4=mysql_query($sql4,$cn);
								//f_type_combobox_filter('combo_zone3','id_direc_tipo2',$conexion4,'d_clase_calle','d_clase_calle','','',$tamaño4,$clase_calle2,'',$ver2); comentado por falta de definicion de $ver ...en su lugar se envia una cadena vacia
								f_type_combobox_filter('id_direc_tipo2','id_direc_tipo2',$conexion4,'d_clase_calle','d_clase_calle','','',$tamaño4,$clase_calle2,'','');
			?>
			</div>
			
			<div style="width:200px; height:30px; float:left; ">
			<label><strong>Nombre calle:</strong> </label>
			<?php
			      			if ($_GET['operacion']==3){
			      				$calle2=$aa['t_calle2'];
			      			}else{
				      				$calle2='';
				      			}
			      				$tamaño5="255px";
								$sql5='select nombre from cat_calles group by nombre ASC';
								$conexion5=mysql_query($sql5,$cn);
    						//f_type_combobox_filter('combo_zone4','id_direc_calle2',$conexion5,'nombre','nombre','','',$tamaño5,$calle2,'',$ver2); comentado por falta de definicion de $ver2
								f_type_combobox_filter('id_direc_calle2','id_direc_calle2',$conexion5,'nombre','nombre','','',$tamaño5,$calle2,'','');							
								
								
			?>
			</div>
			
			<br class="clearAll" /><br />			
			
			<div style="width:200px; height:30px; float:left;">
			<label><strong>Y  :</strong> </label>
			<?php
		      			if ($_GET['operacion']==3){
		      				$clase_calle3=$aa['t_tipocalle3'];
		      			}else{
			      				$clase_calle3='';
			      			}
		      				$tamaño6="100px";
							$sql6='select d_clase_calle from cat_clase_calle order by d_clase_calle ASC';
							$conexion6=mysql_query($sql6,$cn);
							//f_type_combobox_filter('combo_zone5','id_direc_tipo3',$conexion6,'d_clase_calle','d_clase_calle','','',$tamaño6,$clase_calle3,'',$ver2); comentado por falta de definicion de $ver ..en su lugar se envia una cadena vacia
							f_type_combobox_filter('id_direc_tipo3','id_direc_tipo3',$conexion6,'d_clase_calle','d_clase_calle','','',$tamaño6,$clase_calle3,'','');	
			?>
			</div>
			
			<div style="width:200px; height:30px; float:left; ">
			<label><strong>Nombre calle:</strong> </label>
			<?php
		      			if ($_GET['operacion']==3){
		      				$calle3=$aa['t_calle3'];
		      			}else{
			      				$calle3='';
			      			}
		      				$tamaño7="255px";
							$sql7='select nombre from cat_calles group by nombre ASC';
							$conexion7=mysql_query($sql7,$cn);
							//f_type_combobox_filter('combo_zone6','id_direc_calle3',$conexion7,'nombre','nombre','','',$tamaño7,$calle3,'',$ver2); comentado por falta de definicion de $ver2 ...en su lugar se envia una cadena vacia
							f_type_combobox_filter('id_direc_calle3','id_direc_calle3',$conexion7,'nombre','nombre','','',$tamaño7,$calle3,'','');
			?>			
			</div>
			<br class="clearAll" /><br />
			
			<label><strong>Ciudad:</strong> </label>
			<?php
	      			if ($_GET['operacion']==3){
	      				$ciudad=$aa['t_ciudad'];
	      			}else{
		      				$ciudad='';
		      		}
	      				$tamaño8="300px";
						$sql8='select d_localidad from cat_localidad group by d_localidad ASC';
						$conexion8=mysql_query($sql8,$cn);
										//f_type_combobox_filter('combo_zone7','id_direc_ciudad',$conexion8,'d_localidad','d_localidad','','',$tamaño8,$ciudad,'',$ver2); comentado por falta de definicion de la $var en su lugar se envia una cadena vacia
						f_type_combobox_filter('id_direc_ciudad','id_direc_ciudad',$conexion8,'d_localidad','d_localidad','','',$tamaño8,$ciudad,'','');
			?>
			<br class="clearAll" /><br />
			
			<label><strong>Municipio:</strong> </label>
			<?php
	      			if ($_GET['operacion']==3){
	      				$ciudad=$aa['t_municipio'];
	      			}else{
		      				$ciudad='';
		      		}
	      				$tamaño8="300px";
						$sql8='select d_municipio from cat_municipios group by d_municipio ASC';
						$conexion8=mysql_query($sql8,$cn);
						//f_type_combobox_filter('combo_zone7','id_direc_municipio',$conexion8,'d_municipio','d_municipio','','',$tamaño8,$ciudad,'',$ver2); comentado por falta de definicion de $ver2 ...en su lugar se envia una cadena vacia
						f_type_combobox_filter('id_direc_municipio','id_direc_municipio',$conexion8,'d_municipio','d_municipio','','',$tamaño8,$ciudad,'','');
			?>  
			<br class="clearAll" /><br />
			
			<div style="width:300px; height:20px; float:left;">
			<label><strong>Estado:</strong> </label>
			<?php
		      		if ($_GET['operacion']==3){
		      				$estado=$aa['t_estado'];
		      		}else{
			      				$estado='';
			      			}
		      				$tamaño9="150px";
							$sql9='select d_estado from cat_estados group by d_estado ASC';
							$conexion9=mysql_query($sql9,$cn);
							//f_type_combobox_filter('combo_zone8','id_direc_estado',$conexion9, 'd_estado','d_estado','','',$tamaño9,$estado,'',$ver2); comentado por falta de definicion de $ver2 ...en su lugar se envia una cadena vacia
							f_type_combobox_filter('id_direc_estado','id_direc_estado',$conexion9, 'd_estado','d_estado','','',$tamaño9,$estado,'','');
			?>
			</div>
			
			
			<label class="labelpeque"><strong>Ruta: </strong></label>
			<input name="id_ruta" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){echo $aa["ruta"];}?>" />
			
			
			
			<label class="labelpeque"><strong>Referencia domicilio: </strong></label>
			<input name="referencia_domicilio_trabajo" type="text" onfocus="doSomething()" value="<?php if ($_GET['operacion']==3){echo $aa["t_referencia_domicilio"];}?>" />
			
			
			
			<br/>
			
			
	
				
			</div>
		</div>
		
		<div id="fragment-5">
        	<div id="form_container">
					<form>
								<p>
										<label><strong>Contenido: </strong></label><textarea name="id_nota" cols="60" rows="10" value=""><?php if ($_GET['operacion']==3){echo $aa["nota"];}?></textarea>
										<br class="clearAll" /><br />
								</p>
					</form>
			</div>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
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
							<input name="btnguardar" type="button"  onclick="validar_formulario()" value="Guardar" />
						
						
							<input onclick="javascript:window.close();" name="btncancelar" type="submit" value="Cancelar" />
						
							<!--<input type="submit" value="Eliminar" />-->
							
						</div>
						</form>
						</div>
<!-- Botones del form -->


</div><!--div body-->
<body>
</html>