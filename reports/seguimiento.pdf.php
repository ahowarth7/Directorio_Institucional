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
			
		 $this->Image($data['logo'],15,10,40);
		 $this->setXY(60,10);
		 $this->SetFont($font['font'], $font['style'],$font['size']+2);
		 $this->Cell(0,4, $data['title'] , $b=0, $ln=1, $a= 'L', $f = false, $link = '');
		 $this->setXY(60,14);
		 $this->SetFont($font['font'], '', $font['size']);
		 $this->MultiCell(0, 4, $data['stitle'], $border = 0, $align = 'J', $fill = false);
		 
		 $this->SetFont($font['font'], '', 7);
		 $this->SetWidths(array(3,6,155,16,16,15,18,20),array('L','L','L','C','C','C','C'),4,0);
		 //$this->SetWidths(array(3,6,93,16,16,15,18,20),array('L','L','L','C','C','C','C'),4,0);			                 
		 $this->Row(array('','','NOMBRE','TEL.','EXT.','RECIBIO','CONFIRMO','QUIEN ASISTE'),array(1,1,1,1,1,1,1,1));
		 $this->Ln(1);
		 $this->SetLineWidth(.4);
		 $this->Cell(0,0, '' , $b='B', $ln=1, $a= 'L', $f = false, $link = '');	     					  
		 $this->Ln(1);
		 
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
		
		$rgrupos = $event->getGroupFromEvent($post['evento'],array('grupo'=>$post['grupo'], 'limit'=>1000000),'array');
		//empezamos con los grupos
		if(is_array($rgrupos)){
		   foreach($rgrupos as $key => $rgrupo){
		       if($rgrupo['descrip']=='TODOS') continue;
			   
			   $this->Ln(2);
			   $idGrupo = $rgrupo['clave'];
			   $this->SetLineWidth(.2);
			   $this->SetFillColor(220,230,242); //213,217,214 
			   $this->SetFont('Times','B',8);
			   $this->Cell(0,4, $rgrupo['descrip'] , $b='B', $ln=1, $a= 'L', $f = true, $link = '');
			   
			   //dependencias del grupo
			   $rdependencias = $event->getDepenFromEvent($post['evento'],array('grupo'=>$idGrupo,'limit'=>1000000),'array');
			   if(is_array($rdependencias)){
				  foreach($rdependencias as $kdep => $rdependencia){
				       if($rdependencia['descrip']=='TODOS') continue;
					   
					   $idDependencia = $rdependencia['clave'];
					   $this->Ln(2);
					   $this->SetLineWidth(.1);
			           $this->SetFont('Times','',8);
					   $this->Cell(5,3,'');
			           $this->Cell(0,3, $rdependencia['descrip']. "  (".$rdependencia['num'].")" , $b='B', $ln=1, $a= 'L', $f = false, $link = '');
					   
					   //buscamos los invitados
					   $rinvitados = $event->getSeguimiento($post['evento'],array('grupo'=> $idGrupo , 'dependencia'=> $idDependencia, 'limit'=>100000),'array');
					   if(is_array($rinvitados)){
						  $index = 0;
						  
						  $this->SetFont('Times','',7);
						   
						  foreach($rinvitados as $kinvi => $rinvitado){
							  $this->Ln(1);
							 
							   
							  if($rinvitado['pers_dext']){ $ext = 'Ext. '.$rinvitado['pers_dext']; }		
							  $this->SetWidths(array(3,6,155,16,16,15,18,20),array('L','R','L','L','L','C','C'),3,0);			                 
					          
							  $iconr = $this->iconNotificado($rinvitado['noti_notificado']);	
							  $iconc = $this->iconRecibio($rinvitado['conf_confirmo']);
							  $this->Row(array('',++$index,$rinvitado['even_npersona'],$rinvitado['pers_dtel'],$ext,$iconr,$iconc,$rinvitado['conf_nquien']),array(0,0,0,0,0,0));
							  $this->SetWidths(array(3,6,240),array('L','L','L','L','L','L'),3,0);
							  $this->Row(array('','',$rinvitado['even_cargo']),array(0,0,0,0,0,0));
						  }
						  $this->Ln(2);
					   }
					   
				  }
			   }
		   }	
		}	
	
	}
	
	public function iconNotificado($notificado){
	    $icon = array();
		
		if($notificado=='S'){
		   $icon['tag']    = 'img';
		   $icon['src']    =  '../imagenes/icons/noti_recibio.jpg';
		   $icon['width']  = 4;
		   $icon['height'] = 3.5;
		   		   
		   return $icon;
		}
		
		$icon['tag']    = 'img';
		$icon['src']    = '../imagenes/icons/noti_recibio_no.jpg';
		$icon['width']  = 3;
		$icon['height'] = 3;
		
		return $icon;
	}
	public function iconRecibio($recibio){
	     $icon = array();
		
		if($recibio=='S'){
		   $icon['tag']    = 'img';
		   $icon['src']    =  '../imagenes/icons/conf_confirmo_si.jpg';
		   $icon['width']  = 4;
		   $icon['height'] = 3.5;
		   		   
		   return $icon;
		}
		
		$icon['tag']    = 'img';
		$icon['src']    =   '../imagenes/icons/conf_confirmo_no.jpg';
		$icon['width']  = 4;
		$icon['height'] = 3.5;
		
		return $icon;
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
