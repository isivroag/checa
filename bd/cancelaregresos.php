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
    case 1: //CANCELAR SUBCONTRATO
        $consulta = "UPDATE w_subcontrato SET estado_sub='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_sub='$foliocan'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }
        break;
    case 2: // CANCELAR REQUISICION
        $consulta = "UPDATE w_reqsub SET estado_req='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE id_req='$foliocan'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;

             //IDENTIFICAR LA PROVISION Y EL MONTO DE LA REQUISICION
             $consulta = "SELECT id_provs,monto_req FROM w_reqsub WHERE id_req='$foliocan'";
             $resultado = $conexion->prepare($consulta);
             if ($resultado->execute()) {
                 $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                 $provision = 0;
                 $montoreq = 0;
                 foreach ($data as $dat) {
 
                     $provision = $dat['id_provs'];
                     $montoreq = $dat['monto_req'];
                 }
 
                 if($provision!='' && $provision!=0){
                    $consulta = "UPDATE w_provsub SET saldo_prov=saldo_prov+'$montoreq' WHERE id_provs='$provision'";
                    $resultado = $conexion->prepare($consulta);
                    $resultado->execute();

                 }
                 //ACTUALIZAR SALDO REQUISICION 
                 
                }
            
        }



        break;
    case 3: // CANCELAR PAGO REQUISICION


        //CANCELAR PAGO
        $consulta = "UPDATE w_pagors SET estado_pagors='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_pagors='$foliocan'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {

            //IDENTIFICAR LA REQUISICION Y EL MONTO DESDE PAGORS
            $consulta = "SELECT id_req,monto_pagors FROM w_pagors WHERE folio_pagors='$foliocan'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                $monto = 0;
                $folioreq = 0;
                foreach ($data as $dat) {

                    $monto = $dat['monto_pagors'];
                    $folioreq = $dat['id_req'];
                }


                //ACTUALIZAR SALDO REQUISICION 
                $consulta = "UPDATE w_reqsub SET saldo_req=saldo_req+'$monto' WHERE id_req='$folioreq'";
                $resultado = $conexion->prepare($consulta);

                if ($resultado->execute()) {
                    //BUSCAR ID SUBCONTRATO
                    $consulta = "SELECT id_sub FROM w_reqsub WHERE id_req='$folioreq'";
                    $resultado = $conexion->prepare($consulta);

                    if ($resultado->execute()) {
                        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                        $foliosub = 0;
                        foreach ($data as $dat) {

                            $foliosub = $dat['id_sub'];
                        }
                        //ACTUALIZAR SALDO SUBCONTRATO
                        $consulta = "UPDATE w_subcontrato SET saldo_sub=saldo_sub+'$monto' WHERE folio_sub='$foliosub'";

                        $resultado = $conexion->prepare($consulta);

                        if ($resultado->execute()) {
                            $res = 1;
                        }
                    }

                    //ACTUALIZAR SALDO SUBCONTRATO
                }
            }
        }
        break;
    case 4: //CANCELAR CXP

        $consulta = "UPDATE w_cxp SET estado_cxp='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_cxp='$foliocan'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }
        break;

    case 5: // CANCELAR PAGO DE CXP
        $consulta = "UPDATE w_pagocxp SET estado_pagocxp='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_pagocxp='$foliocan'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {


            $consulta = "SELECT folio_cxp,monto_pagocxp FROM w_pagocxp WHERE folio_pagocxp='$foliocan'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                $monto = 0;
                $foliocxp = 0;
                foreach ($data as $dat) {

                    $monto = $dat['monto_pagocxp'];
                    $foliocxp = $dat['folio_cxp'];
                }



                $consulta = "UPDATE w_cxp SET saldo_cxp=saldo_cxp+'$monto' WHERE folio_cxp='$foliocxp'";

                $resultado = $conexion->prepare($consulta);

                if ($resultado->execute()) {
                    $res = 1;
                } 
            } 
        } 

        break;

        case 6:

            $consulta = "UPDATE w_provsub SET estado_prov='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE id_provs='$foliocan'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $res = 1;
            }
            break;
}




print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
