<?php
$pagina = "cntadiario";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$fecha = date('Y-m-d');
$conexion = $objeto->connect();
if ($_SESSION['s_rol'] == '2') {
  $consulta = "SELECT * FROM v_registro WHERE estado_reg = 1 ORDER BY folio_reg";
}else{
  $consulta = "SELECT * FROM v_registro WHERE estado_reg = 1 and saldo_reg>0 ORDER BY folio_reg";
}
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
        <h1 class="card-title mx-auto">Registros</h1>
      </div>

      <div class="card-body">
      <?php if ($_SESSION['s_rol'] == '2') {?>
        <div class="card">
          <div class="card-header bg-gradient-green">
            Filtro por rango de Fecha
          </div>
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col-lg-2">
                <div class="form-group input-group-sm">
                  <label for="fecha" class="col-form-label">Desde:</label>
                  <input type="date" class="form-control" name="inicio" id="inicio">
                  <input type="hidden" class="form-control" name="tipo_proy" id="tipo_proy" value=1>

                </div>
              </div>

              <div class="col-lg-2">
                <div class="form-group input-group-sm">
                  <label for="fecha" class="col-form-label">Hasta:</label>
                  <input type="date" class="form-control" name="final" id="final">
                </div>
              </div>

              <div class="col-lg-1 align-self-end text-center">
                <div class="form-group input-group-sm">
                  <button id="btnBuscar" name="btnBuscar" type="button" class="btn bg-gradient-success btn-ms"><i class="fas fa-search"></i> Buscar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php }?>
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
                      <th>Folio</th>
                      <th>Fecha Rg</th>
                      <th>Id PX</th>
                      <th>PX</th>
                      <th>Id Concepto</th>
                      <th>Concepto</th>
                      <th>Total</th>
                      <th>Saldo</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($data as $dat) {
                    ?>
                      <tr>
                        <td><?php echo $dat['folio_reg'] ?></td>
                        <td><?php echo $dat['fecha_reg'] ?></td>
                        <td><?php echo $dat['id_px'] ?></td>
                        <td><?php echo $dat['nom'] ?></td>
                        <td><?php echo $dat['id_concepto'] ?></td>
                        <td><?php echo $dat['nom_concepto'] ?></td>
                        <td><?php echo $dat['total_reg'] ?></td>
                        <td><?php echo $dat['saldo_reg'] ?></td>
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
    <div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-green">
            <h5 class="modal-title" id="exampleModalLabel">Pagos</h5>

          </div>
          <form id="formPago" action="" method="POST">
            <div class="modal-body">
              <div class="row justify-content-sm-between my-auto">



                <div class="col-sm-3 my-auto">
                  <div class="form-group input-group-sm">
                    <label for="foliop" class="col-form-label">Folio Registro:</label>
                    <input type="text" class="form-control" name="foliop" id="foliop" disabled>
                  </div>
                </div>




                <div class="col-sm-3 my-auto">
                  <div class="form-group input-group-sm">
                    <label for="fechap" class="col-form-label ">Fecha de Pago:</label>
                    <input type="date" id="fechap" name="fechap" class="form-control text-right" autocomplete="off" value="<?php echo date("Y-m-d") ?>" placeholder="Fecha">
                  </div>
                </div>

              </div>

              <div class="row">

              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="conceptop" class="col-form-label">Concepto Pago</label>
                    <input type="text" class="form-control" name="conceptop" id="conceptop" autocomplete="off" placeholder="Concepto de Pago">
                  </div>
                </div>
              </div>

              <div class="row justify-content-sm-center">
                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="obsp" class="col-form-label">Observaciones:</label>
                    <textarea class="form-control" name="obsp" id="obsp" rows="3" autocomplete="off" placeholder="Observaciones"></textarea>
                  </div>
                </div>
              </div>

              <div class="row justify-content-sm-center">

                <div class="col-lg-4 ">
                  <label for="saldop" class="col-form-label ">Saldo:</label>
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-dollar-sign"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control text-right" name="saldop" id="saldop" disabled>
                  </div>
                </div>

                <div class="col-lg-4">
                  <label for="montop" class="col-form-label">Pago:</label>
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-dollar-sign"></i>
                      </span>

                    </div>
                    <input type="text" id="montop" name="montop" class="form-control text-right" autocomplete="off" placeholder="Monto del Pago">
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="input-group-sm">
                    <label for="metodo" class="col-form-label">Metodo de Pago:</label>

                    <select class="form-control" name="metodo" id="metodo">
                      <option id="Efectivo" value="Efectivo">Efectivo</option>
                      <option id="Transferencia" value="Transferencia">Transferencia</option>
                      <option id="Deposito" value="Deposito">Deposito</option>
                      <option id="Cheque" value="Cheque">Cheque</option>
                      <option id="Tarjeta de Crédito" value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                      <option id="Tarjeta de Debito" value="Tarjeta de Débito">Tarjeta de Debito</option>

                    </select>
                  </div>
                </div>

              </div>


            </div>





            <div class="modal-footer">
              <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
              <button type="button" id="btnGuardarvp" name="btnGuardarvp" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">


      <!-- Default box -->
      <div class="modal fade" id="modalResumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-md" role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-green">
              <h5 class="modal-title" id="exampleModalLabel">Resumen de Pagos</h5>

            </div>
            <br>
            <div class="table-hover responsive w-auto " style="padding:10px">
              <table name="tablaResumen" id="tablaResumen" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                <thead class="text-center bg-gradient-green">
                  <tr>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Concepto</th>
                    <th>Monto</th>
                    <th>Metodo</th>
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


  <section>
    <div class="modal fade" id="modalcan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-danger">
            <h5 class="modal-title" id="exampleModalLabel">CANCELAR REGISTRO</h5>
          </div>
          <div class="card card-widget" style="margin: 10px;">
            <form id="formcan" action="" method="POST">
              <div class="modal-body row">
                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="motivo" class="col-form-label">Motivo de Cancelacioón:</label>
                    <textarea rows="3" class="form-control" name="motivo" id="motivo" placeholder="Motivo de Cancelación"></textarea>
                    <input type="hidden" id="fechac" name="fechac" value="<?php echo $fecha ?>">
                    <input type="hidden" id="foliocan" name="foliocan" value="">
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
            <button type="button" id="btnGuardarc" name="btnGuardarc" class="btn btn-success" value="btnGuardarc"><i class="far fa-save"></i> Guardar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntadiario.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>