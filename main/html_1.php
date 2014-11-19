
     
<!--////////////////////////////////   GRUPO 1  //////////////////////////////////////////-->
<div id='grup1'>
<table width="100%" border="0">
<tr>     
	<th>GRUPO:</th>
	<td>
			<?php 
			$sqlgrup1=mysql_query("select id_grup,d_grupo from cat_grupos order by d_grupo ASC",$cn);
			f_type_combobox('id_grupo1',$sqlgrup1,'','d_grupo','id_grup','','','','','','430px');
			?>
	</td>
</tr>
<tr> 
	<th>DEPENDENCIA PRINCIPAL:</th>
	<td>
		    <?php
			$con1=mysql_query('select d_dependencia from cat_dependencias order by d_dependencia ASC',$cn);
			f_type_combobox_filter('combo_zone9','id_dependencia1',$con1,'d_dependencia','d_dependencia','','','430','','','');
			?>
	</td>
	<th>TITULAR:</th>
</tr>
<tr> 
	<th>* CARGO:</td>
	<td> 
		<input type="Text" class="texto" name="id_cargo1" style="width:430px;" style="text-transform:uppercase" value="<?php if ($_GET['operacion']==3){ echo $aa["trabajo_cargo"];}?>" <?php echo $ver;?> >
	</td>
	<td>
			<?php
			$sqltit1=mysql_query('select * from cat_titular',$cn);
			f_type_combobox('id_titular1',$sqltit1,'','titular','id','','','','','','');
			?>			
	</td>
</tr>
</table>
</div>

<!--////////////////////////////////   GRUPO 2  //////////////////////////////////////////-->
<div id='grup2' >
<table width="100%" border="0">
<tr>     
	<th>GRUPO:</th>
	<td>
			<?php 
			$sqlgrup2=mysql_query("select * from cat_grupos order by d_grupo ASC",$cn);
			f_type_combobox('id_grupo2',$sqlgrup2,'','d_grupo','id_grup','','','','','','430px');
			?>
	</td>
</tr>
<tr> 
	<th>DEPENDENCIA:</th>
	<td>
		    <?php
			$con2=mysql_query('select d_dependencia from cat_dependencias order by d_dependencia ASC',$cn);
			f_type_combobox_filter('combo_zone10','id_dependencia2',$con2,'d_dependencia','d_dependencia','','','430','','','');
			?>
	</td>
	<th>TITULAR:</th>
</tr>
<tr> 
	<th>* CARGO:</td>
	<td> 
		<input type="Text" class="texto" name="id_cargo2" style="width:430px;" style="text-transform:uppercase" value="<?php if ($_GET['operacion']==3){ echo $aa["trabajo_cargo"];}?>" <?php echo $ver;?> >
	</td>
	<td>
			<?php
			$rdsquery1=mysql_query('select * from cat_titular',$cn);
			f_type_combobox('id_titular2',$rdsquery1,'','titular','id','','','','','','');
			?>			
	</td>
</tr>
</table>
</div>

<!--////////////////////////////////   GRUPO 3  //////////////////////////////////////////-->
<div id='grup3' >
<table width="100%" border="0">
<tr>     
	<th>GRUPO:</th>
	<td>
			<?php 
			$sqlgrup3=mysql_query("select * from cat_grupos order by d_grupo ASC",$cn);
			f_type_combobox('id_grupo3',$sqlgrup3,'','d_grupo','id_grup','','','','','','430px');
			?>
	</td>
</tr>
<tr> 
	<th>DEPENDENCIA:</th>
	<td>
		    <?php
			$con3=mysql_query('select d_dependencia from cat_dependencias order by d_dependencia ASC',$cn);
			f_type_combobox_filter('combo_zone11','id_dependencia3',$con3,'d_dependencia','d_dependencia','','','430','','','');
			?>
	</td>
	<th>TITULAR:</th>
</tr>
<tr> 
	<th>* CARGO:</td>
	<td> 
		<input type="Text" class="texto" name="id_cargo3" style="width:430px;" style="text-transform:uppercase" value="<?php if ($_GET['operacion']==3){ echo $aa["trabajo_cargo"];}?>" <?php echo $ver;?> >
	</td>
	<td>
			<?php
			$rdsquery1=mysql_query('select * from cat_titular',$cn);
			f_type_combobox('id_titular3',$rdsquery1,'','titular','id','','','','','','');
			?>			
	</td>
</tr>
</table>
</div>

<!--////////////////////////////////   GRUPO 4  //////////////////////////////////////////-->
<div id='grup4' >
<table width="100%" border="0">
<tr>     
	<th>GRUPO:</th>
	<td>
			<?php 
			$sqlgrup4=mysql_query("select * from cat_grupos order by d_grupo ASC",$cn);
			f_type_combobox('id_grupo4',$sqlgrup4,'','d_grupo','id_grup','','','','','','430px');
			?>
	</td>
</tr>
<tr> 
	<th>DEPENDENCIA:</th>
	<td>
			<?php
			$con4=mysql_query('select d_dependencia from cat_dependencias order by d_dependencia ASC',$cn);
			f_type_combobox_filter('combo_zone12','id_dependencia4',$con4,'d_dependencia','d_dependencia','','','430','','','');
			?>
	</td>
	<th>TITULAR:</th>
</tr>
<tr> 
	<th>* CARGO:</td>
	<td> 
		<input type="Text" class="texto" name="id_cargo4" style="width:430px;" style="text-transform:uppercase" value="<?php if ($_GET['operacion']==3){ echo $aa["trabajo_cargo"];}?>" <?php echo $ver;?> >
	</td>
	<td>
			<?php
			$rdsquery1=mysql_query('select * from cat_titular',$cn);
			f_type_combobox('id_titular4',$rdsquery1,'','titular','id','','','','','','');
			?>			
	</td>
</tr>
</table> 
</div>

<!--////////////////////////////////////////////////////////////////////////////////////////////////////////-->

<fieldset>
<table width="100%" border="0">
    <tr> 
	      <th>* TITULO: </th>
		  <td>
		  <table width="100%">
		  <tr>
				<td>
				<?php
				$rdsquery1=mysql_query('select d_titulos from cat_titulos order by d_titulos ASC',$cn);
				f_type_combobox('id_titulo',$rdsquery1,'','d_titulos','d_titulos','','','','','','');
				?>
				</td>
				<th>* SEXO:</th>
		      	<td> 
		        	<select name="id_sexo">
		        	<option selected></option>
		        	<option>H</option>
		        	<option>M</option>
		        	</select>
				</td>
		  </tr>		  
		  </table>  
	      </td>
    </tr>
    <tr> 
	      	<th>* NOMBRE: </th>
	      	<td>
	      	<table width="100%">
	      	<tr>
		      	<td><input type="Text" name="id_nombre" size="30" style="text-transform:uppercase"></td>
				<td><input onkeypress="validador();" onKeyDown="validador();" type="Text" name="id_paterno" size="30" style="text-transform:uppercase"></td>
				<td><input type="Text"  class="texto" name="id_materno" size="30" style="text-transform:uppercase" ></td>
			</tr>
	      	</table>
	      	
	      	</td>
	     	
    </tr>
    <div id="validador"></div>
    <tr> 
			<td>&nbsp;</td>
			<td>
			<table width="100%">
	      	<tr>
		      	<td width="178px" align="center">Nombre(s)</td>
				<td width="178px" align="center">Apellido Paterno</td>
				<td width="178px" align="center">Apellido Materno</td>
			</tr>
	      	</table>
			</td>
			
    </tr>
    <tr>
    	<th>FECHA DE CUMPLEAÑOS:</th>
      <td>
        <select name="id_dia" style="width:50px">
        <option></option>
			<?php 
			for($i=1;$i<=31;$i++)
			    {
			    	if( ((int) substr($aa['personal_bday'],0,2)) == $i )
			    	{
			           if($i<10)	
					   	    echo '<OPTION  selected="selected">0'.$i;   
					   	else 
					   	    echo '<OPTION  selected="selected">'.$i;   
			    	}   	    
					else   	
					{
					   	if($i<10)
					   	    echo '<OPTION>0'.$i;   
					   	else 
					   	    echo '<OPTION>'.$i;   
					}  	    
			    }
			 
			?>
        </select>
        <?php
							$conexion_mes=mysql_query('select d_mes from cat_meses',$cn);
							f_type_combobox('id_mes',$conexion_mes,'-','d_mes','d_mes',$id_bmonth,'','',$ver,'','150px');
		?> 
      </td>
    </tr>
    <tr> 
				<th>TELEFONO DE CASA:</th>
				<td>
					<table width="100%">
					<tr>
						<td><input type="Text" name="id_casa" size="23" maxlength="15"></td>
						<th>CELULAR:</th>
						<td><input type='text' name="id_celular" size="23" maxlength="15"></td>
					</tr>
					</table>
				
				</td>
    </tr>
  
    <tr> 
		      	<th>@ PERSONAL: </th>
				<td><input type="Text" name="id_email" size="50" style="text-transform:lowercase"></td>
    </tr>
    <tr>
				<th>ANIVERSARIO DE BODAS</th>  
				<td>
					<select name="id_diaboda" style="width:50px">
        			<option></option>
					<?php 
					for($i=1;$i<=31;$i++)
			    	{
				    	if( ((int) substr($aa['personal_bday'],0,2)) == $i )
				    	{
				           if($i<10)	
						   	    echo '<OPTION  selected="selected">0'.$i;   
						   	else 
						   	    echo '<OPTION  selected="selected">'.$i;   
				    	}   	    
						else   	
						{
						   	if($i<10)
						   	    echo '<OPTION>0'.$i;   
						   	else 
						   	    echo '<OPTION>'.$i;   
						}  	    
			   		}
					?>
       				</select>
        			<?php
							$conexion_mes=mysql_query('select d_mes from cat_meses',$cn);
							f_type_combobox('id_mesboda',$conexion_mes,'-','d_mes','d_mes',$id_bmonth,'','',$ver,'','150px');
					?>
    </tr>
    <tr>
				<th>NOMBRE DE LA ESPOSA(O)</th>  
				<td><input type="text" name="id_esposa" size="50" style="text-transform:uppercase"></td>
    </tr>
    <tr>
				<th>FECHA DE CUMPLEAÑOS</th>  
				<td>
					<select name="id_diaesposa" style="width:50px">
        			<option></option>
					<?php 
					for($i=1;$i<=31;$i++)
			    	{
				    	if( ((int) substr($aa['personal_bday'],0,2)) == $i )
				    	{
				           if($i<10)	
						   	    echo '<OPTION  selected="selected">0'.$i;   
						   	else 
						   	    echo '<OPTION  selected="selected">'.$i;   
				    	}   	    
						else   	
						{
						   	if($i<10)
						   	    echo '<OPTION>0'.$i;   
						   	else 
						   	    echo '<OPTION>'.$i;   
						}  	    
			   		}
					?>
       				</select>
        			<?php
							$conexion_mes=mysql_query('select d_mes from cat_meses',$cn);
							f_type_combobox('id_mesesposa',$conexion_mes,'-','d_mes','d_mes',$id_bmonth,'','',$ver,'','150px');
					?> 
				</td>
    </tr>

<tr><td><div id="b_tabbar" style="width:100%; height:128px;"/></td></tr>
</table>
</fieldset> 
    

<script>
	
var tabbar1 = new dhtmlXTabBar("b_tabbar");
	tabbar1.setSkin('dark_blue');
	tabbar1.setImagePath("../codebase/imgs/");
	tabbar1.addTab("b1", "Grupo Principal", "130px");
	tabbar1.addTab("b2", "Grupo 2", "100px");
	tabbar1.addTab("b3", "Grupo 3", "100px");
	tabbar1.addTab("b4", "Grupo 4", "100px");
	tabbar1.setContent("b1", "grup1");
	tabbar1.setContent("b2", "grup2");
	tabbar1.setContent("b3", "grup3");
	tabbar1.setContent("b4", "grup4");
	tabbar1.setTabActive("b1");
</script>