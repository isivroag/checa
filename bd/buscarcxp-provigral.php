<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $id = (isset($_POST['folio'])) ? $_POST['folio'] : '';
 
 

   $consulta = "SELECT * FROM w_cxpgral WHERE folio_provi='$id' AND estado_cxp= 1 ORDER BY fecha_cxp,folio_cxp";


 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;  
 ?>