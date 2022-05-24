<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <button style="border: white;" class="navbar-toggle" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
      <span class="material-icons">list</span>
    </button> 
        <span>
          <?php echo $_SESSION["nombreUsuario"]?>
        </span>               
    </div>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span>
          <?php echo $_SESSION["nombreUsuario"] ?>
        </span>  
            <i class="material-icons">person</i>
            <p class="d-lg-none d-md-block">
              Account
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
            <a class="dropdown-item"  href="../../Modulos/perfil/index.php">Perfil</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../../Modulos/login/Search/logoff.php"> <?php echo traducir('Salir'); ?> </a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
