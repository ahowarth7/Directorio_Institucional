<?php


require_once("../libs/fpdf/class.fpdf_table.php");
define('FPDF_FONTPATH','../libs/fpdf/font/');
 
/*----------------------------------------------------------------------------------------------------------*
 * Class extention for Header and Footer Definitions
 *----------------------------------------------------------------------------------------------------------*/
class MyPDF extends fpdf_table{
      
	private  $db;
	public  $ref;
	public  $cellw=0; //cell width
	public  $tbl      = array(); 
	public  $tmpHeader = array();
	public  $tmpData   = array();
	
	private $config = array();
	private $header_font;
	private $header_data;
	
	
	
	function setConfig($data, $db, $config) {		
		
		$this->db     = $db;
		$this->config = $config;
		$this->post   = $data;
		
		
		$this->setHeaderFont($config['header_font']);
		$this->setHeaderData($config['header_data']);		
		
		$this->SetAuthor('Instituto Quintanarroense de la Mujer');
	    $this->SetAutoPageBreak(true, 15);
	    $this->SetMargins(15, 10, 15);
	    $this->AliasNbPages(); 
		
	    $this->SetLineWidth(.1);
	    $this->SetFillColor(213,217,214);
  	    $this->SetTextColor(0);
	    $this->SetDrawColor(128,128,128);
		
	}
	 
	  	
   /*----------------------------------------------------------------------------------------------------------*
	* Header
	*----------------------------------------------------------------------------------------------------------*/
	public function Header(){		 
		 
		 $font = $this->getHeaderFont();
		 $data = $this->getHeaderData();
		 
		 $this->SetDrawColor(0,0,0);
			
		 $this->Image($data['logo'],15,10,42,9);
		 $this->setXY(60,10);
		 $this->SetFont($font['font'], $font['style'],$font['size']+2);
		 $this->Cell(0,4, $data['title'] , $b=0, $ln=1, $a= 'L', $f = false, $link = '');
		 $this->setXY(60,14);
		 $this->SetFont($font['font'], '', $font['size']);
		 $this->MultiCell(0, 4, $data['stitle'], $border = 0, $align = 'J', $fill = false);
		 
		 $this->SetFont($font['font'], '', 7);
		 $this->SetWidths(array(3,6,155,16,16,15,18,20),array('L','L','L','C','C','C','C'),4,0);
		 $this->Ln(1);
		 $this->SetLineWidth(.4);
		 $this->Cell(0,0, '' , $b='B', $ln=1, $a= 'L', $f = false, $link = '');	     					  
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
		$this->Cell(0,4,'Chetumal, Q. Roo a '. strftime ("%A, %d de %B de %Y, ".date("h:i A"), time()) ,0,0,'R'); //'Chetumal, Q. Roo a '.date('d-m-Y',strtotime())		
	 
	}
	
	public function drawPDF (){
	    
		$event = new Evento($this->db);
		$post  = $this->post;
		
		//encontramos todas las rutas del evento
		$rutas = $event->getRutas($post['evento'],array('group'=>'depe_ruta, depe_dependencia', 'limit'=>1000000),'array');
		
		
		if(is_array($rutas)){
		   foreach($rutas as $key => $ruta){
		       
			   $id_depen = $ruta['depe_dependencia'];
			   
			   //pagina donde van los datos de la ruta
		       $this->AddPage();			   
			   $this->SetLineWidth(.2);
			   $this->SetFillColor(220,230,242); //213,217,214 
			   $this->SetFont('Times','B',10);
			   
			   //encabezaado, w = 250
			   $this->Cell(170,8, '  RUTA NO. '.$ruta['depe_ruta'] , $b=1, $ln=0, $a= 'L', $f = true, $lk = '');
			   $this->Cell(40 ,8, ' SELLO ', $b=1, $ln=0, $a= 'C', $f = true, $lk = '');
			   $this->Cell(40 ,8, ' FIRMA ', $b=1, $ln=1, $a= 'C', $f = true, $lk = '');
			   
			   //ruta
			   $this->SetFont('Times','B',8);
			   $this->Cell(170,5, ' ', $b='LR', $ln=0, $a= 'L', $f=false, $lk = '');
			   $this->Cell(40,5, '', $b='R', $ln=0, $a= 'C', $f = false, $lk = '');
			   $this->Cell(40,5, '', $b='R', $ln=1, $a= 'C', $f = false, $lk = '');
			   
			   //dependencia
			   $this->SetFont('Times','',8);
			   $this->SetWidths(array(170,40,40),array('L','L','L'),4, array('LR','R','R'));
			   $this->Row(array($ruta['depe_nombre'],'',''),array(0,0,0));
			   
			   //direccion
			   $this->SetWidths(array(170,40,40),array('L','L','L'),4, array('LR','R','R'));
			   $this->Row(array($ruta['depe_ndireccion'],'',''),array(0,0,0));
			   
			   //num de invitados
			   $rinvitados = $event->getInvitados($post['evento'],array('dependencia'=> $id_depen, 'limit'=>1000000),'array');
			  
			   $this->SetFont('Times','B',8);
			   $this->SetWidths(array(170,40,40),array('L','L','L'),4, array('LRB','BR','BR'));
			   $this->Row(array(" INVITADOS ( ".count($rinvitados)." ) ",'',''),array(0,0,0));
			   $this->SetFont('Times','',7);
			   
			   //invitados
			   if(is_array($rinvitados)){
				  $this->Ln(5);
				  
				  $this->SetWidths(array(10,60,114,8,8,50),array('C','L','L','C','C','C'),4, 1);
			      $this->Row(array('','NOMBRE','CARGO','SI','NO','MOTIVO'),array(1,1,1,1,1,1));
			       
				  $cnt=1;
				  foreach($rinvitados as $index => $rinvitado){
					      $this->SetWidths(array(10,60,114,8,8,50),array('C','L','L','C','C','C'),4, 1);
						  $this->Row(array($cnt++, $rinvitado['invi_npersona'], $rinvitado['invi_cargo'],'','',''),array(0,0,0,0,0,0));
				  }
			   
			   }
			   
			   
			   

			   
			   
							  
							 
			   
			   
			   
			   //$this->Cell(180,4, 'RUTA No. '.$ruta['depe_ruta'] , $b='B', $ln=1, $a= 'L', $f = true, $link = '');
			   
			   
			   /*//dependencias del grupo
			   $rdependencias = $event->getLiderazgoFromEvent($post['evento'],array('grupo'=>$idGrupo, 'liderazgo'=>$post['liderazgo'], 'limit'=>1000000, 'group'=>'invi_dependencia'),'array');
			   if(is_array($rdependencias)){
				  foreach($rdependencias as $kdep => $rdependencia){
				       if($rdependencia['descrip']=='TODOS') continue;
					   
					   $idDependencia = $rdependencia['invi_dependencia'];
					   $this->Ln(2);
					   
			            
					   //buscamos los invitados
					   $rinvitados = $event->getLiderazgoFromEvent($post['evento'],array('grupo'=> $idGrupo , 'dependencia'=> $idDependencia, 'liderazgo'=>$post['liderazgo'], 'limit'=>100000),'array');
					   if(is_array($rinvitados)){
						  $index = 0;
						  
						  $this->SetFont('Times','B',9);
					      $this->Cell(5,3,'');
			              $this->Cell(0,3, $rdependencia['invi_ndependencia']. "  (".count($rinvitados).")" , $b='B', $ln=1, $a= 'L', $f = false, $link = '');
					  
						   
						  foreach($rinvitados as $kinvi => $rinvitado){
							  $this->Ln(2);							 
							   
							  if($rinvitado['pers_dext']){ $ext = 'Ext. '.$rinvitado['pers_dext']; }		
							  $this->SetWidths(array(3,6,155,16,16,15,18,20),array('L','R','L','L','L','C','C'),3,0);			                 
					          $this->SetFont('Times','B',8);
							  $this->Row(array('',++$index,$rinvitado['invi_npersona']),array(0,0,0,0,0,0));
							  $this->SetWidths(array(3,6,240),array('L','L','L','L','L','L'),4,0);
							  $this->SetFont('Times','',8);
							  $this->Row(array('','',$rinvitado['invi_cargo']),array(0,0,0,0,0,0));
						  }
						  $this->Ln(3);
					   }
					   
				  }
			   }*/
		   }	
		}	
	
	}
	
	
	public function setHeaderFont($header_font){
	    $this->header_font = $header_font;
	}
	
	public function setHeaderData($header_data){
	    $this->header_data = $header_data;
	}
	
	public function getHeaderFont(){
	    return $this->header_font;
	}
	
	public function getHeaderData(){
	    return $this->header_data;
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
