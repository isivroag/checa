<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$banco = (isset($_POST['banco'])) ? $_POST['banco'] : '';
$cuenta = (isset($_POST['cuenta'])) ? $_POST['cuenta'] : '';
$clabe = (isset($_POST['clabe'])) ? $_POST['clabe'] : '';
$tarjeta = (isset($_POST['tarjeta'])) ? $_POST['tarjeta'] : '';
$idprovcuenta = (isset($_POST['idprovcuenta'])) ? $_POST['idprovcuenta'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO w_cuentaprov (id_prov,banco,cuenta,clabe,tarjeta) VALUES('$idprovcuenta','$banco','$cuenta','$clabe','$tarjeta')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM w_cuentaprov WHERE id_prov='$idprovcuenta' ORDER BY w_cuentaprov DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE w_cuentaprov SET banco='$banco',cuenta='$cuenta',clabe='$clabe',tarjeta='$tarjeta' WHERE id_cuentaprov='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM w_cuentaprov WHERE w_cuentaprov='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3: //baja
        $consulta = "UPDATE w_cuentaprov SET estado_cuentaprov=0 WHERE id_cuentaprov='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = 1;
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
