<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$foliocan = (isset($_POST['foliocan'])) ? $_POST['foliocan'] : '';
$motivo = (isset($_POST['motivo'])) ? $_POST['motivo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';

$consulta = "UPDATE w_pagocxp SET estado_pagocxp='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_pagocxp='$foliocan'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {


    $consulta = "SELECT folio_cxp,monto_pagocxp FROM w_pagocxp WHERE folio_pagocxp='$foliocan'";
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()) {
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $monto=0;
        $foliocxp=0;
        foreach ($data as $dat) {

            $monto = $dat['monto_pagocxp'];
            $foliocxp = $dat['folio_cxp'];
   
        }



        $consulta = "UPDATE w_cxp SET saldo_cxp=saldo_cxp+'$monto' WHERE folio_cxp='$foliocxp'";

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
