

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
				 baseParams : {action : 'event.getGrupos', evento : Events.grid.getSelectionModel().getSelected().get('even_evento')},
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
		         params.evento   = Events.grid.getSelectionModel().getSelected().get('even_evento');
				 params.grupo    = cb.getValue();
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
			
			// The new DataWriter component.
			this.writer = new Ext.data.JsonWriter({
		         encode: true, // <-- don't return encoded JSON -- causes Ext.Ajax#request to send data using jsonData config rather than HTTP params
				 writeAllFields : true
	        });
			
			// Typical JsonReader.  Notice additional meta-data params for defining the core attributes of your json-response
			this.reader = new Ext.data.JsonReader({
			     root            : 'rows'   ,
				 successProperty : 'success',
				 totalProperty   :'total'   ,
				 idProperty      : 'noti_id',
				 id              : 'noti_id',
				 messageProperty : 'message'  // <-- New "messageProperty" meta-data
			},[{ name :'noti_id'          ,  mapping :'noti_id'          , type:'int'    , allowBlank: false },
			   { name :'noti_invitado'    ,  mapping :'noti_evento'      , type:'int'    , allowBlank: false },
			   { name :'noti_persona'     ,  mapping :'noti_persona'     , type:'int'    , allowBlank: false },
			   { name :'noti_npersona'    ,  mapping :'noti_npersona'    , type:'string' , allowBlank: false },
			   { name :'noti_grupo'       ,  mapping :'noti_grupo'       , type:'int'     },
			   { name :'noti_ngrupo'      ,  mapping :'noti_ngrupo'      , type:'string'  },
			   { name :'noti_jerarquia'   ,  mapping :'noti_jerarquia'   , type:'int'     },
			   { name :'noti_njerarquia'  ,  mapping :'noti_njerarquia'  , type:'string'  },
			   { name :'noti_dependencia' ,  mapping :'noti_dependencia' , type:'int'     },
			   { name :'noti_ndependencia',  mapping :'noti_ndependencia', type:'string'  },
			   { name :'noti_cargo'       ,  mapping :'noti_cargo'       , type:'string'  },			   
			   { name :'noti_notificado'  ,  mapping :'noti_notificado'  , type:'boolean' },
			   { name :'noti_recibio'     ,  mapping :'noti_recibio'     , type:'string'  },
			   { name :'noti_nrecibio'    ,  mapping :'noti_nrecibio'    , type:'string'  },
			   { name :'noti_motivo'      ,  mapping :'noti_motivo'      , type:'string'  }
			]);
			
			this.ds  = new Ext.data.GroupingStore({
                restful: false,         // <-- This Store is RESTful
				proxy  : this.proxy,
				reader : this.reader,
				writer : this.writer,    // <-- plug a DataWriter into the store just as you would a Reader
				groupField :'noti_ndependencia',
				baseParams : {action:'notificados', evento : this.evento}
			});
			this.ds.on('loadexception', function(d, o, response){ Events.handleResponse(response); },this);
			
			var params = new Object();	
		    params.xaction = 'load';
			params.start   = 0;
		    params.limit   = this.PageSize;
		    params.evento  = Events.grid.getSelectionModel().getSelected().get('even_evento');			
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
			this.editor.on('afteredit',function(ed,changes,record,rowindex){ Ext.getCmp('noti-motivo').allowBlank=true;},this);
			this.editor.on('canceledit',function(ed,changes,record,rowindex){ Ext.getCmp('noti-motivo').allowBlank=true;},this);
			
			this.cbrecibio = new Ext.form.ComboBox({
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
			
			this.cbrecibio.on('select',function( combo, record, index){ 
			     this.validate();			 
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
					dataIndex : 'noti_npersona',
					width     : 200,
					sortable  : true,
					tooltip   : 'Nombre de la persona invitada al evento'
				},{ 
				    header    : 'Dependencia',
					dataIndex : 'noti_ndependencia',
					width     : 250,
					hidden    : true,
					tooltip   : 'Nombre de la dependencia donde trabaja'
				},{ 
				    header    : 'Jerarquia',
					dataIndex : 'noti_njerarquia',
					width     : 90 ,
					tooltip   : 'Nivel jerarquico que tiene la persona'
				},{ 
				    header    : 'Cargo',
					dataIndex : 'noti_cargo',
					width     : 300,
					tooltip   : 'Cargo que tiene dentro la dependencia'
				},{
					xtype     : 'booleancolumn',
					header    : 'Notificado',
					dataIndex : 'noti_notificado',
					align     : 'center',
					width     : 60,
					sortable  : true,
					tooltip   : 'Indica si se ha visitado a la persona <br> - Se le pudo haber entregado la notificacion <br> - Por algun motivo no se encontro a la persona',
					trueText  : 'SI',
					falseText : 'NO',
					editor: {
						xtype      : 'checkbox',
						allowBlank : false,
						id    : 'cb-notificado',
						ctCls : 'x-cb-center',
						cls   : 'x-cb-center'					
				    }
			    },{
					header    : 'Recibio',
					dataIndex : 'noti_nrecibio',
					width     : 60,
                    sortable  : true,
					align     : 'center',
					tooltip   : 'Indica si la persona recibio la invitacion',
					editor    :  this.cbrecibio
				},{
                    header    : 'Motivo',
					dataIndex : 'noti_motivo',
					width     : 200,
					tooltip   : 'Si no recibio la notificacion, se debe de indicar un motivo',
					editor    : {
						 xtype      : 'textfield',
						 id         : 'noti-motivo',
						 allowBlank : true,
						 listeners  : {
						      blur  : function (){ this.setValue(this.getValue().toUpperCase()); loadedForm.validate(); } 
						 }
				    }
				}],
				tbar : [ '-',' Buscar por grupo:',this.cbSearch ,'-', 'Nombre',this.fdSearch],
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
			 
		   /* REBUIL EVENT OF MAIN WINDOW TO EVENT SUBMIT FORM */
			this.btnOK = Events.mainWin.buttons[0];
			this.btnOK.setText('Aceptar');
			this.btnOK.purgeListeners(); 
			this.btnOK.on('click',function(btn,evt){ Events.mainWin.hide(); },this);
			if(this.modo=='detail'){ this.btnOK.hide(); }else{this.btnOK.show();}
			
			 


		
			
	    },
		
		validate : function (){
		     var roweditor  = this.editor;
			 var rowindex   = this.editor.rowIndex;
			 var recibio    = this.cbrecibio.getValue();
			 	 
			 
			 if(recibio=='NO'){
				Ext.getCmp('noti-motivo').allowBlank=false;
				Ext.getCmp('noti-motivo').focus();						
			 }else{
				Ext.getCmp('noti-motivo').allowBlank=true;				
			 }
			 
			 if(recibio == '-'){
			 	Ext.getCmp('cb-notificado').setValue(false);
			 }else {
				Ext.getCmp('cb-notificado').setValue(true);
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
