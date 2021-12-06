<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$foliocan = (isset($_POST['foliocan'])) ? $_POST['foliocan'] : '';
$motivo = (isset($_POST['motivo'])) ? $_POST['motivo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';

$consulta = "UPDATE mov_caja SET estado_mov='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE id_mov='$foliocan'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {


    $consulta = "SELECT saldo_ini,id_caja FROM mov_caja WHERE id_mov='$foliocan'";
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()) {
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $monto=0;
        $foliocaja=0;
        foreach ($data as $dat) {

            $monto = $dat['saldo_ini'];
            $foliocaja = $dat['id_caja'];
   
        }



        $consulta = "UPDATE w_caja SET saldo_caja='$monto' WHERE id_caja='$foliocaja'";

        $resultado = $conexion->prepare($consulta);

        if ($resultado->execute()) {
            $res = 1;
        } else {
            $res = 0;
        }
    } else {
        $res = 0;
    }
} else {
    $res = 0;
}




print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
