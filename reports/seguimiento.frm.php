

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
	ObjectToDestroy.push({name : 'this.fpanel'  , 'method' : 'destroy();'});
	ObjectToDestroy.push({name : 'this.layout'  , 'method' : 'destroy();'});



	return {

        evento           : Events.grid.getSelectionModel().getSelected().get('even_evento'),
		PageSize         : 20,		
	
	    Init : function (){

		    Events.resizeWin(Events.mainWin,1000,500);
			
			this.dsDEP      = Events.createDataStore({
			     url        : 'process.php?_dc='+new Date().getTime(),
				 baseParams : {action : 'event.getGrupos', evento : this.evento},
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
				 totalProperty   : 'total'   ,
				 idProperty      : 'even_invitado',
				 id              : 'even_invitado'
			},[{ name :'even_invitado'    ,  mapping :'even_invitado'    },
			   { name :'even_evento'      ,  mapping :'even_evento'      },
			   { name :'even_persona'     ,  mapping :'even_persona'     },
			   { name :'even_npersona'    ,  mapping :'even_npersona'    },
			   { name :'even_jerarquia'   ,  mapping :'even_jerarquia'   },
			   { name :'even_njerarquia'  ,  mapping :'even_njerarquia'  },
			   { name :'even_tgrupo'      ,  mapping :'even_tgrupo'      },
			   { name :'even_jerarquia'   ,  mapping :'even_jerarquia'   },
			   { name :'even_grupo'       ,  mapping :'even_grupo'       },
			   { name :'even_ngrupo'      ,  mapping :'even_ngrupo'      },
			   { name :'even_dependencia' ,  mapping :'even_dependencia' },
			   { name :'even_ndependencia',  mapping :'even_ndependencia'},
			   { name :'even_cargo'       ,  mapping :'even_cargo'       },			   
			   { name :'noti_notificado'  ,  mapping :'noti_notificado'  },
			   { name :'noti_recibio'     ,  mapping :'noti_recibio'     },
			   { name :'conf_called'      ,  mapping :'conf_called'      },
			   { name :'conf_confirmo'    ,  mapping :'conf_confirmo'    },
			   { name :'conf_quien'       ,  mapping :'conf_quien'       },
			   { name :'conf_nquien'      ,  mapping :'conf_nquien'      }
			]);
			
			this.ds  = new Ext.data.GroupingStore({
                proxy  : this.proxy,
				reader : this.reader,
				baseParams : {action:'evento.getSeguimiento' , evento : this.evento},
				groupField :'even_ndependencia'
			});
			
			var params = new Object();	
		    params.action = 'evento.getSeguimiento';
			params.start  = 0;
		    params.limit  = this.PageSize;
		    params.evento = this.evento;
			Ext.apply(this.ds.baseParams, params);
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
				    header    : 'Nombre',
					dataIndex : 'even_npersona',
					width     : 200,
					sortable  : true,
					tooltip   : 'Nombre de la persona invitada al evento'
				},{
					header    : 'Jerarquia',
					dataIndex : 'even_njerarquia',
					width     : 130,
					sortable  : true,
					hidden    : true,
					tooltip   : 'Jerarquia que tiene la persona'
				},{
					header    : 'Cargo',
					dataIndex : 'even_cargo',
					width     : 420,
					sortable  : true,
					tooltip   : 'Nombre de la persona invitada al evento'
				},{
				    header    : 'Dependencia',
					dataIndex : 'even_ndependencia',
					width     : 100,
					hidden    : true,
					sortable  : false,
					tooltip   : 'Dependencia donde trabaja la persona'
				},{
					header    : 'Recibio',
					dataIndex : 'noti_recibio',
					align     : 'center',
					width     : 60,
					sortable  : false,
					tooltip   : 'Indica si recibio la invitación'
				},{
				    header    : 'Confirmo',
					dataIndex : 'conf_confirmo',
					width     : 60,
					align     : 'center',
					sortable  : false,
					tooltip   : 'Dependencia donde trabaja la persona'
				},{
				    header    : '¿Quien asiste?',
					dataIndex : 'conf_nquien',
					width     : 100,
					sortable  : false,
					tooltip   : 'Si confirmo, indica quien asiste<br><b>N</b> = Nadie<br><b>T</b> = Titular<br><b>S</b> = Suplente'
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
						 handler : function(){ this.getReport('segumiento.getReport', 'PDF'); }
					},{
					     text    : 'Excel',
						 icon    : '../imagenes/icons/page_excel.png',
						 scope   : this
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
			 this.fpanel = new Ext.FormPanel({
				 formId   : 'frm-export',
				 hidden   : true ,
				 standardSubmit : true,
				 url      : '../reports/process.php',
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
			 this.fpanel.render('tmp-form');
			 this.form = this.fpanel.getForm();
			 
		   /*REBUIL EVENT OF MAIN WINDOW TO EVENT SUBMIT FORM */
			this.btnOK = Events.mainWin.buttons[0];
			this.btnOK.setText('Aceptar');
			this.btnOK.purgeListeners(); 
			this.btnOK.on('click',function(btn,evt){ Events.mainWin.hide(); },this);
			if(this.modo=='detail'){ this.btnOK.hide(); }else{this.btnOK.show();}
			
			 
			
	    },
		
		getReport : function(action, format){
			 this.form.findField('grupo').setValue(this.cbSearch.getValue());
			 this.form.findField('evento').setValue(this.evento);
			 this.form.findField('doaction').setValue(action);
			 this.form.findField('format').setValue(format);
			 this.form.el.dom.action = this.fpanel.url;
			 			 
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
