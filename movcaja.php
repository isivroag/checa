<?php
$pagina = "caja";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';

if (isset($_GET['folio'])) {
    $folio = $_GET['folio'];
    $objeto = new conn();
    $conexion = $objeto->connect();


    $consulta = "SELECT * FROM vcaja where id_caja='$folio'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    $idobra = "";
    $obra = "";
    $saldo = "";
    foreach ($data as $row) {
        $idobra = $row['id_obra'];
        $obra = $row['corto_obra'];
        $saldo = $row['saldo_caja'];
    }


    $consulta = "SELECT * FROM mov_caja where id_caja='$folio' and estado_mov=1 order by id_mov desc";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);


    $fecha = date('Y-m-d');
    $message = "";
} else {
    echo "<script>";
    echo "window.location.href = 'inicio.php'";
    echo "</script>";
}


?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card ">
            <div class="card-header bg-gradient-secondary">
                <h4 class="card-title text-center">MOVIMIENTOS DE CAJA</h4>
            </div>

            <div class="card-body">

                <div class="row justify-content-center mb-4">
                    <div class="col-lg-1">
                        <div class="form-group input-group-sm">
                            <label for="idcaja" class="col-form-label">ID CAJA:</label>
                            <input type="text" class="form-control" name="idcaja" id="idcaja" value=" <?php echo $folio ?>"  disabled>
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="form-group input-group-sm">
                            <label for="obra" class="col-form-label">OBRA:</label>
                            <input type="hidden" class="form-control" name="idobra" id="idobra" value=" <?php echo $idobra ?>"  disabled>
                            <input type="text" class="form-control" name="obra" id="obra" value="<?php echo $obra ?>"  disabled>
                        </div>

                    </div>
                    <div class="col-lg-2">
                        <label for="saldo" class="col-form-label">SALDO ACTUAL:</label>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>

                            </div>
                            <input type="text" class="form-control text-right bg-white" name="saldo" id="saldo" value="<?php echo number_format($saldo,2) ?>"  disabled>

                        </div>
                    </div>
                    <br>
                </div>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-hover table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="font-size:15px;">
                                    <thead class="text-center bg-gradient-secondary">
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Tipo Movimiento</th>
                                            <th>Descripci??n</th>
                                            <th>Saldo Inicial</th>
                                            <th>Monto</th>
                                            <th>Saldo Final</th>
                                            <th>Acciones</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data as $row) { ?>
                                            <tr>
                                                <td><?php echo $row['id_mov'] ?></td>
                                                <td class="text-center"><?php echo $row['fecha_mov'] ?> </td>
                                                <td class="text-center"><?php echo $row['tipo_mov'] ?></td>
                                                <td><?php echo $row['obs_mov'] ?></td>
                                                <td class="text-roght"><?php echo number_format($row['saldo_ini'], 2) ?></td>
                                                <td class="text-roght"><?php echo number_format($row['monto_mov'], 2) ?></td>
                                                <td class="text-roght"><?php echo number_format($row['saldo_fin'], 2) ?></td>
                                                <td></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- /.card-body -->

            </div>
            <!-- /.card -->

    </section>


    <!-- INICIA CANCELAR -->
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
                                        <label for="motivo" class="col-form-label">Motivo de Cancelacio??n:</label>
                                        <textarea rows="3" class="form-control" name="motivo" id="motivo" placeholder="Motivo de Cancelaci??n"></textarea>
                                        <input type="hidden" id="fecha" name="fecha" value="<?php echo $fecha ?>">
                                        <input type="hidden" id="foliocan" name="foliocan">
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
                        <button type="button" id="btnGuardarCAN" name="btnGuardarCAN" class="btn btn-success" value="btnGuardarCAN"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- TERMINA CANCELAR -->


    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/movcaja.js?v=<?php echo (rand()); ?>"></script>
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