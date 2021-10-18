<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $id = (isset($_POST['id'])) ? $_POST['id'] : '';
 
 
 
 $consulta = "SELECT * FROM w_cuentaprov WHERE id_prov='$id' and estado_cuentaprov = 1 ORDER BY id_cuentaprov";
 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;  
 ?>