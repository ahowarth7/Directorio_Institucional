<?php

/**
 * Object class, eventos.class.php
 * v1.0
 */

// Check to ensure this file is within the rest of the framework
defined('PATH_BASE') or die('No se puede acceder de esta forma');
require_once(PATH_BASE.'class/object.php');

class Evento extends Object
{

	/**
	 * Identifier to database
	 *
	 * @var		array of error messages or JExceptions objects
	 * @access	protected
	 * @since	1.0
	 */
    private	$db;
	private $response = array();
	
	
	/**
	 * Class constructor, overridden in descendant classes.
	 *
	 * @access	protected
	 * @since	1.5
	 */
	function __construct($db) 
	{
	     $this->db = $db; 
	
	}
	
	/**
	 * getList - Regresa la lista de eventos que estan en la base de datos
	 *
	 * @param  array  $params Array con los filtros que se quieren aplicar a la consulta
	 * @param  string $rmode Return Mode, regresara los datos en el formato especificado, array, ponter, xml, json, html
	 * @return mixed dependiendo del retur modo
	 */
	public function getList($params,$rmode=NULL)
	{
	    try
		{    $start = $params['start'] ? $params['start']  : 0;
		     $limit = $params['limit'] ? $params['limit']  : 20;
		      
		     $sql ="
			 SELECT SQL_CALC_FOUND_ROWS
			        even_evento   AS even_evento,
			        even_descrip  AS even_descrip,
					even_lugar    AS even_lugar ,
					DATE_FORMAT(even_fini,'%d/%m/%Y')  AS even_ini,
					DATE_FORMAT(even_ffin,'%d/%m/%Y')  AS even_fin,
					even_coordina,
					( SELECT COUNT(*) 
					    FROM invitados 
					   WHERE invi_evento = even_evento 
					)            AS even_invitados					
			   FROM eventos
			  WHERE 1 = 1
			 ";
			 if(strlen($params['evento'])>0){ $sql.=" AND even_evento = '".$params['evento']."'";}
			 
			 $sql.=" ORDER BY even_fini DESC";
			 
			 //ejecutamos la consulta
			 $rs   = $this->db->SelectLimit($sql, $limit, $start);
			 $tt   = $this->db->GetOne(" SELECT FOUND_ROWS(); ");	
			 $rows = $rs->GetAll();
			 
			 //fijamos el response
			 $response = array("success" => true, "total" => $tt, "rows"=> $rows);
			 $this->setResponse($response);			 
			 
		     return $rows;
			 
			        	
		}catch(Exception $e){
			 $this->setError('error', $e->getCode(), $e->getMessage());
			 throw new Exception($e->getMessage() , $e->getCode() );	
		}
	}
	/**
	 * add - Agrega un registro a la base de datos
	 * @param mixed array que contiene todos los datos que se insertan
	 * @param string modo de como debe de regresar los resultados
	 * 
	 */
	public function add($data)
	{
	    try
		{    $fini = cambiarFormatoFecha($data['even_ini']);
		     $ffin = cambiarFormatoFecha($data['even_fin']);
		      
		     
		     $sql = "
			 INSERT INTO eventos (
			        even_descrip ,
					even_lugar   ,
					even_fini    ,
					even_ffin    ,
					even_coordina
			 ) VALUE (
			        ".$this->db->qstr($data['even_descrip']).",
					".$this->db->qstr($data['even_lugar']).",
					'".$fini."',
					'".$ffin."',
					".$this->db->qstr($data['even_coordina'])."
			 )";
			 
			 //aplicamos la transaccion
			 $this->db->StartTrans();
			 $this->db->Execute($sql);
			 $next = $this->db->Insert_ID();
			 $this->db->CompleteTrans();
			 
			
			 //fijamos el response
			 $response = array('success'=>true,'message'=>"Se ha agregado con exito el evento. Folio: <b>{$next}</b>");
			 $this->setResponse($response);
			 
			 return true;
			 
			        	
		}catch(Exception $e){
			 $this->db->RollbackTrans();		   
			 $this->setError('error', $e->getCode(), $e->getMessage());
			 throw new Exception($e->getMessage() , $e->getCode());	
		}
	}
	
	/**
	 * delete - Elimina un registro de la base de datos
	 *
	 * @param integer rowid - id del registro que se desea borrar
	 * @return boolean true si se elimino correctamente de lo contrario false
	 */
	public function edit($data)
	{
	    try 
		 {    
		      $fini = cambiarFormatoFecha($data['even_ini']);
		      $ffin = cambiarFormatoFecha($data['even_fin']);
			 
		      $sql="
			  UPDATE eventos
			     SET even_descrip  = ".$this->db->qstr($data['even_descrip']).",
				     even_lugar    = ".$this->db->qstr($data['even_lugar']).",
				     even_fini     = '".$fini."',
					 even_ffin     = '".$ffin."',
					 even_coordina = ".$this->db->qstr($data['even_coordina'])."
			   WHERE even_evento   = ".$this->db->qstr($data['even_evento'])."
			  ";
			  
			  $this->db->StartTrans();
			  $this->db->Execute($sql);
			  $this->db->CompleteTrans();
			  
			  //fijamos el response
			  $response = array('success'=>true,'message'=>"Se han modificado los datos correctamente");
			  $this->setResponse($response);
			  
			  return true;
			   
		 }catch(Exception $e){
			  $this->db->RollbackTrans();		   
			  $this->setError('error', $e->getCode(), $e->getMessage());
			  throw new Exception($e->getMessage() , $e->getCode());	
		}
	}
	
	
	/**
	 * delete - Elimina un registro de la base de datos
	 *
	 * @param integer rowid - id del registro que se desea borrar
	 * @return boolean true si se elimino correctamente de lo contrario false
	 */
	public function delete($evento)
	{
	     try 
		 {
		      $this->db->StartTrans();
			  $this->db->Execute("DELETE FROM template WHERE temp_evento = '".$evento."'");
			  $sql="DELETE FROM invitados WHERE invi_evento = '".$evento."'";
			  $this->db->Execute($sql);			  
			  $sql="DELETE FROM eventos WHERE even_evento = '".$evento."'";
			  $this->db->Execute($sql);
			  $this->db->CompleteTrans();
			  
			  //fijamos el response
			  $response = array('success'=>true,'message'=>"Se ha eliminado el registro de la base de datos");
			  $this->setResponse($response);
			  
			  return true;
			   
		 }catch(Exception $e){
			  $this->db->RollbackTrans();		   
			  $this->setError('error', $e->getCode(), $e->getMessage());
			  throw new Exception($e->getMessage() , $e->getCode());	
		}
	}
	
	/**
	 * delete - Elimina un registro de la base de datos
	 *
	 * @param integer rowid - id del registro que se desea borrar
	 * @return boolean true si se elimino correctamente de lo contrario false
	 */
	public function getInvitados($event, $filter, $rmode)
	{
	     try 
		 {
		      $start = $filter['start'] ? $filter['start'] : 0;
			  $limit = $filter['limit'] ? $filter['limit'] : 100;			 
			  
			  $sql = "
			  SELECT SQL_CALC_FOUND_ROWS
			         i.*,
					 'true'                     AS isinvited,
					 get_grupName(invi_grupo)   AS invi_ngrupo,
					 get_depeName(invi_dependencia) AS invi_ndependencia,
					 ( SELECT d_titulos FROM cat_titulos WHERE id_titulos = i.pers_titulo) AS invi_ntitulo
			         #g.ngrupo         AS invi_ngrupo,
					 #g.ndependencia   AS invi_ndependencia*/
			    FROM ( #personas que se invitaron al evento, del grupo y dependencia correspondiente
				       SELECT invi_invitado     AS invi_invitado,
					          invi_evento       AS invi_evento  , 
							  invi_persona      AS invi_persona ,
							  p.pers_tel_dep    AS pers_dtel, 
					          p.pers_ext_dep    AS pers_dext,
					          p.pers_email_dep  AS pers_demail,
							  CONCAT_WS(' ', p.pers_nombre, p.pers_apat, p.pers_amat) invi_npersona, 
							  invi_jerarquia    AS invi_jerarquia, 
							  ( SELECT nom_jerarquia FROM cat_jerarquias WHERE id_jerarquia = i.invi_jerarquia) AS invi_njerarquia,  
							  invi_tgrupo       AS invi_tgrupo  , 
							  invi_grupo        AS invi_grupo   ,
							  invi_dependencia  AS invi_dependencia,
							  vp.pers_cargo     AS invi_cargo , 
							  vp.pers_municipio AS invi_municipio,
							  vp.pers_ciudad    AS invi_ciudad,
							  p.pers_titulo     AS pers_titulo
						 FROM invitados i, vpersonas vp , personas p
						WHERE invi_persona = vp.pers_persona 
						  AND invi_grupo        = vp.pers_grupo
						  AND invi_dependencia  = vp.pers_dependencia   
						  AND invi_persona      = p.pers_persona
						  AND invi_evento       = '$event'
                     ) i 
					 /*#, ( 
					 #  SELECT gp.id_grup        AS grupo, 
					 #         gp.d_grupo        AS ngrupo,
					 #		  depe_dependencia  AS dependencia, 
					 #		  de.depe_nombre    AS ndependencia
					 #    FROM cat_grupos gp , cat_dependencias de
					 #	WHERE gp.id_grup  = de.depe_grupo 
					 #) g  */
			   WHERE 1= 1 /*g.grupo       = i.invi_grupo*/
			         #  AND g.dependencia = i.invi_dependencia
			  ";
			  if(strlen($filter['invitado'])> 0 ) {  $sql.= " AND i.invi_invitado  = '".$filter['invitado']."'"; }
			  if(strlen($filter['persona'])> 0 )  {  $sql.= " AND i.invi_persona  = '".$filter['persona']."'"; }
			  if(strlen($filter['npersona'])> 0 ) {  $sql.= " AND i.invi_npersona  LIKE ('%".$filter['npersona']."%')"; }
			  if(strlen($filter['jerarquia'])> 0 ){  $sql.= " AND i.invi_jerarquia = '".$filter['jerarquia']."'"; }
			  if(strlen($filter['grupo'])> 0 ){       $sql.= " AND i.invi_grupo LIKE '".$filter['grupo']."'"; }
			  if(strlen($filter['dependencia'])> 0 ){ $sql.= " AND i.invi_dependencia LIKE '".$filter['dependencia']."'"; }
			  $sql.=" ORDER BY invi_ndependencia, i.invi_jerarquia ASC, i.invi_npersona ASC";
			  
			 
			  $rs    = $this->db->SelectLimit($sql, $limit, $start);
			  $tt    = $this->db->GetOne("SELECT FOUND_ROWS(); ");
			  
			 			 
			  if ($rmode == 'response'){
				  $rows  = $rs->GetAll();
				  $response = array('success'=>true,'total'=>$tt, 'rows'=>$rows, 'sql'=>$sql);
				  unset($rows);
				  $this->setResponse($response);
				  $rs->Close();
				  
			  }elseif($rmode == 'array'){
			      $rows = $rs->GetAll();
				  $rs->Close();
				  return $rows;
			  }elseif($rmode == 'rs'){
			      return  $rs;
			  }
			 
			  return true;
			   
		 }catch(Exception $e){
			  $this->db->RollbackTrans();		   
			  $this->setError('error', $e->getCode(), $e->getMessage());
			  throw new Exception($e->getMessage() , $e->getCode());	
		}
	}
	
	
	
	/**
	 * getGroupFromEvent - Hace una consulta de los grupos que se encuentran en un evento
	 *
	 * @param integer evento - Clave del evento
	 * @param mixed array - parametros adicionales
	 * @param string rmode - forma en que regresara los datos
	 * @return boolean true si se elimino correctamente de lo contrario false
	 */
	public function getGroupFromEvent($evento, $params=array(),$rmode='')
	{
	     try 
		 {
		      $start = $params['start'] ? $params['start']  : 0;
		      $limit = $params['limit'] ? $params['limit']  : 20;
			  
			  $bs = "
			  SELECT invi_grupo , COUNT(invi_grupo) numgrupo
			    FROM invitados
			   WHERE invi_evento ='$evento'					      
			  ";
			  if(strlen($params['grupo'])>0) {$bs.=" AND invi_grupo = '".$params['grupo']."'";}
			  $bs.="  GROUP BY invi_grupo ";
			 
			  $sql="
			  SELECT SQL_CALC_FOUND_ROWS
			         g.id_grup AS clave, CONCAT(g.d_grupo, ' (',i.numgrupo,')') AS descrip
			    FROM (
					     $bs        
				     ) i, cat_grupos g    
			   WHERE i.invi_grupo = g.id_grup ";
			   			  
			  if(strlen($params['ngrupo']) >0) { $sql.=" AND g.d_grupo LIKE '%".$params['ngrupo']."%'";  }
			  
			  $sql.=" ORDER BY g.d_grupo";
			  
			  
			  $rs   = $this->db->SelectLimit($sql, $limit, $start);
			  $tt   = $this->db->GetOne("SELECT FOUND_ROWS(); ");	
			  $rows[] = array('clave'=>'%', 'descrip'=>'TODOS');
			  
			  while($row = $rs->FetchRow() ){
			        $rows[] = $row;
			  }
			  			  
			  //fijamos el response
			  $response = array("success" => true, "total" => $tt, "rows"=> $rows);
			  $this->setResponse($response);			 
			 
		      return $rows;
			   
		 }catch(Exception $e){	   
			  $this->setError('error', $e->getCode(), $e->getMessage());
			  throw new Exception($e->getMessage() , $e->getCode());	
		}
	}
	
	/**
	 * getDepenFromEvent - Hace una consulta de las diferentes dependencias que participan en un evento
	 *
	 * @param integer evento - Clave del evento
	 * @param mixed array - parametros adicionales
	 * @param string rmode - forma en que regresara los datos
	 * @return boolean true si se elimino correctamente de lo contrario false
	 */
	public function getDepenFromEvent($evento, $params,$rmode='')
	{
	     try 
		 {
		      $start = $params['start'] ? $params['start']  : 0;
		      $limit = $params['limit'] ? $params['limit']  : 20;
			  
			  $bs = "
			  SELECT invi_dependencia , COUNT(invi_dependencia) num
				FROM invitados
			   WHERE invi_evento ='$evento'			   
			  ";
			  
			  if(strlen($params['grupo']) > 0){ $bs.=" AND invi_grupo = '".$params['grupo']."'"; }
			  $bs.=" GROUP BY invi_dependencia ";
			  
			  $sql="
			  SELECT depe_dependencia AS clave, 
			         depe_nombre      AS descrip,
					 depe_nombre      AS dependencia,
					 num              AS num
			    FROM (
					   $bs
				     ) i, cat_dependencias       
			   WHERE i.invi_dependencia = depe_dependencia 
			   ORDER BY depe_nombre";
			  
			  
			  $rs   = $this->db->SelectLimit($sql, $limit, $start);
			  $tt   = $this->db->GetOne("SELECT FOUND_ROWS(); ");	
			  $rows[] = array('clave'=>'%', 'descrip'=>'TODOS');
			  
			  while($row = $rs->FetchRow() ){
			        $rows[] = $row;
			  }
			  
			  //fijamos el response
			  $response = array("success" => true, "total" => $tt, "rows"=> $rows);
			  $this->setResponse($response);			 
			 
		      return $rows;
			   
		 }catch(Exception $e){	   
			  $this->setError('error', $e->getCode(), $e->getMessage());
			  throw new Exception($e->getMessage() , $e->getCode());	
		}
	}
	
	
	/**
	 * getLiderazgoFromEvent - Hace una consulta de los tipos de liderazgo que se encuentran en un evento
	 *
	 * @param integer evento - Clave del evento
	 * @param mixed array - parametros adicionales
	 * @param string rmode - forma en que regresara los datos
	 * @return boolean true si se elimino correctamente de lo contrario false
	 */
	public function getLiderazgoFromEvent($evento, $filter = array(), $rmode='array')
	{
	     try 
		 {
		      $start = $filter['start'] ? $filter['start']  : 0;
		      $limit = $filter['limit'] ? $filter['limit']  : 20;
			  
			  $bs = "
			  SELECT invi_invitado     AS invi_invitado,
				     invi_evento       AS invi_evento  , 
				     invi_persona      AS invi_persona ,
					 p.pers_tel_dep    AS pers_dtel, 
					 p.pers_ext_dep    AS pers_dext,
					 p.pers_email_dep  AS pers_demail,
					 CONCAT_WS(' ', p.pers_nombre, p.pers_apat, p.pers_amat) invi_npersona, 
					 invi_jerarquia    AS invi_jerarquia, 
					 ( SELECT nom_jerarquia FROM cat_jerarquias WHERE id_jerarquia = i.invi_jerarquia) AS invi_njerarquia,  
					 invi_tgrupo       AS invi_tgrupo  , 
					 invi_grupo        AS invi_grupo   ,
					 invi_dependencia  AS invi_dependencia,
					 vp.pers_cargo     AS invi_cargo , 
					 vp.pers_municipio AS invi_municipio,
					 vp.pers_ciudad    AS invi_ciudad
			    FROM invitados i, vpersonas vp , personas p
			   WHERE invi_persona = vp.pers_persona 
				 AND invi_grupo        = vp.pers_grupo
				 AND invi_dependencia  = vp.pers_dependencia   
				 AND invi_persona      = p.pers_persona 
				 AND invi_evento       = '$evento'				      
			  ";
			  if(strlen($filter['grupo'])    > 0)  { $bs.=" AND i.invi_grupo       LIKE ('".$filter['grupo']."')"; }
			  if(strlen($filter['depen'])    > 0)  { $bs.=" AND i.invi_dependencia LIKE ('".$filter['depen']."')"; }
			  if(strlen($filter['liderazgo'] > 0)) { $bs.=" AND p.pers_liderazgo  = '".$filter['liderazgo']."'";}
			  
			  if(strlen($filter['group'])> 0 )   { 
			     $bs.= " GROUP BY ".$filter['group']; 
			  }
			 
			  if(strlen($filter['orderby'])> 0 )   { 
			     $bs.=" ORDER BY ".$filter['orderby'];
			  }
			 
			   
			  $sql="
			  SELECT SQL_CALC_FOUND_ROWS
			         i.*,
					 get_grupName(invi_grupo)   AS invi_ngrupo,
					 get_depeName(invi_dependencia) AS invi_ndependencia
			    FROM ( 
				       $bs
                     ) i 
			   WHERE 1 = 1 ";
			   
			  
			  $rs   = $this->db->SelectLimit($sql, $limit, $start);
			  $tt   = $this->db->GetOne("SELECT FOUND_ROWS(); ");	
			  
			  if ($rmode == 'response'){
				  $rows  = $rs->GetAll();
				  $response = array('success'=>true,'total'=>$tt, 'rows'=>$rows, 'sql'=>$sql);
				  unset($rows);
				  $this->setResponse($response);
				  $rs->Close();
				  
			  }elseif($rmode == 'array'){
			      $rows = $rs->GetAll();
				  $rs->Close();
				  return $rows;
			  }elseif($rmode == 'rs'){
			      return  $rs;
			  }
			 
			  return true;
			   
		 }catch(Exception $e){	   
			  $this->setError('error', $e->getCode(), $e->getMessage());
			  throw new Exception($e->getMessage() , $e->getCode());	
		}
	}
	
	
	
	/**
	 * getNotificados - Obtiene la lista de invitados y sus correspondientes notificaciones
	 *
	 * @param integer event
	 * @param mixed array de filtros
	 * @param string rmode forma que deben de regresarse los datos
	 * @return mixed
	 */
	public function getNotificados($event, $filter, $rmode){
	    try
		{    if(!$rmode) return false;
		     
			 $start = $filter['start'] ? $filter['start']  : 0;
		     $limit = $filter['limit'] ? $filter['limit']  : 20;
			 
			 $sql="			    
			 SELECT SQL_CALC_FOUND_ROWS
			        noti_id, i.noti_evento, i.noti_invitado, i.noti_persona, i.noti_npersona,				   
				   i.noti_grupo,
				   i.noti_jerarquia,
				   ( SELECT nom_jerarquia FROM cat_jerarquias WHERE id_jerarquia = i.noti_jerarquia) AS noti_njerarquia,       
				   i.noti_dependencia,
				   #gd.noti_ngrupo noti_ngrupo,       				   
				   #gd.noti_ndependencia AS noti_ndependencia,				   
				   get_grupName(noti_grupo)       AS noti_ngrupo,
				   get_depeName(noti_dependencia) AS noti_ndependencia,               
				   i.noti_cargo , 
				   i.noti_referencia, 
				   CASE i.noti_notificado 
				        WHEN 'S' THEN 'true'
						WHEN 'N' THEN 'false'
				   END AS noti_notificado,
				   i.noti_recibio, 
				   CASE i.noti_recibio 
				        WHEN 'S' THEN 'SI'
						WHEN 'N' THEN 'NO'
				   END AS noti_nrecibio,
				   i.noti_motivo       
			  FROM ( 
					 SELECT noti_id          AS noti_id,
					        invi_invitado    AS noti_invitado,
							invi_evento      AS noti_evento,
							invi_persona     AS noti_persona,
							( SELECT CONCAT_WS(' ', pers_nombre, pers_apat,pers_amat) FROM personas WHERE pers_persona = noti_persona) AS noti_npersona, 
							invi_tgrupo      AS noti_tgrupo,       
							invi_grupo       AS noti_grupo ,
							invi_jerarquia   AS noti_jerarquia,
							invi_dependencia AS noti_dependencia,                
							invi_cargo       AS noti_cargo ,
							invi_referencia  AS noti_referencia,
							noti_notificado  AS noti_notificado,
							noti_recibio     AS noti_recibio ,
							noti_motivo      AS noti_motivo  
					   FROM invitados, inotificacion  
					  WHERE invi_invitado = noti_invitado 
						AND invi_evento   = '$event'        
				  ) i 
				    #, (
					# SELECT gp.id_grup       AS noti_grupo, 
					#		gp.d_grupo       AS noti_ngrupo,
					#		de.depe_dependencia AS noti_dependencia, 
					#		de.depe_nombre   AS noti_ndependencia
					#   FROM cat_grupos gp , cat_dependencias de
					#  WHERE gp.id_grup  = de.depe_grupo
				    # ) gd
			 WHERE 1 = 1
			   # gd.noti_grupo = i.noti_grupo AND gd.noti_dependencia = i.noti_dependencia 
			   
			 ";
			 
			 if(strlen($filter['id'])       >0){ $sql.=" AND i.noti_id  = '".$filter['id']."'"; }
			 if(strlen($filter['invitado']) >0){ $sql.=" AND i.noti_invitado  = '".$filter['invitado']."'"; }
			 if(strlen($filter['notifica']) >0){ $sql.=" AND i.noti_notifica  = '".$filter['notifica']."'"; }
			 if(strlen($filter['grupo'])    >0){ $sql.=" AND noti_grupo       LIKE ('".$filter['grupo']."')"; }
			 if(strlen($filter['depen'])    >0){ $sql.=" AND noti_dependencia LIKE ('".$filter['depen']."')"; }
			 if(strlen($filter['npersona']) >0){ $sql.=" AND noti_npersona LIKE ('%".$filter['npersona']."%')"; }
			 $sql.=" ORDER BY noti_ngrupo, noti_ndependencia , noti_jerarquia ASC , noti_npersona ASC";
			 
			 error_log($sql);
			 $rs    = $this->db->SelectLimit($sql, $limit, $start);
			 $tt    = $this->db->GetOne("SELECT FOUND_ROWS(); ");
			 $rows  = $rs->GetAll();
			 $rs->Close();
			 
			
			 
			 
			 if ($rmode == 'response'){
				 $response = array('success'=>true, 'message' => 'Loaded data', 'rows'=>$rows,'total'=>$tt, 'sql'=>$sql);
				 $this->setResponse($response);
				 return true;
				 
			 }elseif($rmode == 'array'){
			     return $rows;
			 }
			 
			 return true;
			 
			 
		}catch(Exception $e){ 
		     $this->setError('error', $e->getCode(), $e->getMessage());
			 throw new Exception($e->getMessage() , $e->getCode());			  
		}
	}
	
	
	/**
	 * updateNotificados - Actualiza un registro de la tabla de notificaciones
	 *
	 * @param int $id - Clave del registro (notificados.noti_notificado)
	 * @param mixed $data - registro completo con los datos
	 * @param mixed $rmode - forma de regresar el resultado
	 * @return string message de confirmacion
	 */
	public function updateNotificado($data,$rmode)
	{
	    try 
		 {   		  
			  //contiene los datos de los invitados
			  $str  = utf8_encode_array($data['rows']);
			  $rs   = $this->json_decode($str);	//para que pueda hacer la codificacion correctamente. Solo funciona con UTF-8	  
			  if(!$rs){ throw new Exception("Error decoding JSON String: $str",20001);}
			  
			  //cuando se envia un solo registro lo devuelve como un solo arreglo.
			  if($rs['noti_id']){
			     $temp = $rs;
				 $rs  = array();
				 $rs[] = $temp;
			  }		
			  
			  $ds   = utf8_decode_array($rs); //decodificamos el array 
			  
			  $this->db->StartTrans();
			  $nrows = count($ds);
			  //NUMERO DE REGISTROS QUE SE ENVIAS
			  for($i=0; $i < $nrows;  $i++){
			      $id = $ds[$i]['noti_id'];			  
			      if(strlen($id)==0){ throw new Exception("El ID proporcionado es incorrecto. Por favor de verificar",20003);}
			      
				  $evento     = $ds[$i]['noti_evento'];
				  $recibio    = substr($ds[$i]['noti_nrecibio'],0,1); //<-- el valor que despliega SI, NO
				  $motivo     = $ds[$i]['noti_motivo'];			  
			  
			      if($recibio == 'S' || $recibio=='N'){
			         $notificado = 'S';
			      }elseif(!$ds[$i]['noti_notificado']){
			         $notificado = $ds[$i]['noti_notificado']  === true ? 'S' : 'N';	
			      }
				  
				  $sql = "
				  UPDATE inotificacion
			         SET noti_notificado  = '".$notificado."',
					     noti_recibio     = '".$recibio."',
					     noti_motivo      = '".$motivo."'
			       WHERE noti_id          = '$id';
			      ";		  
			      $this->db->Execute($sql);
				  
				  //recuperamos como quedo el registro despues de la modificacion
				  if($nrows==1){
				     $rows = $this->getNotificados($evento, array('id'=>$id), 'array');
				  }else {
				     $rows[] = $this->getNotificados($evento, array('id'=>$id), 'array');
				  }
			  }
			  $this->db->CompleteTrans();
			  			  
			  //fijamos el response
			  $response = array('success'=>true,'message'=>"Se han agregado (<b>$new</b>) invitados al evento con clave <b>$evento</b>", 'rows'=>$rows);
			  $this->setResponse($response);
			  
			  return true;
			   
		 }catch(Exception $e){
			  $this->db->RollbackTrans();		   
			  $this->setError('error', $e->getCode(), $e->getMessage());
			  throw new Exception($e->getMessage() , $e->getCode());	
		}
	}

	
	

	/**
	 * addInvitados - recibe un array de registros que se agregaran como invitados, si esta marcado se agrega de lo contrario se borra
	 *
	 * @param mixed array contiene toda la informacion
	 * @return string message de confirmacion
	 */
	public function addInvitados($data)
	{
	    try 
		 {    //debe recibir un array de la siguiente forma
		      /* Array (
                     [pers_persona] => 593
					 [pers_npersona] => JOS?LUIS JONATHAN YONG MENDOZA
					 [isinvited] => 
					 [pers_tgrupo] => P
					 [pers_grupo] => 88
					 [pers_referencia] => 593
					 [pers_jerarquia] => 3
					 [pers_dependencia] => 102
					 [pers_cargo] => DIRECTOR DE CONSIGNACI? TRAMITE ZONA NORTE DE LA PROCURADUR? GENERAL DE JUSTICIA DEL ESTADO
			  )*/

		 
		 
		      $evento = $data['evento'];			  
			  if(strlen($evento)==0){ throw new Exception("Debes de proporcionar el evento al que se agregaran los invitados",20003);}
			 		 
			  //contiene los datos de los invitados
			  $str  = utf8_encode($data['rs_invitados']);
			  $rs   = $this->json_decode($str);	//para que pueda hacer la codificacion correctamente. Solo funciona con UTF-8	  
			  			  
			  if(!$rs){ throw new Exception("Error decoding JSON String: $str",20001);}
			  $rs  = utf8_decode_array($rs); //decodificamos el array 			  
			  
			  if($rs['pers_persona']){ //solo 1 registro se envio
			    $tmp = $rs;
				$rs  = array();
				$rs[] = $tmp;
			  }
			  
			  //throw new Exception('<pre>'.print_r($rs,true),20001);
			  $this->db->StartTrans();			  
			  $new=0; $deleted=0;
			  for($i=0; $i< count($rs); $i++){
			      $row = $rs[$i];
				  $persona = $row['pers_persona'];
				  
				  //verificamos si es que la persona ya se encuenta o no en la tabla de invitados
				  $sql       = "SELECT COUNT(*) FROM invitados WHERE invi_evento='$evento' AND invi_persona='$persona'";
				  $cnt       = $this->db->GetOne($sql);
				  $isInvited = $cnt > 0 ? 'S' : 'N';
					 
				  //verificamos si esta marcado o desmarcado
				  if($row['isinvited']==false){ 
				     if($isInvited == 'S') {
					    $this->deleteInvitado($evento, $row);
					    $deleted++;
					 }
				  }else {
				     //verifica si no se encuentra en la tabla de invitados	e inserta un registro nuevo
				     if($isInvited == 'N'){
				        $this->addInvitado($evento, $row);
					    $new++;
				     }
				  }
			  }		  
			 
			  $this->db->CompleteTrans();
			  
			  //fijamos el response
			  $response = array('success'=>true,'message'=>"Se han agregado (<b>$new</b>) invitados al evento con clave <b>$evento</b>");
			  $this->setResponse($response);
			  
			  return true;
			   
		 }catch(Exception $e){
			  $this->db->RollbackTrans();		   
			  $this->setError('error', $e->getCode(), $e->getMessage());
			  throw new Exception($e->getMessage() , $e->getCode());	
		}
	}
	
	/**
	 * addInvitado - Agrega un nuevo invitado al evento siempre y cuando no se encuentre
	 *
	 * @param integer evento - Id del evento donde se desea eliminar el contacto
	 * @param mixed   array persona array(isinvited,tgrupo,grupo,dependencia,municipio, ciudad,nombre)
	 * @return true
	 */
	public function addInvitado($evento, $rpersona){
	    try
		{     
		      $persona  = $rpersona['pers_persona'];
			  $jerarquia= $rpersona['pers_jerarquia'];
			  $tgrupo   = $rpersona['pers_tgrupo'];
			  $grupo    = $rpersona['pers_grupo'];
			  $depen    = $rpersona['pers_dependencia'];
			  $refer    = $rpersona['pers_referencia'];
			  $cargo    = $this->db->qstr($rpersona['pers_cargo']);
			  
			  //insertamos el registro del invitado
			  $sql = "
			  INSERT INTO invitados  (
			         invi_evento     ,
					 invi_persona    ,
					 invi_jerarquia  ,
					 invi_tgrupo     ,
					 invi_grupo      ,
					 invi_dependencia,
					 invi_cargo      ,
					 invi_referencia ,
					 invi_finsert    
			  ) VALUE (
			         '$evento'       ,
					 '$persona'      ,
					 '$jerarquia'    ,
					 '$tgrupo'       ,
					 '$grupo'        ,
					 '$depen'        ,
					 $cargo          ,
					 '$refer'        ,
					  now()					 
			  )";
			  $this->db->Execute($sql);
			  $invitado = $this->db->Insert_ID();
			  
			  //insertamos para su notificacion
			  $sql = "INSERT INTO inotificacion(noti_invitado) VALUE ('$invitado');";
			  $this->db->Execute($sql);
			  
			  //insertamos para el seguimiento
			  $sql = "INSERT INTO iconfirmacion(conf_invitado) VALUE ('$invitado');";
			  $this->db->Execute($sql);
			  
			  
			  
			  
			  return true;
			  
		}catch(Exception $e) {
		      $this->setError('error', $e->getCode(), $e->getMessage());
			  throw new Exception($e->getMessage() , $e->getCode());
		}
	}
	
	
	
	/**
	 * deleteInvitado - Elimina un invitado, recibe como parametro la informacion del contacto
	 *
	 * @param integer evento - Id del evento donde se desea eliminar el contacto
	 * @param mixed   array persona array(isinvited,tgrupo,grupo,dependencia,municipio, ciudad,nombre)
	 * @return true
	 */
	public function deleteInvitado($evento, $rpersona){
	    try
		{     
		      $persona = $rpersona['pers_persona'];
			  $tgrupo  = $rpersona['pers_tgrupo'];
			  $grupo   = $rpersona['pers_grupo'];
			  $refer   = $rpersona['pers_referencia'];
			  
			  $sql = "DELETE FROM invitados WHERE invi_evento='$evento' AND invi_persona='$persona'";
			  $this->db->Execute($sql);
			  
			  return true;
			  
		}catch(Exception $e) {
		      $this->setError('error', $e->getCode(), $e->getMessage());
			  throw new Exception($e->getMessage() , $e->getCode());
		}
	}
	
	
	/**
	 * getConfirmados - Obtiene la lista de invitados y sus correspondientes confirmaciones
	 *
	 * @param integer event
	 * @param mixed array de filtros
	 * @param string rmode forma que deben de regresarse los datos
	 * @return mixed
	 */
	public function getConfirmados($event, $filter, $rmode){
	    try
		{    if(!$rmode) return false;
		     
			 $start = $filter['start'] ? $filter['start']  : 0;
		     $limit = $filter['limit'] ? $filter['limit']  : 20;
			 
			 $sql="			    
			 SELECT SQL_CALC_FOUND_ROWS
					c.conf_id,
					c.conf_evento, c.conf_invitado, c.conf_persona, c.conf_npersona,
					c.conf_grupo,
					#gd.ngrupo  AS conf_ngrupo,       
					c.conf_jerarquia,
					( SELECT nom_jerarquia FROM cat_jerarquias WHERE id_jerarquia = c.conf_jerarquia) AS conf_njerarquia,       
					c.conf_dependencia,
					#gd.ndependencia AS conf_ndependencia,                  
					c.conf_cargo ,
					c.noti_recibio ,
					CASE c.conf_called 
						WHEN 'S' THEN 'true'
						WHEN 'N' THEN 'false'
						WHEN ''  THEN 'false'
					END AS conf_called,
					c.conf_confirmo, 
					CASE c.conf_confirmo 
						WHEN 'S' THEN 'SI'
						WHEN 'N' THEN 'NO'
					END AS conf_nconfirmo,
					c.conf_quien ,
					CASE c.conf_quien 
						WHEN 'N' THEN 'NO ASISTE'
						WHEN 'T' THEN 'TITULAR'
						WHEN 'S' THEN 'SUPLENTE'
					END AS conf_nquien,
					get_grupName(c.conf_grupo)       AS conf_ngrupo,
				    get_depeName(c.conf_dependencia) AS conf_ndependencia
			  FROM  ( 
					 SELECT invi_invitado     AS conf_invitado,
							invi_evento       AS conf_evento,
							invi_persona      AS conf_persona,
							( SELECT CONCAT_WS(' ', pers_nombre, pers_apat,pers_amat) FROM personas WHERE pers_persona = invi_persona) AS conf_npersona, 					
							invi_tgrupo       AS conf_tgrupo,       
							invi_grupo        AS conf_grupo ,
							invi_jerarquia    AS conf_jerarquia,
							invi_dependencia  AS conf_dependencia,                
							invi_cargo        AS conf_cargo ,
							noti_recibio      AS noti_recibio,
							conf_id           AS conf_id,
							conf_called       AS conf_called,
							conf_confirmo     AS conf_confirmo ,
							conf_quien        AS conf_quien  
					   FROM invitados, inotificacion, iconfirmacion
					  WHERE invi_invitado    = noti_invitado
						AND noti_invitado    = conf_invitado
						AND invi_evento      = '$event' 							   
				    ) c  
					#, (
					# SELECT gp.id_grup        AS grupo, 
					#		gp.d_grupo        AS ngrupo,
					#		depe_dependencia  AS dependencia, 
					#		de.depe_nombre    AS ndependencia
					#   FROM cat_grupos gp , cat_dependencias de
					#  WHERE gp.id_grup  = de.depe_grupo
				    # ) gd      
			  WHERE 1 = 1 
			        # gd.grupo        = c.conf_grupo AND gd.dependencia  = c.conf_dependencia 
			 ";
			 
			 if(strlen($filter['id'])>0){ $sql.=" AND c.conf_id  = '".$filter['id']."'"; }
			 if(strlen($filter['grupo'])    >0 ) { $sql.=" AND c.conf_grupo       LIKE ('".$filter['grupo']."')"; }
			 if(strlen($filter['depen'])    >0 ) { $sql.=" AND c.conf_dependencia LIKE ('".$filter['depen']."')"; }
			 
			 if(strlen($filter['invitado']) >0 ) { $sql.=" AND c.conf_invitado   = '".$filter['invitado']."'"; }
			 if(strlen($filter['recibio'])  >0 ) { $sql.=" AND c.noti_recibio    = '".$filter['recibio']."'"; }			 
			 if(strlen($filter['confirmo']) >0 ) { $sql.=" AND c.conf_confirmo   = '".$filter['confirmo']."'"; }
			 if(strlen($filter['quien'])    >0 ) { $sql.=" AND c.conf_quien      = '".$filter['quien']."'"; }			 
			 if(strlen($filter['npersona']) >0 ) { $sql.=" AND conf_npersona LIKE ('%".$filter['npersona']."%')"; }
			 
			 $sql.=" ORDER BY conf_ngrupo, conf_ndependencia , conf_jerarquia ASC , conf_npersona ASC";
			 
			
			 $rs    = $this->db->SelectLimit($sql, $limit, $start);
			 $tt    = $this->db->GetOne("SELECT FOUND_ROWS(); ");
			 $rows  = $rs->GetAll();
			 $rs->Close();
			 
			 if ($rmode == 'response'){
				 $response = array('success'=>true, 'message' => 'Loaded data', 'rows'=>$rows,'total'=>$tt, 'sql'=>$sql);
				 $this->setResponse($response);
				 return true;
				 
			 }elseif($rmode == 'array'){
			     return $rows;
			 }
			 
			 return true;
			 
			 
		}catch(Exception $e){ 
		     $this->setError('error', $e->getCode(), $e->getMessage());
			 throw new Exception($e->getMessage() , $e->getCode());			  
		}
	}
	
	
	
	/**
	 * updateNotificados - Actualiza un registro de la tabla de notificaciones
	 *
	 * @param int $id - Clave del registro (notificados.noti_notificado)
	 * @param mixed $data - registro completo con los datos
	 * @param mixed $rmode - forma de regresar el resultado
	 * @return string message de confirmacion
	 */
	public function updateConfirmado($data,$rmode)
	{
	    try 
		 {   		  
			  //contiene los datos de los invitados
			  $str  = utf8_encode_array($data['rows']);
			  $rs   = $this->json_decode($str);	//para que pueda hacer la codificacion correctamente. Solo funciona con UTF-8	  
			  if(!$rs){ throw new Exception("Error decoding JSON String: $str",20001);}
			  
			  //cuando se envia un solo registro lo devuelve como un solo arreglo.
			  if($rs['conf_id']){
			     $temp = $rs;
				 $rs  = array();
				 $rs[] = $temp;
			  }			  
			  $ds   = utf8_decode_array($rs); //decodificamos el array 
			 		   
			  $this->db->StartTrans();	
			  for($i=0; $i < count($ds); $i++){
			      
				  $id = $ds[$i]['conf_id'];
				  if(strlen($id)==0){ throw new Exception("El ID proporcionado es incorrecto. Por favor de verificar",20003);}  
			 
			      $evento     = $ds[$i]['conf_evento'];
				  $invitado   = $ds[$i]['conf_invitado'];
				  $confirmo   = substr($ds[$i]['conf_nconfirmo'],0,1); //<-- el valor que despliega SI, NO
				  $quien      = substr($ds[$i]['conf_nquien'],0,1); //<-- el valor que despliega SI, NO
				  $motivo     = $ds[$i]['conf_motivo'];
				  
				  if($confirmo == 'S' || $confirmo=='N'){
					 $called = 'S';
				  }elseif(!$ds[$i]['noti_notificado']){
			         $called = $ds[$i]['conf_called']  === true ? 'S' : 'N';	
			      }
				  
				  if($confirmo=='N'){  $quien='';  }
				  $sql = "
				  UPDATE iconfirmacion
				     SET conf_called   = '".$called."',
					     conf_confirmo = '".$confirmo."',
						 conf_quien    = '".$quien."',
						 conf_motivo   = ".$this->db->qstr($motivo)."
				   WHERE conf_id       = '".$id."'";
				  
				  $this->db->Execute($sql);
				  
				  //recuperamos como quedo el registro despues de la modificacion				  
				  if($nrows==1){
				     $rows = $this->getNotificados($evento, array('id'=>$id), 'array');
				  }else {
				     $rows[] = $this->getNotificados($evento, array('id'=>$id), 'array');
				  }
				  
			  }
			  
			  $this->db->CompleteTrans();
			   
			  //fijamos el response
			  $response = array('success'=>true,'message'=>"Se ha modificado correctamente el registro", 'rows'=>$rows);
			  $this->setResponse($response);
			  
			  return true;
			   
		 }catch(Exception $e){
			  $this->db->RollbackTrans();		   
			  $this->setError('error', $e->getCode(), $e->getMessage());
			  throw new Exception($e->getMessage() , $e->getCode());	
		}
	}
	
	
	
	/**
	 * getSegumiento - Obtiene la lista de invitados y sus correspondientes notificaciones y confirmaciones
	 *
	 * @param integer event
	 * @param mixed array de filtros
	 * @param string rmode forma que deben de regresarse los datos
	 * @return mixed
	 */
	public function getSeguimiento($event, $filter, $rmode){
	    try
		{    if(!$rmode) return false;
		     
			 $start = $filter['start'] ? $filter['start']  : 0;
		     $limit = $filter['limit'] ? $filter['limit']  : 20;
			 
			 $sql="			    
			 SELECT SQL_CALC_FOUND_ROWS
					e.*,
					#gd.ngrupo  AS even_ngrupo,       
					( SELECT nom_jerarquia FROM cat_jerarquias WHERE id_jerarquia = e.even_jerarquia) AS even_njerarquia,
					#gd.ndependencia AS even_ndependencia,
					e.noti_recibio ,
					CASE e.noti_recibio 
						WHEN 'S' THEN 'S'
						ELSE 'N'
					END AS noti_recibio,
					CASE e.conf_called 
						WHEN 'S' THEN 'S'
						ELSE 'N'
					END AS conf_called,
					CASE e.conf_confirmo 
						WHEN 'S' THEN 'S'
						ELSE 'N'
					END AS conf_confirmo,
					e.conf_quien ,
					CASE e.conf_quien 
						WHEN 'N' THEN 'NO ASISTE'
						WHEN 'T' THEN 'TITULAR'
						WHEN 'S' THEN 'SUPLENTE'
					END AS conf_nquien,					
					get_grupName(even_grupo)       AS even_ngrupo,
				    get_depeName(even_dependencia) AS even_ndependencia
					
			  FROM  ( 
					 SELECT invi_invitado     AS even_invitado,
							invi_evento       AS even_evento,
							invi_persona      AS even_persona,
							CONCAT_WS(' ', pers_nombre, pers_apat,pers_amat) AS even_npersona, 					
							p.pers_tel_dep    AS pers_dtel, 
					        p.pers_ext_dep    AS pers_dext,
					        p.pers_email_dep  AS pers_demail,
							invi_tgrupo       AS even_tgrupo,       
							invi_grupo        AS even_grupo ,
							invi_jerarquia    AS even_jerarquia,
							invi_dependencia  AS even_dependencia,                
							invi_cargo        AS even_cargo ,
							noti_notificado   AS noti_notificado,
							noti_recibio      AS noti_recibio,
							conf_called       AS conf_called,
							conf_confirmo     AS conf_confirmo ,
							conf_quien        AS conf_quien  
					   FROM personas p, invitados, inotificacion, iconfirmacion 
					  WHERE pers_persona     = invi_persona 
					    AND invi_invitado    = noti_invitado
						AND noti_invitado    = conf_invitado
						AND invi_evento      = '$event' 							   
				    ) e 
					#, (
					# SELECT gp.id_grup        AS grupo, 
					#		gp.d_grupo        AS ngrupo,
					#		depe_dependencia  AS dependencia, 
					#		de.depe_nombre    AS ndependencia
					#   FROM cat_grupos gp , cat_dependencias de
					#  WHERE gp.id_grup  = de.depe_grupo
				    #) gd      
			  WHERE 1 = 1 
			    # gd.grupo        = e.even_grupo AND gd.dependencia  = e.even_dependencia 
			 ";
			 
			 if(strlen($filter['invitado']) >0 ){ $sql.=" AND invi_invitado  = '".$filter['invitado']."'".chr(13); }			 	 
			 if(strlen($filter['grupo'])    >0 ){ $sql.=" AND even_grupo       LIKE ('".$filter['grupo']."')".chr(13); }
			 if(strlen($filter['depen'])    >0 ){ $sql.=" AND even_dependencia LIKE ('".$filter['depen']."')".chr(13); }			 
			 if(strlen($filter['recibio'])  >0 ){ $sql.=" AND noti_recibio   = '".$filter['recibio']."'".chr(13); }
			 if(strlen($filter['confirmo']) >0 ){ $sql.=" AND conf_confirmo  = '".$filter['confirmo']."'".chr(13); }
			 if(strlen($filter['cquien'])   >0 ){ $sql.=" AND conf_quien     = '".$filter['cquien']."'".chr(13); }		
			 if(strlen($filter['npersona']) >0 ){ $sql.=" AND conf_npersona  LIKE ('%".$filter['npersona']."%')".chr(13); }
			 
			 
			 if(strlen($filter['groupby'])> 0 )   { 
			     $sql.= " GROUP BY ".$filter['groupby'].chr(13); 
			  }
			 
			  if(strlen($filter['orderby'])> 0 )   { 
			     $sql.=" ORDER BY ".$filter['orderby'].chr(13);
			  }else{
			     $sql.=" ORDER BY even_ngrupo, even_ndependencia , even_jerarquia ASC , even_npersona ASC".chr(13);				 
			  }
			 
			 
			 $rs    = $this->db->SelectLimit($sql, $limit, $start);
			 $tt    = $this->db->GetOne("SELECT FOUND_ROWS(); ");
			 $rows  = $rs->GetAll();
			 $rs->Close();
			 
			 if ($rmode == 'response'){
				 $response = array('success'=>true, 'message' => 'Loaded data', 'rows'=>$rows,'total'=>$tt, 'sql'=>$sql);
				 $this->setResponse($response);
				 return true;
				 
			 }elseif($rmode == 'array'){
			     return $rows;
			 }
			 
			 return true;
			 
			 
		}catch(Exception $e){ 
		     $this->setError('error', $e->getCode(), $e->getMessage());
			 throw new Exception($e->getMessage() , $e->getCode());			  
		}
	}
	
	
	
	/**
	 * getRutas - Obtiene las rutas y dependencias de los invitados
	 *
	 * @param integer event
	 * @param mixed array de filtros
	 * @param string rmode forma que deben de regresarse los datos
	 * @return mixed
	 */
	public function getRutas($event, $filter, $rmode){
	    try
		{    if(!$rmode) return false;
		     
			 $start = $filter['start'] ? $filter['start']  : 0;
		     $limit = $filter['limit'] ? $filter['limit']  : 20;
			 
			 $sqlcnt = "
			 SELECT COUNT(*) 
			   FROM invitados
			  WHERE invi_evento = '$event'
			    AND invi_dependencia = i.invi_dependencia	    
			 "; 
			 if(strlen($filter['invitado'])>0)    { $sqlcnt.=" AND invi_invitado     = i.invi_invitado ";    }
			 if(strlen($filter['persona'])>0)     { $sqlcnt.=" AND invi_persona      = i.invi_persona ";    }
			 if(strlen($filter['dependencia'])>0) { $sqlcnt.=" AND invi_dependencia  = i.invi_dependencia "; }
			 if(strlen($filter['grupo'])>0)       { $sqlcnt.=" AND invi_grupo        = i.invi_grupo "; }
			 if(strlen($filter['jerarquia'])>0)   { $sqlcnt.=" AND invi_jerarquia    = i.invi_jerarquia "; }
			 
			 
					   
			 $sql="			    
			 SELECT depe_dependencia   AS depe_dependencia, 
					depe_nombre        AS depe_nombre, 
					depe_estado        AS depe_estado, 
					depe_municipio     AS depe_municipio, 
					depe_ciudad        AS depe_ciudad, 
					depe_tcalle        AS depe_tcalle, 
					depe_sufijo        AS depe_sufijo, 
					depe_calle         AS depe_calle, 
					depe_entre         AS depe_entre, 
					depe_y_entre       AS depe_y_entre, 
					depe_numero        AS depe_numero, 
					depe_manzana       AS depe_manzana, 
					depe_lote          AS depe_lote, 
					depe_colonia       AS depe_colonia, 
					depe_cp            AS depe_cp,
					depe_ruta          AS depe_ruta,
					CONCAT('RUTA ',depe_ruta) AS depe_nruta,
					( SELECT d_localidad FROM cat_localidad WHERE id_localidad = depe_ciudad) nciudad,
				    ( SELECT d_colonia FROM cat_colonias WHERE id_colonia = depe_colonia ) ncolonia  ,
				    ( SELECT nombre FROM cat_calles WHERE id_calle = depe_calle) ncalle	,
					get_depeAddress(depe_dependencia) AS depe_ndireccion,									
					i.invi_invitado    AS invi_invitado,
					i.invi_persona     AS invi_persona,
					i.invi_grupo       AS invi_grupo,
					i.invi_jerarquia   AS invi_jerarquia ,
					( $sqlcnt)         AS num
			   FROM invitados i, cat_dependencias  
			  WHERE invi_dependencia = depe_dependencia 
			    AND invi_evento = '$event'";
			 
			 if(strlen($filter['invitado'])>0)    { $sql.=" AND invi_invitado     = '".$filter['invitado']."'";    }
			 if(strlen($filter['persona'])>0)     { $sql.=" AND invi_persona      = '".$filter['persona']."'";    }
			 if(strlen($filter['dependencia'])>0) { $sql.=" AND depe_dependencia  = '".$filter['dependencia']."'"; }
			 if(strlen($filter['ndependencia'])>0){ $sql.=" AND depe_nombre       LIKE '%".$filter['ndependencia']."%'"; }
			 if(strlen($filter['grupo'])>0)       { $sql.=" AND invi_grupo        = '".$filter['grupo']."'"; }
			 if(strlen($filter['ruta'])>0)        { $sql.=" AND depe_ruta         = '".$filter['ruta']."'"; }
			 
			 
			 if(strlen($filter['group'])> 0 )   { 
			    $sql.= " GROUP BY ".$filter['group']; 
			 }
			 
			 if(strlen($filter['orderby'])> 0 )   { 
			    $sql.=" ORDER BY ".$filter['orderby'];
			 }else {
				$sql.=" ORDER BY depe_ruta, depe_nombre";
			 }
			 
			 $rs    = $this->db->SelectLimit($sql, $limit, $start);
			 $tt    = $this->db->GetOne("SELECT FOUND_ROWS(); ");
			 
			 
			 if ($rmode == 'response'){
				 $rows  = $rs->GetAll();
				 $rs->Close();
				 $response = array('success'=>true, 'message' => 'Loaded data', 'rows'=>$rows,'total'=>$tt, 'sql'=>$sql);
				 $this->setResponse($response);
				 return true;
				 
			 }elseif($rmode == 'array'){
			     $rows  = $rs->GetAll();
				 $rs->Close();
				 return $rows;
				 
			 }elseif($rmode=='rs'){
				 return $rs;
				 
			 }
			 
			 return true;
			 
			 
		}catch(Exception $e){ 
		     $this->setError('error', $e->getCode(), $e->getMessage());
			 throw new Exception($e->getMessage() , $e->getCode());			  
		}
	}
	
	
	public function getStatics($evento){
	    $statics = array();
		//grupos invitados
	    $sql = "
	    SELECT *
          FROM invitados 
         WHERE invi_evento = '$evento'
         GROUP BY invi_grupo    
	    ";
	    $rs = $this->db->Execute($sql);
	    $statics['ngrupos'] = $rs->RowCount();
		
	
		//personas invitadas al evento
		$sql="SELECT COUNT(*) cnt FROM invitados WHERE invi_evento = '$evento'";
		$statics['ninvitados'] = $this->db->GetOne($sql);
	
		//invitaciones entregadas
		$sql = "
		SELECT COUNT(*) cnt
		  FROM invitados, inotificacion  
		 WHERE invi_invitado = noti_invitado 
		   AND invi_evento  = '$evento'   
		   AND noti_recibio = 'S';
		";
		$statics['nentregadas'] = $this->db->GetOne($sql);
	
		//personas confirmadas
		$sql="
		SELECT COUNT(*) cnt
		  FROM invitados, inotificacion, iconfirmacion  
		 WHERE invi_invitado = noti_invitado
		   AND invi_invitado = conf_invitado 
		   AND invi_evento   = '$evento'
		   AND noti_recibio  = 'S'
		   AND conf_confirmo = 'S'; 
		";
		$statics['nconfirmados'] = $this->db->GetOne($sql);
	
		//titulares que asisten
		$sql="
		SELECT COUNT(*) cnt
		  FROM invitados, inotificacion, iconfirmacion 
		 WHERE invi_invitado = noti_invitado
		   AND invi_invitado = conf_invitado 
		   AND invi_evento   = '$evento'
		   AND noti_recibio  = 'S'
		   AND conf_confirmo = 'S'
		   AND conf_quien    = 'T' 
		";
		$statics['ntitulares'] = $this->db->GetOne($sql);
	
		//suplentes
		$sql = "
		SELECT COUNT(*) cnt
		  FROM invitados, inotificacion, iconfirmacion 
		 WHERE invi_invitado = noti_invitado
		   AND invi_invitado = conf_invitado 
		   AND invi_evento   = '$evento'  
		   AND conf_confirmo = 'S'
		   AND conf_quien    = 'S' 
		";	
		$statics['nsuplentes'] = $this->db->GetOne($sql);
	
		//no asisten
		$sql ="
		SELECT COUNT(*)
		  FROM invitados, inotificacion, iconfirmacion 
		 WHERE invi_invitado = noti_invitado
		   AND invi_invitado = conf_invitado 
		   AND invi_evento   = '$evento'  
		   AND conf_confirmo = 'S'
		   AND conf_quien    = 'N'
		";
		$statics['nnoasisten']  = $this->db->GetOne($sql);
	
	
		//por liderazgo
		$sql = "
		SELECT pers_liderazgo, COUNT(*) cnt
		  FROM invitados, personas  
		 WHERE invi_persona = pers_persona
		   AND invi_evento  = '$evento' 
		 GROUP BY pers_liderazgo
		";	
		$rs = $this->db->Execute($sql);
		$statics['rliderasgo'] = $rs->GetAll();
		
		return $statics;
	
	}
	
	/**
	 * saveTemplate - Guarda la plantilla
	 *
	 * @param mixed array $data - informacion que se guarda en la plantilla
	 * @return boolean true if all ok
	 */
	public function saveTemplate($data, $evento)
	{
	    try 
		 {   
		      $sql = "SELECT COUNT(*) FROM template WHERE temp_evento='$evento'";
			  $cnt = $this->db->GetOne($sql);
			  
			  
			  $html = urldecode($data['html']);
			  
			  //$html = $this->db->qstr($html);
			  if( $cnt == 0){
		          $sql = "
			      INSERT INTO template   (
				         temp_evento     ,
						 temp_template   ,
						 temp_finsert    
				  ) VALUE (
			             '$evento'       ,
						 '".$html."'     ,
						 now()           
			      )";
			  }else {
				  $sql = "
				  UPDATE template
				     SET temp_template = '".$html."',
					     temp_fupdate  = now()
				   WHERE temp_evento   = '$evento'";					  
			  }
			  
			  $this->db->Execute($sql);
			  
			  $response = array('success'=>true, 'message' => 'Plantilla guardad', 'sql'=>$sql);
			  return $response;
			  
			   
		 }catch(Exception $e){
			  $this->db->RollbackTrans();		   
			  $this->setError('error', $e->getCode(), $e->getMessage());
			  throw new Exception($e->getMessage() , $e->getCode());	
		}
	}
	
	public function setResponse($array){	    
		$this->response = $array;
	}
	
	/**
	 * getResponse - Regresa un array con los resultados principales de una transaccion
	 * ejemplo : array('success'=> true, 'message'=>'Mensaje', etc). Se puede usar para respuesta del servidor
	 * @return mixed array
	 */
	public function getResponse(){
	    return $this->response;
	}
	
	
	
	
	
	
}
