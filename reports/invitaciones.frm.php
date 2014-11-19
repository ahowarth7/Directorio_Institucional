<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
#form1 #contener {
	text-align: center;
}
html, body {
	margin:0px;
	height:100%;
}
body {
	margin-left:auto;
	margin-right:auto;
	margin-top:0px;
	font-family:lucida grande, tahoma, verdana, arial, sans-serif;
}

</style>
</head>

<script>
function submit(){
     setTimeout("document.getElementById('form').submit();",1000);
}
</script>
<body onload="submit()">
	
	<table width="100%" height="100%"  border="0">
        <tr>
           <td><div id="contener" style="font-size:12px; text-align:center; height:100%">Generando Invitaciones &nbsp;&nbsp; <img src="../imagenes/ajax-loader.gif" width="16" height="11" /></div></td>
        </tr>
    </table>
	
	<form id="form" name="form" method="post" action="invitaciones.pdf.php">  
	  	<input type="hidden" name="evento" id="evento" value="<? echo $_GET['evento']?>" />
	</form>
</body>
</html>