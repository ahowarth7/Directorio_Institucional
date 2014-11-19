<?php

/**
 * Object class, allowing __construct in PHP4.
 */

class Object
{

	/**
	 * An array of errors
	 *
	 * @var		array of error messages or JExceptions objects
	 * @access	protected
	 * @since	1.0
	 */
    public	$errors		= array();
	
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
	function Object()
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
	function __construct() {}
	
	/**	 
	 * Returns an associative array of object properties
	 *
	 * @access	public
	 * @param	boolean $public If true, returns only the public properties
	 * @return	array
	 * @see		get()
	 * @since	1.5
 	 */
	private function getProperties( $public = true )
	{
		$vars  = get_object_vars($this);
        if($public)		{
			foreach ($vars as $key => $value)
			{
				if ('_' == substr($key, 0, 1)) {
					unset($vars[$key]);
				}
			}
		}

        return $vars;
	}
	

	/**
	 * Object-to-string conversion.
	 * Each class can override it as necessary.
	 *
	 * @access	public
	 * @return	string This name of this class
	 * @since	1.5
 	 */
	function toString()
	{
		return get_class($this);
	}
	
	/**
	 * Returns an associative array of object properties
	 *
	 * @access	public
	 * @param	string  $error, name of de error cause the exception ex. error = array(code, message)
	 * @param	integer $code , code of de error
	 * @param	string  $msg  , description of the message
	 * @return	array[code] = message
 	 */
	public function setError($error, $code, $msg){
	    $this->errors[$error] = array('code'=>$code, 'message'=>$msg);		
	}
	
	
	/**
	 * Returns an associative array of object properties
	 *
	 * @access	public
	 * @param	string  $error, if empty return all array with errors, else return property
	 * @return	array[code] = message
 	 */
	public function getError($error=null){
	    if ( ! array_key_exists($error, $this->_errors) ) {
		       return false;
		}
		return $this->errors;
	}
	
	/**
	 * clear error array
	 */
	public function resetError(){
	    $this->errors = array();
	}

	

	/**
	 * Legacy Method, use {@link JObject::getProperties()}  instead
	 *
	 * @deprecated as of 1.5
	 * @since 1.0
	 */
	function getPublicProperties()
	{
		return $this->getProperties();
	}
	
	
	/**
	 * Encode Array to string with JSON format
	 */
	public function json_encode($array)
	{
		if(function_exists('json_encode')){
		   return json_encode($array);		   
		}else{
		   $json = $this->instanceJSON(3);
		   return $json->encode($array);		
		}
	}
	
	/**
	 * Decode a array with JSON format
	 */
	public function json_decode($str)
	{   
		if(function_exists('json_decode')){
		   return json_decode($str, true);
			
		}else{
		   $json = $this->instanceJSON(4);
		   return $json->decode($str);		
		}
	}
	
	private function instanceJSON($mode){
	     require_once("../libs/json/json.php");
		 
		
		 $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);		 
		 return $json;
	}
	
}
