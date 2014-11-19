<?php
	require_once ("libs/adodb/adodb-exceptions.inc.php");
	require_once ("libs/adodb/adodb.inc.php");
	require_once ("includes/utf8.php");
	require_once ("includes/config.php");
	require_once ("includes/conexion.php");
	require_once ("libs/lib/lib.php");
	include('include/funciones_v2.php');
	include('include/conexion_bd.php');
	f_verifica_sesion();
	$tipousuario=$_SESSION['d_tipo'];
	$db = Conectar();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE>Directorio General</TITLE>
  <META name="Author" Content="Bit Repository">
  <META name="Keywords" Content="private">
  <META name="Description" Content="Private Page">
  <META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <LINK rel="shortcut icon" type="image/x-png" href="../icons/addressbook.png">

<!-- ////////////////// LIBRERIAS -->
    <script language="javascript" type="text/javascript" src="codebase/ajax.js"></script>
    <script type="text/javascript" src="js/jquery-1.6.min.js"></script>

<!-- ////////////////// DHTMLX -->
    <link rel="stylesheet" type="text/css" href="codebase/dhtmlxwindows.css">
    <link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxwindows_dhx_black.css">
    <link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxlayout_dhx_skyblue.css">
    <link rel="stylesheet" type="text/css" href="codebase/dhtmlxlayout.css">
    <script src="codebase/dhtmlxcommon.js"></script>
    <script src="codebase/dhtmlxlayout.js"></script>
    <script src="codebase/patterns/dhtmlxlayout_pattern4f.js"></script>
    <script src="codebase/dhtmlxwindows.js"></script>

    <link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxmenu_dhx_black.css">
    <script src="codebase/dhtmlxmenu.js"></script>
    <script src="codebase/ext/dhtmlxmenu_ext.js"></script>
    <script src="codebase/dhtmlxcontainer.js"></script>

<!-- /////////////////// FINALIZA DATE CALENDAR ////////////////////-->

<!-- //////////////////////////////   HOJA DE ESTILOS    ////////////////////////// -->
<style>
html, body{
	width:100%;
	height:100%;
	margin:0px;
    padding: 0px;
    overflow:hidden;
    font-family:Arial, Helvetica, sans-serif;
    background:url('img/bg.jpg') repeat-x #718693;
}
.link_lista_directorio{
	font-size:11px;
	font-weight: bold;
	text-tranform: uppercase;
	color:#000000;
	text-decoration:underline;
	list-style-type:none;
	vertical-align:bottom;
}

#barra{
	height:33px;
	font-size: 14px;
	font-weight: bold;
	text-transform: uppercase;
	color: #00000;
	text-align: center;
	text-decoration: none;
	text-shadow: 1px 1px 1px #fff;
}
.contenido{
	font-size: 12px;
	font-weight: normal;
	color: #000000;
}
.contacto{font-size: 13px;font-weight: bold;color: #000000;}
.link_lista_directorio_press{background-color: #ffb502;font-size:11px;font-weight:bold;font-family:arial;}
.centrar-imagen {text-align: center; vertical-align: middle;margin:40px }
/*************************SEARCH**************************************************/
#page{
	/* The main container div */
	width:100%;
	margin:0px auto 0;
}

#searchForm{
	/* The search form. */
	background-color:#4C5A65;
	padding:20px 50px 30px;
	margin:00px 0;
	position:relative;
     height:35px;
	-moz-border-radius:16px;
	-webkit-border-radius:16px;
	border-radius:16px;
}
fieldset{
	border:none;
}
#searchInputContainer{
	/* This div contains the transparent search box */
	width:420px;
	height:36px;
	background:url("img/searchBox.png") no-repeat;
	float:left;
	margin-right:12px;
}
#s{
	/* The search text box. */
	border:none;
	color:#888888;
	background:url("img/searchBox.png") no-repeat;
	float:left;
	font-family:Arial,Helvetica,sans-serif;
	font-size:15px;
	height:36px;
	line-height:36px;
	margin-right:12px;
	outline:medium none;
	padding:0 0 0 35px;
	text-shadow:1px 1px 0 white;
	width:400px;
    text-transform:uppercase;
}
/* The submit button */
#submitButton{
	background:url('img/buttons.png') no-repeat;
	width:83px;
	height:36px;
	text-indent:-9999px;
	overflow:hidden;
	text-transform:uppercase;
	border:none;
	cursor:pointer;
}
#submitButton:hover{
	background-position:left bottom;
}

/* The Search tutorialzine.com / Search the Web radio buttons */

#searchInContainer{
	float:left;
	margin-top:0px;
	width:330px;
}
label{
	color:#DDDDDD;
	cursor:pointer;
	font-size:11px;
	position:relative;
	right:-2px;
	top:-2px;
	margin-right:10px;
	white-space:nowrap;
	/*float:left;*/
}
input[type=radio]{
	cursor:pointer;
	/*float:left;*/
}
</style>


<script>
var dhx_globalImgPath="imagenes/";
dhtmlx.skin="dhx_skyblue";

var dhxLayout,dhxWins,w1,TrnID;
/******************** BUSCAR NOMBRES ************************/
function buscar(){

      var datos= $("#searchForm").serialize();
      $.ajax({
         type: "GET",
         url: "ajax/ajax_buscar.php",
         data:datos,
         success: function(str){
            $("#contenido_ajax").html(str);
         }
      });
}

///////////////////////////  BUSCAR GRUPOS /////////////////////
function buscar_grupo(div,letra)
{

	form_to_submit = 'form_2'; //global y sirve para identificar que formulario se enviara
	form_search_by = 'searchByGroup';
	var contenedor;
   	contenedor = document.getElementById(div);
	id_persona= document.form_1.persona.value;
	id_letra= letra;
	var aleatorio = Math.random();

	clearTimeout(TrnID);
	TrnID = setTimeout( function() {
		ajax=nuevoAjax();
	    ajax.open("GET", "ajax/ajax_buscargrupos.php?id_persona="+id_persona+"&id_letra="+id_letra+"&ale="+aleatorio);

        ajax.onreadystatechange=function() {
           if (ajax.readyState==4){
               contenedor.innerHTML = ajax.responseText;
		   }
	    }
        ajax.send(null);

	}, 500 );
}
///////////////////////////  BUSQUEDA AVANZADA /////////////////////
function busqueda_avanzada(div,letra)
{
   	/*------------------------------------*/
	form_to_submit = 'form_advanced'; //global y sirve para identificar que formulario se enviara
	form_search_by = 'searchAdvanced';

	var contenedor;
   	contenedor = document.getElementById(div);
	var str  = new String();
	var form = document.getElementById('form_advanced');
	str+= 'sexo='+         form.sexo.value;
	str+= '&categoria='+   form.categoria.value;
	str+= '&grupo='+       form.grupo.value;
	str+= '&dependencia='+ form.dependencia.value;
	str+= '&cargo='+       form.cargo.value;
	str+= '&municipio='+   form.municipio.value;
	str+= '&ciudad='+      form.ciudad_id.value;

	if(form.jera_titulares.checked)
	   str+= '&jera_titulares='+     form.jera_titulares.value;
	if(form.jera_subtitulares.checked)
	   str+= '&jera_subtitulares='+ form.jera_subtitulares.value;
	if(form.jera_directivo.checked )
	   str+= '&jera_directivo='+ form.jera_directivo.value;
	if(form.jera_coordinacion.checked )
	   str+= '&jera_coordinacion='+ form.jera_coordinacion.value;
	if(form.jera_jefatura.checked)
	   str+= '&jera_jefatura='+ form.jera_jefatura.value;

	str+= '&_dc='+Math.random();
	ajax=nuevoAjax();
	ajax.open("GET", "ajax/ajax_buscaadvanced.php?"+str);
   	ajax.onreadystatechange=function()
   	{
      if (ajax.readyState==4)
      {
         contenedor.innerHTML = ajax.responseText;
      }
   	}
   	ajax.send(null);
}
jQuery.download = function(url, data, method){
	//http://www.filamentgroup.com/lab/jquery_plugin_for_requesting_ajax_like_file_downloads/
	//url and data options required
	if( url && data ){
		//data can be string of parameters or array/object
		data = typeof data == 'string' ? data : jQuery.param(data);
		//split params into form inputs
		var inputs = '';
		jQuery.each(data.split('&'), function(){
			var pair = this.split('=');
			inputs+='<input type="hidden" name="'+ pair[0] +'" value="'+ pair[1] +'" />';
		});
		//send request
		jQuery('<form action="'+ url +'" method="'+ (method||'post') +'">'+inputs+'</form>').appendTo('body').submit().remove();
	};
};

var form_to_submit = null;
var form_search_by = null;
function pdf(){
	 if(!form_to_submit) return false;
	 var params = $('#'+form_to_submit).serialize();
	 $.download('reportes/process.php','action=exportToPDF&searchBy='+form_search_by+'&' + params , 'POST');
}
function excel(){
	if(!form_to_submit) return false;
	var params = $('#'+form_to_submit).serialize();
	$.download('reportes/process.php','action=exportToXLS&searchBy='+form_search_by+'&'+ params, 'POST' );
}
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
function lista_nombresgrupos(div,id, tipoJerarquia)
{
var aleatorio = Math.random();
var contenedor;

	contenedor = document.getElementById(div);
	id_grup= id;
	ajax=nuevoAjax();
	ajax.open("GET", "ajax/ajax_resultadosgrupos.php?id_grup="+id_grup+"&ale="+aleatorio);
   	ajax.onreadystatechange=function()
   	{
      if (ajax.readyState==4)
      {
         contenedor.innerHTML = ajax.responseText;
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
	var allATags = new Array();
	var allATags = document.getElementsByTagName("td");

	for (i=0; i < allATags.length; i++) {

		if (allATags[i].className == "link_lista_directorio_press") {
			allATags[i].className = "link_lista_directorio";
		}
	}
	var elemento = document.getElementById(id);
	elemento.setAttribute('class','link_lista_directorio_press');
}
</script>

<script type="text/javascript">
//Función para refrescar en el cambio de pestaña
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
</script>
</head>

 <BODY>

<CENTER>Welcome,

This is your private page. You can put specific content here.
</CENTER>
<div id="parentId" align="center"  style="margin: 0 auto;position: relative; width: 1024px; height: 100%; aborder: #B5CDE4 0px solid;"></div>
<div id="my_copy" style="height: 74px;">Hi! I'm copyright &copy;!</div><div id="my_copy" style="height: 74px;">Hi! I'm copyright &copy;!</div>
<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
                                    MENU PRINCIPAL
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
<div id="a" align="center" style="width: 100%; height: 100%; display: block;vertical-align:top;">
    <div class="main_cont">
          <div class="sub_menu">
              <ul>
                  <li><a href="inicio.php">INICIO</a></li>
                  <li><a href="#" onClick="javascript:agregar();"><span>AGREGAR CONTACTOS</span></a></li>
                  <li><a href="modificar.php">MODIFICAR </a></li>
                  <li><a href="#" onClick="javascript:w_imrpimir('reportes/select.php');">REPORTES</a></li>
                  <li><?php if($tipousuario=="Administrador"){?>
                      <a href="main/tablerodecontrol.php">PANEL&nbsp;DE&nbsp;USUARIOS</a>
                      <?php }?>
                  </li>
                  <li><a href="#" onClick="javascript:catalogo();">CATALOGOS</a></li>
                  <li><a href="#" onClick="javascript:eventos();">EVENTOS</a></li>
                  <li><a href="login/login_form.php">SALIR</a></li>
              </ul>
          </div>
    </div>
</div>

<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
                                LOGO
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
<div id="logo" align="center" style="width: 100%; height: 100%; overflow: hidden; margin: 0 auto;position: relative;">
    <img src="imagenes/logoiqm.png" width="428" height="80" alt="" />
</div>
<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
                                HEADER - BUSCAR
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
<div id="header" align="center" style="width: 100%; height: 100%; overflow: hidden; margin: 0 auto;position: relative;">
<div id="page">

     <form id="searchForm" method="GET">
		<fieldset>
           	<input id="s" type="text" name="id_buscar" onkeyup="buscar();"/>
            <input type="submit" value="Submit" id="submitButton" />
             <br />
            <div id="searchInContainer">
                <input type="radio" name="check" value="site" id="searchSite" checked />
                <label for="searchSite" id="siteNameLabel">Buscar Persona</label>

                <input type="radio" name="check" value="web" id="searchWeb" />
                <label for="searchWeb">Buscar por Grupo</label>
			</div>

            <!--  <ul class="icons">
                <li class="web" title="Web Search" data-searchType="web">Web</li>
                <li class="images" title="Image Search" data-searchType="images">Images</li>
                <li class="news" title="News Search" data-searchType="news">News</li>
                <li class="videos" title="Video Search" data-searchType="video">Videos</li>
            </ul> -->
        </fieldset>
    </form>


</div>
</div>

<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
                                CONTACTOS
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
<div id="link_lista_directorio" style="width: 100%; height: 100%; overflow: auto; display: none;" align="center">
		<div id="contenido_ajax" >
            <div class="centrar-imagen"><img src="imagenes/contactos.png" width="128" height="128" alt="" /></div>
        </div>
</div>

<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
                            TITULARES O NO TITULARES
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->

<div id="tit" style="width: 100%;height: 100%; overflow: hidden;valign:top;vertical-align: top;position:static;" align="center" >
<form name="form_links" method="GET" action="inicio.php" id="form_links" >
<table width="100%" cellpadding="0" cellspacing="0" id="barra">
    <tr>
			<td background="imagenes/am1.gif" width="24px" >&nbsp;</td>
			<td background="imagenes/am2.gif" align="left" id="titulo1">
				<br>
				<div style="width:800px; float:left">
                  <input type="radio" name="rad" id="titulo1" onClick="javascript: try{ document.getElementById('pre_titular').style.visibility='visible';document.getElementById('pre_grupo').style.visibility='hidden';document.getElementById('pre_titular').style.display='block';document.getElementById('pre_grupo').style.display='none';} catch(e){}" checked="checked"/>Titulares
				  &nbsp;&nbsp;&nbsp;
				  <input type="radio" name="rad" onClick="javascript: try { document.getElementById('pre_titular').style.visibility='hidden';document.getElementById('pre_grupo').style.visibility='visible';document.getElementById('pre_titular').style.display='none';document.getElementById('pre_grupo').style.display='block';} catch(e){}" />Personal del grupo
                </div>
                <div style="float:right">
                     <a href="#" onClick="javascript:pdf();" style="cursor: pointer;"><img src="icons/pdf.gif" border="0" alt="Exportar en PDF"/></a>&nbsp;
                     <a href="#" onClick="javascript:excel();" style="cursor: pointer;"><img src="icons/page_excel.png" border="0" alt="Exportar en Excel"></a>
                </div>
            </td>
			<td background="imagenes/am3.gif" width="24px">&nbsp;</td>
    </tr>
</table>
</form>
</div>

<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
                                REPORTE
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
<div id="reporte" style="width: 100%;height: 100%; overflow: hidden;valign:top;vertical-align: top;position:static;" align="center">
        <div class="centrar-imagen">
            <img src="imagenes/titulares.png" width="64" height="64" alt="" />&nbsp;&nbsp;&nbsp;<img src="imagenes/notitulares.png" width="64" height="64" alt="" />
        </div>
</div>

<!--XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
                                INICIAN SCRIPS DHTMXL
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX-->
<script>
var dhxLayout = new dhtmlXLayoutObject(document.body, "1C");
    // statusBar = dhxLayout.attachStatusBar();
    // statusBar.setText("© 2011 IQM - Dirección de Sistemas . Todos los derechos reservados ®");
var dhxMenu = dhxLayout.attachMenu();
dhxMenu.setSkin("dhx_black");
dhxMenu.setIconsPath("common/imgs/");
dhxMenu.setTopText("© 2011 IQM - Dirección de Sistemas . Todos los derechos reservados ®");

dhxMenu.addNewSibling(null, "inicio", "Inicio");
dhxMenu.addNewSeparator("inicio", "sep1");
dhxMenu.addNewSibling("sep1", "agregar", "Agregar Contacto");
dhxMenu.addNewSeparator("agregar", "sep2");
dhxMenu.addNewSibling("sep2", "modificar", "Modificar", false);
dhxMenu.addNewSeparator("modificar", "sep3");
dhxMenu.addNewSibling("sep3", "reportes", "Reportes", false);
    dhxMenu.addNewChild("reportes", 0, "a1", "Reporte General", false, "document-index-icon.png");
    dhxMenu.addNewChild("reportes", 1, "a2", "Invitados Especiales", false, "redo_dis.gif");
    dhxMenu.addNewChild("reportes", 2, "a3", "Gabinete Ampliado", false, "pdf.png");
    dhxMenu.addNewChild("reportes", 3, "a4", "Directorio general por grupo", false, "direcgrupo.png");
dhxMenu.addNewSeparator("reportes", "sep4");
dhxMenu.addNewSibling("sep4", "panel", "Panel de Control", false);
dhxMenu.addNewSeparator("panel", "sep5");
dhxMenu.addNewSibling("sep5", "catalogos", "Catalogos", false);
dhxMenu.addNewSeparator("catalogos", "sep6");
dhxMenu.addNewSibling("sep6", "eventos", "Eventos", false);
dhxMenu.addNewSeparator("eventos", "sep7");
dhxMenu.addNewSibling("sep7", "salir", "Salir", false);

dhxMenu.attachEvent("onClick", menuClick);

function menuClick(id) {
    var id=id;
    switch (id) {
    case 'inicio':
            document.location.href="inicio.php";
    break;
    case 'agregar':
            dhxLayout.cells("a").attachURL("contactos/add.php");
    break;
    case 'modificar':
            dhxLayout.cells("a").attachURL("contactos/add.php");
    break;
    case 'a1':
            alert("hola");
    break;
    case 'a2':
            alert("hola");
    break;
    case 'a3':
            alert("hola");
    break;
    case 'a4':
            alert("hola");
    break;
    case 'panel':
            document.location.href="main/tablerodecontrol.php";
    break;
    case 'catalogos':
            dhxWins = new dhtmlXWindows();
            dhxWins.setImagePath("codebase/imgs/");
            dhxWins.setSkin('dhx_black');
        	w2 = dhxWins.createWindow("w1", 30, 40, 950, 500);
        	w2.setText("Catalogo de Categorias y Grupos");
            w2.setModal(true);
        	w2.centerOnScreen();
            w2.button("park").disable();
            w2.button("minmax1").disable();
            w2.attachURL("main/catalogogrupos.php",true);
    break;
    case 'eventos':
            dhxLayout.cells("a").attachURL("eventos/index.php");
    break;
    case 'salir':
            document.location.href="logout.php";
    break;
    }

}

Layout_A = new dhtmlXLayoutObject(dhxLayout.cells("a"), "4f");
Layout_B = new dhtmlXLayoutObject(Layout_A.cells("c"), "2U");
Layout_C = new dhtmlXLayoutObject(Layout_A.cells("d"), "2E");

dhxLayout.cells("a").hideHeader();
Layout_A.cells("a").hideHeader();
Layout_A.cells("b").hideHeader();
Layout_A.cells("d").hideHeader();
Layout_C.cells("a").hideHeader();
Layout_C.cells("b").hideHeader();

Layout_A.cells("a").setWidth(440);
Layout_A.cells("b").setHeight(90);
Layout_A.cells("c").setHeight(300);
Layout_B.cells("a").setWidth(300);
Layout_C.cells("a").setHeight(40);

Layout_B.cells("a").setText("Grupos");
Layout_B.cells("b").setText("Contactos");

Layout_A.cells("a").attachObject("logo");
Layout_A.cells("b").attachObject("header");
Layout_B.cells("b").attachObject("link_lista_directorio");
Layout_C.cells("a").attachObject("tit");
Layout_C.cells("b").attachObject("reporte");

dhxLayout.attachFooter("my_copy");

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx//
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx//

var dhxWins = new dhtmlXWindows();
var w1={};
w1._frame = null ;
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx//
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx//
function w_imrpimir(url) {
		dhxWins.setImagePath("codebase/imgs/");
		dhxWins.setSkin('dhx_black');
		if(!w1._frame) {
		   w1 = dhxWins.createWindow("w1", 30, 40, 1000, 600);
		}
		w1.setText("Imprimir");
		w1.setModal(true);
		w1.centerOnScreen();
    	w1.button("park").disable();
    	w1.button("minmax1").disable();
    	w1.attachURL(url);

}

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
    	w1.attachURL("reportes/reporte_grupos.php");

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
    	w1.attachURL("reportes/imprimir_invitaciones.php");

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
    	w1.attachURL("reportes/acuse_recibo.php");

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
    	w1.attachURL("reportes/confirmaciones.php");
}



//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
var cbciudad = new dhtmlXCombo("cbciudad","ciudad_id",350);
cbciudad.enableFilteringMode(true,'contactos/process.php?action=ciudades.getListByXML');


function getCiudades(el){
	 mid = el.value;
	 cbciudad.clearAll(true);
	 cbciudad.enableFilteringMode(true);
	 cbciudad._xml = 'contactos/process.php?action=ciudades.getListByXML&municipio='+ mid;
	 cbciudad.loadXML('contactos/process.php?action=ciudades.getListByXML&municipio='+ mid);
}
function init(){
	  var cbcategoria =  new dhtmlXComboFromSelect("categoria");
      cbcategoria.enableFilteringMode(true);
	  var cbgrupo =  dhtmlXComboFromSelect("grupo");
      cbgrupo.enableFilteringMode(true);
	  var cbdependencia =  dhtmlXComboFromSelect("dependencia");
      cbdependencia.enableFilteringMode(true);
	  cbcategoria.attachEvent("onBlur",function(){
		  var c = cbcategoria.getSelectedValue();
		  if(!c){ c=''; }
		  cbgrupo.clearAll(true);
		  cbdependencia.clearAll(true);
          cbgrupo.loadXML("reportes/process.php?action=grupos.getByXML&categoria="+c);
		  var g = cbgrupo.getSelectedValue();
		  if(!g){ g=''; }
		  cbdependencia.clearAll(true);
          cbdependencia.loadXML("reportes/process.php?action=dependencia.getByXML&grupo="+g);
      });
	  cbgrupo.attachEvent("onBlur",function(){
		  var g = cbgrupo.getSelectedValue();
		  if(!g){ g=''; }
		  cbdependencia.clearAll(true);
          cbdependencia.loadXML("reportes/process.php?action=dependencia.getByXML&grupo="+g);
      });
 }

 try { document.getElementById('html_3').parentNode.style.overflow='auto'; } catch(e){}
 function get_grupos(el){
     ajax=nuevoAjax();
	 ajax.open("GET", "reportes/process.php?action=grupos.getBySelect&categoria="+el.value);
	 var result = document.getElementById('contenedor-grupo');
   	 ajax.onreadystatechange=function(){
         if (ajax.readyState==4){
             result.innerHTML = ajax.responseText;
         }
   	}
   	ajax.send(null);
 }
</script>
</BODY>
</HTML>