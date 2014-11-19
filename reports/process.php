<?PHP    
    
	define('PATH_BASE','../');
	
	//includes
    
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
	require_once('../eventos/eventos.class.php');
		  
    //conexion
    $db = Conectar();
	
		
   /*--------------------------------------------------------------------------------------------------*
    * Listar los eventos
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='invitados.getList' ){
	   try {	        				
			 $event     = new Evento($db);
			 $rows      = $event->getInvitados($_POST['evento'], $_POST, 'response');
			 $response  = $event->getResponse();
			 echo $event->json_encode(utf8_encode_array($response));			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	

   /*--------------------------------------------------------------------------------------------------*
    * REPORTE DE INVITADOS
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['doaction']) && $_POST['doaction']=='invitados.getReport' ){
	   try {	        				
			 
			 require_once('reports.cls.php');
			 $report  = new Reports($db,'L');
			 $format = $_POST['format'];
			 $report->reportInvitados($format, $_POST);			 		 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Listar los eventos
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='evento.getSeguimiento' ){
	   try {	        				
			 $event     = new Evento($db);
			 $rows      = $event->getSeguimiento($_POST['evento'], $_POST, 'response');
			 $response  = $event->getResponse();
			 echo $event->json_encode(utf8_encode_array($response));			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * REPORTE DE INVITADOS
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['doaction']) && $_POST['doaction']=='segumiento.getReport' ){
	   try {	        				
			 
			 require_once('reports.cls.php');
			 $report  = new Reports($db,'L');
			 $format = $_POST['format'];
			 $report->reportSeguimiento($format, $_POST);			 		 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Listar las Rutas del evento
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='event.getRutas' ){
	   try {	        				
			 $event     = new Evento($db);
			 
			 $_POST['group']='depe_ruta, depe_dependencia';
			 
			 $rows      = $event->getRutas($_POST['evento'], $_POST, 'response');
			 $response  = $event->getResponse();
			 echo $event->json_encode(utf8_encode_array($response));			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
   /*--------------------------------------------------------------------------------------------------*
    * REPORTE DE GRUPOS INVITADOS EN EL EVENTO
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['doaction']) && $_POST['doaction']=='event.groups().getReport' ){
	   try {	        				
			 
			 require_once('reports.cls.php');
			 $report  = new Reports($db,'L');
			 $format = $_POST['format'];
			 $report->reportEventGroup($format, $_POST);			 		 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
   /*--------------------------------------------------------------------------------------------------*
    * REPORTE DE LAS RUTAS DEL EVENTO
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['doaction']) && $_POST['doaction']=='rutas.getReport' ){
	   try {	        				
			 
			 require_once('reports.cls.php');
			 $report  = new Reports($db,'P');
			 $format = $_POST['format'];
			 $report->reportRutas($format, $_POST);			 		 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
   /*--------------------------------------------------------------------------------------------------*
    * REPORTE DE CONFIRMADOS, TITULARES QUE ASISTEN, SUPLENTES QUE ASISTEN, NO ASISTEN
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['doaction']) && $_POST['doaction']=='event.confirmWho().getReport' ){
	   try {	        				
			 
			 require_once('reports.cls.php');
			 $report  = new Reports($db,'P');
			 $format = $_POST['format'];
			 $report->reportQuienes($format, $_POST);			 		 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * REPORTE POR LIDERAZGO
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['doaction']) && $_POST['doaction']=='event.liderazgo().getReport' ){
	   try {	        				
			 
			 require_once('reports.cls.php');
			 $report  = new Reports($db,'P');
			 $format = $_POST['format'];
			 $report->reportLiderazgo($format, $_POST);			 		 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
	
	
	
	
   /*--------------------------------------------------------------------------------------------------*
    * RESUMEN DE LAS ESTADISTICAS
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['doaction']) && $_POST['doaction']=='statics.print' ){
	   try {	        				
			 
			 require_once("stadisticas.pdf.php");
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
	
	
	
	
	
	
	
	

   /*--------------------------------------------------------------------------------------------------*
    * REPORTE DE CATEGORIAS
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['doaction']) && $_POST['doaction']=='categorias.getReport' ){
	   try {	        				
			 

			 require_once('categ.pdf.php');
		   
		     $pdf = new MyPDF("P","mm","Letter");
		     $config = array(
		         'header_font' => array('font'=>'Times', 'style'=>'B', 'size'=>8) ,
			     'header_data' => array(
			         'logo'   => "../imagenes/iqmlogo.jpg" ,
				     'title'  => 'INSTITUTO QUINTANARROENSE DE LA MUJER',
			         'stitle' => 'REPORTE DE CATEGORIA/GRUPOS'
			     ),			   
		     );
			 
			 $pdf->setConfig($data, $db,$config);
		     $pdf->Open();
		     $pdf->AddPage();
		     $pdf->drawPDF();
		     $pdf->Output(date('dmYhi').'.pdf', 'D'); 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
	$db->Close();
?>	