<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$razon = (isset($_POST['razon'])) ? $_POST['razon'] : '';

$rfc = (isset($_POST['rfc'])) ? $_POST['rfc'] : '';

$dir = (isset($_POST['dir'])) ? $_POST['dir'] : '';


$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


$id_pros = (isset($_POST['id_pros'])) ? $_POST['id_pros'] : '';
$id_cita = (isset($_POST['id_cita'])) ? $_POST['id_cita'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO w_empresa (rfc_emp,razon_emp,dir_emp) VALUES('$rfc','$razon','$dir') ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM w_empresa ORDER BY id_emp DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE w_empresa SET razon_emp='$razon',rfc_emp='$rfc',dir_emp='$dir' WHERE id_emp='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM w_empresa WHERE id_emp='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE w_empresa SET estado_emp=0 WHERE id_emp='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;   
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
