<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$total = 0;



        $consulta = "SELECT monto_req from requisicion 
                    where folio_req='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $total=0;
        foreach ($data as $row) {
            $total+=$row['monto_req'];
        }


 

print json_encode($total, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
