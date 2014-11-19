<? 
	header("Content-Type: text/html;  charset=iso-8859-1");
	header("Content-Encoding :iso-8859-1");
	
   
?>

<div id="tmp-form"></div>

<script type="text/javascript">

var loadedForm = function(){
    
	var ModuleName = 'eventos';
	var ModulePath = '';
	var KeyRecord  = 'even_evento';

	
	/*-------------------------------------------------------------------------------------------------------------*
	* Objetos que se definen para borrar, cuando se vuelve a descargar el modulo
    *-------------------------------------------------------------------------------------------------------------*/
	var ObjectToDestroy  = new Array (); //lista de objetos del objeto loadedGrid que necesitan destruirse;
	ObjectToDestroy.push({name : 'this.grid'         , 'method' : 'destroy(true);'});
	ObjectToDestroy.push({name : 'this.fpanel'       , 'method' : 'destroy(true);'});	
	
	return {
	    
		modo      : '<? echo $_POST['modo']; ?>',
			 
	    Init : function (){
	        
			
			Events.resizeWin(Events.mainWin, 600,300);			
            this.RowSelected = Events.grid.getSelectionModel().getSelected();
			
		
			
		   /**
			* A DateField with a secondary trigger button that clears the contents of the DateField
			*/
			Ext.namespace('Ext.ux', 'Ext.ux.form');
			Ext.ux.form.ClearableDateField = Ext.extend(Ext.form.DateField, {
				initComponent : function(){
					Ext.ux.form.ClearableDateField.superclass.initComponent.call(this);
					this.triggerConfig = {
						tag : 'span', cls:'x-form-twin-triggers',
					    cn  : [{ tag: "img", src: Ext.BLANK_IMAGE_URL, cls: "x-form-trigger x-form-clear-trigger"},            
						       { tag: "img", src: Ext.BLANK_IMAGE_URL, cls: "x-form-trigger x-form-date-trigger"}
					    ]
			        };
				},
				getTrigger : function(index){
					return this.triggers[index];
				},
				initTrigger : function(){
					var ts = this.trigger.select('.x-form-trigger', true);
					this.wrap.setStyle('overflow', 'hidden');
					var triggerField = this;
					ts.each(function(t, all, index){					
						t.hide = function(){
							var w = triggerField.wrap.getWidth();
							this.dom.style.display = 'none';
							triggerField.el.setWidth(w-triggerField.trigger.getWidth());
						};
						t.show = function(){
							var w = triggerField.wrap.getWidth();
							this.dom.style.display = '';
							triggerField.el.setWidth(w-triggerField.trigger.getWidth());
						};
						var triggerIndex = 'Trigger'+(index+1);
						
						if(this['hide'+triggerIndex]){
							t.dom.style.display = 'none';
						}
						t.on("click", this['on'+triggerIndex+'Click'], this, {preventDefault:true});
						t.addClassOnOver('x-form-trigger-over');
						t.addClassOnClick('x-form-trigger-click');
					}, this);
					this.triggers = ts.elements;        
					this.triggers[0].hide();                   
				},
			
				validateValue : function(value) {
					
					var error = this.getErrors(value)[0];
					if (error == undefined) {
						//no hay errores						
				    } else {                       
						this.markInvalid(error);
                        return false;
                    }
									
					if(value !== this.emptyText && value !== undefined && value.length > '1'){
					   this.triggers[0].show();
					}
					return true;
				},    
				// clear contents of combobox
				onTrigger1Click : function() {
					this.reset();
					this.fireEvent('select', this, '' , '');
					this.triggers[0].hide();
				},
				// pass to original combobox trigger handler
				onTrigger2Click : function() {
					this.onTriggerClick();
				}
			});
			Ext.reg('extuxclearabledatefield', Ext.ux.form.ClearableDateField);

		   /*----------------------------------------------------------------------*
			* Creatin Ext.FormPanel
		    *----------------------------------------------------------------------*/
	        this.fpanel = new Ext.FormPanel({
				 formId     : 'frm-evento',
                 labelWidth : 100, // label settings here cascade unless overridden
                 frame      : false,
				 bodyStyle  : 'padding:10px',
				 style      : 'margin-rigth:15px; align:center;',
				 autoWidth  : true,
				 autoHeight : true,
				 border     : false,
				 labelAlign : 'right',					 
		         items           : [{			 
				     xtype       : 'fieldset',
                     title       : 'Por favor ingrese los siguientes datos para el evento',
					 collapsible : true ,
					 defaults    : {width:350}, 
					 items       : [{
					     xtype         : 'textarea',
						 fieldLabel    : 'Nombre del evento',
						 name          : 'even_descrip',
						 allowBlank    : false,
						 grow          : true,
						 growMin       : 50,
						 height        : 50,
						 maxLength     : 300,
						 helpText      : 'Por favor escribe el nombre del evento',
						 plugins       : new Ext.ux.plugins.HelpIcon(),
						 readOnly      : this.readOnly(),
						 disabled      : this.readOnly(),
						 listeners     :{
						    blur       : function() { 
							    this.setValue(this.getValue().toUpperCase()); 
							}
						 }					 
					 },{
					     xtype         : 'textfield',
						 fieldLabel    : 'Lugar',
						 name          : 'even_lugar',
						 allowBlank    : false,
						 maxLength     : 250,
						 helpText      : 'Lugar donde se lleva acabo el evento',
						 plugins       : new Ext.ux.plugins.HelpIcon(),
						 readOnly      : this.readOnly(),
						 disabled      : this.readOnly(),
						 listeners     :{
						    blur       : function() { 
							    this.setValue(this.getValue().toUpperCase()); 
							}
						 }					 
					 },{
					     xtype         : 'textfield',
						 fieldLabel    : 'Coordinador',
						 name          : 'even_coordina',
						 allowBlank    : false,
						 helpText      : 'Nombre del coordinador del evento',
						 plugins       : new Ext.ux.plugins.HelpIcon(),
						 maxLength     : 35,
						 readOnly      : this.readOnly(),
						 disabled      : this.readOnly(),
						 listeners     :{
						    blur       : function() { 
							    this.setValue(this.getValue().toUpperCase()); 
							}
						 }						 	
					 },{
					     xtype     : 'compositefield',
						 fieldLabel: 'Fechas',
						 defaults  : { flex: 1},
						 msgTarget : 'side' ,
						 items     : [							  
							  new Ext.ux.form.ClearableDateField({ 
									  fieldLabel   : 'Fecha expide',
									  name         : 'even_ini',
									  allowBlank   : false,
									  format       : 'd/m/Y',
									  readOnly     : this.readOnly(),
									  disabled     : this.readOnly()								 								  
							  })				    
						      , 
							  new Ext.ux.form.ClearableDateField({ 
									  fieldLabel   : 'Fecha Vence',
									  name         : 'even_fin',
									  allowBlank   : false,
									  format       : 'd/m/Y',
									  readOnly     : this.readOnly(),
						              disabled     : this.readOnly()
						      })
						 ]
					 },{
					     xtype    : 'hidden',
						 name     : 'even_evento'
					 }]				 
				 }]
			});
            
			
			/* GET THE FORM FROM FORMPANEL */
            this.fpanel.render('tmp-form');
			this.form = this.fpanel.getForm();
			
		   /* REBUIL EVENT OF MAIN WINDOW TO EVENT SUBMIT FORM */
			this.btnOK = Events.mainWin.buttons[0];
			this.btnOK.setText('Guardar');
			this.btnOK.purgeListeners(); 
			this.btnOK.on('click',function(btn,evt){ this.submitForm(); },this);
			if(this.modo=='detail'){ this.btnOK.hide(); }else{this.btnOK.show();}
			
			
			
			/* PUT DE VALUES OF GRID TO FORM */
			if(this.modo!='insert'){
			   this.setValues(Events.grid.getSelectionModel().getSelected(),null);		  
			}
		   
	    },
		
	    setValues: function(record,field){	       
		    
			if (this.modo !='insert' && Events.ds.getCount() > 0) {
			    if(field){
			 	   var f= this.form.findField(field);
				   f.setValue(record.get(f.getName()));
				   return ;
			    }
				
				this.form.loadRecord(record);
		    }					   
	    },
	    
		submitForm : function(){		   
		   if(this.form.isValid()){
			   this.form.submit({
			        clientValidation: true,
				    url     : 'process.php?_dc=' + new Date().getTime(),
				    params  : { action : this.modo },
				    waitMsg : 'Procesando...',
                    success : function(form, action) {
				       Ext.Msg.show({
					       title   : 'Respuesta del Servidor',
						   msg     : action.result.message,
						   buttons : Ext.MessageBox.OK,
						   fn      : function (){
						       Events.mainWin.hide();					   
							   Events.ds.reload();
						   },
						   icon    : Ext.MessageBox.INFO
					   });
					   
					   
				   },
				   failure: function(form, action) {
						Events.handleResponse(action.response);
					}
			   });			
		    }else{
			     Ext.MessageBox.show({title   : 'Advertencia',msg:'Por favor corrige los datos del formulario', buttons : Ext.MessageBox.OK, icon: Ext.MessageBox.WARNING });
		    }
	    },
	   
	    readOnly : function(){
	        return this.modo =='detail' ? true : false;
	    },
		removeObjects : function(){
		   /* CAMPOS DEL FORMULARIO */
			try {   this.form.items.each(function(f){ if(f.isFormField){ f.destroy(); } }); }catch(e){alert(e.message );}
			
			var str;
			if(ObjectToDestroy instanceof Array ) {  
			   for(i=0; i< ObjectToDestroy.length ; i++){
				   try{
					    str = (ObjectToDestroy[i].name+'.'+ObjectToDestroy[i].method);
						eval (str);						  
				   }catch(e){  /*alert(e.name+' : '+e.message );*/ }			  
			   }
			}
	    }
	
	}

}();

Ext.onReady(loadedForm.Init, loadedForm);

</script>