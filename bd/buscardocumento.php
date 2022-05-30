<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$opcdoc = (isset($_POST['opcdoc'])) ? $_POST['opcdoc'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$data = 0;

            switch ($opcdoc) {
                case 'PROVISION SUB':
                    $consulta = "SELECT * FROM vprovsub WHERE id_provs='$id' ";

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
           


$resultadodeto = $conexion->prepare($consulta);
$resultadodeto->execute();
$data = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
