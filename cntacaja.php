<?php
$pagina = "caja";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();



$datanom = 0;
$fecha = date('Y-m-d');

$resultado = 0;
$id_obra = null;


//BUSCAR NOMBRE DE OBRA
$consultaobra = "SELECT * from w_obra where estado_obra=1";
$resultadoobra = $conexion->prepare($consultaobra);
$resultadoobra->execute();
$datacon = $resultadoobra->fetchAll(PDO::FETCH_ASSOC);


//BUSCAR NOMBRE DE OBRA

$consulta = "SELECT * FROM vcaja WHERE estado_caja=1 ORDER BY id_caja";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);









$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">


<div class="content-wrapper">



    <!-- TABLA PRINCIPAL -->
    <section class="content">


        <div class="card">
            <div class="card-header bg-gradient-secondary text-light">
                <h1 class="card-title mx-auto">CONTROL DE CAJA DE OBRA</h1>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="content">

                            <div class="card">
                                <div class="card-header bg-gradient-secondary text-light">
                                    <h1 class="card-title mx-auto">INFORMACION DE NOMINAS</h1>
                                </div>

                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button id="btnNuevo" type="button" class="btn bg-gradient-secondary btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="container-fluid">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed w-auto mx-auto" style="width:100%">
                                                    <thead class="text-center bg-gradient-secondary">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>ID OBRA</th>
                                                            <th>CLAVE</th>
                                                            <th>OBRA</th>
                                                            <th>SALDO</th>
                                                            <th>MONTO</th>
                                                            <th>MINIMO</th>
                                                            <th>ACCIONES</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($data as $dat) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $dat['id_caja'] ?></td>
                                                                <td><?php echo $dat['id_obra'] ?></td>
                                                                <td><?php echo $dat['clave_caja'] ?></td>
                                                                <td><?php echo $dat['corto_obra'] ?></td>
                                                                <td class="text-right"><?php echo number_format($dat['saldo_caja']) ?></td>
                                                                <td class="text-right"><?php echo number_format($dat['monto_caja']) ?></td>
                                                                <td class="text-right"><?php echo number_format($dat['min_caja']) ?></td>
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





<!-- INICIA ALTA CAJA -->

<section>
    <div class="modal fade" id="modalReq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content w-auto">
                <div class="modal-header bg-gradient-secondary">
                    <h5 class="modal-title" id="exampleModalLabel">APERTURA DE CAJA</h5>

                </div>
                <form id="formReq" action="" method="POST" autocomplete="off">
                    <div class="card card-widget" style="margin: 10px;">

                        <div class="modal-body">
                            <div class="row justify-content-sm-center">

                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                        <label for="folionom" class="col-form-label">ID CAJA:</label>
                                        <input type="text" class="form-control" name="folionom" id="folionom" disabled>

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group input-group-sm">
                                        <label for="claveca" class="col-form-label">CLAVE CAJA:</label>
                                        <input type="text" class="form-control" name="claveca" id="claveca">
                                    </div>
                                </div>
                                <div class="col-sm-3 ">

                                </div>
                                <div class="col-sm-3 ">
                                    <div class="form-group input-group-sm">
                                        <label for="fechaini" class="col-form-label">FECHA INICIO:</label>
                                        <input type="date" class="form-control" name="fechaini" id="fechaini" value="<?php echo $fecha; ?>">
                                    </div>
                                </div>





                            </div>

                            <div class=" row justify-content-sm-center">

                                <div class="col-sm-12">
                                    <div class="input-group input-group-sm">
                                        <label for="obra" class="col-form-label">OBRA:</label>
                                        <div class="input-group input-group-sm">
                                            <input type="hidden" class="form-control" name="id_obra" id="id_obra">
                                            <input type="text" class="form-control" name="obra" id="obra" disabled placeholder="SELECCIONAR OBRA">
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
                                        <label for="descripcion" class="col-form-label">OBSERVACIONES:</label>
                                        <textarea row="2" type="text" class="form-control" name="descripcion" id="descripcion" placeholder="CONCEPTO"></textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="row justify-content-sm-center" style="margin-bottom: 10px;">

                                <div class="col-sm-4 ">
                                    <label for=" mincaja" class="col-form-label">LIMITE INFERIOR</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="mincaja" id="mincaja" onkeypress="return filterFloat(event,this);">
                                    </div>
                                </div>
                                <div class=" col-sm-4 ">

                                </div>
                                <div class=" col-sm-4 ">
                                    <label for=" montonom" class="col-form-label">MONTO DE CAJA</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-dollar-sign"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control text-right" name="montonom" id="montonom" onkeypress="return filterFloat(event,this);">
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
<script src="fjs/cntacaja.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>