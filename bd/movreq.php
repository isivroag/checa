<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';




switch ($opcion) {
    case 1: //alta
        $consulta = "UPDATE requisicion set seleccion=1 where folio_req='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 2:
        $consulta = "UPDATE requisicion set seleccion=0 where folio_req='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 3:
        $consulta = "SELECT monto_req,folio_rpt FROM requisicion WHERE folio_req='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach($data as $row){
            $importe=$row['monto_req'];
            $reporte=$row['folio_rpt'];

        }

        $consulta = "UPDATE requisicion set seleccion=0,generado=0, folio_rpt=0 where folio_req='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "UPDATE reportereq set importe=importe-'$importe' WHERE folio_rpt='$reporte'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;

}

$consulta = "SELECT * FROM vreq WHERE estado_req=1 and generado=0 and terminado=1 ORDER BY id_obra,id_prov,fecha,folio_req";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

?>