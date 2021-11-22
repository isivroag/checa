<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '';
 $final = (isset($_POST['final'])) ? $_POST['final'] : '';
 $opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
 $obra = (isset($_POST['obra'])) ? $_POST['obra'] : '';
 session_start();
 if ($obra == null) {
     
    $consulta = "SELECT * FROM vnomina WHERE fecha_ini BETWEEN '$inicio' AND '$final' and estado_nom = 1 ORDER BY id_obra,id_nom";
 }else{
   
    $consulta = "SELECT * FROM vnomina WHERE id_obra='$obra' AND  fecha_ini BETWEEN '$inicio' AND '$final' and estado_nom = 1 ORDER BY id_obra,id_nom";
 }
 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;  
 ?>