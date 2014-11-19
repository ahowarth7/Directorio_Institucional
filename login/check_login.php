<?PHP

	//includes
    header("Content-Type: text/html; charset=iso-8859-1");
	header("Content-Encoding :iso-8859-1");

//////////////////////IP/////////////////
if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
{
    $ip = getenv("HTTP_X_FORWARDED_FOR");
}
elseif (isset($_SERVER["CLIENT_IP"]))
{
    $ip = getenv("CLIENT_IP");
}
elseif (isset($_SERVER["REMOTE_ADDR"]))
{
    $ip = getenv("REMOTE_ADDR");
}
///////////////TERMINA IP/////////////////

 $response = array();


	if ( $_POST['action']=='checkLogin'){
		 require_once("../include/conexion_bd.php");
		 require_once("../libs/lib/lib.php");
		 require_once ("../includes/utf8.php");
		 
		 //get the posted values
		 $login = htmlspecialchars($_POST['username'],ENT_QUOTES);
		 $passw = md5($_POST['password']);
		 
		 
		 
		 //now validating the username and password
         $sql    = "
		 SELECT username, pass, id_usuario, user.id_tipo, d_t_user, CONCAT_ws(' ',nombre,ap_paterno,ap_materno) as nombre 
           FROM tb_cuentas user INNER JOIN tipo_user t_user ON user.id_tipo = t_user.id_t_user 
          WHERE username = '".$login ."' 
		 ";
		 $result = mysql_query($sql,$cn);
		 $row    = mysql_fetch_array($result);
		 
		
		 //usuario no existe
		 if( mysql_num_rows($result)==0){
			 $response = array("success"=> false, "message"=>"Usuario Incorrecto");			 
		 }else{
			 //compare the password			 
			 if(strcmp($row['pass'],$passw)==0){
		        $response = array("success"=> true, "message"=>"");			 
		        
				//now set the session from here if needed
				session_name("contacto");
				session_start();
				$id_usuario = $_SESSION['id_usuario']= $row['id_usuario'] ;
	            $_SESSION['id_tipo'] = $row['id_tipo'];
				$_SESSION['nombre']  = $row['nombre'];
				$_SESSION['d_tipo']  = $row['d_t_user'];
				$fecha_hoy = date("d-m-Y");
				$hora      = date ("h:i:s:A") ;
				$sql="insert into tb_bitacoraacceso (id_usuario,fecha_registro,hora, ip)values ( '$id_usuario','$fecha_hoy','$hora','$ip')" ; 
				mysql_query($sql,$cn) or die(mysql_error());
				
	         }else{
			 	$response = array("success"=> false, "message"=>"Contrase&ntilde;a incorrecta");
					
			 }
		 }
		
		 echo json(utf8_encode_array($response),'encode');
		
	}
	
	
	
	

?>