var contacto;$(document).ready(function(){$(".tab_content").hide();$("ul.tabs li:first").addClass("active").show();$(".tab_content:first").show();$("ul.tabs li").click(function(){$("ul.tabs li").removeClass("active");$(this).addClass("active");$(".tab_content").hide();var a=$(this).find("a").attr("href");$(a).fadeIn();return false});contacto=function(){return{modo:null,persona:{},activeTab:function(a){var b=$('#'+a);$("ul.tabs li").removeClass("active");b.addClass("active");$(".tab_content").hide();var c=$(b).find("a").attr("href");$(c).fadeIn();return false},init:function(){$("#pers_telefono").mask("(999) 999-9999");$("#pers_celular").mask("(999) 999-9999");$("#pers_dep_tel").mask("(999) 999-9999");$("#pers_dep_tel2").mask("(999) 999-9999");jQuery.fn.reset=function(){$(this).each(function(){this.reset()})};$('#btn-guardar').click(function(){contacto.save()});$('#btn-cancelar').click(function(){$('#ajax-submit-result').hide();$('#ajax-submit-indicator').hide();$('#ajax-submit-error').hide(1000);$('#input_name_src').val('');$('#input_apat_src').val('');$('#input_amat_src').val('');$('#input_id').val('');contacto.deleteGrupos();$('#frm-contacto').reset();$("#tabs").fadeOut('slow',function(){$("#search-tb").fadeIn('slow')})});$("#frm-contacto").validate({rules:{pers_titulo:{required:true},pers_sexo:{required:true},pers_nombre:{required:true},pers_apat:{required:true},pers_dep_grupo:{required:true},pers_dependencia:{required:true},pers_cargo:{required:true}},messages:{pers_sexo:"Indique el sexo",},submitHandler:function(){$.scrollTo('#tb-menu',{duration:800},{easing:'elasout'});$('#btn-guardar').attr('disabled','disabled');$('#ajax-submit-result').hide();$('#ajax-submit-error').hide();$('#ajax-submit-indicator').show();$.ajax({type:'POST',url:'process.php',data:$('#frm-contacto').serialize(),success:function(b){tbl.setCount(1);$('#ajax-submit-indicator').fadeOut(1000,function(){try{var a=eval('('+b+')')}catch(e){a=false}if(!a){alert('JSON Error : data [ '+b+' ]');return false}if(a.success==true){$('#submit-message').html(a.message);$('#ajax-submit-result').fadeIn(2000,function(){$('#input_name_src').val('');$('#input_apat_src').val('');$('#input_amat_src').val('');$('#input_id').val('');$("#tabs").fadeOut('slow',function(){contacto.deleteGrupos();$('#ajax-submit-result').hide();$('#ajax-submit-indicator').hide();$('#ajax-submit-error').hide();$("#search-tb").fadeIn('slow');$('#frm-contacto').reset();contacto.modo='insert';$("#action").val('contact.save')});$('#btn-guardar').removeAttr('disabled')})}else{$('#error-submit-msg').html(a.errors.msg);$('#ajax-submit-result').hide();$('#ajax-submit-indicator').hide();$('#ajax-submit-error').fadeIn(1000);$('#btn-guardar').removeAttr('disabled')}})}});return false}})},deleteGrupos:function(){var a=document.getElementsByName('detail');while(a.length>0){var b=a[0];b.parentNode.removeChild(b)}},save:function(){$('#frm-contacto').submit();var a=$('#frm-contacto').validate().invalid;for(key in a){var b=key;tab=$('#'+b).attr('tab');if(tab){this.activeTab(tab);break}}},edit:function(){},getInfo:function(d){$.ajax({url:'process.php',data:{action:'persona.getInfo',pers_persona:d},type:"POST",success:function(a){try{var b=eval('('+a+')')}catch(e){b=false}if(!b){alert(a);return false}contacto.setValues(b)}});$.ajax({url:'process.php',data:{action:'persona.getInfoGrupos',pers_persona:d},type:"POST",success:function(a){$('#grupos').append(a);var b=document.getElementsByName('detail');var c=b.length;tbl.setCount(c+1)}})},setValues:function(b){$("#pers_persona_id").val(b.pers_persona);$("#pers_titulo").val(b.pers_dtitulo);$("#pers_titulo_id").val(b.pers_titulo);$("#pers_sexo").val(b.pers_sexo);$("#pers_nombre").val(b.pers_nombre);$("#pers_apat").val(b.pers_apat);$("#pers_amat").val(b.pers_amat);var a=b.pers_fnac.split('-');$("#pers_fndia").val(a[2]);$("#pers_fnmes").val(a[1]);$("#pers_fnanio").val(a[0]);$("#pers_telefono").val(b.pers_telefono);$("#pers_nextel").val(b.pers_nextel);$("#pers_celular").val(b.pers_celular);$("#pers_email").val(b.pers_email);$("#pers_web").val(b.pers_web);$("#pers_name_esposa").val(b.pers_esposa);var a=b.pers_aniversarioboda.split('-');$("#pers_dia_aniv").val(a[2]);$("#pers_mes_aniv").val(a[1]);var a=b.pers_cumple_esposa.split('-');$("#pers_fdia_esposa").val(a[2]);$("#pers_fmes_esposa").val(a[1]);$("#pers_fanio_esposa").val(a[0]);$("#pers_tcalle").val(b.pers_dtcalle);$("#pers_tcalle_id").val(b.pers_tcalle);$("#pers_sufijo").val(b.pers_sufijo);$("#pers_calle").val(b.pers_dcalle);$("#pers_calle_id").val(b.pers_calle);$("#pers_numero").val(b.pers_numero);$("#pers_lote").val(b.pers_lote);$("#pers_manzana").val(b.pers_manzana);$("#pers_colonia").val(b.pers_dcolonia);$("#pers_colonia_id").val(b.pers_colonia);$("#pers_cp").val(b.pers_cp);$("#pers_refdomi").val(b.pers_refdomicilio);if(b.pers_invi_dm=='S'){$('#pers_invi_dm').attr('checked',true)}else{$('#pers_invi_dm').attr('checked',false)}if(b.pers_invi_avf=='S'){$('#pers_invi_avf').attr('checked',true)}else{$('#pers_invi_avf').attr('checked',false)}if(b.pers_invi_dievcm=='S'){$('#pers_invi_dievcm').attr('checked',true)}else{$('#pers_invi_dievcm').attr('checked',false)}if(b.pers_invi_maestra=='S'){$('#pers_invi_maestra').attr('checked',true)}else{$('#pers_invi_maestra').attr('checked',false)}$("#pers_dep_grupo").val(b.pers_dgrupo);$("#pers_dep_grupo_id").val(b.pers_grupo);$("#pers_dependencia").val(b.pers_ndependencia);$("#pers_dependencia_id").val(b.pers_dependencia);$("#pers_cargo").val(b.pers_cargo);$("#pers_dep_jerarquia").val(b.pers_jerarquia);$("#pers_liderazgo").val(b.pers_liderazgo);$("#pers_dep_tel").val(b.pers_tel_dep);$("#pers_dep_ext").val(b.pers_ext_dep);$("#pers_dep_ext_priv").val(b.pers_ext_priv_dep);$("#pers_dep_tel2").val(b.pers_tel2_dep);$("#pers_dep_fax").val(b.pers_fax_dep);$("#pers_dep_ext_fax").val(b.pers_fax_ext_dep);$("#pers_email_dep").val(b.pers_email_dep);$("#pers_observa").val(b.pers_observaciones)},showTapsInfo:function(){$("#search-tb").slideUp('slow',function(){$("#tabs").fadeIn('slow')});if(contacto.modo=='edit'){contacto.getInfo(contacto.persona.id)}else{$("#pers_nombre").val($("#input_name_src").val().toUpperCase());$("#pers_apat").val($("#input_apat_src").val().toUpperCase());$("#pers_amat").val($("#input_amat_src").val().toUpperCase())}},validate:function(d,f,g){if(!f)f='';if(!g)g='';var h=$("#"+d).val();$.ajax({url:'process.php',data:{action:'persona.validate',field:d,value:h,generico:f,cual:g},type:"POST",success:function(a){try{var b=eval('('+a+')')}catch(e){b=false}if(!b){alert('Error validando: data [ '+a+' ]');return false}var c=$('#'+b.field);if(b.success!=true){$(c).removeClass('x-form-field');$(c).addClass('x-form-invalid');$('#error-submit-msg').html(b.errors.msg);$('#ajax-submit-error').fadeIn(1000);if(b.script){eval(b.script)}}else{$(c).removeClass('x-form-invalid');$(c).addClass('x-form-field');$('#ajax-submit-error').slideUp(1000,function(){$('#error-submit-msg').html('')})}}})}}}();contacto.init();var m=function(o){var j=document.getElementById(o.tr);var k=document.getElementById(o.table);var l=1;return{addRow:function(){var c=j.cloneNode(true);var d=this.getCount();c.id='detail';c.name='detail';c.setAttribute('name','detail');if(navigator.appName.indexOf("Microsoft")>-1){var e='block';c.style.display='block'}else{var e='table-row';c.style.display='table-row-group'}c.style.visibility='visible';var f=c.getElementsByTagName("input")[0];f.name="grup_grupo[]";f.id="grup_grupo_"+d;f.onblur=function(){contacto.validate("grup_grupo_"+d,'S','grupo')};var f=c.getElementsByTagName("input")[1];f.name="grup_grupo_id[]";f.id="grup_grupo_id_"+d;f=c.getElementsByTagName("input")[2];f.name="grup_dependencia[]";f.id="grup_dependencia_"+d;f.onblur=function(){contacto.validate("grup_dependencia_"+d,'S','dependencia')};f=c.getElementsByTagName("input")[3];f.name="grup_dependencia_id[]";f.id="grup_dependencia_id_"+d;f=c.getElementsByTagName("input")[4];f.name="grup_cargo[]";f.id="grup_cargo_"+d;f=c.getElementsByTagName("select")[0];f.name="grup_jerarquia[]";f.id="grup_jerarquia_"+d;a=c.getElementsByTagName("a")[0];a.id="remove_"+d;a.href='javascript: void(0);';a.onclick=function(){tbl.confirm('delete',null,d)};k.appendChild(c);var g="grup_grupo_"+d;var h=new bsn.AutoSuggest(g,{script:"process.php?action=grupo.getList&",meth:'get',varname:"query",json:true,shownoresults:false,noresults:"No hay resultados - Agregar ",handleNoResult:function(){},maxresults:10,cache:true,minchars:1,timeout:1000000,callback:function(a){$('#grup_grupo_id_'+d).val(a.id)}});var g="grup_dependencia_"+d;var i=new bsn.AutoSuggest(g,{script:"process.php?tip=a&action=dependencia.getList&",meth:'get',varname:"query",json:true,shownoresults:true,noresults:"No hay resultados - Agregar ",handleNoResult:function(){var a='process.php?action=dependencia.getFrm&return[name]=grup_dependencia_'+d+'&return[id]=grup_dependencia_id_'+d;var b=$("#grup_grupo_id_"+d).val();if(b.length==0||b==""){alert("Antes de continuar, debes de elegir un grupo");return false};a=a+'&grupo='+b;jQuery.facebox({ajax:a})},maxresults:10,width:500,cache:true,minchars:1,timeout:10000,callback:function(a){$('#grup_dependencia_id_'+d).val(a.id)}});$.scrollTo('#grup_grupo_'+d,{duration:800},{easing:'elasout'});this.inCount()},updateRow:function(a,o){document.getElementById('disp_nombre_'+a).value=o.nombre;document.getElementById('disp_descrip_'+a).value=o.descrip;document.getElementById('disp_valores_'+a).value=o.valores;document.getElementById('disp_activo_'+a).value=o.activo},removeRow:function(a){var b=document.getElementById('grup_grupo_'+a);var c=b.parentNode.parentNode;tbody=c.parentNode;tbody.parentNode.removeChild(tbody)},confirm:function(a,b,c){var d=confirm("¿ Seguro que desea realizar esta operación ? \n");if(!d)return false;this.removeRow(c)},getCount:function(){return l},setCount:function(a){l=a},inCount:function(){l=l+1;return(l)}}};tbl=new m({table:'grupos',tr:'detail-template'});$("#add-institution").click(function(){tbl.addRow()});$('#frm-search').bind('submit',function(){return false});$('#frm-person').bind('submit',function(){return false});var n={script:"process.php?action=contact.getByFilter&",meth:'get',varname:"input",cache:false,json:true,shownoresults:true,noresults:"No hay resultados - Agregar ",handleNoResult:function(){$('#frm-contacto').reset();contacto.modo='insert';$("#action").val('contact.save');$("#modo").val('edit');tbl.setCount(1);contacto.deleteGrupos();contacto.showTapsInfo()},maxresults:15,cache:true,minchars:1,timeout:9000,getFields:{name:'#input_name_src',apat:'#input_apat_src',amat:'#input_amat_src'},callback:function(a){$('#frm-contacto').reset();$('#input_id').val(a.id);$("#modo").val('edit');$("#action").val('contact.edit');$("#pers_persona_id").val(a.id);contacto.modo='edit';contacto.persona.id=a.id;contacto.persona.nombre=a.nombre;contacto.persona.amat=a.amat;contacto.persona.apat=a.apat;contacto.showTapsInfo()}};var p=new bsn.AutoSuggest('input_name_src',n);var p=new bsn.AutoSuggest('input_apat_src',n);var p=new bsn.AutoSuggest('input_amat_src',n);$('#pers_titulo').autocomplete('process.php?tip=a&action=titulos.getList',{width:156,selectFirst:true,minChars:0,autoFill:true,mustMatch:true,scrollHeight:220}).result(function(a,b,c){if(b){$('#pers_titulo_id').val(b[1])}});$('#pers_tcalle').autocomplete('process.php?tip=a&action=tcalles.getList',{width:156,selectFirst:true,minChars:0,autoFill:true,mustMatch:true}).result(function(a,b,c){if(b){$('#pers_tcalle_id').val(b[1])}});$('#pers_calle').autocomplete('process.php?tip=a&action=calles.getList',{selectFirst:true,minChars:0,autoFill:true,mustMatch:true}).result(function(a,b,c){if(b){$('#pers_calle_id').val(b[1])}});var n={script:"process.php?action=colonias.getList&",meth:'get',varname:"q",json:true,shownoresults:false,noresults:"No hay resultados - Agregar ",handleNoResult:contacto.showTapsInfo,maxresults:10,cache:true,minchars:2,timeout:1000000,callback:function(a){$('#pers_colonia_id').val(a.id)}};var q=new bsn.AutoSuggest('pers_colonia',n);var q=new bsn.AutoSuggest('pers_dep_grupo',{script:"process.php?action=grupo.getList&",meth:'get',varname:"query",json:true,shownoresults:false,noresults:"No hay resultados - Agregar ",handleNoResult:contacto.showTapsInfo,maxresults:10,cache:true,minchars:1,timeout:1000000,width:500,callback:function(a){$('#pers_dep_grupo_id').val(a.id)}});var r=new bsn.AutoSuggest('pers_dependencia',{script:"process.php?tip=a&action=dependencia.getList&",meth:'get',varname:"query",json:true,shownoresults:true,noresults:"No hay resultados - Agregar ",handleNoResult:function(){var a='process.php?action=dependencia.getFrm&return[name]=pers_dependencia&return[id]=pers_dependencia_id';var b=$('#pers_dep_grupo_id').val();if(b.length==0||b==""){alert("Antes de continuar, debes de elegir un grupo valido");$('pers_dep_grupo').focus();return false}a=a+'&grupo='+b;jQuery.facebox({ajax:a})},maxresults:10,width:500,cache:true,minchars:1,timeout:10000,getFields:{grupo:'#pers_dep_grupo_id'},callback:function(a){$('#pers_dependencia_id').val(a.id)}});var s=$('a[rel*=facebox]').facebox({loading_image:'../js/facebox/loading.gif',close_image:'../js/facebox/closelabel.gif',overlay:false});$.facebox.settings.opacity=0.2});