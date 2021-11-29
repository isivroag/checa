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
        <input type="hidden" id="tipousuario" name="tipousuario" value="<?php echo $_SESSION['s_rol']; ?>">
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

        <?php if ($_SESSION['s_rol'] == '3' || $_SESSION['s_rol'] == '2') { ?>
          <!-- ABRE MENU CATALOGOS -->
          <li class="nav-item  has-treeview <?php echo ($pagina == 'empresa' ||  $pagina == 'cliente' ||  $pagina == 'obra'  ||  $pagina == 'especialidad' ||  $pagina == 'proveedor') ? "menu-open" : ""; ?>">
            <a href="#" class="nav-link  <?php echo ($pagina == 'empresa' || $pagina == 'cliente' ||  $pagina == 'obra'  ||  $pagina == 'especialidad' ||  $pagina == 'proveedor') ? "active" : ""; ?>">
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
                <a href="cntaobra.php" class="nav-link <?php echo ($pagina == 'obra') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-road nav-icon"></i>
                  <p>Obra</p>
                </a>
              </li>




              <li class="nav-item">
                <a href="cntacliente.php" class="nav-link <?php echo ($pagina == 'cliente') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-user-tie nav-icon"></i>
                  <p>Cliente</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="cntaproveedor.php" class="nav-link <?php echo ($pagina == 'proveedor') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-portrait nav-icon"></i>
                  <p>Proveedor</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntaespecialidad.php" class="nav-link <?php echo ($pagina == 'especialidad') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-screwdriver nav-icon"></i>
                  <p>Especialidad</p>
                </a>
              </li>



            </ul>

          </li>
        <?php } ?>
        <!-- CIERRA MENU CATALOGOS -->


        <!-- ABRE MENU INGRESOS -->
        <li class="nav-item has-treeview <?php echo ($pagina == 'cntaingresos' || $pagina == 'ingresos' || $pagina == 'cntacxc' || $pagina == 'recepcion' || $pagina == 'ingresos' || $pagina == 'diario' || $pagina == 'confirmar') ? "menu-open" : ""; ?>">


          <a href="#" class="nav-link <?php echo ($pagina == 'cntaingresos' || $pagina == 'ingresos' || $pagina == 'cntacxc' || $pagina == 'recepcion' || $pagina == 'ingresos' || $pagina == 'diario' || $pagina == 'confirmar') ? "active" : ""; ?>">

            <span class="fa-stack">
              <i class=" fas fa-arrow-up "></i>
              <i class=" fas fa-dollar-sign "></i>

            </span>
            <p>
              Ingresos

              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <!--
            <li class="nav-item">
              <a href="ingresos.php" class="nav-link <?php echo ($pagina == 'ingresos') ? "active seleccionado" : ""; ?>  ">

                <i class=" text-green fas fa-file-invoice-dollar nav-icon"></i>
                <p>Registro de Facturas</p>
              </a>
            </li>
          -->

            <li class="nav-item">
              <a href="cntacxc.php" class="nav-link <?php echo ($pagina == 'cntacxc') ? "active seleccionado" : ""; ?>  ">

                <i class="fas text-green fa-list nav-icon"></i>
                <p>Cuentas x Cobrar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="cntaingresos.php" class="nav-link <?php echo ($pagina == 'cntaingresos') ? "active seleccionado" : ""; ?>  ">

                <i class="fas text-green fa-search-dollar nav-icon"></i>
                <p>Consulta Ingresos</p>
              </a>
            </li>


          </ul>
        </li>
        <!-- CIERRA MENU CATALOGOS -->

        <!-- ABRE MENU EGRESOS -->
        <li class="nav-item has-treeview <?php echo ($pagina == 'subcontrato' || $pagina == 'cntaegresos' || $pagina == 'egresos' || $pagina == 'cntacxp' || $pagina == 'cntapagocxp' || $pagina == 'pagoscxp' || $pagina == 'provision'  || $pagina == 'saldoseg' || $pagina == 'gastos') ? "menu-open" : ""; ?>">


          <a href="#" class="nav-link <?php echo ($pagina == 'subcontrato' || $pagina == 'cntaegresos' || $pagina == 'egresos' || $pagina == 'cntacxp' || $pagina == 'cntapagocxp' || $pagina == 'pagoscxp' || $pagina == 'provision'  || $pagina == 'saldoseg' || $pagina == 'gastos') ? "active" : ""; ?>">

            <span class="fa-stack">
              <i class=" fas fa-arrow-down "></i>
              <i class=" fas fa-dollar-sign "></i>

            </span>
            <p>
              Egresos

              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="cntasubcontrato.php" class="nav-link <?php echo ($pagina == 'subcontrato') ? "active seleccionado" : ""; ?>  ">

                <i class="fas text-purple fa-industry nav-icon"></i>
                <p>Subcontratos</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntacxp.php" class="nav-link <?php echo ($pagina == 'cntacxp') ? "active seleccionado" : ""; ?>  ">

                <i class="fas text-purple fa-pen-square nav-icon"></i>
                <p>Cuentas x Pagar</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntaprovision.php" class="nav-link <?php echo ($pagina == 'provision') ? "active seleccionado" : ""; ?>  ">

                <i class="fas text-purple fa-list nav-icon"></i>
                <p>Provisiones</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntagastos.php" class="nav-link <?php echo ($pagina == 'gastos') ? "active seleccionado" : ""; ?>  ">

                <i class="fas text-purple fa-money-bill-wave nav-icon"></i>
                <p>Otros Gastos</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntaegresos.php" class="nav-link <?php echo ($pagina == 'cntapagocxp') ? "active seleccionado" : ""; ?>  ">

                <i class="fas text-purple fa-search-dollar nav-icon"></i>
                <p>Consulta Egresos </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntapagocxp.php" class="nav-link <?php echo ($pagina == 'pagoscxp') ? "active seleccionado" : ""; ?>  ">

                <i class="fas text-purple fa-file-invoice-dollar nav-icon"></i>
                <p>Rpt Pago a Proveedores </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntasaldoseg.php" class="nav-link <?php echo ($pagina == 'saldoseg') ? "active seleccionado" : ""; ?>  ">

                <i class="fas text-purple fa-coins nav-icon"></i>
                <p>Saldos Pendientes </p>
              </a>
            </li>

          </ul>
        </li>
        <!-- CIERRA MENU EGRESOS -->


        <!-- ABRE MENU OPERACIONES -->
        <li class="nav-item has-treeview <?php echo ($pagina == 'nomina' || $pagina == 'otro' || $pagina == 'proveedorobra' || $pagina == 'cajaobra') ? "menu-open" : ""; ?>">


          <a href="#" class="nav-link <?php echo ($pagina == 'nomina' || $pagina == 'otro' || $pagina == 'proveedorobra' || $pagina == 'cajaobra') ? "active" : ""; ?>">

            <span class="fa-stack">

              <i class=" fas fa-briefcase nav-icon "></i>

            </span>
            <p>
              Operaciones

              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="cntacajaobra.php" class="nav-link <?php echo ($pagina == 'cajaobra') ? "active seleccionado" : ""; ?>  ">

                <i class=" fas fa-briefcase nav-icon"></i>
                <p>Caja</p>
              </a>
            </li>



          </ul>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="cntaproveedorobra.php" class="nav-link <?php echo ($pagina == 'proveedorobra') ? "active seleccionado" : ""; ?>  ">

                <i class=" fas fa-portrait nav-icon"></i>
                <p>Proveedores</p>
              </a>
            </li>



          </ul>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="cntanomina.php" class="nav-link <?php echo ($pagina == 'nomina') ? "active seleccionado" : ""; ?>  ">

                <i class="fas  fa-people-arrows nav-icon"></i>
                <p>Nominas</p>
              </a>
            </li>



          </ul>

          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="cntaotrosgastos.php" class="nav-link <?php echo ($pagina == 'otro') ? "active seleccionado" : ""; ?>  ">

                <i class="fas  fa-money-bill-wave nav-icon"></i>
                <p>Gastos de Obra</p>
              </a>
            </li>



          </ul>
        </li>
        <!-- CIERRA MENU OPERACIONES -->

        <!-- ABRE MENU REPORTES -->
        <?php if ($_SESSION['s_rol'] == '3' || $_SESSION['s_rol'] == '2') { ?>
          <li class="nav-item has-treeview <?php echo ($pagina == 'caja') ? "menu-open" : ""; ?>">


            <a href="#" class="nav-link <?php echo ($pagina == 'caja') ? "active" : ""; ?>">

              <span class="fa-stack">
                <i class="nav-icon fas fa-shield-alt "></i>
              </span>
              <p>
                Control
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="cntacaja.php" class="nav-link <?php echo ($pagina == 'caja') ? "active seleccionado" : ""; ?>  ">

                  <i class="fas fa-briefcase   nav-icon"></i>
                  <p>Caja</p>
                </a>
              </li>




            </ul>
          </li>


          <li class="nav-item has-treeview <?php echo ($pagina == 'rptobra') ? "menu-open" : ""; ?>">


            <a href="#" class="nav-link <?php echo ($pagina == 'rptobra') ? "active" : ""; ?>">

              <span class="fa-stack">
                <i class="nav-icon fas fa-file-contract "></i>
              </span>
              <p>
                Reportes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="rptobra.php" class="nav-link <?php echo ($pagina == 'rptobra') ? "active seleccionado" : ""; ?>  ">

                  <i class="fas text-primary fa-building nav-icon"></i>
                  <p>Obra</p>
                </a>
              </li>




            </ul>
          </li>
        <?php } ?>
        <!-- CIERRA MENU EGRESOS -->



        <?php if ($_SESSION['s_rol'] == '3') { ?>
          <hr class="sidebar-divider">
          <li class="nav-item">
            <a href="cntausuarios.php" class="nav-link <?php echo ($pagina == 'usuarios') ? "active" : ""; ?> ">
              <i class="fas fa-user-shield"></i>
              <p>Usuarios</p>
            </a>
          </li>
        <?php } ?>

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