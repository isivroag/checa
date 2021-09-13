<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$id_tipo = (isset($_POST['id_tipo'])) ? $_POST['id_tipo'] : '';
$id_concepto = (isset($_POST['id_concepto'])) ? $_POST['id_concepto'] : '';
$costo_concepto = (isset($_POST['costo'])) ? $_POST['costo'] : '';
$precio_concepto = (isset($_POST['precio'])) ? $_POST['precio'] : '';


$concepto = $concepto;

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO concepto (nom_concepto,id_t_concepto,costo_concepto,precio_concepto) VALUES('$concepto','$id_tipo','$costo_concepto','$precio_concepto')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM vconcepto ORDER BY id_concepto DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE concepto SET nom_concepto='$concepto',costo_concepto='$costo_concepto',id_t_concepto='$id_tipo',precio_concepto='$precio_concepto' WHERE id_concepto='$id_concepto'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM vconcepto WHERE id_concepto='$id_concepto'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3: //baja
        $consulta = "UPDATE concepto SET estado_concepto=0 WHERE id_concepto='$id_concepto' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = 1;
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
