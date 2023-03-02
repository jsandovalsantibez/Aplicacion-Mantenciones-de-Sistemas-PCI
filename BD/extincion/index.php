<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
$servidor = "localhost"; $usuario = "root"; $contrasenia = "@@Macc22"; $nombreBaseDatos = "ingelecsa";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);
if(isset($_GET["insertar"])){
    
    $data = json_decode(file_get_contents("php://input"));

    $sqlTienda = mysqli_query($conexionBD,"SELECT cod_tienda FROM tienda WHERE nombre_tienda='$data'");
    $cod_tienda = mysqli_fetch_Column($sqlTienda);

    $sqlExtincion = mysqli_query($conexionBD,"SELECT extincion.id_ext, extincion.localizacion, extincion.estado, tienda.cod_tienda FROM tienda INNER JOIN datos_central ON
    tienda.cod_tienda = datos_central.cod_tienda INNER JOIN extincion ON datos_central.modelo = extincion.modelo WHERE tienda.cod_tienda='$cod_tienda'");
    
    if(mysqli_num_rows($sqlExtincion) > 0){
        $Extincion = mysqli_fetch_all($sqlExtincion,MYSQLI_ASSOC);
        echo json_encode($Extincion);
        exit();
    }
    else{ echo json_encode([["success"=>0]]); }
    
    
}
if(isset($_GET["update1"])){
    $data = json_decode(file_get_contents("php://input"));

    
    $id = $data->id;
    $loca = $data->loca;
    $tienda = $data->tienda;

    $sqlActualizar = mysqli_query($conexionBD, "UPDATE extincion SET estado='Revisado', detalle='' WHERE id_ext='$id' AND localizacion='$loca'");

    $sqlExtincion = mysqli_query($conexionBD,"SELECT extincion.id_ext, extincion.localizacion, extincion.estado, tienda.cod_tienda FROM tienda INNER JOIN datos_central ON
    tienda.cod_tienda = datos_central.cod_tienda INNER JOIN extincion ON datos_central.modelo = extincion.modelo WHERE tienda.cod_tienda='$tienda'");
    
    if(mysqli_num_rows($sqlExtincion) > 0){
        $Extincion = mysqli_fetch_all($sqlExtincion,MYSQLI_ASSOC);
        echo json_encode($Extincion);
        exit();
    }
    else{ echo json_encode([["success"=>0]]); }

    
}

if(isset($_GET["update2"])){
    
    $data = json_decode(file_get_contents("php://input"));

    $Id = $data->Id;
    $detalle = $data->detalle;
    $loca = $data->localizacion;
    $cod_tienda = $data->cod_tienda;

    $sqlActualizar = mysqli_query($conexionBD, "UPDATE extincion SET estado='No Aplica', detalle='$detalle' WHERE id_ext='$Id' AND localizacion='$loca'");

    $sqlExtincion = mysqli_query($conexionBD,"SELECT extincion.id_ext, extincion.localizacion, extincion.estado, tienda.cod_tienda FROM tienda INNER JOIN datos_central ON
    tienda.cod_tienda = datos_central.cod_tienda INNER JOIN extincion ON datos_central.modelo = extincion.modelo WHERE tienda.cod_tienda='$cod_tienda'");
    
    if(mysqli_num_rows($sqlExtincion) > 0){
        $Extincion = mysqli_fetch_all($sqlExtincion,MYSQLI_ASSOC);
        echo json_encode($Extincion);
        exit();
    }
    else{ echo json_encode([["success"=>0]]); }


}


?>