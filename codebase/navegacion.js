//ARRAYS MENUS
var inicio = new Array (
"Inicio", "/index.html", "",
"Secciones", "", "",
"Scripts y código", "/taller/taller.html", "Scripts y código para la creación de páginas",
"Superscripts", "/superscripts/superscripts.html", "Potentes utilidades JavaScript para webmasters",
"Herramientas desarrolladores", "/herramientas/herramientas.html", "Aplicaciones y herramientas prácticas para la creación de páginas",
"Exclusivos de El Código", "", "",
"Curso de JavaScript", "/cgi-bin/DBread.cgi?tabla=herramientas&campo=0&clave=49&info=1", "Cursos de JavaScript de El Código",
"JavaScript avanzado", "/cgi-bin/DBread.cgi?tabla=herramientas&campo=0&clave=48&info=1", "Artículos sobre aspectos avanzados de la programación JavaScript",
"Asistentes creación código", "/tiralineas/tiralineas.html", "Asistentes para obtener código JavaScript a medida",
"Foros de discusión", "/cgi-bin/yabb2/YaBB.pl", "Foros de ayuda para la resolución de dudas",
"Buscador", "", "",
"", "#BUSCADOR#", "",
"Búsqueda avanzada", "/buscador.html", "Opciones avanzadas de búsqueda",
"Colaboradores", "", "",
"Enviar scripts", "/taller/enviascripts.html", "Formulario de envío de ejemplos",
"Top 10 colaboradores", "/taller/autores.html", "Lista de colaboradores de El Código",
"Recomendar a un amigo", "javascript:void(window.open('/recomendar.html', '_blank', 'toolbar=no,menubar=no,directories=no,status=no,resizable=yes,location=no,scrollbars=no,height=400,width=500'))", "Formulario de recomendación"
)
//VARIABLES
var menu
var EstiloTitulo = '<span class="titulomenu">'
var EstiloTituloOff = '</span><br>'
var EstiloSuperTitulo = '<span class="supertitulomenu">'
var EstiloSuperTituloOff = '</span><br>'
var SeparadorS = '<img src="/images/dot.gif" width="1" height="8"><br>'
var SeparadorM = '<img src="/images/dot.gif" width="1" height="12"><br>'

function Enlace(item, pagina, titulo) {
	var enlace
	var clase2 = (pagina == '/index.html') ? '' : ' class="remarcado"'
	if ( pagina.indexOf(":") == -1 ) {
		enlace = (item != pagina ? '<a class="pequeno" href="' + pagina + '" title="' + titulo + '">' : '<span' + clase2 + '>')
	} else {
		enlace = '<a class="pequeno" href="' + pagina + '" title="' + titulo + '">'
	}
	return enlace 
}

function EnlaceOff(item, pagina) {
return (item != pagina? '</a>' : '</span>')
}

function MuestraPie( urlsig, cerrar) {
  var pie = ''+
  '<center><form>'+
  '<table width="80%" cellspacing="8">'+
  '<tr><td colspan="2" align="center">'+
  ((urlsig != 'index.html') ? '<input type="button" value="Página de inicio" name="inicio" onclick="location.href=\'/index.html\';" class="metal">&nbsp;' : '' )+
  ((urlsig != '')&&(urlsig != 'index.html') ? '<input type="button" value="Capítulo siguiente" name="siguiente" onclick="location.href=\'' + urlsig + '\';" class="metal">' : '' )+
  ((cerrar == true) ? '<input type="button" value="Cerrar" name="cerrar" onclick="self.close();" class="metal">' : '' )+
  '</td></tr><tr><td colspan="2" align="center"><small>&copy; 1999 - 2008 por '+
  '<a href=\'javascript:forego("15746 21759 19569 5795 25986 24691 18528 5795 13172 15746 21759 19569 5795 25986 24691 18528 5795 1113 19569 5795 21947",27161,10733)\'>Iván Nieto Pérez</a>'+
  '<br>'+
  '<a href="/copyright.html" target="_self">Aviso legal</a> | '+
  '<a href="/creditos.html" target="_self">Acerca de El Código</a> | '+
  '<a href="/sugerencias.html" target="_self">Sugerencias</a>'+
  '</small></td></tr></table></form></center>'+
  ((urlsig == 'index.html') ? UltimaActualizacion() : '' )
  
  document.write(pie)
}

function MenuNavegacion2 ( ruta, item, paginas ) {
	numelem = paginas.length
	menu = ''
	for ( var x = 0; x < numelem; x=x+3 ) {
		if ( (paginas[x+1] == "") && (x == 0) ) 
			menu += SeparadorS + EstiloSuperTitulo + paginas[x] + EstiloSuperTituloOff + SeparadorS + '\n'
		else if ( paginas[x+1] == "" )
			menu += SeparadorS + EstiloTitulo + paginas[x] + EstiloTituloOff + SeparadorS + '\n'
		else if ( paginas[x] == "Inicio" )  
			menu += Enlace(item, paginas[x+1], paginas[x+2]) + '<img src="/images/logo_small.gif" alt="{El Codigo}" border="0">' + EnlaceOff(item, paginas[x+1]) + '<br><small class="logo">Código JavaScript para copiar y pegar</small><br><br>'
		else if (paginas[x+1] == "#BUSCADOR#") {
			if (item != "/index.html")
				buscador(11)
		}
		else 
			menu += Enlace(item, paginas[x+1], paginas[x+2]) + paginas[x] + EnlaceOff(item, paginas[x+1]) + '<br>' + SeparadorS + '\n'
	
	}
	document.write( menu )
}

function buscador( ancho ) {
  menu += '<table width="60%" border="0" cellpadding="0" cellspacing="3">'
  menu += '<form name="buscar" action="/cgi-bin/buscar.cgi" method="GET" onSubmit="return validaBuscador(this)">\n'
  menu += '<tr><td>'
  menu += '<!-- Método: todas las palabras --><input type="hidden" name="X" value="1">\n'
  menu += EstiloTitulo + 'Buscador' + EstiloTituloOff
  menu += '</td></tr><tr><td>'
  menu += '<input type="text" name="Q" size="' + ancho + '">\n'
  menu += '</td></tr><tr><td>'
  menu += '<input type="submit" value="Buscar" name="B" class="metal">\n'
  menu += '</td></tr>'
  menu += '</form>\n'
  menu += '</table>'
}

function validaBuscador(formu) {
	if(formu.Q.value == "") {
		alert('Introduzca una palabra de búsqueda en el formulario.')
		return false
	}
	return true
}

//BANNER
//canal: taller, herramientas, ejemplos, tiralineas, tutoriales, general
//tipo: banner horizontal o vertical
function ShowBanner( canal, tipo ) {
	var banner
	var mychannel
	if ( canal == 'taller' ) mychannel = '5201172967'
	else if ( canal == 'herramientas' ) mychannel = '5111208711'
	else if ( canal == 'ejemplos' ) mychannel = '7398213174'
	else if ( canal == 'tiralineas' ) mychannel = '3179598417'
	else if ( canal == 'tutoriales' ) mychannel = '8032557656'
	else if ( canal == 'foros' ) mychannel = '6159791855'
	else if ( canal == 'superscripts' ) mychannel = '2501536988'
	else mychannel = '3696579891'
	
	if ( (tipo == 0) || (tipo == 3) ) {	//banner vertical
		banner = 'google_alternate_color = "FAFAF5";google_ad_width = 120;google_ad_height = 600;google_ad_format = "120x600_as";google_ad_type = "text_image";google_ad_channel = "' + mychannel + '";google_color_border = "FAFAF5";google_color_bg = "FAFAF5";google_color_link = "554B8B";google_color_text = "483713";google_color_url = "A25151";google_ui_features = "rc:0";'
	} else if ( tipo == 1 ) {	//banner links horizontal
		banner = 'google_ad_width = 468;google_ad_height = 15;google_ad_format = "468x15_0ads_al";google_ad_channel ="' + mychannel + '";google_color_border = "A25151";google_color_bg = "FAFAF5";google_color_link = "0000CC";google_color_url = "008000";google_color_text = "483713";'
	} else if ( tipo == 2 ) {	//referral adsense
		banner = 'google_ad_width = 125;google_ad_height = 125;google_ad_format = "125x125_as_rimg";google_cpa_choice = "CAAQmeqbzgEaCB4V1s2_pU2WKLXE93M";'
	} else if ( tipo == 4 ) {	//banner horizontal
		banner = 'google_alternate_color = "FAFAF5";google_ad_width = 468;google_ad_height = 60;google_ad_format = "468x60_as";google_ad_type = "text_image";google_ad_channel ="' + mychannel + '";google_color_border = "A25151";google_color_bg = "FAFAF5";google_color_link = "0000CC";google_color_url = "008000";google_color_text = "483713";'
	} else if ( tipo == 5 ) {	//banner links vertical
		banner = 'google_alternate_color = "FAFAF5";google_ad_width = 120;google_ad_height = 90;google_ad_format = "120x90_0ads_al";google_ad_channel ="' + mychannel + '";google_color_border = "A25151";google_color_bg = "FAFAF5";google_color_link = "0000CC";google_color_url = "008000";google_color_text = "483713";'
	} else if ( tipo == 6 ) {	//rectangulo mediano
		banner = 'google_alternate_color = "FAFAF5";google_ad_width = 300;google_ad_height = 250;google_ad_format = "300x250_as";google_ad_type = "text";google_ad_channel ="' + mychannel + '";google_color_border = "FAFAF5";google_color_bg = "FAFAF5";google_color_link = "A25151";google_color_text = "483713";google_color_url = "554B8B";'
	} else {
		return
	}
	
	document.write( "<script type=\"text/javascript\"><!--\ngoogle_ad_client = \"pub-2146507246466737\";" + banner + "\n//--></script>\n<script type=\"text/javascript\" src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\"></script>\n" )
}

function UltimaActualizacion() {
	var fecha = new Date( document.lastModified )
	fecha = fecha.toGMTString()
	return "<small>&nbsp;Ultima actualización: " + fecha + "</small>"
}


// <!-- 389138404
// This script is (C) Copyright 2004 Jim Tucek
// Leave these comments alone!  For more info, visit
// www.jracademy.com/~jtucek/email/ 

function forego(grandfather,agriculture,alchemist) {
 grandfather += ' '
 var bed = grandfather.length
 var center = 0
 var connection = ''
 for(var opposite = 0; opposite < bed; opposite++) {
  center = 0
  while(grandfather.charCodeAt(opposite) != 32) {
   center = center * 10
   center = center + grandfather.charCodeAt(opposite)-48
   opposite++
  }
  connection += String.fromCharCode(sleep(center,agriculture,alchemist))
 }
parent.location = 'm'+'a'+'i'+'l'+'t'+'o'+':'+connection
}

function sleep(hypothesis,human,information) {
 if (information % 2 == 0) {
  lottery = 1
  for(var death = 1; death <= information/2; death++) {
   memory = (hypothesis*hypothesis) % human
   lottery = (memory*lottery) % human
  }
 } else {
  lottery = hypothesis
  for(var night = 1; night <= information/2; night++) {
   memory = (hypothesis*hypothesis) % human
   lottery = (memory*lottery) % human
  }
 }
return lottery
}