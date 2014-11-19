

<div id="tmp-form"></div>

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
	ObjectToDestroy.push({name : 'this.fpanel'  , 'method' : 'destroy();'});
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
				 typeAhead    : false,
				 triggerAction: 'all',
				 store        : this.dsDEP,
				 mode         : 'remote',
				 displayField : 'descrip',
				 valueField   : 'clave',
				 width        : 400,
				 listWidth    : 600,
				 pageSize     : 10,
				 minChars     : 1,
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
			
			// Typical JsonReader.  Notice additional meta-data params for defining the core attributes of your json-response
			this.reader = new Ext.data.JsonReader({
			     root            : 'rows'   ,
				 successProperty : 'success',
				 totalProperty   : 'total'   ,
				 idProperty      : 'invi_invitado',
				 id              : 'invi_invitado',
				 messageProperty : 'message'  // <-- New "messageProperty" meta-data
			},[{ name :'invi_invitado'     ,  mapping :'invi_invitado'     , type:'int'    , allowBlank: false },
			   { name :'invi_evento'       ,  mapping :'invi_evento'       , type:'int'    , allowBlank: false },
			   { name :'invi_persona'      ,  mapping :'invi_persona'      , type:'int'    , allowBlank: false },
			   { name :'invi_npersona'     ,  mapping :'invi_npersona'     , type:'string' , allowBlank: false },
			   { name :'invi_jerarquia'    ,  mapping :'invi_jerarquia'    , type:'int'    , allowBlank: false },
			   { name :'invi_njerarquia'   ,  mapping :'invi_njerarquia'   , type:'string'  },
			   { name :'invi_tgrupo'       ,  mapping :'invi_tgrupo'       , type:'string'  },
			   { name :'invi_grupo'        ,  mapping :'invi_grupo'        , type:'int'     },
			   { name :'invi_ngrupo'       ,  mapping :'invi_ngrupo'       , type:'string'  },
			   { name :'invi_dependencia'  ,  mapping :'invi_dependencia'  , type:'int'     },
			   { name :'invi_ndependencia' ,  mapping :'invi_ndependencia' , type:'string'  },
			   { name :'invi_cargo'        ,  mapping :'invi_cargo'        , type:'string'  },
			   { name :'isinvited'         , mapping :'isinvited'          , type: 'boolean'}	
			]);
			
			this.ds  = new Ext.data.GroupingStore({
                restful: false,         // <-- This Store is RESTful
				proxy  : this.proxy,
				reader : this.reader,
				groupField :'invi_ndependencia',
				baseParams : {action:'event.getInvitados', evento : this.evento}
			});			
			
			this.ds.on('loadexception', function(d, o, response){ Events.handleResponse(response); },this);
			this.ds.on('load',function(store,records, opt){ 
		        var btnOK    = Events.mainWin.buttons[0];				
			    var toSelect = Array();
					 
				if(store.getCount() >0 ){
				   btnOK.enable();				   
				   
				   for(var i = 0, len = store.getCount(); i < len; i++){
                       record = store.getAt(i);					   					   
					   if(record.get('isinvited')==true){
						   toSelect.push(i);
					   }					   
                   }	
				   		
				   this.csmRemoveListeners();
				   if(toSelect.length > 0 ){  
				      this.sm.selectRows(toSelect,true);
				   }
				   this.csmAddListeners();
												
				 }else {					 
				   btnOK.disable();
				}
			},this);
				  
			
			this.pbar = new Ext.PagingToolbar({
				 store       : this.ds,
				 pageSize    : this.PageSize,
				 displayInfo : true,
				 displayMsg  : 'Mostrando registros {0} - {1} de {2}',
				 emptyMsg    : 'No hay registros para mostrar',
				 plugins     : [new Ext.ux.plugin.PagingToolbarResizer({prependCombo: true, displayText:'Mostrar :', options: [10,20,25,30,50,75,100]})]
		    });
			
			this.sm = new Ext.grid.CheckboxSelectionModel({dataIndex: 'isinvited', checkOnly:true});
			this.csmAddListeners();			
				
			this.grid   = new Ext.grid.GridPanel({
				store   : this.ds,
				sm      : this.sm,
				width   : 1000,
				height  : 500,
				region  :'center',
				border  : false,
				frame   : false,
				viewConfig : {
					forceFit: true
				},
				view : new Ext.grid.GroupingView({
                    markDirty     : false,
					showGroupName : false,
					groupTextTpl  : '{text} ({[values.rs.length]})'
			    }),
				loadMask: {msg:'Loading...',removeMask :true},
				cm      : new Ext.grid.ColumnModel({
					defaults : {sortable: true},
					columns  : [
				        new Ext.grid.RowNumberer(),
					    { header: "Nombre"      , dataIndex: 'invi_npersona'     , sortable: true, width :300 , tooltip: 'Nombre del contacto de la agenda'},
					    { header: "Jerarquia"   , dataIndex: 'invi_njerarquia'   , sortable: true, width :100 , tooltip: 'Jerarquia que tiene'},
					    { header: "Cargo"       , dataIndex: 'invi_cargo'        , sortable: true, width :500 , tooltip: 'Cargo de la persona'},
					    { header: "Dependencia" , dataIndex: 'invi_ndependencia' , sortable: true, width :200 , tooltip: 'Nombre de la dependencia donde trabaja', hidden: true},
					      this.sm
					]
				}),
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
			
			var params = new Object();
			params.action  = 'event.getInvitados';
			params.start   = 0;
		    params.limit   = this.PageSize;
		    params.evento  = this.evento;
			this.ds.load({params:params});		
			
			//creamos el formulario oculto
			this.fpanel = new Ext.FormPanel({
				 formId   : 'frm-export',
				 hidden   : true ,
				 url      : 'process.php'
			 });
			 this.fpanel.render('tmp-form');
			 this.form = this.fpanel.getForm();
			
		   /*REBUIL EVENT OF MAIN WINDOW TO EVENT SUBMIT FORM */
			this.btnOK = Events.mainWin.buttons[0];
			this.btnOK.setText('Aceptar');
			this.btnOK.purgeListeners(); 
			this.btnOK.on('click',function(btn,evt){ this.sendRecords(); },this);
			
			
	    },
		
		sendRecords : function (){
		     var params  = new Object();
			 var data    = new Array();
			
			 
			 if(this.ds.getCount()==0){
				Ext.Msg.show({title: 'Error',msg: 'No se puede agregar invitados, porque no existe ninguno. <br>Intente de nuevo la busqueda con criterios diferentes',buttons:Ext.MessageBox.OK,icon: Ext.MessageBox.ERROR});
				return;
			 }
							 
			 //extraemos unicamente los datos para tener un array de objetos
			 //array [{name:'some'},{name:'some'},{name:'some'},{name:'some'}]							 
			 this.ds.each(function(record){
			      //necesito enviarle los siguientes parametros
				  var r = {};
				  r.pers_persona  = record.get('invi_persona');
				  r.pers_npersona = record.get('invi_npersona');
				  r.isinvited     = record.get('isinvited');
				  data.push(r);
			 });
							 							
			 params.action = 'event.editInvitados';
			 params.evento = this.evento;
			 params.rs_invitados = Ext.encode(data);
			 
			 //enviamos el formulario
			 this.form.submit({
				  params  : params,
				  waitMsg : 'Procesando...',
				  scope   : this,
				  success : function(form, action) {
				      Ext.Msg.show({
						  title   : 'Respuesta del Servidor',
						  msg     : action.result.message,
						  buttons : Ext.MessageBox.OK,
						  fn      : function (){
						      this.ds.removeAll(true);
							  this.grid.getView().refresh();
							  this.ds.reload();
							  Events.ds.reload();
						  },
						  icon    : Ext.MessageBox.INFO,
						  scope   : this
					  });
								  
				  },
				  failure: function(form, action) { 
				      Events.handleResponse(action.response);
				  }
			 });
							 
		},
		
		csmRemoveListeners : function(){
			this.sm.purgeListeners();
		},
		csmAddListeners : function(){
		    this.sm.on('beforerowselect',function( sm, index, keepExisting, record){ // sm, index, record
				 record.set('isinvited', true);
							
			}, this);
				
			this.sm.on('rowdeselect',function( sm, index, record){
				 record.set('isinvited', false);
				 					
			}, this);
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
				Ext.apply(this.ds.baseParams, params);				
				
				store.removeAll(true);
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
