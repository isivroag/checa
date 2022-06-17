<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';

$res = 0;
switch ($tipo) {

    case 1: //SELECCIONAR PROVISIONES SUBCONTRATO

        $consulta = "UPDATE w_provsub SET edorpt=1 WHERE id_provs='$id'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }
        break;

    case 2: // SELECCIONAR REQUISICIONES
        $consulta = "UPDATE w_reqsub SET edorpt=1 WHERE id_req='$id'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }

        break;
    case 3: // SELECCIONAR CXP

        $consulta = "UPDATE w_cxp SET edorpt=1 WHERE folio_cxp='$id'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }
        break;
    case 4: //SELECCIONAR PROVISIONES CXP

        $consulta = "UPDATE w_provision SET edorpt=1 WHERE folio_provi='$id'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }
        break;
    case 5: //SELECCIONAR PROVISIONES GENERALES

        $consulta = "UPDATE w_provisiongral SET edorpt=1 WHERE folio_provi='$id'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }
        break;
    case 6: //SELECCIONAR CXP  GENERALES

        $consulta = "UPDATE w_cxpgral SET edorpt=1 WHERE folio_cxp='$id'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }
        break;

    case 8://provisiones sub
        $consulta = "UPDATE w_provsub SET edorpt=0 WHERE id_provs='$id'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }
        break;
    case 9:// requisiciones
        $consulta = "UPDATE w_reqsub SET edorpt=0 WHERE id_req='$id'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }
        break;
    case 10:// cxp
        $consulta = "UPDATE w_cxp SET edorpt=0 WHERE folio_cxp='$id'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }
        break;
    case 11:// provisiones
        $consulta = "UPDATE w_provision SET edorpt=0 WHERE folio_provi='$id'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res = 1;
        }
        break;

        case 12:// cxp gral
            $consulta = "UPDATE w_cxpgral SET edorpt=0 WHERE folio_cxp='$id'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $res = 1;
            }
            break;

            case 13:// provisiones gral
                $consulta = "UPDATE w_provisiongral SET edorpt=0 WHERE folio_provi='$id'";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $res = 1;
                }
                break;
}




print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
