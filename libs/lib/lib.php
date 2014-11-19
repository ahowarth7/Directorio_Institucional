<?PHP

function select($query,$label,$value,$id, $tipo){
		 global $db;
		
		
		 if ($tipo == 'array') {
			 if (is_array($query)){
				foreach($query as $key => $value){
					echo "<option value=\"".$key."\" ";
					if ($key==$id)
						echo " selected ";
					echo ">";
					echo ($value);
					echo "</option>";
				} 
				return;
			 }
		 }elseif($tipo=='query') {
			
			 $rs = $db->Execute($query);			 
			 while ($row=$rs->FetchRow() ){
					echo "<option value=\"".$row[$value]."\" ";
					if ($row[$value]==$id)
						echo " selected ";
					echo ">";
					echo $row[$label];
					echo "</option>";
				
			 }
			 
		 }elseif($tipo=='enum'){
			 $rs      = $db->Execute($query);
			 $row     = $rs->FetchRow();
			 $valores = explode(',',substr($row['Type'],5,strlen($row['Type'])-6));
			  
			 if(count($valores)>0){
				foreach($valores as $key => $value){
					$value=str_replace("'",'',$value);
					
					echo "<option value=\"".$value."\" ";
					if ($value==$id)
						echo " selected ";
					echo ">";
					echo $value;
					echo "</option>";
				} 
				return;
			 }	 
		 }
}


class cronometro { 
    var $comienzo; 
    // me devuelve un tiempo en segundos y milisegundos 
    function _getmicrotime() { 
 
        list($_milisegundos, $_segundos) = explode(" ", microtime()); 		
		return ((float)$_milisegundos + (float)$_segundos); 
		
    } 
 
    // constructor cronometro 
    function cronometro() { 
 
        $this->comienzo = $this->_getmicrotime(); 
		return true; 
    } 
 
    // para el cronometro y devuelve el tiempo 
    // se puede dar una salida formateada a traves de los parametros. 
    //  
    // Si $formatear esta a verdadero entonces devolvera cuantos segundos 
    // se demoro con $nroDecimales decimales (milisegundos). 
    function stop($formatear = false, $nroDecimales = 0) { 
        
		//time in seconds
        $seconds  = $this->_getmicrotime() - $this->comienzo; 
				
        $minutos  = intval($seconds / 60);
		$seg      = intval($seconds % 60);
		$mil      = ($seconds % 1000);
		
		$text_min = str_pad($minutos, 2, "0", STR_PAD_LEFT);
		$text_seg = str_pad($seg, 2, "0", STR_PAD_LEFT);
		$text_mil = str_pad($mil, 3, "0", STR_PAD_LEFT);
		
		$time = ($seconds * 1000);
		(int) $milliseconds = (int)($time % 1000);
		(int) $seconds = (int)(($time/1000) % 60);
		(int) $minutes = (int)(($time/60000) % 60);
		(int) $hours = (int)(($time/3600000) % 24);
		
		(string) $millisecondsStr = ($milliseconds<10 ? "00" : ($milliseconds<100 ? "0" : "")). $milliseconds;
		(string) $secondsStr      = ($seconds<10 ? "0" : ""). $seconds;
		(string) $minutesStr      = ($minutes<10 ? "0" : ""). $minutes;
		(string) $hoursStr        = ($hours<10 ? "0" : ""). $hours;
		
		
		//echo $hoursStr . ":" . $minutesStr . ":" . $secondsStr . ".".  $millisecondsStr;
		
		return ($text_min .':'.$text_seg . '.'.$text_mil);
		
        //return ($formatear) ? number_format($_tiempo, $nroDecimales, '.', ',') : $_tiempo; 
    } 
}

function getDias(){
         $dias = array();
		 
		 for ($c = 1; $c<=31; $c++) {
		      $dias[$c] = str_pad($c,2,'0',STR_PAD_LEFT);
		 }
		 
		 return $dias;
}
function getMes($m= NULL){
         
		 $mes = array("01"  => 'ENERO'  , "02"  => 'FEBRERO'  , "03" => 'MARZO',  
	                  "04"  => 'ABRIL'  , "05"  => 'MAYO'     , "06" => 'JUNIO', 
		 		      "07"  => 'JULIO'  , "08"  => 'AGOSTO'   , "09" => 'SEPTIEMBRE',
					  "10"  => 'OCTUBRE', "11"  => 'NOVIEMBRE', "12" => 'DICIEMBRE'
		 );
		 
		 if ($m!=NULL)
		    return ($mes[$m]);
		
		return ($mes);

}
function getAnio($ini,$fin){
         $anios = array();
		 for ($c= $fin; $c >= $ini; $c--){
			  $anios[$c] = $c; 
		 }
		 return ($anios);

}

function cambiarFormatoFecha($fecha){ 
         list($dia,$mes,$anio)=explode("/",$fecha); 
	     $fech=$anio."-".$mes."-".$dia;
         return $fech;
}

function json($str,$mode){
            
			require_once("./../libs/json/json.php");
			 
			if(function_exists('json_encode')){
			   if ($mode == 'encode'){
			      return json_encode($str);
			   }elseif($mode == 'decode'){
			      return json_decode($str,true);
			   }
			}else{
			   //include_once('json.php');
			   $json = new Services_JSON();
			   if ($mode == 'encode'){
			      return $json->encode($str);
			   }elseif($mode == 'decode'){
			      return $json->decode($str);
			   } 
			
			}
}

?>