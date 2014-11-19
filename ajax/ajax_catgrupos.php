<?php 
include("../include/conexion_bd.php");
include("../include/funciones_v2.php");
header('<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />');
header('<meta http-equiv="Expires" content="Tue, 01 Dec 1991 06:30:00 GMT">');

$categoria=strtoupper($_GET['categoria']);

echo'<div  style="width:100%;height:420px;overflow:auto" align="center">';
echo'<table width="100%" border="0">';

 echo $sqlcategoria="select count(id_grupo )as num,id_grup, id_categoria,d_grupo,id_grupo 
from cat_grupos inner join tb_contactos on id_grup=id_grupo where id_categoria='$categoria' GROUP by d_grupo";
			$recurso=mysql_query($sqlcategoria,$cn);		
			 while ($bb=mysql_fetch_array($recurso) )	
				{		
					
				if ($bb['d_grupo']==''){	
					echo '<tr><td bgcolor="#585858" class="titulo" align="left" >NO CONTIENE GRUPO</td></tr>';
		 		}else{ 
		 			$grupo=$bb['d_grupo'];
		 			 echo $sqlnum="select count(* )as num,trabajo_idgrupo from tb_contactos  
					where trabajo_categoria='$grupo' ";
		 
		 			$ww=mysql_fetch_array(mysql_query($sqlnum,$cn));
					echo '<tr> <td bgcolor="#585858" class="titulo" align="left" >'.$bb['d_grupo'].' ('.$ww['num'].')</td></tr>';
				 } 
			} 
	  
echo'</table>';
echo'</div>';

?>