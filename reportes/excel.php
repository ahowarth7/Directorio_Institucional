<?php
	$nombre=strtoupper($_GET['nombre']);
	//$nombre=utf8_decode($nombre);
	$nombre = str_replace(" ","%",$nombre);	
	$dependencia=strtoupper($_GET['dependencia']);
	//$dependencia=utf8_decode($dependencia);	
	$cargo=strtoupper($_GET['cargo']);
	$cargo=utf8_decode($cargo);
    $municipio=strtoupper($_GET['municipio']);
	$municipio=utf8_decode($municipio);
    $localidad=strtoupper($_GET['localidad']);
    $localidad=utf8_decode($localidad);
	$categoria=strtoupper($_GET['categoria']);
    $grupo=strtoupper($_GET['grupo']);
	$evento=strtoupper($_GET['evento']);
	$sexo=strtoupper($_GET['sexo']);
	
/* Comentado temporalmente	
switch ($EVENTO) {
	case 1:// Informe
		echo "esta activada la opcion 1";
	break;
	
	case 2:// 15 de Septiembre
		echo "esta activada la opcion 2";
	break;
	
	case 3:// Dia Internacional de la Mujer
		echo "esta activada la opcion 3";
	break;
	
	case 4://Invitado Especial
		echo "esta activada la opcion 4";
	
	case 5://Varios
		echo "esta activada la opcion 4";
	
	case 6://VIP
		echo "esta activada la opcion 4";
	break;
}
*/

	/* Comentado temporalmente	
    $id=strtoupper($_GET['evento']);
	*/
    
	$titulo=strtoupper($_GET['titulo']);
	
    
 /////////////////////////////////////////////////////////////////////////////////////7   
/*
 $database_server = "172.16.10.1";	 // Database server
            $database_user = "josue";				    // Database username
            $database_pass = "josueiqm85";					 // Database password
            $database_name = "contactos";			       // Database name
            $maxlifetime = "";				 // Cookie max life time in seconds
$cn = mysql_connect($database_server,$database_user,$database_pass);
mysql_select_db($database_name);
*/
///////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////7   
/*$database_server = "localhost";	 // Database server
            $database_user = "root";				    // Database username
            $database_pass = "";					 // Database password
            $database_name = "contactos";			       // Database name
            $maxlifetime = "";				 // Cookie max life time in seconds
$cn = mysql_connect($database_server,$database_user,$database_pass);*/
mysql_select_db($database_name);
///////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////7   
 $database_server = "localhost";	 // Database server
            $database_user = "root";				    // Database username
            $database_pass = "mastiqr10";					 // Database password
            $database_name = "contactos2";			       // Database name
            $maxlifetime = "3600";				 // Cookie max life time in seconds
$cn = mysql_connect($database_server,$database_user,$database_pass);
mysql_select_db($database_name);
///////////////////////////////////////////////////////////////////////////////////////

// Get data records from table.	

     $condicion='';
    
     
	  if ($nombre!=''){
			$condicion .=" and concat_ws(' ',p_nombre,p_paterno,p_materno) like '%$nombre%'";
		} 	
	  if ($dependencia!=''){
			$condicion .=" and t_dependencia1 like '%$dependencia%' or t_dependencia2 like '%$dependencia%' or t_dependencia3 like '%$dependencia%' or t_dependencia4 like '%$dependencia%'";
		} 	
	  if ($cargo!=''){
			$condicion .=" and t_cargo1 like '%$cargo%' or t_cargo2 like '%$cargo%' or t_cargo3 like '%$cargo%' or t_cargo4 like '%$cargo%'";
		} 	
	  if ($municipio!='' and $municipio!='0' ){
			$condicion .=" and t_municipio like '$municipio'";
		} 	
	  if ($localidad!=''){
			$condicion .=" and t_ciudad ='$localidad'";
		} 	
	  if ($categoria!='0' and $categoria!=''){
			$condicion .=" and id_categoria = '$categoria'";
		} 	
	  if ($grupo!='' && $grupo!='354'){ //CAMBIAR SEGUN LA TABLA
			$condicion .=" and id_grupo1 ='$grupo' or  id_grupo2 ='$grupo' or  id_grupo3 ='$grupo' or id_grupo4 ='$grupo'";
		}
      //--------------------------------
	  if ($evento==0){
		  $condicion .= "";	  
	  }
      if ($evento==1){
		 $condicion .= " and diamujer = '1'";
	  }
	  if ($evento==2){
		 $condicion .= " and maestra = '1'";
	  }
	  //--------------------------------
	  
	  //--------------------------------
	  if ($sexo==0){
		  $condicion .= "";	  
	  }
      if ($sexo==1){
		 $condicion .= " and p_sexo = 'H'";
	  }
	  if ($sexo==2){
		 $condicion .= " and p_sexo = 'M'";
	  }
	  //--------------------------------


		if($condicion !='')
		{
	    	$condicion=substr($condicion,5);
			$condicion="where $condicion";
		}

$sql="SELECT id, id_categoria, id_grupo1, concat_ws(' ',p_titulo,p_nombre,p_paterno,p_materno) as nombre,
			 t_cargo1, t_dependencia1, concat_ws(' ',t_tipocalle,t_calle) as direccion, t_ciudad, t_telefono1, t_ext, t_email1, ruta, t_orden
	  FROM tb_contactos ".$condicion."
	  ORDER BY id_categoria,nombre ASC";
	  
$result=mysql_query($sql);


// ----- begin of function library -----
// Excel begin of file header
function xlsBOF() {
	echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); 
	return;
}
// Excel end of file footer
function xlsEOF() {
	echo pack("ss", 0x0A, 0x00);
	return;
}
// Function to write a Number (double) into Row, Col
function xlsWriteNumber($Row, $Col, $Value) {
	echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
	echo pack("d", $Value);
	return;
}
// Function to write a label (text) into Row, Col
function xlsWriteLabel($Row, $Col, $Value ) {
	$L = strlen($Value);
	echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
	echo $Value;
return;
}
// ----- end of function library -----
/*
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");;
header("Content-Disposition: attachment;filename=directorio.xls ");
header("Content-Disposition: attachment;filename=directorio.xls ");
header("Content-Transfer-Encoding: binary ");
header("Content-Type:  charset=iso-8859-1");
xlsBOF();
*/
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");	
header ("Pragma: no-cache");	
header ('Content-type: application/x-msexcel');
header ("Content-Disposition: attachment; filename=EmplList.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" );
/*
Make a top line on your excel sheet at line 1 (starting at 0).
The first number is the row number and the second number is the column, both are start at '0'
*/
xlsBOF();   // begin Excel stream
xlsWriteLabel(0,0,$titulo);

// Make column labels. (at line 3)
xlsWriteLabel(2,0,"ID");
xlsWriteLabel(2,1,"CATEGORIA");
xlsWriteLabel(2,2,"GRUPO");
xlsWriteLabel(2,3,"NOMBRE");
xlsWriteLabel(2,4,"CARGO");
xlsWriteLabel(2,5,"DEPENDENCIA");
xlsWriteLabel(2,6,"TELEFONO");
xlsWriteLabel(2,7,"EXT");
xlsWriteLabel(2,8,"EMAIL");
xlsWriteLabel(2,9,"DIRECCION");
xlsWriteLabel(2,10,"CIUDAD");
xlsWriteLabel(2,11,"RUTA");
xlsWriteLabel(2,12,"ORDEN");


$xlsRow = 3;
// Put data records from mysql by while loop.

while($row=mysql_fetch_array($result)){

xlsWriteNumber($xlsRow,0,$row['id']);
xlsWriteLabel($xlsRow,1,$row['id_categoria']);
xlsWriteLabel($xlsRow,2,$row['id_grupo1']);
xlsWriteLabel($xlsRow,3,$row['nombre']);
xlsWriteLabel($xlsRow,4,$row['t_cargo1']);
xlsWriteLabel($xlsRow,5,$row['t_dependencia1']);
xlsWriteLabel($xlsRow,6,$row['t_telefono1']);
xlsWriteLabel($xlsRow,7,$row['t_ext']);
xlsWriteLabel($xlsRow,8,$row['t_email1']);
xlsWriteLabel($xlsRow,9,$row['direccion']);
xlsWriteLabel($xlsRow,10,$row['t_ciudad']);
xlsWriteLabel($xlsRow,11,$row['ruta']);
xlsWriteLabel($xlsRow,12,$row['t_orden']);
$xlsRow++;
}

xlsEOF();
exit();
?>