<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<?php include('../include/conexion_bd.php'); ?>
<title>Tablero de Control</title>
<meta name="author" content="Thierry Koblentz" />
<meta name="document-rights" content="Copyrighted Work" />
<meta name="Copyright" content="Copyright (c) TJKDesign.com, Thierry Koblentz" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="../codebase/dhtmlxlayout.css">
<link rel="stylesheet" type="text/css" href="../codebase/skins/dhtmlxlayout_dhx_skyblue.css">
<script src="../codebase/dhtmlxcommon.js"></script>
<script src="../codebase/dhtmlxlayout.js"></script>
<script src="../codebase/dhtmlxcontainer.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<style type="text/css" media="screen">
@charset "utf-8";
html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			overflow: hidden;
            font-family: Arial, Helvetica, sans-serif;
}
/*** Text Styles */
h1{ color: #ffffff; font-size: 28px; font-weight: bold; line-height: 1.4em; margin: 0 22px 8px !important; padding: 0; text-align: center;}
h2{ color: #ffffff; font-size: 22px; font-weight: bold; line-height: 1em; margin: 12px 18px 5px 16px; padding: 0; text-align: center;text-transform: uppercase; clear: both;}
h3{ color: #ffffff; font-size: 16px; font-weight: bold; text-align: center; text-shadow: 1px 1px 1px #000;background-color:#396c9f;}
h1, h2, h3, h4, h5 {padding: 0; margin: 0;word-spacing:-0.1em;}                          ,
hr {
    display:block;
    height:1px;
    border:0;
    border-top:1px solid #cccccc;
    margin:1em 0;
    padding:0;
}
strong{background:transparent;border:0;color: #ffffff;text-shadow: 1px 1px 1px #000;font-size: 12px;;margin:0;outline:0;padding:0;vertical-align:baseline}
p{line-height:1.6;margin:5px 0;text-align:justify;color:#4b9bed}
/*** BACKGRUND  */
#header {background: #353535 url(../imagenes/top-menu-bg.png) repeat-x top;  }
#menuprincipal {background: #525252 url("http://209.217.226.156/~tforrest/admin_cp_pro/img/bg_leftside.png") repeat-x top;}
#sub-section {background: #525252 url("http://209.217.226.156/~tforrest/admin_cp_pro/img/bg_leftside.png") repeat-x top;}
#footer {background:url("http://www.oxylusflash.com/themeforest/27/css/layout/footer-bg.jpg") repeat-x top;}
/*******************************************************************/
#sub-section div {text-align:center}
/*** FOOTER */
#footer {position:relative;width:100%; bottom:0;height:52px;}
#footer .content_all {width:960px; font-size:11px; color:#505050;}
#footer .content_all .footer_left{width:auto; float:none;font-family:Arial, Helvetica, sans-serif;   padding-top:18px; text-align:center;}
#footer {clear:left}
/*** IDS Y CLASSS */
.content_all{ width:963px; margin:0 auto; height:auto;  padding-left:37px;}
.boton a:hover {background-position:0 -40px;}
.pad-lr{padding:0 15px;}
/* Status Bars ---------------------------------------------------------------------*/
.status {padding: 8px 10px 5px 10px; border-radius: 10px; -moz-border-radius: 10px; text-shadow: 1px 1px 1px #fff; overflow: auto; margin-bottom: 20px; clear: both;}
		.status img {float: left; padding-right: 5px;}
		.status p {padding: 0; margin: 0;}
		.status p span {font-weight: 700;}
		.status .closestatus {float: right; color: #fff; text-align: center; margin-left: 10px;}
			.status .closestatus a {position: relative; color: #fff; text-decoration: none; padding: 5px; width: 10px; height: 10px; display: block; border-radius: 5px; -moz-border-radius: 5px; line-height: .6em; top: -2px; text-shadow: none;}

.warning {border: 3px solid #BF9900; background: #FEEB9C url("http://209.217.226.156/~tforrest/admin_cp_pro/img/bg_fade_yellow_med.png") repeat-x top;}
		.warning span {color: #BF9900;}
		.warning .closestatus a {background: #BF9900;}
			.warning .closestatus a:hover {background: #9B7C00;}

.success {border: 3px solid #8EA534; background: #CBDA8F url("http://209.217.226.156/~tforrest/admin_cp_pro/img/bg_fade_green_med.png") repeat-x top;}
		.success span {color: #8EA534;}
		.success .closestatus a {background: #8EA534;}
			.success .closestatus a:hover {background: #829829;}

.error {border: 3px solid #990000; background: #F5D0CD url("http://209.217.226.156/~tforrest/admin_cp_pro/img/bg_fade_red_med.png") repeat-x top;}
		.error span {color: #990000;}
		.error .closestatus a {background: #990000;}
			.error .closestatus a:hover {background: #730D0D;}

.info {border: 3px solid #2FADD7; background: #92D6ED url("http://209.217.226.156/~tforrest/admin_cp_pro/img/bg_fade_blue_med.png") repeat-x top;}
		.info span {color: #0E7A9F;}
		.info .closestatus a {background: #2FADD7;}
			.info .closestatus a:hover {background: #228DB0;}
            .warning {border: 3px solid #BF9900; background: #FEEB9C url("http://209.217.226.156/~tforrest/admin_cp_pro/img/bg_fade_yellow_med.png") repeat-x top;}
.warning span {color: #BF9900;}
.warning .closestatus a {background: #BF9900;}
.warning .closestatus a:hover {background: #9B7C00;}
.status {padding: 8px 10px 5px 10px; border-radius: 10px; -moz-border-radius: 10px; text-shadow: 1px 1px 1px #fff; overflow: auto; margin-bottom: 20px; clear: both;}
		.status img {float: left; padding-right: 5px;}
		.status p {padding: 0; margin: 0;}
		.status p span {font-weight: 700;}
		.status .closestatus {float: right; color: #fff; text-align: center; margin-left: 10px;}
			.status .closestatus a {position: relative; color: #fff; text-decoration: none; padding: 5px; width: 10px; height: 10px; display: block; border-radius: 5px; -moz-border-radius: 5px; line-height: .6em; top: -2px; text-shadow: none;}
#message-count {
	background-color: #CC3300;
	padding: 2px 5px;
	color: #fff;
	text-shadow: 0px 1px 16px #333;
	-webkit-box-shadow: 1px 1px 1px #fff;
	-moz-border-radius: 4px; /* FF1+ */;
	-webkit-border-radius: 4px; /* Saf3-4 */;
	border-radius: 4px; /* Opera 10.5, IE 9, Saf5, Chrome */
}
/* Tables ---------------------------------------------------------------------*/
table.no-style th,table.no-style td {
	line-height:18px;
	padding:4px 8px 4px 0;
}
table.no-style td,table.no-style th {
	background:none !important;
	color:#666;
	border-bottom:0 none;
	border-bottom:1px dotted #ddd !important;;
  width: 100%
}
</style>
<script type="text/javascript" charset="utf-8">
	$(function(){
		$('#menu li a').click(function(event){
			var elem = $(this).next();
			if(elem.is('ul')){
				event.preventDefault();
				$('#menu ul:visible').not(elem).slideUp();
				elem.slideToggle();
			}
		});
	});
</script>
<style type="text/css" media="screen">
		#menu{
			-moz-border-radius:5px;
			-webkit-border-radius:5px;
			border-radius:5px;
			-webkit-box-shadow:1px 1px 3px #888;
			-moz-box-shadow:1px 1px 3px #888;
            width: 100%;
		}
		#menu li{border-bottom:1px solid #FFF;}
		#menu ul li, #menu li:last-child{border:none}
		a{
			display:block;
			color:#FFF;
			text-decoration:none;
			font-family:'Helvetica', Arial, sans-serif;
			font-size:13px;
			padding:3px 5px;
			text-shadow:1px 1px 1px #325179;
		}
		#menu a:hover{
			color:#F9B855;
			-webkit-transition: color 0.2s linear;
		}
		#menu ul a{background-color:#6594D1;}
		#menu ul a:hover{
			background-color:#FFF;
			color:#2961A9;
			text-shadow:none;
			-webkit-transition: color, background-color 0.2s linear;
		}
		ul{
			display:block;
			background-color:#2961A9;
			margin:0;
			padding:0;
			width:100%;
			list-style:none;
		}
#menu ul{background-color:#6594D1;}
#menu li ul {display:none;}
</style>
<script type="text/javascript">
/*-------------------   CLICKS A TABLAS ------------*/
$(document).ready(function(){
	$("#bt_usuarios").click(function(evento){
		evento.preventDefault();
		$("#content").load("../ajax/ajax_usuarios.php");
	});
})
$(document).ready(function(){
	$("#id_categoria").click(function(evento){
		evento.preventDefault();
		$("#content").load("../ajax/ajax_cat_categorias.php");
	});
})
$(document).ready(function(){
	$("#id_titulos").click(function(evento){
		evento.preventDefault();
		$("#content").load("../ajax/ajax_cat_titulos.php");
	});
})
$(document).ready(function(){
	$("#id_clasecalle").click(function(evento){
		evento.preventDefault();
		$("#content").load("../ajax/ajax_cat_tipocalle.php");
	});
})


$(document).ready(function(){
	$("#id_bitacora").click(function(evento){
		evento.preventDefault();
		$("#content").load("../ajax/ajax_bitacora.php");
	});
})
</script>
</head>
<body>
<!-- ///////////////////////////////  HEAD  ///////////////////////////////// -->
<div id="header"><h1>Panel de Control</h1></div>
<!-- /////////////////////////////////////  MENU  ////////////////////////////////////////// -->
<div id="menuprincipal" style="width: 100%; height: 100%; overflow: auto; display: none;">
<ul id="menu">
              <li><a href="tablerodecontrol.php"><img src="../icons/house.png" width="12" height="12" alt="" /> Inicio</a></li>
              <li><a href="#"><img src="../icons/table.png" width="12" height="12" alt="" /> Catalogos</a>
              	<ul>
                    <li><a href="#" id="id_titulos">Titulos</a></li>
                    <li><a href="#" ID="id_clasecalle">Tipo de Calle</a></li>
                    <li><a href="#">Nombre de Calle</a></li>
                    <li><a href="#">Colonias</a></li>
                    <li><a href="#">Municios</a></li>
                    <li><a href="#">Ciudades</a></li>
                    <li><a href="#" id="id_depe">Dependencias</a></li>
              		<li><a id="id_categoria" href="#">Categorias</a></li>
                    <li><a href="#">Grupos</a></li>
              	</ul>
              </li>
              <li><a id="bt_usuarios" href="#"><img src="../icons/mbs.png" width="16" height="16" alt="" /> Usuarios</a></li>
              <li><a id="id_bitacora" href="#"><img src="../icons/page.gif" width="12" height="12" alt="" /> Bitacora</a></li>
              <li><a href="../inicio.php"><img src="../icons/logout.png" width="12" height="12" alt="" /> Menu Principal</a></li>
</ul>
</div>
<!-- ///////////////////////////////  CONTENIDO  ///////////////////////////////// -->
<div id="content" style="width: 100%; height: 100%; overflow: auto; display: none;">&nbsp;</div>
<!-- ///////////////////////////////  ESTADISTICAS  ///////////////////////////////// -->
<div id="sub-section" style="width: 100%; height: 100%; overflow: auto; display: none;">
<?php
            $recursos=mysql_query("select count(*) as total,  sum(if(id_tipo='1' or id_tipo='2', 1, 0) ) activos, sum(if(id_tipo='0', 1, 0) ) noactivos from tb_cuentas",$cn);
            $a=mysql_fetch_array($recursos);
/////////////////////  total de categorias  //////////////////////////////////////
			$recursos1=mysql_query("select id_categoria from cat_categorias group by d_categoria",$cn);
			$cat=mysql_num_rows($recursos1);
/////////////////////  total de grupos  //////////////////////////////////////
			$recursos2=mysql_query("select * from cat_grupos group by d_grupo",$cn);
			$grup=mysql_num_rows($recursos2);
/////////////////////   contactos total  //////////////////////////////////////
			$recursos3=mysql_query("select count(*) as total,  sum(if(pers_sexo='H', 1, 0) ) hom, sum(if(pers_sexo='M', 1, 0) ) muj from personas where pers_activo='s'",$cn);
			$contac=mysql_fetch_array($recursos3 );
/////////////////////   ultimo contacto de alta  //////////////////////////////////////
            $sqlaalta=mysql_query("select CONCAT_WS(' ',pers_nombre,pers_apat,pers_amat) as nombre ,pers_cargo,pers_insert ,pers_update from personas order by pers_insert desc limit 1",$cn);
            $aa=mysql_fetch_array($sqlaalta );
/////////////////////   ultimo actulizacion  //////////////////////////////////////
            $sqlaactualiza=mysql_query("select CONCAT_WS(' ',pers_nombre,pers_apat,pers_amat) as nombre ,pers_cargo,pers_update from personas order by pers_update desc limit 1",$cn);
            $bb=mysql_fetch_array($sqlaactualiza );
?>
<div class="pad-lr">
<br />
<h3><img src="../icons/newspaper-icon.png" width="12" height="12" alt="" /> Notificaciones</h3>
<br />
<div class="status warning">
    <p><strong>Usted tiene <span id="message-count">
    <img src="../icons/icon_warning.png" width="16" height="16" alt="" />
    <?php echo $a['noactivos'];?></span> usuarios  por dar de alta</strong></p>
</div>
<br />
<h3><img src="../icons/chart_bar.png" width="16" height="16" alt="" /> &nbsp;Estadisticas</h3>
<table class="no-style full">
<tbody>
    <tr>
        <td align="left"><p><img src="../icons/view.png" width="12" height="12" alt="" /> Categorias:</p></td>
        <td align="right"><strong><?php echo $cat;?></strong></td>
    </tr>
    <tr>
        <td align="left"><p><img src="../icons/groups.png" width="12" height="12" alt="" /> Grupos:</p></td>
        <td align="right"><strong><?php echo $grup;?> </strong></td>
    </tr>
    <tr>
          <td align="left">
            <p>
                <img src="../icons/contactos.png" width="12" height="12" alt="" /> Contactos:
                <br />&nbsp;&nbsp;&nbsp;
                <img src="../icons/female_icon.png" width="12" height="13" alt="" />
                 Mujeres
                <br />&nbsp;&nbsp;&nbsp;
                <img src="../icons/male_icon.png" width="12" height="13" alt="" /> hombres
            </p>
        </td>
        <td align="right">
            <strong><?php echo $contac['total'];?>
            <hr />
             <?php echo $contac['muj'];?>
            <br />
            <?php echo $contac['hom'];?>
            </strong>
        </td>
    </tr>
    <tr>
        <td align="left">
            <p>
                <img src="../icons/mbs.png" width="16" height="16" alt="" /> Usuarios:
                <br />&nbsp;&nbsp;&nbsp;
                <img src="../icons/action_check.gif" width="16" height="16" alt="" />Activos
                <br />&nbsp;&nbsp;&nbsp;
                <img src="../icons/action_delete.gif" width="16" height="16" alt="" />Inactivos
            </p>
        </td>
        <td align="right">
            <strong><?php echo $a['total'];?>
            <hr />
             <?php echo $a['activos'];?>
            <br />
            <?php echo $a['noactivos'];?>
            </strong>
        </td>
    </tr>
</tbody>
</table>
<br />
    <h3><img src="../icons/chart_bar.png" width="16" height="16" alt="" /> &nbsp;Lo Ultimo</h3>
      <table class="no-style full" >
      <tbody>
          <tr>
              <td align="left"><p>Ultima contacto de alta:</p></td>
          </tr>
           <tr>
              <td align="left"><strong><?php echo $aa['pers_insert'];?></strong></td>
          </tr>
          <tr>
              <td align="left"><strong><?php echo $aa['nombre'];?></strong></td>
          </tr>
          <tr>
              <td align="left"><strong><?php echo $aa['pers_cargo'];?></strong></td>
          </tr>
      </tbody>
      </table>
<br />
      <table class="no-style full" >
      <tbody>
          <tr>
              <td align="left"><p>Ultima actualización:</p></td>
          </tr>
           <tr>
              <td align="left"><strong><?php echo $bb['pers_update'];?></strong></td>
          </tr>
          <tr>
              <td align="left"><strong><?php echo $bb['nombre'];?></strong></td>
          </tr>
          <tr>
              <td align="left"><strong><?php echo $bb['pers_cargo'];?></strong></td>
          </tr>
      </tbody>
      </table>
</div>
</div>
<!-- ///////////////////////////////  FOOTER  ///////////////////////////////// -->
<div id="footer">
    <div class="content_all">
      <div class="footer_left">&copy;2010 INSTITUTO&nbsp;QUINTANARROENSE DE LA MUJER. DERECHOS RESERVADOS.</div>
    </div>
</div>
<!-- ///////////////////////////////  CONTROL LAYOUT  ///////////////////////////////// -->
<script>
var dhxLayout = new dhtmlXLayoutObject(document.body, "5I");
dhxLayout.cells("a").hideHeader();
dhxLayout.cells("b").hideHeader();
dhxLayout.cells("c").hideHeader();
dhxLayout.cells("d").hideHeader();
dhxLayout.cells("e").hideHeader();
dhxLayout.cells("a").setHeight(38);
dhxLayout.cells("b").setWidth(200);
dhxLayout.cells("d").setWidth(250);
dhxLayout.cells("e").setHeight(52);
dhxLayout.cells("a").attachObject("header");
dhxLayout.cells("b").attachObject("menuprincipal");
dhxLayout.cells("c").attachObject("content");
dhxLayout.cells("d").attachObject("sub-section");
dhxLayout.cells("e").attachObject("footer");
</script>
</body>
</html>