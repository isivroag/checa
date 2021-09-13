<?php
$pagina = "cliente";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM w_cliente WHERE estado_clie=1 ORDER BY id_clie";
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
        <h1 class="card-title mx-auto">CLIENTES</h1>
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
                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                  <thead class="text-center bg-gradient-green">
                    <tr>
                      <th>ID</th>
                      <th>RFC</th>
                      <th>RAZON SOCIAL</th>
                      <th>DIRECCION</th>
                      <th>TEL</th>
                      <th>ACCIONES</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($data as $dat) {
                    ?>
                      <tr>
                        <td><?php echo $dat['id_clie'] ?></td>
                        <td><?php echo $dat['rfc_clie'] ?></td>
                        <td><?php echo $dat['razon_clie'] ?></td>
                        <td><?php echo $dat['dir_clie'] ?></td>
                        <td><?php echo $dat['tel_clie'] ?></td>
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


  <section>
    <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-green">
            <h5 class="modal-title" id="exampleModalLabel">NUEVO CLIENTE</h5>

          </div>
          <div class="card card-widget" style="margin: 10px;">
            <form id="formDatos" action="" method="POST">
              <div class="modal-body row">

              <div class="col-sm-3">
                  <div class="form-group input-group-sm">
                    <label for="rfc" class="col-form-label">RFC:</label>
                    <input type="text" class="form-control" name="rfc" id="rfc" autocomplete="off" placeholder="RFC">
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="razon" class="col-form-label">RAZON SOCIAL:</label>
                    <input type="text" class="form-control" name="razon" id="razon" autocomplete="off" placeholder="RAZON SOCIAL">
                  </div>
                </div>

              
           
                

                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="dir" class="col-form-label">DIRECCION:</label>
                    <textarea rows="2" type="text" class="form-control" name="dir" id="dir" autocomplete="off" placeholder="DIRECCION"></textarea>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group input-group-sm">
                    <label for="tel" class="col-form-label">TELEFONO:</label>
                    <input type="text" class="form-control" name="tel" id="tel" autocomplete="off" placeholder="TELEFONO DE CONTACTO">
               
                  </div>
                </div>

                


              </div>
          </div>


          <?php
          if ($message != "") {
          ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <span class="badge "><?php echo ($message); ?></span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>

            </div>

          <?php
          }
          ?>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
            <button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntacliente.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>