<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$foliocan = (isset($_POST['foliocan'])) ? $_POST['foliocan'] : '';
$motivo = (isset($_POST['motivo'])) ? $_POST['motivo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$tipodoc = (isset($_POST['tipodoc'])) ? $_POST['tipodoc'] : '';

$res = 0;
switch ($tipodoc) {
  
    case 1: //CANCELAR CXC

        $consulta = "UPDATE w_cxc SET estado_cxc='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_cxc='$foliocan'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }
        break;

    case 2: // CANCELAR PAGO DE CXC
        $consulta = "UPDATE w_pagocxc SET estado_pagocxc='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_pagocxc='$foliocan'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {


            $consulta = "SELECT folio_cxc,monto_pagocxc FROM w_pagocxc WHERE folio_pagocxc='$foliocan'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                $monto = 0;
                $foliocxc = 0;
                foreach ($data as $dat) {

                    $monto = $dat['monto_pagocxc'];
                    $foliocxc = $dat['folio_cxc'];
                }



                $consulta = "UPDATE w_cxc SET saldo_cxc=saldo_cxc+'$monto' WHERE folio_cxc='$foliocxc'";

                $resultado = $conexion->prepare($consulta);

                if ($resultado->execute()) {
                    $res = 1;
                } 
            } 
        } 

        break;
}




print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
