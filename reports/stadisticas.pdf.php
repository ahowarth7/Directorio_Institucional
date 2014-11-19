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


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Logo
		$this->Image('../imagenes/iqmlogo.jpg',15,5,45);
		// Set font
		$this->SetFont('helvetica', 'B', 10);
		// Title
		$this->Cell(50);
		$this->Cell(0, 4, 'INSTITUTO QUINTANARROENSE DE LA MUJER', $b=0, $ln=1, $a='L', $f=0, $lk='', $stretch=0, false, $calign='T', $valign='T');
		$this->SetFont('helvetica', '', 8);
		$this->Cell(0, 4, 'ESTADISTICAS DEL EVENTO ', $b=0, $ln=false, $a='C', $f=0, $lk='', $stretch=0, false, $calign='M', $valign='M');		
		
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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
	$statics = $event->getStatics($_POST['evento']);
	
	$db->Close();
	
	
	
	
	
	
	//EMPEZAMOS A DISEÑAR EL HTML
	$html = '
	<table align="center">
	<tr>
	<td width="20%"></td>
	<td width="60%">
		<table cellspacing="0" align="center">
		  <tr>
			<td height="15" colspan="2" bgcolor="#4F81BD" style="color: #FFF; text-align: center; font-size:25px; font-weight: bold;">RESUMEN ESTADISTICO</td>
		  </tr>
		  <tr>
			<td width="70%" height="8" bgcolor="#4F81BD" style="border:1px solid #FFF"><div align="center" style="color:#FFF; font-size:25px;"><b>RUBRO</b></div></td>
			<td width="30%" bgcolor="#4F81BD" style="border:1px solid #FFF; font-size:25px;"><div align="center" style="color:#FFF"><b>CANTIDAD</b></div></td>
		  </tr>
		  <tr>
			<td width="70%" height="8" bgcolor="#D0D8E8" style="text-align: left"><div style="font-size:20px; padding:2px;">GRUPOS INVITADOS</div></td>
			<td width="30%" bgcolor="#D0D8E8" style="border:1px solid #FFF; font-size:20px;"><div align="center">'. number_format($statics['ngrupos']). '</div></td>
		  </tr>
		  <tr>
			<td bgcolor="#E9EDF4" height="8" style="text-align: left"><div style="font-size:20px; padding:2px;">PERSONAS INVITADAS&#13;</div></td>
			<td bgcolor="#E9EDF4" style="border:1px solid #FFF; font-size:20px;"><div align="center">'. number_format($statics['ninvitados']). '</div></td>
		  </tr>
		  <tr>
			<td width="70%" height="8" bgcolor="#D0D8E8" style="text-align: left"><div style="font-size:20px; padding:2px;">INVITACIONES ENTREGADAS</div></td>
			<td width="30%" bgcolor="#D0D8E8" style="border:1px solid #FFF; font-size:20px;"><div align="center">'. number_format($statics['nentregadas']). '</div></td>
		  </tr>
		  <tr>
			<td height="8"   valign="middle" bgcolor="#E9EDF4" style="text-align: left"><div style="font-size:20px; padding:2px;">PERSONAS CONFIRMADAS&#13;</div></td>
			<td bgcolor="#E9EDF4" style="border:1px solid #FFF; font-size:20px;"><div align="center">'. number_format($statics['nconfirmados']). '</div></td>
		  </tr>
		  <tr>
			<td width="70%" height="10" valign="middle" bgcolor="#D0D8E8" style="text-align: left"><div style="font-size:20px; padding:2px;">TITULARES QUE ASISTEN&#13;</div></td>
			<td width="30%" bgcolor="#D0D8E8" style="border:1px solid #FFF; font-size:20px;"><div align="center">'. number_format($statics['ntitulares']). '</div></td>
		  </tr>
		  <tr>
			<td bgcolor="#E9EDF4" height="8" style="text-align: left"><div style="font-size:20px; padding:2px;">SUPLENTES</div></td>
			<td bgcolor="#E9EDF4" style="border:1px solid #FFF;font-size:20px;"><div align="center">'. number_format($statics['nsuplentes']). '</div></td>
		  </tr>
		  <tr>
			<td width="70%" height="8"  bgcolor="#D0D8E8" style="text-align: left"><div style="font-size:20px; padding:2px;">NO ASISTEN&#13;</div></td>
			<td width="30%" bgcolor="#D0D8E8" style="border:1px solid #FFF; font-size:20px;"><div align="center">'. number_format($statics['nnoasisten']). '</div></td>
		  </tr>
		  <tr>
			<td bgcolor="#E9EDF4" height="8" style="text-align: left"><div style="font-size:20px; padding:2px;">LIDERES DE PRIMER NIVEL</div></td>
			<td bgcolor="#E9EDF4" style="border:1px solid #FFF; font-size:20px;"><div align="center">'. number_format($statics['rliderasgo'][1]['cnt']). '</div></td>
		  </tr>
		  <tr>
			<td width="70%" height="8" bgcolor="#D0D8E8" style="text-align: left"><div style="font-size:20px; padding:2px;">LIDERES DE SEGUNDO NIVEL</div></td>
			<td width="30%" bgcolor="#D0D8E8" style="border:1px solid #FFF; font-size:20px;"><div align="center">'. number_format($statics['rliderasgo'][2]['cnt']). '</div></td>
		  </tr>
		  <tr>
			<td bgcolor="#E9EDF4" height="8" style="text-align: left"><div style="font-size:20px; padding:2px;">LIDERES DE TERCER NIVEL</div></td>
			<td bgcolor="#E9EDF4" style="border:1px solid #FFF; font-size:20px;"><div align="center">'. number_format($statics['rliderasgo'][3]['cnt']). '</div></td>
		  </tr> 
		</table>
	</td>
	<td width="20%"></td>
	</tr>
	</table>';
	
	
    $pdf->AddPage();
	$pdf->Ln(20);
	$pdf->SetFont('times', '', 14);
	$pdf->writeHTML( $html, $ln=true, $fill=false,$reseth = false, $cell = false, $align = 'J');	
	//Close and output PDF document
	$pdf->Output(date('dmYhi').'.pdf', 'D');
	
	
	
	
	function Debug($msg){
	      $text = date('d-m-Y H:i:s : '). $msg."\n";
		  $fp = fopen('log.txt','a+');		  
		  fwrite($fp,$text,strlen($text)); 
		  
	}
	
	//
	
 

	
	
	
?>