

    <div id="tmp-form"></div>
    <!-- the custom editor for the 'Light' column references the id="light" -->
    <select name="cbrecibio" id="cbrecibio" style="display: none;">
    	<option value=""> - </option>
    	<option value="S">SI</option>
    	<option value="N">NO</option>
    </select>


<script type="text/javascript">
var loadedForm = function(){

	var ModuleName = 'notificacion';
	var ModulePath = '';
	var KeyRecord  = 'noti_invitado';

	/*-------------------------------------------------------------------------------------------------------------*
	* Objetos que se definen para borrar, cuando se vuelve a descargar el modulo
    *-------------------------------------------------------------------------------------------------------------*/
	var ObjectToDestroy  = new Array (); //lista de objetos del objeto loadedGrid que necesitan destruirse;
	ObjectToDestroy.push({name : 'this.grid'    , 'method' : 'destroy();'});
	ObjectToDestroy.push({name : 'this.layout'  , 'method' : 'destroy();'});



	return {

        PageSize      : 20,
		evento        : Events.grid.getSelectionModel().getSelected().get('even_evento'),
		minChars      : 1,
		searchMode    : 'remote',
	
	    Init : function (){

		    Events.resizeWin(Events.mainWin,1000,500);			
			
				
			this.dsDEP      = Events.createDataStore({
			     url        : 'process.php?_dc='+new Date().getTime(),
				 baseParams : {action : 'event.getGrupos', evento : this.evento },
				 fields     : ['clave', 'descrip']
		    });
			
			this.cbSearch = new Ext.form.ComboBox({
				 fieldLabel   :' Buscar ',
				 typeAhead    : true,
				 triggerAction: 'all',
				 store        : this.dsDEP,
				 mode         : 'remote',
				 displayField : 'descrip',
				 valueField   : 'clave',
				 width        : 400,
				 listWidth    : 600,
				 emptyText    : 'Seleccione un grupo...',
				 value        :''
			});
			
			this.cbSearch.on('select',function( cb, record, index){
				 var params = new Object();
		         params.start    = 0;
		         params.limit    = this.pbar.pageSize||this.PageSize;
		         params.evento   = this.evento;
				 params.grupo    = cb.getValue();
				 params.recibio  = 'S';
				 params.npersona = this.fdSearch.getValue();
				 Ext.apply(this.ds.baseParams, params);
				 this.ds.load({params:params});
			},this);
			
			// add input field (TwinTriggerField in fact)
			this.fdSearch = new Ext.form.TwinTriggerField({
				 width    : 200,
				 selectOnFocus  : true,
				 trigger1Class  :'x-form-clear-trigger',
				 trigger2Class  :'x-hide-display',
				 onTrigger1Click: this.onTriggerClear.createDelegate(this),
				 onTrigger2Click: function(){ alert('click2') }
			});
			// install event handlers on input field
			this.fdSearch.on('render', function() {		
				
				if(this.minChars) {
				   this.fdSearch.el.on({
					    scope  : this, 
						buffer : this.searchMode=='local' ? 10 : 1000, 
						keyup  : this.onKeyUp
					});
				}
				
				// install key map
				var map = new Ext.KeyMap(this.fdSearch.el, [{
					key   : Ext.EventObject.ENTER, 
					scope : this,
					fn    : this.onTriggerSearch
				},{
					key   : Ext.EventObject.ESC,
					scope : this,
					fn    : this.onTriggerClear
				}]);
				map.stopEvent = true;
			}, this, {single:true});

				
			
			this.proxy = new Ext.data.HttpProxy({
				 url: 'process.php'
			});
			
			this.proxy.on('exception', function(proxy, type, action, options, response, arg) {
				var res = {};
				res.status = 200;
				res.success = response.success;
				res.responseText = Ext.encode(response.raw);
				Events.handleResponse(res);
            });
			
			// The new DataWriter component.
			this.writer = new Ext.data.JsonWriter({
		         encode: true, // <-- don't return encoded JSON -- causes Ext.Ajax#request to send data using jsonData config rather than HTTP params
				 writeAllFields : true
	        });
			
			// Typical JsonReader.  Notice additional meta-data params for defining the core attributes of your json-response
			this.reader = new Ext.data.JsonReader({
			     root            : 'rows'   ,
				 successProperty : 'success',
				 totalProperty   : 'total'   ,
				 idProperty      : 'conf_id',
				 id              : 'conf_id',
				 messageProperty : 'message'  // <-- New "messageProperty" meta-data
			},[{ name :'conf_id'          ,  mapping :'conf_id'          , type:'int'    , allowBlank: false },
			   { name :'conf_invitado'    ,  mapping :'conf_invitado'    , type:'int'    , allowBlank: false },
			   { name :'conf_evento'      ,  mapping :'conf_evento'      , type:'int'    , allowBlank: false },
			   { name :'conf_persona'     ,  mapping :'conf_persona'     , type:'int'    , allowBlank: false },
			   { name :'conf_npersona'    ,  mapping :'conf_npersona'    , type:'string' , allowBlank: false },
			   { name :'conf_grupo'       ,  mapping :'conf_grupo'       , type:'int'     },
			   { name :'conf_ngrupo'      ,  mapping :'conf_ngrupo'      , type:'string'  },
			   { name :'conf_jerarquia'   ,  mapping :'conf_jerarquia'   , type:'int'     },
			   { name :'conf_njerarquia'  ,  mapping :'conf_njerarquia'  , type:'string'  },
			   { name :'conf_dependencia' ,  mapping :'conf_dependencia' , type:'int'     },
			   { name :'conf_ndependencia',  mapping :'conf_ndependencia', type:'string'  },
			   { name :'conf_cargo'       ,  mapping :'conf_cargo'       , type:'string'  },
			   { name :'noti_recibio'     ,  mapping :'noti_recibio'     , type:'string'  },
			   { name :'conf_called'      ,  mapping :'conf_called'      , type:'string'  },			   
			   { name :'conf_confirmo'    ,  mapping :'conf_confirmo'    , type:'string'  },
			   { name :'conf_nconfirmo'   ,  mapping :'conf_nconfirmo'   , type:'string'  },
			   { name :'conf_quien'       ,  mapping :'conf_quien'       , type:'int'     },
			   { name :'conf_nquien'      ,  mapping :'conf_nquien'      , type:'string'  },
			   { name :'conf_motivo'      ,  mapping :'conf_motivo'      , type:'string'  }
			]);
			
			this.ds  = new Ext.data.GroupingStore({
                restful: false,         // <-- This Store is RESTful
				proxy  : this.proxy,
				reader : this.reader,
				writer : this.writer,    // <-- plug a DataWriter into the store just as you would a Reader
				groupField :'conf_ndependencia',
				baseParams : {action:'confirmados', evento : this.evento}
			});			
			
			

			var params = new Object();	
		    params.xaction = 'load';
			params.start   = 0;
		    params.limit   = this.PageSize;
		    params.evento  = this.evento;
			params.recibio = 'S';			
			this.ds.load({params:params});		
								  
			
			this.pbar = new Ext.PagingToolbar({
				 store       : this.ds,
				 pageSize    : this.PageSize,
				 displayInfo : true,
				 displayMsg  : 'Mostrando registros {0} - {1} de {2}',
				 emptyMsg    : 'No hay registros para mostrar',
				 plugins     : [new Ext.ux.plugin.PagingToolbarResizer({prependCombo: true, displayText:'Mostrar :', options: [10,20,25,30,50,75,100]})]
		    });
								  
			this.editor = new Ext.ux.grid.RowEditor({
				 saveText: 'Guardar',
				 clicksToEdit : 1,
				 focusDelay   : 100,
				 commitChangesText: 'Es necesario guradar o cancelar los cambios'
		    });			
			this.editor.on('afteredit',function(ed,changes,record,rowindex){ this.cbwho.allowBlank=true;},this);
			this.editor.on('canceledit',function(ed,changes,record,rowindex){ this.cbwho.allowBlank=true;},this);
			
			 
			this.cbconfirmo = new Ext.form.ComboBox({
                 typeAhead     : true,
                 triggerAction : 'all',
				 store         : new Ext.data.SimpleStore({fields:['clave','descrip'], data : [['','-'],['S','SI'],['N','NO']]}),
                 mode          : 'local',
				 displayField  : 'descrip',
				 valueField    : 'descrip',
				 //transform    : 'cbrecibio',// <--- transform the data already specified in html
                 lazyRender    : true,
                 listClass     : 'x-combo-list-small'
            });
			
			this.cbconfirmo.on('select',function( combo, record, index){ 
			     this.validate();			 
			},this);
			
			this.cbwho = new Ext.form.ComboBox({
				 id            : 'cb-who',
                 typeAhead     : true,
                 triggerAction : 'all',
				 store         : new Ext.data.SimpleStore({fields:['clave','descrip'], data : [['','NO ASISTE'],['T','TITULAR'],['S','SUPLENTE']]}),
                 mode          : 'local',
				 displayField  : 'descrip',
				 valueField    : 'descrip',
				 //transform    : 'cbrecibio',// <--- transform the data already specified in html
                 lazyRender    : true,
                 listClass     : 'x-combo-list-small',
				 allowBlank    : true
            });
			
			this.cbwho.on('select',function(combo,record,index){
			     var who = combo.getValue();
				 this.cbconfirmo.setValue('SI');
				 Ext.getCmp('cb-called').setValue(true);
				 
			},this);
			
					
			
			this.grid   = new Ext.grid.GridPanel({
				store   : this.ds,
				width   : 1000,
				height  : 500,
				region  :'center',
				border  : false,
				frame   : false,
				margins : '0 5 5 5',                
				plugins : [this.editor],
				viewConfig : {
					forceFit: false
				},
				view : new Ext.grid.GroupingView({
                    markDirty: false,
					showGroupName : false,
					groupTextTpl: '{text} ({[values.rs.length]})'
			    }),
				loadMask: {msg:'Loading...',removeMask :true},
				columns :[
				    new Ext.grid.RowNumberer(),
				{   
				    header    : 'Nombre',
					dataIndex : 'conf_npersona',
					width     : 200,
					sortable  : true,
					tooltip   : 'Nombre de la persona invitada al evento'
				},{ 
				    header    : 'Dependencia',
					dataIndex : 'conf_ndependencia',
					width     : 250,
					hidden    : true,
					tooltip   : 'Nombre de la dependencia donde trabaja'
				},{ 
				    header    : 'Jerarquia',
					dataIndex : 'conf_njerarquia',
					width     : 120 ,
					tooltip   : 'Nivel jerarquico que tiene la persona'
				},{ 
				    header    : 'Cargo',
					dataIndex : 'conf_cargo',
					width     : 320,
					tooltip   : 'Cargo que tiene dentro la dependencia'
				},{
				    header    : 'Recibio',
					dataIndex : 'noti_recibio',
					align     : 'center',
					width     : 60,
					hidden    : true,
					tooltip   : 'Indica si la persona recibio su invitación<br>para asistir al evento'					
				},{
					xtype     : 'booleancolumn',
					header    : 'Llamada',
					dataIndex : 'conf_called',
					align     : 'center',
					width     : 70,
					sortable  : true,
					tooltip   : 'Indica si se le ha llamado a la persona <br> - Se le pudo haber llamado pero no contesto<br> - Si contesto puedo haber confirmado o no',
					trueText  : 'SI',
					falseText : 'NO',
					editor: {
						xtype : 'checkbox',
						id    : 'cb-called',
						allowBlank : false,
						cls   : 'x-cb-center',
						ctCls : 'x-cb-center'
					}
			    },{
					header    : 'Confirmo',
					dataIndex : 'conf_nconfirmo',
					width     : 60,
                    sortable  : true,
					align     : 'center',
					tooltip   : 'Indica si la persona recibio la invitacion',
					editor    :  this.cbconfirmo
				},{
					header    : '¿Quien Asite?',
					dataIndex : 'conf_nquien',
					width     : 90,
                    sortable  : true,
					align     : 'center',
					tooltip   : 'Indica si la persona recibio la invitacion',
					editor    :  this.cbwho
				}],
				tbar : [ '-',' Buscar por grupo:',this.cbSearch,'-', 'Nombre',this.fdSearch ],
				bbar : this.pbar
			});
			
			this.layout = new Ext.Panel({
				 layout  : 'border',
				 border  : false,
				 layoutConfig: {
					 columns: 1
				 },
				 width  :800,
				 height : 400,
				 items  : [this.grid]
			});			 
			Events.mainWin.add(this.layout);
			
		   /*REBUIL EVENT OF MAIN WINDOW TO EVENT SUBMIT FORM */
			this.btnOK = Events.mainWin.buttons[0];
			this.btnOK.setText('Aceptar');
			this.btnOK.purgeListeners(); 
			this.btnOK.on('click',function(btn,evt){ Events.mainWin.hide(); },this);
			if(this.modo=='detail'){ this.btnOK.hide(); }else{this.btnOK.show();}
			
			
	    },
		
		validate : function (){
		     var roweditor  = this.editor;
			 var rowindex   = this.editor.rowIndex;
			 var confirmo   = this.cbconfirmo.getValue();
			 
			 Ext.getCmp('cb-called').setValue(true);
				 
			 if(confirmo=='SI'){				    
				Ext.getCmp('cb-who').allowBlank=false;									
			 }else{
				Ext.getCmp('cb-who').allowBlank=true;
				Ext.getCmp('cb-who').setValue('');
			 }			 
		},
		
		
		onKeyUp:function(e, t, o) {
			// ignore special keys
			if(e.isNavKeyPress()) { return; }
			
			var length = this.fdSearch.getValue().toString().length;
			if(0 === length || this.minChars <= length) {
				this.onTriggerSearch();
			}
		 }, // eo function onKeyUp

		onTriggerClear:function() {
			if( this.fdSearch.getValue()) {
			    this.fdSearch.setValue('');
				this.fdSearch.focus();
				this.onTriggerSearch();
			}
		},
		
		onTriggerSearch : function() {
			if(!this.fdSearch.isValid()) {	return;	}
			
			var val = this.fdSearch.getValue();
			var store = this.grid.store;		
		  		
					   
			// grid's store filter
			if('local' === this.searchMode) {
				store.clearFilter();
			   /*----------------------------------------------------------------------*
			    * Crea Filtro para todas las columnas que se muestran
			    *----------------------------------------------------------------------*/
			    var col = this.grid.getColumnModel(); var l   = col.getColumnCount();
			    var items= new Array();					   
			    for(c=0; c<l; c++){ items.push(col.getDataIndex(c));}
				
				if(val) {
					store.filterBy(function(r) {
					    var retval = false;
					    /*this.menu.items.each(function(item) {
						   if(!item.checked || retval){ return; }
						   
						   var rv = r.get(item.dataIndex);
						   rv = rv instanceof Date ? rv.format(this.dateFormat || r.fields.get(item.dataIndex).dateFormat) : rv;
						   var re = new RegExp(RegExp.escape(val), 'gi');
						   retval = re.test(rv);
					    }, this);*/
						
						for (var i=0; i<items.length; i++){
						   if(!items[i]) continue;
						   
						   var rv = r.get(items[i]);
						   console.log(rv);
						   rv = rv instanceof Date ? rv.format(this.dateFormat || r.fields.get(item.dataIndex).dateFormat) : rv;
						   //var re = new RegExp(RegExp.escape(val), 'gi');
						   var re = new RegExp(Ext.escapeRe(val), "gi");						   
						   if(re.test(rv)) retval =  true;
					    };
					
					    if(retval) { return true; }
					    return retval;
				    }, this);
			    } 
			}
			// ask server to filter records
			else {
				var params = new Object();
		        params.start    = 0;
		        params.limit    = this.pbar.pageSize||this.PageSize;
		        params.evento   = this.evento;
				params.grupo    = this.cbSearch.getValue();
				params.npersona = this.fdSearch.getValue();
				params.recibio  = 'S';				
				Ext.apply(this.ds.baseParams, params);				
				// reload store
				store.load({params:params});
			}
		}, // eo function onTriggerSearch

	    removeObjects : function(){
		   /* CAMPOS DEL FORMULARIO */
			//try {  this.form.items.each(function(f){  if(f.isFormField){ f.destroy(); } }); } catch(e){alert(e.message );}

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
