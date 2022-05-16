<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 $res=0;
 $consulta = "SELECT * FROM vpreseleccion  UNION  SELECT * FROM vpreselecciongral ORDER BY id_obra";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    if($resultado->rowCount() >= 1){
       $res=$resultado->fetchAll(PDO::FETCH_ASSOC);

    }

 
 
 
 print json_encode($res, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;
