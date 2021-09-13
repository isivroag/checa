<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$tel = (isset($_POST['tel'])) ? $_POST['tel'] : '';
$cel = (isset($_POST['cel'])) ? $_POST['cel'] : '';
$contacto = (isset($_POST['contacto'])) ? $_POST['contacto'] : '';
$tel_contacto = (isset($_POST['tel_contacto'])) ? $_POST['tel_contacto'] : '';

$id = (isset($_POST['id'])) ? $_POST['id'] : '';




$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO prospecto (nombre,tel,cel,contacto,tel_contacto) VALUES('$nombre','$tel','$cel','$contacto','$tel_contacto') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM prospecto ORDER BY id_pros DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE prospecto SET nombre='$nombre', tel='$tel', cel='$cel',contacto='$contacto',tel_contacto='$tel_contacto' WHERE id_pros='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM prospecto WHERE id_pros='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE prospecto SET estado_pros=0 WHERE id_pros='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
