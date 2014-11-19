<?php 
   session_start();
//DIBUJA LA CABECERA DE LA PAGINA
?>
<table width="100%" border="0" cellpadding="0" cellspacing="5" background="images/banner/banner.jpg">
 <tr height="50px">
  <td align="center" valign="top">
  		<div align="center" class="t" style="margin-left:3px; margin-top:2px"><img src="images/banner/icono-overview.png" /></div>
  </td>
  <td align="left" valign="top">
		<div style="float:left; width:90%; margin-top:5px;">
		<div align="left" class="t" style="margin-left:0px;">
			Sistema Integral de Desarrollo Urbano - Municipio de Oth&oacute;n P. Blanco, Q.Roo</div>
		</div>
		<div style="float:right; position:absolute; right:-200px; top: 0px;">
			<img src="images/banner/userborder.png">
		</div>
		<div class="texto" id="user" style="float:right; position:absolute; right:340px; top:1px;">
			<img src="images/banner/user.png" width="23" height="23" style="margin-left:5px;"/>
		</div>
		<div class="texto" id="user" style="float:right; position:absolute; right:220px; top:4px;">
			<span style="color:#ffcc33; margin-left:5px; font-size:10px; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif">
				<a  href="http://localhost/opb/home.php"><? echo $_SESSION['nombre']; ?></a>
			</span>
		</div>
		<div class="texto" id="user" style="float:right; position:absolute; right:145px; top:2px;">
			<img src="images/banner/salir.png" width="20" height="20" style="margin-left:5px;"/>
		</div>
		<div class="texto" id="user" style="float:right; position:absolute; right:110px; top:4px;">
			<span style="color:#ffcc33; margin-left:5px; font-weight:700">
			<a id="user-logout"  href="#">Salir</a>		
			</span>
		</div>					
		<div style="float:right; position:absolute; right:10px; top: 0px;">
			<img src="images/banner/faro.png" width="60" height="47">
	    </div>
  </td>
 </tr>
</table>
