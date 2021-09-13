<aside class="main-sidebar sidebar-light-primary elevation-3 ">
  <!-- Brand Logo -->

  <a href="inicio.php" class="brand-link">

    <img src="img/logoempresa.jpg" alt="Logo" class="brand-image  elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-bold">CHECA</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex ">
      <div class="image">
        <img src="img/user.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $_SESSION['s_nombre']; ?></a>
        <input type="hidden" id="nameuser" name="nameuser" value="<?php echo $_SESSION['s_nombre']; ?>">
        <input type="hidden" id="fechasys" name="fechasys" value="<?php echo date('Y-m-d') ?>">
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


        <li class="nav-item ">
          <a href="inicio.php" class="nav-link <?php echo ($pagina == 'home') ? "active" : ""; ?> ">
            <i class="nav-icon fas fa-home "></i>
            <p>
              Home
            </p>
          </a>
        </li>
        <li class="nav-item  has-treeview <?php echo ($pagina == 'empresa' ||  $pagina == 'cliente' ||  $pagina == 'obra' ||  $pagina == 'personal') ? "menu-open" : ""; ?>">


          <a href="#" class="nav-link  <?php echo ($pagina == 'empresa' || $pagina == 'cliente' ||  $pagina == 'obra' ||  $pagina == 'personal') ? "active" : ""; ?>">
            <i class="nav-icon fas fa-bars "></i>
            <p>
              Catalogos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>


          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="cntaempresa.php" class="nav-link <?php echo ($pagina == 'empresa') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-city nav-icon"></i>
                <p>Empresa</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntacliente.php" class="nav-link <?php echo ($pagina == 'cliente') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Cliente</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="cntaobra.php" class="nav-link <?php echo ($pagina == 'obra') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-road nav-icon"></i>
                <p>Obra</p>
              </a>
            </li>
            <?php if ($_SESSION['s_rol'] == '2') {?>
            <li class="nav-item">
              <a href="cntaconcepto.php" class="nav-link <?php echo ($pagina == 'concepto') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-layer-group nav-icon"></i>
                <p>Conceptos</p>
              </a>
            </li>
            <?php }?>




          </ul>

        </li>





        <li class="nav-item has-treeview <?php echo ($pagina == 'cntavisitas' || $pagina == 'cntadiario' || $pagina == 'calendario' || $pagina == 'recepcion' || $pagina == 'ingresos' || $pagina == 'diario' || $pagina == 'confirmar') ? "menu-open" : ""; ?>">


          <a href="#" class="nav-link <?php echo ($pagina == 'cntavisitas' || $pagina == 'cntadiario' || $pagina == 'calendario' || $pagina == 'recepcion' || $pagina == 'ingresos' || $pagina == 'diario' || $pagina == 'confirmar') ? "active" : ""; ?>">
            <span class="fa-stack">
              <i class="fas fa-laptop-medical nav-icon"></i>

            </span>
            <p>
              Operaciones
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="calendario.php" class="nav-link <?php echo ($pagina == 'calendario') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-calendar-alt nav-icon"></i>
                <p>Agenda</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="confirmacion.php" class="nav-link <?php echo ($pagina == 'confirmar') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-phone nav-icon"></i>
                <p>Confirmación</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="recepcion.php" class="nav-link <?php echo ($pagina == 'recepcion') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-hospital nav-icon"></i>
                <p>Recepción</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntadiario.php" class="nav-link <?php echo ($pagina == 'cntadiario') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-money-bill-wave nav-icon"></i>
                <p>Registro de Ingresos</p>
              </a>
            </li>
<!--
            <li class="nav-item">
              <a href="cntavisitas.php" class=" nav-link <?php echo ($pagina == 'cntavisitas') ? "active seleccionado" : ""; ?> ">
                <i class=" fas fa-file-invoice nav-icon"></i>
                <p>Reporte de Visitas</p>
              </a>
            </li>
            -->
            <li class="nav-item">
              <a href="cortediario.php" class=" nav-link <?php echo ($pagina == 'diario') ? "active seleccionado" : ""; ?> ">
                <i class=" fas fa-file-invoice-dollar nav-icon"></i>
                <p>Reporte de Caja</p>
              </a>
            </li>

            <?php if ($_SESSION['s_rol'] == '2') {?>
            <li class="nav-item">
              <a href="cntaingresos.php" class=" nav-link <?php echo ($pagina == 'ingresos') ? "active seleccionado" : ""; ?> ">
                <i class=" fas fa-file-invoice nav-icon"></i>
                <p>Reporte de Ingresos</p>
              </a>
            </li>
           

            <?php }?>

          </ul>
        </li>





        <?php if ($_SESSION['s_rol'] == '2') {?>
          <hr class="sidebar-divider">
          <li class="nav-item">
            <a href="cntausuarios.php" class="nav-link <?php echo ($pagina == 'usuarios') ? "active" : ""; ?> ">
              <i class="fas fa-user-shield"></i>
              <p>Usuarios</p>
            </a>
          </li>
        <?php }?>

        <hr class="sidebar-divider">
        <li class="nav-item">
          <a class="nav-link" href="bd/logout.php">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <p>Salir</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
<!-- Main Sidebar Container -->