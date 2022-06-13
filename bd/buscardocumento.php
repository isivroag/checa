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
                    
                    break;
                case 'CXP':
                    
                    break;
                case 'PROVISION':
                    $consulta = "SELECT * FROM vprovision WHERE folio_provi='$id'";
                    break;
                case 'CXP GRAL':
                    
                    break;
                case 'PROVISION GRAL':
                    $consulta = "SELECT * FROM vprovisiongral WHERE folio_provi='$id'";
                    break;
            }
           


$resultadodeto = $conexion->prepare($consulta);
$resultadodeto->execute();
$data = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
