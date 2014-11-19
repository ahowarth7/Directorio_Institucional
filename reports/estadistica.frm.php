<?PHP
    
	define('PATH_BASE','../');
	
	
	$path = '../'; //dirname(__FILE__);
	require_once("../libs/adodb/adodb-exceptions.inc.php");
	require_once("../libs/adodb/adodb.inc.php");
	require_once("../includes/utf8.php");
	require_once("../includes/config.php");
	require_once("../includes/conexion.php");
	require_once("../libs/lib/lib.php");	
	require_once('../eventos/eventos.class.php');
	
	 
    //conexion
    $db = Conectar();	
	$evento = new Evento($db);
	
	$statics = $evento->getStatics($_POST['evento']);
	
	$db->Close();
	
	
	
?>
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

		    Events.resizeWin(Events.mainWin,600,450);
			
			//creamos el formulario oculto
			 this.fpanel = new Ext.FormPanel({
				 formId   : 'frm-export',
				 hidden   : true ,
				 standardSubmit : true,
				 url      : '../reports/process.php',
				 items    : [{
					  xtype : 'hidden',
					  name  : 'evento'
				 },{ 
				      xtype : 'hidden',
				      name  : 'liderazgo'
				 },{
					  xtype : 'hidden',
				      name  : 'recibio' 
				 },{
					  xtype : 'hidden',
				      name  : 'confirmo'
				 },{
					  xtype : 'hidden',
				      name  : 'quien'
				 },{ 
				      xtype : 'hidden',
				      name  : 'doaction'
				 },{ 
				      xtype : 'hidden',
				      name  : 'format'
				 },{
				      xtype : 'hidden',
				      name  : 'treport'
				 }]
			 });
			 this.fpanel.render('tmp-form');
			 this.form = this.fpanel.getForm();
			 
			 
			
			/*REBUIL EVENT OF MAIN WINDOW TO EVENT SUBMIT FORM */
			this.btnOK = Events.mainWin.buttons[0];
			this.btnOK.setText('Imprimit');
			this.btnOK.purgeListeners(); 
			this.btnOK.on('click',function(btn,evt){ this.getReport('statics.print','PDF'); },this);
			if(this.modo=='detail'){ this.btnOK.hide(); }else{this.btnOK.show();}
			
			
			 
			
	    },
		
		getReport : function(action, format){
			 
			 this.form.findField('evento').setValue(this.evento);
			 this.form.findField('doaction').setValue(action);
			 this.form.findField('format').setValue(format);			 			 
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

<div style="width:100%; padding-top:10px; font-size: 12px; font-family: 'Times New Roman', Times, serif;" align="center">
<form action="process.php" method="post" enctype="application/x-www-form-urlencoded" name="form" id="form">
<table width="98%" border="0" cellspacing="0" align="center">
  <tr>
    <td height="35" colspan="3" bgcolor="#4F81BD" style="color: #FFF; text-align: center; font-weight: bold;">RESUMEN ESTADISTICO</td>
  </tr>
  <tr height="25">
    <td width="60%" bgcolor="#4F81BD" style="border:1px solid #FFF"><div align="center" style="color:#FFF"><b>RUBRO</b></div></td>
    <td width="19%" bgcolor="#4F81BD" style="border:1px solid #FFF"><div align="center" style="color:#FFF"><b>CANTIDAD</b></div></td>
    <td width="21%" bgcolor="#4F81BD" style="border:1px solid #FFF"><div align="center" style="color:#FFF"><b>DETALLE</b></div></td>
  </tr>
  <tr height="25">
    <td width="60%" bgcolor="#D0D8E8" style="text-align: left"><div style="font-size:11px; padding:2px;">GRUPOS INVITADOS</div></td>
    <td width="19%" bgcolor="#D0D8E8" style="border:1px solid #FFF"><div align="center"><? echo number_format($statics['ngrupos']); ?></div></td>
    <td width="21%" bgcolor="#D0D8E8" style="border:1px solid #FFF"><div align="center"><a href="#" onclick="javascript:void(0); loadedForm.getReport('event.groups().getReport','PDF'); ">Detalle</a></div></td>
  </tr>
  <tr height="25">
    <td bgcolor="#E9EDF4" style="text-align: left"><div style="font-size:11px; padding:2px;">PERSONAS INVITADAS&#13;</div></td>
    <td bgcolor="#E9EDF4" style="border:1px solid #FFF"><div align="center"><? echo number_format($statics['ninvitados']); ?></div></td>
    <td bgcolor="#E9EDF4" style="border:1px solid #FFF"><div align="center"><a href="#" onclick="javascript:void(0); loadedForm.getReport('invitados.getReport','PDF');">Detalle</a></div></td>
  </tr>
  <tr height="25">
    <td width="60%" bgcolor="#D0D8E8" style="text-align: left"><div style="font-size:11px; padding:2px;">
      <p>INVITACIONES ENTREGADAS&#13;</p>
    </div></td>
    <td width="19%" bgcolor="#D0D8E8" style="border:1px solid #FFF"><div align="center"><? echo number_format($statics['nentregadas']); ?></div></td>
    <td width="21%" bgcolor="#D0D8E8" style="border:1px solid #FFF"><div align="center"><a href="#" onclick="javascript:void(0);  loadedForm.form.findField('treport').setValue('IE'); loadedForm.form.findField('recibio').setValue('S'); loadedForm.getReport('event.confirmWho().getReport','PDF');">Detalle</a></div></td>
  </tr>
  <tr height="25">
    <td bgcolor="#E9EDF4" style="text-align: left"><div style="font-size:11px; padding:2px;">PERSONAS CONFIRMADAS&#13;</div></td>
    <td bgcolor="#E9EDF4" style="border:1px solid #FFF"><div align="center"><? echo number_format($statics['nconfirmados']); ?></div></td>
    <td bgcolor="#E9EDF4" style="border:1px solid #FFF"><div align="center"><a href="#" onclick="javascript:void(0);  loadedForm.form.findField('treport').setValue('PC'); loadedForm.form.findField('confirmo').setValue('S'); loadedForm.getReport('event.confirmWho().getReport','PDF');">Detalle</a></div></td>
  </tr>
  <tr height="25">
    <td width="60%" bgcolor="#D0D8E8" style="text-align: left"><div style="font-size:11px; padding:2px;">TITULARES QUE ASISTEN&#13;</div></td>
    <td width="19%" bgcolor="#D0D8E8" style="border:1px solid #FFF"><div align="center"><? echo number_format($statics['ntitulares']); ?></div></td>
    <td width="21%" bgcolor="#D0D8E8" style="border:1px solid #FFF"><div align="center"><a href="#" onclick="javascript:void(0);  loadedForm.form.findField('treport').setValue('QA'); loadedForm.form.findField('recibio').setValue('S'); loadedForm.form.findField('confirmo').setValue('S'); loadedForm.form.findField('quien').setValue('T'); loadedForm.getReport('event.confirmWho().getReport','PDF');">Detalle</a></div></td>
  </tr>
  <tr height="25">
    <td bgcolor="#E9EDF4" style="text-align: left"><div style="font-size:11px; padding:2px;">SUPLENTES</div></td>
    <td bgcolor="#E9EDF4" style="border:1px solid #FFF"><div align="center"><? echo number_format($statics['nsuplentes']); ?></div></td>
    <td bgcolor="#E9EDF4" style="border:1px solid #FFF"><div align="center"><a href="#" onclick="javascript:void(0); loadedForm.form.findField('treport').setValue('QA'); loadedForm.form.findField('confirmo').setValue('S'); loadedForm.form.findField('quien').setValue('S'); loadedForm.getReport('event.confirmWho().getReport','PDF');">Detalle</a></div></td>
  </tr>
  <tr height="25">
    <td width="60%" bgcolor="#D0D8E8" style="text-align: left"><div style="font-size:11px; padding:2px;">NO ASISTEN&#13;</div></td>
    <td width="19%" bgcolor="#D0D8E8" style="border:1px solid #FFF"><div align="center"><? echo number_format($statics['nnoasisten']); ?></div></td>
    <td width="21%" bgcolor="#D0D8E8" style="border:1px solid #FFF"><div align="center"><a href="#" onclick="javascript:void(0);  loadedForm.form.findField('treport').setValue('QA'); loadedForm.form.findField('recibio').setValue('S'); loadedForm.form.findField('confirmo').setValue('S'); loadedForm.form.findField('quien').setValue('N');  loadedForm.getReport('event.confirmWho().getReport','PDF');">Detalle</a></div></td>
  </tr>
  <tr height="25">
    <td bgcolor="#E9EDF4" style="text-align: left"><div style="font-size:11px; padding:2px;">LIDERES DE PRIMER NIVEL</div></td>
    <td bgcolor="#E9EDF4" style="border:1px solid #FFF"><div align="center"><? echo number_format($statics['rliderasgo'][1]['cnt']); ?></div></td>
    <td bgcolor="#E9EDF4" style="border:1px solid #FFF"><div align="center"><a href="#" onclick="javascript:void(0);  loadedForm.form.findField('liderazgo').setValue('1'); loadedForm.getReport('event.liderazgo().getReport','PDF');">Detalle</a> </div></td>
  </tr>
  <tr height="25">
    <td width="60%" bgcolor="#D0D8E8" style="text-align: left"><div style="font-size:11px; padding:2px;">LIDERES DE SEGUNDO NIVEL</div></td>
    <td width="19%" bgcolor="#D0D8E8" style="border:1px solid #FFF"><div align="center"><? echo number_format($statics['rliderasgo'][2]['cnt']); ?></div></td>
    <td width="21%" bgcolor="#D0D8E8" style="border:1px solid #FFF"><div align="center"><a href="#" onclick="javascript:void(0);  loadedForm.form.findField('liderazgo').setValue('2'); loadedForm.getReport('event.liderazgo().getReport','PDF');">Detalle</a></div></td>
  </tr>
  <tr height="25">
    <td bgcolor="#E9EDF4" style="text-align: left"><div style="font-size:11px; padding:2px;">LIDERES DE TERCER NIVEL</div></td>
    <td bgcolor="#E9EDF4" style="border:1px solid #FFF"><div align="center"><? echo number_format($statics['rliderasgo'][3]['cnt']); ?></div></td>
    <td bgcolor="#E9EDF4" style="border:1px solid #FFF"><div align="center"><a href="#" onclick="javascript:void(0);  loadedForm.form.findField('liderazgo').setValue('3'); loadedForm.getReport('event.liderazgo().getReport','PDF');">Detalle</a></div></td>
  </tr> 
</table>
 <input type="hidden" name="evento" value=""/>
 <input type="hidden" name="action" value=""/>
 <input type="hidden" name="format" value=""/>
 

</form>
</div>


