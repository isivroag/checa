<!-- CODIGO PHP-->
<?php
$pagina = "registro";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();



if (isset($_GET['id'])) {
    $id_obra=$_GET['id'];
    $consulta = "SELECT * FROM vobra WHERE id_obra='$id_obra'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach($data as $row){
        $id_emp = $row['id_emp'];
        $empresa = $row['razon_emp'];
        $id_clie = $row['id_clie'];
        $cliente = $row['razon_clie'];
        $fecha =$row['inicio_obra'];
        $clave = $row['clave_obra'];
        
        $corto = $row['corto_obra'];
        $largo = $row['largo_obra'];
        $monto = $row['monto_obra'];

    }
} else{
    $id_emp = "";
    $empresa = "";
    $id_clie = "";
    $cliente = "";
    $fecha = date('Y-m-d');
    $clave = "";
    $id_obra = 0;
    $corto = "";
    $largo = "";
    $monto = 0;
}

$message = "";




$consultacon = "SELECT * FROM w_empresa WHERE estado_emp=1 ORDER BY id_emp";
$resultadocon = $conexion->prepare($consultacon);
$resultadocon->execute();
$datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);



$consultadet = "SELECT * FROM w_cliente WHERE estado_clie=1 ORDER BY id_clie";
$resultadodet = $conexion->prepare($consultadet);
$resultadodet->execute();
$datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);




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
                <h1 class="card-title mx-auto">REGISTRO DE OBRA</h1>
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


                                <h1 class="card-title "> DATOS DE OBRA</h1>
                            </div>

                            <div class="card-body" style="margin:0px;padding:1px;">

                                <div class="row justify-content-sm-center">


                                    <div class="col-lg-1">
                                        <div class="form-group input-group-sm">
                                            <label for="folio" class="col-form-label">ID:</label>

                                            <input type="text" class="form-control" name="folio" id="folio" value="<?php echo  $id_obra; ?> " disabled>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="clave" class="col-form-label">CLAVE:</label>
                                            <input type="text" class="form-control" name="clave" id="clave" value="<?php echo  $clave; ?>" placeholder="CLAVE/#CONTRATO">
                                        </div>
                                    </div>

                                    <div class="col-lg-2 offset-lg-3">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">FECHA INICIO:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
                                        </div>
                                    </div>






                                </div>

                                <div class=" row justify-content-sm-center">

                                    <div class="col-lg-4">
                                        <div class="input-group input-group-sm">
                                            <label for="empresa" class="col-form-label">EMPRESA:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="hidden" class="form-control" name="id_emp" id="id_emp" value="<?php echo $id_emp;?>">
                                                <input type="text" class="form-control" name="empresa" id="empresa" disabled placeholder="SELECCIONAR EMPRESA" value="<?php echo $empresa;?>">
                                                <span class="input-group-append">
                                                    <button id="bempresa" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group input-group-sm">
                                            <label for="cliente" class="col-form-label">CLIENTE:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="hidden" class="form-control" name="id_clie" id="id_clie" value="<?php echo $id_clie;?>">
                                                <input type="text" class="form-control" name="cliente" id="cliente" disabled placeholder="SELECCIONAR CLIENTE" value="<?php echo $cliente;?>">
                                                <span class="input-group-append">
                                                    <button id="bcliente" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                </span>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="form-group input-group-sm">
                                            <label for="corto" class="col-form-label">NOMBRE CORTO:</label>
                                            <input type="text" class="form-control" name="corto" id="corto" value="<?php echo  $corto;?>"  placeholder="NOMBRE CORTO">
                                        </div>
                                    </div>

                                    

                                    <div class="col-lg-8">
                                        <div class="form-group input-group-sm">
                                            <label for="largo" class="col-form-label">DESCRIPCION / NOMBRE LARGO:</label>
                                            <textarea rows="3" class="form-control" name="largo" id="largo" value="<?php echo $largo; ?>" placeholder="DESCRIPCION / NOMBRE LARGO"><?php echo $largo;?></textarea>
                                        </div>
                                    </div>



                                </div>
                                <div class="row justify-content-sm-center" style="margin-bottom: 10px;">
                                    <div class="col-lg-3">
                                    
                                    </div>
                                    <div class="col-lg-2 offset-lg-3">
                                        <label for="monto" class="col-form-label">MONTO TOTAL:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="monto" id="monto" value="<?php echo number_format($monto,2);?>" pattern="[0-9]*">
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
            <div class="modal fade" id="modalCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR CLIENTE</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablacliente" id="tablacliente" class="table table-sm text-nowrap table-striped table-bordered table-condensed" style="width:100%">
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
                                    foreach ($datadet as $datc) {
                                    ?>
                                        <tr>
                                            <td><?php echo $datc['id_clie'] ?></td>
                                            <td><?php echo $datc['rfc_clie'] ?></td>
                                            <td><?php echo $datc['razon_clie'] ?></td>
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
            <div class="modal fade" id="modalEmpresa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR EMPRESA</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaEmpresa" id="tablaEmpresa" class="table table-sm table-striped table-bordered table-condensed " style="width:100%">
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
                                    foreach ($datacon as $datc) {
                                    ?>
                                        <tr>
                                            <td><?php echo $datc['id_emp'] ?></td>
                                            <td><?php echo $datc['rfc_emp'] ?></td>
                                            <td><?php echo $datc['razon_emp'] ?></td>
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
<script src="fjs/obra.js?v=<?php echo(rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>