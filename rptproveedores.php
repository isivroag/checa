<?php
$pagina = "rptproveedores";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM w_proveedor WHERE estado_prov=1 ORDER BY id_prov";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$consultaesp = "SELECT * FROM especialidad WHERE estado_especialidad=1 ORDER BY nom_especialidad";
$resultadoesp = $conexion->prepare($consultaesp);
$resultadoesp->execute();
$dataesp = $resultadoesp->fetchAll(PDO::FETCH_ASSOC);

$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->


  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header bg-gradient-green text-light">
        <h1 class="card-title mx-auto">PROVEEDORES</h1>
      </div>

      <div class="card-body">

       
        <div class="container-fluid">

          <div class="row">
            <div class="col-lg-12">
              <div class="table-responsive">
                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                  <thead class="text-center bg-gradient-green">
                    <tr>
                      <th>ID</th>
                      <th>RFC</th>
                      <th>RAZON SOCIAL</th>
                      <th>DIRECCION</th>
                      <th>TEL</th>
                      <th>CONTACTO</th>
                      <th>TEL CONTACTO</th>
                      <th>ESPECIALIDAD</th>
                      <th>ACCIONES</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($data as $dat) {
                    ?>
                      <tr>
                        <td><?php echo $dat['id_prov'] ?></td>
                        <td><?php echo $dat['rfc_prov'] ?></td>
                        <td><?php echo $dat['razon_prov'] ?></td>
                        <td><?php echo $dat['dir_prov'] ?></td>
                        <td><?php echo $dat['tel_prov'] ?></td>
                        <td><?php echo $dat['contacto_prov'] ?></td>
                        <td><?php echo $dat['telcon_prov'] ?></td>
                        <td><?php echo $dat['especialidad'] ?></td>

                        <td></td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
      <!-- /.card-body -->

      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>



  <!-- TABLA CUENTAS -->
  <section>
    <div class="container">


      <!-- Default box -->
      <div class="modal fade" id="modalCuentas" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-md" role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-green">
              <h5 class="modal-title" id="exampleModalLabel">Resumen de Cuentas de Proveedor</h5>

            </div>
            <br>
            <div class="table-hover responsive w-auto " style="padding:10px">
              <table name="tablaCuentas" id="tablaCuentas" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                <thead class="text-center bg-gradient-green">
                  <tr>
                    <th>ID</th>
                    <th>ID PROV</th>
                    <th>BANCO</th>
                    <th>CUENTA</th>
                    <th>CLABE</th>
                    <th>TARJETA</th>
                    <th>PREDETERMINADA</th>
                  
                  </tr>
                </thead>
                <tbody>

                </tbody>

              </table>
            </div>


          </div>

        </div>
        <!-- /.card-body -->

        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </div>
  </section>


  <!-- /.content -->
</div>






<?php include_once 'templates/footer.php'; ?>
<script src="fjs/rptproveedores.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="http://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>