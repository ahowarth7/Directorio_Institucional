<?php

//**************************************************************************
// FUNCION DE PAGINACION
//**************************************************************************
/*
Requiere de las siguientes variables:

$inicio=0;
$pagina=1;
$registros=10;
if(isset($_GET['pagina']))
{
if ($_GET['pagina'] != '' and $_GET['pagina'] != '1' )
{
$pagina = $_GET['pagina'];
}
}
else
{
if ($_POST['pagina'] != '' and $_POST['pagina'] != '1' )
{
$pagina = $_POST['pagina'];
}
}

$inicio = ($pagina*$registros)-$registros;
*/
function f_paginacion ($total_registros,$inicio, $registros,$rds,$archivo,$pagina)
{
   $total_paginas = ceil($total_registros / $registros);

   mysql_free_result($rds);

   if($total_registros) {


      echo "<center>";


      if(($pagina - 1) > 0) {
         echo "<a href='$archivo?pagina=".($pagina-1)."'>< Anterior</a> ";
      }



      for ($i=1; $i<=$total_paginas; $i++){
         if ($pagina == $i)
         echo "<b>".$pagina."</b> ";
         else
         echo "<a href='$archivo?pagina=$i'>$i</a> ";
      }

      if(($pagina + 1)<=$total_paginas) {
         echo " <a href='$archivo?pagina=".($pagina+1)."'>Siguiente ></a>";
      }

      echo "</center>";

   }


}

//*****************************************************************************
// IMPRIME UN MENSAJE EN PANTALLA CON EL ICONO QUE SE INDIQUE
//*****************************************************************************
function f_mensaje($mensaje,$ancho,$clase_imagen)
{
   $_nivel="../";

   switch ($clase_imagen)
   {
      case "pregunta":
         $bgcolor="#F3F5F8";
         $linea="#B1C3D9";
         $image="../imagenes/pregunta.png";
         break;

      case "datos":
         $bgcolor="#F3F5F8";
         $linea="#B1C3D9";
         $image="../imagenes/documento.png";
         break;

      case "error":
         $bgcolor="#F3F5F8";
         $linea="#B1C3D9";
         $image="../imagenes/error.png";
         break;

      case "exito":
         $bgcolor="#F3F5F8";
         $linea="#B1C3D9";
         $image="../imagenes/exito.png";
         break;

      case "buscar":
         $bgcolor="#F3F5F8";
         $linea="#B1C3D9";
         $image="../imagenes/buscar.png";
         break;

      case "seguro":
         $bgcolor="#F3F5F8";
         $linea="#B1C3D9";
         $image="../imagenes/seguridad.png";
         break;

      case "advertencia";
      $bgcolor="#F3F5F8";
      $linea="#B1C3D9";
      $image="../imagenes/advertencia.png";
      break;

      default:
         $bgcolor="#F3F5F8";
         $linea="#B1C3D9";
         $image="../imagenes/advertencia.png";
         break;

   }

?>
     
   <table id= 'mensaje_pantalla' align='center' width='<? echo $ancho ?>"'  border='0' cellpadding='3' cellspacing='0' bgcolor='#FFFCC6' style='border: 1px solid <?php echo $linea ?> '>
      <tr bgcolor='<?php echo $bgcolor ?>' valign='middle'>
         <td  align="center" width='13'><img src= '<?php echo $_nivel."imagenes/".$image ?>' ></td>
         <td width='90%'><?php echo $mensaje ?></td>
      </tr>
   </table>
   
<?php

}


function f_asigna_id($tabla, $campo_id,$conexion)
{
    $qryId="select $campo_id from $tabla
           order by $campo_id DESC limit 1";

   $rdsId=mysql_query($qryId,$conexion);

   $Id_array=mysql_fetch_assoc($rdsId);

    $Id = $Id_array["$campo_id"]+1;

   return $Id;
}


// REALIZA SALTOS DE LINEA DEPENDIENDO DEL NUMERO ASIGNADO
function f_espacio($espacios)
{
   $contador = 1;
   while ($contador <= $espacios)
   {
      echo "</br>";
      $contador++;
   }
}

// IMPRIME EL CONTENIDO DE UN ARREGLO
function f_imprime_arreglo ($arreglo)
{
   echo '<pre>';
   print_r($arreglo);
   echo '<pre>';
}


function f_redireccionar($ruta)
{
 ?>
 <?php
}

function f_title_main($titulo,$ancho)
{
   ?>  
   <!-- <title><?php echo $titulo ?></title> -->
   </br>
   <table  id="title_main" align="center" width="<?php echo $ancho ?>">
   <tr>
   <td align="center"><?php echo $titulo ?> </td>
   </tr>
   </table>
   </br>
   <?php
}

function f_type_text2($nombre,$valor,$tamaño,$maxlenght)
{
   ?>
   <input type="text" class="texto" size="<? echo $tamaño ?>" name="<? echo $nombre ?>" value="<? echo $valor ?>" maxlength="<? echo $maxlenght ?>" >
   <?php
}


function f_type_text($nombre,$valor,$tamaño,$maxlenght,$disabled,$validacion)
{
   ?>
   <input type="text" class="texto" size="<? echo $tamaño ?>" name="<? echo $nombre ?>" value="<? echo $valor ?>" maxlength="<? echo $maxlenght ?>" <? echo "$disabled" ?>  <? echo "$validacion" ?>  >
   <?php
}

function f_type_text_num($nombre,$valor,$tamaño,$maxlenght,$disabled,$validacion,$onkeypress)
{
   ?>
   <input type="text" class="texto" size="<? echo $tamaño ?>" name="<? echo $nombre ?>" value="<? echo $valor ?>"  onkeypress="return onlyDigits(event,'noDec')"  maxlength="<? echo $maxlenght ?>" <? echo "$disabled" ?>  onblur="javascript:this.value=this.value.toUpperCase();"     >
   <?php
}

function f_type_text_mail($nombre,$valor,$tamaño,$maxlenght,$disabled,$validacion)
{
   ?>
   <input type="text" class="texto" size="<? echo $tamaño ?>" name="<? echo $nombre ?>" value="<? echo $valor ?>"   maxlength="<? echo $maxlenght ?>" <? echo "$disabled" ?>  onblur="return isEmailAddress(<? echo $nombre ?>,'<? echo $nombre ?>' )"     >
   <?php
}

function f_type_hidden($nombre,$valor)
{
   ?>
   <input type="hidden" name="<? echo $nombre ?>" value="<? echo $valor ?>" >
   <?php
}

function f_type_radio($nombre,$valor)
{
   ?>
   <input type="radio" name="<? echo $nombre ?>" value="<? echo $valor ?>" >
   <?php
}

function  f_type_pass($nombre,$valor)
{
   ?>
   <input type="password" name="<?php echo $nombre ?>" value="<?php echo $valor ?>" >
   <?php
}

function f_type_button($nombre,$valor,$ancho,$tipo_accion,$accion,$clase,$disabled,$title)
{
   ?>  
   <input  type="button" name="<?php echo $nombre ?>" style="width:<?php echo $ancho ?>"  title="<?php echo $title ?>"  value="<?php echo $valor ?>"  <?php echo "$tipo_accion=" ?>"<?php echo $accion ?>" class="<?php echo $clase; ?>" <?php echo $disabled ?>  >
   
   <?php
}

function f_type_checkbox($nombre,$valor,$tipo_accion,$accion,$descripcion)
{
   if($tipo_accion != '')
   $accion="$tipo_accion=$accion";

   ?>
   <input type="checkbox" name="<?php echo $nombre; ?>" value="<?php echo $valor; ?>" <?php echo $accion ?> title="<?php echo $descripcion ?>"  >
   <?php
}

function f_type_checkbox_evento($nombre,$valor,$tipo_accion,$accion,$tipo_accion2,$accion2)
{
   if($tipo_accion != '')
   $accion="$tipo_accion=$accion";
   
      if($tipo_accion2 != '')
   $accion2="$tipo_accion2=$accion2";

   ?>
   <input type="checkbox" name="<?php echo $nombre; ?>" value="<?php echo $valor; ?>" <?php echo $accion ?>  <?php echo $accion2 ?>   >
   <?php
}

function f_type_checkbox_hidden($nombre,$valor,$tipo_accion,$accion)
{
   if($tipo_accion != '')
   $accion="$tipo_accion=$accion";

   ?>
   <input type="checkbox" name="<?php echo $nombre; ?>" value="<?php echo $valor; ?>" <?php echo $accion ?> class="check_oculto"  >
   <?php
}

function f_trans_begin($conexion)
{
   mysql_query("set autocommit='0'",$conexion);
   mysql_query("BEGIN",$cn);
}

function f_trans_commit($conexion)
{
   mysql_query("commit",$conexion);
   mysql_query("set autocommit='1'",$conexion);
}

function f_trans_rollback($conexion)
{
   mysql_query("rollback",$conexionn);
   mysql_query("set autocommit='1'",$conexion);
}

function f_grupo_inicio($titulo,$ancho)
{
   ?>
   <table align="center" width="<?php echo $ancho ?>">
      <tr >
         <td align="left" height="30px" >
         <div id="grupo_title"><a><span><?php echo $titulo ?></span></a></div>
        <table id="grupo_tb" align="center" border="1" width="100%" >
            <tr>
               <td >
      
   <?php
}


function f_grupo_fin()
{
   ?>
               </td>
            </tr>
         </table>
      </td>
      </tr>
   </table>

   <?php
}


function f_type_combobox_filter($id,$nombre,$rds,$campo_mostrar,$campo_valor,$accion,$disabled,$width,$seleccionado,$tipo_accion,$ver2)
{

   ?>
   

   <script>
   //window.dhx_globalImgPath="http://sistemasiqm.sytes.net/contactosv4/imagenes/";
   window.dhx_globalImgPath="http://localhost/contactosv4_26_jul_10/imagenes/";
		</script>

    
   <?php
   //echo "<script>alert('-->".$seleccionado."<--')</script>";
   $unico=0;  // Sirve para indicar si solo hay un registro
   $lleno=0;  // Lleno nos indica si hay registros

   $registros=mysql_num_rows($rds);
   ?>
   <select style='width:<?php echo $width;?>;'  id="<?php echo $id ?>" name="<?php echo $nombre ?>"  <? echo "$tipo_accion=" ?>"<? echo $accion ?>"  <?php echo $disabled ?> >
   
   <?php 
   if ($registros>0){
      while ($arreglo = mysql_fetch_assoc($rds)){

         $descripcion=$arreglo[$campo_mostrar];
         //  echo	$seleccionado;
         if ($arreglo[$campo_valor]==$seleccionado){
            printf ("<option value=\"%s\" selected='selected'>%s</option>","$arreglo[$campo_valor]",$descripcion);
			//echo "<script>alert('dsdsas".$seleccionado."');</script>";
         }
         else
            printf ("<option value=\"%s\">%s</option>","$arreglo[$campo_valor]",$descripcion);
      }
   }
   ?>
   </select>
       <script> 
       var z=dhtmlXComboFromSelect("<?php echo $id ?>");
       z.enableFilteringMode(true);
      // z.disable(true)
       z.disable(<?php echo $ver2;?>)
       </script>
   <?php 
}



function f_type_combobox_filter_tab($id,$nombre,$rds,$campo_mostrar,$campo_valor,$accion,$disabled,$width,$seleccionado,$tipo_accion,$ver2)
{
?>
   <script>
   window.dhx_globalImgPath="http://sistemasiqm.sytes.net/contactosv5/imagenes/";
		</script>

    
   <?php
   $unico=0;  // Sirve para indicar si solo hay un registro
   $lleno=0;  // Lleno nos indica si hay registros

   $registros=mysql_num_rows($rds);
   ?>
   <select style='width:<?php echo $width;?>;border:double #385D8A;'  id="<?php echo $id ?>" name="<?php echo $nombre ?>"  <?php echo "$tipo_accion=" ?>"<?php echo $accion ?>"  <?php echo $disabled ?> >
   
   <?php 
   if ($registros>0){
      while ($arreglo = mysql_fetch_assoc($rds)){

         $descripcion=$arreglo[$campo_mostrar];
         //  echo	$seleccionado;
         if ($arreglo[$campo_valor]==$seleccionado){
            printf ("<option value=\"%s\" selected>%s</option>",$arreglo[$campo_valor],$descripcion);
         }
         else
            printf ("<option value=\"%s\">%s</option>","$arreglo[$campo_valor]",$descripcion);
      }
   }
   ?>
   </select>

   <?php 
}





function f_type_combobox($nombre,$rds,$default,$campo_mostrar,$campo_valor,$seleccionado,$size,$accion,$disabled,$clase,$width)
{
	//echo "<script>alert('-->".$seleccionado."<--')</script>";
   $unico=0;  // Sirve para indicar si solo hay un registro
   $lleno=0;  // Lleno nos indica si hay registros

   if($clase=='')
   {
     $clase='combobox';
   }
   
   $registros=mysql_num_rows($rds);
   ?>
   <select name="<?php echo $nombre ?>"  <?php echo $accion ?> <?php echo "$disabled" ?> style="border:double;background:#FFFFFF;color:#385D8A;width:<?php echo "$width";?>"
   
   <?php if(isset($size) and $size != '' )
   {
     ?>
      size="<?php echo $size ?>" 
     <?php
   }
   ?>
   class="<?php echo "$clase" ?>"  >
  
   <?php
   if (isset($default))
   {
      if (!isset($seleccionado))
      {
         ?>
         <option value="0" selected><?php echo $default; ?></option>
         <?php
      }
      else
      {
         ?>
         <option value="0"><?php echo $default; ?></option>
         <?php
      }
	  
   }

   if ($registros>0){
      while ($arreglo = mysql_fetch_assoc($rds)){

         $descripcion=$arreglo[$campo_mostrar];
         //echo	$seleccionado;
         if ($arreglo[$campo_valor]==$seleccionado){
            printf ("<option value=\"%s\" selected='selected'>%s</option>",$arreglo[$campo_valor],$descripcion);			
         }
         else{
         printf ("<option value=\"%s\">%s</option>",$arreglo[$campo_valor],$descripcion);
		 //echo "<script>alert('-->".$seleccionado."<--')</script>";
		 }
		 
	}
   }
   ?>
   </select>
   <?php 
}




function f_verifica_sesion(){
         session_name("contacto");
		 session_start();
   		 
		 
		 if (!isset($_SESSION['id_usuario']) || strlen($_SESSION['id_usuario'])==0){
			  session_unset();
			  session_destroy();
			  header("Location: ../contactosv5/index.php");
			  exit();
		 }
}



  		
  		
function f_verifica_sesion_v2(){


  session_name("contacto");
   		session_start();
  if (!isset($_SESSION['id_tipo']) ){
     session_unset();
     session_destroy();
     print_r($_SESSION);
   
     
   	session_start();
  	$_SESSION['id_tipo']=2;
  	header ("Location: ../contactosv5/index.php"); 
  }

}
  	
  


function f_type_calendario($dia,$mes,$year)
{
?>
<script language="javascript" type="text/javascript" src="../javascript/calendario.js"></script>

<script>

var fc_ie = false;
if (document.all) { fc_ie = true; }

var calendars = Array();
var fc_months = Array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiempre', 'Octubre', 'Noviembre', 'Diciembre');
var fc_openCal;

var fc_calCount = 0;

</script>
<input size="4" maxlength="4" id="fc_1212688128_y" name="year" value="<?php echo $year ?>">
<select name="mes" id="fc_1212688128_m" >
			<option value="01" <?php if ($mes==1) echo selected?> >Enero</option>
			<option value="02" <?php if ($mes==2) echo selected?> >Febrero</option>
			<option value="03" <?php if ($mes==3) echo selected?> >Marzo</option>
			<option value="04" <?php if ($mes==4) echo selected?> >Abril</option>
			<option value="05" <?php if ($mes==5) echo selected?> >Mayo</option>
			<option value="06" <?php if ($mes==6) echo selected?> >Junio</option>
			<option value="07" <?php if ($mes==7) echo selected?> >Julio</option>
			<option value="08" <?php if ($mes==8) echo selected?> >Agosto</option>
			<option value="09" <?php if ($mes==9) echo selected?> >Septiembre</option>
			<option value="10" <?php if ($mes==10) echo selected?> >Octubre</option>
			<option value="11" <?php if ($mes==11) echo selected?> >Noviembre</option>
			<option value="12" <?php if ($mes==12) echo selected?> >Diciembre</option>
		</select>
		
		
		
		<input size="2" maxlength="2" id="fc_1212688128_d" name="dia" value="<?php echo $dia ?>">

		<input type="button" value="" class="btn_calendario" onclick="display3FieldCalendar(fc_getObj('fc_1212688128_m'), fc_getObj('fc_1212688128_d'), fc_getObj('fc_1212688128_y'));">

<?php
}

function f_type_fecha($year,$moth,$day,$v_year,$v_moth,$v_day)
{
   $actual = date("Y");
   $actual=$actual-18;
   ?>
   <select name="<?php echo $year ?>" >
   <?php
   
    if($v_year=='')
		{
		   ?>
		   <option value="0" selected>Año</option>
		   <?php
		}
   
   
   $contador = 1 ;
   while ($contador <= 120)
   {
   ?>
   <option value="<?php echo $actual ?>" <?php if ($v_year==$actual) echo selected?> ><?php echo $actual ?></option>
   <?php
   $actual=$actual -1;
   $contador++;
   }

   ?>
			
		
		</select>
		
		<select name="<?php echo $moth ?>"  >
		
		<?php if($v_moth == '')
		{
		   ?>
		   <option value="0" selected>Mes</option>
		   <?php
		}
?>
			<option value="1" <?php if ($v_moth==1) echo selected?> >Enero</option>
			<option value="2" <?php if ($v_moth==2) echo selected?> >Febrero</option>
			<option value="3" <?php if ($v_moth==3) echo selected?> >Marzo</option>
			<option value="4" <?php if ($v_moth==4) echo selected?> >Abril</option>
			<option value="5" <?php if ($v_moth==5) echo selected?> >Mayo</option>
			<option value="6" <?php if ($v_moth==6) echo selected?> >Junio</option>
			<option value="7" <?php if ($v_moth==7) echo selected?> >Julio</option>
			<option value="8" <?php if ($v_moth==8) echo selected?> >Agosto</option>
			<option value="9" <?php if ($v_moth==9) echo selected?> >Septiembre</option>
			<option value="10" <?php if ($v_moth==10) echo selected?> >Octubre</option>
			<option value="11" <?php if ($v_moth==11) echo selected?> >Noviembre</option>
			<option value="12" <?php if ($v_moth==12) echo selected?> >Diciembre</option>
		</select>
		
		<select name="<?php echo $day ?>"  >
		<?php

	 if($v_day=='')
		{
		   ?>
		   <option value="0" selected>Dia</option>
		   <?php
		}
		
		$contador=1;
		while ($contador<=31)
		{
		?>
			<option value="<?php echo $contador ?>" <?php if ($v_day==$contador) echo selected?> ><?php echo $contador ?></option>
			
			<?php
			$contador++;
		}
			?>
		</select>
<?php
}


function f_grupo_inicio_v2($titulo)
{
  ?>
  <table cellpadding="0" cellspacing="0" >
  <tr>
    <td width="40px" height="37" background="../imagenes/grupo/login01.jpg" >    </td>
    <td width="238px" background="../imagenes/grupo/login03.jpg" >
    <div align="center">
      <h5 class="Estilo1"><?php echo $titulo; ?></h5>
    </div></td>
    <td width="40px" height="37" background="../imagenes/grupo/login02.jpg" >    </td>
  </tr>
</table>

<table cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr>
    <td width="9"  background="../imagenes/grupo/login_left.jpg" >    </td>
	<td width="300px">


<?php
}

function f_grupo_fin_v2($titulo)
{
  ?>
  	
	</td>

    <td width="9"  background="../imagenes/grupo/login_right.jpg" >    </td>
  </tr>
</table>


<table cellpadding="0" cellspacing="0" >
  <tr>
    <td width="34px" height="35px" background="../imagenes/grupo/login_d_01.jpg" >    </td>
    <td width="250px" background="../imagenes/grupo/login_d_03.jpg" >
    <div align="center"></div></td>
    <td width="34px" height="35px" background="../imagenes/grupo/login_d_02.jpg" >    </td>
  </tr>
</table>
<?php
}
/*
    Función que retorna la fecha actual como una cadena en formato completo
    y traducida al castellano.
    (c) Carlos Castillo Peralta, 2008
*/

function fechaActualCastellano()
{
    // Obtenemos el nombre del día y lo traducimos
    switch( date("l") )
    {
        case "Monday":
            $nombreDia = "Lunes";
            break;
        case "Tuesday":
            $nombreDia = "Martes";
            break;
        case "Wednesday":
            $nombreDia = "Miércoles";
            break;
        case "Thursday":
            $nombreDia = "Jueves";
            break;
        case "Friday":
            $nombreDia = "Viernes";
            break;
        case "Saturday":
            $nombreDia = "Sábado";
            break;
        case "Sunday":
            $nombreDia = "Domingo";
            break;
    }

    // Obtenemos el numero del día
    $numDia = date("d");

    // Obtenemos y el nombre del mes y lo traducimos
    switch( date("F") )
    {
        case "January":
            $nombreMes = "Enero";
            break;
        case "February":
            $nombreMes = "Febrero";
            break;
        case "March":
            $nombreMes = "Marzo";
            break;
        case "April":
            $nombreMes = "Abril";
            break;
        case "May":
            $nombreMes = "Mayo";
            break;
        case "June":
            $nombreMes = "Junio";
            break;
        case "July":
            $nombreMes = "Julio";
            break;
        case "August":
            $nombreMes = "Agosto";
            break;
        case "September":
            $nombreMes = "Séptiembre";
            break;
        case "October":
            $nombreMes = "Octubre";
            break;
        case "November":
            $nombreMes = "Noviembre";
            break;
        case "December":
            $nombreMes = "Diciembre";
            break;
     }

    // Obtenemos el año
    $anno = date("Y");

    // Armamos la cadena con la fecha completa en castellano
    $fecha = $nombreDia . " " .
             $numDia . " de " .
             $nombreMes . " de " .
             $anno;

    // Retornamos la fecha como una cadena
    return ($fecha);
}






/*Functions added by Alex*/
function optimizar_texto($variable){
$variable = str_replace("&aacute;","á",$variable);
$variable = str_replace("&eacute;","é",$variable);
$variable = str_replace("&iacute;","í",$variable);
$variable = str_replace("&oacute;","ó",$variable);
$variable = str_replace("&uacute;","ú",$variable);
$variable = str_replace("&Aacute;","Á",$variable);
$variable = str_replace("&Eacute;","É",$variable);
$variable = str_replace("&Iacute;","Í",$variable);
$variable = str_replace("&Oacute;","Ó",$variable);
$variable = str_replace("&Uacute;","Ú",$variable);
$variable = str_replace("&ntilde;","ñ",$variable);
$variable = str_replace("&iexcl;","¡",$variable);

return $variable;

} 
function ucfirstHTMLentity($matches){
        return "&".ucfirst(strtolower($matches[1])).";";
    }
 function fullUpper($str){
        $subject = strtoupper(htmlentities($str, null, 'UTF-8'));
        $pattern = '/&([A-Z]+);/';
        return preg_replace_callback($pattern, "ucfirstHTMLentity", $subject);
    }
?>