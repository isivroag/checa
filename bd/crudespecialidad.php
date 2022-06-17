<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$especialidad = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';

$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO especialidad (nom_especialidad) VALUES('$especialidad')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM especialidad ORDER BY id_especialidad DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE especialidad SET nom_especialidad='$especialidad' WHERE id_especialidad='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM especialidad WHERE id_especialidad='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3: //baja
        $consulta = "UPDATE especialidad SET estado_especialidad=0 WHERE id_especialidad='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = 1;
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
