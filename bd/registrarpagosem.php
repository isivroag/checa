<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$foliosemanal = (isset($_POST['foliosemanal'])) ? $_POST['foliosemanal'] : '';

$tipodoc = (isset($_POST['tipodoc'])) ? $_POST['tipodoc'] : '';

$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';
$montopago = (isset($_POST['montopago'])) ? $_POST['montopago'] : '';

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$id_reg = (isset($_POST['id_reg'])) ? $_POST['id_reg'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$data = 0;

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO semanal_detalle (folio_rpt,tipo,folio,observaciones,monto,aplicado) VALUES('$foliosemanal','$tipodoc','$id','$obs','$montopago','0') ";
        $resultado = $conexion->prepare($consulta);




        if ($resultado->execute()) {

            switch ($tipodoc) {
                case 'PROVISION SUB':
                    $consulta = "UPDATE w_provsub SET edorpt=2 WHERE id_provs ='$id'";
                    break;
                case 'REQUISICION':
                    $consulta = "UPDATE w_reqsub SET edorpt=2 WHERE id_req ='$id'";
                    break;
                case 'CXP':
                    $consulta = "UPDATE w_cxp SET edorpt=2 WHERE folio_cxp ='$id'";
                    break;
                case 'PROVISION':
                    $consulta = "UPDATE w_provision SET edorpt=2 WHERE folio_provi ='$id'";
                    break;
                case 'CXP GRAL':
                    $consulta = "UPDATE w_cxpgral SET edorpt=2 WHERE folio_cxp ='$id'";
                    break;
                case 'PROVISION GRAL':
                    $consulta = "UPDATE w_provisiongral SET edorpt=2 WHERE folio_provi ='$id'";
                    break;
            }
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $data = 1;
            $consulta = "SELECT SUM(monto) as total from semanal_detalle where folio_rpt='$foliosemanal' group by folio_rpt";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $res = $resultado->fetchAll(PDO::FETCH_ASSOC);

                foreach ($res as $reg) {
                    $total = $reg['total'];
                }
                $consulta = "UPDATE semanal set total='$total' where folio='$foliosemanal'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
            }
        }



        break;
    case 2: //modificación

        break;
    case 3: //baja
        $consulta = "DELETE FROM semanal_detalle where id_reg='$id_reg' ";
        $resultado = $conexion->prepare($consulta);




        if ($resultado->execute()) {

            switch ($tipodoc) {
                case 'PROVISION SUB':
                    $consulta = "UPDATE w_provsub SET edorpt=1 WHERE id_provs ='$id'";
                    break;
                case 'REQUISICION':
                    $consulta = "UPDATE w_reqsub SET edorpt=1 WHERE id_req ='$id'";
                    break;
                case 'CXP':
                    $consulta = "UPDATE w_cxp SET edorpt=1 WHERE folio_cxp ='$id'";
                    break;
                case 'PROVISION':
                    $consulta = "UPDATE w_provision SET edorpt=1 WHERE folio_provi ='$id'";
                    break;
                case 'CXP GRAL':
                    $consulta = "UPDATE w_cxpgral SET edorpt=1 WHERE folio_cxp ='$id'";
                    break;
                case 'PROVISION GRAL':
                    $consulta = "UPDATE w_provisiongral SET edorpt=1 WHERE folio_provi ='$id'";
                    break;
            }
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $data = 1;
            $consulta = "SELECT SUM(monto) as total from semanal_detalle where folio_rpt='$foliosemanal' group by folio_rpt";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $res = $resultado->fetchAll(PDO::FETCH_ASSOC);
            $total=0;
            foreach ($res as $reg) {
                $total = $reg['total'];
            }
            $consulta = "UPDATE semanal set total='$total' where folio='$foliosemanal'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
        }
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
