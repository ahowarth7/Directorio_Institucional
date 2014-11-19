<?PHP

    define('PATH_BASE','../');
	
	//includes
    header("Content-Type: text/html; charset=iso-8859-1");
	header("Content-Encoding :iso-8859-1");
	
	//para los de session
	//include('../include/funciones_v2.php');
    //f_verifica_sesion();
	
	$path = '../'; //dirname(__FILE__);
	require_once("../libs/adodb/adodb-exceptions.inc.php");
	require_once("../libs/adodb/adodb.inc.php");
	require_once("../includes/utf8.php");
	require_once("../includes/config.php");
	require_once("../includes/conexion.php");
	require_once("../libs/lib/lib.php");
	
	ini_set('display_errors',1); 
	ini_set('error_reporting',6135); 
	setlocale(LC_TIME, "spanish-mexican");
	setlocale(LC_TIME, "es_MX");
		  
    //conexion
    $db = Conectar();
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Borra el registro
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='contacto.getByFilters' ){
	   try {	        				
			 require_once('../contactos/contactos.class.php');
			 $contact = new Contacto($db);
			 
			 $request = $_POST;
			 $request['dmujer']     = $request['pers_invi_dm'];
			 $request['vfemenino']  = $request['pers_invi_avf'];
			 $request['violencia']  = $request['pers_invi_dievcm'];
			 $request['imaestra']   = $request['pers_invi_maestra'];
			 
			
			 $jerarquias = array();
			 if($request['jera_titulares'])    array_push($jerarquias,$request['jera_titulares']);
			 if($request['jera_subtitulares']) array_push($jerarquias,$request['jera_subtitulares']);
			 if($request['jera_directivo'])    array_push($jerarquias,$request['jera_directivo']);
			 if($request['jera_coordinacion']) array_push($jerarquias,$request['jera_coordinacion']);
			 if($request['jera_jefatura'])     array_push($jerarquias,$request['jera_jefatura']);
			 
			 $str_jerarquias = '';
			 if(count($jerarquias) > 0) $str_jerarquias = implode(',',$jerarquias);
			 			 
			 $filters = array(
			     'filt_categoria'  => $request['categoria'],
				 'filt_grupo'      => $request['grupo'],
				 'filt_dependencia'=> $request['dependencia'],
				 'filt_jerarquia'  => $request['jerarquia'],
				 'filt_jerarquias' => $str_jerarquias ,	
				 'filt_cargo'      => $request['cargo'],
				 'filt_municipio'  => $request['municipio'],
				 'filt_ciudad'     => $request['ciudad'],
				 'filt_sexo'       => $request['sexo'],
				 'filt_dm'         => $request['dmujer'],
			     'filt_maestra'    => $request['imaestra'],
				 'filt_avf'        => $request['vfemenino'],
				 'filt_dievcm'     => $request['violencia'],
				 'limit'           => 1000000 ,
				 'group'           => 'pg.pers_grupo , pg.pers_dependencia ',
				 'orderby'         => 'pers_ngrupo, pers_ndependencia'
			 );	 
			 
			 
			 $result = $contact->getByFilters($filters,'array');
			 //echo "<pre>"; print_r($filters); echo "</pre>";
			 //echo $contact->sql;
			 
			 if(!is_array($result)) die('Error de recuperacion de datos en la consulta grupo');
			 $rgrupos = array();
			 foreach($result as $key => $rperson){
		             $rgrupos[] = array('grupo'=> $rperson['pers_grupo'], 'ngrupo'=> $rperson['pers_ngrupo'], 'dependencia'=>$rperson['pers_dependencia']);
			 }	
			 
					 			
			 //empezamos a hacer la consulta
			 $html = '<div style="width:100%">';
			 if(count($rgrupos)==0) echo "No se encontraron registros";
			 
			 foreach($rgrupos as $kdep => $row){
				   $grupo       = $row['grupo'];
				   $dependencia = $row['dependencia'];
				   
				   $html.='<table width="100%" >';
				   $html.='<tr bgcolor="#FDE87F"><td class="table-title">'.$row['ngrupo'].'</td> </tr></table>';
				   $html.='<hr style="margin:0px; padding:0px">';
				   
				   $filters = array(
			          'filt_grupo'       => $grupo, 
					  'filt_dependencia' => $dependencia,
					  'filt_categoria'  => $request['categoria'],
					  'filt_jerarquia'  => $request['jerarquia'],
					  'filt_jerarquias' => $str_jerarquias ,	
					  'filt_cargo'      => $request['cargo'],
					  'filt_municipio'  => $request['municipio'],
					  'filt_ciudad'     => $request['ciudad'],
					  'filt_sexo'       => $request['sexo'],
					  'filt_dm'         => $request['dmujer'],
					  'filt_maestra'    => $request['imaestra'],
					  'filt_avf'        => $request['vfemenino'],
					  'filt_dievcm'     => $request['violencia'],
					  'limit'           => 1000000 
				   );
				   
				   
				   $result = $contact->getByFilters($filters,'array');				   
				   if(is_array($result)){
				      foreach($result as $key => $rperson){
						  $RowNum++;
						  $html.='<div style="padding-left:10px; margin-top:5px;">';
						  $html.= '<table width="100%" border="0" cellpadding="0" cellspacing="1" style=" border-bottom:1px solid; font-family:lucida grande,tahoma,verdana,arial,sans-serif; font-size:10px">';
						  $html.= ' <tr>';
						  $html.= '  <td width="50%">'.$rperson['pers_nnombre'].'</td>';
						  $html.= '  <td width="15%">'.$rperson['pers_dtel'].'</td>';
						  $html.= '  <td width="10%">'.$rperson['pers_dext'].'</td>';
						  $html.= '  <td width="25%">'.$rperson['pers_demail'].'</td>';
						  $html.= ' </tr>';
						  $html.= ' <tr><td colspan="4">'.$rperson['pers_njerarquia'].'</td> </tr>';
						  $html.= ' <tr><td colspan="4">'.$rperson['pers_cargo'].'</td> </tr>';
						  $html.= ' <tr><td colspan="4">'.$rperson['pers_ndependencia'].'</td> </tr>';
						  $html.= '</table>';
						  $html.='</div>';
					  }
					  $html.='<br>';
				   }			   
			 }
			 unset($result);
			 $html.=" Registros encontrados : {$RowNum}";
			 $html.='</div>';			 
			 echo $html;

			
			 //echo json(utf8_encode_array($response),'encode');			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Genera el reporte en PDF
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='getPDF' ){
	   try {	        				
			 
			 
			 require_once("../libs/fpdf/class.fpdf_table.php");
             define('FPDF_FONTPATH','../libs/fpdf/font/');

			 require_once('../contactos/contactos.class.php');			 
			 require_once('agenda.pdf.php');
			 
			 
			 $pdf = new MyPDF("P","mm","Letter");
		     $config = array(
		         'header_font' => array('font'=>'Times', 'style'=>'B', 'size'=>8) ,
			     'header_data' => array(
			        'logo'   => "../imagenes/iqmlogo.jpg" ,
				    'title'  => 'INSTITUTO QUINTANARROENSE DE LA MUJER',
			        'stitle' => 'DIRECTORIO INSTITUCIONAL'
			     ),			   
		     );
		   
		     $pdf->setConfig($_GET, $db, $config);
		     $pdf->Open();
		     $pdf->AddPage();
		     $pdf->drawPDF();
		     $pdf->Output('directorio.pdf', 'D');
			 		 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Genera el reporte en XLS
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='getXLS' ){
	   try {	        				
			 
			 require_once('../contactos/contactos.class.php');
			 require_once("../libs/adodb/toexport.inc.php");
		     require_once("../libs/adodb/tohtml.inc.php");
		   
			 $contact = new Contacto($db);
			 
			 $request = $_POST;
			 $request['dmujer']     = $request['pers_invi_dm'];
			 $request['vfemenino']  = $request['pers_invi_avf'];
			 $request['violencia']  = $request['pers_invi_dievcm'];
			 $request['imaestra']   = $request['pers_invi_maestra'];
			 
			
			 $jerarquias = array();
			 if($request['jera_titulares'])    array_push($jerarquias,$request['jera_titulares']);
			 if($request['jera_subtitulares']) array_push($jerarquias,$request['jera_subtitulares']);
			 if($request['jera_coordinacion']) array_push($jerarquias,$request['jera_coordinacion']);
			 if($request['jera_jefatura'])     array_push($jerarquias,$request['jera_jefatura']);
			 
			 $str_jerarquias = '';
			 if(count($jerarquias) > 0) $str_jerarquias = implode(',',$jerarquias);
			 			 
			 $filters = array(
			     'filt_categoria'  => $request['categoria'],
				 'filt_grupo'      => $request['grupo'],
				 'filt_dependencia'=> $request['dependencia'],
				 'filt_jerarquia'  => $request['jerarquia'],
				 'filt_jerarquias' => $str_jerarquias ,	
				 'filt_cargo'      => urldecode($request['cargo']),				 
				 'filt_municipio'  => $request['municipio'],
				 'filt_ciudad'     => $request['ciudad'],
				 'filt_sexo'       => $request['sexo'],
				 'filt_dm'         => $request['dmujer'],
			     'filt_maestra'    => $request['imaestra'],
				 'filt_avf'        => $request['vfemenino'],
				 'filt_dievcm'     => $request['violencia'],
				 'group'           => 'p.pers_persona',
	             'orderby'         => 'pers_nnombre ASC',
				 'limit'           => 1000000 
			 );	 
			 
			 
			 $rs = $contact->getByFilters($filters,'rs');
			 $rs->MoveFirst();
		     $str = rs2html($rs,$ztabhtml=true,$zheaderarray=false,$htmlspecialchars=true,$echo = false);
		   
		     header("Content-Encoding :iso-8859-1");
			 header('Content-type: application/vnd.ms-excel');
			 header("Content-Disposition: attachment; filename=agenda.xls");
			 header('Content-Length: ' . strlen($str));
			 header("Pragma: no-cache");
			 header("Expires: 0");
			 echo $str; 		 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
		
   /*--------------------------------------------------------------------------------------------------*
    * Reporte de los invitados de la maestra
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['doaction']) && $_POST['doaction']=='reporte.personalizado' ){
	   try {	        				
			 
			 
			 if($_POST['tipo']== 'invimaestra'){
				require_once("../libs/fpdf/class.fpdf_table.php");
             	define('FPDF_FONTPATH','../libs/fpdf/font/');

			 	require_once('../contactos/contactos.class.php');			 
			 	require_once('agenda.pdf.php');
			 
			 
			 	$pdf = new MyPDF("P","mm","Letter");
				$config = array(
					 'header_font' => array('font'=>'Times', 'style'=>'B', 'size'=>8) ,
					 'header_data' => array(
						'logo'   => "../imagenes/iqmlogo.jpg" ,
						'title'  => 'INSTITUTO QUINTANARROENSE DE LA MUJER',
						'stitle' => 'DIRECTORIO INSTITUCIONAL, INVITADOS DE LA MAESTRA'
					 ),			   
				);
				
				$filters = array('pers_invi_maestra'=>'S');		   
		        $pdf->setConfig($filters, $db, $config);
		        $pdf->Open();
		        $pdf->AddPage();
		        $pdf->drawPDF();
		        $pdf->Output('directorio.pdf', 'D'); 				 
			 }
			 
			 if($_POST['tipo']== 'gabineteampliado'){
				require_once("../libs/fpdf/class.fpdf_table.php");
             	define('FPDF_FONTPATH','../libs/fpdf/font/');

			 	require_once('../contactos/contactos.class.php');			 
			 	require_once('agenda.pdf.php');
			 
			 
			 	$pdf = new MyPDF("P","mm","Letter");
				$config = array(
					 'header_font' => array('font'=>'Times', 'style'=>'B', 'size'=>8) ,
					 'header_data' => array(
						'logo'   => "../imagenes/iqmlogo.jpg" ,
						'title'  => 'INSTITUTO QUINTANARROENSE DE LA MUJER',
						'stitle' => 'DIRECTORIO INSTITUCIONAL, GABINETE AMPLIADO'
					 ),			   
				);
				
				$filters = array('grupo'=>207);		   
		        $pdf->setConfig($filters, $db, $config);
		        $pdf->Open();
		        $pdf->AddPage();
		        $pdf->drawPDF();
		        $pdf->Output('directorio.pdf', 'D'); 
				 
			 }
			 
			 if($_POST['tipo']== 'gralByGroup'){
				require_once("../libs/fpdf/class.fpdf_table.php");
             	define('FPDF_FONTPATH','../libs/fpdf/font/');

			 	require_once('../contactos/contactos.class.php');			 
			 	require_once('agenda.gral.grupo.pdf.php');
			 
			 
			 	$pdf = new MyPDF("P","mm","Letter");
				$config = array(
					 'header_font' => array('font'=>'Times', 'style'=>'B', 'size'=>7) ,
					 'header_data' => array(
						'logo'   => "../imagenes/iqmlogo.jpg" ,
						'title'  => 'INSTITUTO QUINTANARROENSE DE LA MUJER',
						'stitle' => 'DIRECTORIO INSTITUCIONAL, REPORTE GENERAL POR GRUPO'
					 ),			   
				);				
				
		        $pdf->setConfig($filters, $db, $config);
		        $pdf->Open();
		        $pdf->AddPage();
		        $pdf->drawPDF();
		        $pdf->Output('directorio.pdf', 'D'); 
				 
			 }
			 
			 if($_POST['tipo']== 'gralByName'){
				require_once("../libs/fpdf/class.fpdf_table.php");
             	define('FPDF_FONTPATH','../libs/fpdf/font/');

			 	require_once('../contactos/contactos.class.php');			 
			 	require_once('agenda.gral.name.pdf.php');
			 
			 
			 	$pdf = new MyPDF("P","mm","Letter");
				$config = array(
					 'header_font' => array('font'=>'Times', 'style'=>'B', 'size'=>7) ,
					 'header_data' => array(
						'logo'   => "../imagenes/iqmlogo.jpg" ,
						'title'  => 'INSTITUTO QUINTANARROENSE DE LA MUJER',
						'stitle' => 'DIRECTORIO INSTITUCIONAL, REPORTE GENERAL POR NOMBRE'
					 ),			   
				);
				
				  
		        $pdf->setConfig($filters, $db, $config);
		        $pdf->Open();
		        $pdf->AddPage();
		        $pdf->drawPDF();
		        $pdf->Output('directorio.pdf', 'D'); 
				 
			 }
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
		
   /*--------------------------------------------------------------------------------------------------*
    * Obtienes los grupos
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='grupos.getByXML' ){
	   try {	        				
			 require_once('../contactos/contactos.class.php');
			 $contact = new Contacto($db);
			 
			 $request = array('start'=>0, 'limit'=> 10000, 'categoria'=>$_GET['categoria']);			 
			 $rows = $contact->getGrupos($request, 'array');
			 
			 header("Content-type:text/xml");
			 $xml = "<?xml version=\"1.0\"?>".chr(13);
			 $xml.= "<complete>".chr(13);
			 if(is_array($rows)){
				foreach($rows as $key => $row) {
				        $xml.= '<option value="'.$row['id'].'">'.utf8_encode($row['value']).'</option>'.chr(13);
				}				 
			 }
			 $xml.= "</complete>".chr(13);
			 
			 echo $xml;
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Obtienes las dependencias
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='dependencia.getByXML' ){
	   try {	        				
			 require_once('../contactos/contactos.class.php');
			 $contact = new Contacto($db);
			 
			 $request = array('start'=>0, 'limit'=> 10000, 'grupo'=>$_GET['grupo']);			 
			 $rows = $contact->getDependencias($request, 'array');
			 
			 header("Content-type:text/xml");
			 $xml = "<?xml version=\"1.0\"?>".chr(13);
			 $xml.= "<complete>".chr(13);
			 if(is_array($rows)){
				foreach($rows as $key => $row) {
				        $xml.= '<option value="'.$row['id'].'">'.utf8_encode($row['value']).'</option>'.chr(13);
				}				 
			 }
			 $xml.= "</complete>".chr(13);
			 
			 echo $xml;
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Obtienes los grupos
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='grupos.getBySelect' ){
	   try {	        				
			 require_once('../contactos/contactos.class.php');
			 $contact = new Contacto($db);
			 
			 $request = array('start'=>0, 'limit'=> 10000, 'categoria'=>$_GET['categoria']);			 
			 $rows = $contact->getGrupos($request, 'array');
			 
			 $select = '<select name="grupo" id="grupo" class="x-form-field" style="width:350px">';
			 $select.= '<option value=""> </option>';
			 
			 if(is_array($rows)){
				foreach($rows as $key => $row) {
				        $select.="<option value='".$row['id']."'>" .$row['value']."</option>";	
				}
				 
			 }
			 $select.='</select>';
			 
			 echo $select;
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Reporte que se manda a llamar desde inicio, Boton.PDF, Botton.XLS
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='exportToPDF' ){
	   try {	        				
			 
			 require_once("../libs/fpdf/class.fpdf_table.php");
             define('FPDF_FONTPATH','../libs/fpdf/font/');
			 
			 require_once('../contactos/contactos.class.php');			 
			 require_once('agenda.export.php');
			 
			 		   
			 $contact = new Contacto($db);
			 
			 $request = $_POST;
			 
			 //definimos que tipo de busqueda esta realizando
			 if(     $request['searchBy'] == 'searchByName'){
			 
			 
			 }elseif($request['searchBy'] == 'searchByGroup' ){
				 
				 $pdf = new MyPDF("P","mm","Letter");
				 $config = array(
					 'header_font' => array('font'=>'Times', 'style'=>'B', 'size'=>8) ,
					 'header_data' => array(
						'logo'   => "../imagenes/iqmlogo.jpg" ,
						'title'  => 'INSTITUTO QUINTANARROENSE DE LA MUJER',
						'stitle' => 'DIRECTORIO INSTITUCIONAL, BUSQUEDA POR GRUPO'
					 ),			   
				 );
			     
				 $ngrupo = urldecode($_POST['grupo']);				 
				 $pdf->setConfig(array('ngrupo'=>$ngrupo), $db, $config);
				 $pdf->Open();
				 $pdf->AddPage();
				 $pdf->drawPDF();
				 $pdf->Output('directorio.pdf', 'D');			 
				 
			 }elseif($request['searchBy'] == 'searchAdvanced'){
				 $pdf = new MyPDF("P","mm","Letter");
				 $config = array(
					 'header_font' => array('font'=>'Times', 'style'=>'B', 'size'=>8) ,
					 'header_data' => array(
						'logo'   => "../imagenes/iqmlogo.jpg" ,
						'title'  => 'INSTITUTO QUINTANARROENSE DE LA MUJER',
						'stitle' => 'DIRECTORIO INSTITUCIONAL'
					 ),			   
				 );
			   
				 $pdf->setConfig($_POST, $db, $config);
				 $pdf->Open();
				 $pdf->AddPage();
				 $pdf->drawPDF();
				 $pdf->Output('directorio.pdf', 'D');
			 }
			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
	 
   /*--------------------------------------------------------------------------------------------------*
    * Reporte que se manda a llamar desde inicio, Boton.PDF, Botton.XLS
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='exportToXLS' ){
	   try {	        				
			 
			 require_once('../contactos/contactos.class.php');
			 require_once("../libs/adodb/toexport.inc.php");
		     require_once("../libs/adodb/tohtml.inc.php");
		   
			 $contact = new Contacto($db);
			 
			 $request = $_POST;
			  
			 
			 if($request['searchBy'] == 'searchByGroup'){
			     $ngrupo = urldecode($_POST['grupo']);
				 
				 $filters = array(
				     'filt_ngrupo'   => $ngrupo,
					 'group'         => 'p.pers_persona',
					 'orderby'       => 'pers_nnombre ASC',
					 'limit'         => 1000000 
				 );	
				 $rs = $contact->getByFilters($filters,'rs');
				 $rs->MoveFirst();
				 $str = rs2html($rs,$ztabhtml=true,$zheaderarray=false,$htmlspecialchars=true,$echo = false);
			   
				 header("Content-Encoding :iso-8859-1");
				 header('Content-type: application/vnd.ms-excel');
				 header("Content-Disposition: attachment; filename=agenda.xls");
				 header('Content-Length: ' . strlen($str));
				 header("Pragma: no-cache");
				 header("Expires: 0");
				 echo $str;
				 
			 }elseif($request['searchBy'] == 'searchAdvanced'){
				 $request['dmujer']     = $request['pers_invi_dm'];
				 $request['vfemenino']  = $request['pers_invi_avf'];
				 $request['violencia']  = $request['pers_invi_dievcm'];
				 $request['imaestra']   = $request['pers_invi_maestra'];
				 
				
				 $jerarquias = array();
				 if($request['jera_titulares'])    array_push($jerarquias,$request['jera_titulares']);
				 if($request['jera_subtitulares']) array_push($jerarquias,$request['jera_subtitulares']);
				 if($request['jera_coordinacion']) array_push($jerarquias,$request['jera_coordinacion']);
				 if($request['jera_jefatura'])     array_push($jerarquias,$request['jera_jefatura']);
				 
				 $str_jerarquias = '';
				 if(count($jerarquias) > 0) $str_jerarquias = implode(',',$jerarquias);
							 
				 $filters = array(
					 'filt_categoria'  => $request['categoria'],
					 'filt_grupo'      => $request['grupo'],
					 'filt_dependencia'=> $request['dependencia'],
					 'filt_jerarquia'  => $request['jerarquia'],
					 'filt_jerarquias' => $str_jerarquias ,	
					 'filt_cargo'      => urldecode($request['cargo']),				 
					 'filt_municipio'  => $request['municipio'],
					 'filt_ciudad'     => $request['ciudad'],
					 'filt_sexo'       => $request['sexo'],
					 'filt_dm'         => $request['dmujer'],
					 'filt_maestra'    => $request['imaestra'],
					 'filt_avf'        => $request['vfemenino'],
					 'filt_dievcm'     => $request['violencia'],
					 'group'           => 'p.pers_persona',
					 'orderby'         => 'pers_nnombre ASC',
					 'limit'           => 1000000 
				 );	
				 $rs = $contact->getByFilters($filters,'rs');
				 $rs->MoveFirst();
				 $str = rs2html($rs,$ztabhtml=true,$zheaderarray=false,$htmlspecialchars=true,$echo = false);
			   
				 header("Content-Encoding :iso-8859-1");
				 header('Content-type: application/vnd.ms-excel');
				 header("Content-Disposition: attachment; filename=agenda.xls");
				 header('Content-Length: ' . strlen($str));
				 header("Pragma: no-cache");
				 header("Expires: 0");
				 echo $str;
			 }
			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
	
	
	
	
	$db->Close();


?>