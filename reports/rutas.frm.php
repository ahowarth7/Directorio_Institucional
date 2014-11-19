

<div id="tmp-form"></div>
<script type="text/javascript">
var loadedForm = function(){

	var ModuleName = 'reports';
	var ModulePath = '';
	var KeyRecord  = 'noti_invitado';

	/*-------------------------------------------------------------------------------------------------------------*
	* Objetos que se definen para borrar, cuando se vuelve a descargar el modulo
    *-------------------------------------------------------------------------------------------------------------*/
	var ObjectToDestroy  = new Array (); //lista de objetos del objeto loadedGrid que necesitan destruirse;
	ObjectToDestroy.push({name : 'this.grid'    , 'method' : 'destroy();'});
	ObjectToDestroy.push({name : 'this.layout'  , 'method' : 'destroy();'});



	return {

        evento           : Events.grid.getSelectionModel().getSelected().get('even_evento'),
		PageSize         : 20,		
	
	    Init : function (){

		    Events.resizeWin(Events.mainWin,1000,500);
			
			this.dsDEP      = Events.createDataStore({
			     url        : 'process.php?_dc='+new Date().getTime(),
				 baseParams : {action : 'event.getRutas', evento : this.evento},
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
				 emptyText    : 'Buscar por dependencia ...',
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
			
			
			this.proxy = new Ext.data.HttpProxy({
				 url: '../reports/process.php'
			});			
			// Typical JsonReader.  Notice additional meta-data params for defining the core attributes of your json-response
			this.reader = new Ext.data.JsonReader({
			     root            : 'rows'   ,
				 successProperty : 'success',
				 totalProperty   :'total'   ,
				 idProperty      : 'invi_invitado',
				 id              : 'invi_invitado'
			},[{ name :'depe_dependencia' ,  mapping :'invi_invitado'    },
			   { name :'depe_nombre'      ,  mapping :'depe_nombre'      }, 
			   { name :'depe_ndireccion'  ,  mapping :'depe_ndireccion'  },
			   { name :'depe_ruta'        ,  mapping :'depe_ruta'        }, 
			   { name :'depe_nruta'       ,  mapping :'depe_nruta'       },
			   { name :'num'              ,  mapping :'num'              }
			]);
			
			this.ds  = new Ext.data.GroupingStore({
                proxy  : this.proxy,
				reader : this.reader,
				baseParams : {action:'event.getRutas' , evento : this.evento},
				groupField :'depe_nruta'
			});
			
			var params = new Object();	
		    params.action = 'event.getRutas';
			params.start  = 0;
		    params.limit  = this.PageSize;
		    params.evento = Events.grid.getSelectionModel().getSelected().get('even_evento');
			
			//Ext.apply(this.ds.baseParams, params);
			this.ds.load({params:params});
			
			this.pbar = new Ext.PagingToolbar({
				 store       : this.ds,
				 pageSize    : this.PageSize,
				 displayInfo : true,
				 displayMsg  : 'Mostrando registros {0} - {1} de {2}',
				 emptyMsg    : 'No hay registros para mostrar',
				 plugins     : [new Ext.ux.plugin.PagingToolbarResizer({prependCombo: true, displayText:'Mostrar :', options: [10,20,25,30,50,75,100]})]
		    });
						
			this.grid   = new Ext.grid.GridPanel({
				store   : this.ds,
				width   : 1000,
				height  : 400,
				region  :'center',
				border  : false,
				frame   : false,
				margins : '0 5 5 5',  
				view    : new Ext.grid.GroupingView({
					forceFit:false,
					showGroupName : false,
					groupTextTpl: '{text} ({[values.rs.length]})'
				}),
				loadMask: {msg:'Loading...',removeMask :true},
				columns :[
				    new Ext.grid.RowNumberer(),
				{   
				    header    : 'Dependencia',
					dataIndex : 'depe_nombre',
					width     : 400,
					sortable  : true,
					tooltip   : 'Nombre de la dependencia'
				},{
					header    : 'Direccion',
					dataIndex : 'depe_ndireccion',
					width     : 450,
					sortable  : true,
					tooltip   : 'Direccion donde se localiza la dependencia'
				},{
					header    : 'Invitados',
					dataIndex : 'num',
					width     : 50,
					sortable  : true,
					align     : 'center',
					tooltip   : 'Numero de invitados'
				},{
					header    : 'Dependencia',
					dataIndex : 'depe_nruta',
					width     : 100,
					sortable  : true,
					hidden    : true,
					tooltip   : 'Dependencia donde trabaja la persona'
				}],
				tbar : ['Grupo :',
				    this.cbSearch ,
					'-',
				{
				    text : '&nbsp;&nbsp; Exportar',
					icon : '../imagenes/icons/fileexport.png',
					menu : [{
					     text    : 'PDF',
						 icon    : '../imagenes/icons/page_white_acrobat.png',
						 scope   : this,
						 handler : function(){ this.getReport('rutas.getReport', 'PDF'); }
					},{
					     text    : 'Excel',
						 icon    : '../imagenes/icons/page_excel.png',
						 scope   : this,
						 handler : function(){ this.getReport('rutas.getReport', 'XLS'); }
					}]
				}],
				bbar : this.pbar
			});
			
			this.layout = new Ext.Panel({
				 layout  : 'border',
				 border : false,
				 layoutConfig: {
					 columns: 1
				 },
				 width:800,
				 height: 400,
				 items  : [this.grid]
			 });
			 
			 Events.mainWin.add(this.layout);
			 
			 //creamos el formulario oculto
			 this.fpanel   = new Ext.FormPanel({
				 formId    : 'frm-export-invi',
				 standardSubmit : true,
				 url       : "../reports/process.php",
				 renderTo  : "tmp-form",
				 hidden    : true,
				 items    : [{
				      xtype : 'hidden',
					  name  : 'grupo'     
				 },{
					  xtype : 'hidden',
					  name  : 'evento'
				 },{ 
				      xtype : 'hidden',
				      name  : 'doaction'
				 },{ 
				      xtype : 'hidden',
				      name  : 'format'
				 }]
			 });
			 this.form = this.fpanel.getForm();
			
	    },
		
		getReport : function(action, format){
			 
			 this.form.findField('grupo').setValue(this.cbSearch.getValue());
			 this.form.findField('evento').setValue(this.evento);
			 this.form.findField('doaction').setValue(action);
			 this.form.findField('format').setValue(format);
			 this.form.getEl().dom.action = this.fpanel.url;			 			 
		     this.form.submit();		 
			
			 
		},
		
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
