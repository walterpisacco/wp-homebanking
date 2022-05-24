    <div class="sidebar" data-color="rose" data-background-color="black" data-image="../../img/sidebar-1.jpg">
      <div class="logo">
        <img src="../../img/logo-small.png" alt="">
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="../../img/faces/avatar.jpg" />
          </div>
          <div class="user-info">

            <a data-toggle="collapse" href="#collapseExample" class="username">
              <div>
              <span>
               <?php echo $_SESSION["nombreUsuario"]?>
              </span>
            </div>
            </a>
            <div class="collapse" id="collapseExample">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="../../Modulos/perfil/index.php">
                    <span class="sidebar-mini"> MP </span>
                    <span class="sidebar-normal"> Mi Perfil </span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <ul class="nav">
          <li class="nav-item active ">
            <a class="nav-link" href="../../Modulos/panel/index.php">
              <i class="material-icons"  style="color: black;">dashboard</i>
              <p> <?php echo traducir('Panel de Control'); ?> </p>
            </a>
          </li>
          <li class="nav-item active ">
            <a class="nav-link" href="../../Modulos/mapa/index.php">
              <i class="material-icons" style="color: black;">Mapa</i>
              <p> <?php echo traducir('Mapa de Distribución'); ?> </p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="../../Modulos/mensajes/index.php">
              <i class="material-icons">alarm_add</i>
              <span class="sidebar-normal"> <?php echo traducir('Mensajes'); ?> </span>
            </a>
          </li>
          <li class="nav-item ">          
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="../../Modulos/movimientos/index.php">
                    <i class="material-icons">sync_alt</i>
                    <span class="sidebar-normal"> <?php echo traducir('Movimientos'); ?> </span>
                  </a>
                </li>
              </ul>
          </li> 
<?php  if(BuscarPerfil(1)){//1 Super Administrador ?>                    
          <li class="nav-item ">          
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="../../Modulos/clientes/index.php">
                    <i class="material-icons">face</i>
                    <span class="sidebar-normal"> <?php echo traducir('Clientes'); ?> </span>
                  </a>
                </li>
              </ul>
          </li>
<?php } ?>
<?php  if(BuscarPerfil('1,2')){//1 Super Administrador, 2 Administrador Local ?> 
          <li class="nav-item ">          
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="../../Modulos/equipos/index.php">
                    <i class="material-icons">local_atm</i>
                    <span class="sidebar-normal"> <?php echo traducir('Máquinas'); ?> </span>
                  </a>
                </li>
              </ul>
          </li> 
<?php } ?>  
<?php  if(BuscarPerfil('1,2')){//1 Super Administrador, 2 Administrador Local ?>   
          <li class="nav-item ">
            <a class="nav-link" href="../../Modulos/personas/personas.php">
              <i class="material-icons">face</i>
              <span class="sidebar-normal"> <?php echo traducir('Usuarios'); ?> </span>
            </a>
          </li>
<?php } ?> 
          <li class="nav-item ">          
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="../../Modulos/login/Search/logoff.php">
                    <i class="material-icons">desktop_access_disabled</i>
                    <span class="sidebar-normal"> <?php echo traducir('Salir'); ?> </span>
                  </a>
                </li>
              </ul>
          </li>         
        </ul>
<?php include '../../Modulos/diccionario/idiomas.php'?>;        
      </div>
    </div>