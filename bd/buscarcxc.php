<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '';
 $final = (isset($_POST['final'])) ? $_POST['final'] : '';
 $opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
 session_start();
 if ($_SESSION['id_obra'] == null) {
    
    $consulta = "SELECT * FROM vcxc WHERE fecha_cxc BETWEEN '$inicio' AND '$final' and estado_cxc = 1 ORDER BY id_obra,fecha_cxc,folio_cxc";
 }else{
     $id_obra=$_SESSION['id_obra'];
   $consulta = "SELECT * FROM vcxc WHERE id_obra='$id_obra' AND fecha_cxc BETWEEN '$inicio' AND '$final' and estado_cxc = 1 ORDER BY id_obra,fecha_cxc,folio_cxc";
   // $consulta = "SELECT * FROM vcxc WHERE fecha_cxc BETWEEN '$inicio' AND '$final' and estado_cxc = 1 ORDER BY id_obra,fecha_cxc,folio_cxc";
 }
 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;  
 ?>