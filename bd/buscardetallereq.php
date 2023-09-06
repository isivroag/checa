<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$consulta = "SELECT * FROM vreq_det where folio_req='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);




print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
