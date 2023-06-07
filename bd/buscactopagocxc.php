<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $obra = (isset($_POST['obra'])) ? $_POST['obra'] : '';
 $cxc = (isset($_POST['cxc'])) ? $_POST['cxc'] : '';
 $pago = (isset($_POST['pago'])) ? $_POST['pago'] : '';
 $opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

 
 
 $consulta = "SELECT * FROM vconsultacostopagocxc WHERE id_obra='$obra' and folio_cxc='$cxc' and folio_pagocxc='$pago' order by id_partida";
 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 if($resultado->rowCount() >=1){
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 }
    else{
      $data=0;  
 }

 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;
