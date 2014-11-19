   
      <div class="menu" id="tb-menu">
        <ul>
          <li>
            <table class="table">
              <tr><td><a href="<?=$path;?>contactos/add.php"><span>AGREGAR<br>CONTACTOS</span></a> </td></tr>
            </table>
          </li>
          <li>
            <table class="table">
              <tr><td><a href="<?=$path;?>modificar.php">MODIFICAR </a></td></tr>
            </table>
          </li>
          <li>
            <table class="table">
              <tr><td><a href="#" onClick="javascript:w_imrpimir();">REPORTES</a></td></tr>
            </table>
          </li>
		  <?php if($tipousuario=="Administrador"){?>
          <li>
            <table class="table">
              <tr><td><a href="#" onClick="javascript:panel();" style="cursor:hand;">PANEL<br />DE USUARIOS</a></td></tr>
            </table>
          </li>
		  <?php }	?>
          <li>
            <table class="table">
              <tr><td><a href="#" onClick="javascript:catalogo();">CATALOGOS </a></td></tr>
            </table>
          </li>
          <li>
            <table class="table">
              <tr><td><a href="<?=$path;?>inicio.php" style="color:yellow;">INICIO </a></td></tr>
            </table>
          </li>
        </ul>
      </div>