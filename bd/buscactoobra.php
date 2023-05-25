<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $obra = (isset($_POST['obra'])) ? $_POST['obra'] : '';
 $opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

 
 
 $consulta = "SELECT * FROM vconsultacosto WHERE id_obra='$obra' order by id_partida";
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
