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
	
	
	
	function setConfig($request, $db, $config) {		
		
		$this->db      = $db;
		$this->config  = $config;
		$this->request = $request;
		
		setlocale(LC_TIME, "spanish-mexican");
		
		$this->setHeaderFont($config['header_font']);
		$this->setHeaderData($config['header_data']);		
		
		$this->SetAuthor('Instituto Quintanarroense de la Mujer');
	    $this->SetAutoPageBreak(true, 15);
	    $this->SetMargins($l=10, $t=10, $r=10);
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
	    
		$contact = new Contacto($this->db);
		$request  = $this->request;		 
			 
		//encontramos los grupos que tienen valores
		$filters = array(		   
		   'limit'            => 1000000 ,
		   'orderby'          => 'pers_nombre, pers_apat, pers_amat'
		);
					 
		$result = $contact->getByFilters($filters,'array');
		$this->SetFont('Times','',9);
		
		$cnt = 1;
		foreach($result as $key => $rperson){
			    $rperson = ($rperson);
				
				if($rperson['pers_dtel']) {
				   $rperson['pers_dtel'] =  '('.substr($rperson['pers_dtel'],0,3).') '.substr($rperson['pers_dtel'],3,3).'-'.substr($rperson['pers_dtel'],6,4);
				   $rperson['pers_dtel']="Tel. ".$rperson['pers_dtel'];
				}
						  
				if($rperson['pers_dext']) $rperson['pers_dext']="Ext. ".$rperson['pers_dext'];
				$this->SetFont('Times','',6);
						  
				$h   = 4;
				$lmargen =  7;
				$this->Cell(7, $h, $cnt++, $b=0, $ln=0, $a= 'R', $f = false, $link = '');
								
				$this->SetFont('Times','B',8.5);
				$this->Cell(100,$h, $rperson['pers_nnombre'], $b=0, $ln=1,$a= 'L', $f = false, $link = '');				
							 
				//cargo
				$this->SetFont('Times','',8);
				$this->Cell($lmargen, $h,'');
				$this->MultiCell(0,$h, $rperson['pers_cargo'], $b=0, $a= 'L', $f = false);
								
			    //numeros telefonicos y correo
				$this->Cell($lmargen, $h,'');
				$this->Cell(30,$h, $rperson['pers_dtel'],   $b=0, $ln=0, $a= 'L', $f = false, $link = '');
				$this->Cell(20,$h, $rperson['pers_dext'],   $b=0, $ln=0, $a= 'L', $f = false, $link = '');
								
				if($request['incluye_celular']){
				   if ($rperson['pers_celular']){
				       $rperson['pers_celular'] =  '('.substr($rperson['pers_celular'],0,3).') '.substr($rperson['pers_celular'],3,3).'-'.substr($rperson['pers_celular'],6,4);
					   $this->Cell(30 ,$h, 'Cel. '.$rperson['pers_celular'], $b=0, $ln=0, $a= 'L', $f = false, $link = '');	
					}
					$this->Cell(100,$h, $rperson['pers_demail'], $b=0, $ln=1, $a= 'L', $f = false, $link = '');		
				}else {
				    $this->Cell(100,$h, $rperson['pers_demail'], $b=0, $ln=1, $a= 'L', $f = false, $link = '');		
				}
				
				$this->Ln(3);
				   
		}	
	}
	
	
	
	public function iconNotificado($notificado){
	    $icon = array();
		
		if($notificado=='S'){
		   $icon['tag']    = 'img';
		   $icon['src']    =  '../imagenes/icons/noti_recibio_si.jpg';
		   $icon['width']  = 3;
		   $icon['height'] = 3;
		   		   
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
