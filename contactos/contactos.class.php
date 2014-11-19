<?PHP


class Contacto {
      
	private $db;
	private $errors = array();
	
   /**
    * Constructor function. Arguments:
    * $params - An assoc array of parameters:
    * 
    */
	public function __construct($db) {
        $args = func_get_args();		
		$this->db = $db;
    }
	
	
	
	public function verifiGroupDependency( $grupo, $dependencia) {
        	
		try 
		{   
		    #si el ID de la dependencia y es NO DISPONIBLE, solo valida el grupo y la dependencia por separado
			if($dependencia == 511 ){
			   //valido el grupo
			   $sql = "SELECT COUNT(*) FROM cat_grupos WHERE id_grup = '".$grupo."'";
			   $cnt = $this->db->GetOne($sql);
			   
			   
			   if($cnt==0) return false;
			   
			   //valido la dependencia
			   $sql = "SELECT COUNT(*) FROM cat_dependencias WHERE depe_dependencia = '$dependencia'";
			   $cnt = $this->db->GetOne($sql);
			   
			   if($cnt==0) return false;
				
			}else {
			
				#verificamos que la dependencia que eligio, realmente sea del grupo seleccionado
				$sql = "
				SELECT COUNT(*) cnt
				  FROM cat_grupos gp , cat_dependencias de
				 WHERE gp.id_grup   = de.depe_grupo
				   AND gp.id_grup       =  '$grupo'
				   AND depe_dependencia =  '$dependencia'
				";
			    
				
				
			    $cnt = $this->db->GetOne($sql);
			}
			
			if($cnt == 0){
			   return false;
			}
			
			return true;
			
		}catch(Exception $e){			
			return false;
		}				
    }
	
	
   /**
    * $params - $_POST
	* Guarda un nuevo registro en la base de datos de contactos
    */	
    public function save( $data) {
        	
		try 
		{   
		    //nombre
			$nombre = $data['pers_nombre'].' '.$data['pers_apat'].' '.$data['pers_amat'];
			$grupo  = $data['pers_dep_grupo_id'];
			$depen  = $data['pers_dependencia_id'];
		
		    //vericamos que el nombre no exista mas de dos veces
			$sql="
			SELECT COUNT(*) cnt
			  FROM personas 
			 WHERE TRIM(pers_nombre) = '".strtoupper(trim($data['pers_nombre']))."'
			   AND TRIM(pers_apat)   = '".strtoupper(trim($data['pers_apat']))."'
			   AND TRIM(pers_amat)   = '".strtoupper(trim($data['pers_amat']))."'";
			
			$cnt = $this->db->GetOne($sql);
			if($cnt > 0){ throw new Exception("El nombre $nombre. Ya existe en la base de datos", 20001); }
			
		    
			//algunas validaciones
			if(strlen($data['pers_nombre']) == 0){ throw new Exception("Debes de escribir el nombre de la persona", 20001); }
			if(strlen($data['pers_apat']) == 0){ throw new Exception("Debes de escribir el Apellido de la persona", 20001); }
			if(strlen($data['pers_sexo']) == 0){ throw new Exception("Debes de seleccionar el sexo de la persona", 20001); }
			
			$sql = "SELECT COUNT(*) cnt FROM cat_titulos WHERE id_titulos = '".$data['pers_titulo_id']."'";
			$cnt = $this->db->GetOne($sql);
			if($cnt == 0){ throw new Exception("El nombre del titulo que proporciono, no coincide con ninguno del catalogo. Por favor seleccione uno de la lista que se despliega", 20001); }
			
			
			//validamos que exista el tipo de calle selccionado
			if(strlen($data['pers_tcalle_id']) > 0 ) {
			   $sql = "SELECT COUNT(*) FROM  cat_clase_calle WHERE id_clase_calle = '".$data['pers_tcalle_id']."'";
			   $cnt = $this->db->GetOne($sql);
			   if($cnt == 0){ throw new Exception("El tipo de calle que proporciono, no coincide con ninguno del catalogo. Por seleccione uno de la lista desplegable", 20001); }
			}
			
			//validamos que exista la calle en el catalogo
			if(strlen($data['pers__calle_id']) > 0 ) {
			   $sql = "SELECT COUNT(*) FROM  cat_calles WHERE id_calle = '".$data['pers__calle_id']."'";
			   $cnt = $this->db->GetOne($sql);
			   if($cnt == 0){ throw new Exception("El nombre de la calle que proporciono, no existe en el catalogo. Por seleccione uno de la lista desplegable", 20001); }
			}
			
			//validamos que la colonia que proporciono exista en el catalogo
			if(strlen($data['pers_colonia_id']) > 0 ) {
			   $sql = "SELECT COUNT(*) FROM cat_colonias WHERE id_colonia = '".$data['pers_colonia_id']."'";
			   $cnt = $this->db->GetOne($sql);
			   if($cnt == 0){ throw new Exception("El nombre de la colonia que proporciono, no coincide con ninguno del catalogo. Por favor revice de nuevo", 20001); }
			}
			
			$sql = "SELECT COUNT(*) FROM cat_grupos WHERE id_grup = '".$data['pers_dep_grupo_id']."'";
			$cnt = $this->db->GetOne($sql);
			if($cnt == 0){ throw new Exception("El nombre del grupo que proporciono, no coincide con ninguno del catalogo. Por favor revice de nuevo", 20001); }
			
			$sql = "SELECT COUNT(*) cnt FROM cat_dependencias WHERE depe_dependencia = '".$data['pers_dependencia_id']."'";
			$cnt = $this->db->GetOne($sql);
			if($cnt == 0){ throw new Exception("El nombre de la dependencia que se proporciono, no coincide con ninguna del catalogo. Por favor revice de nuevo", 20001); }
			
			
			if(!$this->verifiGroupDependency($grupo, $depen)){
			   throw new Exception("La dependencia que elegiste no pertenece al grupo seleccionado, por favor verifica la información", 20001);
			}
			
			/* se manejo como Y/m/d en varchar(10), ya que muchas veces no cuentan con el año de nacimiento solo dia y mes*/
			$fnace         = $data['pers_fnanio'].'/'.$data['pers_fnmes'].'/'.$data['pers_fndia'];			
			$aniv_boda     = "/".$data['pers_mes_aniv'].'/'.$data['pers_dia_aniv'];			
			$fcumplesposa  = $data['pers_fanio_esposa'].'/'.$data['pers_fmes_esposa'].'/'.$data['pers_fdia_esposa'];
			
			
			$diamujer = $data['pers_invi_dm']      ? 'S' : 'N';
			$diamaest = $data['pers_invi_maestra'] ? 'S' : 'N';
			$votofeme = $data['pers_invi_avf']     ? 'S' : 'N';
			$eliviole = $data['pers_invi_dievcm']  ? 'S' : 'N';
			
			
			
			$data['pers_telefono']    = str_replace(array(' ','(',')','-'),'',$data['pers_telefono']);
			$data['pers_celular']     = str_replace(array(' ','(',')','-'),'',$data['pers_celular']);
			$data['pers_dep_tel']     = str_replace(array(' ','(',')','-'),'',$data['pers_dep_tel']);
			$data['pers_dep_tel2']    = str_replace(array(' ','(',')','-'),'',$data['pers_dep_tel2']);
			$data['pers_name_esposa'] = strtoupper($data['pers_name_esposa']);
			
			if(strlen($_SESSION['id_usuario'])==0){
			   throw new Exception("Session no valida. No puede guardar información del contacto, hasta que inicie una session valida.",20001);
			}
			
			
		    $this->db->StartTrans();
		
		    $sql = "
		     INSERT INTO personas  (
			        pers_titulo    , 
					pers_nombre     ,   pers_apat          ,	pers_amat      ,
					pers_sexo       ,   pers_fnac          ,	pers_celular   ,
					pers_telefono   ,   pers_nextel        ,    pers_email     ,
					pers_web        ,	pers_colonia   ,
					pers_cp         ,   pers_tcalle        ,	pers_calle     ,
					pers_sufijo     ,   pers_numero        ,	pers_lote      ,
					pers_manzana    ,   pers_refdomicilio  ,    pers_aniversarioboda  ,
					pers_esposa     ,	pers_cumple_esposa ,	
					pers_invi_dm    ,   pers_invi_maestra  ,	pers_invi_avf   ,	pers_invi_dievcm, 
					pers_observaciones ,	
					pers_grupo      ,   pers_dependencia   ,    pers_cargo     , 
					pers_jerarquia  ,   pers_liderazgo     ,    pers_tel_dep   ,   
					pers_ext_dep   ,
					pers_ext_priv_dep,  pers_tel2_dep      ,    pers_fax_dep   ,
					pers_fax_ext_dep,   pers_email_dep     ,    
					pers_insert     ,	pers_activo        ,	
					pers_usuario
			 ) VALUES (
			       '".$data['pers_titulo_id']."'     ,
				   '".strtoupper($data['pers_nombre'])."'  ,   '".strtoupper($data['pers_apat'])."',  '".strtoupper($data['pers_amat'])."',
				   '".$data['pers_sexo']."'          , '".$fnace."', '".$data['pers_celular']."',
				   '".$data['pers_telefono']."'      , '".$data['pers_nextel']."', '".$data['pers_email']."', 
				   '".$data['pers_web']."'           , '".$data['pers_colonia_id']."',
				   '".$data['pers_cp']."'            , '".$data['pers_tcalle_id']."',  '".$data['pers_calle_id']."',
				   '".$data['pers_sufijo']."'        , '".$data['pers_numero']."',  '".$data['pers_lote']."',
				   '".$data['pers_manzana']."'       , '".$data['pers_refdomi']."',  '".$aniv_boda."',
				   '".$data['pers_name_esposa']."'   , '".$fcumplesposa."', 
				   '".$diamujer."', '".$diamaest."', '".$votofeme."',  '".$eliviole."',
				   '".$data['pers_observa']."',  
				   '".$data['pers_dep_grupo_id']."'  , '".$data['pers_dependencia_id']."' , '".strtoupper($data['pers_cargo'])."' ,
				   '".$data['pers_dep_jerarquia']."' , '".$data['pers_liderazgo']."', '".$data['pers_dep_tel']."' , 
				   '".$data['pers_dep_ext']."' ,
				   '".$data['pers_dep_ext_priv']."'  , '".$data['pers_dep_tel2']."' , '".$data['pers_dep_fax']."',
				   '".$data['pers_dep_ext_fax']."'   , '".$data['pers_email_dep']."' , 
				   now() , 'S',
				   '".$_SESSION['id_usuario']."'
			 )";
			 
			 $this->db->Execute($sql);
			 $next = $this->db->Insert_ID();
			 
			 
			 //borramos el detalle antes de volver a insertarlo
			 $sql = "DELETE FROM contact_institutions WHERE pins_persona = '".$next."'";
			 $this->db->Execute($sql);
			 
			 //guardamos el detalle
			 for($c=0; $c < count($data['grup_grupo']); $c++ ) {
			     
				 $id_grupo = $data['grup_grupo_id'][$c];
				 $id_depen = $data['grup_dependencia_id'][$c];
				 $cargo    = $data['grup_cargo'][$c];
				 
				 //validamos que exista el grupo
				 $sql = "SELECT COUNT(*) FROM cat_grupos WHERE id_grup = '".$id_grupo."'";
			     $cnt = $this->db->GetOne($sql);
			     if($cnt == 0){ throw new Exception("<b>Estas tratando de ingresar un grupo que no existe, Por favor verifica</b>", 20001); }
			     
				 //validamos que exista la dependencia
			     $sql = "SELECT COUNT(*) cnt FROM cat_dependencias WHERE depe_dependencia = '".$id_depen."'";
			     $cnt = $this->db->GetOne($sql);
			     if($cnt == 0){ throw new Exception("El nombre de la dependencia que se proporciono, no coincide con ninguna del catalogo. Por favor revice de nuevo", 20001); }
				 if(strlen($cargo) == 0){ throw new Exception("Debes de escribir el nombre del cargo", 20001); }			 
				 
				 
				 /*if(!$this->verifiGroupDependency($id_grupo,$id_depen)){
			         throw new Exception("La dependencia que elegiste no pertenece al grupo seleccionado, por favor verifica la información", 20001);
			     }*/
				 
				 //validamos que no tenga dado de alta el grupo
				 $sql = "SELECT COUNT(*) cnt FROM contact_institutions WHERE pins_persona='".$next."' AND pins_grupo='".$id_grupo."'";
				 $cnt = $this->db->GetOne($sql);
				 if($cnt > 0){
				    $sql   = "SELECT d_grupo FROM cat_grupos WHERE id_grup = '".$id_grupo."'";
					$ngrup = $this->db->GetOne($sql);
					throw new Exception("Upss.. El grupo $ngrup , ya ha sido registrado para esta persona, favor de verificar", 20001);					
				 }
				 
				 //verifico que el mismo grupo no sea el que tiene como principal
				 if($data['pers_dep_grupo_id'] == $id_grupo){
				    throw new Exception("<b>Upss... Esta persona ya tiene asignado este grupo como grupo principal. Favor de verificar</b>", 20001);					
				 }

			     
			
				 $sql =" 
			     INSERT INTO contact_institutions(
			            pins_persona    ,
					    pins_grupo	    ,
					    pins_dependencia,
					    pins_cargo	    ,
					    pins_jerarquia  ,
					    pins_activo
			     ) VALUE (
			           '".$next."',
				       '".$data['grup_grupo_id'][$c]."',
				       '".$data['grup_dependencia_id'][$c]."',
				       '".$data['grup_cargo'][$c]."',
				       '".$data['grup_jerarquia'][$c]."',
					   'S'
			     );";
				
				 $this->db->Execute($sql);
			 }
			 
			 $this->db->CompleteTrans();
			 
		 	 return array("success"=> true, 'message'=>"<b>Se ha agregado con exito el contacto</b>");
			
		}catch(Exception $e){
			$this->db->RollbackTrans();		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception($e->getMessage() , $e->getCode() );	
		}				
    }
	
	
	
   /**
    * $params - $_POST
	* Guarda un nuevo registro en la base de datos de contactos
    */	
    public function edit( $data) {
        	
		try 
		{   
		    $persona = $data['pers_persona_id'];
		    
			//algunas validaciones
			if(strlen($data['pers_nombre']) == 0){ throw new Exception("Debes de escribir el nombre de la persona", 20001); }
			if(strlen($data['pers_apat']) == 0){ throw new Exception("Debes de escribir el Apellido de la persona", 20001); }
			if(strlen($data['pers_sexo']) == 0){ throw new Exception("Debes de seleccionar el sexo de la persona", 20001); }
			
			$sql = "SELECT COUNT(*) cnt FROM cat_titulos WHERE id_titulos = '".$data['pers_titulo_id']."'";
			$cnt = $this->db->GetOne($sql);
			if($cnt == 0){ throw new Exception("El nombre del titulo que proporciono, no coincide con ninguno del catalogo. Por favor seleccione uno de la lista que se despliega", 20001); }
			
			//validamos que exista el tipo de calle selccionado
			if(strlen($data['pers_tcalle_id']) > 0 ) {
			   $sql = "SELECT COUNT(*) FROM  cat_clase_calle WHERE id_clase_calle = '".$data['pers_tcalle_id']."'";
			   $cnt = $this->db->GetOne($sql);
			   if($cnt == 0){ throw new Exception("El tipo de calle que proporciono, no coincide con ninguno del catalogo. Por seleccione uno de la lista desplegable", 20001); }
			}
			
			//validamos que exista la calle en el catalogo
			if(strlen($data['pers_calle']) > 0 ) {
			   $sql = "SELECT COUNT(*) FROM  cat_calles WHERE id_calle = '".$data['pers_calle_id']."'";
			   $cnt = $this->db->GetOne($sql);
			   if($cnt == 0){ throw new Exception("El nombre de la calle que proporciono, no existe en el catalogo. Por seleccione uno de la lista desplegable", 20001); }
			}
			
			//validamos que la colonia que proporciono exista en el catalogo
			if(strlen($data['pers_colonia_id']) > 0 ) {
			   $sql = "SELECT COUNT(*) FROM cat_colonias WHERE id_colonia = '".$data['pers_colonia_id']."'";
			   $cnt = $this->db->GetOne($sql);
			   if($cnt == 0){ throw new Exception("El nombre de la colonia que proporciono, no coincide con ninguno del catalogo. Por favor revice de nuevo", 20001); }
			}
			
			
			$grupo = $data['pers_dep_grupo_id'];
			$depen = $data['pers_dependencia_id'];
			
			$sql = "SELECT COUNT(*) FROM cat_grupos WHERE id_grup = '".$data['pers_dep_grupo_id']."'";
			$cnt = $this->db->GetOne($sql);
			if($cnt == 0){ throw new Exception("El nombre del titulo que proporciono, no coincide con ninguno del catalogo. Por favor revice de nuevo", 20001); }
			
			$sql = "SELECT COUNT(*) cnt FROM cat_dependencias WHERE depe_dependencia = '".$data['pers_dependencia_id']."'";
			$cnt = $this->db->GetOne($sql);
			if($cnt == 0){ throw new Exception("El nombre de la dependencia que se proporciono, no coincide con ninguna del catalogo. Por favor revice de nuevo", 20001); }
			
			if(!$this->verifiGroupDependency($grupo,$depen)){
			   throw new Exception("La dependencia que elegiste no pertenece al grupo seleccionado, por favor verifica la informaci&oacute;n", 20001);
			}
			
			/* se manejo como Y/m/d en varchar(10), ya que muchas veces no cuentan con el año de nacimiento solo dia y mes*/
			$fnace         = $data['pers_fnanio'].'/'.$data['pers_fnmes'].'/'.$data['pers_fndia'];			
			$aniv_boda     = "/".$data['pers_mes_aniv'].'/'.$data['pers_dia_aniv'];			
			$fcumplesposa  = $data['pers_fanio_esposa'].'/'.$data['pers_fmes_esposa'].'/'.$data['pers_fdia_esposa'];
			
			$diamujer = $data['pers_invi_dm']      ? 'S' : 'N';
			$diamaest = $data['pers_invi_maestra'] ? 'S' : 'N';
			$eliviole = $data['pers_invi_dievcm']  ? 'S' : 'N';
			$votofeme = $data['pers_invi_avf']     ? 'S' : 'N';
			
			$data['pers_telefono'] = str_replace(array(' ','(',')','-'),'',$data['pers_telefono']);
			$data['pers_celular']  = str_replace(array(' ','(',')','-'),'',$data['pers_celular']);
			$data['pers_dep_tel']  = str_replace(array(' ','(',')','-'),'',$data['pers_dep_tel']);
			$data['pers_dep_tel2'] = str_replace(array(' ','(',')','-'),'',$data['pers_dep_tel2']);
			
			
		    $this->db->StartTrans();
		
		     $sql = "
			 UPDATE personas  
			    SET pers_titulo        = '".$data['pers_titulo_id']."',
				    pers_nombre        = '".strtoupper($data['pers_nombre'])."',
					pers_apat          = '".strtoupper($data['pers_apat'])."'  ,
					pers_amat          = '".strtoupper($data['pers_amat'])."'  ,
					pers_sexo          = '".strtoupper($data['pers_sexo'])."'  ,
					pers_fnac          = '".$fnace."'                          ,
					pers_celular       = '".$data['pers_celular']."',
					pers_telefono      = '".$data['pers_telefono']."',
					pers_nextel        = '".$data['pers_nextel']."',					
					pers_email         = '".$data['pers_email']."',
					pers_web           = '".$data['pers_web']."',					
					pers_colonia       = '".$data['pers_colonia_id']."',
					pers_cp            = '".$data['pers_cp']."',
					pers_tcalle        = '".$data['pers_tcalle_id']."',
					pers_calle         = '".$data['pers_calle_id']."',
					pers_sufijo        = '".$data['pers_sufijo']."',
					pers_numero        = '".$data['pers_numero']."',
					pers_lote          = '".$data['pers_lote']."',
					pers_manzana       = '".$data['pers_manzana']."',
					pers_refdomicilio    = '".$data['pers_refdomi']."',
					pers_aniversarioboda = '".$aniv_boda."',
					pers_esposa        = '".strtoupper($data['pers_name_esposa'])."',
					pers_cumple_esposa = '".$fcumplesposa."',
					pers_invi_dm       = '".$diamujer."' ,
					pers_invi_maestra  = '".$diamaest."' ,
					pers_invi_avf      = '".$votofeme."' ,
					pers_invi_dievcm   = '".$eliviole."' ,					
					pers_observaciones = '".$data['pers_observa']."',
					pers_grupo         = '".$data['pers_dep_grupo_id']."',
					pers_dependencia   = '".$data['pers_dependencia_id']."',
					pers_cargo         = '".strtoupper($data['pers_cargo'])."',
					pers_jerarquia     = '".$data['pers_dep_jerarquia']."' ,
					pers_liderazgo     = '".$data['pers_liderazgo']."' ,					
					pers_tel_dep       = '".$data['pers_dep_tel']."',
					pers_ext_dep       = '".$data['pers_dep_ext']."',
					pers_ext_priv_dep  = '".$data['pers_dep_ext_priv']."',
					pers_tel2_dep      = '".$data['pers_dep_tel2']."',
					pers_fax_dep       = '".$data['pers_dep_fax']."',
					pers_fax_ext_dep   = '".$data['pers_dep_ext_fax']."',
					pers_email_dep     = '".$data['pers_email_dep']."',
					pers_update        = now()
			 WHERE  pers_persona       = '".$persona."'";
			 $sql_temp = $sql;
			 $this->db->Execute($sql);
			 			 
			 //borramos el detalle antes de volver a insertarlo
			 $sql = "DELETE FROM contact_institutions WHERE pins_persona = '".$persona."'";
			 $this->db->Execute($sql);
			 
			 //guardamos el detalle
			 for($c=0; $c < count($data['grup_grupo']); $c++ ) {
			     
				 $id_grupo = $data['grup_grupo_id'][$c];
				 $id_depen = $data['grup_dependencia_id'][$c];
				 
				 $sql = "SELECT COUNT(*) FROM cat_grupos WHERE id_grup = '".$id_grupo."'";
			     $cnt = $this->db->GetOne($sql);
			     if($cnt == 0){ throw new Exception("El nombre del grupo que proporciono en Otros grupos, no coincide con ninguno del catalogo. Por favor revice de nuevo", 20001); }
			
			     $sql = "SELECT COUNT(*) cnt FROM cat_dependencias WHERE depe_dependencia = '".$id_depen."'";
			     $cnt = $this->db->GetOne($sql);
			     if($cnt == 0){ throw new Exception("El nombre de la dependencia que se proporciono, no coincide con ninguna del catalogo. Por favor revice de nuevo", 20001); }
				 
				 
				 /*if(!$this->verifiGroupDependency($id_grupo,$id_depen)){
			         throw new Exception("La dependencia que elegiste no pertenece al grupo seleccionado, por favor verifica la información", 20001);
			     }*/
				 
				 //validamos que no tenga dado de alta el grupo
				 $sql = "SELECT COUNT(*) cnt FROM contact_institutions WHERE pins_persona='".$next."' AND pins_grupo='".$id_grupo."'";
				 $cnt = $this->db->GetOne($sql);
				 if($cnt > 0){
				    $sql   = "SELECT d_grupo FROM cat_grupos WHERE id_grup = '".$id_grupo."'";
					$ngrup = $this->db->GetOne($sql);
					throw new Exception("Upss.. El grupo $ngrup , ya ha sido registrado para esta persona, favor de verificar", 20001);					
				 }
			     
				 //verifico que el mismo grupo no sea el que tiene como principal
				 if($data['pers_dep_grupo_id'] == $id_grupo){
				    throw new Exception("<b>Upss... Esta persona ya tiene asignado este grupo como grupo principal. Favor de verificar</b>", 20001);					
				 }
			
			
				 $sql =" 
			     INSERT INTO contact_institutions(
			            pins_persona    ,
					    pins_grupo	    ,
					    pins_dependencia,
					    pins_cargo	    ,
					    pins_jerarquia  ,
					    pins_activo
			     ) VALUE (
			           '".$persona."',
				       '".$data['grup_grupo_id'][$c]."',
				       '".$data['grup_dependencia_id'][$c]."',
				       '".$data['grup_cargo'][$c]."',
				       '".$data['grup_jerarquia'][$c]."',
					   'S'
			     );";
				
				 $this->db->Execute($sql);
			 }
			 
			 $this->db->CompleteTrans();
			 
		 	 return array("success"=> true, 'message'=>"<b>Se han modificado correctamente los datos del contacto</b>");
			
		}catch(Exception $e){
			 $this->db->RollbackTrans();		   
			 $this->setError($e->getCode(), $e->getMessage());
			 throw new Exception($e->getMessage() , $e->getCode() );	
		}
				
    }
	
   /**
    * Elimina el contacto con toda su respectiva informacion
	* $person : string
    */	
    public function delete( $person) {
        	
		try 
		{    
		     
			 
			 $this->db->StartTrans();
			 
			 $persona = $this->getInfo($person);
			 		 
		     $sql="DELETE FROM contact_institutions WHERE pins_persona = '$person'";
		     $this->db->Execute($sql);		
		     $sql = "DELETE FROM personas WHERE pers_persona='$person'";
			 $this->db->Execute($sql);
			 
			 $this->db->CompleteTrans();
			 
			 return array("success"=> true, 'message'=>"Se ha eliminado de la base de datos a la persona: \n\n".$persona['nombre']);
			
		}catch(Exception $e){
		     $this->db->RollbackTrans();
			 $this->setError($e->getCode(), $e->getMessage());
			 throw new Exception( $e->getMessage() , $e->getCode() );	
		}
				
    }
	
	
	
   /**
    * obtiene toda la informacion del contacto
	* $person : string
    */	
    public function getInfo( $person) {        	
		try 
		{    $sql = "
		     SELECT pers_persona   ,
			        pers_titulo    ,
				   ( SELECT d_titulos FROM cat_titulos WHERE id_titulos = pers_titulo ) pers_dtitulo,
					pers_nombre    , pers_apat   , pers_amat     ,
					CONCAT_WS(' ',pers_nombre    , pers_apat   , pers_amat) nombre,
					pers_sexo      , 
					pers_fnac   , 
					pers_celular  ,
					pers_telefono  , pers_nextel , pers_email    , 
					pers_colonia   , pers_web    ,
				   ( SELECT d_colonia FROM cat_colonias WHERE id_colonia = pers_colonia ) pers_dcolonia,
				    pers_cp        , pers_tcalle ,
				   ( SELECT d_clase_calle FROM cat_clase_calle WHERE id_clase_calle = pers_tcalle) pers_dtcalle,
				    pers_calle     , 
				   ( SELECT nombre FROM cat_calles WHERE id_calle=pers_calle) pers_dcalle,
					pers_sufijo , pers_numero    , pers_lote   ,
					pers_manzana   , pers_refdomicilio, pers_aniversarioboda    ,
					pers_esposa    , pers_cumple_esposa , 
					pers_invi_dm   , pers_invi_avf      , pers_invi_dievcm      , pers_invi_maestra,
					pers_observaciones   , 
					pers_grupo     ,
				   ( SELECT d_grupo FROM cat_grupos WHERE id_grup = pers_grupo ) pers_dgrupo ,
				    pers_dependencia,
				   ( SELECT depe_nombre FROM cat_dependencias WHERE depe_dependencia = pers_dependencia) pers_ndependencia,
				    pers_cargo     , pers_jerarquia, pers_liderazgo ,
				   ( SELECT nom_jerarquia  FROM cat_jerarquias WHERE id_jerarquia = pers_jerarquia) pers_djerarquia,
				    pers_tel_dep   , pers_ext_dep , pers_ext_priv_dep ,
					pers_tel2_dep  , pers_fax_dep , pers_fax_ext_dep  , pers_email_dep
			   FROM personas
			  WHERE pers_persona = '$person'";			  
			 
			 $rs      = $this->db->Execute($sql);
			 $rperson =  $rs->FetchRow();
			 $rs->Close();
			 
			 return $rperson;
			
		}catch(Exception $e){		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception( $e->getMessage() , $e->getCode() );	
		}				
    }
	
   
   /**
    * getByFilters - Ejecuta un queri con los filtros correspondientes
	* @params {array} filters 
	* @return mixed array encoded in json
    */	
    public function getByFilters( $filter, $rmode='array' ) {        	
		try 
		{    
		     $start = $filter['start'] ? $filter['start'] : 0;
			 $limit = $filter['limit'] ? $filter['limit'] : 100;
		
		     $sql = "
			 SELECT SQL_CALC_FOUND_ROWS
			        CONCAT_WS(' ',p.pers_nombre,p.pers_apat,p.pers_amat) AS pers_nnombre,
					pg.*,
					p.pers_celular              AS pers_celular,
					p.pers_tel_dep              AS pers_dtel, 
					p.pers_ext_dep              AS pers_dext,
					IF(LENGTH(p.pers_email_dep)=0, p.pers_email, p.pers_email_dep) AS pers_demail,
					( SELECT nom_jerarquia 
					    FROM cat_jerarquias  
					   WHERE id_jerarquia = pg.pers_jerarquia
					)                           AS pers_njerarquia ,
					( SELECT d_grupo FROM cat_grupos WHERE id_grup = pg.pers_grupo)  AS pers_ngrupo,
		            ( SELECT depe_nombre   FROM cat_dependencias WHERE depe_dependencia = pg.pers_dependencia) AS pers_ndependencia,
					IF(( SELECT COUNT(*) 
					       FROM invitados 
						  WHERE invi_evento  = '".$filter['evento']."'
						    AND invi_persona = pg.pers_persona
					   ) > 0, 'true', 'false'
					)                           AS isinvited ,
					( SELECT COUNT(*) FROM vpersonas vp WHERE vp.pers_persona = pg.pers_persona ) ngroup
			   FROM	(   
			            SELECT 'P'              AS pers_tgrupo,
						       pers_persona     AS pers_referencia,
							   pers_persona     AS pers_persona ,
							   id_cat           AS pers_categoria,       
							   pers_jerarquia   AS pers_jerarquia,
							   pers_grupo       AS pers_grupo   ,       
							   pers_dependencia AS pers_dependencia,
							   pers_cargo       AS pers_cargo,      
							   depe_municipio   AS pers_municipio,       
							   depe_ciudad      AS pers_ciudad
						  FROM personas , cat_grupos, cat_dependencias  
						 WHERE pers_grupo       = id_grup 
                           AND pers_dependencia = depe_dependencia ";
						
						if(strlen($filter['filt_ngrupo'])     > 0 ){ $sql.= " AND d_grupo LIKE '%".$filter['filt_ngrupo']."%' ".chr(13); }			 
			
						   
					$sql.=" UNION ALL
						SELECT 'O'              AS pers_tgrupo,
						       pins_id          AS pers_referencia,
							   pins_persona     AS pers_persona,
							   id_cat           AS pers_categoria,      
							   pins_jerarquia   AS pers_jerarquia,
							   pins_grupo       AS pers_grupo ,       
							   pins_dependencia AS pers_dependencia,
							   pins_cargo       AS pers_cargo ,     
							   depe_municipio   AS pers_municipio,       
							   depe_ciudad      AS pers_ciudad
						  FROM contact_institutions , cat_dependencias  , cat_grupos
						 WHERE pins_dependencia = depe_dependencia
						   AND pins_grupo       = id_grup ";
				       if(strlen($filter['filt_ngrupo'])     > 0 ){ $sql.= " AND d_grupo LIKE '%".$filter['filt_ngrupo']."%' ".chr(13); }			 
			
					$sql.=" ) pg , personas p
			  WHERE p.pers_persona = pg.pers_persona
			 ";			  
			 
			 if(strlen($filter['filt_npersona'])   > 0 ){ $sql.= " AND CONCAT_WS(' ',p.pers_nombre,p.pers_apat,p.pers_amat) LIKE ('%".$filter['filt_npersona']."%')"; }
			 if(strlen($filter['filt_jerarquia'])  > 0 ){ $sql.= " AND pg.pers_jerarquia = '".$filter['filt_jerarquia']."'"; }
			 if(strlen($filter['filt_jerarquias']) > 0 ){ $sql.= " AND pg.pers_jerarquia IN (".$filter['filt_jerarquias'].")"; }
			 if(strlen($filter['filt_categoria'])  > 0 ){ $sql.= " AND pg.pers_categoria = '".$filter['filt_categoria']."'"; }
			 if(strlen($filter['filt_grupo'])      > 0 ){ $sql.= " AND pg.pers_grupo = '".$filter['filt_grupo']."'"; }
			 if(strlen($filter['filt_dependencia'])> 0 ){ $sql.= " AND pg.pers_dependencia = '".$filter['filt_dependencia']."'"; }
			 if(strlen($filter['filt_sexo'])       > 0 ){ $sql.= " AND p.pers_sexo = '".$filter['filt_sexo']."'"; }
			 if(strlen($filter['filt_cargo'])      > 0 ){ $sql.= " AND pg.pers_cargo LIKE ('".$filter['filt_cargo']."')"; }
			 if(strlen($filter['filt_municipio'])  > 0 ){ $sql.= " AND pg.pers_municipio = '".$filter['filt_municipio']."'"; }
			 if(strlen($filter['filt_ciudad'])     > 0 ){ $sql.= " AND pg.pers_ciudad = '".$filter['filt_ciudad']."'"; }
			 if(strlen($filter['filt_dm'])         > 0 ){ $sql.= " AND p.pers_invi_dm = '".$filter['filt_dm']."'"; }
			 if(strlen($filter['filt_maestra'])    > 0 ){ $sql.= " AND p.pers_invi_maestra = '".$filter['filt_maestra']."'"; }
			 if(strlen($filter['filt_avf'])        > 0 ){ $sql.= " AND p.pers_invi_avf = '".$filter['filt_avf']."'"; }
			 if(strlen($filter['filt_dievcm'])     > 0 ){ $sql.= " AND p.pers_invi_dievcm = '".$filter['filt_dievcm']."'"; }
			 
			 if(strlen($filter['group'])> 0 )   { 
			    $sql.= " GROUP BY ".$filter['group']; 
			 }
			 
			 if(strlen($filter['orderby'])> 0 )   { 
			    $sql.=" ORDER BY ".$filter['orderby'];
			 }else {
				$sql.=" ORDER BY pers_ndependencia, pg.pers_jerarquia ASC, pers_nnombre ASC";
			 }
			 
			 $this->sql = $sql;
			 error_log($this->sql);
			 
			 $rs    = $this->db->SelectLimit($sql, $limit, $start);
			 $tt    = $this->db->GetOne("SELECT FOUND_ROWS(); ");
			 
			 if ($rmode == 'response'){
			     $rows  = $rs->GetAll();
				 $response = array('success'=>true,'total'=>$tt, 'rows'=>$rows, 'sql'=>$sql);
				 unset($rows);
				 $rs->Close();
				 return $response;
				  
			 }elseif($rmode == 'array'){
			     $rows = $rs->GetAll();
				 $rs->Close();
				 return $rows;
			 }elseif($rmode == 'rs'){
			     return  $rs;
			 }
			  			 
			 return true;
			
		}catch(Exception $e){
		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception( $e->getMessage() , $e->getCode() );	
		}
	}
	
   /**
    * $params - $array
    */	
    public function getByFilter( $search, $by) {
        	
		try 
		{    $sql = "		
		     SELECT pers_persona AS id     , 
			        CONCAT_WS(' ',pers_nombre,pers_apat, pers_amat) AS value,
					( 
					   SELECT CONCAT('Grupos (',COUNT(*),')')
					     FROM contact_institutions  
						WHERE pins_persona = pers_persona 
					)            AS info   ,
					pers_nombre  AS nombre ,
					pers_apat    AS apat   ,
					pers_amat    AS amat   
			   FROM personas "; 
			  
			  if($by=='name'){
			     $where = " WHERE pers_nombre   LIKE '".strtoupper($search)."%'";
			  }elseif($by=='apat'){
			    $where = " WHERE pers_apat   LIKE '".strtoupper($search)."%'";
			  }else{
			    $where= " WHERE CONCAT_WS(' ',pers_nombre,pers_apat, pers_amat) LIKE '%".strtoupper($search)."%'";
			  }
			  
			  $sql.= $where;
			  $sql.= " LIMIT 20";		 	 
			
			 $rs   = $this->db->Execute($sql);
			 $rows =  $rs->GetAll();			 
			 $rs->Close();
			 
			 return $rows;
			
		}catch(Exception $e){
		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception( $e->getMessage() , $e->getCode() );	
		}
				
    }
	
   /**
    * Obtiene el catalogo de titulos para el tratamiento de las personas
	* $search - string : palabra a buscar
	* $return - string : Forma en que debe de devolver los datos
    */	
    public function validate( $field, $value, $generico, $cual) {
        	
		try 
		{    $this->script = array();
		     
			 if($generico=='S'){
			    
				if($cual=='grupo'){
					$sql ="SELECT COUNT(*) FROM cat_grupos WHERE d_grupo ='$value'";
					$cnt = $this->db->GetOne($sql);
					$this->script['script'] = "contacto.activeTab('tabs3');";
					if($cnt == 0){ throw new Exception("En la secci&oacute;n de otros grupos, has introducido un valor invalido para el grup", 20001); }				
				 }
				 
				 if($cual=='dependencia'){
					$sql ="SELECT COUNT(*) FROM cat_dependencias WHERE depe_nombre ='$value'";
					$this->script['script'] = "contacto.activeTab('tabs3');";
					$cnt = $this->db->GetOne($sql);					
					if($cnt == 0){ throw new Exception("En la secci&oacute;n de otros grupos, has introducido un valor invalido para  la dependencia", 20001); }				
				 }
				
				
				
			 }else{
				 if($field=='pers_titulo'){
					$sql ="SELECT COUNT(*) FROM cat_titulos WHERE d_titulos ='$value'";
					$cnt = $this->db->GetOne($sql);
					$this->script['script'] = "contacto.activeTab('tabs1'); $('#$field').focus();";
					if($cnt == 0){ throw new Exception("Has introducido un valor invalido para el campo Titulo. Selecciona uno de la lista desplegable", 20001); }				
				 }
				 
				 if($field=='pers_tcalle'){
					$sql ="SELECT COUNT(*) FROM cat_clase_calle WHERE d_clase_calle='$value'";
					$cnt = $this->db->GetOne($sql);
					$this->script['script'] = "contacto.activeTab('tabs2');";
					if($cnt == 0){ throw new Exception("Has introducido un valor invalido para el campo Tipo de Calle. Selecciona uno de la lista desplegable", 20001); }				
				 }
				 
				 if($field=='pers_calle'){
					$sql ="SELECT COUNT(*) FROM cat_calles WHERE nombre = '$value'";
					$cnt = $this->db->GetOne($sql);
					$this->script['script'] = "contacto.activeTab('tabs2');";
					if($cnt == 0){ throw new Exception("Has introducido un valor invalido para el campo Calle. Por favor selecciona uno de la lista desplegable", 20001); }				
				 }
				 
				 if($field=='pers_colonia'){
					$sql ="SELECT COUNT(*) FROM cat_colonias WHERE d_colonia ='$value'";
					$cnt = $this->db->GetOne($sql);
					$this->script['script'] = "contacto.activeTab('tabs2');";
					if($cnt == 0){ throw new Exception("Has introducido un valor invalido para el campo Colonia. Selecciona uno de la lista desplegable", 20001); }				
				 }
				 
				 if($field=='pers_dep_grupo'){
					$sql ="SELECT COUNT(*) FROM cat_grupos WHERE d_grupo ='$value'";
					$cnt = $this->db->GetOne($sql);
					$this->script['script'] = "contacto.activeTab('tabs3');";
					if($cnt == 0){ throw new Exception("Has introducido un valor invalido para el campo Grupo. Por favor selecciona uno de la lista desplegable", 20001); }				
				 }
				 
				 if($field=='pers_dependencia'){
					$sql ="SELECT COUNT(*) FROM cat_dependencias WHERE depe_nombre ='$value'";
					$this->script['script'] = "contacto.activeTab('tabs3');";
					$cnt = $this->db->GetOne($sql);
					
					if($cnt == 0){ throw new Exception("Has introducido un valor invalido para el campo Dependencia. Por favor selecciona uno de la lista desplegable o Agrega una nueva", 20001); }				
				 }
			 }
			 
			 
			 
			 
			 
			 
			 
			 return array('success'=>true);
			 
		}catch(Exception $e){		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception( $e->getMessage() , $e->getCode() );	
		}				
    }
	
	/**
    * Obtiene el catalogo de jerarquias
	* 
	* @param  mixed array contiene datos como el query, start, limit, etc
	* @return {Array/String} dependiendo del modo en que se solicite
    */	
    public function getJerarquias( $data, $return='array') {        	
		try 
		{    
		     if(strlen($return)==0) return false;		
		     
			 $start = $data['start'] ? $data['start'] : 0;
			 $limit = $data['limit'] ? $data['limit'] : 20;
			 
		     $sql = "	
		     SELECT SQL_CALC_FOUND_ROWS
			        id_jerarquia  AS clave ,
			        nom_jerarquia AS descrip
			   FROM cat_jerarquias
			  WHERE 1 = 1";
			 
			 if(strlen($data['query'])>0){
			    $sql.=" AND nom_jerarquia LIKE '%".$data['query']."%'";
			 }
			  
		 	 
			 $sql." ORDER BY orden_jer ASC";
			 $rs   = $this->db->SelectLimit($sql,$limit,$start);			 
			 $tt   = $this->db->GetOne("SELECT FOUND_ROWS()");
			 $rows = $rs->GetAll();
			 
			 if ($return=='response'){
				 $response = array('success'=>true, 'rows'=>$rows, 'total'=>$tt, 'sql'=>$sql );
				 return $response;				 
			 }elseif ($return=='array'){
				 $rows =  $rs->GetAll();
			     $rs->Close();
				 return $rows;
			 }elseif($return=='pipe'){
			     $str = '';
				 while($row = $rs->FetchRow()){
	                $str.= $row['descrip']."|".$row['clave']."\n";
	             }
				 return $str;		 
			 }
			 
			 
		}catch(Exception $e){		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception( $e->getMessage() , $e->getCode() );	
		}				
    }
		
   /**
    * Obtiene el catalogo de titulos para el tratamiento de las personas
	* $search - string : palabra a buscar
	* $return - string : Forma en que debe de devolver los datos
    */	
    public function getTitulos( $search, $return='array') {
        	
		try 
		{    
		     if(strlen($return)==0) return false;		
		
		     $sql = "	
		     SELECT id_titulos AS clave, 
			        d_titulos  AS descrip 
			   FROM cat_titulos 
			  WHERE d_titulos LIKE '%".strtoupper($search)."%' 
			  ORDER BY d_titulos 
			  LIMIT 10;";
		 	 
			 $rs   = $this->db->Execute($sql);			 
			 
			 if ($return=='array'){
				 $rows =  $rs->GetAll();
			     $rs->Close();
				 return $rows;
			 }elseif($return=='pipe'){
			     $str = '';
				 while($row = $rs->FetchRow()){
	                $str.= $row['descrip']."|".$row['clave']."\n";
	             }
				 return $str;		 
			 }
			 
			 
		}catch(Exception $e){		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception( $e->getMessage() , $e->getCode() );	
		}				
    }
	
   
   /**
    * Obtiene el catalogo de tipos de calles
	* $search - string : palabra a buscar
	* $return - string : Forma en que debe de devolver los datos
    */	
    public function getTCalles( $search, $return='array') {
        	
		try 
		{    
		     if(strlen($return)==0) return false;		
		
		     $sql = "	
		     SELECT id_clase_calle AS clave   ,
			        d_clase_calle  AS descrip 
			   FROM cat_clase_calle
			  WHERE d_clase_calle LIKE '%$search%'
			  ORDER BY d_clase_calle
			  LIMIT 10";
		 	 
			 $rs   = $this->db->Execute($sql);			 
			 
			 if ($return=='array'){
				 $rows =  $rs->GetAll();
			     $rs->Close();
				 return $rows;
			 }elseif($return=='pipe'){
			     $str = '';
				 while($row = $rs->FetchRow()){
	                $str.= $row['descrip']."|".$row['clave']."\n";
	             }
				 return $str;		 
			 }
			 
			 
		}catch(Exception $e){		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception( $e->getMessage() , $e->getCode() );	
		}				
    }
	
   /**
    * Obtiene el catalogo de de calles
	* $search - string : palabra a buscar
	* $return - string : Forma en que debe de devolver los datos
    */	
    public function getCalles( $search, $return='array') {
        	
		try 
		{    
		     if(strlen($return)==0) return false;		
		
		     $sql = "	
		     SELECT id_calle AS clave  ,
			        nombre   As descrip 
			   FROM cat_calles
			  WHERE nombre LIKE '%$search%' 
			  LIMIT 10";
		 	 
			 $rs   = $this->db->Execute($sql);			 
			 
			 if ($return=='array'){
				 $rows =  $rs->GetAll();
			     $rs->Close();
				 return $rows;
			 }elseif($return=='pipe'){
			     $str = '';
				 while($row = $rs->FetchRow()){
	                $str.= $row['descrip']."|".$row['clave']."\n";
	             }
				 return $str;		 
			 }
			 
			 
		}catch(Exception $e){		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception( $e->getMessage() , $e->getCode() );	
		}				
    }
	
	
	/**
    * Obtiene el catalogo de tipos de calles
	* $search - string : palabra a buscar
	* $return - string : Forma en que debe de devolver los datos
    */	
    public function getColonias( $search, $municipio = '',  $return='array') {
        	
		try 
		{    
		     if(strlen($return)==0) return false;		
		
		     $sql = "	
		     SELECT id_colonia  AS id   , 
			        d_colonia   AS value, 
					initcap(d_municipio) AS info
			   FROM cat_colonias c, cat_municipios m
			  WHERE m.id_municipio_inegi = c.id_municipio
			    AND d_colonia LIKE '%$search%'
			 ";
			 
			 if(strlen($municipio) > 0){
			    $sql.=" AND c.id_municipio = '".$municipio."' ";
			 }
			 $sql.= "  LIMIT 10";
			 
		 	 
			 $rs   = $this->db->Execute($sql);			 
			 
			 if ($return=='array'){
				 $rows =  $rs->GetAll();
			     $rs->Close();
				 return $rows;
			 }elseif($return=='pipe'){
			     $str = '';
				 while($row = $rs->FetchRow()){
	                $str.= $row['descrip']."|".$row['clave']."\n";
	             }
				 return $str;		 
			 }
			 
			 
		}catch(Exception $e){		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception( $e->getMessage() , $e->getCode() );	
		}				
    }
	
	
   /**
    * Obtiene el catalogo de categorias
	* $search - string : palabra a buscar
	* $return - string : Forma en que debe de devolver los datos
    */	
    public function getCategorias( $search, $return='array') {
        	
		try 
		{    
		     if(strlen($return)==0) return false;
			 
			 $start = $search['start'] ? $search['start'] : 0;
			 $limit = $search['limit'] ? $search['limit'] : 10;	
		
		     $sql = "	
		     SELECT SQL_CALC_FOUND_ROWS 
			        id_categoria   AS clave ,
			        d_categoria    AS descrip
			   FROM cat_categorias 
			  WHERE 1 = 1";
			 
			 if(strlen($search['query'])>0 ){
			    $sql.=" AND d_categoria LIKE '%".$search['query']."%'";
			 }
		 	 
			 $sql.=" ORDER BY d_categoria";	 
			 $rs   = $this->db->SelectLimit($sql, $limit, $start);
			 $tt   = $this->db->GetOne("SELECT FOUND_ROWS()");
			
			 
			 if($return=='response'){
			     $rows = $rs->GetAll();
				 $rs->Close();
				 $response = array('success'=>true, 'rows'=>$rows, 'total'=>$tt, 'sql'=>$sql );
				 return $response;			 
			 }elseif ($return=='array'){
				 $rows =  $rs->GetAll();
			     $rs->Close();
				 return $rows;
			 }elseif($return=='pipe'){
			     $str = '';
				 while($row = $rs->FetchRow()){
	                $str.= $row['descrip']."|".$row['clave']."\n";
	             }
				 $rs->Close();
				 return $str;		 
			 }
			 
		}catch(Exception $e){		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception( $e->getMessage() , $e->getCode() );	
		}				
    }
	
   /**
    * Obtiene el catalogo de grupos
	* $search - string : palabra a buscar
	* $return - string : Forma en que debe de devolver los datos
    */	
    public function getGrupos( $search, $return='array') {
        	
		try 
		{    
		     if(strlen($return)==0) return false;		
		     
			 $start = $search['start'] ? $search['start'] : 0;
			 $limit = $search['limit'] ? $search['limit'] : 10;
			 
		     $sql = "	
		     SELECT SQL_CALC_FOUND_ROWS
			        id_grup              AS id   ,
			        d_grupo              AS value,
					initcap(d_categoria) AS info,
					( SELECT COUNT(grupo) ngrupo
					   FROM ( SELECT pers_persona, pers_grupo grupo
								FROM personas
							   UNION ALL
							  SELECT pins_persona,pins_grupo grupo
								FROM contact_institutions
							) p					
					  WHERE p.grupo = g.id_grup 
					) num
			   FROM cat_grupos g, cat_categorias c
			  WHERE g.id_cat = c.id_categoria";			  
			 
			 if(strlen($search['categoria'])>0 ){
			    $sql.=" AND id_cat = '".$search['categoria']."'";
			 }
			 
			 if(strlen($search['query'])>0 ){
			    $sql.=" AND g.d_grupo LIKE '%".$search['query']."%'";
			 }
		 	 
			 $sql.=" ORDER BY d_categoria, d_grupo ASC  ";			 
			 $rs   = $this->db->SelectLimit($sql, $limit, $start);
			 $tt   = $this->db->GetOne("SELECT FOUND_ROWS()");
			
			 
			 if($return=='response'){
			     $rows = $rs->GetAll();
				 $rs->Close();
				 $response = array('success'=>true, 'rows'=>$rows, 'total'=>$tt, 'sql'=>$sql );
				 return $response;			 
			 }elseif ($return=='array'){
				 $rows =  $rs->GetAll();
			     $rs->Close();
				 return $rows;
			 }elseif($return=='pipe'){
			     $str = '';
				 while($row = $rs->FetchRow()){
	                $str.= $row['descrip']."|".$row['clave']."\n";
	             }
				 $rs->Close();
				 return $str;		 
			 }
			 
			 
		}catch(Exception $e){		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception( $e->getMessage() , $e->getCode() );	
		}				
    }
	
	
   /**
    * Obtiene el catalogo de ciudades
	* $search - string : palabra a buscar
	* $return - string : Forma en que debe de devolver los datos
    */	
    public function getMunicipios( $search, $return='array') {
        	
		try 
		{    
		     if(strlen($return)==0) return false;
			 
			 $start = $search['start'] ? $search['start'] : 0;
			 $limit = $search['limit'] ? $search['limit'] : 10;	
			 
			 
		     $sql = "	
		     SELECT SQL_CALC_FOUND_ROWS
			        id_municipio_inegi  AS id    ,
			        d_municipio         AS value ,
					initcap(e.d_estado) AS info
			   FROM cat_municipios m, cat_estados e
			  WHERE m.id_estado = e.id_estado";
			  
			 if(strlen($search['query']) > 0){ 
			    $sql.=" AND m.d_municipio LIKE '%".$search['query']."%'";
			 }
			 
			 $sql.=" ORDER BY d_municipio";
			 $rs   = $this->db->SelectLimit($sql, $limit, $start);
			 $tt   = $this->db->GetOne("SELECT FOUND_ROWS()");
					 
			 if($return=='response'){
			     $rows = $rs->GetAll();
				 $rs->Close();
				 $response = array('success'=>true, 'rows'=>$rows, 'total'=>$tt, 'sql'=>$sql );
				 return $response;			 
			 }elseif ($return=='array'){
				 $rows =  $rs->GetAll();
			     $rs->Close();
				 return $rows;
			 }elseif($return=='pipe'){
			     $str = '';
				 while($row = $rs->FetchRow()){
	                $str.= $row['descrip']."|".$row['clave']."\n";
	             }
				 return $str;		 
			 }
			 
			 
		}catch(Exception $e){		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception( $e->getMessage() , $e->getCode() );	
		}				
    }
	
   /**
    * Obtiene el catalogo de ciudades
	* $search - string : palabra a buscar
	* $return - string : Forma en que debe de devolver los datos
    */	
    public function getCiudades( $search, $municipio='', $return='array') {
        	
		try 
		{    
		     if(strlen($return)==0) return false;		
		
		     $sql = "	
		     SELECT l.id_localidad   AS id ,
			        l.d_localidad    AS value ,
					CONCAT(initcap(m.d_municipio),', ',initcap(e.d_estado))  AS info
			   FROM cat_localidad l, cat_municipios m, cat_estados e
			  WHERE l.id_municipio = m.id_municipio_inegi
			    AND m.id_estado  =  e.id_estado
				AND l.d_localidad LIKE '%$search%'";			  
			 
			 if(strlen($municipio) > 0){
			    $sql.=" AND l.id_municipio = '".$municipio."' ";
			 }
			 $sql.= "
			 ORDER BY d_localidad
			 LIMIT 10			 
			 ";
		 	 
			 $rs   = $this->db->Execute($sql);			 
			 
			 if ($return=='array'){
				 $rows =  $rs->GetAll();
			     $rs->Close();
				 return $rows;
			 }elseif($return=='pipe'){
			     $str = '';
				 while($row = $rs->FetchRow()){
	                $str.= $row['descrip']."|".$row['clave']."\n";
	             }
				 return $str;		 
			 }
			 
			 
		}catch(Exception $e){		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception( $e->getMessage() , $e->getCode() );	
		}				
    }
	
	
   /**
    * Obtiene el catalogo de dependencias
	* $search - string : palabra a buscar
	* $return - string : Forma en que debe de devolver los datos
    */	
    public function getDependencias( $search, $return='array') {
        	
		try 
		{    
		     if(strlen($return)==0) return false;
			 
			 $start = $search['start'] ? $search['start'] : 0;
			 $limit = $search['limit'] ? $search['limit'] : 10;
			 
			 
			 $sql="
			 SELECT d.*,
				   ( SELECT d_localidad FROM cat_localidad WHERE id_localidad = depe_ciudad) nciudad,
				   ( SELECT d_colonia FROM cat_colonias WHERE id_colonia = depe_colonia ) ncolonia  ,
				   ( SELECT nombre FROM cat_calles WHERE id_calle = depe_calle) ncalle
		      FROM cat_dependencias d
			  WHERE 1 = 1
			 ";
			 
			 if(strlen($search['grupo'])>0){  $sql.=" AND depe_grupo LIKE '".$search['grupo']."'";}
			 if(strlen($search['query'])>0){  $sql.=" AND depe_nombre LIKE '%".$search['query']."%'";}			 	
		
		     $csql = "	
		     SELECT SQL_CALC_FOUND_ROWS
			        depe_dependencia AS id,
			        depe_nombre      AS value,
					IFNULL(CONCAT(initcap(ncalle),' ',initcap(depe_entre),' ',initcap(depe_y_entre),' No. ',depe_numero,', Col. ',ncolonia,', ',nciudad),' ')  info   
			   FROM ( 
			           $sql 
					) a
			  WHERE 1 = 1
			  ORDER BY depe_nombre";
			  			
						  			 
			 $rs   = $this->db->SelectLimit($csql, $limit, $start);
			 $tt   = $this->db->GetOne("SELECT FOUND_ROWS()");
			 
			 if($return=='response'){
			     $rows = $rs->GetAll();
				 $rs->Close();
				 $response = array('success'=>true, 'rows'=>$rows, 'total'=>$tt, 'sql'=>$sql );
				 return $response;			 
			 }elseif ($return=='array'){
				 $rows =  $rs->GetAll();
			     $rs->Close();
				 return $rows;
			 }elseif($return=='pipe'){
			     $str = '';
				 while($row = $rs->FetchRow()){
	                $str.= $row['descrip']."|".$row['clave']."\n";
	             }
				 $rs->Close();
				 return $str;		 
			 }
			 
			 
		}catch(Exception $e){		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception( $e->getMessage() , $e->getCode() );	
		}				
    }
	
	
	
	
   /**------------------------------------------------------------------------------------------------------------------------------------------*
    * Guarda los datos de la dependencia
	* $data  - Array que puede ser el post
    *-------------------------------------------------------------------------------------------------------------------------------------------*/	
    public function saveDependencia( $data ) {        	
		try 
		{    
		     $grupo = $data['depe_categoria_id'];
			 
			 //validamos algunos datos
			 $sql = "SELECT COUNT(*) cnt FROM cat_dependencias WHERE depe_nombre = '".$data['depe_nombre']."'";
			 $cnt = $this->db->GetOne($sql);			 
			 if( (int) $cnt > 0){ throw new Exception("El nombre de la dependencia ya existe.", 20001); }
			 
			 $sql = "SELECT COUNT(*) cnt FROM cat_grupos WHERE id_grup = '".$grupo."'";
			 $cnt = $this->db->GetOne($sql);			 
			 if($cnt == 0){ throw new Exception("El grupo proporcionado no coincide con ninguno del catalogo. Por favor elige uno de la lista desplegable", 20001); }
			 
			 $sql = "SELECT COUNT(*) cnt FROM cat_municipios WHERE id_municipio_inegi = '".$data['depe_municipio_id']."'";
			 $cnt = $this->db->GetOne($sql);			 
			 if($cnt == 0){ throw new Exception("<b>Debes de seleccionar un municipio de la lista desplegable</b>", 20001); }
			 
			 $sql = "SELECT COUNT(*) FROM cat_localidad WHERE id_localidad = '".$data['depe_ciudad_id']."'";
			 $cnt = $this->db->GetOne($sql);			 
			 if($cnt == 0){ throw new Exception("La ciudad seleccionada no existe", 20001); }
			 
			 $sql = "SELECT COUNT(*) FROM  cat_clase_calle WHERE id_clase_calle = '".$data['depe_tcalle_id']."'";
			 $cnt = $this->db->GetOne($sql);
			 if($cnt == 0){ throw new Exception("El tipo de calle que proporciono, no existe en el catalogo. Por seleccione uno de la lista desplegable", 20001); }
						 
			 $sql = "SELECT COUNT(*) FROM cat_calles WHERE id_calle = '".$data['depe_calle_id']."'";
			 $cnt = $this->db->GetOne($sql);			 
			 if($cnt == 0){ throw new Exception("La calle proporcionada no existe en el catalogo", 20001); }
			 
			 
			 
			 //recuperamos algunos datos
			 $sql = "
			 SELECT e.id_estado , id_municipio_inegi id_municipio,
					CONCAT(initcap(m.d_municipio),', ',initcap(e.d_estado))  AS info
			   FROM cat_localidad l, cat_municipios m, cat_estados e
			  WHERE l.id_municipio = m.id_municipio_inegi
			    AND m.id_estado  =  e.id_estado
				AND l.id_localidad = '".$data['depe_ciudad_id']."'";
			 $rciudad = $this->db->Execute($sql)->FetchRow();
			 
		     //guardamos los datos en la tabla
		     $sql = "
			 INSERT INTO cat_dependencias (
			        depe_grupo        ,
					depe_nombre       ,
					depe_estado       ,
					depe_municipio    ,
					depe_ciudad       ,
					depe_tcalle       ,
					depe_sufijo       ,
					depe_calle        ,
					depe_entre        ,
					depe_y_entre      ,
					depe_numero       ,
					depe_manzana      ,
					depe_lote         ,
					depe_referencia   ,
					depe_colonia      ,
					depe_cp           ,
					depe_ruta         ,
					depe_insert       ,
					depe_usuario     
			 ) VALUE (
			        '".$data['depe_categoria_id']."',
					'".strtoupper($data['depe_nombre'])."',
					'".$rciudad['id_estado']."',
					'".$rciudad['id_municipio']."',
					'".$data['depe_ciudad_id']."',
					'".$data['depe_tcalle_id']."',
					'".$data['depe_sufijo']."',
					'".strtoupper($data['depe_calle_id'])."',
					'".strtoupper($data['depe_entre'])."',
					'".strtoupper($data['depe_y_entre'])."',
					'".$data['depe_numero']."',
					'".$data['depe_manzana']."',
					'".$data['depe_lote']."',					
					'".strtoupper($data['depe_referencia'])."',
					'".strtoupper($data['depe_colonia_id'])."',
					'".$data['depe_cp']."',
					'".$data['depe_ruta']."',
					now() ,
					'".$_SESSION['id_usuario']."'
			 );";
			 
			 $this->db->Execute($sql);
			 $next = $this->db->Insert_ID();
			 
			 return array('success'=>true, 'message' => 'La dependencia se ha agregado al catalogo', 'id'=>$next, 'nombre'=>strtoupper($data['depe_nombre']) );
		     
			 
		}catch(Exception $e){		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception($e->getMessage() , $e->getCode());	
		}				
    }
	
    /**
    * Obtiene el catalogo de dependencias
	* $search - string : palabra a buscar
	* $return - string : Forma en que debe de devolver los datos
    */	
    public function getInfoGrupos($person) {        	
		try 
		{    
		     $sql = "
			 SELECT pins_id          AS id, 
				    pins_persona     AS persona , 
				    pins_grupo       AS grupo ,
				    ( SELECT d_grupo FROM cat_grupos WHERE id_grup = pins_grupo) AS ngrupo,
				    pins_dependencia AS dependencia,
				    ( SELECT depe_nombre FROM cat_dependencias WHERE depe_dependencia = pins_dependencia) AS ndependencia,       
				    pins_cargo       AS cargo,
					pins_jerarquia   AS jerarquia
			   FROM contact_institutions
			  WHERE pins_persona = '".$person."'";
			  
			 $rs = $this->db->Execute($sql); 
			 
			 $index = 1;
			 while ($row = $rs->FetchRow()){
			        echo '<tbody name="detail" id="detail">';
				    echo ' <tr class="dataRow">';
				    echo '  <th width="200" class="label">Grupo :</th>';
				    echo '  <td class="data">'; 
					echo '    <input type="text"   name="grup_grupo[]"     id="grup_grupo_'.$index.'" maxlength="200" value="'.$row['ngrupo'].'" allowblank="false" style="width: 400px;"  class="x-form-field" onblur="contacto.validate(\'grup_grupo_'.$index.'\',\'S\',\'grupo\')" />';
			        echo '    <input type="hidden" name="grup_grupo_id[]"  id="grup_grupo_id_'.$index.'" value="'.$row['grupo'].'" />';
					echo '  </td>';
					echo '  <td class="delete_msg"><a href="javascript: void(0);" onclick=" tbl.confirm(\'delete\', null, '.$index.'); " title="Eliminar Grupo"> </a></td>';
					echo ' </tr>';
					echo ' <tr class="dataRow">';
					echo '   <th class="label">Instituci&oacute;n :</th>';
					echo '   <td class="data">';
					echo '      <input type="text"   name="grup_dependencia[]"    id="grup_dependencia_'.$index.'" maxlength="200" value="'.$row['ndependencia'].'" allowblank="false" style="width: 400px;" class="x-form-field"  onblur="contacto.validate(\'grup_dependencia_'.$index.'\',\'S\',\'dependencia\')"/>';
					echo '      <input type="hidden" name="grup_dependencia_id[]" id="grup_dependencia_id_'.$index.'" value="'.$row['dependencia'].'"/> ';
					//echo '      <a href="javascript: void(0)" onclick="jQuery.facebox({ ajax: \'process.php?action=dependencia.getFrm&return[name]=grup_dependencia_'.$index.'&return[id]=grup_dependencia_id_'.$index.'\'})"> <img src="../imagenes/add_dependencia.png" border="0" width="18" height="18" align="baseline" title="si no existe la dependencia, clic para agregarla" /> </a></td>';
					echo '   <td class="rightCol">&nbsp;</td>';
					echo ' </tr>';
					echo ' <tr class="dataRow">';
					echo '  <th class="label">Cargo :</th>';
					echo '  <td class="data">';
					echo '    <input type="text" name="grup_cargo[]" id="grup_cargo_'.$index.'"  maxlength="200" value="'.$row['cargo'].'" allowblank="false" style="width: 400px;" class="x-form-field"  onblur="this.value= this.value.toUpperCase()"/></td>';
					echo '  <td class="rightCol">&nbsp;</td>';
					echo ' </tr>';
					echo ' <tr class="dataRow">';
					echo '   <th class="label">Jerarquia :</th>';
					echo '   <td class="data">';
					echo '     <select name="grup_jerarquia[]" id="grup_jerarquia_id_'.$index.'" class="x-form-field" style="width:400px">';
					echo '       <option value=""> Jerarquia </option>';
				         	     $sql = "SELECT id_jerarquia AS clave, nom_jerarquia AS descrip FROM cat_jerarquias ORDER BY orden_jer";
		                         select($sql,'descrip','clave',$row['jerarquia'],'query');
					echo '     </select>';
					echo '   </td>';
					echo '   <td class="rightCol">&nbsp;</td>';
					echo ' </tr>';
					echo ' <tr class="spacer"><td colspan="3"><hr></td></tr>';
					echo '</tbody>';
					echo '<script>';
					echo '    var name = "grup_grupo_'.$index.'";'.chr(13);	
					echo '    var suggest = new bsn.AutoSuggest( name , {'.chr(13);
		            echo '        script     : "process.php?action=grupo.getList&",'.chr(13);
					echo '        meth       : "get",'.chr(13);
					echo '        varname    : "query",'.chr(13);
					echo '        json       : true,'.chr(13);
					echo '        shownoresults:false,				// If disable, display nothing if no results'.chr(13);
					echo '        noresults  :"No hay resultados - Agregar ",			// String displayed when no results'.chr(13);
					echo '        maxresults : 10,					// Max num results displayed'.chr(13);
					echo '        cache      : true,				// To enable cache'.chr(13);
					echo '        minchars   : 1,					// Start AJAX request with at leat 2 chars'.chr(13);
					echo '        timeout    : 4000,				// AutoHide in XX ms'.chr(13);
					echo '        callback   : function (obj) { 	// Callback after click or selection'.chr(13);
					echo '          	$("#grup_grupo_id_'.$index.'").val(obj.id);'.chr(13);
					echo '        }'.chr(13);
					echo '  	});'.chr(13);					
					//==============================================================================
				    echo 'var name = "grup_dependencia_'.$index.'";'.chr(13);			
				    echo 'var au = new bsn.AutoSuggest(name, {'.chr(13);
					echo '    script   : "process.php?tip=a&action=dependencia.getList&",'.chr(13);
					echo '    meth     : "get",'.chr(13);
					echo '    varname  : "query",'.chr(13);
					echo '    json     : true,'.chr(13);
					echo '    shownoresults:true,				// If disable, display nothing if no results'.chr(13);
					echo '    noresults:"No hay resultados - Agregar ",			// String displayed when no results'.chr(13);
					echo '    handleNoResult : function(){'.chr(13);
		            echo '       var grupo = $("#grup_grupo_id_'.$index.'").val();'.chr(13);
					echo '       if(grupo.length==0 || grupo ==""){'.chr(13);
					echo '	        alert("Antes de continuar, debes de elegir un grupo"); return false;'.chr(13);
					echo '       }'.chr(13);
					echo '       jQuery.facebox({ ajax: \'process.php?grupo='.$row['grupo'].'&action=dependencia.getFrm&return[name]=grup_dependencia_'.$index.'&return[id]=grup_dependencia_id_'.$index.'\'})'.chr(13);
					echo '    },'.chr(13);
					echo '    maxresults:10,					// Max num results displayed'.chr(13);
					echo '    width     : 500,'.chr(13);
					echo '    cache    : true,				// To enable cache'.chr(13);
					echo '    minchars : 1,					// Start AJAX request with at leat 2 chars'.chr(13);
					echo '    timeout  : 10000,				// AutoHide in XX ms'.chr(13);
					echo '    //getFields: { grupo : "#grup_grupo_id_'.$index.'"},'.chr(13);
					echo '    callback : function (obj) { 	// Callback after click or selection'.chr(13);
				    echo '	      $("#grup_dependencia_id_'.$index.'").val(obj.id);'.chr(13);
					echo '    }'.chr(13);
			        echo '});'.chr(13);
					echo "</script>";
					
					$index++;
			 }
			
		
			 
			 
		}catch(Exception $e){		   
			$this->setError($e->getCode(), $e->getMessage());
			throw new Exception( $e->getMessage() , $e->getCode() );	
		}				
    }
	
	
	public function query($stm){
	       try 
		   {
		    	$rs = $db->Execute($stm);
				return $rs;
		   
		   }catch(Exception $e){
		        $this->setError($e->getCode(), $e->getMessage()); 
			    return false;
		   
		   }
	}
    
	
	public function setError( $code, $message ) {
        $this->errors['code']    =  $code;
		$this->errors['message'] = $message;
				
		return $this->errors;	
    }
	
	public function getError() {
        return $this->errors;	
    }
	
	public function cleanErrors(){
	    $this->errors = array();
	}
	
	
	
	
	
}


?>