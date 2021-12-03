<?php
$pagina = "obra";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM vobra WHERE estado_obra=1 ORDER BY id_obra";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

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
        <h1 class="card-title mx-auto">OBRAS, PROYECTOS Y CENTROS DE COSTO</h1>
      </div>

      <div class="card-body">

        <div class="row">
          <div class="col-lg-12">
            <button id="btnNuevo" type="button" class="btn bg-gradient-green btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
          </div>
        </div>
        <br>
        <div class="container-fluid">

          <div class="row">
            <div class="col-lg-12">
              <div class="table-responsive">
                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed w-auto mx-auto" style="width:100%">
                  <thead class="text-center bg-gradient-green">
                    <tr>
                      <th>ID</th>
                      <th>CLAVE</th>
                      <th>NOMBRE CORTO</th>
                      <th>NOMBRE LARGO</th>
                      <th>FECHA INICIO</th>
                      
                      <th>ID EMP</th>
                      <th>EMPRESA RESPONSABLE</th>
                      <th>ID CLIE</th>
                      <th>CLIENTE</th>
                      <th>IMPORTE CONTRATO</th>
                      <th>INCREMENTOS</th>
                      <th>DECREMENTOS</th>
                      <th>IMPORTE</th>
                      <th>ACCIONES</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($data as $dat) {
                    ?>
                      <tr>
                        <td><?php echo $dat['id_obra'] ?></td>
                        <td><?php echo $dat['clave_obra'] ?></td>
                        <td><?php echo $dat['corto_obra'] ?></td>
                        <td><?php echo $dat['largo_obra'] ?></td>
                        <td><?php echo $dat['inicio_obra'] ?></td>
                      
                        <td><?php echo $dat['id_emp'] ?></td>
                        <td><?php echo $dat['razon_emp'] ?></td>
                        <td><?php echo $dat['id_clie'] ?></td>
                        <td><?php echo $dat['razon_clie'] ?></td>
                        <td class="text-right"><?php echo number_format($dat['importe_origen'] )?></td>
                        <td class="text-right"><?php echo number_format($dat['add_obra'] )?></td>
                        <td class="text-right"><?php echo number_format($dat['dec_obra'] )?></td>
                        <td class="text-right"><?php echo number_format($dat['monto_obra'] )?></td>
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



  <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaobra.js?v=<?php echo(rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>