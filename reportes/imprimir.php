<?PHP
      require_once ('../include/funciones_v2.php');
	  require_once ("../libs/adodb/adodb-exceptions.inc.php");
	  require_once ("../libs/adodb/adodb.inc.php");
	  require_once ("../includes/utf8.php");
	  require_once ("../includes/config.php");
	  require_once ("../includes/conexion.php");
	  require_once ("../libs/lib/lib.php");
	
	  $db = Conectar();  

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv='Expires' content='Tue, 01 Dec 1991 06:30:00 GMT'>
    <link rel="shortcut icon" type="image/x-png" href="../icons/8.png">
    <title>IMPRIMIR</title>

    <!-- Loading jQuery Framework -->
    <script type="text/javascript" src="../jquery/jquery-1.3.2.min.js"></script>
    <!-- Autosuggest module -->
	<link rel="stylesheet" href="../js/autosuggest/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8">	
	<script type="text/javascript" src="../js/jquery.watermarkinput.js"></script>	
	<script type="text/javascript" src="../js/autosuggest/bsn.AutoSuggest_2.1.3.js"></script>  
    
    <script>window.dhx_globalImgPath = "../imagenes/";</script>
    <link rel="STYLESHEET" type="text/css" href="../codebase/dhtmlxcombo.css">
    <script  src="../codebase/dhtmlxcommon.js"></script>
    <script  src="../codebase/dhtmlxcombo.js"></script>

    
<style>
html, body {
	width:100%;
	height:100%;
	margin:0px;
	overflow:hidden;
}
select {
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
.titulo {
	font-family:  Tahoma, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #00000;
}
.cont {
	font-family:  Tahoma, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #00000;
}

.table-title{
  font-family:lucida grande,tahoma,verdana,arial,sans-serif;
  font-size:10px; font-weight:normal;
}
.contenido{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000000;
}
</style>
<script>

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



var titulo;

function execute_query(form,div)
{	
	 var params = new Object();
	 var el = $(div);
	 
	 $.ajax({
	     type : 'POST',
		 url  : 'process.php',
		 data : $(form).serialize()+'&action=contacto.getByFilters',
		 type : "POST",
		 success: function(html) {
		     el.html(html);
		 }
	 });		
}

function ajax_pdf(){	
	 var params = $('#formulario').serialize()+'&action=getPDF';
	 $.download('process.php','format=xls&' + params , 'GET');	 
	

	
}
function excel()
{	var params = $('#formulario').serialize()+'&action=getXLS';
	$.download('process.php','format=xls&' + params );
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
          cbgrupo.loadXML("../reportes/process.php?action=grupos.getByXML&categoria="+c);
		  
		  var g = cbgrupo.getSelectedValue();
		  if(!g){ g=''; }
		  cbdependencia.clearAll(true);	
          cbdependencia.loadXML("../reportes/process.php?action=dependencia.getByXML&grupo="+g);
      });
	  
	  cbgrupo.attachEvent("onBlur",function(){ 
		  var g = cbgrupo.getSelectedValue();
		  if(!g){ g=''; }
		  cbdependencia.clearAll(true);	
          cbdependencia.loadXML("../reportes/process.php?action=dependencia.getByXML&grupo="+g);
      });
	  
	  
	//==================== Autocomplete =================================================
	// Set autosuggest options with all plugins activated & response in xml
	var as_json = new bsn.AutoSuggest('ngrupo', {
		script   : "../contactos/process.php?action=grupo.getList&",
		meth     : 'get',
		varname  : "query",
		json     : true,
		shownoresults:false,				// If disable, display nothing if no results
		noresults:"No hay resultados - Agregar ",			// String displayed when no results
		handleNoResult : function(){},
		maxresults:10,					// Max num results displayed
		cache    : true,				// To enable cache
		minchars : 1,					// Start AJAX request with at leat 2 chars
		timeout  : 10000,				// AutoHide in XX ms
		callback : function (obj) { 	// Callback after click or selection
			$('#grupo').val(obj.id);
		}
	});
	
	//==================== Autocomplete =================================================
	var au_dependencia = new bsn.AutoSuggest('ndependencia', {
		script   : "../contactos/process.php?tip=a&action=dependencia.getList&",
		meth     : 'get',
		varname  : "query",
		json     : true,
		shownoresults:false,				// If disable, display nothing if no results
		noresults:"No hay resultados - Agregar ",			// String displayed when no results
		handleNoResult : function(){},
		maxresults:10,					// Max num results displayed
		width     : 400,
		cache    : true,				// To enable cache
		minchars : 1,					// Start AJAX request with at leat 2 chars
		timeout  : 10000,				// AutoHide in XX ms
		getFields: { grupo : '#grupo'},
		callback : function (obj) { 	// Callback after click or selection
			 $('#dependencia').val(obj.id);
		}
	});
	
	// Set autosuggest options with all plugins activated & response in xml
	var json_muni = new bsn.AutoSuggest('nmunicipio', {
	    script   : "../contactos/process.php?action=municipio.getList&",
	    meth     : 'get',
		varname  : "q",
		json     : true,
		shownoresults:false,				// If disable, display nothing if no results
		noresults:"No hay resultados - Agregar ",			// String displayed when no results
		maxresults:10,					// Max num results displayed
		cache    : true,				// To enable cache
		minchars : 1,					// Start AJAX request with at leat 2 chars
		timeout  : 3000,				// AutoHide in XX ms
		callback : function (obj) { 	// Callback after click or selection
		    $('#municipio').val(obj.id); 
		}
	 });
		 
	 // Set autosuggest options with all plugins activated & response in xml
	 var json_ciudad = new bsn.AutoSuggest('nciudad', {
	     script   : "../contactos/process.php?action=ciudades.getList&",
	     meth     : 'get',
		 varname  : "q",
		 json     : true,
		 shownoresults:false,				// If disable, display nothing if no results
		 noresults:"No hay resultados - Agregar ",			// String displayed when no results
		 maxresults:10,					// Max num results displayed
		 cache    : true,				// To enable cache
		 minchars : 1,					// Start AJAX request with at leat 2 chars
		 timeout  : 4000,   			// AutoHide in XX ms
		 getFields: { municipio : '#municipio'},
		 callback : function (obj) { 	// Callback after click or selection
		 		    $('#ciudad').val(obj.id);
	     }
	});
}

function limpiar(val,to){
         var value = $('#'+val).val();
		 
		 
		 if(value.length == 0){
		    $('#'+to).val('');
		 }
}
</script>
</head>

<body onload="init();">
<form name="formulario" method="GET" action="imprimir.php" id="formulario" >
  <table width="100%" border="0"  class="contenido">
    <tr>
      <td valign="top" width="55%"><div id="titulo1" style="width: 100%; height: 100%; background-color:#585858; color: #FFF;">
          <table width="100%" border="0" cellpadding="7">
            <tr>
              <td align="left"><h1>Seleccione</h1></td>
            </tr>
            <tr>
              <td valign="top"><table cellpadding="1" cellspacing="0" border="0" width="100%" class="h2" >
                  <tr>
                    <td colspan="10"><b>Utilize los campos necesarios para su busqueda</b></td>
                  </tr>
                  <tr>
                    <td align="left" class="titulo" style="text-align: right">Categoria :</td>
                    <td align="left"><select name="categoria" id="categoria" class="x-form-field" style="width:350px">
                      <option selected></option>
                      <?  
						     $sql = "SELECT `id_categoria` clave,  `d_categoria` descrip FROM `cat_categorias` ORDER BY `d_categoria`";
		                     select($sql,'descrip','clave','clave','query');
						  ?>
                    </select></td>
                  </tr>
                  <tr>
                    <td align="left" class="titulo" style="text-align: right">Grupo :</td>
                    <td align="left">
                      <div id="contenedor-grupo">
                         <select name="grupo" id="grupo" class="x-form-field" style="width:350px">
                             <option selected></option>
                             <?  
                                $sql = "SELECT id_grup clave, d_grupo descrip FROM cat_grupos ORDER BY d_grupo";
                                select($sql,'descrip','clave','clave','query');
                             ?>
                         </select>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td width="90" align="left" class="titulo" style="text-align: right"><b>Jerarquia :</b></td>
                    <td align="left">
                      <div class="contenido">
                                 <div style="padding:0px; color: #FFF;"> 
                                      <input type="checkbox" id="jera_titulares" name="jera_titulares" value="1">
                                      Titular/Presidentes
                                 </div>
                                 <div style="padding:0px; color: #FFF;">
                                      <input type="checkbox" id="jera_subtitulares" name="jera_subtitulares" value="2">
                                      Subtitular/Delegados
                                 </div>
                                 <div style="padding:0px; vertical-align:middle">
                                      <input type="checkbox" id="jera_directivo" name="jera_directivo" value="3">
                                      <span style="color: #FFF">Directivo</span></div>
                                 <div style="padding:0px; vertical-align:middle; color: #FFF;">
                                      <input type="checkbox" id="jera_coordinacion" name="jera_coordinacion" value="4">
                                      Coordinaci&oacute;n</div>
                                 <div style="padding:0px; vertical-align:middle; color: #FFF;">
                                      <input type="checkbox" id="jera_jefatura" name="jera_jefatura" value="5">
                                      <label for="jera_jefatura">Jefatura</label></div>
                                 </div>
                    </td>
                  </tr>
                  <tr>
                    <td height="25" align="left" class="titulo" style="text-align: right"><b>Dependencia :</b></td>
                    <td align="left"><select name="dependencia" id="dependencia" class="x-form-field" style="width:350px">
                      <option value=""> </option>
                      <?  
						             $sql = "SELECT depe_dependencia clave, depe_nombre descrip FROM cat_dependencias ORDER BY depe_nombre ";
		                             select($sql,'descrip','clave','clave','query');
						         ?>
                    </select></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" class="titulo" style="text-align: right">Cargo :</td>
                    <td align="left"><input type="text" size="55" name="cargo" style="text-transform:uppercase; width:350px; " /></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" class="titulo" style="text-align: right"><b>Municipio :</b></td>
                    <td align="left"><select name="municipio" id="municipio" class="x-form-field" style="width:350px">
                      <option value=""> </option>
                      <?  
						             $sql = "SELECT `id_municipio_inegi` clave,  `d_municipio` descrip FROM `cat_municipios` WHERE id_estado = 23 ORDER BY d_municipio ";
		                             select($sql,'descrip','clave','clave','query');
						         ?>
                    </select></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" class="titulo" style="text-align: right"><b>Ciudad :</b></td>
                    <td align="left"><input type="text" size="56" name="nciudad" id="nciudad"   onblur="javascript: limpiar('nciudad','ciudad');"/>
                    <input type="hidden" name="ciudad" id="ciudad" /></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" class="titulo" style="text-align: right"><b>Invitaciones:</b></td>
                    <td align="left">
                      <div class="contenido">
                                 <div style="color:#FFF"> 
                                      <input type="checkbox" id="pers_invi_dm" name="pers_invi_dm" value="S">
                                      <label for="pers_invi_dm" style="color: #FFF">Día internacional de la Mujer </label>
                                 </div>
                                 <div style="color:#FFF">
                                      <input type="checkbox" id="pers_invi_avf" name="pers_invi_avf" value="S">
                                      <label for="pers_invi_avf" style="color: #FFF">Aniversario del voto femenino en México </label>
                                 </div>
                                 <div style="color:#FFF">
                                      <input type="checkbox" id="pers_invi_dievcm" name="pers_invi_dievcm" value="S">
                                      <label for="pers_invi_dievcm">Día internacional para la eliminación de la violencia contra la Mujer</label>
                                 </div>
                                  <div style="color:#FFF">
                                      <input type="checkbox" id="pers_invi_maestra" name="pers_invi_maestra" value="S">
                                      <label for="pers_invi_maestra">Invitados por la maestra </label>
                                 </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td height="25" align="left" class="titulo" style="text-align: right"><b>Sexo:</b></td>
                    <td align="left" valign="middle">
                       <div style="font-size:10px">
                          <input autocomplete="off" name="sexo" type="radio" value="">
                          <label for="sexo">Ambos</label>
                          &nbsp;
                          <input autocomplete="off" name="sexo" type="radio" value="H">
                          <label for="sexo">Hombre</label>
                          &nbsp;
                          <input autocomplete="off" name="sexo" type="radio" value="M">
                          <label for="sexo">Mujer</label>
                      </div>
                    </td>
                  </tr>
                  
                  <tr>
                    <td height="25" align="left" class="titulo" style="text-align: right">&nbsp;</td>
                    <td align="left" valign="middle" class="contenido">
                       <div style="color:#FFF">
                                     <input type="checkbox" id="incluye_celular" name="incluye_celular" value="S">
                                      <label for="incluye_celular">Incluir numero celular</label>
                      </div>
                    </td>
                  </tr>
                  <!-- --> <!-- -->
                  
                  <tr>
                    <td align="left" colspan="2" style="border-bottom: dotted  1px #000000"></td>
                  </tr>
                  <tr>
                    <td align="center" height="60px" colspan="10" ><table border="0" width="100%" cellpadding="0" cellspacing="0" id="titulo" height="53PX" >
                        <tr>
                          <td background="../imagenes/b1.gif" width="37px">&nbsp;</td>
                          <td align="center" background="../imagenes/b2.gif" onclick="javascript:execute_query('#formulario','#content_result');" style="cursor: pointer;">EJECUTAR CONSULTA</td>
                          <td background="../imagenes/b4.gif" width="35px">&nbsp;</td>
                          <td align="center" background="../imagenes/b2.gif" onclick="javascript:ajax_pdf();"style="cursor: pointer;"><img src="../icons/pdf.gif" border="0">&nbsp;IMPRIMIR</td>
                          <td background="../imagenes/b4.gif" width="35px">&nbsp;</td>
                          <td align="center" background="../imagenes/b2.gif" onclick="javascript:excel();"style="cursor: pointer;"><img src="../icons/9.gif" border="0">&nbsp;EXPORTAR</td>
                          <td background="../imagenes/b3.gif" width="35px">&nbsp;</td>
                        </tr>
                      </table></td>
                  </tr>
                </table>
          </table>
      </div></td>
      <td valign="top" height="400"><div id="content_result" style="height:400px; overflow:auto"></div></td>
    </tr>
  </table>
</form>
<? $db->Close(); ?>
</body>

<script>

function get_grupos(el){
     
	 $.ajax({
	     url  : "../reportes/process.php?action=grupos.getBySelect&categoria="+el.value,
		 data : $("#formulario").serialize(),
		 type : "POST",
		 success: function(html) {
		     var result = document.getElementById('contenedor-grupo');
			 result.innerHTML = html;
		 }
	 }); 
	 
 }
 </script>
</html>