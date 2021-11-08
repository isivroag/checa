<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';
 
 $data=0;
 
    $consulta = "SELECT * FROM w_subcontrato WHERE clave_sub='$clave' AND estado_sub = 1";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    if($resultado->rowCount() >=1){
       $data=1;
    }

 
 
 
 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;  
 ?>