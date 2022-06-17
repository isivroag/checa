<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   



$folioreq = (isset($_POST['folioreq'])) ? $_POST['folioreq'] : '';
$fechavp = (isset($_POST['fechavp'])) ? $_POST['fechavp'] : '';
$observacionesvp = (isset($_POST['observacionesvp'])) ? $_POST['observacionesvp'] : '';
$referenciavp = (isset($_POST['referenciavp'])) ? $_POST['referenciavp'] : '';
$saldovp = (isset($_POST['saldovp'])) ? $_POST['saldovp'] : '';
$montovp = (isset($_POST['montovp'])) ? $_POST['montovp'] : '';
$saldofin = (isset($_POST['saldofin'])) ? $_POST['saldofin'] : '';
$metodovp = (isset($_POST['metodovp'])) ? $_POST['metodovp'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

$forigen = (isset($_POST['forigen'])) ? $_POST['forigen'] : '';

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$res = 0;

switch ($opcion) {
    case 1:

        $consulta = "INSERT INTO w_pagors (id_req,fecha_pagors,referencia_pagors,observaciones_pagors,metodo_pagors,monto_pagors,usuario) VALUES ('$folioreq','$fechavp','$referenciavp','$observacionesvp','$metodovp','$montovp','$usuario')";
        $resultado = $conexion->prepare($consulta);

        if ($resultado->execute()) {

            $consulta = "UPDATE w_reqsub SET saldo_req='$saldofin' where id_req='$folioreq'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $consulta = "SELECT id_sub from w_reqsub where id_req='$folioreq'";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($data as $row) {
                        $foliosub = $row['id_sub'];
                    }
                    $consulta = "UPDATE w_subcontrato SET saldo_sub=saldo_sub - '$montovp' where folio_sub='$foliosub'";
                    $resultado = $conexion->prepare($consulta);
                    if ($resultado->execute()) {
                        $res = 1;
                    } else {
                        $res = 2;
                    }
                } else {
                    $res = 2;
                }
            } else {
                $res = 2;
            }
        }
        break;
    case 2:

        $consulta = "INSERT INTO w_pagors (id_req,fecha_pagors,referencia_pagors,observaciones_pagors,metodo_pagors,monto_pagors,usuario) VALUES ('$folioreq','$fechavp','$referenciavp','$observacionesvp','$metodovp','$montovp','$usuario')";
        $resultado = $conexion->prepare($consulta);

        if ($resultado->execute()) {

            $consulta = "UPDATE w_reqsub SET saldo_req='$saldofin' where id_req='$folioreq'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $consulta = "SELECT id_sub from w_reqsub where id_req='$folioreq'";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($data as $row) {
                        $foliosub = $row['id_sub'];
                    }
                    $consulta = "UPDATE w_subcontrato SET saldo_sub=saldo_sub - '$montovp' where folio_sub='$foliosub'";
                    $resultado = $conexion->prepare($consulta);
                    if ($resultado->execute()) {

                        $consulta = "UPDATE semanal_detalle SET aplicado=1 where id_reg='$forigen'";
                        $resultado = $conexion->prepare($consulta);
                        $resultado->execute();

                        $consulta = "SELECT folio_rpt from semanal_detalle WHERE id_reg='$forigen'";
                        $resultado = $conexion->prepare($consulta);
                        $resultado->execute();
                        $reg = $resultado->fetchAll(PDO::FETCH_ASSOC);
                        foreach($reg as $row){
                         $folioreporte=$row['folio_rpt'];
                        }
 
 
                        $consulta = "SELECT * FROM semanal_detalle where folio_rpt='$folioreporte' and aplicado=0";
                        $resultado = $conexion->prepare($consulta);
                        $resultado->execute();
                        if ($resultado->rowCount()==0){
                         $consulta = "UPDATE semanal SET activo=3 where folio='$folioreporte'";
                         $resultado = $conexion->prepare($consulta);
                         $resultado->execute();
                        }

                        $res = 1;
                    } else {
                        $res = 2;
                    }
                } else {
                    $res = 2;
                }
            } else {
                $res = 2;
            }
        }
        break;
}













print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
