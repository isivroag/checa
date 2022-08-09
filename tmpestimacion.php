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
$opcion="";

function buscarpadre($idpadre, $conn, $obra)
{



    $consultaf = "SELECT * FROM w_pres WHERE indice_renglon='$idpadre' and id_obra='$obra'";

    $resultadof = $conn->prepare($consultaf);
    $resultadof->execute();
    $dataf = $resultadof->fetchAll(PDO::FETCH_ASSOC);
    foreach ($dataf as $rowf) {
        $padre = $rowf['padre_renglon'];
    }
    if ($padre == 0) {
        echo '<tr>
        <td></td>
        <td>' . $rowf['id_renglon'] . '</td>
        <td>' . $rowf['indice_renglon'] . '</td>
        <td>' . $rowf['clave_renglon'] . '</td>
        <td>' . $rowf['concepto_renglon'] . '</td>
        <td class="text-right"></td>
        <td class="text-center"></td>
        <td class="text-right"></td>
        <td class="text-right"></td>
        <td>' . $rowf['tipo_renglon'] . '</td>
        <td>' . $rowf['padre_renglon'] . '</td>
        <td></td>
    </tr>';
    } else {
        buscarpadre($padre, $conn, $obra);
        echo '<tr>
        <td></td>
        <td>' . $rowf['id_renglon'] . '</td>
        <td>' . $rowf['indice_renglon'] . '</td>
        <td>' . $rowf['clave_renglon'] . '</td>
        <td>' . $rowf['concepto_renglon'] . '</td>
        <td class="text-right"></td>
        <td class="text-center"></td>
        <td class="text-right"></td>
        <td class="text-right"></td>
        <td>' . $rowf['tipo_renglon'] . '</td>
        <td>' . $rowf['padre_renglon'] . '</td>
        <td></td>
    </tr>';
    }
}


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
        //$folio_est = 0;
        $opcion=0;
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
        $opcion=0;
    }
} else {

    if (isset($_GET['folio'])) {
        $folio_tmp = $_GET['folio'];
        $consulta = "SELECT * FROM v_tmp_est WHERE folio_tmp='$folio_tmp'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $opcion=1;

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








$consulta = "SELECT * FROM v_tmp_detalleest WHERE folio_tmp='$folio_tmp' order by id_renglon";
//$consulta = "SELECT * FROM v_tmp_detalleest WHERE folio_tmp='$folio_tmp' ";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$datadet = $resultado->fetchAll(PDO::FETCH_ASSOC);


$consulta = "SELECT * FROM w_pres WHERE id_obra='$id_obra'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dataPres = $resultado->fetchAll(PDO::FETCH_ASSOC);




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


    #div_carga2 {
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

    #cargador2 {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
    }

    #textoc2 {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: 120px;
        margin-left: 20px;

    }
    .conSel tbody tr:hover td {
        background-color: #04146F !important;
        color: #FFFFFF !important;

    }

    .sinSel tr:hover td {

        color: #000000 !important;

    }

    .sinSel tr td {

        color: #000000 !important;

    }
</style>

<div class="content-wrapper">



    <section class="content">



        <div class="card">




            <div class="card-header bg-gradient-green text-light">
                <h1 class="card-title mx-auto">REGISTRO DE ESTIMACIONES</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">



                        <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>

                    </div>
                </div>

                <br>



                <form id="formDatos" action="" method="POST">


                    <div class="content">

                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-green " style="margin:0px;padding:8px">


                                <h1 class="card-title "> DATOS DE ESTIMACION</h1>
                            </div>

                            <div id="div_carga2">

                                <img id="cargador2" src="img/loader.gif" />
                                <span class=" " id="textoc2"><strong>Cargando...</strong></span>

                            </div>

                            <div class="card-body" style="margin:0px;padding:1px;">

                                <div class="row justify-content-sm-center">


                                    <div class="col-lg-1">
                                        <div class="form-group input-group-sm">
                                            <label for="idtmp" class="col-form-label">ID:</label>

                                            <input type="text" class="form-control" name="idtmp" id="idtmp" value="<?php echo  $folio_tmp; ?> " disabled onload="buscarpresupuesto()">
                                            <input type="hidden" class="form-control" name="folioest" id="folioest" value="<?php echo  $folio_est; ?>" >
                                            <input type="hidden" class="form-control" name="opcion" id="opcion" value="<?php echo  $opcion; ?>" >
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="folio" class="col-form-label">No. DE ESTIMACION:</label>
                                            <input type="text" class="form-control" name="folio" id="folio" value="<?php echo  $clave; ?>" placeholder="No. DE ESTIMACION">

                                        </div>
                                    </div>
                                    <div class="col-lg-3">

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
                                                <input type="text" style="max-width: 100px;" class="form-control" name="id_obra" id="id_obra" value="<?php echo $id_obra; ?>" disabled>
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
                                            <textarea rows="3" class="form-control" name="descripcion" id="descripcion" placeholder="DESCRIPCION/CONCEPTO"><?php echo  $desc; ?></textarea>
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

                                            <table name="tablaDet" id="tablaDet" class="table table-sm table-striped table-bordered table-condensed  mx-auto" style="width:100%">
                                                <thead class="text-center bg-gradient-green">
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Id Renglon</th>
                                                        <th>Indice</th>
                                                        <th>Clave</th>
                                                        <th style="width:50%">Concepto</th>
                                                        <th>Cantidad</th>
                                                        <th>Unidad</th>
                                                        <th>P.U.</th>
                                                        <th>Importe</th>
                                                        <th>TIPO</th>
                                                        <th>PADRE</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!--
                                                    <?php
                                                    /*
                                                    foreach ($datadet as $datdet) {

                                                     
                                                        $idpadre = $datdet['padre_renglon'];
                                                        if ($idpadre != 0) {
                                                            buscarpadre($idpadre, $conexion, $id_obra);
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $datdet['id_det'] ?></td>
                                                            <td><?php echo $datdet['id_renglon'] ?></td>
                                                            <td><?php echo $datdet['indice_renglon'] ?></td>
                                                            <td><?php echo $datdet['clave_renglon'] ?></td>
                                                            <td><?php echo $datdet['concepto_renglon'] ?></td>
                                                            <td class="text-right"><?php echo number_format($datdet['cantidad'], 2) ?></td>
                                                            <td class="text-center"><?php echo $datdet['unidad_renglon'] ?></td>
                                                            <td class="text-right"><?php echo number_format($datdet['precio'], 2) ?></td>
                                                            <td class="text-right"><?php echo number_format($datdet['importe'], 2) ?></td>
                                                            <td><?php echo $datdet['tipo_renglon'] ?></td>
                                                            <td><?php echo $datdet['padre_renglon'] ?></td>
                                                            <td></td>
                                                        </tr>
                                                    <?php

                                                    }*/
                                                    ?>
-->
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


                            </div>

                        </div>



                    </div>


                </form>


            </div>
        </div>



        <!-- /.card -->

    </section>






    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalCon" tabindex="-1">
                <div class="modal-dialog modal-xl ">
                    <div class="modal-content ">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR CONCEPTOS</h5>

                        </div>
                        <br>
                        <div id="div_carga">

                            <img id="cargador" src="img/loader.gif" />
                            <span class=" " id="textoc"><strong>Cargando...</strong></span>

                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm-6">
                                <div class="form-group form-group-sm">
                                    <label for="txtbuscar" class="col-form-label">Introduzca una palabra a buscar dentro de los conceptos del presupuesto:</label>

                                    <div class="input-group input-group-sm">
                                        <input type="text" name="txtbuscar" id="txtbuscar" class="form-control">
                                        <span class="input-group-append">
                                            <button type="button" name="btnbuscar" id="btnbuscar" class="btn bg-gradient-green btn-flat">Buscar</button>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class=" table-hover" style="padding:15px">
                            <table name="tablaCon" id="tablaCon" class="table table-sm table-striped table-bordered  mx-auto " style="width:100%; font-size:15px">
                                <thead class="text-center bg-gradient-primary">
                                    <tr>
                                        <th>ID</th>
                                        <th>INDICE</th>
                                        <th>CLAVE</th>
                                        <th>CONCEPTO</th>
                                        <th>UNIDAD</th>
                                        <th>CANTIDAD</th>
                                        <th>PRECIO</th>
                                        <th>MONTO</th>
                                        <th>TIPO</th>
                                        <th>PADRE</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>


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
            <div class="modal fade" id="modalCon2" tabindex="-1">
                <div class="modal-dialog modal-xl ">
                    <div class="modal-content ">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR CONCEPTOS</h5>

                        </div>
                        <br>
                        <div class=" table-hover" style="padding:15px">
                            <table name="tablaCon2" id="tablaCon2" class="table table-sm table-striped table-bordered  mx-auto " style="width:100%; font-size:15px">
                                <thead class="text-center bg-gradient-green">
                                    <tr>
                                        <th>ID</th>
                                        <th>INDICE</th>
                                        <th>CLAVE</th>
                                        <th>CONCEPTO</th>
                                        <th>UNIDAD</th>
                                        <th>CANTIDAD</th>
                                        <th>PRECIO</th>
                                        <th>MONTO</th>
                                        <th>TIPO</th>
                                        <th>PADRE</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($dataPres as $datPres) {
                                    ?>
                                        <tr>
                                            <td><?php echo $datPres['id_renglon'] ?></td>
                                            <td><?php echo $datPres['indice_renglon'] ?></td>
                                            <td><?php echo $datPres['clave_renglon'] ?></td>
                                            <td><?php echo $datPres['concepto_renglon'] ?></td>
                                            <td><?php echo $datPres['unidad_renglon'] ?></td>
                                            <td class="text-right"><?php echo number_format($datPres['cantidad_renglon'], 2) ?></td>
                                            <td class="text-right"><?php echo number_format($datPres['precio_renglon'], 2) ?></td>
                                            <td class="text-right"><?php echo number_format($datPres['monto_renglon'], 2) ?></td>
                                            <td><?php echo $datPres['tipo_renglon'] ?></td>
                                            <td><?php echo $datPres['padre_renglon'] ?></td>
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
        <div class="modal fade" id="modalAlta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content w-auto">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">AGREGAR CONCEPTO</h5>

                    </div>
                    <form id="formAlta" action="" method="POST" autocomplete="off">
                        <div class="card card-widget" style="margin: 10px;">

                            <div class="modal-body">
                                <div class="row justify-content-sm-center">

                                    <div class="col-sm-3">
                                        <div class="form-group input-group-sm">
                                            <label for="indice_renglon" class="col-form-label">INDICE:</label>
                                            <input type="text" class="form-control" name="indice_renglon" id="indice_renglon" disabled>
                                            <input type="text" class="form-control" name="id_renglon" id="id_renglon" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group input-group-sm">
                                            <label for="clave_renglon" class="col-form-label">CLAVE:</label>
                                            <input type="text" class="form-control" name="clave_renglon" id="clave_renglon" placeholder="CLAVE" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group input-group-sm">
                                            <label for="cantidad_renglon" class="col-form-label">CANT PRES:</label>
                                            <input type="text" class="form-control" name="cantidad_renglon" id="cantidad_renglon" placeholder="CANT PRES" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group input-group-sm">
                                            <label for="cantidad_pend" class="col-form-label">CANT X EJEC:</label>
                                            <input type="text" class="form-control" name="cantidad_pend" id="cantidad_pend" placeholder="CANT X EJEC" disabled>
                                        </div>
                                    </div>

                                </div>



                                <div class=" row justify-content-sm-center">

                                    <div class="col-sm-12">
                                        <div class="form-group input-group-sm">
                                            <label for="concepto_renglon" class="col-form-label">CONCEPTO:</label>
                                            <textarea row="3" type="text" class="form-control" name="concepto_renglon" id="concepto_renglon" placeholder="CONCEPTO" style="height: 120px;"></textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="row justify-content-sm-center" style="margin-bottom: 10px;">

                                    <div class="col-sm-3 ">
                                        <label for="precio_renglon" class="col-form-label">PRECIO:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="precio_renglon" id="precio_renglon" onkeypress="return filterFloat(event,this);" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 ">

                                        <div class="form-group input-group-sm">
                                            <label for="cantidad" class="col-form-label">CANTIDAD:</label>
                                            <input type="text" class="form-control text-right" name="cantidad" id="cantidad" onkeypress="return filterFloat(event,this);">
                                        </div>


                                    </div>

                                    <div class="col-sm-3 ">

                                        <div class="form-group input-group-sm">
                                            <label for="unidad_renglon" class="col-form-label">UNIDAD:</label>
                                            <input type="text" class="form-control text-right" name="unidad_renglon" id="unidad_renglon" onkeypress="return filterFloat(event,this);" disabled>
                                        </div>


                                    </div>

                                    <div class="col-sm-3 ">
                                        <label for="importe" class="col-form-label">IMPORTE:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="importe" id="importe" onkeypress="return filterFloat(event,this);" disabled>
                                        </div>
                                    </div>







                                </div>




                            </div>

                            <div class=" modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                                <button type="button" id="btnAgregarc" name="btnAgregarc" class="btn btn-success" value="btnGuardarreq"><i class="far fa-save"></i> Guardar</button>
                            </div>


                    </form>
                </div>
            </div>
        </div>
    </section>



</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/tmpestimacion.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>