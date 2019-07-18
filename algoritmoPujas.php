<?php
/**
 * Created by PhpStorm.
 * User: lalo
 * Date: 09/08/18
 * Time: 7:36 PM
 */
require_once('utilidades/ConexionBD.php');
require_once('algoritmoPuja/ganador.php');
require_once('algoritmoPuja/auto.php');

$usuariosGanados = array();
$subasta = 30;
$autos = autosPorSubasta($subasta);
$gananciaTotal = 0;
$autosPermitidos = 2;

foreach ($autos as &$auto) {
    $ganador = usuarioGanadorPorAuto($subasta,$auto->idAuto);
    $ganancia = calcularGanancia($auto,$ganador);
    $gananciaTotal += $ganancia;
    if(!isset($usuariosGanados[$ganador->idUsuario])){
        $usuariosGanados[$ganador->idUsuario] = 0;
    }
    $usuariosGanados[$ganador->idUsuario] ++;


    echo "AUTO: ".$auto . "<br>";
    echo "GANADOR:".$ganador."<br>";
    echo "GANANCIA:".$ganancia . "<br>";
}

print_r($usuariosGanados);
echo "<br>"."GANANCIA TOTAL:".$gananciaTotal . "<br>";


$usuariosConMasGanados = usuariosConMasGanados($usuariosGanados,$autosPermitidos);
print_r($usuariosConMasGanados);

function usuariosConMasGanados($usuariosGanados,$autosPermitidos){
    $usuariosConMas = array();
    foreach ($usuariosGanados as $key => $value){
        if ($value > $autosPermitidos){
            $usuariosConMas[$key] = $value;
        }
    }
    return $usuariosConMas;
}


function calcularGanancia($auto,$ganador){
    return  $ganador->oferta - $auto->precio;
}


function usuarioGanadorPorAuto($idSubasta,$idAuto,$idsPujas = "''")
{
    try {
        $comando = "SELECT ap.idPuja as idPuja, ap.oferta as oferta, ap.idUsuario as idUsuario
                    FROM escuderia_subastas.autos_puja ap 
                    where ap.idSubasta = ? and ap.idAuto = ?
                    and ap.oferta = (SELECT max( ap.oferta )
                    FROM escuderia_subastas.autos_puja ap 
                    where ap.idSubasta = ? and ap.idAuto = ? and idPuja not in (?))";
        $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
        $sentencia = $pdo->prepare($comando);

        $sentencia->bindParam(1, $idSubasta);
        $sentencia->bindParam(2, $idAuto);
        $sentencia->bindParam(3, $idSubasta);
        $sentencia->bindParam(4, $idAuto);
        $sentencia->bindParam(5, $idsPujas);

        $sentencia->setFetchMode(PDO::FETCH_CLASS,ganador::class);

        $resultado = $sentencia->execute();
        return $sentencia->fetch();

    } catch (Excepcion $e) {
        print_r($e);
        return null;
    }
}

function autosPorSubasta($idSubasta)
{
    try {
        $comando = "SELECT au.idAuto,au.precio
                    FROM escuderia_subastas.subastas_autos sa 
                    left join escuderia_subastas.autos au on au.idAuto = sa.autoId
                    where sa.subastaId = ?";
        $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
        $sentencia = $pdo->prepare($comando);

        $sentencia->bindParam(1, $idSubasta);

        $resultado = $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_CLASS,auto::class);

    } catch (Excepcion $e) {
        print_r($e);
        return null;
    }
}


?>