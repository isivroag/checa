<?php
$pagina = "obra";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';



if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $objeto = new conn();
    $conexion = $objeto->connect();


    $consulta = "SELECT * FROM w_obra where id_obra='$id'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    $id_obra = "";
    $obra = "";
    $monto = "";
    $clave = "";
    foreach ($data as $row) {
        $id_obra = $row['id_obra'];
        $clave = $row['clave_obra'];
        $obra = $row['corto_obra'];
        $importe_origen = $row['importe_origen'];
        $importe_add = $row['add_obra'];
        $importe_dec = $row['dec_obra'];
        $importe_obra = $row['monto_obra'];
    }


    $consulta = "SELECT * FROM w_extraobra where id_obra='$id_obra' and estado_extra=1 order by id_extra";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);


    $fecha = date('Y-m-d');
    $message = "";
} else {
    echo "<script>";
    echo "window.location.href = 'cntaobra.php'";
    echo "</script>";
}

?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">


<div class="content-wrapper">



    <!-- TABLA PRINCIPAL -->
    <section class="content">


        <div class="card">
            <div class="card-header bg-gradient-green text-light">
                <h1 class="card-title mx-auto">ANEXOS DE OBRA</h1>
            </div>

            <div class="card-body">
            <div class="row justify-content-center mb-4">
                    <div class="col-lg-1">
                        <div class="form-group input-group-sm">
                            <label for="idobra" class="col-form-label">ID OBRA:</label>
                            <input type="text" class="form-control" name="idobra" id="idobra" value=" <?php echo $id_obra ?>"  disabled>
                        </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="form-group input-group-sm">
                            <label for="obra" class="col-form-label">OBRA:</label>
                           
                            <input type="text" class="form-control" name="obra" id="obra" value="<?php echo $obra ?>"  disabled>
                        </div>

                    </div>
                    <div class="col-lg-2">
                        <label for="imporigen" class="col-form-label">IMPORTE DE ORIGEN:</label>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>

                            </div>
                            <input type="text" class="form-control text-right bg-white" name="imporigen" id="imporigen" value="<?php echo number_format($importe_origen,2) ?>"  disabled>

                        </div>
                    </div>
                    <div class="col-lg-2">
                        <label for="impadd" class="col-form-label">IMPORTE DE INCREMENTOS:</label>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>

                            </div>
                            <input type="text" class="form-control text-right bg-white" name="impadd" id="impadd" value="<?php echo number_format($importe_add,2) ?>"  disabled>

                        </div>
                    </div>
                    <div class="col-lg-2">
                        <label for="impdec" class="col-form-label">IMPORTE DE DECREMETOS:</label>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>

                            </div>
                            <input type="text" class="form-control text-right bg-white" name="impdec" id="impdec" value="<?php echo number_format($importe_dec,2) ?>"  disabled>

                        </div>
                    </div>
                    

                    <div class="col-lg-2">
                        <label for="importe" class="col-form-label">IMPORTE DE OBRA:</label>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>

                            </div>
                            <input type="text" class="form-control text-right bg-white" name="importe" id="importe" value="<?php echo number_format($importe_obra,2) ?>"  disabled>

                        </div>
                    </div>
                  
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="content">

                            <div class="card">
                                <div class="card-header bg-gradient-green text-light">
                                    <h1 class="card-title mx-auto">DETALLE DE ANEXOS</h1>
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
                                                                <th>FECHA</th>
                                                                <th>TIPO</th>
                                                                <th>CLAVE</th>
                                                                <th>CONCEPTO</th>
                                                                <th>MONTO</th>
                                                                <th>ACCIONES</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($data as $dat) {
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $dat['id_extra'] ?></td>
                                                                    <td><?php echo $dat['fecha_extra'] ?></td>
                                                                    <td><?php echo $dat['tipo_extra'] ?></td>
                                                                    <td><?php echo $dat['clave_extra'] ?></td>
                                                                    <td><?php echo $dat['concepto_extra'] ?></td>
                                                                    <td class="text-right"><?php echo number_format($dat['monto_extra']) ?></td>
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


                        </section>




                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- TERMINA TABLA PRINCIPAL -->





    <!-- INICIA ALTA adenda -->

    <section>
        <div class="modal fade" id="modalA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content w-auto">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">REGISTRO DE ADENDA</h5>

                    </div>
                    <form id="formA" action="" method="POST" autocomplete="off">
                        <div class="card card-widget" style="margin: 10px;">

                            <div class="modal-body">
                                <div class="row justify-content-sm-center">

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="folioadd" class="col-form-label">ID:</label>
                                            <input type="text" class="form-control" name="folioadd" id="folioadd" disabled>

                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                    <div class="form-group input-group-sm auto">
                                            <label for="tipoadd" class="col-form-label">TIPO ADENDA:</label>
                                            <select class="form-control" name="tipoadd" id="tipoadd">
                                                <option id="INCREMENTO" value="INCREMENTO">INCREMENTO</option>
                                                <option id="DECREMENTO" value="DECREMENTO">DECREMENTO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 ">
                                    <div class="form-group input-group-sm">
                                            <label for="claveadd" class="col-form-label">CLAVE ADENDA:</label>
                                            <input type="text" class="form-control" name="claveadd" id="claveadd" >

                                        </div>
                                       
                                    </div>
                                    <div class="col-sm-3 ">
                                        <div class="form-group input-group-sm">
                                            <label for="fechaadd" class="col-form-label">FECHA INICIO:</label>
                                            <input type="date" class="form-control" name="fechaadd" id="fechaadd" value="<?php echo $fecha; ?>">
                                        </div>
                                    </div>





                                </div>

                                <div class=" row justify-content-sm-center">

                                    <div class="col-sm-12">
                                        <div class="input-group input-group-sm">
                                            <label for="obra" class="col-form-label">OBRA:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="hidden" class="form-control" name="id_obra" id="id_obra" value="<?php echo $id_obra?>">
                                                <input type="text" class="form-control" name="obra" id="obra" value="<?php echo $obra?>" disabled placeholder="SELECCIONAR OBRA">
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





                                </div>

                                <div class=" row justify-content-sm-center">

                                    <div class="col-sm-12">
                                        <div class="form-group input-group-sm">
                                            <label for="descripcionadd" class="col-form-label">CONCEPTO:</label>
                                            <textarea row="2" type="text" class="form-control" name="descripcionadd" id="descripcionadd" placeholder="CONCEPTO"></textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="row justify-content-sm-center" style="margin-bottom: 10px;">

                                    <div class="col-sm-4 ">
                                        <label for=" importeobra" class="col-form-label">IMPORTE ACTUAL DEL CONTRATO</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="importeobra" id="importeobra" value="<?php echo number_format($importe_obra,2)?>" onkeypress="return filterFloat(event,this);" disabled>
                                        </div>
                                    </div>
                                    <div class=" col-sm-4 ">

                                    </div>
                                    <div class=" col-sm-4 ">
                                        <label for=" importeadd" class="col-form-label">MONTO DE CAJA</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="importeadd" id="importeadd" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class=" modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                                <button type="button" id="btnGuardarnom" name="btnGuardarnom" class="btn btn-success" value="btnGuardarnom"><i class="far fa-save"></i> Guardar</button>
                            </div>


                    </form>
                </div>
            </div>
        </div>
    </section>


    <!-- TERMINA ALTA CAJA -->


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



    <!-- INICIA MOVIMIENTO -->
    <section>
        <div class="modal fade" id="modalMov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content w-auto">
                    <div class="modal-header bg-gradient-secondary">
                        <h5 class="modal-title" id="exampleModalLabel">APERTURA DE CAJA</h5>

                    </div>
                    <form id="formMov" action="" method="POST" autocomplete="off">
                        <div class="card card-widget" style="margin: 10px;">

                            <div class="modal-body">
                                <div class="row justify-content-sm-center">

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="foliomov" class="col-form-label">ID CAJA:</label>
                                            <input type="text" class="form-control" name="foliomov" id="foliomov" disabled>
                                            <input type="hidden" class="form-control" name="foliocajamov" id="foliocajamov">

                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                    </div>
                                    <div class="col-sm-3 ">

                                    </div>
                                    <div class="col-sm-3 ">
                                        <div class="form-group input-group-sm">
                                            <label for="fechamov" class="col-form-label">FECHA OPERACION:</label>
                                            <input type="date" class="form-control" name="fechamov" id="fechamov" value="<?php echo $fecha; ?>">
                                        </div>
                                    </div>





                                </div>



                                <div class=" row justify-content-sm-center">

                                    <div class="col-sm-12">
                                        <div class="form-group input-group-sm">
                                            <label for="descmov" class="col-form-label">DESCRIPCION:</label>
                                            <textarea row="2" type="text" class="form-control" name="descmov" id="descmov" placeholder="DESCRIPCION DEL MOVIMIENTO"></textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="row justify-content-sm-center" style="margin-bottom: 10px;">

                                    <div class="col-sm-4 ">
                                        <div class="form-group input-group-sm auto">
                                            <label for="tipomov" class="col-form-label">TIPO OPERACION:</label>
                                            <select class="form-control" name="tipomov" id="tipomov">
                                                <option id="Saldo Inicial" value="Saldo Inicial">SALDO INICIAL</option>
                                                <option id="Reposicion" value="Reposicion"> REPOSICION</option>
                                                <option id="Ajuste Positivo" value="Ajuste Positivo"> AJUSTE POSITIVO</option>
                                                <option id="Ajuste Negativo" value="Ajuste Negativo"> AJUSTE NEGATIVO</option>


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">

                                    </div>
                                    <div class=" col-sm-4 ">
                                        <label for=" montomov" class="col-form-label">MONTO DE OPERACION</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="montomov" id="montomov" onkeypress="return filterFloat(event,this);">
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class=" modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                                <button type="button" id="btnGuardarMov" name="btnGuardarMov" class="btn btn-success" value="btnGuardarMov"><i class="far fa-save"></i> Guardar</button>
                            </div>


                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- TERMINA MOVIMIENTO -->

</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaextraobra.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>