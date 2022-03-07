<!-- CODIGO PHP-->
<?php
$pagina = "estimacion";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$tokenid = md5($_SESSION['s_usuario']);
$usuario = $_SESSION['s_nombre'];
$idusuario = $_SESSION['s_id_usuario'];



if (isset($_GET['id_obra'])) {
    $id_obra = $_GET['id_obra'];

    $consultacon = "SELECT * FROM v_tmp_est WHERE estado_est=1 and usuario_alt='$idusuario' and id_obra='$id_obra'";

    $resultadocon = $conexion->prepare($consultacon);
    $resultadocon->execute();

    if ($resultadocon->rowCount() > 0) {
        $datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);
        foreach ($datacon as $row) {
            $folio_tmp = $row['folio_tmp'];
            $obra = $row['corto_obra'];
            $fecha = $row['fecha_est'];
            $clave = $row['clave_est'];
            $tipo = $row['tipo_est'];
            $desc = $row['descripcion_est'];
            $importe = $row['importe_est'];
            $folio_est = $row['folio_est'];
        }
    } else {
        $fecha = date('Y-m-d');
        $consultacon = "INSERT INTO w_tmp_est(fecha_est,importe_est,id_obra,usuario_alt) values ('$fecha','0','$id_obra','$idusuario')";
        $resultadocon = $conexion->prepare($consultacon);
        $resultadocon->execute();

        $consultacon = "SELECT * FROM v_tmp_est WHERE estado_est=1 and usuario_alt='$idusuario'";
        $resultadocon = $conexion->prepare($consultacon);
        $resultadocon->execute();
        $datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);

        foreach ($datacon as $row) {
            $folio_tmp = $row['folio_tmp'];
            $id_obra = $row['id_obra'];
            $obra = $row['corto_obra'];
        }

        $fecha = date('Y-m-d');
        $tipo = "";
        $clave = "";
        $desc = "";
        $importe = 0;
        $folio_est = 0;
    }
} else {

    if (isset($_GET['folio'])) {
        $folio_tmp = $_GET['folio'];
        $consulta = "SELECT * FROM v_tmp_est WHERE folio_tmp='$folio_tmp'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        if ($resultadocon->rowCount() > 0) {
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $row) {
                $id_obra = $row['id_obra'];
                $obra = $row['corto_obra'];
                $fecha = $row['fecha_est'];
                $clave = $row['clave_est'];
                $tipo = $row['tipo_est'];
                $desc = $row['descripcion_est'];
                $importe = $row['importe_est'];
                $folio_est = $row['folio_est'];
            }
        } else {
            echo "<script>";
            echo "window.location.href = 'cntaestimacion.php'";
            echo "</script>";
        }
    } else {
        echo "<script>";
        echo "window.location.href = 'cntaestimacion.php'";
        echo "</script>";
    }
}




$message = "";








$consulta = "SELECT * FROM v_tmp_detalleest WHERE folio_tmp='$folio_tmp'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$datadet = $resultado->fetchAll(PDO::FETCH_ASSOC);





?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="css/estilo.css">
<style>
    .punto {
        height: 20px !important;
        width: 20px !important;

        border-radius: 50% !important;
        display: inline-block !important;
        text-align: center;
        font-size: 15px;
    }

    #div_carga {
        position: absolute;
        /*top: 50%;
    left: 50%;
    */

        width: 100%;
        height: 100%;
        background-color: rgba(60, 60, 60, 0.5);
        display: none;

        justify-content: center;
        align-items: center;
        z-index: 3;
    }

    #cargador {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
    }

    #textoc {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: 120px;
        margin-left: 20px;


    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">


        <!-- Default box -->
        <div class="card">


            <div id="div_carga">

                <img id="cargador" src="img/loader.gif" />
                <span class=" " id="textoc"><strong>Cargando...</strong></span>

            </div>

            <div class="card-header bg-gradient-green text-light">
                <h1 class="card-title mx-auto">REGISTRO DE ESTIMACIONES</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">


                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-green btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
                        <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-primary btn-ms" data-toggle="modal"><i class="fas fa-envelope-square"></i> Enviar</button>-->
                    </div>
                </div>

                <br>


                <!-- Formulario Datos de Cliente -->
                <form id="formDatos" action="" method="POST">


                    <div class="content">

                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-green " style="margin:0px;padding:8px">


                                <h1 class="card-title "> DATOS DE ESTIMACION</h1>
                            </div>

                            <div class="card-body" style="margin:0px;padding:1px;">

                                <div class="row justify-content-sm-center">


                                    <div class="col-lg-1">
                                        <div class="form-group input-group-sm">
                                            <label for="idtmp" class="col-form-label">ID:</label>

                                            <input type="text" class="form-control" name="idtmp" id="idtmp" value="<?php echo  $folio_tmp; ?> " disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="folio" class="col-form-label">No. DE ESTIMACION:</label>
                                            <input type="text" class="form-control" name="folio" id="folio" value="<?php echo  $clave; ?>" placeholder="No. DE ESTIMACION">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <!--  <div class="form-group input-group-sm">
                                            <label for="tipo" class="col-form-label">TIPO:</label>
                                            <select class="form-control" name="tipo" id="tipo">

                                                <option id="NORMAL" value="NORMAL">NORMAL</option>
                                                <option id="ADICIONAL" value="ADICIONAL">ADICIONAL</option>
                                                <option id="EXTRAORDINARIA" value="EXTRAORDINARIA">EXTRAORDINARIA</option>

                                            </select>
                                        </div> -->
                                    </div>




                                    <div class="col-lg-2 ">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">FECHA:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class=" row justify-content-sm-center">

                                    <div class="col-lg-8">
                                        <div class="input-group input-group-sm">
                                            <label for="obra" class="col-form-label">OBRA:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="hidden" class="form-control" name="id_obra" id="id_obra" value="<?php echo $id_obra; ?>">
                                                <input type="text" class="form-control" name="obra" id="obra" disabled placeholder="SELECCIONAR OBRA" value="<?php echo $obra; ?>">
                                                <?php
                                                if ($id_obra == null) {
                                                ?>
                                                    <span class="input-group-append">
                                                        <button id="bobra" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                    </span>
                                                <?php } ?>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-lg-8">
                                        <div class="form-group input-group-sm">
                                            <label for="descripcion" class="col-form-label">DESCRIPCION:</label>
                                            <textarea rows="3" class="form-control" name="descripcion" id="descripcion" value="<?php echo  $desc; ?>" placeholder="DESCRIPCION/CONCEPTO"></textarea>
                                        </div>
                                    </div>


                                </div>
                                <div class="row justify-content-sm-end ">
                                    <div class="col-sm-2 d-block">
                                        <button type="button" id="btnAgregar" name="btnAgregar" class="btn btn-primary btn-block" value="btnAgregar"><i class="fas fa-plus"></i> Agregar Concepto</button>
                                    </div>

                                </div>
                                
                                <div class="row justify-content-sm-center" style="margin-bottom:10px">
                                    <div class="col-lg-12 mx-auto">

                                        <div class="table-responsive" style="padding:5px;">

                                            <table name="tablaDet" id="tablaDet" class="table table-sm table-striped table-bordered table-condensed  mx-auto" style="width:100%;">
                                                <thead class="text-center bg-gradient-green">
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Concepto</th>
                                                        <th>Cantidad</th>
                                                        <th>Unidad</th>
                                                        <th>P.U.</th>
                                                        <th>Importe</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($datadet as $datdet) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $datdet['id_det'] ?></td>
                                                            <td><?php echo $datdet['concepto_renglon'] ?></td>
                                                            <td class="text-right"><?php echo number_format($datdet['cantidad'],2) ?></td>
                                                            <td class="text-center"><?php echo $datdet['unidad_renglon'] ?></td>
                                                            <td class="text-right"><?php echo number_format($datdet['precio'],2) ?></td>
                                                            <td class="text-right"><?php echo number_format($datdet['importe'],2) ?></td>
                                                            
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

                                <div class="row justify-content-sm-center" style="margin-bottom: 10px;">
                                    <div class="col-lg-3">

                                    </div>
                                    <div class="col-lg-2 offset-lg-3">
                                        <label for="monto" class="col-form-label">IMPORTE ESTIMACION:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="monto" id="monto" value="<?php echo number_format($importe, 2); ?>" pattern="[0-9]*">
                                        </div>
                                    </div>
                                </div>
                                <!-- modificacion Agregar notas a presupuesto-->


                            </div>
                            <!--fin modificacion agregar vendedor a presupuesto -->

                        </div>
                        <!-- Formulario Agrear Item -->


                    </div>


                </form>


                <!-- /.card-body -->

                <!-- /.card-footer-->
            </div>
        </div>



        <!-- /.card -->

    </section>






    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalObra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR OBRA</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaObra" id="tablaObra" class="table table-sm text-nowrap table-striped table-bordered table-condensed" style="width:100%">
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

    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR OBRA</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaProveedor" id="tablaProveedor" class="table table-sm text-nowrap table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-gradient-green">
                                    <tr>
                                        <th>ID</th>
                                        <th>RFC</th>
                                        <th>RAZON SOCIAL</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($dataprov as $datp) {
                                    ?>
                                        <tr>
                                            <td><?php echo $datp['id_prov'] ?></td>
                                            <td><?php echo $datp['rfc_prov'] ?></td>
                                            <td><?php echo $datp['razon_prov'] ?></td>
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

</div>

<script>
    //window.addEventListener('beforeunload', function(event)  {

    // event.preventDefault();


    //event.returnValue ="";
    //});
</script>

<?php include_once 'templates/footer.php'; ?>
<script src="fjs/tmpestimacion.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>