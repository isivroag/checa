
<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$tipomov = (isset($_POST['tipomov'])) ? $_POST['tipomov'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$montomov = (isset($_POST['montomov'])) ? $_POST['montomov'] : '';
$descmov = (isset($_POST['descmov'])) ? $_POST['descmov'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';






$res = 0;
$consulta = "SELECT * from vcaja where id_caja='$folio'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $rowdata) {
        $saldo = $rowdata['saldo_caja'];
    }
    $res += 1;
    switch ($tipomov) {

        case "Reposicion":

            $saldofin = $saldo + $montomov;
            break;

        case "Ajuste Negativo":

            $saldofin = $saldo - $montomov;
            break;
        case "Ajuste Positivo":

            $saldofin = $saldo + $montomov;
            break;
        case "Cancelacion Pago":

            $saldofin = $saldo + $montomov;
            break;
            case "Egreso":

                $saldofin = $saldo - $montomov;
                break;
        case "Saldo Inicial":
            $saldofin = $montomov;
            break;
    }
    //guardar el movimiento
    $consulta = "INSERT INTO mov_caja(id_caja,tipo_mov,fecha_mov,obs_mov,monto_mov,saldo_ini,saldo_fin,usuarioalt) 
                values('$folio','$tipomov','$fecha','$descmov','$montomov','$saldo','$saldofin','$usuario')";
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()) {
        $res += 1;
        $consulta = "UPDATE w_caja SET saldo_caja='$saldofin' WHERE id_caja='$folio'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $res += 1;
        }
    }
}





print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;

?>