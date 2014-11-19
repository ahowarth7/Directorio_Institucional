<?php
function Conectar (){
    try {
				  $db = &ADONewConnection("mysqli");
				  $db->Connect(SERVER,USER,PASS,DB);
				  $db->SetFetchMode(ADODB_FETCH_ASSOC);
			      $db->multiQuery = true;
				  return $db;
			 }catch(Exception $e){
				  $result["success"] = false;
                  $result["errors"]["msg"] = $e->getMessage();
				  echo json_encode($result);
				  exit (1);	          
	         }
	}
?>