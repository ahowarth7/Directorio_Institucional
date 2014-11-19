<?

function OrraError($msg){
         $ini = strpos($msg,'[');
         $fin = strpos($msg,']');
  
		 $err= substr(
		       $msg,
		       $ini,
			   $fin-$ini+1
		 );
		 return utf8_encode($err);
		 

}


function utf8_encode_array($array){
         $result_array = array();
		 
		 if (is_array($array)){   
             foreach($array as $key => $value){     
                 if (is_array($value)){      //recursivo
				     $result_array[utf8_encode($key)] = utf8_encode_array($value);
				 }elseif(is_string($value)){ //cadena la codifica
			         $result_array[utf8_encode($key)] = utf8_encode($value);
                 }else{                     //cualquier otro valor solo lo copia
                     $result_array[utf8_encode($key)] = $value;
		         }
		     }
         }else{
		     return  utf8_encode($array);
		 }
		 
         return $result_array;
}

function utf8_decode_array($array){
         $result_array = array();
		 
		 if (is_array($array)){   
             foreach($array as $key => $value){     
                 if (is_array($value)){      //recursivo
				     $result_array[utf8_decode($key)] = utf8_decode_array($value);
				 }elseif(is_string($value)){ //cadena la codifica
			         $result_array[utf8_decode($key)] = utf8_decode($value);
                 }else{                     //cualquier otro valor solo lo copia
                     $result_array[utf8_decode($key)] = $value;
		         }
		     }
         }else{
		     return  utf8_decode($array);
		 }
		 
         return $result_array;
}

/**
 * Determines array type ("vector" or "map"). Returns false if not an array at all.
 * (I hope a native function will be introduced in some future release of PHP, because
 * this check is inefficient and quite costly in worst case scenario.)
 *
 * @param array $array The array to analyze
 * @return string array type ("vector" or "map") or false if not an array
 */

function array_type($array){
         if (is_array($array)) {
             $next = 0;

             $return_value = "vector";  // we have a vector until proved otherwise
             
			 foreach ($array as $key => $value){
			          if ($key != $next) {
					      $return_value = "map";  // we have a map
						   break;
					  }
					  $next++;
			 }
			 return $return_value;
         }

         return false;    // not array
}


function mapCodeError($code){
		 
		 switch ($code) {
			case 'DB-10': return array('rgb' => '000000');
			case 0x09: return array('rgb' => 'FFFFFF');
			case 0x0A: return array('rgb' => 'FF0000');
			case 0x0B: return array('rgb' => '00FF00');
			case 0x0C: return array('rgb' => '0000FF');
			case 0x0D: return array('rgb' => 'FFFF00');
			case 0x0E: return array('rgb' => 'FF00FF');
			case 0x0F: return array('rgb' => '00FFFF');
			case 0x10: return array('rgb' => '800000');
			case 0x11: return array('rgb' => '008000');
			case 0x12: return array('rgb' => '000080');
			case 0x13: return array('rgb' => '808000');
			case 0x14: return array('rgb' => '800080');
			case 0x15: return array('rgb' => '008080');
			case 0x16: return array('rgb' => 'C0C0C0');
			case 0x17: return array('rgb' => '808080');
			case 0x18: return array('rgb' => '9999FF');
			case 0x19: return array('rgb' => '993366');
			case 0x1A: return array('rgb' => 'FFFFCC');
			case 0x1B: return array('rgb' => 'CCFFFF');
			case 0x1C: return array('rgb' => '660066');
			case 0x1D: return array('rgb' => 'FF8080');
			case 0x1E: return array('rgb' => '0066CC');
			case 0x1F: return array('rgb' => 'CCCCFF');
			case 0x20: return array('rgb' => '000080');
			case 0x21: return array('rgb' => 'FF00FF');
			case 0x22: return array('rgb' => 'FFFF00');
			case 0x23: return array('rgb' => '00FFFF');
			case 0x24: return array('rgb' => '800080');
			case 0x25: return array('rgb' => '800000');
			case 0x26: return array('rgb' => '008080');
			case 0x27: return array('rgb' => '0000FF');
			case 0x28: return array('rgb' => '00CCFF');
			case 0x29: return array('rgb' => 'CCFFFF');
			case 0x2A: return array('rgb' => 'CCFFCC');
			case 0x2B: return array('rgb' => 'FFFF99');
			case 0x2C: return array('rgb' => '99CCFF');
			case 0x2D: return array('rgb' => 'FF99CC');
			case 0x2E: return array('rgb' => 'CC99FF');
			case 0x2F: return array('rgb' => 'FFCC99');
			case 0x30: return array('rgb' => '3366FF');
			case 0x31: return array('rgb' => '33CCCC');
			case 0x32: return array('rgb' => '99CC00');
			case 0x33: return array('rgb' => 'FFCC00');
			case 0x34: return array('rgb' => 'FF9900');
			case 0x35: return array('rgb' => 'FF6600');
			case 0x36: return array('rgb' => '666699');
			case 0x37: return array('rgb' => '969696');
			case 0x38: return array('rgb' => '003366');
			case 0x39: return array('rgb' => '339966');
			case 0x3A: return array('rgb' => '003300');
			case 0x3B: return array('rgb' => '333300');
			case 0x3C: return array('rgb' => '993300');
			case 0x3D: return array('rgb' => '993366');
			case 0x3E: return array('rgb' => '333399');
			case 0x3F: return array('rgb' => '333333');
			default:   return array('rgb' => '000000');
		}
}



$_POST= utf8_decode_array($_POST);
$_GET = utf8_decode_array($_GET);
?>