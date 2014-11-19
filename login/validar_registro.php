<?php
include("../include/conexion_bd.php");
$user = $_POST['user'];
$pass1 =$_POST['pass1'];
$pass2=$_POST['pass2'];
$nombre = strtoupper($_POST['nombre']);
$ap_paterno = strtoupper($_POST['lastName']);
$email=$_POST['email'];
$dependencia=strtoupper($_POST['dependencia']);
$cargo=strtoupper($_POST['cargo']);


$ssql="SELECT * FROM tb_cuentas WHERE username='$user'";
$result=mysql_query($ssql,$cn);
if(mysql_num_rows($result)){
	echo "Nombre de usuario en uso.";
} else {
			mysql_free_result($result);
			//procedimos a comprobar contraseñas
			if($pass1!=$pass2)
			{
					echo "Error: las contraseñas especificadas son distintas";
					return "registro.php" ;
			} else {
							$ssql="INSERT INTO tb_cuentas (username,pass,nombre,ap_paterno,email,dependencia,cargo,id_tipo) VALUES ('$user', md5('$pass1'),'$nombre','$ap_paterno','$email','$dependencia','$cargo','0')";
						if(mysql_query($ssql,$cn))
						{
							echo "Usuario registrado con exito.";
							
							?>
							<div align='center'><font size='1' face='verdana'><a href='../index.php'>Regresar a pagina de Inicio</a></font></div>
<?php


						} else 
							{
								echo "Error registrando usuario.";
								return "../index.php" ;
							}
					}
		}
?>