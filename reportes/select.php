<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<script>

function myFunc(url) {
      window.parent.w_imrpimir(url);
}

function getReport(type){
	document.getElementById('tipo').value = type;
	document.form.submit();
}
</script>

<body>
<style> a{text-decoration:none}</style>


<table border="0" width="80%" cellpadding="0" cellspacing="0"  align="center">
<tr height="33">
			<td background="../imagenes/am1.gif" width="24px" height="33" >&nbsp;</td>
			<td background="../imagenes/am2.gif" align="center" id="titulo1"> <b>Seleccione el tipo de reporte</b><br>
	        <td background="../imagenes/am3.gif" width="24px">&nbsp;</td>
</tr>
<tr  height="15">
    <td></td>
    <td><ol><a href="#" onclick="javascript: myFunc('reportes/imprimir.php');">Reporte General</a></ol></td></td>
    <td></td>
</tr>
<tr height="15">
    <td></td>
    <td height="12"><ol>
        <a href="#" onclick="javascript: getReport('invimaestra');">Invitados especiales por la maestra</a><a href="#" onclick="javascript: myFunc('reportes/imprimir.php');"></a>
    </ol></td>
    <td></td>
</tr>
<tr height="15">
    <td></td>
    <td><ol>
      <a href="#" onclick="javascript: getReport('gabineteampliado');">Gabinete Ampliado</a>
    </ol></td>
    <td></td>
</tr>
<tr height="15">
    <td></td>
    <td><ol><a href="#" onclick="javascript: getReport('gralByGroup');">Directorio  general por grupo </a></ol></td>
    <td></td>
</tr>
<tr height="15">
    <td></td>
    <td><ol>
    <a href="#" onclick="javascript: getReport('gralByName');">Directorio general por nombre</a>
    </ol></td>
    <td></td>
</tr>
</table>

<form name="form" id="form" action="process.php" method="post">
   <input type="hidden" name="tipo" id="tipo" value="" />
   <input type="hidden" name="doaction" value="reporte.personalizado" />
</form>


</body>
</html>