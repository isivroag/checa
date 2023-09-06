<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
ini_set('precision', 6);
// Recepción de los datos enviados mediante POST desde el JS   

$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';

$importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';

$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

$folio=0;

$res = 0;
switch($opcion){
    case 1:
        $consulta = "INSERT INTO reportereq (fecha,importe,usuarioalt) 
        VALUES ('$fecha','$importe','$usuario')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM reportereq ORDER BY folio_rpt DESC limit 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row){
            $folio=$row['folio_rpt'];
        }

        $consulta = "UPDATE requisicion SET generado=1, folio_rpt='$folio',seleccion=2 where seleccion=1 and generado=0";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $res=$folio;
        break;

    case 2:
      
        break;


}
        //guardar el pago
        
       

       
        print json_encode($res, JSON_UNESCAPED_UNICODE);
        $conexion = NULL;
     