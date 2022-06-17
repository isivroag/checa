<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '';
 $final = (isset($_POST['final'])) ? $_POST['final'] : '';
 
 $opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
 $consulta = "SELECT * FROM vprovisiongral WHERE fecha_provi BETWEEN '$inicio' AND '$final' ORDER BY folio_provi";
 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;  
 ?>