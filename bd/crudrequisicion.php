

<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
session_start();
$usuarioalt = $_SESSION['s_nombre'];

// Recepción de los datos enviados mediante POST desde el JS   
$folioreq = (isset($_POST['folioreq'])) ? $_POST['folioreq'] : '';
$subcontrato = (isset($_POST['subcontrato'])) ? $_POST['subcontrato'] : '';

$descripcionreq = (isset($_POST['descripcionreq'])) ? $_POST['descripcionreq'] : '';
$clavereq = (isset($_POST['clavereq'])) ? $_POST['clavereq'] : '';
$fechareq = (isset($_POST['fechareq'])) ? $_POST['fechareq'] : '';
$montoreq = (isset($_POST['montoreq'])) ? $_POST['montoreq'] : '';
$subtotalreq = (isset($_POST['subtotalreq'])) ? $_POST['subtotalreq'] : '';
$ivareq = (isset($_POST['ivareq'])) ? $_POST['ivareq'] : '';
$idprovision = (isset($_POST['idprovision'])) ? $_POST['idprovision'] : '';


$opcionreq = (isset($_POST['opcionreq'])) ? $_POST['opcionreq'] : '';

$ret1 = (isset($_POST['ret1'])) ? $_POST['ret1'] : '';
$ret2 = (isset($_POST['ret2'])) ? $_POST['ret2'] : '';
$ret3 = (isset($_POST['ret3'])) ? $_POST['ret3'] : '';

$importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';
$descuento = (isset($_POST['descuento'])) ? $_POST['descuento'] : '';
$devolucion = (isset($_POST['devolucion'])) ? $_POST['devolucion'] : '';
//$ret4 = (isset($_POST['ret4'])) ? $_POST['ret4'] : '';
$montob = (isset($_POST['montob'])) ? $_POST['montob'] : '';
$forigen = (isset($_POST['forigen'])) ? $_POST['forigen'] : '';
$uuid = (isset($_POST['uuid'])) ? $_POST['uuid'] : '';



$data = 0;
switch ($opcionreq) {
    case 1: //alta
        $consulta = "INSERT INTO w_reqsub (id_sub,fecha_req,factura_req,concepto_req,monto_req,saldo_req,subtotal_req,iva_req,id_provs,usuarioalt,ret1,ret2,ret3,montob,importe,descuento,devolucion,uuid) 
        VALUES('$subcontrato','$fechareq','$clavereq','$descripcionreq','$montoreq','$montoreq','$subtotalreq','$ivareq','$idprovision','$usuarioalt','$ret1','$ret2','$ret3','$montob','$importe','$descuento','$devolucion','$uuid') ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;

            if ($idprovision != "") {
                //$consulta = "UPDATE w_provsub SET saldo_prov=saldo_prov-'$montoreq' WHERE id_provs='$idprovision'";
                $montoabono = round($importe * 1.16, 2, PHP_ROUND_HALF_UP);
                $consulta = "UPDATE w_provsub SET saldo_prov=saldo_prov-'$montoabono' WHERE id_provs='$idprovision'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();

                $consulta = "SELECT saldo_prov FROM w_provsub WHERE id_provs='$idprovision'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);;
                $saldoprov = 1;

                foreach ($datos as $row) {
                    $saldoprov = $row['saldo_prov'];
                }

                if ($saldoprov == 0) {
                    $consulta = "UPDATE w_provsub SET estado=2 WHERE id_provs='$idprovision'";
                    $resultado = $conexion->prepare($consulta);
                    $resultado->execute();
                }
            }
        }



        break;
    case 2: //modificación
        $consulta = "UPDATE w_reqsub SET  id_sub='$id_sub',fecha_reg='$fechareq',concepto_req='$descripcionreq',factura_req='$clavereq',monto_req='$montoreq',saldo_req='$montoreq',subtotal_req='$subtotalreq',
        iva_req='$ivareq' WHERE folio_req='$folioreq' ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
        }


        break;
    case 3: //baja
        $consulta = "UPDATE w_reqsub SET estado_req=0 WHERE folio_req='$folioreq'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
        }

        break;

    case 4:

        $consulta = "INSERT INTO w_reqsub (id_sub,fecha_req,factura_req,concepto_req,monto_req,saldo_req,subtotal_req,iva_req,id_provs,usuarioalt,ret1,ret2,ret3,montob,importe,descuento,devolucion,uuid) 
        VALUES('$subcontrato','$fechareq','$clavereq','$descripcionreq','$montoreq','$montoreq','$subtotalreq','$ivareq','$idprovision','$usuarioalt','$ret1','$ret2','$ret3','$montob','$importe','$descuento','$devolucion','$uuid') ";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;

            //busca el registro agregado en requisicion

            $consulta = "SELECT * from w_reqsub where id_provs='$idprovision' ORDER BY id_req DESC LIMIT 1 ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);
            foreach ($datos as $row) {
                $folioreq = $row['id_req'];
                $foliosub = $row['id_sub'];
            }


            if ($idprovision != "") {
                //$consulta = "UPDATE w_provsub SET saldo_prov=saldo_prov-'$montoreq' WHERE id_provs='$idprovision'";
                $montoabono = round($importe * 1.16, 2, PHP_ROUND_HALF_UP);
                $consulta = "UPDATE w_provsub SET saldo_prov=saldo_prov-'$montoabono' WHERE id_provs='$idprovision'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();

                $consulta = "SELECT saldo_prov FROM w_provsub WHERE id_provs='$idprovision'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);
                $saldoprov = 1;

                foreach ($datos as $row) {
                    $saldoprov = $row['saldo_prov'];
                }

                if ($saldoprov == 0) {
                    $consulta = "UPDATE w_provsub SET estado=2 WHERE id_provs='$idprovision'";
                    $resultado = $conexion->prepare($consulta);
                    $resultado->execute();
                }


                //registrar el pago


                $fechavp = (isset($_POST['fechavp'])) ? $_POST['fechavp'] : '';
                $observacionesvp = (isset($_POST['observacionesvp'])) ? $_POST['observacionesvp'] : '';
                $referenciavp = (isset($_POST['referenciavp'])) ? $_POST['referenciavp'] : '';

                $montovp = (isset($_POST['montovp'])) ? $_POST['montovp'] : '';

                $metodovp = (isset($_POST['metodovp'])) ? $_POST['metodovp'] : '';
                $usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
                $opcionpago = (isset($_POST['opcionpago'])) ? $_POST['opcionpago'] : '';




                $res = 0;





                $consulta = "INSERT INTO w_pagors (id_req,fecha_pagors,referencia_pagors,observaciones_pagors,metodo_pagors,monto_pagors,usuario) VALUES ('$folioreq','$fechavp','$referenciavp','$observacionesvp','$metodovp','$montovp','$usuario')";
                $resultado = $conexion->prepare($consulta);

                if ($resultado->execute()) {
                    //aqui empieza el error
                    $consulta = "UPDATE w_reqsub SET saldo_req=0 where id_req='$folioreq'";
                    $resultado = $conexion->prepare($consulta);
                    if ($resultado->execute()) {


                        $consulta = "UPDATE w_subcontrato SET saldo_sub=saldo_sub - '$montovp' where folio_sub='$foliosub'";
                        $resultado = $conexion->prepare($consulta);
                        if ($resultado->execute()) {
                            $res = 1;
                        } else {
                            $res = 2;
                        }
                        //falta actualizar el registro del reporte semanal

                        $consulta = "UPDATE semanal_detalle SET aplicado=1 where id_reg='$forigen'";
                        $resultado = $conexion->prepare($consulta);
                        $resultado->execute();


                        $consulta = "SELECT folio_rpt from semanal_detalle WHERE id_reg='$forigen'";
                        $resultado = $conexion->prepare($consulta);
                        $resultado->execute();
                        $reg = $resultado->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($reg as $row) {
                            $folioreporte = $row['folio_rpt'];
                        }


                        $consulta = "SELECT * FROM semanal_detalle where folio_rpt='$folioreporte' and aplicado=0";
                        $resultado = $conexion->prepare($consulta);
                        $resultado->execute();
                        if ($resultado->rowCount() == 0) {
                            $consulta = "UPDATE semanal SET activo=3 where folio='$folioreporte'";
                            $resultado = $conexion->prepare($consulta);
                            $resultado->execute();
                        }
                    } else {
                        $res = 2;
                    }
                }
            }
        }
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
