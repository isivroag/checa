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
      
        break;
    case 2: // CANCELAR REQUISICION
      


        break;
    case 3: // CANCELAR PAGO REQUISICION


        break;
    case 4: //CANCELAR CXP

        $consulta = "UPDATE w_cxpgral SET estado_cxp='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_cxp='$foliocan'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;

            $consulta = "SELECT folio_provi,importe FROM w_cxpgral WHERE folio_cxp='$foliocan'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                $provision = 0;
                $montoreq = 0;
                foreach ($data as $dat) {

                    $provision = $dat['folio_provi'];
                    $montoreq = $dat['importe'];
                }

                if ($provision != '' && $provision != 0) {
                    $consulta = "UPDATE w_provisiongral SET saldo_provi=saldo_provi+'$montoreq' WHERE folio_provi='$provision'";
                    $resultado = $conexion->prepare($consulta);
                    $resultado->execute();
                }

            
        }
        }
        break;

    case 5: // CANCELAR PAGO DE CXP
        $consulta = "UPDATE w_pagocxpgral SET estado_pagocxp='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_pagocxp='$foliocan'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {


            $consulta = "SELECT folio_cxp,monto_pagocxp FROM w_pagocxpgral WHERE folio_pagocxp='$foliocan'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                $monto = 0;
                $foliocxp = 0;
                foreach ($data as $dat) {

                    $monto = $dat['monto_pagocxp'];
                    $foliocxp = $dat['folio_cxp'];
                }



                $consulta = "UPDATE w_cxpgral SET saldo_cxp=saldo_cxp+'$monto' WHERE folio_cxp='$foliocxp'";

                $resultado = $conexion->prepare($consulta);

                if ($resultado->execute()) {
                    $res = 1;
                }
            }
        }

        break;

    case 6:

      
        break;
    case 7:
        $consulta = "UPDATE w_provisiongral SET estado_provi='0',fecha_can='$fecha',motivo_can='$motivo',usuario_can='$usuario' WHERE folio_provi='$foliocan'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }
        break;

    case 8:

     

        break;

    case 9:


        break;

    case 10:

      

        break;

        case 11:

          
    
            break;
    
        case 12:
    
    
            break;
}




print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
