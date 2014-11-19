<?php 
		header("Content-Type: text/html; charset=iso-8859-1");
	    header("Content-Encoding :iso-8859-1");
	 
		include("../include/conexion_bd.php");
	    include('../include/funciones_v2.php');
        f_verifica_sesion();
		

		$id_grupo = strtoupper($_GET['id_grup']);
        $comoabrir = $_GET['como'];
		
		/*$sql = "
		SELECT pers_persona  ,
			   CONCAT_WS(' ' ,pers_nombre, pers_apat, pers_amat) nombre,
			   pers_grupo    ,
			   pers_cargo    ,
			   pers_dependencia
			   pers_jerarquia,
			   pers_tel_dep  ,
			   pers_ext_dep  ,
			   pers_email
		  FROM ( SELECT pers_persona persona, pers_grupo grupo
				   FROM personas 
				  UNION ALL
				 SELECT pins_persona persona, pins_grupo grupo
				   FROM contact_institutions
			   ) g, personas p
		 WHERE g.persona = p.pers_persona
		   AND g.grupo   = '".$id_grupo."'
		   AND p.pers_jerarquia = 1";*/
		   		
		//buscamos las personas que pertenecen al grupo seleccionado titulares
        $sql = "
		SELECT pers_persona     AS persona,
               CONCAT_WS(' '  ,pers_nombre, pers_apat, pers_amat) nombre,
			   pers_grupo       AS grupo,
			   ( SELECT d_grupo FROM cat_grupos WHERE id_grup = pers_grupo ) AS ngrupo ,
			   pers_cargo       AS cargo    ,
			   pers_jerarquia   AS jerarquia,
			   pers_dependencia AS dependencia,
			   pers_tel_dep     AS tel,
			   pers_ext_dep     AS ext,
			   pers_email       AS email 
		  FROM personas 
		 WHERE pers_grupo       = '".$id_grupo."'
		   AND pers_jerarquia   = 1
         UNION ALL  
        SELECT pers_persona     AS persona,
	   	       CONCAT_WS(' ',pers_nombre, pers_apat, pers_amat) nombre,
			   pins_grupo       AS grupo,
			   ( SELECT d_grupo FROM cat_grupos WHERE id_grup = pins_grupo ) AS ngrupo ,
			   pins_cargo       AS cargo,
			   pins_jerarquia   AS jerarquia,
			   pers_dependencia AS dependencia,
			   pers_tel_dep     AS tel   ,
			   pers_ext_dep     AS ext   ,
			   pers_email       AS email 
		  FROM personas  , contact_institutions 
		 WHERE pers_persona     = pins_persona 
		   AND pins_grupo       = '".$id_grupo."'
		   AND pins_jerarquia   = 1";
		   
				
		$resource =mysql_query($sql,$cn);
	
        

?>	
					
<form name="form_links" method="GET" action="inicio.php" id="form_links" >		

<!--//////////////////////////// TITULARES (titulares)  //////////////////////////////////////-->
		
		<div style="display:block;visibility:visible;width:100%;height:100%;overflow:auto;left:0;" id="pre_titular">
		<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
	   	
		<?php 
			$numero=0;
			while ($arreglo=mysql_fetch_array($resource) ){				
						
		?> 
                <tr>
                     <td colspan="2">&nbsp;<font class="contenido"><?php echo $arreglo['ngrupo'];?></font></td>
                </tr>
                <tr>
        
                    <td class="contenido" width="30px">&nbsp;<?php echo $numero;?> </td>
                    <td ><?php echo $icongremio; ?> &nbsp;<font class="contacto" onclick="javascript:popup('<?php echo $arreglo['persona'];?>');" style="cursor:pointer;"><b><?php echo $arreglo['nombre'];?></b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font class="contenido"><?php echo '('.substr($arreglo['tel'],0,3).') '.substr($arreglo['tel'],3,3).'-'.substr($arreglo['tel'],6,4);;?>&nbsp;&nbsp;&nbsp;&nbsp;Ext. <?php echo $arreglo['ext'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $arreglo['email'];?></font></td>
                </tr>
                <tr>
                     <td>&nbsp;</td>
                  <td><div style="font-size:11px;font-family:lucida grande,tahoma,verdana,arial,sans-serif;"><?php echo $arreglo['cargo']; ?></div></td>
                </tr>
                <tr>
                     <td colspan="2">&nbsp;<font class="contenido"><?php echo $arreglo['ndependencia'];?></font></td>
                </tr>
                <tr>
                     <td style="border-bottom: dotted  1px #000000" colspan="2">&nbsp;</td>
                </tr>
		<?php	
				$numero++;
								
			}  
		?>
		
		</table>
		</div>

	
<!--//////////////////////////// NO TITULARES (*)  //////////////////////////////////////-->
<?php 
        
		//buscamos las personas que pertenecen al grupo seleccionado titulares
        $sql = "
		SELECT pers_persona     AS persona,
               CONCAT_WS(' '  ,pers_nombre, pers_apat, pers_amat) nombre,
			   pers_grupo       AS grupo,
			   ( SELECT d_grupo FROM cat_grupos WHERE id_grup = pers_grupo ) AS ngrupo ,
			   pers_cargo       AS cargo    ,
			   pers_jerarquia   AS jerarquia,
			   pers_dependencia AS dependencia,
			   pers_tel_dep     AS tel,
			   pers_ext_dep     AS ext,
			   pers_email       AS email 
		  FROM personas 
		 WHERE pers_grupo     = '".$id_grupo."'
		   AND pers_jerarquia <> 1
         UNION ALL  
        SELECT pers_persona     AS persona,
	   	       CONCAT_WS(' ',pers_nombre, pers_apat, pers_amat) nombre,
			   pins_grupo       AS grupo,
			   ( SELECT d_grupo FROM cat_grupos WHERE id_grup = pins_grupo ) AS ngrupo ,
			   pins_cargo       AS cargo,
			   pins_jerarquia   AS jerarquia,
			   pers_dependencia AS dependencia,
			   pers_tel_dep     AS tel   ,
			   pers_ext_dep     AS ext   ,
			   pers_email       AS email 
		  FROM personas  , contact_institutions 
		 WHERE pers_persona    = pins_persona 
		   AND pins_grupo      = '".$id_grupo."'
		   AND pins_jerarquia  <> 1";
		 $resource =mysql_query($sql,$cn);

?>
		<div style="display:none;visibility:hidden; overflow:auto;height:100%;width:100%;left:0;" id="pre_grupo">
		<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
		<?php 
			$numero=1;
		    while ($arreglo=mysql_fetch_array($resource) ){
				
						
						
		?> 
			<tr>
				 <td colspan="2">&nbsp;<font class="contenido"><?php echo $arreglo['ngrupo'];?></font></td>
			</tr>
			<tr>
			

				<td class="contenido" width="30px">&nbsp;<?php echo $numero;?> </td>
				<td ><?php echo $icongremio; ?>&nbsp;<font class="contacto" onclick="javascript:popup('<?php echo $arreglo['persona'];?>');" style="cursor:pointer;"><b><?php  echo $arreglo['nombre'];?></b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font class="contenido"><?php echo '('.substr($arreglo['tel'],0,3).') '.substr($arreglo['tel'],3,3).'-'.substr($arreglo['tel'],6,4); ?> &nbsp;&nbsp;&nbsp;&nbsp;Ext. <?php echo $arreglo['ext'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $arreglo['email'];?></font></td>
			</tr>
			<tr>
				 <td>&nbsp;</td>
			  <td><div style="font-size:11px;font-family:lucida grande,tahoma,verdana,arial,sans-serif;"><?php echo $arreglo['cargo']; ?></div></td>
			</tr>
			<tr>
				 <td colspan="2">&nbsp;<font class="contenido"><?php echo $arreglo['ndependencia']; ?></font></td>
			</tr>
			<tr>
				 <td style="border-bottom: dotted  1px #000000" colspan="2">&nbsp;</td>
				 
			</tr>
		<?php	
				$numero++;	
												
			}

		?>
		
		</table>
		</div>

	
</form>				
