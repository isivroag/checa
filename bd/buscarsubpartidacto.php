<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$partida = (isset($_POST['partida'])) ? $_POST['partida'] : '';


        $consulta = "SELECT * FROM subpartidacto WHERE id_partidacto='$partida' and estado_subpartidacto=1 order by id_subpartidacto ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        if($resultado->execute()){
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $data=null;
        }

print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
