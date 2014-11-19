<?PHP
    
	include('../include/funciones_v2.php');
    f_verifica_sesion();
    $path = '../';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head id="head">
    
	<title><? echo $config['title']?></title>
   <!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	  
	<link rel="stylesheet" type="text/css" href="../css/style.css"/>   
    
</head>

<body>


<div id="loading-mask" style=""></div> 
    <div id="loading"> 
        <div id="loading-ind" class="loading-indicator">IQM - Administraci&oacute;n de Eventos &#8482;<br>
            <img id="loading-image" src="../imagenes/ajax_indicator.gif" width="32" height="32" style="margin-left:8px; margin-right:8px;float:left;vertical-align:top;"/><br>
            <span id="loading-msg">Loading styles and images...</span>
      </div> 
    </div>
    
	<script type="text/javascript">document.getElementById('loading-msg').innerHTML = 'Loading style and images...';</script> 
	<link rel="stylesheet" type="text/css" href="../js/ext/resources/css/ext-all.css" />
    <!--<link rel="stylesheet" type="text/css" href="../js/ext/resources/css/xtheme-gray-extend.css" />-->
    <link rel="stylesheet" type="text/css" href="../js/ext/plugin/RowEditor/RowEditor.css"/>
    
    
    <script type="text/javascript">document.getElementById('loading-msg').innerHTML = 'Loading UI Components...';</script> 
	<script type="text/javascript" src="../js/ext/adapter/ext/ext-base.js"></script>
    <script type="text/javascript" src="../js/ext/ext-all.js"></script>
	<script type="text/javascript" src="../js/ext/locale/ext-lang-es.js"></script>	
    
    <script type="text/javascript">document.getElementById('loading-msg').innerHTML = 'Loading Plugins...';</script> 
	<script type="text/javascript" src="../js/ext/plugin/HelpIcon.js"></script> 
	<script type="text/javascript" src="../js/ext/plugin/PagingResizer.js"></script> 
   
     
    <script type="text/javascript">document.getElementById('loading-msg').innerHTML = 'Loading Aplication...';</script> 
    <script type="text/javascript" src="event-min.js"></script>
    
    <script type="text/javascript">
		Ext.onReady(function(){
		   
			var loading=document.getElementById("loading");
		    if(loading)document.body.removeChild(loading);
		    // eliminate the loading mask so application shows
		    var mask=document.getElementById("loading-mask");
		    if(mask)document.body.removeChild(mask);      
		});	  
    </script>
    
    
    <div id="contenedor" style="width:100%; height:100%;" align="center">
        <div class="menu" id="tb-menu">
        <ul>
          <li>
            <table class="table" style="padding-left:800px">
              <tr><td><a href="../inicio.php" style="color:yellow;">INICIO </a></td></tr>
            </table>
          </li>
        </ul>
      </div>
    
        <div id="container-panel" style="width:1000px; height:auto;">
            <div id='ptitle' style="font-size:11px; padding-top:20px; padding-bottom:6px; text-align:left"> Modulo de administraci&oacute;n de eventos. Podra organizar un evento, agregar sus invitados y llevar el control y segumiento de la entrega de invitaciones y confirmaciones</div>
            <div id="panel" align="left" style="height:auto"></div>
        </div>
        
        
    </div>
    
    
    
    
  <div id="win-main"    style="display:none"></div>
  <div id="win-error"   style="display:none"></div>
  <div id="win-loading" style="display:none"></div>
  <div id="dlg-search"  style="display:none"></div>
  <div id="frm-report-invi" style="display:none"></div>


    

</body>
</html>