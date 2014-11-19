<?php
    

    define('PATH_BASE','../');

	
	require_once("../libs/adodb/adodb-exceptions.inc.php");
	require_once("../libs/adodb/adodb.inc.php");
	require_once("../includes/config.php");
	require_once("../includes/utf8.php");
	require_once("../includes/conexion.php");
	require_once("../libs/lib/lib.php");	
	require_once('../eventos/eventos.class.php');
	
	require_once('../libs/tcpdf/config/lang/eng.php');
	require_once('../libs/tcpdf/tcpdf.php');
	
	
	ini_set('max_execution_time',1200);
    ini_set('display_errors',0);
	ini_set("memory_limit", "256M");

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {		
		
	}

	// Page footer
	public function Footer() {
		
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator('TCPDF');
$pdf->SetAuthor('Instituto Quintanarroense de la Mujer');
$pdf->SetTitle('Directorio Institucional');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(15, 10, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------


	// add a page
	
	
	// set some text to print

    //============================================================+
    // END OF FILE                                                
    //============================================================+

    $db = Conectar();
	$event = new Evento($db);
	
	$evento = $_POST['evento'] ? $_POST['evento'] : $_GET['evento'];
	
	
	//obtenermos la plantilla en HTML
	$sql = "SELECT * FROM  template WHERE temp_evento='".$evento."'";
	$rs  = $db->Execute($sql);
	$template = $rs->FetchRow();
	
	
	//obtenemos las rutas de las dependencias
	$sql = "
	SELECT depe_ruta  AS ruta
     FROM invitados, cat_dependencias 
	WHERE invi_dependencia = depe_dependencia 
	  AND invi_evento = '".$evento."'";
	  
	if(strlen($_POST['persona'])>0){
	   $sql.=" AND invi_persona = '".$_POST['persona']."'";
	}
	
	$sql.=" GROUP BY depe_ruta  ORDER BY depe_ruta";
		  
	
	
	$rs_ruta = $db->Execute($sql);
	
	
	$cnt = 0;
	while($rutas = $rs_ruta->FetchRow() ){
		  $ruta = $rutas['ruta'];
		  
		  //obtenemos todas las dependencias que estan dentro de la ruta
		  $sql ="
		  SELECT depe_dependencia , depe_nombre
		    FROM invitados , cat_dependencias 
		   WHERE invi_dependencia = depe_dependencia 
		     AND invi_evento = '$evento'
			 AND depe_ruta   = '$ruta'  
		  ";
		  if(strlen($_POST['persona'])>0){
			 $sql.=" AND invi_persona = '".$_POST['persona']."'";
		  }
		  $sql.=" GROUP BY depe_dependencia  ORDER BY depe_nombre";
		  
		  $rde = $db->Execute($sql);
		  $cntDEP = $rde->RowCount();
		  	  
		  //Debug('Depe->'.$rde->RowCount()." sql ->".$sql);
		  
		  while($rdepe = $rde->FetchRow()){
			    $rdepe  = utf8_encode_array($rdepe);
				$dependencia  = $rdepe['depe_dependencia'];
				$ndependencia = $rdepe['depe_nombre'];
				
				$sql="
			    SELECT d.*,
				       ( SELECT d_localidad FROM cat_localidad WHERE id_localidad = depe_ciudad) nciudad,
				       ( SELECT d_colonia FROM cat_colonias WHERE id_colonia = depe_colonia ) ncolonia  ,
				       ( SELECT nombre FROM cat_calles WHERE id_calle = depe_calle) ncalle
		          FROM cat_dependencias d
			     WHERE depe_dependencia = '".$dependencia."'";
				
				$mdep  = $db->Execute($sql);
				$rdata = $mdep->FetchRow();
				$rdata = utf8_encode_array($rdata);
				
				$depe_dir = $rdata['ncalle'].' '.$rdata['depe_entre'].' '.$rdata['depe_y_entre'].' No. '.$rdata['depe_numero'].', COL. '.$rdata['ncolonia'].', '.$rdata['nciudad'];
				 
			    $rows = $event->getInvitados($evento,array('persona'=>$_POST['persona'], 'dependencia'=>$dependencia),'array');
				if(is_array($rows)){
				   //Agramos una pagina nueva con los datos de la ruta y dependencia
				   //
				   //
				   //  RUTA          :
				   //  DEPENDENCIA   :
				   //  DIRECCION     :
				   //  No. Invitados :
				   //
				   
				   $pdf->AddPage('P', PDF_PAGE_FORMAT);
				   $pdf->Ln(80);
				   $html = '
				     <table border="1" cellspacing="2" style="width:100%;" nobr="true">
					  <tr>
						<td bgcolor="#CCCCCC" width="18%" style="text-align: right; font-size:10; font-family: Times New Roman, Times, serif;"> <strong>RUTA :</strong></td>
						<td width="82%" style="height:30px; text-align: left; font-size:10; font-family: Times New Roman, Times, serif;">&nbsp;'.$ruta.'</td>
					  </tr>
					  <tr>
						<td bgcolor="#CCCCCC" style="height:20px; text-align: right; font-size:10; font-family: Times New Roman, Times, serif;"><strong> DEPENDENCIA :</strong></td>
						<td style="height:30px; text-align: left; font-size:10; font-family: Times New Roman, Times, serif;">&nbsp;'.$rdata['depe_nombre'].'</td>
					  </tr>
					  <tr>
						<td bgcolor="#CCCCCC" style="height:20px; text-align: right; font-size:10; font-family: Times New Roman, Times, serif;"><strong>DIRECCION :</strong></td>
						<td style="height:30px; text-align: left; font-size:10; font-family: Times New Roman, Times, serif;">&nbsp;'.strtoupper($depe_dir).'</td>
					  </tr>
					  <tr>
						<td bgcolor="#CCCCCC" style="height:20px; text-align: right; font-size:10; font-family: Times New Roman, Times, serif;"><strong>NO. INVITADOS :</strong></td>
						<td style="height:30px; text-align: left; font-size:10; font-family: Times New Roman, Times, serif;">&nbsp;'.count($rows).'</td>
					  </tr>
					</table>';				   
				   $pdf->writeHTML( $html, $ln=true, $fill=false,$reseth = false, $cell = false, $align = 'J')  ;
				   					 
				   
				   //INVITACION PARA LA PERSONA
				   foreach($rows as $kinvi => $rinvi){
						   $rinvi = utf8_encode_array($rinvi);
						   
						   $titulo = $rinvi['invi_ntitulo'];
						   $nombre = $rinvi['invi_npersona'];
						   $ndepen = $rinvi['invi_ndependencia'];
						   $cargo  = $rinvi['invi_cargo'];
						   $grupo  = $rinvi['invi_ngrupo'];
						   
						   
						   
						   $html = $template['temp_template'];					
						   $html = str_replace('{$_TITULO}'      , $titulo  , $html, $cont);
						   $html = str_replace('{$_NOMBRE}'      , $nombre  , $html, $cont);
						   $html = str_replace('{$_DEPENDENCIA}' , $ndepen  , $html, $cont);
						   $html = str_replace('{$_CARGO}'       , $cargo   , $html, $cont);
						   $html = str_replace('{$_GRUPO}'       , $grupo   , $html, $cont);
						   					   
						   
						   $pdf->AddPage('P', PDF_PAGE_FORMAT);
						   $pdf->writeHTML( $html, $ln=true, $fill=false,$reseth = false, $cell = false, $align = 'J')  ;
					   
						   //Debug('Current -> ' . $cnt++);
				   }
	            }
	
			  
		  }
		  
		
	}
	
	
	//ob_end_clean();
	
	//guarda el archivo en el servidor
	$FileName = "invitaciones.".date('dmYhis').'.'.rand(999).'pdf';
    

	//Close and output PDF document
	$pdf->Output($FileName, 'D');
	
		
	function Debug($msg){
	      $text = date('d-m-Y H:i:s : '). $msg."\n";
		  $fp = fopen('log.txt','a+');		  
		  fwrite($fp,$text,strlen($text));
		  
	}
	

	
?>