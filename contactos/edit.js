
var contacto;


$(document).ready(function() {	
	
	   contacto = function(){
		
		return {
		    modo         : null  ,
			persona      : {}    ,
		   
		   activeTab     : function (name){
		       
			   var tab = $('#'+name);			   
			   $("ul.tabs li").removeClass("active"); //Remove any "active" class		      	   
			   //$(this).addClass("active"); 
			   tab.addClass("active");//Add "active" class to selected tab	  
		       
			   $(".tab_content").hide(); //Hide all tab content
		       var activeTab = $(tab).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		       $(activeTab).fadeIn(); //Fade in the active ID content
		       return false;
		   },
		   init : function (){
		      
			  //When page loads create tabs...
			  $(".tab_content").hide(); //Hide all content
			  $("ul.tabs li:first").addClass("active").show(); //Activate first tab
			  $(".tab_content:first").show(); //Show first tab content
			
			  //On Click Event
			  $("ul.tabs li").click(function() {
			
				  $("ul.tabs li").removeClass("active"); //Remove any "active" class
				  $(this).addClass("active"); //Add "active" class to selected tab
				  $(".tab_content").hide(); //Hide all tab content
			
				  var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
				  $(activeTab).fadeIn(500); //Fade in the active ID content
				  //$(activeTab).css('display','block');
					
				  return false;
			  });
			  
			  $("#pers_telefono").mask("(999) 999-9999");
			  $("#pers_celular").mask("(999) 999-9999");
			  $("#pers_dep_tel").mask("(999) 999-9999");
			  $("#pers_dep_tel2").mask("(999) 999-9999");
			  
			  jQuery.fn.reset = function () { 
			      $(this).each (function() { this.reset(); });
			  };
			  
			  this.setValues(json_data);
			  this.getInfo(json_data.pers_persona);
			  $("#action").val('contact.edit');
			  
			  
			  $('#btn-guardar').click(function()  {  contacto.save(); });
			  $('#btn-cancelar').click(function() {  window.close();  });
			  
			  			  
			  $("#frm-contacto").validate({						
				  rules  : {
				      pers_titulo        : { required: true},
					  pers_sexo          : { required: true},
					  pers_nombre        : { required: true},
					  pers_apat          : { required: true},
					  pers_dep_grupo     : { required: true},
					  pers_dependencia   : { required: true},					  
					  pers_cargo         : { required: true},
					  pers_dep_tel       : { required: true}
				  },
				  messages : {
					  pers_titulo        : "Campo requerido",
					  pers_sexo          : "Indique el sexo",
					  pers_nombre        : "Campo requerido",
					  pers_apat          : "Campo requerido",
					  pers_dep_grupo     : "Campo requerido",
					  pers_dependencia   : "Campo requerido",
					  pers_cargo         : "Campo requerido",
					  pers_dep_tel       : "Campo requerido" 
				  },
				  submitHandler : function () {
				      				  					  
					  //Enviamos el formulario usando AJAX					 
					  $.scrollTo('#title-edit',{duration:800},{easing:'elasout'});
				      
					  $('#btn-guardar').attr('disabled', 'disabled');
					  $('#ajax-submit-result').hide();
					  $('#ajax-submit-error').hide();
					  $('#ajax-submit-indicator').show();
					 					  
					  $.ajax({
					      type : 'POST',
						  url  : 'process.php',
						  data : $('#frm-contacto').serialize(),
							  // Mostramos un mensaje con la respuesta de PHP
							  success: function(data) {
							      
								  //inicializamos el contador de grupos
								  tbl.setCount(1);
								  
								  
								  $('#ajax-submit-indicator').fadeOut(2000, function(){
								   
									   //verificamos si todo salio bien
									   try { var json = eval('(' + data + ')'); }catch(e){ json = false; }								
									   if(!json){ alert (data); return false }
									   
									   if(json.success == true) {
										   //document.getElementById('message').innerHTML=json.message;
										   $('#submit-message').html(json.message);									   
										   $('#ajax-submit-result').fadeIn(2000,function(){	
											   //escodemos cualquier mensaje, del log
											   $('#ajax-submit-indicator').hide();
											   $('#ajax-submit-error').hide();
											   $('#ajax-submit-result').fadeOut(2000);
											   
											   //habilitamos el boton de guardar
											   $('#btn-guardar').removeAttr('disabled');
										   });
									   }else {								   	 
										  
										  $('#error-submit-msg').html(json.errors.msg);
										  $('#ajax-submit-result').hide();									  
										  $('#ajax-submit-indicator').hide();									  
										  $('#ajax-submit-error').fadeIn(1000);	
										  
										  //habilitamos el boton de guardar
										  $('#btn-guardar').removeAttr('disabled');
																	  
									   } 
								      							
								  });								
								  
							  }
						    });						
						    return false;
						}
	          });		  
			 

		   },
		   
		  /*------------------------------------------------------------------------------------------------------------------------
		   * Funcion que borra los tbody de los grupos
		   *-----------------------------------------------------------------------------------------------------------------------*/		   
		   deleteGrupos : function (){
		       
			   //borramos el detalle
		       var detail = document.getElementsByName('detail');				 
			   while( detail.length >  0 ){				 
			       var tb = detail[0];
				   tb.parentNode.removeChild(tb);					 				 
			   }
				
		   },
		   		   
		  /*------------------------------------------------------------------------------------------------------------------------
		   * Funcion que envia el formulario principal
		   *-----------------------------------------------------------------------------------------------------------------------*/
		   save : function(){
		       
			   $('#frm-contacto').submit();
			   
			   //validamos donde se encuentran los errores
			   var invalid = $('#frm-contacto').validate().invalid;		  
			   for(key in invalid) {
		           var name  = key;	   
			   
			       //buscamos el atributo donde se encuentra el campo
				   tab = $('#'+name).attr('tab');
				   if(tab){
					  this.activeTab(tab);
					  break;
				   }
			   }
			   
		   } ,
		   
		   edit : function () {
		   
		   } ,
		   
		   getInfo : function ( pid ) {		   
		       $.ajax({
		           url  : 'process.php',
				   data :  { action:'persona.getInfo', pers_persona : pid},
				   type : "POST",
				   success: function(data) {
					  
					  try { var json = eval('(' + data + ')'); }catch(e){ json = false; }								
					  if(!json){ alert (data); return false }
			          
					  contacto.setValues(json);
			       }
		       });
			   
			   //descarga los grupos a  los que pertenece
			   $.ajax({
		           url  : 'process.php',
				   data :  { action:'persona.getInfoGrupos', pers_persona : pid},
				   type : "POST",
				   success: function(html){  
				        $('#grupos').append(html);
						
						//cada vez que se descarga informacion de los grupos, verifico en cuanto va
						//para continuar con el contador
						var cnt = document.getElementsByName('detail');	
						var len = cnt.length;
						tbl.setCount(len+1);
				   }
		       });
			   
		   },
		   
		   setValues : function (json){
		       //fijamos los valores en los campos para la edicion
			   $("#pers_persona_id").val(json.pers_persona);
			   $("#pers_titulo").val(json.pers_dtitulo);
			   $("#pers_titulo_id").val(json.pers_titulo);
			   $("#pers_sexo").val(json.pers_sexo);			   
			   $("#pers_nombre").val(json.pers_nombre);
			   $("#pers_apat").val(json.pers_apat);
			   $("#pers_amat").val(json.pers_amat);
			   
			   var a = json.pers_fnac.split('/');
			   $("#pers_fndia").val(a[2]);
			   $("#pers_fnmes").val(a[1]);
			   $("#pers_fnanio").val(a[0]);
			   
			  			   
			   $("#pers_telefono").val(json.pers_telefono);
			   $("#pers_nextel").val(json.pers_nextel);
			   $("#pers_celular").val(json.pers_celular);
			   $("#pers_email").val(json.pers_email);
			   $("#pers_web").val(json.pers_web);			   
			   $("#pers_name_esposa").val(json.pers_esposa);
			   
			   var a = json.pers_aniversarioboda.split('/');
			   $("#pers_dia_aniv").val(a[2]);
			   $("#pers_mes_aniv").val(a[1]);
			   
			   var a = json.pers_cumple_esposa.split('/');
			   $("#pers_fdia_esposa").val(a[2]);
			   $("#pers_fmes_esposa").val(a[1]);
			   $("#pers_fanio_esposa").val(a[0]);
			   
			   
			   $("#pers_tcalle").val(json.pers_dtcalle);
			   $("#pers_tcalle_id").val(json.pers_tcalle);
			   $("#pers_sufijo").val(json.pers_sufijo);
			   $("#pers_calle").val(json.pers_dcalle);
			   $("#pers_calle_id").val(json.pers_calle);			   
			   $("#pers_numero").val(json.pers_numero);
			   $("#pers_lote").val(json.pers_lote);
			   $("#pers_manzana").val(json.pers_manzana);
			   $("#pers_colonia").val(json.pers_dcolonia);
			   $("#pers_colonia_id").val(json.pers_colonia);
			   $("#pers_cp").val(json.pers_cp);
			   $("#pers_refdomi").val(json.pers_refdomicilio);
			   
			   //invitaciones
			   if(json.pers_invi_dm=='S'){
				  $('#pers_invi_dm').attr('checked', true);
			   }else {
			      $('#pers_invi_dm').attr('checked', false);
			   }
				
			   if(json.pers_invi_avf=='S'){
				  $('#pers_invi_avf').attr('checked', true);
			   }else {
			      $('#pers_invi_avf').attr('checked', false);
			   }
			   
			   if(json.pers_invi_dievcm=='S'){
				  $('#pers_invi_dievcm').attr('checked', true);
			   }else {
			      $('#pers_invi_dievcm').attr('checked', false);
			   }
			   
			   if(json.pers_invi_maestra=='S'){
				  $('#pers_invi_maestra').attr('checked', true);
			   }else {
			      $('#pers_invi_maestra').attr('checked', false);
			   }  
			   
			 
			   
			   $("#pers_dep_grupo").val(json.pers_dgrupo);
			   $("#pers_dep_grupo_id").val(json.pers_grupo);
			   $("#pers_dependencia").val(json.pers_ndependencia);
			   $("#pers_dependencia_id").val(json.pers_dependencia);
			   $("#pers_cargo").val(json.pers_cargo);
			   $("#pers_dep_jerarquia").val(json.pers_jerarquia);
			   $("#pers_liderazgo").val(json.pers_liderazgo);
			   $("#pers_dep_tel").val(json.pers_tel_dep);
			   $("#pers_dep_ext").val(json.pers_ext_dep);
			   $("#pers_dep_ext_priv").val(json.pers_ext_priv_dep);
			   $("#pers_dep_tel2").val(json.pers_tel2_dep); 
			   $("#pers_dep_fax").val(json.pers_fax_dep);
			   $("#pers_dep_ext_fax").val(json.pers_fax_ext_dep);
			   $("#pers_email_dep").val(json.pers_email_dep);
			   
			   
			   $("#pers_observa").val(json.pers_observaciones);	   
		   },
		   
		   showTapsInfo : function(){
		     
			  $("#search-tb").slideUp('slow',function(){
			      $("#tabs").fadeIn('slow'); 
			  });
			  			
			  //load data is mode isEqual to edit
			  if(contacto.modo == 'edit'){			 
			     contacto.getInfo(contacto.persona.id);
			  }else {
			     
				 $("#pers_nombre").val( $("#input_name_src").val().toUpperCase() );
			     $("#pers_apat").val  ( $("#input_apat_src").val().toUpperCase() );
			     $("#pers_amat").val  ( $("#input_amat_src").val().toUpperCase() );
				 		  
			  }
		   },
		   
		   validate   : function(el, generico, cual){
		       
			   if(!generico) generico = '';
			   if(!cual)  cual = '';
			   
			   var val = $("#"+el).val();
			   
			   if(val.length == 0){
				  $("#"+el+"_id").val('');
				  return false;				   
			   }
			   
			   			   
			   //descarga los grupos a  los que pertenece
			   $.ajax({
		           url  : 'process.php',
				   data :  { action:'persona.validate', field :el, value: val, generico: generico, cual: cual},
				   type : "POST",
				   success: function(html){  
				         try { var json = eval('(' + html + ')'); }catch(e){ json = false; }								
						 if(!json){ alert ('Error validando: data [ '+html +' ]'); return false }
						 
						 var el = $('#'+json.field);
						 //ponemos mensaje de campo invalido
						 if(json.success!=true){
						    $(el).removeClass('x-form-field');
							$(el).addClass('x-form-invalid');
							$('#error-submit-msg').html(json.errors.msg);
							$('#ajax-submit-error').fadeIn(1000);
							
							if(json.script){eval(json.script)}
						 }else{
						    $(el).removeClass('x-form-invalid');
							$(el).addClass('x-form-field');
							$('#ajax-submit-error').slideUp(1000,function(){
							  $('#error-submit-msg').html('');
							});	
						 }
								  
				   }
		       });
		   },
		   setMode : function (mode){
		      contacto.modo = mode;
		   }
		
		};
		
	}();
	
	contacto.setMode('edit');
	contacto.init();
	
	
	
	
	var Table = function(o){
    
		var tr    = document.getElementById(o.tr); //tr to clone
		var table = document.getElementById(o.table); //tr to clone
		var cont  = 1;
	
		return {
		   
		   addRow    : function( ){ //inserta un nuevo registro con los nuevos calores
				var trToClone = tr.cloneNode(true);
				
				
				var nextId = this.getCount();
				
				trToClone.id   = 'detail';
				trToClone.name = 'detail';
				trToClone.setAttribute('name','detail');
				
				
				if(navigator.appName.indexOf("Microsoft") > -1) {
					var visible = 'block';
					trToClone.style.display    = 'block';
				}
				else {
					 var visible = 'table-row'; 
					 trToClone.style.display    = 'table-row-group';					 
				}
				
				trToClone.style.visibility = 'visible';
				
				//element for grupo
				var input     = trToClone.getElementsByTagName("input")[0];
				input.name    = "grup_grupo[]";
				input.id      = "grup_grupo_"+ nextId;
				input.onblur = function(){ contacto.validate("grup_grupo_"+ nextId,'S','grupo');}
				
				//element for hidden grupo id				
				var input     = trToClone.getElementsByTagName("input")[1];
				input.name    = "grup_grupo_id[]";
				input.id      = "grup_grupo_id_"+ nextId;				
				
				
				
				//element for dependendencia o instituciones 
				input         = trToClone.getElementsByTagName("input")[2];
				input.name    = "grup_dependencia[]";
				input.id      = "grup_dependencia_"+nextId;
				input.onblur = function(){ contacto.validate("grup_dependencia_"+ nextId,'S','dependencia');}	
				
				//element for dependendencia id 
				input         = trToClone.getElementsByTagName("input")[3];
				input.name    = "grup_dependencia_id[]";
				input.id      = "grup_dependencia_id_"+nextId;			
				
				
				//element for cargo 
				input         = trToClone.getElementsByTagName("input")[4];
				input.name    = "grup_cargo[]";
				input.id      = "grup_cargo_"+nextId;
				
				//element for activo
				input         = trToClone.getElementsByTagName("select")[0];
				input.name    = "grup_jerarquia[]";
				input.id      = "grup_jerarquia_"+nextId;
				
				
				//element for a href edit
				a             = trToClone.getElementsByTagName("a")[0];
				a.id          = "remove_"+nextId;
				a.href        = 'javascript: void(0);';
				a.onclick     = function(){ tbl.confirm('delete', null, nextId); };
				
				
				/*//evento para que abra la ventana del facebox
				a             = trToClone.getElementsByTagName("a")[1];
				a.id          = "facebox_"+nextId;
				a.href        = 'javascript: void(0);';
				a.title       = "Si la Dependencia, Institución, Organización, etc no se encuentra, Agregarla haciendo click aqui";
				a.onclick     = function(){ 
				     jQuery.facebox({ ajax: 'process.php?action=dependencia.getFrm&return[name]=grup_dependencia_'+ nextId +'&return[id]=grup_dependencia_id_'+ nextId });
				};*/				
				
				table.appendChild(trToClone);
				

				var name = "grup_grupo_"+ nextId;				
				//=======================================================================
				// Set autosuggest options with all plugins activated & response in xml
				var suggest = new bsn.AutoSuggest( name , {
		            script   : "process.php?action=grupo.getList&",
					meth     : 'get',
					varname  : "query",
					json     : true,
					shownoresults:false,				// If disable, display nothing if no results
					noresults:"No hay resultados - Agregar ",			// String displayed when no results
					handleNoResult : function(){},
					maxresults:10,					// Max num results displayed
					cache    : true,				// To enable cache
					minchars : 1,					// Start AJAX request with at leat 2 chars
					timeout  : 1000000,				// AutoHide in XX ms
					callback : function (obj) { 	// Callback after click or selection
					    $('#grup_grupo_id_'+nextId).val(obj.id);
					}
				});
				
				//==============================================================================
				var name = "grup_dependencia_"+ nextId;				
				var au = new bsn.AutoSuggest(name, {
					script   : "process.php?tip=a&action=dependencia.getList&",
					meth     : 'get',
					varname  : "query",
					json     : true,
					shownoresults:true,				// If disable, display nothing if no results
					noresults:"No hay resultados - Agregar ",			// String displayed when no results
					handleNoResult : function(){
		                 var url   = 'process.php?action=dependencia.getFrm&return[name]=grup_dependencia_'+ nextId +'&return[id]=grup_dependencia_id_'+ nextId;
						 var grupo = $("#grup_grupo_id_"+nextId).val();
						 
						 if(grupo.length==0 || grupo ==""){
						    alert("Antes de continuar, debes de elegir un grupo"); return false;
						 }
						 
						 url = url+'&grupo='+grupo;
						 jQuery.facebox({ ajax: url });
					},
					maxresults:10,					// Max num results displayed
					width     : 500,
					cache    : true,				// To enable cache
					minchars : 1,					// Start AJAX request with at leat 2 chars
					timeout  : 10000,				// AutoHide in XX ms
					//getFields: { grupo : "#grup_grupo_id_"+nextId},
					callback : function (obj) { 	// Callback after click or selection
						$('#grup_dependencia_id_'+nextId).val(obj.id);
					}
			    });	
				
				/*$(name).autocomplete('process.php?tip=a&action=dependencia.getList', {
                   width       : 405,
                   selectFirst : false,
		           minChars    : 1
                }).result(function(event, data, formatted) {
		           $('#grup_dependencia_id_'+nextId).val(data[1]);
                });*/
	
				
				
				$.scrollTo('#grup_grupo_'+nextId,{duration:800},{easing:'elasout'}); //$(...).scrollTo( target, duration, settings );
				
				this.inCount();
					 
		   },
		   
		   updateRow : function(id,o){
				document.getElementById('disp_nombre_'+id).value  = o.nombre;
				document.getElementById('disp_descrip_'+id).value = o.descrip;
				document.getElementById('disp_valores_'+id).value = o.valores;
				document.getElementById('disp_activo_'+id).value  = o.activo;
		   },
		   removeRow : function(id){
				
				var input = document.getElementById('grup_grupo_'+id);
				var tr = input.parentNode.parentNode; //td->tr
				tbody = tr.parentNode; //tbody					
				tbody.parentNode.removeChild(tbody); //tbody->table
		   },
		   
		   confirm   : function(modo,form, id){
				
				var res = confirm("¿ Seguro que desea realizar esta operación ? \n");  
				if (!res) return false; 
				
				this.removeRow(id);
		   }, 
		   getCount  : function(){
				return cont;
		   },
		   setCount  : function(value){
			   cont = value; 
		   },
		   inCount   : function(){
				cont = cont+1;
				return (cont);
		   }
		   
		}
	
	}
    tbl = new Table({table:'grupos', tr:'detail-template'});

    $("#add-institution").click(function() {       
	   tbl.addRow();//mostrar el nuevo registro
    });




	
	
	
	//==================== Search With all plugins =================================================
	// Unbind form submit
	$('#frm-search').bind('submit', function() {return false;} ) ;
	$('#frm-person').bind('submit', function() {return false;} ) ;
	
	
	// Set autosuggest options with all plugins activated & response in xml
	var options  = {
		script   : "process.php?action=contact.getByFilter&",
		meth     : 'get',
		varname  : "input",
		json     : true,
		shownoresults:true,				// If disable, display nothing if no results
		noresults:"No hay resultados - Agregar ",			// String displayed when no results
		handleNoResult : function () { 
		    $('#frm-contacto').reset();
			
			contacto.modo='insert'; 
			$("#action").val('contact.save');
			$("#modo").val('edit');
								
			tbl.setCount(1);
			contacto.deleteGrupos(); 
			contacto.showTapsInfo();
		},
		maxresults:10,					// Max num results displayed
		cache    : true,				// To enable cache
		minchars : 1,					// Start AJAX request with at leat 2 chars
		timeout  : 10000,				// AutoHide in XX ms
		getFields: { name : '#input_name_src', apat:'#input_apat_src', amat:'#input_amat_src' },
		callback : function (obj) { 	// Callback after click or selection
			$('#frm-contacto').reset();
			
			$('#input_id').val(obj.id);	
			$("#modo").val('edit');
			$("#action").val('contact.edit');
			$("#pers_persona_id").val(obj.id);
			
			
			contacto.modo = 'edit';
			contacto.persona.id = obj.id;
			contacto.persona.nombre = obj.nombre;
			contacto.persona.amat = obj.amat;
			contacto.persona.apat = obj.apat;
			
			contacto.showTapsInfo( );			
		}
	};
	// Init autosuggest
	var src1 = new bsn.AutoSuggest('input_name_src', options);
	var src1 = new bsn.AutoSuggest('input_apat_src', options);
	var src1 = new bsn.AutoSuggest('input_amat_src', options);
	
	
	
	
	//==================== Autocomplete =================================================
	$('#pers_titulo').autocomplete('process.php?tip=a&action=titulos.getList', {
          width       : 156,
          selectFirst : false,
		  minChars    : 1
    }).result(function(event, data, formatted) {
		  $('#pers_titulo_id').val(data[1]);		
    });
	
	
	
	
	
	//==================== Autocomplete =================================================
	$('#pers_tcalle').autocomplete('process.php?tip=a&action=tcalles.getList', {
          width       : 156,
          selectFirst : false,
		  minChars    : 1
    }).result(function(event, data, formatted) {
		  $('#pers_tcalle_id').val(data[1]);		
    });
	
	//==================== Autocomplete =================================================
	$('#pers_calle').autocomplete('process.php?tip=a&action=calles.getList', {
         
          selectFirst : false,
		  minChars    : 1
    }).result(function(event, data, formatted) {
		  $('#pers_calle_id').val(data[1]);		
    });
	
	
	/*//==================== Autocomplete =================================================
	var au_calle = new bsn.AutoSuggest('pers_calle', {
		script   : "process.php?tip=a&action=calles.getList&",
		meth     : 'get',
		varname  : "q",
		json     : true,
		shownoresults:false,				// If disable, display nothing if no results
		noresults:"No hay resultados - Agregar ",			// String displayed when no results
		handleNoResult : function(){},
		maxresults:10,					// Max num results displayed
		cache    : true,				// To enable cache
		minchars : 1,					// Start AJAX request with at leat 2 chars
		timeout  : 10000,				// AutoHide in XX ms
		callback : function (obj) { 	// Callback after click or selection
			 $('#pers_calle_id').val(obj.id);
		}
	});	*/
	
	// Set autosuggest options with all plugins activated & response in xml
	var options  = {
		script   : "process.php?action=colonias.getList&",
		meth     : 'get',
		varname  : "q",
		json     : true,
		shownoresults:false,				// If disable, display nothing if no results
		noresults:"No hay resultados - Agregar ",			// String displayed when no results
		handleNoResult : contacto.showTapsInfo,
		maxresults:10,					// Max num results displayed
		cache    : true,				// To enable cache
		minchars : 2,					// Start AJAX request with at leat 2 chars
		timeout  : 1000000,				// AutoHide in XX ms
		callback : function (obj) { 	// Callback after click or selection
			$('#pers_colonia_id').val(obj.id);
		}
	};
	// Init autosuggest
	var as_json = new bsn.AutoSuggest('pers_colonia', options);	
	
	// Set autosuggest options with all plugins activated & response in xml
	var as_json = new bsn.AutoSuggest('pers_dep_grupo', {
		script   : "process.php?action=grupo.getList&",
		meth     : 'get',
		varname  : "query",
		json     : true,
		shownoresults:false,				// If disable, display nothing if no results
		noresults:"No hay resultados - Agregar ",			// String displayed when no results
		handleNoResult : contacto.showTapsInfo,
		maxresults:10,					// Max num results displayed
		cache    : true,				// To enable cache
		minchars : 1,					// Start AJAX request with at leat 2 chars
		timeout  : 1000000,				// AutoHide in XX ms
		width    : 500,
		callback : function (obj) { 	// Callback after click or selection
			$('#pers_dep_grupo_id').val(obj.id);
		}
	});	
	
	
	//==================== Autocomplete =================================================
	var au_dependencia = new bsn.AutoSuggest('pers_dependencia', {
		script   : "process.php?tip=a&action=dependencia.getList&",
		meth     : 'get',
		varname  : "query",
		json     : true,
		shownoresults:true,				// If disable, display nothing if no results
		noresults:"No hay resultados - Agregar ",			// String displayed when no results
		handleNoResult : function(){
		    var url   = 'process.php?action=dependencia.getFrm&return[name]=pers_dependencia&return[id]=pers_dependencia_id';
			var grupo = $('#pers_dep_grupo_id').val();
			
			if(grupo.length==0 || grupo ==""){
			   alert("Antes de continuar, debes de elegir un grupo valido"); $('pers_dep_grupo').focus(); return false;
			}
						 
			url = url+'&grupo='+grupo;
			jQuery.facebox({ ajax: url});
		},
		maxresults:10,					// Max num results displayed
		width     : 500,
		cache    : true,				// To enable cache
		minchars : 1,					// Start AJAX request with at leat 2 chars
		timeout  : 10000,				// AutoHide in XX ms
		//getFields: { grupo : '#pers_dep_grupo_id'},
		callback : function (obj) { 	// Callback after click or selection
			 $('#pers_dependencia_id').val(obj.id);
		}
	});	

	
	
     var fbox = $('a[rel*=facebox]').facebox({
	    loading_image : '../js/facebox/loading.gif',
	 	close_image : '../js/facebox/closelabel.gif',
		overlay     : false
	 });
			  
	 $.facebox.settings.opacity = 0.2;

	
	

});


