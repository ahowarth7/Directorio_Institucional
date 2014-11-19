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
    $mujer=strtoupper($_GET['diamujer']);
	$titulo=strtoupper($_GET['titulo']);
    
     	
	   $condicion='';
    
    
   
	  if ($nombre!=''){
			$condicion .=" and concat_ws(' ',p_nombre,p_paterno,p_materno) like '%$nombre%'";
		} 	
	  if ($dependencia!=''){
			$condicion .=" and t_dependencia like '%$dependencia%'";
		} 	
	  if ($cargo!=''){
			$condicion .=" and t_cargo like '%$cargo%'";
		} 	
	  if ($municipio!='' and $municipio!='0' ){
			$condicion .=" and p_municipio like '$municipio'";
		} 	
	  if ($localidad!=''){
			$condicion .=" and p_ciudad ='$localidad'";
		} 	
	  if ($categoria!='0' and $categoria!=''){
			$condicion .=" and id_categoria = '$categoria'";
		} 	
	  if ($grupo!=''){
			$condicion .=" and id_grupo ='$grupo'";
		} 	
	 	if ($diamujer!=''){
			$condicionmujer .=" and diamujer !='0'";
		} 	

		if($condicion !='')
		{
	    	$condicion=substr($condicion,5);
			$condicion="where $condicion";
		}
				
		 
$sql=("select id,id_categoria,gp.id_grup,gp.d_grupo as grupo,
concat_ws(' ',p_titulo,p_nombre,p_paterno,p_materno) as nombre,
t_dependencia,t_cargo,t_telefono1,t_telefono2,
t_ext,t_extprivida,t_fax,t_faxext,t_nextel
from tb_contactos 
left join cat_grupos gp on gp.id_grup=id_grupo 
order by gp.d_grupo,orden,nombre ASC limit 0,11");
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
			$invitado= "INVITADO";
		}else {
			$invitado="NO INVITADO";
		}
		$nombre=$row['nombre'];
		$cargo=$row['t_cargo'];
		$dependencia=$row['t_dependencia'];
		$telefono=$row['t_telefono1']." Ext.".$row['t_ext'];
		$fax=$row['t_fax']." Ext Fax.".$row['tfaxext'];
		$grupo=$row['grupo'];
		if ($grupo==''){
			$grupo=$row['id']." - NO TIENE GRUPO";
		}else{
			$grupo=$row['id']." - ".$grupo;
		}
		
		$nextel=$row['t_nextel'];
		$categoria=$row['id_categoria'];
		$unido=$row['id']."-".$grupo;
		
	
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(60,10,$grupo,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
      	$pdf->Cell(60,10,"Nombre:".$nombre,0,0,'LR',0,'R');
      	
      	$pdf->SetFont('Arial','',10);
		$pdf->Ln(5);
		$pdf->cell($width[0],10,"Cargo: ".$cargo,0,0,'L');
		$pdf->Ln(5);
		$pdf->cell($width[0],10,"Dependencia: ".$dependencia,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell($width[0],10,"Telefono: ".$telefono,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell($width[0],10,"Fax: ".$fax,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell($width[0],10,"Nextel: ".$nextel,0,0,'L');
		$pdf->Ln(10);
		$pdf->Cell(array_sum($width),0,'','T');
		$pdf->Ln(3);
	
			
}
	

$pdf->Output();
?>