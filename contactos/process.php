<?PHP

    //includes
    header("Content-Type: text/html; charset=iso-8859-1");
	header("Content-Encoding :iso-8859-1");
	
	//para los de session
	include('../include/funciones_v2.php');
    f_verifica_sesion();
	
	
	$path = '../../'; //dirname(__FILE__);
	require_once ("../libs/adodb/adodb-exceptions.inc.php");
	require_once ("../libs/adodb/adodb.inc.php");
	require_once ("../includes/utf8.php");
	require_once ("../includes/config.php");
	require_once ("../includes/conexion.php");
	require_once ("../libs/lib/lib.php");
	require_once('contactos.class.php');	  
	  
    //conexion
    $db = Conectar();
    
	//Instance
	$contact = new Contacto($db);
	
	
   
   /*--------------------------------------------------------------------------------------------------*
    * verifica para descargar la lista de contactos 
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='contact.getByFilters' ){
	   try {
	         	
			 $response = $contact->getByFilter($_POST);
			 echo json(utf8_encode_array($response),'encode');			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * verifica para descargar la lista de contactos 
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='contact.getByFilter' ){
	   try {
	         if($_GET['name']) {
			    $by = 'name';
			 }elseif($_GET['apat']){
			    $by = 'apat';
			 }else{
			    $by = '';
			 }
			    
				
			 $rows = $contact->getByFilter($_GET['input'], $by);
			 $response = array("results"=> $rows);
			 echo json(utf8_encode_array($response),'encode');			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Guarda los datos principales
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='contact.save' ){
	   try {
	         $response = $contact->save($_POST);
		     echo json(utf8_encode_array($response),'encode');			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Edita los datos
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='contact.edit' ){
	   try {
	         $response = $contact->edit($_POST);
		     echo json(utf8_encode_array($response),'encode');			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Edita los datos
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='contact.delete' ){
	   try {
	         $response = $contact->delete($_POST['pers_persona']);
		     echo json(utf8_encode_array($response),'encode');			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
		
	
   /*--------------------------------------------------------------------------------------------------*
    * verifica para descargar la lista de contactos 
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='persona.getInfo' ){
	   try {
	         $response = $contact->getInfo($_POST['pers_persona']);
			 echo json(utf8_encode_array($response),'encode');			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * verifica para descargar la lista de contactos 
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='persona.getInfoGrupos' ){
	   try {
	         $response = $contact->getInfoGrupos($_POST['pers_persona']);
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
   /*--------------------------------------------------------------------------------------------------*
    * verifica para descargar la lista de contactos 
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='persona.validate' ){
	   try {
	        
			 $response = $contact->validate($_POST['field'],$_POST['value'], $_POST['generico'],$_POST['cual']);
			 $response['field']  = $_POST['field'];
			 echo json(utf8_encode_array($response),'encode');			 
			 
	   }catch(Exception $e){
	         $response  = (array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     $response['field']  = $_POST['field'];
			 $response['script'] = $contact->script['script'];
			 echo json(utf8_encode_array($response),'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Busca los tipos de titulos para el contacto 
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='titulos.getList' ){
	   try {
	         $string = $contact->getTitulos($_GET['q'] , 'pipe');
			 echo  $string;		 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
  
	
   /*--------------------------------------------------------------------------------------------------*
    * Busca los tipos de calles
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='tcalles.getList' ){
	   try {
	         $string = $contact->getTCalles($_GET['q'] , 'pipe');
			 echo  $string;		 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Busca en el catalogo de calles
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='calles.getList' ){
	   try {
	         $string = $contact->getCalles($_GET['q'] , 'pipe');
			 echo  $string;		 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Busca el catalogo de colonias
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='colonias.getList' ){
	   try {
	       
			 $rows = $contact->getColonias($_GET['q'], $_GET['municipio'] ,'array');
			 $response = array("results"=> $rows);
		     echo json(utf8_encode_array($response),'encode');	 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Busca los tipos de titulos para el contacto 
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='categoria.getList' ){
	   try {
	         $string = $contact->getCategorias($_GET['q'] , 'pipe');
			 echo  $string;		 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   
   /*--------------------------------------------------------------------------------------------------*
    * Regresa la lista de municipios
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='municipio.getList' ){
	   try {
	         
			 $rows = $contact->getMunicipios(array('query'=>$_GET['q']) ,'array'); 
			 $response = array("results"=> $rows);
		     echo json(utf8_encode_array($response),'encode');		 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Regresa la lista de municipios
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='municipio.getListByXML' ){
	   try {
	         
			 $filters = array('query'=>$_GET['mask']);
			 $rows = $contact->getMunicipios($filters ,'array');
			 
			 header("Content-type:text/xml");
			 print("<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>");
			 print("<complete>");
			 foreach($rows as $key => $record){
			     print("<option value=\"".$record["id"]."\">");
				 print($record["value"]);
				 print("</option>");
			 }
			 print("</complete>");

			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Regresa la lista de estados
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='ciudades.getList' ){
	   try {
	         $rows = $contact->getCiudades($_GET['q'] , $_GET['municipio'],'array');  //@query, @muni, @type 
			 $response = array("results"=> $rows);
		     echo json(utf8_encode_array($response),'encode');		 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
   
   /*--------------------------------------------------------------------------------------------------*
    * Regresa la lista de estados
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='ciudades.getListByXML' ){
	   try {
	         $rows = $contact->getCiudades($_GET['mask'] , $_GET['municipio'],'array');  //@query, @muni, @type 
			 
			 header("Content-type:text/xml");
			 print("<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>");
			 print("<complete>");
			 foreach($rows as $key => $record){
			     print("<option value=\"".$record["id"]."\">");
				 print($record["value"]);
				 print("</option>");
			 }
			 print("</complete>");		 
			 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Busca el catalogo de grupos
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='grupo.getList' ){
	   try {
	         $rows = $contact->getGrupos($_GET,'array');
			 $response = array("results"=> $rows);
		     echo json(utf8_encode_array($response),'encode');	 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Guarda la dependencia
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_POST['action']) && $_POST['action']=='dependencia.save' ){
	   try {
	         
			 $rows = $contact->saveDependencia($_POST);
			 $response = $rows;
		     echo json(utf8_encode_array($response),'encode');
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
	
   /*--------------------------------------------------------------------------------------------------*
    * Busca el catalogo de dependencias
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='dependencia.getList' ){
	   try {
	         $rows     = $contact->getDependencias($_GET, 'array');
			 $response = array("results"=> $rows);
		     echo json(utf8_encode_array($response),'encode');	 
			 
	   }catch(Exception $e){
	         $response  = utf8_encode_array(array('success'=> false, 'errors'=>array('code' => $e->getCode(), 'msg'=> $e->getMessage(),'line'=>$e->getLine()) ));
		     echo json($response,'encode');
	   }		
	}
	
   /*--------------------------------------------------------------------------------------------------*
    * Descarga el formulario de dependencias
	*--------------------------------------------------------------------------------------------------*/
	if(isset($_GET['action']) && $_GET['action']=='dependencia.getFrm' ){
	   require_once('dependencia.frm.php');	   
	}
	
	
	
	
   
   
    $db->Close();


?>