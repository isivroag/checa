
<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$foliosemanal = (isset($_POST['foliosemanal'])) ? $_POST['foliosemanal'] : '';



$data=0;
$consultadeto = "SELECT * FROM vdetallesemanal where folio_rpt='$foliosemanal' and estado=1 order by id_reg";
$resultadodeto = $conexion->prepare($consultadeto);
$resultadodeto->execute();
$data = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);


print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;


