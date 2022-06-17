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
            $consulta = "SELECT id_provs,importe FROM w_reqsub WHERE id_req='$foliocan'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                $provision = 0;
                $montoreq = 0;
                foreach ($data as $dat) {

                    $provision = $dat['id_provs'];
                    $montoreq = $dat['importe'];
                }
                $montoreq = round($montoreq *1.16 ,0, PHP_ROUND_HALF_UP);
                if ($provision != '' && $provision != 0) {
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

            $consulta = "SELECT folio_provi,importe FROM w_cxp WHERE folio_cxp='$foliocan'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                $provision = 0;
                $montoreq = 0;
                foreach ($data as $dat) {

                    $provision = $dat['folio_provi'];
                    $montoreq = $dat['importe'];
                }
                $montoreq= round($montoreq * 1.16 ,0, PHP_ROUND_HALF_UP);
                if ($provision != '' && $provision != 0) {
                    $consulta = "UPDATE w_provision SET saldo_provi=saldo_provi+'$montoreq' WHERE folio_provi='$provision'";
                    $resultado = $conexion->prepare($consulta);
                    $resultado->execute();
                }

            
        }
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
    case 7:
        $consulta = "UPDATE w_provision SET estado_provi='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_provi='$foliocan'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }
        break;

    case 8:

        $consulta = "UPDATE w_nomina SET estado_nom='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE id_nom='$foliocan'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }

        break;

    case 9:

        $consulta = "UPDATE w_otro SET estado_otro='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE id_otro='$foliocan'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }

        break;

    case 10:

        $consulta = "UPDATE w_pagootro SET estado_pagoo='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_pagoo='$foliocan'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {


            $consulta = "SELECT id_otro,monto_pagoo,id_caja FROM w_pagootro WHERE folio_pagoo='$foliocan'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                $monto = 0;
                $otro = 0;
                foreach ($data as $dat) {
                    $caja= $dat['id_caja'];
                    $monto = $dat['monto_pagoo'];
                    $otro = $dat['id_otro'];
                }



                $consulta = "UPDATE w_otro SET saldo_otro=saldo_otro+'$monto' WHERE id_otro='$otro'";

                $resultado = $conexion->prepare($consulta);

                if ($resultado->execute()) {
                    $res = 1;

   
                    $consulta = "SELECT * from w_otro where id_otro='$otro'";
                    $resultado = $conexion->prepare($consulta);
                    $resultado->execute();
                    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($data as $row) {
                        $id_obra = $row['id_obra'];
                    }
            
                    $consulta = "SELECT * from w_caja where id_obra='$id_obra' and id_caja='$caja'";
                    $resultado = $conexion->prepare($consulta);
                    $resultado->execute();
                    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($data as $row) {
                        $id_caja = $row['id_caja'];
                        $saldocaja = $row['saldo_caja'];
                    }
                    $tipomov='Cancelacion Pago';
                    $fechamov=date ('Y-m-d');
                    $descmov="CANCELACION PAGO DE GASTO FOLIO: ". $otro;
                    $montomov=$monto;
                    $saldo=$saldocaja;
                    $saldofin=$saldo+$montomov;
                    
            
            
                    $consulta = "INSERT INTO mov_caja(id_caja,tipo_mov,fecha_mov,obs_mov,monto_mov,saldo_ini,saldo_fin,usuarioalt) 
                    values('$id_caja','$tipomov','$fechamov','$descmov','$montomov','$saldo','$saldofin','$usuario')";
                    $resultado = $conexion->prepare($consulta);
                    if ($resultado->execute()) {
                        $res += 1;
                        $consulta = "UPDATE w_caja SET saldo_caja='$saldofin' WHERE id_caja='$id_caja'";
                        $resultado = $conexion->prepare($consulta);
                        if ($resultado->execute()) {
                            $res += 1;
                        }
                    }

                }
            }
        }

        break;

        case 11:

            $consulta = "UPDATE w_gasto SET estado_gto='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_gto='$foliocan'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $res = 1;
            }
    
            break;
    
        case 12:
    
            $consulta = "UPDATE w_pagogasto SET estado_pagogto='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_pagogto='$foliocan'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
    
    
                $consulta = "SELECT folio_gto,monto_pagogto FROM w_pagogasto WHERE folio_pagogto='$foliocan'";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                    $monto = 0;
                    $otro = 0;
                    foreach ($data as $dat) {
    
                        $monto = $dat['monto_pagogto'];
                        $otro = $dat['folio_gto'];
                    }
    
    
    
                    $consulta = "UPDATE w_gasto SET saldo_gto=saldo_gto+'$monto' WHERE folio_gto='$otro'";
    
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
