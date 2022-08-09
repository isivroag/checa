<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$obra = (isset($_POST['obra'])) ? $_POST['obra'] : '';
$estimacion = (isset($_POST['estimacion'])) ? $_POST['estimacion'] : '';
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$folioest = (isset($_POST['folioest'])) ? $_POST['folioest'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$idusuario = (isset($_POST['idusuario'])) ? $_POST['idusuario'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$res = 0;

$consulta = "UPDATE w_tmp_est 
            SET clave_est='$folio', fecha_est='$fecha', descripcion_est='$descripcion',
            estado_est=2 WHERE folio_tmp='$estimacion'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

if ($opcion == 0) {
    $consulta = "INSERT INTO w_est (id_obra,clave_est,fecha_est,descripcion_est,folio_tmp,usuario_alt)
            VALUES('$obra','$folio','$fecha', '$descripcion','$estimacion','$idusuario')";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();

    $consulta = "SELECT * FROM w_est WHERE folio_tmp='$estimacion'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $rw) {
        $folioest = $rw['folio_est'];
    }

    $consulta = "UPDATE w_tmp_est 
            SET folio_est='$folioest' WHERE folio_tmp='$estimacion'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
} else {

}


$consulta = "DELETE FROM w_detalle_est WHERE folio_est='$folioest'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dt = $resultado->fetchAll(PDO::FETCH_ASSOC);


$consulta = "SELECT * FROM w_tmpdetalle_est WHERE folio_tmp='$estimacion'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dt = $resultado->fetchAll(PDO::FETCH_ASSOC);

$suma = 0;
foreach ($dt as $row) {

    $id_renglon = $row['id_renglon'];
    $cantidad = $row['cantidad'];
    $precio = $row['precio'];
    $importe = $row['importe'];


    $suma += $importe;

    $consultain = "INSERT INTO w_detalle_est (folio_est,id_renglon,cantidad,precio,importe) 
    VALUES ('$folioest','$id_renglon','$cantidad','$precio','$importe')";
    $resultadoin = $conexion->prepare($consultain);
    $resultadoin->execute();
}

$consulta = "UPDATE w_est 
SET importe_est='$suma' WHERE folio_est='$folioest'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$res = 1;
print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
