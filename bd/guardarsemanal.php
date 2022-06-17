<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$foliosemanal = (isset($_POST['foliosemanal'])) ? $_POST['foliosemanal'] : '';

$fecha_ini = (isset($_POST['fechaini'])) ? $_POST['fechaini'] : '';
$fecha_fin = (isset($_POST['fechafin'])) ? $_POST['fechafin'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


$data=0;
switch($opcion){
    case 1: //alta
        $consulta = "UPDATE semanal SET fecha_ini='$fecha_ini',fecha_fin='$fecha_fin' WHERE folio='$foliosemanal'";
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        } 

        
        break;
    case 2: //modificación
        $consulta = "UPDATE semanal SET fecha_ini='$fecha_ini',fecha_fin='$fecha_fin',activo='2' WHERE folio='$foliosemanal' ";		
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $data=1;
        }
        
        
        break;        
    case 3://baja
       
        break;   
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;