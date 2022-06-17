<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $id_pros = (isset($_POST['id_pros'])) ? $_POST['id_pros'] : '';

 
 $data=0;

 
        $consulta = "SELECT * from prospecto where id_pros='$id_pros'";			
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
            
         

        }
         


 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;  
 ?>