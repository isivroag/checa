<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch($opcion){
    case 1:
        $consulta = "";
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        }
        
    break;
    case 2:
        $consulta = "SELECT * FROM vcxc WHERE folio_cxc='$folio' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        if($resultado->execute()){
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $data=null;
        }
    break;
    
}

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
