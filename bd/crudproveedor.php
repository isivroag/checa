<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$rfc = (isset($_POST['rfc'])) ? $_POST['rfc'] : '';
$razon = (isset($_POST['razon'])) ? $_POST['razon'] : '';
$dir = (isset($_POST['dir'])) ? $_POST['dir'] : '';
$tel = (isset($_POST['tel'])) ? $_POST['tel'] : '';
$contacto = (isset($_POST['contacto'])) ? $_POST['contacto'] : '';
$tel_contacto = (isset($_POST['tel_contacto'])) ? $_POST['tel_contacto'] : '';
$especialidad = (isset($_POST['especialidad'])) ? $_POST['especialidad'] : '';
$correo = (isset($_POST['correo'])) ? $_POST['correo'] : '';
$puntaje = (isset($_POST['puntaje'])) ? $_POST['puntaje'] : '';

$id = (isset($_POST['id'])) ? $_POST['id'] : '';




$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO w_proveedor (rfc_prov,razon_prov,dir_prov,tel_prov,contacto_prov,telcon_prov,especialidad,correo_prov,puntaje) VALUES('$rfc','$razon','$dir','$tel','$contacto','$tel_contacto','$especialidad','$correo','$puntaje') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM w_proveedor ORDER BY id_prov DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE w_proveedor SET rfc_prov='$rfc',razon_prov='$razon',dir_prov='$dir', tel_prov='$tel', contacto_prov='$contacto',telcon_prov='$tel_contacto',especialidad='$especialidad',correo_prov='$correo',puntaje='$puntaje' WHERE id_prov='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM w_proveedor WHERE id_prov='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE w_proveedor SET estado_prov=0 WHERE id_prov='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
