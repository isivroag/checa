<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$foliosubcob = (isset($_POST['foliosubcob'])) ? $_POST['foliosubcob'] : '';

$montocobrado = (isset($_POST['montocobrado'])) ? $_POST['montocobrado'] : '';


$res = 0;

        //guardar el pago
        $consulta = "UPDATE w_subcontrato SET cobrado_sub='$montocobrado' WHERE folio_sub='$foliosubcob'";
        $resultado = $conexion->prepare($consulta);

        if ($resultado->execute()) {
            $res = 1;
              
        } else {
            $res = 0;
        }
        print json_encode($res, JSON_UNESCAPED_UNICODE);
        $conexion = NULL;
     