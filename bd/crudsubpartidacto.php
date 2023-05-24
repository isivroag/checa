<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$id_partidacto = (isset($_POST['id_partidacto'])) ? $_POST['id_partidacto'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO subpartidacto (nom_subpartidacto,id_partidacto) VALUES('$nombre','$id_partidacto')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM vsubpartidacto ORDER BY id_subpartidacto DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE subpartidacto SET nom_subpartidacto='$nombre', id_partidacto='$id_partidacto' WHERE id_subpartidacto='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM vsubpartidacto WHERE id_subpartidacto='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3: //baja
        $consulta = "UPDATE subpartidacto SET estado_subpartidacto=0 WHERE id_subpartidacto='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = 1;
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
