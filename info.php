<?

 $str = '[{"pers_persona":"JONATHAN VARGAS ACOSTA","isinvited":true},{"pers_persona":"JONATHAN ADOLFO GONZÁLEZ GARCÍA","isinvited":true},{"pers_persona":"JOSÉ LUIS JONATHAN YONG MENDOZA","isinvited":false}]';
 $str = utf8_encode($str);
 
 
 require_once('libs/json/json.php');
 echo "<pre>";
 
 $json = new Services_JSON();		
 print_r($json->decode($str));
 
 $json = new Services_JSON(1);		
 print_r($json->decode($str));
 
 $json = new Services_JSON(2);		
 print_r($json->decode($str));
 
 $json = new Services_JSON(3);		
 print_r($json->decode($str));
 
 $json = new Services_JSON(4);		
 print_r($json->decode($str));
 
  $json = new Services_JSON(5);		
 print_r($json->decode($str));
 
 
 
 


echo utf8_encode($str);
?>