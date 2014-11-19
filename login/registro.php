<html>
<head>
<title>IQM - REGISTRO USUARIO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" type="image/x-png" href="../icons/iqm.ico">
<script language="JavaScript" type="text/javascript" src="../javascript/md5.js"></script>
<style>
td{;
  font-family: Verdana, Arial, Helvetica, sans-serif  ;
  font-size: 12;
  color: 000 ;
  font-weight: bold
}
</style>
</head>

<body>
<form action="validar_registro.php" method="post">
<br>
<div align="center">
<table width='90%' border='0' align='center' cellpadding='0' cellspacing='0' >
    <tr> 
    <td colspan="3" background="../imagenes/login/login03.jpg" class="contenido1" align="center">
       <b>REGISTRO<b></td>
    </tr>
  
    <tr> 
      <td colspan='2'><hr></td>
    </tr>
    <tr> 
      <td height='26'>Usuario:</td>
      <td><input type='text' name="user"></td>
    </tr>
    <tr> 
      <td height='28'><font size='2' face='verdana'>Contraseña:</font></td>
      <td><input name="pass1" type="password"></td>
    </tr>
    <tr> 
      <td height='28'>Repetir Contraseña:</td>
      <td><input name="pass2" type="password"></td>
    </tr>
    <tr> 
      <td height='25'><font size='2' face='verdana'>Nombre:</font></td>
      <td><input type='text' name="nombre"></td>
    </tr>
    <tr> 
      <td height='25'>Apellido Paterno:</td>
      <td><input type='text' name='lastName'></td>
    </tr>
    <tr>
      <td height='26'>Correo electronico:</td>
      <td><input type='text' name="email"></td>
    </tr>
    <tr>
      <td height='26'>Dependencia:</td>
      <td><input type='text' name="dependencia"></td>
    </tr>
    <tr>
      <td height='26'>Cargo:</td>
      <td><font size='2' face='verdana'>
        <input type='text' name="cargo">
        </font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><font size='2' face='verdana'>
        <input type='submit' name='Submit' value='Registrar'>
        </font></td>
    </tr>
    <tr> 
      <td colspan='2'><hr></td>
    </tr>
    <tr> 
      <td><a href="login.php">SALIR</a></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
</form>
</body>
</html>