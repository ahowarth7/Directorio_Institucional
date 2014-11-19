<?PHP    
    
		
	define('PATH_BASE','../');
	
	ini_set('display_errors',1); 
	ini_set('error_reporting',6135); 
	
	
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
	require_once('eventos.class.php');
		  
    //conexion
    $db = Conectar();
	$event = new Evento($db);
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Listar los eventos
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='load' ){
	   try {	        				
			 
			 $rows        = $event->getList($_POST,NULL);
			 $response    = $event->getResponse();
			 echo $event->json_encode(utf8_encode_array($response));			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Guarda el evento
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='insert' ){
	   try {	        				
			 
			 $transaction = $event->add($_POST);
			 $response    = $event->getResponse();	
			 echo $event->json_encode(utf8_encode_array($response));
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Guarda el evento
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='edit' ){
	   try {	        				
			 
			 $transaction = $event->edit($_POST);
			 $response    = $event->getResponse();	
			 echo $event->json_encode(utf8_encode_array($response));			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Borra el registro
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='delete' ){
	   try {	        				
			 
			 $transaction = $event->delete($_POST['rowid']);
			 $response    = $event->getResponse();	
			 echo $event->json_encode(utf8_encode_array($response));			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Borra el registro
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='event.addInvitados' ){
	   try {	        				
			
			 $transaction = $event->addInvitados($_POST,'response');
			 $response    = $event->getResponse();
			 echo $event->json_encode(utf8_encode_array($response));			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Edita los invitados ya agregados a un evento
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='event.editInvitados' ){
	   try {	        				
			
			 
			 $transaction = $event->addInvitados($_POST,'response');
			 $response    = $event->getResponse();
			 echo $event->json_encode(utf8_encode_array($response));			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Recupera los invitados de un evento
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='event.getInvitados' ){
	   try {	        				
			
			 $transaction = $event->getInvitados($_POST['evento'], $_POST, 'response');
			 $response    = $event->getResponse();
			 echo $event->json_encode(utf8_encode_array($response));			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Recupera los invitados de un evento
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='evento.getForPreview' ){
	   try {	        				
			
			 $rows = $event->getInvitados($_GET['evento'], array('npersona'=>$_GET['query']), 'array');
			 if(is_array($rows)){
				$result = array();
				foreach($rows as $key => $rinvi){
					   
				        $record = array('id'=>$rinvi['invi_persona'], 'value'=> $rinvi['invi_npersona'] , 'info'=>$rinvi['invi_cargo']);
						$result[] = $record;
				}
				$response = array("results"=> $result);
				echo $event->json_encode(utf8_encode_array($response));
			 }
			 
			 
			 		 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Obtiene la lista de grupos que participan en un evento
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='event.getGrupos' ){
	   try {	        				
			 
			 $params    = array('ngrupo'=>$_POST['query'], 'start'=>$_POST['start'], 'limit'=>$_POST['limit']);
			 $rows      = $event->getGroupFromEvent($_POST['evento'],$params,'response');
			 $response  = $event->getResponse();
			 echo $event->json_encode(utf8_encode_array($response));			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Obtiene la lista de invitados a notificar
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='event.getDependencias' ){
	   try {	        				
			 			 
			 $rows      = $event->getDepenFromEvent($_POST['evento'],$_POST,'response');
			 $response  = $event->getResponse();
			 echo $event->json_encode(utf8_encode_array($response));			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
	
	
	
				
   /*--------------------------------------------------------------------------------------------------*
    * Obtiene la lista de invitados a notificar
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='notificados' ){
	   try {	        				
			 $xaction = $_POST['xaction'];
			  
			 if($xaction=='read'){
			    $transaction = $event->getNotificados($_POST['evento'],$_POST,'response');
			    $response    = $event->getResponse();
			    echo $event->json_encode(utf8_encode_array($response));
			 }
			 
			 if($xaction=='update'){
			   
				$transaction = $event->updateNotificado($_POST,'response');
			    $response    = $event->getResponse();
			    echo $event->json_encode(utf8_encode_array($response));
			 }
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Obtiene la lista de invitados que ya recibieron la notificacion, para llamarles y confirmar
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='confirmados' ){
	   try {	        				
			 $xaction = $_POST['xaction'];
			  
			 if($xaction=='read'){
			    $transaction = $event->getConfirmados($_POST['evento'],$_POST,'response');
			    $response    = $event->getResponse();
			    echo $event->json_encode(utf8_encode_array($response));
			 }
			 
			 if($xaction=='update'){
			   
				$transaction = $event->updateConfirmado($_POST,'response');
			    $response    = $event->getResponse();
			    echo $event->json_encode(utf8_encode_array($response));
			 }
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'message'=> $e->getMessage(), 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Borra el registro
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='contacto.getByFilters' ){
	   try {	        				
			 require_once('../contactos/contactos.class.php');
			 $contact = new Contacto($db);
			 
			 $response = $contact->getByFilters($_POST,'response');
			 echo json(utf8_encode_array($response),'encode');			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Busca las tipos de categorias que existen
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='categorias.getList' ){
	   try {
	         require_once('../contactos/contactos.class.php');
			 $contact = new Contacto($db);
			 
			 $response = $contact->getCategorias($_POST, 'response');
		     echo json(utf8_encode_array($response),'encode');
			  
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Busca los tipos de jerarquias
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='jerarquias.getList' ){
	   try {
	         require_once('../contactos/contactos.class.php');
			 $contact = new Contacto($db);
			 
			 $response = $contact->getJerarquias($_POST, 'response');
		     echo json(utf8_encode_array($response),'encode');
			  
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Busca el catalogo de grupos
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='grupo.getList' ){
	   try {
	         require_once('../contactos/contactos.class.php');
			 $contact = new Contacto($db);
			 
			 $response = $contact->getGrupos($_POST,'response');
		     echo json(utf8_encode_array($response),'encode');	 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Busca el catalogo de dependencias
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='dependencia.getList' ){
	   try {
	         require_once('../contactos/contactos.class.php');
			 $contact = new Contacto($db);
			 
			 $response = $contact->getDependencias($_POST,'response');
		     echo json(utf8_encode_array($response),'encode');	 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Busca el catalogo de Municipios
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='municipio.getList' ){
	   try {
	         require_once('../contactos/contactos.class.php');
			 $contact = new Contacto($db);
			 
			 $response = $contact->getMunicipios($_POST,'response');
		     echo json(utf8_encode_array($response),'encode');	 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
	
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Guarda los datos de la plantilla
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='template.save' ){
	   try {
	         
			/**
			 * $_POST = array (evento, html )
			 */
			 
			 $response = $event->saveTemplate($_POST, $_POST['evento']);
		     echo json(utf8_encode_array($response),'encode');	 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
	
	$db->Close();
?>	