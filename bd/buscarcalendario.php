<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $fechad = (isset($_POST['fechad'])) ? $_POST['fechad'] : '';

 
 
 $consulta = "SELECT id,id_pros,tipo_p,title,descripcion,date(start) as fecha,time(start) as hora,nombre,color,estado,confirmar FROM vcitap2 WHERE date(start)='$fechad' ORDER BY start";
 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;
