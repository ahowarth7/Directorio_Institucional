<?php  
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             		// Date in the past
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");		// always modified
        header("Cache-Control: no-cache, must-revalidate");           		// HTTP/1.1
        header("Pragma: no-cache");   // HTTP/1.0
   
		include('include/funciones_v2.php');
		include('include/conexion_bd.php');

		f_verifica_sesion();


		$tipousuario=$_SESSION['d_tipo'];
		
?>

<title>Modificar Directorio</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" type="image/x-png" href="icons/addressbook.png">
<script language="javascript" type="text/javascript" src="codebase/ajax.js"></script>
<link rel="stylesheet" type="text/css" href="codebase/dhtmlxwindows.css">
	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxwindows_dhx_black.css">
	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxwindows_dhx_blue.css">
	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxwindows_dhx_skyblue.css">

	<link rel="stylesheet" type="text/css" href="codebase/dhtmlxlayout.css">
	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxlayout_dhx_skyblue.css">
	
	<script type="text/javascript" src="js/jquery1.4.2-min.js"></script>
	<script src="codebase/dhtmlxcommon.js"></script>
	<script src="codebase/dhtmlxlayout.js"></script>
	<script src="codebase/dhtmlxwindows.js"></script>
    <link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxcombo.css">
    <script src="codebase/dhtmlxcombo.js"></script>
    <script src="codebase/dhtmlxcontainer.js"></script>
    <link rel="stylesheet" type="text/css" href="codebase/dhtmlxtabbar.css">
    <script src="codebase/dhtmlxtabbar.js"></script>
<script>

var dhxLayout,dhxWins,w1,tabbar,dhtmlXTabBar,dhxLayouta;
function popup(id)
{
	window.open("main/ficha_contacto.php?id=" + id, "newwin", "width=650,height=470,menubar=no,scrollbar=auto,resizable=yes,top=50,left=300,status=yes");
}

function regresar()
{
	window.location="inicio.php";
}



///////////////////////////  BUSCAR NOMBRES /////////////////////
function cargar_grupos(div,letra)
{
   	var contenedor;
   	contenedor = document.getElementById(div);
	id_persona= document.form_1.persona.value;
	
	id_letra= letra;
	
	var aleatorio = Math.random();
	
	directo = "directo";
	
	ajax=nuevoAjax();
	ajax.open("GET", "ajax/ajax_buscarnombre.php?id_persona="+id_persona+"&id_letra="+id_letra+"&ale="+aleatorio+"&como="+directo);

   	ajax.onreadystatechange=function()
   	{
      if (ajax.readyState==4)
      {
         contenedor.innerHTML = ajax.responseText;
      }
   	}
   	ajax.send(null);
}
///////////////////////////  BUSCAR GRUPOS /////////////////////
function buscar_grupo(div,letra)
{
   var contenedor;
	
   	contenedor = document.getElementById(div);
	id_persona= document.form_2.grupo.value;
	id_letra= letra;
	var aleatorio = Math.random();
	
	ajax=nuevoAjax();
	ajax.open("GET", "ajax/ajax_buscargrupos.php?id_persona="+id_persona+"&id_letra="+id_letra+"&ale="+aleatorio);

   ajax.onreadystatechange=function()
   {
      if (ajax.readyState==4)
      {
         contenedor.innerHTML = ajax.responseText;
      }
   }
   ajax.send(null);
}
///////////////////////////  BUSQUEDA AVANZADA /////////////////////
/*Disabled because isn´t necesary*/
/*
function busqueda_avanzada(div,letra)
{
   	var contenedor;
   	contenedor = document.getElementById(div);
   	
	id_persona= document.form_1.persona.value;
	id_persona= document.form_1.persona.value;
	id_persona= document.form_1.persona.value;
	id_persona= document.form_1.persona.value;
	id_persona= document.form_1.persona.value;
	id_persona= document.form_1.persona.value;
	id_persona= document.form_1.persona.value;
	id_persona= document.form_1.persona.value;
	
	var aleatorio = Math.random();
	
	ajax=nuevoAjax();
	ajax.open("GET", "ajax/ajax_buscarnombre.php?id_persona="+id_persona+"&id_letra="+id_letra+"&ale="+aleatorio);

   	ajax.onreadystatechange=function()
   	{
      if (ajax.readyState==4)
      {
         contenedor.innerHTML = ajax.responseText;
      }
   	}
   	ajax.send(null);
}
*/
/*Disabled because isn´t necesary*/

///////////////////////////  RESULTADOS DE NOMBRES  ///////////////////////////////////////
function links_grupos(div,id,tipoJerarquia)
{
var aleatorio = Math.random();
var contenedor;   
	
	contenedor = document.getElementById(div);
	id_persona= id;
	ajax=nuevoAjax();
	ajax.open("GET", "ajax/ajax_resultadonombres.php?id_persona="+id_persona+"&ale="+aleatorio);

   	ajax.onreadystatechange=function()
   	{
      if (ajax.readyState==4)
      {
         contenedor.innerHTML = ajax.responseText;
		  /*Valida si se tiene que activar los titulares ó personal de grupo */
		 if(tipoJerarquia==1){
				
				
				var radiotipo = document.getElementsByName("rad");
				radiotipo[0].checked = true;
				
				 document.getElementById('pre_titular').style.visibility='visible';
				 document.getElementById('pre_titular').style.display='block';
		 
				 document.getElementById('pre_grupo').style.visibility='hidden';
				 document.getElementById('pre_grupo').style.display='none';		
				 

				 
		 }
		
		 if(tipoJerarquia!=1){
				
				var radiotipo = document.getElementsByName("rad");
				radiotipo[1].checked = true;
				
			     document.getElementById('pre_grupo').style.visibility='visible';
				 document.getElementById('pre_grupo').style.display='block';
		 
				 document.getElementById('pre_titular').style.visibility='hidden';
				 document.getElementById('pre_titular').style.display='none';
				 
		 }
      }
   	}
   	ajax.send(null);
}
///////////////////////////  RESULTADOS DE NOMBRES  ///////////////////////////////////////
function lista_nombresgrupos(div,id)
{
var aleatorio = Math.random();
var contenedor;   
	
	contenedor = document.getElementById(div);
	id_grup= id;
	directo = "directo";
	
	ajax=nuevoAjax();
	ajax.open("GET", "ajax/ajax_resultadosgrupos.php?id_grup="+id_grup+"&ale="+aleatorio+"&como="+directo);

   	ajax.onreadystatechange=function()
   	{
      if (ajax.readyState==4)
      {
         contenedor.innerHTML = ajax.responseText;
      }
   	}
   	ajax.send(null);
}





function lista_nombre(div,id)
{
	var aleatorio = Math.random();
	
   var contenedor;   
	contenedor = document.getElementById(div);
	opcion= 15;
	id= id;
	ajax=nuevoAjax();
	ajax.open("GET", "main/ajax_contactos.php?opcion="+opcion+"&id="+id+"&ale="+aleatorio);

   	ajax.onreadystatechange=function()
   	{
      if (ajax.readyState==4)
      {
         contenedor.innerHTML = ajax.responseText;
      }
   	}
   	ajax.send(null);
}



function marcaElSeleccionado(id){
	
	
	//Encuentra un elemento con una clase diferente y le regresa su valor
	var allATags = new Array();
	var allATags = document.getElementsByTagName("td");

	for (i=0; i < allATags.length; i++) {

		if (allATags[i].className == "link_lista_directorio_press") {
			allATags[i].className = "link_lista_directorio";
		}
		
	}	
	
	//Asignar color al nuevo elemento
	var elemento = document.getElementById(id);	
	elemento.setAttribute('class','link_lista_directorio_press');	
	//alert("->"+document.getElementById(id).getAttribute('bgcolor'));

	
}

</script>		

<style>
.link_lista_directorio_press{
	background-color: #ffb502;
	font-size:11px;
	font-weight:bold;
	font-family:arial;	
}
</style>

<script type="text/javascript">


//Función para refrescar en el cambio de pestaña
//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
window.onload = function() {

var allATags = new Array();
var allATags = document.getElementsByTagName("div");

for (i=0; i < allATags.length; i++) {

	if (allATags[i].className == "dhx_tabbar_row") {
	allATags[i].onclick = function(){									
									document.getElementById('reporte').innerHTML = '';
									document.getElementById('contenido_ajax').innerHTML = '';
									};	
	
	}
	
}
}

//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
</script>

<script type="text/javascript">
function editar(id){
		 //window.location.href="contacto_editar.php?operacion=3&id='<?php echo $ids;?>'";
		 var a = window.open("contactos/edit.php?operacion=3&id="+id+"&_dc="+(new Date().getTime())+"","ventana1","width=950,height=800,menubar=no,location=no");
		 window.close();
}
</script>

<style>
html, body{
	width:100%;
	height:100%;
	margin:0px;
	overflow:hidden;
	background-color:#ffffff;
	}
#html_4{
	background-image:url('imagenes/info2_01.jpg');
	height:100%;
	width:100%;
}
.link_lista_directorio{
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	font-weight: bold;
	text-tranform: uppercase;
	color:#000000;
	text-decoration:underline;
	list-style-type:none;
	vertical-align:bottom;
}
#tab{
	height:40px;
	width:100%;
	font-family:Arial, Helvetica, sans-serif;
	font-size:13px;
	margin:auto;
	padding:0;
	background-color:#ffffff;
	background-image:url('imagenes/1.gif');
	background-repeat:repeat-x; 
	font-weight: bold;
	text-shadow: 1px 1px 1px #000;
	color:#FFFFFF;
	filter:glow(color=#000000);
}
#barra{
	height:33px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	text-transform: uppercase;
	color: #00000;
	text-align: center;
	text-decoration: none;
	text-shadow: 1px 1px 1px #fff;
}
#titulo{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #ffffff;
	height: 51px;
	text-align: center;
	text-shadow: 1px 1px 1px #000;
	vertical-align:bottom;
}
.titulo{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #ffffff;
	text-shadow: 1px 1px 1px #000;
	style="cursor:pointer;"
}
.contenido{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000000;
}
.contacto{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-weight: bold;
	color: #000000;
}
.footer
{
	height:50px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	text-transform: uppercase;
	color: #00000;
	text-align: center;
	text-decoration: none;
	text-shadow: 1px 1px 1px #fff;
	
}
table {
margin:auto;
}
.boton {
    display:block;
    width:183px;
    height:40px;
    text-indent:-9999px;
    }

.boton a {
    display:block;
    width:183px;
    height:40px;
    background:transparent url(imagenes/boton.gif) no-repeat top left;
    outline:none;
    }
.boton a:hover {
    background-position:0 -40px;
    }

</style>
<style>
#menuh {
        font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
      //  margin-top: 20px;
}

#menuh ul, li {
        list-style-type: none;
}

#menuh ul {
        margin: 0;
        padding: 0;
}

#menuh li {
        float: left;
}

#menuh a {
        text-decoration: none;
        color: #ffffff;
        /*background: #F0F7FC;*/
        display: block;
        padding: 3px 5px;
        text-align: center;
        border: 1px solid #ACCFE8;
        border-width: 1px 1px 1px 0;
}


#menuh a#primero {
        border-left: 1px solid #ACCFE8;
}

#menuh a:hover {
        /*background: #DBEBF6;*/
}

</style>
</head>

<body marginheight="0" marginwidth="0"  topmargin="0" style="text-align:center">

<div id="parentId" align="center"  style="margin: 0 auto;position: relative; width: 1015px; height: 100%; aborder: #B5CDE4 0px solid;"></div>	

<!--//////////////////////////  A  /////////////////////////////////-->
<div id="a" align="center" style="width: 100%; height: 100%; display: none;vertical-align: top  ">

	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="titulo" class="table" >
		<tr>
			<td background="imagenes/menuTop_button.jpg" width="37px">&nbsp;</td>			
			<td align="center" background="imagenes/menuTop_button.jpg"><span style="color:yellow">MODIFICAR EL DIRECTORIO</span></td>
			<td background="imagenes/menuTop_button.jpg" width="35px">&nbsp;</td>
			<td align="center" background="imagenes/menuTop_button.jpg"><a href="javascript:void(0);"  onClick="javascript:regresar();" style="color:#FFF">Menu<br>Principal</a></td>			
			<td background="imagenes/menuTop_button.jpg" width="35px">&nbsp;</td>
		</tr>
	</table>
</div>
<!--//////////////////////////  b - a titulo tab  /////////////////////////////////-->
<div id="titulotab" align="center" style="width: 100%; height: 100%; overflow: auto; display: none;" >
	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="barra">
			<tr>
				<td background="imagenes/am1.gif" width="24px"></td>
				<td background="imagenes/am2.gif" align="left">&nbsp;&nbsp;&nbsp;MODIFIQUE UN REGISTRO</td>
				<td background="imagenes/am3.gif" width="24px"></td>
			</tr>
	</table>
</div>
<!--//////////////////////////  b - b  tab  /////////////////////////////////-->
<div id="general" align="center" style="width: 100%; height: 100%; overflow: auto; margin: 0 auto;position: relative;">	

				<div id="a_tabbar" style="width:100%;" >
							<div id='html_1' style="background-color:#525252;">
							<form name="form_1" method="GET" id="form_1" onSubmit="return false;" > 
						
								<table cellspacing="0" cellpadding="0" border="0" width="100%" height="100%" class="contenido" >
								
												<tr><td colspan="10">&nbsp;</td></tr>
												<tr><td colspan="10" align="center" class="titulo"><b>Edite una persona</b></td></tr>
												<tr><td colspan="10">&nbsp;</td></tr>
												
												<tr>
													<td align="center" colspan="10" class="titulo"><b>Nombre:</b><br>
													<input type="text" size="52" name="persona" style="text-transform:uppercase;widht:356px;" onKeyUp="javascript:cargar_grupos('contenido_ajax');" autocomplete="off">
													</td>
												</tr>
												<tr>
													</td>
														<td align="center" height="50px" colspan="10"><button type="button" onClick="javascript:cargar_grupos('contenido_ajax'); javascript:document.form_1.persona.value = '';">BUSCAR</button> 
													</td>
												</tr>
												
												<tr><td colspan="10">&nbsp;</td></tr>
												<tr>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','A');" value="A" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','B');" value="B" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','C');" value="C" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','D');" value="D" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','E');" value="E" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','F');" value="F" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','G');" value="G" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','H');" value="H" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','I');" value="I" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','J');" value="J" name="letra"></td>
												</tr>
												<tr>
													<td colspan="10">&nbsp;</td>
												</tr>
												<tr>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','K');" value="K" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','L');" value="L" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','M');" value="M" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','N');" value="N" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','Ñ');" value="Ñ" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','O');" value="O" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','P');" value="P" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','Q');" value="Q" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','R');" value="R" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','S');" value="S" name="l"></td>
												</tr>	
												<tr><td colspan="10">&nbsp;</td></tr>
												<tr>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','T');" value="T" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','U');" value="U" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','V');" value="V" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','W');" value="W" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','X');" value="X" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','Y');" value="Y" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:cargar_grupos('contenido_ajax','Z');" value="Z" name="l"></td>
													<td align="center" colspan="3"></td>
												</tr>
										
							</table>
							</form>
							</div>
							<div id='html_2'>
							<form name="form_2" method="GET" action="inicio.php" id="form_2" onSubmit="return false;"> 	
								<table cellspacing="0" cellpadding="0" border="0" width="100%" height="100%" class="contenido" style="background-color:#525252;">
												<tr><td colspan="10">&nbsp;</td></tr>
												<tr><td colspan="10" align="center" class="titulo"><b>Edite una persona de un grupo </b></td></tr>
												<tr><td colspan="10">&nbsp;</td></tr>
												<tr>
													<td align="center" colspan="10" class="titulo"><b>Nombre del grupo:</b><br>
													<input type="text" size="52" name="grupo" style="text-transform:uppercase;widht:356px;" onKeyPress="javascript:buscar_grupo('contenido_ajax');"></td>
												</tr>
												<tr>
													</td><td align="center" height="50px" colspan="10"><button onClick="javascript:buscar_grupo('contenido_ajax');" type="button">BUSCAR</button> <!--<p class="boton"><a alt="Hola" title="Mi Botón" onclick="javascript:cargar_grupo('contenido_ajax','8');" href="URL-destino"></a></p>--></td>
												</tr>
												<tr><td  colspan="10">&nbsp;</td></tr>
												<tr>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','A');" value="A" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','B');" value="B" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','C');" value="C" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','D');" value="D" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','E');" value="E" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','F');" value="F" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','G');" value="G" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','H');" value="H" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','I');" value="I" name="letra"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','J');" value="J" name="letra"></td>
												</tr>
												<tr>
													<td colspan="10">&nbsp;</td>
												</tr>
												<tr>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','K');" value="K" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','L');" value="L" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','M');" value="M" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','N');" value="N" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','Ñ');" value="Ñ" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','O');" value="O" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','P');" value="P" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','Q');" value="Q" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','R');" value="R" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','S');" value="S" name="l"></td>
												</tr>	
												<tr><td colspan="10">&nbsp;</td></tr>
												<tr>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','T');" value="T" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','U');" value="U" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','V');" value="V" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','W');" value="W" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','X');" value="X" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','Y');" value="Y" name="l"></td>
													<td align="center"><input type="button" onClick="javascript:buscar_grupo('contenido_ajax','Z');" value="Z" name="l"></td>
													<td align="center" colspan="3"></td>
												</tr>
											</table>
							</form>
							</div>
							<div id='html_3'>

							<!-- BUSQUEDA AVANZADA    *********************************************************-->
							<!-- ******************************************************************************-->
							<!--Disabled because isn´t necesary-->
							<!--
							<form name="form_3a" method="GET" action="inicio.php" id="form_3" onSubmit="return false;" > 	
							
							<table  cellspacing="0" cellpadding="2" border="0" width="100%" class="contenido" style="background-color:#525252;">
							<tr>
								<td colspan="10" align="center" class="titulo"><b>Utilize los campos necesarios para su busqueda</b></td>
							</tr>
							<tr>
								<td colspan="10" class="titulo">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" colspan="9" class="titulo"><b>Nombre:</b></td>
								<td><input type="text" size="46" name="persona" style="text-transform:uppercase;widht:356px;"></td>
							</tr>
							<tr>
								<td align="left" colspan="9" class="titulo"><b>Dependencia:</b></td>
								<td>
								<?php
								//$conexion11=mysql_query('select UPPER(d_dependencia) as d_dependencia from cat_dependencias group by d_dependencia ASC',$cn);
								//f_type_combobox_filter_tab('html_3_d_dependencia','id_dependencia',$conexion11,'d_dependencia','d_dependencia','','','302','','','');
								?>
								</td>
							</tr>
							<tr>
								<td align="left" colspan="9" class="titulo"><b>Cargo:</b></td>
								<td><input type="text" size="46" name="cargo" style="text-transform:uppercase;"></td>
							</tr>
							<tr>
							<td align="left" colspan="9" class="titulo"><b>Municipio:</b></td>
								<td>
								<?php			
								//$conexion8=mysql_query('select d_municipio from cat_municipios group by d_municipio ASC',$cn);
								//f_type_combobox('d_municipio',$conexion8,'','d_municipio','d_municipio','0','','300','','','');
								?> 
								</td>
							</tr>
							<tr>
							<td align="left" colspan="9" class="titulo"><b>Localidad:</b></td>
								<td>
								<?php
								//$sql8='select d_localidad from cat_localidad group by d_localidad ASC';
								//$conexion8=mysql_query($sql8,$cn);
								//f_type_combobox_filter_tab('html_3_id_localidad','id_localidad',$conexion8,'d_localidad','d_localidad','','',$tamaño8,$ciudad,'','');
								?>
								</td>
							</tr>
							<tr>
							<td align="left" colspan="9" class="titulo"><b>Categoria:</b></td>
								<td>
								<?php
								//$sql10='select d_categoria from tb_grupos group by d_categoria order by d_categoria ASC';
								//$conexion10=mysql_query($sql10,$cn);
								//f_type_combobox('id_categoria',$conexion10,'-','d_categoria','d_categoria',"$clasificacion",'',"",$ver,'','');
								?>
								</td>
							</tr>
							<tr>
							<td align="left" colspan="9" class="titulo"><b>Grupos:</b></td>
								<td>
								<?php 
			      				//$qrySgrupos="select * from tb_grupos group by d_grupo order by d_grupo ASC";
			      				//$qrySgrupos=mysql_query($qrySgrupos,$cn);
					    		//f_type_combobox_filter_tab('html_3_d_grupo','d_grupo',$qrySgrupos,'d_grupo','d_grupo',"",'','290px',"",'','');
					    		?>
					    		</td>
							</tr>
							<tr>
								<td align="center" height="40px" colspan="10">
									<button onclick="javascript:cargar_avanzada('contenido_ajax');" type="button">BUSCAR</button> 
								</td>
							</tr>					
							</table>
							</form>	
							-->
							<!--Disabled because isn´t necesary-->
							</div>
				</div>
</div>
<!--//////////////////////////  C - A  TITULO  /////////////////////////////////-->
<div id="links" style="width: 100%; height: 100%;  display: none;" align="center" >
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="barra">
			<tr>
				<td background="imagenes/am1.gif" width="24px"></td>
				<td background="imagenes/am2.gif" align="left">&nbsp;&nbsp;&nbsp;RESULTADOS DE LA BÚSQUEDA</td>
				<td background="imagenes/am3.gif" width="24px"></td>
			</tr>
	</table>
</div>
<!--//////////////////////////  C - B  LINKS  /////////////////////////////////-->
<div id="link_lista_directorio" style="width: 100%; height: 100%; overflow: auto; display: none;" align="center">
		<div id="contenido_ajax"></div>		
</div>



<!--////////////////////////////////// LITULARES O NO TITULARES //////////////////////////////-->
<div id="tit" style="width: 100%;height: 100%; overflow: hidden;valign:top;vertical-align: top;position:static;" align="center" >
<form name="form_links" method="GET" action="inicio.php" id="form_links" >		
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="barra">
<tr>
			<td background="imagenes/am1.gif" width="24px" >&nbsp;</td>
			<td background="imagenes/am2.gif" align="center" id="titulo1">
				<?php //echo $arreglo['d_grupo']; ?><br>
				<input type="radio" name="rad" id="titulo1" onClick="javascript: $('#pre_titular').css('visibility','visible'); $('#pre_grupo').css('visibility','hidden'); $('#pre_titular').css('display','block'); $('#pre_grupo').css('display','none');" checked="checked"/>Titulares ( <?php //echo $resultadost ?> )
				&nbsp;&nbsp;&nbsp;
				<input type="radio" name="rad" onClick="javascript: $('#pre_titular').css('visibility','hidden'); $('#pre_grupo').css('visibility','visible'); $('#pre_titular').css('display','none'); $('#pre_grupo').css('display','block');" />Personal del grupo ( <?php //echo $resultadosg ?> )
			<td background="imagenes/am3.gif" width="24px">&nbsp;</td>
</tr>

</table>
</form>
</div>








<!--//////////////////////////////////  REPORTE //////////////////////////////-->
<div id="reporte" style="width: 100%;height: 100%; overflow: hidden;" align="center">

</div>	
<!--//////////////////////////  dhxLayout  D - Layout B  /////////////////////////////////-->
<div id="d-b" align="center" style="width: 100%; height: 100%;  display: none;">
	<table border="0" width="100%" cellpadding="0" cellspacing="0" class="footer" >
		<tr>
			<td background="imagenes/f1.gif" width="17px"></td>
			<td background="imagenes/f2.gif" align="center">© 2009 IQM - Dirección de Sistemas . Todos los derechos reservados ®</td>
			<td background="imagenes/f3.gif" width="21px"></td>
		</tr>
	</table>
</div>

<script>

//////////////////////// dhxLayout  A   ////////////////////////////////
dhxLayout = new dhtmlXLayoutObject("parentId", "4I");
dhxLayout.cells("a").hideHeader();
dhxLayout.cells("a").setHeight(53);
dhxLayout.cells("a").attachObject("a");
//////////////////////// dhxLayout  B   ////////////////////////////////
dhxLayout.cells("b").setWidth(470);
dhxLayout.cells("b").setHeight(340);
Layout0 = new dhtmlXLayoutObject(dhxLayout.cells("b"), "2e");
//***************************    dhxLayout  B - layout0 A  ******************************/////
Layout0.cells("a").hideHeader();
Layout0.cells("a").setHeight(35);
Layout0.cells("a").attachObject("titulotab");
//***************************    dhxLayout  B - layout0 B  ******************************/////
Layout0.cells("b").hideHeader();
dhxTabbar = Layout0.cells("b").attachTabbar();
//Layout0.cells("b").attachObject("general");
//dhxTabbar = new dhtmlXTabBar("a_tabbar", "top");
dhxTabbar.setSkin('dhx_black');
dhxTabbar.setImagePath("codebase/imgs/");
dhxTabbar.addTab("a1", " Buscar Persona ", "100px");
dhxTabbar.addTab("a2", " Buscar Grupo ", "100px");
//dhxTabbar.addTab("a3", " Busqueda Avanzada ", "120px"); <!--Disabled because isn´t necesary-->
dhxTabbar.setContent("a1", "html_1");
dhxTabbar.setContent("a2", "html_2");
//dhxTabbar.setContent("a3", "html_3"); <!--Disabled because isn´t necesary-->
dhxTabbar.setTabActive("a1");
//////////////////////// dhxLayout  C   ////////////////////////////////
LayoutC = new dhtmlXLayoutObject(dhxLayout.cells("c"), "2e");
//***************************    dhxLayout  C - layoutC A  ******************************/////
LayoutC.cells("a").setHeight(35);
LayoutC.cells("a").hideHeader();
LayoutC.cells("a").attachObject("links");
//***************************    dhxLayout  C - layoutC B  ******************************/////
LayoutC.cells("b").hideHeader();
LayoutC.cells("b").attachObject("link_lista_directorio");
//////////////////////// dhxLayout  D - Layout A ////////////////////////////////
Layout1 = new dhtmlXLayoutObject(dhxLayout.cells("d"), "3e");
////////////////////////   dhxLayout  D - Layout A  ******************************/////
//Layout1.cells("a").hideHeader();
Layout1.cells("a").attachObject("tit");
Layout1.cells("a").hideHeader();
Layout1.cells("a").setHeight(35);
Layout1.cells("b").attachObject("reporte");
Layout1.cells("b").hideHeader();
//////////////////////// dhxLayout  D - Layout B ////////////////////////////////
Layout1.cells("c").setHeight(50);
Layout1.cells("c").hideHeader();
Layout1.cells("c").setText("Comments");
Layout1.cells("c").attachObject("d-b");

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
    	w1.attachURL("reportes/imprimir.php");
    	
}
function agregar() {
		dhxWins = new dhtmlXWindows();
		dhxWins.setImagePath("codebase/imgs/");
		dhxWins.setSkin('dhx_black');
		w1 = dhxWins.createWindow("w1", 30, 40, 860, 550);
		w1.setText("Agregar Contacto");
		w1.setModal(true);
		w1.centerOnScreen();
    	w1.button("park").disable();
    	w1.button("minmax1").disable();
    	w1.attachURL("main/contacto.php");
    	


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
    	w1.attachURL("main/catalogogrupos.php");
}

/*
var z=dhtmlXComboFromSelect("html_3_d_dependencia");
    z.enableFilteringMode(true);

var y=dhtmlXComboFromSelect("html_3_id_localidad");
    y.enableFilteringMode(true);

var x=dhtmlXComboFromSelect("html_3_d_grupo");
    x.enableFilteringMode(true);*/
</script>
</body>
</html>