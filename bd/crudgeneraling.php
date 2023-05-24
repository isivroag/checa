<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   



$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$obra = (isset($_POST['obra'])) ? $_POST['obra'] : '';
$cxc = (isset($_POST['cxc'])) ? $_POST['cxc'] : '';
$pago = (isset($_POST['pago'])) ? $_POST['pago'] : '';
$subpartida = (isset($_POST['subpartida'])) ? $_POST['subpartida'] : '';
$importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$data=0;
switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO gral_ing (id_obra,id_cxc,id_pagocxc,id_subpartida,monto) 
        VALUES('$obra','$cxc','$pago','$subpartida','$importe')";
        $resultado = $conexion->prepare($consulta);
       if ( $resultado->execute()){
        $data=1;
       }

       
        
        break;
    case 2: //modificación
       
 
        $consulta = "UPDATE gral_ing SET estado_reg=0 WHERE id_reg='$id' ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $data = 1;
        }
        
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
