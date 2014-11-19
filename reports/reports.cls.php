<?php


require_once("../libs/fpdf/class.fpdf_table.php");
define('FPDF_FONTPATH','../libs/fpdf/font/');
 
/**
 * Object class, allowing __construct in PHP4.
 */

class Reports
{

	/**
	 * An array of errors
	 *
	 * @var		array of error messages or JExceptions objects
	 * @access	protected
	 * @since	1.0
	 */
    public	$errors		= array();
	private	$pdf		= NULL;
	private	$db 		= NULL;
	public  $config     = array();
	
	
	/**
	 * A hack to support __construct() on PHP 4
	 *
	 * Hint: descendant classes have no PHP4 class_name() constructors,
	 * so this constructor gets called first and calls the top-layer __construct()
	 * which (if present) should call parent::__construct()
	 *
	 * @access	public
	 * @return	Object
	 * @since	1.5
	 */
	function Reports()
	{
		$args = func_get_args();
		call_user_func_array(array(&$this, '__construct'), $args);
	}

	/**
	 * Class constructor, overridden in descendant classes.
	 *
	 * @access	protected
	 * @since	1.5
	 */
	function __construct($db, $orientation='P') {
		
		$this->db = $db;		
	    setlocale(LC_TIME, "spanish-mexican");
		
		
		
		//create pdf
        $this->pdf = new CMyPDF($orientation,"mm","Letter");
		$this->pdf->Open();
		$this->pdf->SetAuthor('Instituto Quintanarroense de la Mujer');
		$this->pdf->SetAutoPageBreak(true, 15);
		$this->pdf->SetMargins(15, 10, 15);
		$this->pdf->AliasNbPages(); 
		
		$this->pdf->SetLineWidth(.1);
		$this->pdf->SetFillColor(213,217,214);
  	    $this->pdf->SetTextColor(0);
	    $this->pdf->SetDrawColor(128,128,128);
		
		
		$this->pdf->config['logo'] = "../imagenes/iqmlogo.jpg";
		$this->pdf->config['font_title']  = array('font'=>'Times','style'=>'B','size'=>12);
		$this->pdf->config['font_stitle'] = array('font'=>'Times','style'=>'','size'=>10);
		
			 
		$this->filename = date('dmYhi').'.pdf';	
	}
	
	
	public function reportInvitados($format, $data){
		$format = strtoupper($format);
	    if($format=='PDF'){
		   $this->reportInvitadosByPDF($data);		
		}elseif($format=='XLS'){
		   require_once('../eventos/eventos.class.php');
		   require_once("../libs/adodb/toexport.inc.php");
		   require_once("../libs/adodb/tohtml.inc.php");
		   
		   $event = new Evento($this->db);
		   $rs    = $event->getInvitados($data['evento'],array('limit'=>1000000),'rs');
		   $rs->MoveFirst();
		   //$str   = rs2csv($rs,true);
		   $str = rs2html($rs,$ztabhtml=true,$zheaderarray=false,$htmlspecialchars=true,$echo = false);
		   
		   
           header("Content-Encoding :iso-8859-1");
		   header('Content-type: application/vnd.ms-excel');
           header("Content-Disposition: attachment; filename=archivo.xls");
           header("Pragma: no-cache");
           header("Expires: 0");		   
		   echo $str;
		    
		   
		}				
	}
	
	public function reportSeguimiento($format, $data){
	    if($format=='PDF'){
		   require_once('../eventos/eventos.class.php');
		   require_once('seguimiento.pdf.php');
		   
		   $idEvento = $data['evento'];
	  	   $sql = "SELECT * FROM eventos WHERE even_evento = '".$idEvento."'";
		   $row = $this->db->Execute($sql)->FetchRow();
		
		   $pdf = new MyPDF("L","mm","Letter");
		   $config = array(
		       'header_font' => array('font'=>'Times', 'style'=>'B', 'size'=>8) ,
			   'header_data' => array(
			       'logo'   => "../imagenes/iqmlogo.jpg" ,
				   'title'  => 'INSTITUTO QUINTANARROENSE DE LA MUJER',
			       'stitle' => 'NOTIFICADOS Y CONFIRMADOS. "'.$row['even_descrip'].'",  FECHA :'.strtoupper(date('d/M/Y',strtotime($row['even_fini'])))
			   ),			   
		   );
		   
		   $pdf->setConfig($data, $this->db,$config);
		   $pdf->Open();
		   $pdf->AddPage();
		   $pdf->drawPDF();
		   $pdf->Output($this->filename, 'D');
		   
		}elseif($format=='xls'){
		
		}
	}
	
	public function reportInvitadosByPDF($data){	    
		require_once('../eventos/eventos.class.php');
		$event = new Evento($this->db);
		
		$idEvento = $data['evento'];
		$sql = "SELECT * FROM eventos WHERE even_evento = '".$idEvento."'";
		$row = $this->db->Execute($sql)->FetchRow();
		
		$this->pdf->title = "INSTITUTO QUINTANARROENSE DE LA MUJER";
		$this->pdf->subtitle = 'INVITADOS PARA EL EVENTO "'.$row['even_descrip'].'",  FECHA :'.strtoupper(date('d/M/Y',strtotime($row['even_fini']))) ;
		
		$this->pdf->AddPage();
		
		$rgrupos = $event->getGroupFromEvent($idEvento,array('grupo'=>$data['grupo'], 'limit'=>1000000),'array');
		//empezamos con los grupos
		if(is_array($rgrupos)){
		   foreach($rgrupos as $key => $rgrupo){
		       if($rgrupo['descrip']=='TODOS') continue;
			   
			   $this->pdf->Ln(2);
			   $idGrupo = $rgrupo['clave'];
			   $this->pdf->SetLineWidth(.2);
			   $this->pdf->SetFillColor(220,230,242); //213,217,214 
			   $this->pdf->SetFont('Times','B',8);
			   $this->pdf->Cell(0,4, $rgrupo['descrip'] , $b='B', $ln=1, $a= 'L', $f = true, $link = '');
			   
			   //dependencias del grupo
			   $rdependencias = $event->getDepenFromEvent($idEvento,array('grupo'=>$idGrupo,'limit'=>1000000),'array');
			   if(is_array($rdependencias)){
				  foreach($rdependencias as $kdep => $rdependencia){
				       if($rdependencia['descrip']=='TODOS') continue;
					   
					   $idDependencia = $rdependencia['clave'];
					   $this->pdf->Ln(2);
					   $this->pdf->SetLineWidth(.1);
			           $this->pdf->SetFont('Times','',8);
					   $this->pdf->Cell(5,3,'');
			           $this->pdf->Cell(0,3, $rdependencia['descrip']. "  (".$rdependencia['num'].")" , $b='B', $ln=1, $a= 'L', $f = false, $link = '');
					   
					   //buscamos los invitados
					   $rinvitados = $event->getInvitados($idEvento,array('grupo'=> $idGrupo , 'dependencia'=> $idDependencia, 'limit'=>100000),'array');
					   if(is_array($rinvitados)){
						  $index = 0;
						  $this->pdf->SetWidths(array(4,5,55,155,14,16),array('L','R','L','L','L','L'),2,0);
						  $this->pdf->SetFont('Times','',6);
						   
						  foreach($rinvitados as $kinvi => $rinvitado){
							  $this->pdf->Ln(1);
							  if($rinvitado['pers_dext']){ $ext = 'Ext. '.$rinvitado['pers_dext']; }			                 
					          $this->pdf->Row(array('',++$index,$rinvitado['invi_npersona'],$rinvitado['invi_cargo'],$rinvitado['pers_dtel'],$ext),array(0,0,0,0,0,0));
							  
						  }
						  $this->pdf->Ln(2);
					   }
					   
				  }
			   }
		   }	
		}		
		
		$this->pdf->Output($this->filename, 'D');	
	}
	
	
	/**
	 * REPORTE DE QUIENES ASISTEN AL EVENTO
	 */
	public function reportRutas($format, $data){
	    if($format=='PDF'){
		   require_once('../eventos/eventos.class.php');
		   require_once('rutas.pdf.php');
		   
		   $idEvento = $data['evento'];
	  	   $sql   = "SELECT * FROM eventos WHERE even_evento = '".$idEvento."'";
		   $row   = $this->db->Execute($sql)->FetchRow();
		   		   
		   $pdf = new MyPDF("L","mm","Letter");
		   $config = array(
		       'header_font' => array('font'=>'Times', 'style'=>'B', 'size'=>8) ,
			   'header_data' => array(
			       'logo'   => "../imagenes/iqmlogo.jpg" ,
				   'title'  => 'INSTITUTO QUINTANARROENSE DE LA MUJER',
			       'stitle' => "REPORTE DE RUTAS E INVITADOS DEL EVENTO \n".$row['even_descrip'].'",  FECHA :'.strtoupper(date('d/M/Y',strtotime($row['even_fini'])))
			   ),			   
		   );
		   
		   $pdf->setConfig($data, $this->db,$config);
		   $pdf->Open();
		   $pdf->drawPDF();
		   $pdf->Output($this->filename, 'D');
		   
		}elseif($format=='xls'){
		
		}		
	}
	
	/**
	 * REPORTE DE QUIENES ASISTEN AL EVENTO
	 */
	public function reportQuienes($format, $data){
	    if($format=='PDF'){
		   require_once('../eventos/eventos.class.php');
		   require_once('event-who.pdf.php');
		   
		   $idEvento = $data['evento'];
	  	   $sql   = "SELECT * FROM eventos WHERE even_evento = '".$idEvento."'";
		   $row   = $this->db->Execute($sql)->FetchRow();
		   
		   if($data['treport']=='IE'){ //personas confirmadas
			   $title = "PERSONAS QUE RECIBIERON LA INVITACION";
		   }elseif($data['treport']=='PC'){ //personas confirmadas
			   $title = "PERSONAS CONFIRMADAS PARA EL EVENTO";
		   }elseif($data['treport']=='QA'){ // quien asiste
			   $who = $data['quien'];
			   
			   if($who=='T'){
				  $title = "TITULARES QUE ASISTEN AL EVENTO";
			   }elseif($who == 'S'){
			      $title = "PERSONAS QUE ENVIARAN UN SUPLENTE"; 
			   }elseif($who=='N'){
			      $title = "PERSONAS QUE NO ASISTEN";
			   }
		   }
		   
		   $pdf = new MyPDF("P","mm","Letter");
		   $config = array(
		       'header_font' => array('font'=>'Times', 'style'=>'B', 'size'=>8) ,
			   'header_data' => array(
			       'logo'   => "../imagenes/iqmlogo.jpg" ,
				   'title'  => 'INSTITUTO QUINTANARROENSE DE LA MUJER',
			       'stitle' => "$title \n".$row['even_descrip'].'",  FECHA :'.strtoupper(date('d/M/Y',strtotime($row['even_fini'])))
			   ),			   
		   );
		   
		   $pdf->setConfig($data, $this->db,$config);
		   $pdf->Open();
		   $pdf->AddPage();
		   $pdf->drawPDF();
		   $pdf->Output($this->filename, 'D');
		   
		}elseif($format=='xls'){
		
		}		
	}
	
	/**
	 * REPORTE DE LOS TIPOS DE LIDERAZGO QUE HAY EN EL EVENTO
	 */
	public function reportLiderazgo($format, $data){
	    if($format=='PDF'){
		   require_once('../eventos/eventos.class.php');
		   require_once('event-liderasgo.pdf.php');
		   
		   $idEvento = $data['evento'];
	  	   $sql   = "SELECT * FROM eventos WHERE even_evento = '".$idEvento."'";
		   $row   = $this->db->Execute($sql)->FetchRow();
		   $nivel = $data['liderazgo'];
		   
		   $pdf = new MyPDF("P","mm","Letter");
		   $config = array(
		       'header_font' => array('font'=>'Times', 'style'=>'B', 'size'=>8) ,
			   'header_data' => array(
			       'logo'   => "../imagenes/iqmlogo.jpg" ,
				   'title'  => 'INSTITUTO QUINTANARROENSE DE LA MUJER',
			       'stitle' => "PERSONAS CON LIDERAZGO NIVEL $nivel. \n".$row['even_descrip'].'",  FECHA :'.strtoupper(date('d/M/Y',strtotime($row['even_fini'])))
			   ),			   
		   );
		   
		   $pdf->setConfig($data, $this->db,$config);
		   $pdf->Open();
		   $pdf->AddPage();
		   $pdf->drawPDF();
		   $pdf->Output($this->filename, 'D');
		   
		}elseif($format=='xls'){
		
		}		
	}
	
	
	
	
	
	/**
	 * REPORTE DE GRUPOS, GRUPOS QUE ESTAN INVITADOS AL EVENTO
	 */
	public function reportEventGroup($format, $data){
	    if($format=='PDF'){
		   require_once('../eventos/eventos.class.php');
		   require_once('event-group.pdf.php');
		   
		   $idEvento = $data['evento'];
	  	   $sql = "SELECT * FROM eventos WHERE even_evento = '".$idEvento."'";
		   $row = $this->db->Execute($sql)->FetchRow();
		
		   $pdf = new MyPDF("L","mm","Letter");
		   $config = array(
		       'header_font' => array('font'=>'Times', 'style'=>'B', 'size'=>8) ,
			   'header_data' => array(
			       'logo'   => "../imagenes/iqmlogo.jpg" ,
				   'title'  => 'INSTITUTO QUINTANARROENSE DE LA MUJER',
			       'stitle' => 'GRUPOS INVITADOS DEL EVENTO. "'.$row['even_descrip'].'",  FECHA :'.strtoupper(date('d/M/Y',strtotime($row['even_fini'])))
			   ),			   
		   );
		   
		   $pdf->setConfig($data, $this->db,$config);
		   $pdf->Open();
		   $pdf->AddPage();
		   $pdf->drawPDF();
		   $pdf->Output($this->filename, 'D');
		   
		}elseif($format=='xls'){
		
		}
	}
	
	function Debug($msg){
	      $text = date('d-m-Y H:i:s : '). $msg."\n";
		  $fp = fopen('log.txt','a+');		  
		  fwrite($fp,$text,strlen($text)); 
		  
	}
	
	function array_get_keys($rs, $colname, $return){
		$keys = array();
		$row  = array();
		
		if(!is_array($rs)) return false;
		
		foreach($rs as $index => $record ){
		        $k = $record[$colname];
				$v = $record[$return];
				
				if(!array_key_exists($k,$keys)){
				    $keys[$k] = $v;
				}			
		}
		
		return $keys;
		
    }
	
	
}



/*----------------------------------------------------------------------------------------------------------*
* Class extention for Header and Footer Definitions
*----------------------------------------------------------------------------------------------------------*/
class CMyPDF extends fpdf_table{
      
	  public  $db;
	  public  $ref;
	  public  $cellw=0; //cell width
	  public  $tbl      = array(); 
	  public  $tmpHeader = array();
	  public  $tmpData   = array();
	  
	  public $config = array();
	  
	  
	  	
     /*----------------------------------------------------------------------------------------------------------*
      * Header
      *----------------------------------------------------------------------------------------------------------*/
	  public function Header(){
	         
			
			 $this->SetDrawColor(0,0,0);
			 $this->SetStyle("head1", "Times", "B", 14, "0,0,0");    //$tag, $family, $style, $size, $color
			 $this->SetStyle("head2", "Times", "B", 10, "0,0,0");  //$tag, $family, $style, $size, $color
			 $this->SetStyle("head3", "Times", "B", 8,  "0,0,0");  //$tag, $family, $style, $size, $color

			 $this->Image($this->config['logo'],15,10,42,9);
			 $this->setXY(60,10);
			 $this->SetFont($this->config['font_title']['font'], $this->config['font_title']['style'],$this->config['font_title']['size']);
			 $this->Cell(0,4, $this->title , $b=0, $ln=1, $a= 'L', $f = false, $link = '');
			 $this->setXY(60,16);
			 $this->SetFont('Times','',10);
			 $this->MultiCell(0, 4, $this->subtitle, $border = 0, $align = 'J', $fill = false);
			 $this->SetLineWidth(.4);
			 $this->Cell(0,0, '' , $b='B', $ln=0, $a= 'L', $f = false, $link = '');
			 $this->Ln(4);
			 
	  }
     
	 
	 /*----------------------------------------------------------------------------------------------------------*
      * Footer
      *----------------------------------------------------------------------------------------------------------*/
	  public function Footer(){
			 
			 
			 
			 $this->SetTextColor(0);
	         $this->SetY(-12);
			 $w = $this->w - $this->rMargin;
			 $this->SetLineWidth(.4);
			 $this->SetDrawColor(0,0,0);
			 $this->Line($this->x, $this->y, $w, $this->y);
			 $this->Ln(1);
			 	 
			 $this->SetFont('Times','I',7);
			 $this->SetTextColor(170, 170, 170);
	         $this->Cell(90,4,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');//Numeracion de pagina
			 //$this->SetX($this->lMargin);       
	         $this->Cell(0,4,'Chetumal, Q. Roo a '. strftime ("%A, %d de %B de %Y, ".date("h:i A"), time()) ,0,0,'R'); //'Chetumal, Q. Roo a '.date('d-m-Y',strtotime())
			 
			 //$this->Cell(0,5,'Fecha de impresion: '.date('d-m-Y  h:i A'),0,0,'R');
		 
	  }	
	  
	  public function tbRender(){
	         $this->tbDrawHeader();
			 $this->tbDrawData();
			 //output the table data to the pdf
	         $this->tbOuputData();
			 //draw the Table Border
			 $this->tbDrawBorder();
	  }
	  
	  public function renderHeader($ml){
	         $this->tbSetHeaderType($this->tmpHeader,$ml);
			 $this->tbDrawHeader();
	  }
	  
	  public function addHeader($rows){	         
			 $hd = array();
			 $size = (int) $rows;			 
			 			 
			 for($r=0; $r<$size; $r++){
			     for($c=0; $c< $this->iColumnsNr; $c++){
				     $hd[$r][$c] = $this->setHeaderType(); 					    
				 }			     
			 }			 
			 $this->tmpHeader = $hd;			 
			 return $hd;	  
	  }
	  
	  public function addData(){
	         $data = $this->tmpData;
			 
			 for ($c=0; $c < $this->iColumnsNr; $c++){
			      //cargamos valores por default;
				  $data[$c] =  $this->setDataType();				 
			 }
			 
			 $this->tmpData = $data;
			 return $data;	  
	  }
	  
	  public function setHeadProperty($rowNumber, $cols, $values, $property){
	         $row = $this->tmpHeader[$rowNumber];
			 $apl = 0;			 		 
			 
			 //recorremos las columnas
			 for ($c=0; $c < $this->iColumnsNr; $c++){
			      if(sizeof($cols)==0){
				    $row[$c][$property] = $values[0];
				  }elseif(in_array($c,$cols)){
				     $row[$c][$property] = $values[$apl];
					 $apl++;
				  }		 
			 }			 		 
			 $this->tmpHeader[$rowNumber] = $row;  
	  }
	  
	  public function setDataProperty($cols, $values, $property){
	         $data = $this->tmpData;
			 $apl = 0;
			 
			 //recorremos las columnas
			 for ($c=0; $c < $this->iColumnsNr; $c++){
			      //cargamos valores por default;
				  if(sizeof($cols)==0){
				     $data[$c][$property] = $values[0];
				  }elseif(in_array($c,$cols)){
				     $data[$c][$property] = $values[$apl];
					 $apl++;
				  }
			 }
			 $this->tmpData = $data;
	  }
	  
	  
	  public function setTableType($property){
			 //por default			 
			 $tb_def_type   =   array(
				'TB_ALIGN'  => 'L',					//table align on page
				'L_MARGIN'  => 0,					//space to the left margin
				'BRD_COLOR' => array(0,0,0),		//border color
				'BRD_SIZE'  => '0.1',				//border size
			 );
			 
			 foreach($property as $p => $value){
			         $tb_def_type[$p]  = $value;
			 }
			 
			 $this->tbSetTableType($tb_def_type);	  
	  }
	  
	  public function setHeaderType($property=array()){	         
			 if (sizeof($property) == 0 ) {
				 $tbl_def_header_type = array(
					'WIDTH'     => 20,				    //cell width
					'T_COLOR'   => array(0,0,0),	//text color
					'T_SIZE'    => 8,					//font size
					'T_FONT'    => 'Arial',				//font family
					'T_ALIGN'   => 'C',					//horizontal alignment, possible values: LRC (left, right, center)
					'V_ALIGN'   => 'M',					//vertical alignment, possible values: TMB(top, middle, bottom)
					'T_TYPE'    => 'B',					//font type
					'LN_SIZE'   => 4,					//line size for one row
					'BG_COLOR'  => array(255, 255, 255),	    //background color
					'BRD_COLOR' => array(0,0,0),		//border color
					'BRD_SIZE'  => 0.1,					//border size
					'BRD_TYPE'  => '1',					//border type, can be: 0, 1 or a combination of: "LRTB"
					'TEXT'      => '',				    //text
				 );
			 }else {			 
				 foreach($property as $p => $value){
						 $tbl_def_header_type[$p]  = $value;
				 }
			 }
			 
			 return $tbl_def_header_type;
	  }
	  
	  public function setDataType($property=array()){
	         
			 $table_default_data_type = array(
					'T_COLOR'   => array(0,0,0),		//text color
					'T_SIZE'    => 7,					//font size
					'T_FONT'    => 'Arial',				//font family
					'T_ALIGN'   => 'C',					//horizontal alignment, possible values: LRC (left, right, center)
					'V_ALIGN'   => 'M',					//vertical alignment, possible values: TMB(top, middle, bottom)
					'T_TYPE'    => '',					//font type
					'LN_SIZE'   => 4,					//line size for one row
					'BG_COLOR'  => array(255,255,255),	//background color
					'BRD_COLOR' => array(0,0,0),		//border color
					'BRD_SIZE'  => 0.1,					//border size
					'BRD_TYPE'  => '1',					//border type, can be: 0, 1 or a combination of: "LRTB"
			 );
			 			 
			 foreach($property as $p => $value){
						 $table_default_data_type[$p]  = $value;
			 }			
			 
			 return $table_default_data_type;
	  }
	  
	  public function getData(){
	         return $this->tmpData;
	  } 
}
    
   		 
	
	
	
?>
