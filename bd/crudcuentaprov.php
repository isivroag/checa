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
$cuentadefault = (isset($_POST['cuentadefault'])) ? $_POST['cuentadefault'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch ($opcion) {
    case 1: //alta
        if ($cuentadefault==1){
            $consulta = "UPDATE w_cuentaprov SET cuentadefault='0' where id_prov='$idprovcuenta'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
        }else{
            $consulta = "SELECT * from w_cuentaprov where id_prov='$idprovcuenta' and cuentadefault='1'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            if ($resultado->rowCount()==0){
                $cuentadefault=1;
            }
        }


        $consulta = "INSERT INTO w_cuentaprov (id_prov,banco,cuenta,clabe,tarjeta,cuentadefault) VALUES('$idprovcuenta','$banco','$cuenta','$clabe','$tarjeta','$cuentadefault')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM w_cuentaprov WHERE id_prov='$idprovcuenta' ORDER BY w_cuentaprov DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación

        if ($cuentadefault==1){
            $consulta = "UPDATE w_cuentaprov SET cuentadefault='0' where id_prov='$idprovcuenta'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
        }else{
            $consulta = "SELECT * from w_cuentaprov where id_prov='$idprovcuenta' and cuentadefault='1'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            if ($resultado->rowCount()==0){
                $cuentadefault=1;
            }
        }
        $consulta = "UPDATE w_cuentaprov SET banco='$banco',cuenta='$cuenta',clabe='$clabe',tarjeta='$tarjeta',cuentadefault='$cuentadefault' WHERE id_cuentaprov='$id'";
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
