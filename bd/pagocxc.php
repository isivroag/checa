<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$foliocxc = (isset($_POST['foliocxc'])) ? $_POST['foliocxc'] : '';

$fechavp = (isset($_POST['fechavp'])) ? $_POST['fechavp'] : '';
$observacionesvp = (isset($_POST['observacionesvp'])) ? $_POST['observacionesvp'] : '';
$referenciavp = (isset($_POST['referenciavp'])) ? $_POST['referenciavp'] : '';
$saldovp = (isset($_POST['saldovp'])) ? $_POST['saldovp'] : '';
$montovp = (isset($_POST['montovp'])) ? $_POST['montovp'] : '';
$saldofin = (isset($_POST['saldofin'])) ? $_POST['saldofin'] : '';
$metodovp = (isset($_POST['metodovp'])) ? $_POST['metodovp'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$res = 0;

        //guardar el pago
        $consulta = "INSERT INTO w_pagocxc (folio_cxc,fecha_pagocxc,referencia_pagocxc,observaciones_pagocxc,metodo_pagocxc,monto_pagocxc,usuario) VALUES ('$foliocxc','$fechavp','$referenciavp','$observacionesvp','$metodovp','$montovp','$usuario')";
        $resultado = $conexion->prepare($consulta);

        if ($resultado->execute()) {
            $res += 1;
                $consulta = "UPDATE w_cxc SET saldo_cxc='$saldofin' where folio_cxc='$foliocxc'";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $res += 1;
                }
        } else {
            $res = 0;
        }
        print json_encode($res, JSON_UNESCAPED_UNICODE);
        $conexion = NULL;
     