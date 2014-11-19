<?PHP
    
	define('PATH_BASE','../');
	
	ini_set('display_errors',1); 
	ini_set('error_reporting',6135); 
	
	
	//includes
    header("Content-Type: text/html; charset=iso-8859-1");
	header("Content-Encoding :iso-8859-1");
	
	//para los de session
	//include('../include/funciones_v2.php');
    //f_verifica_sesion();
	
	$path = '../'; //dirname(__FILE__);
	require_once("../libs/adodb/adodb-exceptions.inc.php");
	require_once("../libs/adodb/adodb.inc.php");
	require_once("../includes/utf8.php");
	require_once("../includes/config.php");
	require_once("../includes/conexion.php");
	require_once("../libs/lib/lib.php");
	
	//conexion
    $db = Conectar();
	
	$sql = "SELECT * FROM template WHERE temp_evento = '".$_GET['evento']."'";
	$rs  = $db->Execute($sql);
	$row = $rs->FetchRow();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Generar plantilla para evento </title>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    
    <!-- TinyMCE -->
	<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	 <!-- Loading jQuery Framework -->
    <script type="text/javascript" src="../js/jquery1.4.2-min.js"></script>
    
    <!-- Autosuggest module -->
	<link rel="stylesheet" href="../js/autosuggest/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8">	
	<script type="text/javascript" src="../js/autosuggest/bsn.AutoSuggest_2.1.3.js"></script> 
    <script type="text/javascript" src="template-min.js"></script>   


</head>

<body scroll="auto" onload="init();">
    <br />
    <div>    
        <form enctype="application/x-www-form-urlencoded" id="form" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" />
        <div align="center" style=" width:100%; font-family:lucida grande,tahoma,verdana,arial,sans-serif;font-size:11px;"> 
              <div style="width:900px" align="left">
                  Por favor redacte el contenido de la invitaci&oacute;n que se le hara llegar al ciudadano. Campos permitidos <br />
                  <b>{$_NOMBRE}</b> : Nombre completo de la persona, 
                  <b>{$_DEPENDENCIA}</b> : Nombre de la dependencia donde trabaja la persona, 
      <b>{$_CARGO}</b> : Cargo que ocupa la persona dentro la dependencia .  <b>{$_GRUPO}</b> : Grupo al que pertenece, <b>{$_TITULO}</b> : Grupo al que pertenece. <br />
      <div style="text-align:right"></div>
    <br />
                  <div style="text-align:right">
                       <input name="btn-vista-previa" type="button" class="button" value="Vista Previa" onclick="javascript: showPreview();" id="btn-vista-previa" />
                       <div id="vista-previa" style="display:none" align="center">
                       <div style="width:100%;" align="left">
                         Nombre del invitado : 
                         <input type="text" maxlength="200" value="" allowblank="false" style="width: 300px;" id="npersona" class="x-form-field" name="npersona"/>
			             <input name="dispache" type="button" class="button" value="Ejecutar" id="dispache" onclick="javascript:getPDF();" />
                         
                       </div>
                       <script>
						// Set autosuggest options with all plugins activated & response in xml
					   var as_json = new bsn.AutoSuggest('npersona', {
							script   : "process.php?action=evento.getForPreview&evento="+<? echo $_GET['evento']?>+'&',
							meth     : 'POST',
							varname  : "query",
							json     : true,
							shownoresults:false,				// If disable, display nothing if no results
							noresults:"No hay resultados - Agregar ",			// String displayed when no results
							handleNoResult : function(){},
							maxresults:10,					// Max num results displayed
							cache    : true,				// To enable cache
							minchars : 1,					// Start AJAX request with at leat 2 chars
							timeout  : 5000,				// AutoHide in XX ms
							callback : function (obj) { 	// Callback after click or selection
								$('#persona').val(obj.id);
							}
						});	
					</script>
                   </div>
                  </div>
                  <br>
              </div>
        </div>
        <!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded -->
        <div align="center"> 
          <textarea id="template" name="template" cols="80" rows="30"><? echo $row['temp_template']; ?></textarea>
          <input name="html" id="html" type="hidden"/>
          <input name="evento" id="evento" type="hidden" value="<? echo $_GET['evento']?>"/>
          <input name="persona" id="persona" type="hidden"/>
          
          
        </div>
        <!-- Some integration calls -->
        <div align="center">
        <input name="evento" id="evento" type="hidden" value="<? echo $_GET['evento']; ?>" />
            <input name="btn-guardar" type="button" class="btn" value="Cancelar" onclick="javascript: window.close();" />
            <input name="btn-guardar" type="button" class="btn" value="Guardar" onclick="javascript: save(); " />
        </div>
        </form>
        
        
        
    </div>
</body>




</html>