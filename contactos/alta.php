<?PHP
    
	  
	  $path = '../../'; //dirname(__FILE__);
	  require_once ("../libs/adodb/adodb-exceptions.inc.php");
	  require_once ("../libs/adodb/adodb.inc.php");
	  require_once ("../includes/utf8.php");
	  require_once ("../includes/config.php");
	  require_once ("../includes/conexion.php");
	  require_once ("../libs/lib/lib.php");
	  
	  include('../include/funciones_v2.php');
      f_verifica_sesion();

      
	  $db = Conectar();
	  
	  

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Agregar Contacto</title>
    
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />    
    
    <link rel="stylesheet" type="text/css" href="tabs.css"/>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <link rel="stylesheet" type="text/css" href="../js/facebox/facebox.css"/>
    
    <!-- Loading jQuery Framework -->
    <script type="text/javascript" src="../jquery/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="../js/facebox/facebox.js" ></script>
    <script type="text/javascript" src="../js/jquery-validate/jquery.validate.js"></script>
    
	
    <!-- Autosuggest module -->
	<link rel="stylesheet" href="../js/autosuggest/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8">	
	<script type="text/javascript" src="../js/jquery.watermarkinput.js"></script>	
	<script type="text/javascript" src="../js/autosuggest/bsn.AutoSuggest_2.1.3.js"></script>    
    <script type="text/javascript" src="uY7J9nHYsMxZs.js"></script>
    
    <script type='text/javascript' src='../js/autocompletex/lib/jquery.bgiframe.min.js'></script>
    <script type='text/javascript' src='../js/autocompletex/lib/jquery.ajaxQueue.js'></script>
    <script type='text/javascript' src='../js/autocompletex/lib/thickbox-compressed.js'></script>
    <script type='text/javascript' src='../js/autocompletex/jquery.autocomplete.js'></script>
    <link rel="stylesheet" type="text/css" href="../js/autocompletex/jquery.autocomplete.css" />    
    <script type='text/javascript' src='../js/jquery.scrollTo-min.js'></script>  
	<script src="../js/mask/maskedinput.js" type="text/javascript"></script>
        

    
</head>

<body>
<div class="menu" id="tb-menu">
  <ul>
    <li>
      <table class="table">
        <tr><td><a href="alta.php"><span style="color:yellow;">AGREGAR<br>CONTACTOS</span></a> </td></tr>
      </table>
    </li>
    <li>
      <table class="table">
        <tr><td><a href="modificar.php">MODIFICAR </a></td></tr>
      </table>
    </li>
    <li>
      <table class="table">
        <tr><td><a href="#" onClick="javascript:w_imrpimir();">REPORTES</a></td></tr>
      </table>
    </li>
    <?php if($tipousuario=="Administrador"){?>
    <li>
      <table class="table">
        <tr><td><a href="#" onClick="javascript:panel();" style="cursor:hand;">PANEL<br />DE USUARIOS</a></td></tr>        
      </table>
    </li>
    <?php }	?>
    <li>
      <table class="table">
        <tr><td><a href="#" onClick="javascript:catalogo();">CATALOGOS </a></td></tr>
      </table>
    </li>
    <li>
      <table class="table">
        <tr>
          <td><a href="../inicio.php">INICIO </a></td>
        </tr>
      </table>
     </li>
  </ul>
</div>


<div  id="search-tb" class="busqueda"> <br/>
  <div align="left">
    <form name="frm-search" id="frm-search" method="post" enctype="multipart/form-data">
      <div style="padding-left:15px">
      	<label>Nombre : </label>       
      	<input type="text" name="input_name_src" id="input_name_src" class="x-form-search"  style="width:200px" autocomplete="off" />
        <input type="text" name="input_apat_src" id="input_apat_src" class="x-form-search"  style="width:200px" autocomplete="off" />
        <input type="text" name="input_amat_src" id="input_amat_src" class="x-form-search"  style="width:200px" autocomplete="off" />
        <input type="hidden" name="input_id" id="input_id" />
      </div>
     </form>       
  </div> 
</div>
 
<div align="center" style="font-size:11px">
     <div style="width:1000px">
         <div id="ajax-submit-indicator" class="indicator"> 
               <div> <span> Procesando. Por favor espere .... </span><img src="../imagenes/ajax-loader.gif" border="0" /></div>       
          </div>
          
          <div id="ajax-submit-result" class="indicator" align="center"> 
               <div> <span id="submit-message">&nbsp;</span> </div>       
          </div>
          
          <div id="ajax-submit-error" class="x-error" align="center"> 
               <div> <span id="error-submit-msg">&nbsp;</span> </div>       
          </div>
      </div>
  </div>


 <div id="tabs" class="s-tabs" style="display:none">
   <form name="frm-contacto" id="frm-contacto" method="post">
     
     <ul class="tabs">
         <li><a href="#tab1">Datos Generales</a></li>
         <li><a href="#tab2">Domicilio</a></li>
         <li><a href="#tab3">Dependencia</a></li>
         <li><a href="#tab4">Notas</a></li>
         
         
     </ul>
     
     <div class="tab_container">
        
			 <div id="tab1" class="tab_content">
			  <table class="dataTable" align="center" width="900px" cellpadding="0" cellspacing="0">
				   <tbody>
				     <tr class="dataRow">
				       <th class="label">Titulo : </th>
				       <td class="data"><label for="select"></label>
				         <div style="width:100%">
						    <div style="width:200px; float:left"> 
						       <input type="text" maxlength="200" value="" allowblank="false" style="width: 150px;" id="pers_titulo" class="x-form-field" name="pers_titulo" />
					          <input type="hidden" name="pers_titulo_id" id="pers_titulo_id" />
                            </div>
						    <div  class="label" style=" width:40px;float:left; vertical-align:middle; padding:5px">Sexo :</div>
							<div  style=" width:60px;float:left;">
							  <select name="pers_sexo" id="pers_sexo" class="x-form-field">
							    <option value="">Sexo</option>
								<option value="F">Femenino</option>
							    <option value="M">Masculino</option>
                              </select>
							</div>							
					     </div>			           </td>
				       <td class="rightCol">&nbsp;</td>
			         </tr>
				     <tr class="dataRow">
					   <th width="155" class="label">Nombre :</th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="pers_nombre" class="x-form-field" name="pers_nombre" onblur="this.value = this.value.toUpperCase()" />
			           <input type="hidden" name="pers_persona_id" id="pers_persona_id" /></td>
				       <td width="214" class="rightCol">&nbsp;</td>
				     </tr>
				     <tr class="dataRow">
				       <th class="label">Apellido Paterno  : </th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="pers_apat" class="x-form-field" name="pers_apat"  onblur="this.value = this.value.toUpperCase()"/></td>
				       <td class="rightCol">&nbsp;</td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Apellido Materno: </th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="pers_amat" class="x-form-field" name="pers_amat"  onblur="this.value = this.value.toUpperCase()"/></td>
				       <td class="rightCol"></td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Fecha Nacimiento  :</th>
				       <td class="data">
                         <select name="pers_fndia" id="pers_fndia" class="x-form-field">
                            <option value=""> d&iacute;a </option>
							<?  
							    $dias = getDias(); 	
		                        select($dias,NULL,NULL,NULL,'array');
							    
							?>
                         </select>
				         <select name="pers_fnmes" id="pers_fnmes" class="x-form-field">
                            <option value=""> mes </option>
							<?  
							    $meses = getMes(); 	
		                        select($meses,NULL,NULL,NULL,'array');							    
							?>
                         </select>
				         <select name="pers_fnanio" id="pers_fnanio" class="x-form-field">
                            <option value=""> a&ntilde;o </option>
							<?  
							    $anios = getAnio(1950,date('Y')); 	
		                        select($anios,NULL,NULL,NULL,'array');							    
							?>
                         </select>                         
                       </td>
				       <td class="rightCol"></td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Telefono : </th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="pers_telefono" class="x-form-field" name="pers_telefono" /></td>
				       <td class="rightCol"></td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Celular : </th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="pers_celular" class="x-form-field" name="pers_celular" /></td>
				       <td class="rightCol"></td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Email  : </th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="pers_email" class="x-form-field" name="pers_email" /></td>
				       <td class="rightCol"></td>
			         </tr>
					 <tr class="spacer">
					   <td colspan="3"><hr></td>
					 </tr>
				   </tbody>
				   
				   <tbody>
				     <tr class="dataRow">
				       <th class="label">Nombre esposa : </th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="pers_name_esposa" class="x-form-field" name="pers_name_esposa"  onblur="this.value = this.value.toUpperCase()"/></td>
				       <td class="rightCol">&nbsp;</td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Aniversario :</th>
				       <td class="data">
                         <select name="pers_dia_aniv" id="pers_dia_aniv" class="x-form-field">
                            <option value=""> d&iacute;a </option>
                             <?  
							    $dias = getDias(); 	
		                        select($dias,NULL,NULL,NULL,'array');
							    
							?>
                         </select>
                      <select name="pers_mes_aniv" id="pers_mes_aniv" class="x-form-field">
                            <option value=""> mes </option>
                           <?  
							    $meses = getMes(); 	
		                        select($meses,NULL,NULL,NULL,'array');							    
							?>
                         </select>
                       </td>
				       <td class="rightCol">&nbsp;</td>
			         </tr>
				     <tr class="dataRow">
					 <th class="label">Cumplea&ntilde;os : </th>
					 <td class="data">
                       <select name="pers_fdia_esposa" id="pers_fdia_esposa" class="x-form-field">
                           <option value=""> d&iacute;a </option>
						   <?  
							    $dias = getDias(); 	
		                        select($dias,NULL,NULL,NULL,'array');
							    
							?>
                       </select>
                       <select name="pers_fmes_esposa" id="pers_fmes_esposa" class="x-form-field">
                           <option value=""> mes </option>
                           <?  
							    $meses = getMes(); 	
		                        select($meses,NULL,NULL,NULL,'array');
							    
							?>
                       </select>
                       <select name="pers_fanio_esposa" id="pers_fanio_esposa" class="x-form-field">
                           <option value=""> a&ntilde;o </option>
                          <?  
							    $anios = getAnio(1950,date('Y')); 	
		                        select($anios,NULL,NULL,NULL,'array');							    
					      ?>
                       </select>
                     </td>
					 <td class="rightCol">&nbsp;</td>
				     </tr>
					 <tr class="spacer"><td colspan="3"><hr></td></tr>
				   </tbody>
			   </table>

			 </div>
			 <div id="tab2" class="tab_content">
			   
	     <table class="dataTable" align="center" width="900px" cellpadding="0" cellspacing="0">
				   <tbody>
				     <tr class="dataRow">
					   <th width="155" class="label">Tipo de calle :</th>
				       <td class="data">
                       
                       <div style="width:100%">
						    <div style="width:200px; float:left"> 
						         <input type="text" maxlength="200" value="" allowblank="false" style="width: 150px;" id="pers_tcalle" class="x-form-field" name="pers_tcalle" />
						         <input type="hidden" name="pers_tcalle_id" id="pers_tcalle_id" />
						    </div>
					     <div  class="label" style=" width:50px;float:left; vertical-align:middle; padding:5px">Sufijo :</div>
					     <div  style=" width:60px;float:left;"><span style=" width:120px;float:left;">
                             <select name="pers_sufijo" id="pers_sufijo" class="x-form-field" style="width:100px">
						     <option value=""> Sufijo </option>
						     <?  
							    $sql = "SELECT id_sufijo  AS clave, cve_sufijo  AS descrip FROM cat_sufijo_calle ORDER BY cve_sufijo";
		                        select($sql,'descrip','clave','clave','query');
							    
							?>
					     </select>
						 </span></div>
                       </div>
                          
                       </td>
				       <td width="214" class="rightCol">&nbsp;</td>
				     </tr>
				     <tr class="dataRow">
				       <th class="label">Calle : </th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="pers_calle" class="x-form-field" name="pers_calle" onblur="this.value=this.value.toUpperCase()" /></td>
				       <td class="rightCol">&nbsp;</td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">N&uacute;mero : </th>
				       <td class="data">
					      <div style="width:100%">
						    <div style="width:60px; float:left"> 
						       <input type="text" maxlength="200" value="" allowblank="false" style="width: 50px;" id="pers_numero" class="x-form-field" name="pers_numero" />
						    </div>
						    <div  class="label" style=" width:40px;float:left; vertical-align:middle; padding:5px">Lote :</div>
							<div  style=" width:60px;float:left;"> <input type="text" maxlength="200" value="" allowblank="false" style="width: 50px;" id="pers_lote" class="x-form-field" name="pers_lote" />
							</div>
							<div  class="label" style=" width:70px;float:left; vertical-align:middle; padding:5px">Manzana :</div>
							<div  style=" width:60px;float:left;"> <input type="text" maxlength="200" value="" allowblank="false" style="width: 50px;" id="pers_manzana" class="x-form-field" name="pers_manzana" />
							</div>
						  </div>					   </td>
				       <td class="rightCol"></td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Colonia :</th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="pers_colonia" class="x-form-field" name="pers_colonia" onblur="this.value= this.value.toUpperCase()" />
			           <input type="hidden" name="pers_colonia_id" id="pers_colonia_id" /></td>
				       <td class="rightCol"></td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">CP : </th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="pers_cp" class="x-form-field" name="pers_cp" /></td>
				       <td class="rightCol"></td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Referencia : </th>
				       <td class="data"><textarea name="pers_refdomi" rows="2" class="x-form-item" id="pers_refdomi" style="width: 400px;" onblur="this.value= this.value.toUpperCase()"></textarea></td>
				       <td class="rightCol"></td>
			         </tr>
					 <tr class="spacer">
					   <td colspan="3"><hr></td>
					 </tr>
				   </tbody>
				   
				   <tbody>
				     <tr class="dataRow">
					 <th class="label">Invitaciones : </th>
					 <td class="data">
                       <div>
                         <div>
                              <input type="checkbox" id="pers_dia_mujer" name="pers_dia_mujer" value="S">
					          <label for="pers_dia_mujer">D&iacute;a internacional de la mujer </label>
					     </div>
                         <div>
                              <input type="checkbox" id="pers_dia_maestra" name="pers_dia_maestra" value="S">
					          <label for="pers_dia_maestra">D&iacute;a de la maestra </label>
					     </div>
                         <div>
                              <input type="checkbox" id="pers_voto_femenino" name="pers_voto_femenino" value="S">
					          <label for="pers_voto_femenino">Voto femenino (23 de sep) </label>
					     </div>
                       </div>
                      </td>
					 <td class="rightCol">&nbsp;</td>
				     </tr>
					 <tr class="spacer"><td colspan="3"><hr></td></tr>
				   </tbody>
			   </table>
</div>
			 
             
             <div id="tab3" class="tab_content">
         <table id="table-ins" class="dataTable" align="center" width="900px" cellpadding="0" cellspacing="0">
				   <tbody>
				     <tr class="dataRow">
					   <th width="140" class="label">Grupo :</th>
				       <td width="442" class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="pers_dep_grupo" class="x-form-field" name="pers_dep_grupo" />
			           <input type="hidden" name="pers_dep_grupo_id" id="pers_dep_grupo_id" /></td>
				       <td width="316" class="rightCol">&nbsp;</td>
				     </tr>
				     <tr class="dataRow">
				       <th class="label">Dependencia : </th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="pers_dependencia" class="x-form-field" name="pers_dependencia" />
			           <input type="hidden" name="pers_dependencia_id" id="pers_dependencia_id" /></td>
				       <td class="rightCol"><span class="data"><a href="process.php?action=dependencia.getFrm&return[name]=pers_dependencia&return[id]=pers_dependencia_id" rel="facebox" title="si NO se encuentra la dependencia, la puede agregar aqui">Agregar</a></span></td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Cargo : </th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="pers_cargo" class="x-form-field" name="pers_cargo" onblur="this.value= this.value.toUpperCase()" /></td>
				       <td class="rightCol"></td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Jerarquia :</th>
				       <td class="data"><select name="pers_dep_jerarquia" id="pers_dep_jerarquia" class="x-form-field" style="width:400px">
				         <option value=""> Jerarquia </option>
				         <?  
							    $sql = "SELECT id_jerarquia AS clave, nom_jerarquia AS descrip FROM cat_jerarquias ORDER BY orden_jer";
		                        select($sql,'descrip','clave','clave','query');
							    
							?>
			           </select></td>
				       <td class="rightCol"></td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Liderazgo :</th>
				       <td class="data">
                         <select name="pers_liderazgo" id="pers_liderazgo" class="x-form-field" style="width:400px">
				           <option value=""> Liderazgo </option>
				            <?  
							    $sql = "SELECT id AS clave, nombre AS descrip FROM cat_liderazgo";
		                        select($sql,'descrip','clave','clave','query');
							    
							?>
			             </select></td>
				       <td class="rightCol"></td>
			         </tr>
					 <tr class="spacer">
					   <td colspan="3"><hr></td>
					 </tr>
				   </tbody>
				   
				   <tbody>
				     <tr class="dataRow">
				       <th class="label">Telefono :</th>
				       <td class="data">
                          <div style="width:100%">
						    <div style="width:100px; float:left"> 
						       <input type="text" maxlength="200" value="" allowblank="false" style="width: 90px;" id="pers_dep_tel" class="x-form-field" name="pers_dep_tel" />
						    </div>
						    <div  class="label" style=" width:40px;float:left; vertical-align:middle; padding:5px">Ext :</div>
							<div  style=" width:60px;float:left;"> <input type="text" maxlength="200" value="" allowblank="false" style="width: 50px;" id="pers_dep_ext" class="x-form-field" name="pers_dep_ext" />
							</div>
							<div  class="label" style=" width:80px;float:left; vertical-align:middle; padding:5px">Ext. Privada :</div>
							<div  style=" width:60px;float:left;"> <input type="text" maxlength="200" value="" allowblank="false" style="width: 50px;" id="pers_dep_ext_priv" class="x-form-field" name="pers_dep_ext_priv" />
							</div>
						  </div>
                       </td>
				       <td class="rightCol">&nbsp;</td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Tel. secundario :</th>
				       <td class="data">
                       
                         <span style="width:100px; float:left">
				         <input type="text" maxlength="200" value="" allowblank="false" style="width: 90px;" id="pers_dep_tel2" class="x-form-field" name="pers_dep_tel2" />
				       </span></td>
				       <td class="rightCol">&nbsp;</td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Fax :</th>
				       <td class="data">
                         <div style="width:100%">
						    <div style="width:100px; float:left"> 
						       <input type="text" maxlength="200" value="" allowblank="false" style="width: 90px;" id="pers_dep_fax" class="x-form-field" name="pers_dep_fax" />
						    </div>
						    <div  class="label" style=" width:40px;float:left; vertical-align:middle; padding:5px">Ext :</div>
						   <div  style=" width:60px;float:left;"> <input type="text" maxlength="200" value="" allowblank="false" style="width: 50px;" id="pers_dep_ext_fax" class="x-form-field" name="pers_dep_ext_fax" />
						   </div>
                         </div>
                       </td>
				       <td class="rightCol">&nbsp;</td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Clave Nextel :</th>
				       <td class="data"><span style="width:100px; float:left">
				         <input type="text" maxlength="200" value="" allowblank="false" style="width: 90px;" id="pers_nextel" class="x-form-field" name="pers_nextel" />
				       </span></td>
				       <td class="rightCol">&nbsp;</td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Email Institucional :</th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="pers_email_dep" class="x-form-field" name="pers_email_dep" /></td>
				       <td class="rightCol">&nbsp;</td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">P&aacute;gina Web :</th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="pers_web" class="x-form-field" name="pers_web" /></td>
				       <td class="rightCol">&nbsp;</td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">&nbsp;</th>
				       <td class="data">&nbsp;</td>
				       <td class="rightCol">&nbsp;</td>
			         </tr>
					 <tr class="spacer"><td colspan="3"><hr></td></tr>
				   </tbody>
                 </table>
                 
                 <table id="grupos"  class="dataTable" align="center" width="900px" cellpadding="0" cellspacing="0">
                   <tbody id="add-new">
                     <tr class="dataRow">
					 <th width="146" class="label">&nbsp;</th>
					 <td width="735" class="data"><a href="#" id="add-institution">Agregar Instituci&oacute;n, Organizaci&oacute;n, etc.</a></td>
					 <td width="17" class="rightCol">&nbsp;</td>
				     </tr>
					 <tr class="spacer"><td colspan="3"><hr></td></tr>
				   </tbody>
                   
                   <tbody id="detail-template" style="display:none">
				     <tr class="dataRow">
				       <th width="200" class="label">Grupo :</th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="grup_grupo_id" class="x-form-field" name="grup_grupo_id" />
			           <input type="hidden" name="grup_institucion_id2" id="grup_institucion_id2" /></td>
				       <td class="delete_msg"><a href="javascript: void(0);" title="Eliminar Grupo"> </a></td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Instituci&oacute;n :</th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="grup_institucion" class="x-form-field" name="grup_institucion" />
				         <input type="hidden" name="grup_institucion_id" id="grup_institucion_id" /> 
				         <a href="javascript: void(0)">Agregar</a></td>
				       <td class="rightCol">&nbsp;</td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Cargo :</th>
				       <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="grup_cargo" class="x-form-field" name="grup_cargo" onblur="this.value= this.value.toUpperCase()"/></td>
				       <td class="rightCol">&nbsp;</td>
			         </tr>
				     <tr class="dataRow">
				       <th class="label">Jerarquia :</th>
				       <td class="data"><select name="pers_dep_jerarquia2" id="pers_dep_jerarquia2" class="x-form-field" style="width:400px">
				         <option value=""> Jerarquia </option>
				         <?  
							    $sql = "SELECT id_jerarquia AS clave, nom_jerarquia AS descrip FROM cat_jerarquias ORDER BY orden_jer";
		                        select($sql,'descrip','clave','clave','query');
							    
							?>
			           </select></td>
				       <td class="rightCol">&nbsp;</td>
			         </tr>
                     <tr class="spacer"><td colspan="3"><hr></td></tr>
				   </tbody>
                   
                   
                   
			   </table>	 
       </div>
             
             
             
         <div id="tab4" class="tab_content">
            <table class="dataTable" align="center" width="900px" cellpadding="0" cellspacing="0">
			     <tbody>
			       <tr class="dataRow">
			         <th width="155" class="label">Observaciones : </th>
			         <td width="529" class="data"><textarea rows="5" style="width: 400px;" name="pers_observa" class="x-form-item" id="pers_observa" onblur="this.value= this.value.toUpperCase()"></textarea></td>
			         <td width="214" class="rightCol"></td>
		           </tr>
			       <tr class="spacer">
			         <td colspan="3"><hr /></td>
		           </tr>
		         </tbody>
			     <tbody>
		         </tbody>
	       </table>
       </div>
         <input type="hidden" name="modo" id="modo" value=""  />
     <input type="hidden" name="action" id="action" value=""  />
   </form>       
</div>

        <div style="clear:both"></div>
        <div align="left" style="padding-left:193px">
          <br />
          <input type="button" value="Cancelar" name="btn-cancelar" id="btn-cancelar" class="button" />
          <input type="button" value="Guardar" name="btn-guardar" id="btn-guardar" class="button" />
        </div>
 
 

 
</body>
</html>