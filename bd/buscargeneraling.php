<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $obra = (isset($_POST['obra'])) ? $_POST['obra'] : '';
 $cxc = (isset($_POST['cxc'])) ? $_POST['cxc'] : '';
 $pago = (isset($_POST['pago'])) ? $_POST['pago'] : '';



   
$consulta = "SELECT * FROM vgral_ing WHERE id_obra='$obra' AND  id_cxc='$cxc' and id_pagocxc='$pago'
  ORDER BY id_partidacto,id_subpartida";

 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;  
 ?>