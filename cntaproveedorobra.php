<?php
$pagina = "proveedorobra";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


if ($_SESSION['id_obra'] == null) {
  $id_obra = null;
  $obra = null;
  $consultacon = "SELECT * FROM w_obra WHERE estado_obra=1 ORDER BY id_obra";
  $resultadocon = $conexion->prepare($consultacon);
  $resultadocon->execute();
  $datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);

  if (isset($_GET['id_obra'])) {
    $id_obra = $_GET['id_obra'];

    //BUSCAR NOMBRE DE OBRA
    $consultaobra = "SELECT corto_obra,monto_obra from w_obra where id_obra='$id_obra'";
    $resultadoobra = $conexion->prepare($consultaobra);
    $resultadoobra->execute();
    $dataobra = $resultadoobra->fetchAll(PDO::FETCH_ASSOC);
    foreach ($dataobra as $rowobra) {
      $obra = $rowobra['corto_obra'];
      $montoobra = $rowobra['monto_obra'];
    }

    //BUSCAR NOMBRE DE OBRA
    $consulta = "SELECT * FROM o_proveedor WHERE id_obra='$id_obra' and estado_prov=1 ORDER BY id_prov";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
  }
} else {

  $id_obra = $_SESSION['id_obra'];
  $obra = $_SESSION['nom_obra'];

  //BUSCAR NOMBRE DE OBRA
  $consultaobra = "SELECT corto_obra,monto_obra from w_obra where id_obra='$id_obra'";
  $resultadoobra = $conexion->prepare($consultaobra);
  $resultadoobra->execute();
  $dataobra = $resultadoobra->fetchAll(PDO::FETCH_ASSOC);
  foreach ($dataobra as $rowobra) {
    $obra = $rowobra['corto_obra'];
    $montoobra = $rowobra['monto_obra'];
  }

  $consulta = "SELECT * FROM o_proveedor WHERE id_obra='$id_obra' and estado_prov=1 ORDER BY id_prov";
  $resultado = $conexion->prepare($consulta);
  $resultado->execute();
  $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
}







$consultaesp = "SELECT * FROM especialidad WHERE estado_especialidad=1 ORDER BY id_especialidad";
$resultadoesp = $conexion->prepare($consultaesp);
$resultadoesp->execute();
$dataesp = $resultadoesp->fetchAll(PDO::FETCH_ASSOC);

$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">


<div class="content-wrapper">



  <section class="content">


    <div class="card">
      <div class="card-header bg-gradient-secondary text-light">
        <h1 class="card-title mx-auto">PROVEEDORES</h1>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">

            <div class="card">
              <div class="card-header bg-gradient-secondary">
                SELECCIONAR OBRA
              </div>

              <div class="card-body ">
                <div class="row justify-content-center mb-3">
                  <div class="col-sm-5">
                    <div class="input-group input-group-sm">
                      <label for="obra" class="col-form-label">OBRA:</label>
                      <div class="input-group input-group-sm">
                        <input type="hidden" class="form-control" name="id_obra" id="id_obra" value="<?php echo $id_obra; ?>">
                        <input type="text" class="form-control" name="obra" id="obra" disabled placeholder="SELECCIONAR OBRA" value="<?php echo $obra; ?>">
                        <?php if ($id_obra == null) { ?>
                          <span class="input-group-append">
                            <button id="bobra" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                          </span>
                        <?php } ?>
                      </div>

                    </div>
                  </div>
                </div>


              </div>
            </div>


            <?php

            if ($id_obra != null) { ?>


              <section class="content">

                <!-- Default box -->
                <div class="card">
                  <div class="card-header bg-gradient-secondary text-light">
                    <h1 class="card-title mx-auto">INFORMACION DE OTROS GASTOS</h1>
                  </div>

                  <div class="card-body">

                    <div class="container-fluid">

                      <div class="row">
                        <div class="col-lg-12">
                          <button id="btnNuevo" type="button" class="btn bg-gradient-secondary btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
                        </div>
                      </div>
                      <br>
                      <div class="container-fluid">

                        <div class="row">
                          <div class="col-lg-12">
                            <div class="table-responsive">
                              <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                <thead class="text-center bg-gradient-secondary">
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

                  </div>
                  <!-- /.card-body -->

                  <!-- /.card-footer-->
                </div>
                <!-- /.card -->

              </section>




            <?php } ?>
          </div>
        </div>

      </div>


    </div>


  </section>

  <!-- PROVEEDOR -->
  <section>
    <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-secondary">
            <h5 class="modal-title" id="exampleModalLabel">NUEVO PROVEEDOR</h5>

          </div>
          <div class="card card-widget" style="margin: 10px;">
            <form id="formDatos" action="" method="POST">
              <div class="modal-body row">

                <div class="col-sm-6">
                  <div class="form-group input-group-sm">
                    <label for="rfc" class="col-form-label">RFC:</label>
                    <input type="hidden" class="form-control" name="id_obra2" id="id_obra2" value="<?php echo $id_obra; ?>">
                    <input type="text" class="form-control" name="rfc" id="rfc" autocomplete="off" placeholder="RFC">

                  </div>
                </div>


                <div class="col-sm-6">
                  <div class="form-group input-group-sm auto">
                    <label for="especialidad" class="col-form-label">ESPECIALIDAD:</label>
                    <select class="form-control" name="especialidad" id="especialidad">
                      <?php
                      foreach ($dataesp as $dtt) {
                      ?>
                        <option id="<?php echo $dtt['id_especialidad'] ?>" value="<?php echo $dtt['nom_especialidad'] ?>"> <?php echo $dtt['nom_especialidad'] ?></option>

                      <?php
                      }
                      ?>
                    </select>
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

                <div class="col-sm-4">
                  <div class="form-group input-group-sm">
                    <label for="tel" class="col-form-label">TELEFONO:</label>
                    <input type="text" class="form-control" name="tel" id="tel" autocomplete="off" placeholder="Teléfono">
                  </div>
                </div>



                <div class="col-sm-4">
                  <div class="form-group input-group-sm">
                    <label for="contacto" class="col-form-label">CONTACTO:</label>
                    <input type="text" class="form-control" name="contacto" id="contacto" autocomplete="off" placeholder="Contacto">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group input-group-sm">
                    <label for="tel_contacto" class="col-form-label">TELEFONO DE CONTACTO:</label>
                    <input type="text" class="form-control" name="tel_contacto" id="tel_contacto" autocomplete="off" placeholder="Teléfono deContacto">
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
  <!-- CUENTA DE PROVEEDOR -->

  <section>
    <div class="modal fade" id="modalcuentaprov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-secondary">
            <h5 class="modal-title" id="exampleModalLabel">CUENTAS DE PROVEEDORES</h5>

          </div>
          <div class="card card-widget" style="margin: 10px;">
            <form id="formcuentaprov" action="" method="POST">
              <div class="modal-body row">

                <div class="col-sm-3">
                  <div class="form-group input-group-sm">
                    <label for="idcuentaprov" class="col-form-label">ID:</label>
                    <input type="hidden" class="form-control" name="idprovcuenta" id="idprovcuenta" autocomplete="off" placeholder="ID">
                    <input type="text" class="form-control" name="idcuentaprov" id="idcuentaprov" autocomplete="off" placeholder="ID">
                  </div>
                </div>

                <div class="col-sm-9">
                  <div class="form-group input-group-sm">
                    <label for="bancoprov" class="col-form-label">BANCO:</label>
                    <input type="text" class="form-control" name="bancoprov" id="bancoprov" autocomplete="off" placeholder="BANCO">
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group input-group-sm">
                    <label for="cuenta" class="col-form-label">No. CUENTA:</label>
                    <input type="text" class="form-control" name="cuenta" id="cuenta" autocomplete="off" placeholder="No. CUENTA">
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group input-group-sm">
                    <label for="clabe" class="col-form-label">CLABE:</label>
                    <input type="text" class="form-control" name="clabe" id="clabe" autocomplete="off" placeholder="CLABE">
                  </div>
                </div>



                <div class="col-sm-4">
                  <div class="form-group input-group-sm">
                    <label for="tarjeta" class="col-form-label">No. TARJETA:</label>
                    <input type="text" class="form-control" name="tarjeta" id="tarjeta" autocomplete="off" placeholder="No. TARJETA">
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
            <button type="submit" id="btnGuardarcuentaprov" name="btnGuardarcuentaprov" class="btn btn-success" value="btnGuardarcuentaprov"><i class="far fa-save"></i> Guardar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- TABLA CUENTAS -->
  <section>
    <div class="container">


      <!-- Default box -->
      <div class="modal fade" id="modalCuentas" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-md" role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-secondary">
              <h5 class="modal-title" id="exampleModalLabel">Resumen de Pagos</h5>

            </div>
            <br>
            <div class="table-hover responsive w-auto " style="padding:10px">
              <table name="tablaCuentas" id="tablaCuentas" class="table table-sm table-striped table-bordered table-condensed display compact" style="width:100%">
                <thead class="text-center bg-gradient-secondary">
                  <tr>
                    <th>ID</th>
                    <th>ID PROV</th>
                    <th>BANCO</th>
                    <th>CUENTA</th>
                    <th>CLABE</th>
                    <th>TARJETA</th>
                    <th>ACCIONES</th>
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

  <!-- INICIA OBRA -->
  <section>
    <div class="container-fluid">

      <!-- Default box -->
      <div class="modal fade" id="modalObra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-md" role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-green">
              <h5 class="modal-title" id="exampleModalLabel">BUSCAR OBRA</h5>

            </div>
            <br>
            <div class="table-hover table-responsive w-auto" style="padding:15px">
              <table name="tablaObra" id="tablaObra" class="table table-sm  table-striped table-bordered table-condensed" style="width:100%">
                <thead class="text-center bg-gradient-green">
                  <tr>
                    <th>ID</th>
                    <th>CLAVE</th>
                    <th>NOMBRE CORTO</th>
                    <th>ACCIONES</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($datacon as $datc) {
                  ?>
                    <tr>
                      <td><?php echo $datc['id_obra'] ?></td>
                      <td><?php echo $datc['clave_obra'] ?></td>
                      <td><?php echo $datc['corto_obra'] ?></td>
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
  </section>
  <!-- TERMINA OBRA -->

  <!-- /.content -->
</div>






<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaproveedorobra.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>