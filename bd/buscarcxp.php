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
     
    $consulta = "SELECT * FROM vcxp WHERE fecha_cxp BETWEEN '$inicio' AND '$final' and estado_cxp = 1 ORDER BY id_obra,id_prov,fecha_cxp,folio_cxp";
 }else{
    $id_obra=$_SESSION['id_obra'];
    $consulta = "SELECT * FROM vcxp WHERE id_obra='$id_obra' AND fecha_cxp BETWEEN '$inicio' AND '$final' and estado_cxp = 1 ORDER BY id_obra,id_prov,fecha_cxp,folio_cxp";
 }
 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;  
 ?>