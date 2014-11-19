<?php
header('Content-Type:  charset=iso-8859-1');
include("../include/conexion_bd.php");
define('FPDF_FONTPATH','font/');

require('../include/fpdf.php');



$rdsDatos=mysql_query("set @h=0,@m=0,@aj=0,@a=0,@am=0,@te=0,@prim=0,@sec=0,@bach=0,@pf=0,@lic=0,@ma=0,@doc=0",$cn);
      
      
      
	$fecha=date('d - M - Y');
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
	/* Comentado temporalmente
    $diamujer=strtoupper($_GET['diamujer']);
	*/
	$evento=strtoupper($_GET['evento']);
	
	$sexo=strtoupper($_GET['sexo']);
	
	$titulo=strtoupper($_GET['titulo']);
    
     	
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
		/* Comentado temporalmente		
	 	if ($diamujer!=''){
			$condicionmujer .=" and diamujer !='0'";
		} 	*/
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
				
		 
/*$sql=("select id,id_categoria,id_grupo,concat_ws(' ',p_titulo,p_nombre,p_paterno,p_materno) as nombre,t_dependencia,t_cargo,t_telefono1,t_email,t_ext,
p_municipio,p_ciudad,diamujer,orden,ruta,gp.d_grupo,gp.id_grup
from tb_contactos 
inner join cat_grupos gp on gp.id_grup=id_grupo
$condicion 
order by id_categoria,orden,nombre ASC ");*/

$sql="SELECT id, id_categoria, id_grupo1, concat_ws(' ',p_titulo,p_nombre,p_paterno,p_materno) as nombre,
			 t_cargo1, t_dependencia1, concat_ws(' ',t_tipocalle,t_calle) as direccion, t_ciudad, t_telefono1, t_ext, t_email1, ruta, t_orden,diamujer
	  FROM tb_contactos ".$condicion."
	  ORDER BY id_categoria,nombre ASC";
	  
$rdsDatos=mysql_query($sql,$cn);
$registros=mysql_num_rows($rdsDatos);



class PDF extends FPDF
{
//Cabecera de página
function Header()
{
	//Logo
	$this->Image('../imagenes/iqmlogo.jpg',10,8,50);
	//Arial bold 14
	$this->SetFont('Arial','B',14);
	///Movernos a la derecha
    $this->Cell(80);
	//Título
	$this->Cell('50',8,'DIRECTORIO INSTITUCIONAL',0,0,'C');
	//Variable Fecha
	$fecha=date('d - M - Y');
	//Título
    $this->SetFont('Arial','',12);
    //$this->SetFillColor(200,220,255);
    $this->Cell(0,6,$fecha,0,1,'C');
	//Salto de línea
	 $this->Ln(4);
}

//Encabezados
function ImprovedTable($header,$w)
{
	//Anchuras de las columnas

	//Cabeceras
	$this->SetFillColor(233,233,233);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],5,$header[$i],1,0,'C',1);
	$this->Ln();
}


//Pie de página
function Footer()
{
	//Posición: a 1,5 cm del final
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','I',8);
	$this->SetTextColor(128);

	//Número de página
	$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
function ChapterTitle($titulo)
{
    //Título
    $this->SetFont('Arial','',12);
    $this->SetFillColor(200,220,255);
    $this->Cell(0,6,$titulo,0,1,'C',true);
    $this->Ln(4);
    //Guardar ordenada
    $this->y0=$this->GetY();
}
function fecha($fecha)
{
	//Título
    $this->SetFont('Arial','',12);
    //$this->SetFillColor(200,220,255);
    $this->Cell(0,6,$fecha,0,1,'C');
    $this->Ln(4);
    //Guardar ordenada
    $this->y0=$this->GetY();
}


}

//Creación del objeto de la clase heredada


$pdf=new PDF();
$pdf->FPDF('P','mm','letter');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->ChapterTitle($titulo);
      
$contador=0;
for($i=0;$i<$registros;$i++)
{
		
      $row=mysql_fetch_array($rdsDatos);
	  if($contador ==6){
	  	
	  	$pdf->AddPage();
	  	
	  	$contador=0;
	  	$pdf->ChapterTitle($titulo);
	  }
	  
	  $contador++;
	  
		$invitado=$row['diamujer'];
		if ($invitado!='0'){
			$invitado="INVITADO";
		}else {
			$invitado="NO INVITADO";
		}
		$nombre=$row['nombre'];
		$cargo=$row['t_cargo1'];
		$dependencia=$row['t_dependencia1'];
		$telefono=$row['t_telefono1']." Ext.".$row['t_ext'];
		$email=$row['t_email1'];
		$grupo=$row['id_grupo1'];
		$categoria=$row['id_categoria'];
		$unido=$categoria."  -  ".$grupo;
		
	
		$pdf->SetFont('Arial','B',12);
		$pdf->cell(10,10,$invitado,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
      	$pdf->Cell(60,10,$nombre,0,0,'L');
      	$pdf->SetFont('Arial','',10);
		$pdf->Ln(5);
		$pdf->cell(10,10,$cargo,0,0,'L');
		$pdf->Ln(5);
		$pdf->cell(10,10,$dependencia,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(10,10,$telefono,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell(10,10,$email,0,0,'L');
		/* Asi estaba y marcaba error ya que no existe el arreglo width
		$pdf->Cell($width[0],10,$email,0,0,'L');
		*/
		//$pdf->Ln(5);
		//$pdf->Cell($width[0],10,$unido,0,0,'L');
		$pdf->Ln(10);
		//Línea de cierre
		//$pdf->Cell(array_sum($width),0,'','T'); Comentado Alejandro Suárez
		$pdf->Ln(3);
	
			
}
	
	

$pdf->SetFont('Times','',12);

$pdf->Output();
?>