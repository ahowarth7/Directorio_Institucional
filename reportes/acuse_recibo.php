<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv='Expires' content='Tue, 01 Dec 1991 06:30:00 GMT'>

	<link rel="shortcut icon" type="image/x-png" href="../icons/8.png">
	<title>ACUSE DE RECIBO</title>
	
<script src="../codebase/dhtmlxcommon.js"></script>	
<link rel="STYLESHEET" type="text/css" href="../codebase/dhtmlxcombo.css">
<script src="../codebase/dhtmlxcombo.js"></script>
<script language="javascript" type="text/javascript" src="../codebase/ajax.js"></script>
	

	<?php 
include('../include/funciones_v2.php');
include('../include/conexion_bd.php');
	?>

<style>
html, body{
	width:100%;
	height:100%;
	margin:0px;
	overflow:hidden;
	}
		
		
		

select
{
	font-family:  Tahoma, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #505050; 
    text-transform:uppercase;
    border: double #385D8A;
    color: #000000;
}
h1 {
	font-family:  Tahoma, Arial, Helvetica, sans-serif;
    font-size: 23px;
    font-weight: bold;
	margin: 0 0 0px 0;
	border-bottom: 1px solid #a0a0a0;
	color: #ffffff;
	text-shadow: 1px 1px 6px #000;
}

.h2 {
	font-family:  Tahoma, Arial, Helvetica, sans-serif;
    font-size: 14px;
    font-weight: bold;
	margin: 0 0 0px 0;
	color: #ffffff;
	text-shadow: 1px 1px 6px #000;
}

.titulo{
	font-family:  Tahoma, Arial, Helvetica, sans-serif;
	font-size: 12px;
    font-weight: bold;
    color: #00000;
}

.cont{
	font-family:  Tahoma, Arial, Helvetica, sans-serif;
	font-size: 12px;
    font-weight: normal;
    color: #00000;
}

</style>


<script>
var titulo;

function ajax_cargardatos(div)
{	
	contenedor = document.getElementById(div);
	frm=document.form_3a;
	nombre=document.form_3a.persona.value;
	dependencia=frm.id_dependencia.value;	
	cargo=document.form_3a.cargo.value;	
	municipio=document.form_3a.d_municipio.value;
	localidad=frm.id_localidad.value;
	categoria=document.form_3a.id_categoria.value;
	grupo=frm.id_grupo.value;
	titulo=frm.tit.value;					
	
	ajax=nuevoAjax();
	
	ajax.open("GET", "../ajax/ajax_cargardatos.php?nombre="+nombre+"&dependencia="+dependencia+"&cargo="+cargo+"&municipio="+municipio+"&localidad="+localidad+"&categoria="+categoria+"&grupo="+grupo+"&titulo="+titulo);
	
		ajax.onreadystatechange=function()
   	{
      if (ajax.readyState==4)
      {
         contenedor.innerHTML = ajax.responseText;
      }
   	}
   	ajax.send(null);
}

function ajax_pdf()
{	
	
	frm=document.form_3a;
	nombre=document.form_3a.persona.value;
	dependencia=frm.id_dependencia.value;	
	cargo=document.form_3a.cargo.value;	
	municipio=document.form_3a.d_municipio.value;
	localidad=frm.id_localidad.value;
	categoria=document.form_3a.id_categoria.value;
	grupo=frm.id_grupo.value;
	titulo=frm.tit.value;
	
	window.open("pdf.php?nombre="+nombre+"&dependencia="+dependencia+"&cargo="+cargo+"&municipio="+municipio+"&localidad="+localidad+"&categoria="+categoria+"&grupo="+grupo+"&titulo="+titulo, "newwin", "width=650,height=470,menubar=no,scrollbar=auto,resizable=yes,top=50,left=300,status=yes");
	

	
}
function excel()
{	
	frm=document.form_3a;
	nombre=document.form_3a.persona.value;
	dependencia=frm.id_dependencia.value;	
	cargo=document.form_3a.cargo.value;	
	municipio=document.form_3a.d_municipio.value;
	localidad=frm.id_localidad.value;
	categoria=document.form_3a.id_categoria.value;
	grupo=frm.id_grupo.value;
	titulo=frm.tit.value;
	window.open("excel.php?nombre="+nombre+"&dependencia="+dependencia+"&cargo="+cargo+"&municipio="+municipio+"&localidad="+localidad+"&categoria="+categoria+"&grupo="+grupo+"&titulo="+titulo, "newwin");
	
}
</script>

</head>

<body>
<form name="form_3a" method="GET" action="imprimir.php" id="form_3a" >

<table width="100%" border="0">
<tr>
	<td valign="top" width="55%">
		<div id="titulo1" style="width: 100%; height: 100%;background-color:#585858;">
		 
		<table width="100%" border="0" cellpadding="7">
				  <tr>
				    <td align="left"><h1>Seleccione</h1></td>
				  </tr>
				  <tr>
				    <td valign="top">				
					<table cellpadding="3" cellspacing="0" border="0" width="100%" class="h2">
									<tr>
										<td colspan="10"><b>Utilize los campos necesarios para su busqueda</b></td>
									</tr>
									<tr>
										<td align="left" class="titulo" width="90px"><b>Nombre:</b></td>
										<td align="left"><input type="text" size="56" name="persona" style="widht:356px"></td>
									</tr>
									<tr>
										<td align="left" class="titulo"><b>Dependencia:</b></td>
										<td align="left">
										<?php
										$sql_a='select UPPER(d_dependencia) as d_dependencia from cat_dependencias group by d_dependencia ASC';
										$conexion_a=mysql_query($sql_a,$cn); 
										f_type_combobox_filter_tab('html_3_d_dependencia','id_dependencia',$conexion_a,'d_dependencia','d_dependencia','','','400px','','','',$cn);
							
										?>
										</td>
									</tr>
									<tr>
										<td align="left" class="titulo"><b>Cargo:</b></td>
										<td align="left"><input type="text" size="56" name="cargo"></td>
									</tr>
									<tr>
										<td align="left" class="titulo"><b>Municipio:</b></td>
										<td align="left">
										<?php			
										$sql_b='select d_municipio from cat_municipios order by d_municipio ASC';
										$conexion_b=mysql_query($sql_b,$cn);
										f_type_combobox('d_municipio',$conexion_b,'','d_municipio','d_municipio','','','','','','400px');
										?> 
										</td>
									</tr>
									<tr>
										<td align="left" class="titulo"><b>Localidad:</b></td>
										<td align="left">
										<?php
										$sql_c='select d_localidad from cat_localidad order by d_localidad ASC';
										$conexion_c=mysql_query($sql_c,$cn);
										f_type_combobox_filter_tab('html_3_id_localidad','id_localidad',$conexion_c,'d_localidad','d_localidad','','','400px','','','');
										?>
										</td>
									</tr>
									<tr>
										<td align="left" class="titulo"><b>Categoria:</b></td>
										<td align="left">
										<?php
										$sql_d='select id_categoria,d_categoria from cat_categorias order by d_categoria ASC';
										$conexion_d=mysql_query($sql_d,$cn);
										f_type_combobox('id_categoria',$conexion_d,'','d_categoria','id_categoria','','','','','','400px');
										?>
										</td>
									</tr>
									<tr>
										<td align="left" class="titulo" colspan="2"><b>Grupos:</b></td>
									</tr>
									<tr>
										<td align="left" colspan="2">
										<?php 
					      				$qrySgrupos="select id_grup,d_grupo from cat_grupos order by d_grupo ASC";
					      				$qrySgrupos=mysql_query($qrySgrupos,$cn);
							    		f_type_combobox_filter_tab('html_3_d_grupo','id_grupo',$qrySgrupos,'d_grupo','id_grup','','','510px','','','');
							    		?>
							    		</td>
									</tr>
									<tr>
										<td align="left" class="titulo"><b>Evento</b></td>
										<td align="left" class="titulo">
										Ninguno&nbsp;<input type="radio" name="diamuj" checked>
										Día Mujer&nbsp;<input type="radio" name="diamuj">
										Maestra&nbsp;<input type="radio" name="diamuj">
										</td>
									</tr>
									<tr>
										<td align="left" colspan="2" style="border-bottom: dotted  1px #000000"></td>
									</tr>
									<tr>
										<td align="left" class="titulo" colspan="2">Titulo del Documento</td>
									</tr>
									<tr>
										<td align="left" colspan="2"><input type="text" size="80" name="tit" ></td>
									</tr>
									<tr>
										<td align="center" height="60px" colspan="10" >
										<table border="0" width="100%" cellpadding="0" cellspacing="0" id="titulo" height="53PX" >
											<tr>
												<td background="../imagenes/b1.gif" width="37px">&nbsp;</td>			
												<td align="center" background="../imagenes/b2.gif" onclick="javascript:ajax_cargardatos('contenido_ajax');" style="cursor: pointer;">EJECUTAR CONSULTA</td>
												<td background="../imagenes/b4.gif" width="35px">&nbsp;</td>
												<td align="center" background="../imagenes/b2.gif" onclick="javascript:ajax_pdf();"style="cursor: pointer;"><img src="../icons/pdf.gif" border="0">&nbsp;IMPRIMIR</td>
												<td background="../imagenes/b4.gif" width="35px">&nbsp;</td>
												<td align="center" background="../imagenes/b2.gif" onclick="javascript:excel();"style="cursor: pointer;"><img src="../icons/9.gif" border="0">&nbsp;EXPORTAR</td>
												<td background="../imagenes/b3.gif" width="35px">&nbsp;</td>
											</tr>
										</table>
										</td>					
									</tr>									
					</table>
												
		</form>
		</table>						    
		</div>
	</td>
	<td valign="top">
			<div id="contenido_ajax"></div> 
	</td>
</tr>
</table>

<script>
z=dhtmlXComboFromSelect("html_3_d_dependencia");
    z.enableFilteringMode(true);

y=dhtmlXComboFromSelect("html_3_id_localidad");
    y.enableFilteringMode(true);

x=dhtmlXComboFromSelect("html_3_d_grupo");
    x.enableFilteringMode(true);

</script>

</body>
</html>