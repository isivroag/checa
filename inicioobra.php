<?php


include_once('bd/funcion.php');
session_start();

include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

if ($_SESSION['s_usuario'] === null) {
    header("Location:index.php");
} else {
    $id_usuario = $_SESSION["s_id_usuario"];
    $nom_usuario = $_SESSION['s_nombre'];
    if ($_SESSION['s_rol'] != 2 && $_SESSION['s_rol'] != 3) {
        if ($_SESSION['id_obra'] != null) {
            header("Location:inicio.php");
        }
        else{
            $consultacon = "SELECT * FROM vusuarioobra WHERE estado_obra=1 and estado_reg=1 and id_usuario='$id_usuario' ORDER BY id_obra";
            $resultadocon = $conexion->prepare($consultacon);
            $resultadocon->execute();
            $datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}








?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CHECA | SELECCIONAR OBRA</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css?v=<?php echo (rand()); ?>">

    <link rel="apple-touch-icon" sizes="57x57" href="img/iconos/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/iconos/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/iconos/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/iconos/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/iconos/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/iconos/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/iconos/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/iconos/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/iconos/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="img/iconos/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/iconos/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="img/iconos/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/iconos/favicon-16x16.png">
    <link rel="manifest" href="img/iconos/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#faffff">
</head>
<style>
    .login-box{
        width: 600px !important;
    }
</style>

<body class=" login-page" style="background:white">
    <div class="login-box" >
    
        <!-- /.login-logo -->
        <div class="card bg-gradient-green">
            <div class="card-body  ">
                <p class="login-box-msg">SELECCIONAR OBRA</p>
                <p> <?php echo $_SESSION['id_obra']?></p>

                <form id="formlogin" name="formlogin" action="" method="post">
                    <div class="col-sm-12">
                        <label for="usuario" class="col-form-label">USUARIO:</label>
                        <input type="text" class="form-control" name="usuario" id="usuario" value="<?php echo $nom_usuario; ?>" disabled>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group input-group-sm auto">
                            <label for="obra" class="col-form-label">OBRA:</label>
                            <select class="form-control" name="obra" id="obra">
                                <?php
                                foreach ($datacon as $dtu) {
                                ?>
                                    <option id="<?php echo $dtu['id_obra'] ?>" value="<?php echo $dtu['id_obra'] ?>"> <?php echo $dtu['corto_obra'] ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                     <div class="row justify-content-between mt-4">
                                <?php echo $_SESSION['id_obra']?>
                    <!-- /.col -->
                    <div class="col-6">
                        <button type="buttn" id="btnaceptar" class="btn btn-primary btn-block">SELECCIONAR</button>
                    </div>
                    <div class="col-6">
                        <button type="button" id="btncancelar" class="btn btn-warning btn-block" >CANCELAR</button>
                    </div>
                    </div>           
                    <!-- /.col -->
            </div>

            </form>

        </div>
        <!-- /.login-card-body -->
    </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->


    <script src="js/adminlte.min.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="fjs/codigoobra.js"></script>


</body>

</html>