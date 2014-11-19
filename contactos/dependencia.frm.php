<?

   //tratamos de obtener el grupo
   $path = '../../'; //dirname(__FILE__);
	require_once ("../libs/adodb/adodb-exceptions.inc.php");
	require_once ("../libs/adodb/adodb.inc.php");
	require_once ("../includes/utf8.php");
	require_once ("../includes/config.php");
	require_once ("../includes/conexion.php");
	require_once ("../libs/lib/lib.php");
    
	//para los de session
	require_once('../include/funciones_v2.php');
    f_verifica_sesion();
	  
	  
    //conexion
    $db = Conectar();
	
	//recuperamos informacion del grupo
	$sql    = "SELECT id_grup AS clave, d_grupo AS descrip FROM cat_grupos  WHERE id_grup ='".$_GET['grupo']."'";
	$rs     = $db->Execute($sql);
	$rgrupo = $rs->FetchRow();
	
	
?>


<div style="height:500px; overflow:auto;" class="table-frm">
  <div id="ajax-indicator" class="indicator" align="center"> 
       <div> 
         <span> Procesando. Por favor espere .... </span>
          <img src="../imagenes/ajax-loader.gif" border="0" />       
       </div>       
  </div>
  
  <div id="ajax-result" class="indicator" align="center"> 
       <div> <span id="message">&nbsp;</span> </div>       
  </div>
  
<div id="ajax-error" class="x-error" align="center"> 
       <div> <span id="error-msg">&nbsp;</span> </div>       
  </div>
  
  
  <form name="frm-dependencia" id="frm-dependencia" action="process.php" enctype="multipart/form-data" method="POST"> 
  <table class="dataTable" align="center" width="600px" cellpadding="0" cellspacing="0">
    <tbody>
      <tr class="dataRow">
        <th height="28" colspan="3" align="center" bgcolor="#CCCCCC" >POR FAVOR INGRESE LOS DATOS DE LA DEPENDENCIA</th>
        </tr>
      <tr class="dataRow" height="5px">
        <th class="label">&nbsp;</th>
        <td class="data">&nbsp;</td>
        <td class="rightCol">&nbsp;</td>
      </tr>
      <tr class="dataRow">
        <th width="108" class="label">* Grupo :</th>
        <td width="469" class="data"><input type="text" maxlength="200" value="<?=$rgrupo['descrip']?>" allowblank="false" style="width: 400px; background:#E5E5E5" id="depe_categoria" class="required"  name="depe_categoria" readonly="readonly" />
        <input type="hidden" name="depe_categoria_id" id="depe_categoria_id" value="<?=$rgrupo['clave']?>" /></td>
        <td width="21" class="rightCol">&nbsp;</td>
      </tr>
      <tr class="dataRow">
        <th class="label">* Nombre  : </th>
        <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="depe_nombre" class="x-form-field" name="depe_nombre" onblur="this.value = this.value.toUpperCase();" /></td>
        <td class="rightCol">&nbsp;</td>
      </tr>
      <tr class="spacer">
        <td colspan="3"><hr></td>
      </tr>
      <tr class="dataRow">
        <th class="label">* Municipio :</th>
        <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="depe_municipio" class="x-form-field" name="depe_municipio" />
          <input type="hidden" name="depe_municipio_id" id="depe_municipio_id" /></td>
        <td class="rightCol"></td>
      </tr>
      <tr class="dataRow">
        <th class="label">* Ciudad :</th>
        <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="depe_ciudad" class="x-form-field" name="depe_ciudad" />
          <input type="hidden" name="depe_ciudad_id" id="depe_ciudad_id" /></td>
        <td class="rightCol"></td>
      </tr>
      <tr class="dataRow">
        <th class="label">* Tipo de calle :</th>
        <td class="data">
          <div style="width:100%">
            <div style="width:150px; float:left">
              <input type="text" maxlength="200" value="" allowblank="false" style="width: 120px;" id="depe_tcalle" class="x-form-field" name="depe_tcalle" />
              <input type="hidden" name="depe_tcalle_id" id="depe_tcalle_id" />
            </div>
            <div  class="label" style=" width:60px;float:left; vertical-align:middle; padding:5px">Sufijo :</div>
            <div  style=" width:120px;float:left;">
              <select name="depe_sufijo" id="depe_sufijo" class="x-form-field" style="width:100px">
                <option value=""> Sufijo </option>
                <?  
							    $sql = "SELECT id_sufijo  AS clave, cve_sufijo  AS descrip FROM cat_sufijo_calle ORDER BY cve_sufijo";
		                        select($sql,'descrip','clave','clave','query');
							    
							?>
              </select>
            </div>
          </div>
        <td class="rightCol"></td>
      </tr>
      <tr class="dataRow">
        <th class="label">* Calle :</th>
        <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="depe_calle" class="x-form-field" name="depe_calle" onblur="this.value = this.value.toUpperCase();" />
          <input type="hidden" name="depe_calle_id" id="depe_calle_id" /></td>
        <td class="rightCol"></td>
      </tr>
      <tr class="dataRow">
        <th class="label">N&uacute;mero :</th>
        <td class="data"><div style="width:100%">
						    <div style="width:60px; float:left"> 
						       <input type="text" maxlength="200" value="" allowblank="false" style="width: 50px;" id="depe_numero" class="x-form-field" name="depe_numero" />
						    </div>
		      <div  class="label" style=" width:40px;float:left; vertical-align:middle; padding:5px">Lote :</div>
							<div  style=" width:60px;float:left;"> <input type="text" maxlength="200" value="" allowblank="false" style="width: 50px;" id="depe_lote" class="x-form-field" name="depe_lote" />
							</div>
			  <div  class="label" style=" width:65px;float:left; vertical-align:middle; padding:5px">Manzana :</div>
							<div  style=" width:60px;float:left;"> <input type="text" maxlength="200" value="" allowblank="false" style="width: 50px;" id="depe_manzana" class="x-form-field" name="depe_manzana" />
							</div>
						  </div></td>
        <td class="rightCol"></td>
      </tr>
      <tr class="dataRow">
        <th class="label">Colonia :</th>
        <td class="data"><div style="width:100%">
						    <div style="width:300px; float:left"> 
						       <input type="text" maxlength="200" value="" allowblank="false" style="width: 295px;" id="depe_colonia" class="x-form-field" name="depe_colonia" />
						    </div>
              <input type="hidden" name="depe_colonia_id" id="depe_colonia_id" />
<div  class="label" style=" width:40px;float:left; vertical-align:middle; padding:5px">C.P :</div>
							<div  style=" width:60px;float:left;"> <input type="text" maxlength="200" value="" allowblank="false" style="width: 50px;" id="depe_cp" class="x-form-field" name="depe_cp" />
							</div>
        </div></td>
        <td class="rightCol"></td>
      </tr>
      <tr class="dataRow">
        <th class="label">Entre calle :</th>
        <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="depe_entre" class="x-form-field" name="depe_entre" onblur="this.value = this.value.toUpperCase();" /></td>
        <td class="rightCol"></td>
      </tr>
      <tr class="dataRow">
        <th class="label">Y calle :</th>
        <td class="data"><input type="text" maxlength="200" value="" allowblank="false" style="width: 400px;" id="depe_entre_y" class="x-form-field" name="depe_entre_y" onblur="this.value = this.value.toUpperCase();" /></td>
        <td class="rightCol"></td>
      </tr>
      <tr class="dataRow">
        <th class="label">Ruta :</th>
        <td class="data"><span style=" width:120px;float:left;">
          <select name="depe_ruta" id="depe_ruta" class="x-form-field" style="width:100px">
            <option value=""> Ruta </option>
            <?  
			    $rutas = array('1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>9,'10'=>10,'11'=>11,'12'=>12,'13'=>13,'14'=>14,'15'=>15);
		        select($rutas,NULL,NULL,NULL,'array');
							    
			?>
          </select>
        </span></td>
        <td class="rightCol"></td>
      </tr>
      <tr class="dataRow">
        <th class="label">Referencia :</th>
        <td class="data"><textarea name="depe_referencia" rows="2" class="x-form-item" id="depe_referencia" style="width: 400px;" onblur="this.value = this.value.toUpperCase();"></textarea></td>
        <td class="rightCol"></td>
      </tr>
      <tr class="dataRow">
        <th class="label">&nbsp;</th>
        <td class="data">
           <span style="padding-left:193px"><br />
              <input type="button" value="Cancelar" name="btn-dep-cancelar" id="btn-dep-cancelar" class="button" />
              <input type="button" value="Guardar" name="btn-dep-guardar" id="btn-dep-guardar" class="button" />
           </span>
        </td>
        <td class="rightCol"></td>
      </tr>
      
    </tbody>
    <tbody>
    </tbody>
    <tbody>
    </tbody>
  </table>
  </form>
  
  <script>
       $(document).ready(function() {
        		 
		 //==================== Autocomplete =================================================
	     $('#depe_categoria').autocomplete('process.php?tip=a&action=categoria.getList', {
            width       : 405,
            selectFirst : false,
		    minChars    : 1
         }).result(function(event, data, formatted) {		 
		    $('#depe_categoria_id').val(data[1]);		
         });
		 
		 // Set autosuggest options with all plugins activated & response in xml
	     var json_muni = new bsn.AutoSuggest('depe_municipio', {
		     script   : "process.php?action=municipio.getList&",
		     meth     : 'get',
			 varname  : "q",
			 json     : true,
			 shownoresults:false,				// If disable, display nothing if no results
			 noresults:"No hay resultados - Agregar ",			// String displayed when no results
			 maxresults:10,					// Max num results displayed
			 cache    : true,				// To enable cache
			 minchars : 1,					// Start AJAX request with at leat 2 chars
			 timeout  : 3000,				// AutoHide in XX ms
			 callback : function (obj) { 	// Callback after click or selection
			 		    $('#depe_municipio_id').val(obj.id);
						$('#depe_ciudad').val();
						$('#depe_ciudad_id').val();
						$('#depe_colonia').val(); 
						$('#depe_colonia_id').val(); 
						
		     }
	     });
		 
		 // Set autosuggest options with all plugins activated & response in xml
	     var json_ciudad = new bsn.AutoSuggest('depe_ciudad', {
		     script   : "process.php?action=ciudades.getList&",
		     meth     : 'get',
			 varname  : "q",
			 json     : true,
			 shownoresults:false,				// If disable, display nothing if no results
			 noresults:"No hay resultados - Agregar ",			// String displayed when no results
			 maxresults:10,					// Max num results displayed
			 cache    : true,				// To enable cache
			 minchars : 1,					// Start AJAX request with at leat 2 chars
			 timeout  : 4000,   			// AutoHide in XX ms
			 getFields: { municipio : '#depe_municipio_id'},
			 callback : function (obj) { 	// Callback after click or selection
			 		    $('#depe_ciudad_id').val(obj.id);
		     }
	     });
		 
		 // Set autosuggest options with all plugins activated & response in xml
	     var json_col = new bsn.AutoSuggest('depe_colonia', {
		     script   : "process.php?action=colonias.getList&",
		     meth     : 'get',
			 varname  : "q",
			 json     : true,
			 shownoresults:false,				// If disable, display nothing if no results
			 noresults:"No hay resultados - Agregar ",			// String displayed when no results
			 maxresults:10,					// Max num results displayed
			 cache    : true,				// To enable cache
			 minchars : 1,					// Start AJAX request with at leat 2 chars
			 timeout  : 3000,				// AutoHide in XX ms
			 getFields: { municipio : '#depe_municipio_id'},
			 callback : function (obj) { 	// Callback after click or selection
			 		    $('#depe_colonia_id').val(obj.id);
		     }
	     });
		 
		 //==================== Autocomplete =================================================
		 $('#depe_tcalle').autocomplete('process.php?tip=a&action=tcalles.getList', {
			 selectFirst : true,
			 minChars    : 0,
			 autoFill    : true,
			 mustMatch   : true
	     }).result(function(event, data, formatted) {
		     $('#depe_tcalle_id').val(data[1]);		
         });
		 
		 //==================== Autocomplete =================================================
		 $('#depe_calle').autocomplete('process.php?tip=a&action=calles.getList', {         
			  selectFirst : true,
			  minChars    : 0,
			  autoFill    : true,
			  mustMatch   : true
		 }).result(function(event, data, formatted) {
			  if(data){
				 $('#depe_calle_id').val(data[1]);		
			  }
		 });
		 
		 
		 var dependencia = function (){
			 
			 return {
				 
				 //campo donde se regresa el nombre de la dependencia
				 //campo donde se regresa el id de la dependencia
				 return_id   : '<? echo '#'.$_GET['return']['id']; ?>' ,
				 return_name : '<? echo '#'.$_GET['return']['name']; ?>' ,
				 
				 init : function(){
				     //boton de guardar
					 $('#btn-dep-guardar').click(function(){ dependencia.save(); });
					 $('#btn-dep-cancelar').click(function(){ $.facebox.close(); });
					 
					 
					 
					 
					 $("#frm-dependencia").validate({
						rules    : { depe_categoria: "required", depe_nombre: "required", depe_municipio : "required", depe_ciudad : "required", depe_tcalle : 'required',  depe_calle : 'required',  depe_referencia: {maxlength:250}},
						messages : {
							depe_categoria : "Por favor ingrese el nombre de la Categoria",
							depe_nombre    : "Por favor ingrese el nombre de la Dependencia",
							depe_municipio : "Por favor ingrese el nombre del municipio",
							depe_ciudad    : "Por favor ingrese el nombre de la Ciudad",
							depe_tcalle    : "Por favor Ingrese el Tipo de Calle",
							depe_calle     : "Por favor ingrese el Nombre de la Calle",
							depe_referencia: "Longitud maxima de 250 caracteres"
						} ,
						
						submitHandler : function () {
						    //Enviamos el formulario usando AJAX
						    
						    $('#btn-dep-guardar').attr('disabled', 'disabled');
							$('#ajax-result').hide();
							$('#ajax-error').hide();
							$('#ajax-indicator').show();
						
							$.ajax({
					          type : 'POST',
							  url  : 'process.php',
							  data : $('#frm-dependencia').serialize() + '&action=dependencia.save',
							  // Mostramos un mensaje con la respuesta de PHP
							  success: function(data) {
							      
								  $('#ajax-indicator').fadeOut(2000, function(){
								   
								   //verificamos si todo salio bien
								   try { var json = eval('(' + data + ')'); }catch(e){ json = false; }								
								   if(!json){ alert (data); return false }
								   	
								   if(json.success == true) {
									   //document.getElementById('message').innerHTML=json.message;
									   $('#message').html(json.message)
									   
									   $('#ajax-result').fadeIn(2000,function(){
									      //$('#pers_dependencia').val(json.nombre);
										  //$('#pers_dependencia_id').val(json.id);
										  
										 
										  
										  $(dependencia.return_id).val(json.id);
										  $(dependencia.return_name).val(json.nombre);
										  
										  $.facebox.close();
									   });
								   }else {								   	 
									  $('#error-msg').html(json.errors.msg);
									  $('#ajax-result').hide();									  
									  $('#ajax-indicator').hide();									  
									  $('#ajax-error').show();							  
								   } 
								      							
								  });								
								  $('#btn-dep-guardar').removeAttr('disabled');
							  }
						    });						
						    return false;
						}
	                  });
					  
					 
					 
					 
				 } , 
				 
				 save : function(){
				    $('#frm-dependencia').submit();
				 } ,
				 
				 isValidForm : function (form){
				    
				 }
			 }			 
		 }();
		 
		 
		 dependencia.init();
		 
		 
	  });

  </script>
</div>