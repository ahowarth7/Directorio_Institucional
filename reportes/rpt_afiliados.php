<?php
header('Content-Type:  charset=iso-8859-1');
include("../include/conexion_bd.php");
define('FPDF_FONTPATH','font/');

require('../include/fpdf.php');



$rdsDatos=mysql_query("set @h=0,@m=0,@aj=0,@a=0,@am=0,@te=0,@prim=0,@sec=0,@bach=0,@pf=0,@lic=0,@ma=0,@doc=0",$cn);
      
      
      
$nombre=strtoupper($_GET['nombre']);
	//$nombre=utf8_decode($nombre);
	
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
	
    $condicion='';
    
    $grupo=utf8_decode($grupo);
    
	  if ($nombre!=''){
			$condicion .=" and concat_ws(' ',personal_nombre,personal_paterno,personal_materno) like '%$nombre%'";
		} 	
	  if ($dependencia!=''){
			$condicion .=" and trabajo_dependencia like '%$dependencia%'";
		} 	
	  if ($cargo!=''){
			$condicion .=" and trabajo_cargo like '%$cargo%'";
		} 	
	  if ($municipio!='' and $municipio!='0' ){
			$condicion .=" and direccion_municipio like '$municipio'";
		} 	
	  if ($localidad!=''){
			$condicion .=" and direccion_ciudad ='$localidad'";
		} 	
	  if ($categoria!='0' and $categoria!=''){
			$condicion .=" and trabajo_categoria like '%$categoria%'";
		} 	
	  if ($grupo!=''){
			$condicion .=" and d_grupo like '%$grupo%' ";
		} 	


		if($condicion !='')
		{
	    	$condicion=substr($condicion,5);
			$condicion="where $condicion";
		}
				
		 
$sql="select concat_ws(' ',personal_nombre,personal_paterno,personal_materno) as nombre,trabajo_dependencia,trabajo_cargo,trabajo_categoria,
trabajo_idgrupo,trabajo_grupo, direccion_municipio,direccion_ciudad,orden,gp.d_grupo,gp.id_cat_grup as id_grupo
from tb_contactos 
inner join tb_grupos gp on gp.id_cat_grup=trabajo_idgrupo
$condicion
order by orden ASC";
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
function ChapterTitle($id_grupo)
{
    //Título
    $this->SetFont('Arial','',12);
    $this->SetFillColor(200,220,255);
    $this->Cell(0,6,"$id_grupo",0,1,'C',true);
    $this->Ln(4);
    //Guardar ordenada
    $this->y0=$this->GetY();
}
function fecha($fecha)
{
	
    //Título
    $this->SetFont('Arial','',12);
    //$this->SetFillColor(200,220,255);
    $this->Cell(0,6,"$fecha",0,1,'C');
    $this->Ln(4);
    //Guardar ordenada
    $this->y0=$this->GetY();
}


}

//Creación del objeto de la clase heredada



$width=array(0,0,0,0,0,19,19,19,19,19,19,19,19,19,25);
$header=array('MUNICIPIO','H','M','AJ','A','AM','TE','PRIM','SEC','BACH','PT','LIC','MA','DOC','AFILIADOS');
$width2=array(0,0,0,133);
$header2=array('','SEXO','EDAD','ESCOLARIDAD');
//Carga de datos

$pdf=new PDF();
$pdf->FPDF('P','mm','letter');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->ChapterTitle($titulo);

//$pdf->ImprovedTable($header2,$width2);
//$pdf->ImprovedTable($header,$width);
//$header=array('País','Capital','Superficie (km2)','Pobl. (en miles)');

      
$contador=0;
for($i=0;$i<$registros;$i++)
{
      $row=mysql_fetch_array($rdsDatos);
	  if($contador ==7){
	  	$pdf->AddPage();
	  	$contador=0;
	  }
	  $contador++;

	
		$nombre=$row['nombre'];
		$cargo=$row['trabajo_cargo'];
		$dependencia=$row['trabajo_dependencia'];
		$telefono=$row['trabajo_lada']."-".$row['trabajo_telefono']." Ext.".$row['trabajo_ext']." Cel.".$row['personal_celular'];
		$email=$row['trabajo_email'];

		$pdf->SetFont('Arial','B',12);
      	$pdf->Cell(60,10,$nombre,0,0,'L');
      	$pdf->SetFont('Arial','',10);
		$pdf->Ln(5);
		$pdf->cell($width[0],10,$cargo,0,0,'L');
		$pdf->Ln(5);
		$pdf->cell($width[0],10,$dependencia,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell($width[0],10,$telefono,0,0,'L');
		$pdf->Ln(5);
		$pdf->Cell($width[0],10,$email,0,0,'L');
		$pdf->Ln(10);
		//Línea de cierre
		$pdf->Cell(array_sum($width),0,'','T');
		$pdf->Ln(3);
			
}
	
	

$pdf->SetFont('Times','',12);

$pdf->Output();
?>