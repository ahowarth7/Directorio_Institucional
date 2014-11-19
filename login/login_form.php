<?php

session_name("contacto");
session_start();
session_unset();
session_destroy();




include("../include/conexion_bd.php");


?>


<html>
<head>
<title>IQM - DIRECTORIO INSTITUCIONAL</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/project-page.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-png" href="../icons/iqm.ico">
	
	<script language="JavaScript" type="text/javascript" src="../codebase/md5.js"></script>
    <script language="javascript" type="text/javascript" src="../js/jquery1.4.2-min.js"></script>

<style>
html { height: 100%; overflow:hidden;}
body { 
margin: 0px; 
padding: 0px; 
height: 100%; 
border-top: 1px transparent solid; 
margin-top: -1px; 
z-index:0; 
position:relative; }

.titulo{
 font-family:Arial, Helvetica, sans-serif;
	font-size:30px;
	font-weight: bold;
	text-tranform: uppercase;
	color:#00b050;
	text-shadow: 1px 1px 1px #000;
}
h1{
 font-family:Arial, Helvetica, sans-serif;
	font-size:16px;
	font-weight: bold;
	text-tranform: uppercase;
	color:#000000;
	text-shadow: 1px 1px 1px #fff;
}
h2{
 font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	text-tranform: uppercase;
	color:#ffffff;
	text-shadow: 1px 1px 1px #000;
}
h3{
 font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	font-weight: bold;
	text-tranform: uppercase;
	color:#000000;
	text-shadow: 1px 1px 1px #fff;
}
h4{
 font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	font-weight: bold;
	text-tranform: uppercase;
	color:#000000;
	text-shadow: 1px 1px 1px #fff;
}
.subtitulo{background-color:#006530;}
.background { background: url("../imagenes/header.jpg") right no-repeat ;background-color:#e12025;}


#login form {
	-moz-border-radius:10px 10px 10px 10px;
	background-color:#F9F8F7;
	border:1px solid #CCCCCC;
	display:block;
	/*margin:30px auto 0;*/
overflow:hidden;
	padding:20px;
	width:450px;
}

.messagebox{
	position:absolute;
	width:auto;
	margin-left:10px;
	border:1px solid #c93;
	background:#ffc;
	padding:3px;
}
.messageboxok{
	width:auto;
	position:absolute;
	border:1px solid #349534;
	background:#C9FFCA;
	padding:3px;
	font-weight:bold;
	color:#008000;
	
}
.messageboxerror{
	width:auto;
	position:absolute;
	border:1px solid #CC0000;
	background:#F7CBCA;
	padding:3px;
	font-weight:bold;
	color:#CC0000;
}


</style>

</head>

<script language="javascript">
//  Developed by Roshan Bhattarai 
//  Visit http://roshanbh.com.np for this script and more.
//  This notice MUST stay intact for legal use
$(document).ready(function(){
	$("#login_form").submit(function(){
		$('#submitlogin').attr('disabled', 'disabled');
		
		//remove all the class add the messagebox classes and start fading
		$("#msgbox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
		
		//check the username exists or not from ajax
		$.ajax({
		  url  : 'check_login.php',
		  data :  { action:'checkLogin', username: $('#username').val(), password: $('#passwd').val()},
		  type : "POST",
		  success: function(data) {
		      
			  try { var json = eval('(' + data + ')'); }catch(e){ json = false; }
			  
			  if(!json){ alert (data); $('#submitlogin').removeAttr('disabled'); return false }
			  
			  //if correct login detail{
			  if(json.success==true){
		  	    //start fading the messagebox
				$("#msgbox").fadeTo(200,0.1,function() { 
			       //add message and change the class of the box and start fading
			       $(this).html('Ingresando al sistema. Por favor espere...').addClass('messageboxok').fadeTo(900,1,function() { 
			  	     //redirect to secure page
				     document.location='../inicio.php';
			      });			  
			    });			  
			  }else {
		  	    //start fading the messagebox
				$("#msgbox").fadeTo(200,0.1,function() { 
			      //add message and change the class of the box and start fading
			      $(this).html(json.message).addClass('messageboxerror').fadeTo(900,1);
			    });
				$('#submitlogin').removeAttr('disabled');
			  }	  
		  },
		  error: function(xmlHttp, status, error) {
              alert('HTTP Error Request : \n status : '+status+'\n error: '+error);
          },
		  complete: function(){}

		});
		
		//not to post the  form physically
 		return false; 
	});
	
	//now call the ajax also focus move from 
	$("#password").blur(function(){
		$("#login_form").trigger('submit');
	});
});
</script>


<div align="center">
<body>


<table width="950px" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr height="50" bgcolor="#222222">
		<td colspan="2" class="titulo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Directorio Institucional</td>
	</tr>
	<tr>
		<td colspan="2" height="100px" class="background"  align="center">&nbsp;</td>
	</tr>
	<tr>
<td align="left">
			
                      
           <div><span id="msgbox" style="display:block"></span></div> 
           <p>&nbsp;</p>
           <div id="login">            
           <form  action="login_submit.php" method="POST" name="login" id="login_form">
			<table width="400px" border="0" align="left" cellspacing="1">
			  
			  	<tr>
				    <td width="100" rowspan="3" align="center"><img src="../imagenes/login/login.jpg" width="100px" height="100px"></td>
				    <td width="93" align="right"><div style="font-weight:bold">Usuario :</div></td>
				    <td width="144"><input type="text" align="middle" name="username" id="username"></td>  
			  	</tr>
			  	<tr>
				    <td align="right"><div style="font-weight:bold">Contraseña :</div></td>  
				    <td><input type="password" name="passwd" id="passwd" align="middle"></td>
			  	</tr>
			  	<tr>
			   		<td align="center" colspan="2"> 
			    	<input  type="submit" value="ENTRAR" name="submitlogin" id="submitlogin"> 
			    </td>
			  	</tr>
			  	<tr>
			  		<td colspan="3" ><h4>No estoy registrado? | <a href="../login/registro.php"> Registro</a></h4></td>
			  	</tr>
			</table>
            </form>
            </div>
	  </td>
		<td align="center" valign="middle"><img src="../imagenes/mujer.jpg" height="265px"></td>
</tr>
	<tr>
		<td colspan="2" height="40px" align="center" bgcolor="#222222">
		<h2>
			Othón P. Blanco #208 Col. Centro. C.P. 77000.Chetumal, Quintana Roo, México. 
			<a href="www.iqm.gob.mx" target="_blank" > <u><b>www.iqm.gob.mx</b></u></a>
		</h2>	
		</td>
	</tr>
</table>



	  	

	  		
	  		



  




</form>

</body>

</div>

