<?php
session_start();
require_once("views/VistaApi.php");
require_once("views/VistaJson.php");
require_once("modelos/usuarios.php");
require_once("modelos/categorias.php");
require_once("modelos/empresas.php");
require_once("modelos/tiposubastas.php");
require_once("modelos/subastas.php");
require_once("modelos/subasta-empresa.php");
require_once("modelos/cotizacion.php");
require_once("modelos/cotizacion-servicios.php");
require_once("modelos/servicios.php");
require_once("modelos/subServicios.php");
require_once("modelos/estados.php");
require_once("modelos/municipios.php");
require_once("modelos/marcas.php");
require_once("modelos/modelos.php");
require_once("modelos/features.php");
require_once("modelos/colores.php");
require_once("modelos/transmisiones.php");
require_once("modelos/autos.php");
require_once("modelos/autos-features.php");
require_once("modelos/autos-fotos.php");
require_once("modelos/autos-puja.php");
require_once("modelos/subasta-autos.php");
require_once("modelos/seccioneshome.php");
require_once("modelos/resultados.php");
require_once('utilidades/ConexionBD.php');
require_once('utilidades/ExcepcionApi.php');
require_once('utilidades/Utilerias.php');
require_once('modelos/usuario-automovil.php');
require_once('modelos/invitacion.php');
require_once('modelos/precio.php');
require_once('modelos/contactanos.php');
//unregister_GLOBALS();
error_reporting(E_ERROR);
ini_set("display_errors", 0);


//print ConexionBD::obtenerInstancia()->obtenerBD()->errorCode();
//print_r(array_shift($_GET['PATH_INFO']));


$vista = new VistaJson();

set_exception_handler(function ($exception) use ($vista) {
	    $cuerpo = array(
	        "estados" => $exception->estados,
	        "mensaje" => $exception->getMessage()
	    );
	    if ($exception->getCode()) {
	        $vista->estados = $exception->getCode();
	    } else {
	        $vista->estados = 500;
	    }

	    $vista->imprimir($cuerpo);
	}
);


// Obtener recurso
//print $peticion;
//$recurso = array_shift($peticion);
//recursos_existentes = array('contactos', 'usuarios');

// Comprobar si existe el recurso



$metodo = strtolower($_SERVER['REQUEST_METHOD']);

$arreglo = explode('/', $_GET['PATH_INFO']);
$modelo = $arreglo[0];

$arreglo = array_pop($arreglo);
$arreglo = explode(' ',$arreglo);

switch ($metodo) {
    case 'get':
        break;

    case 'post':

    	ejecutaModeloPost($vista, $modelo, $arreglo);
    	//$vista->imprimir(usuarios::post($arreglo));

        break;

    case 'put':
        break;

    case 'delete':
        break;

    default:
        // Método no aceptado

}


function ejecutaModeloPost($vista, $mod, $arr)
{

    switch (strtolower($mod)) {
    	case 'usuarios':
    		$vista->imprimir(usuarios::post($arr));
    		break;
    	case 'categorias':
    		$vista->imprimir(categorias::post($arr));
    		break;
        case 'empresas':
            $vista->imprimir(empresas::post($arr));
            break;
        case 'tiposubastas':
            $vista->imprimir(tiposubastas::post($arr));
            break;
        case 'subastas':
            $salida = subastas::post($arr);
            $vista->imprimir($salida);
            break;
        case 'cotizacion':
            $vista->imprimir(cotizacion::post($arr));
            break;
        case 'servicios':
            $vista->imprimir(servicios::post($arr));
            break;
        case 'subservicio':
            $vista->imprimir(subservicio::post($arr));
            break;
        case 'estados':
            $vista->imprimir(estados::post($arr));
            break;
        case 'municipios':
            $vista->imprimir(municipios::post($arr));
            break;
        case 'marcas':
            $vista->imprimir(marcas::post($arr));
            break;
        case 'modelos':
            $vista->imprimir(modelos::post($arr));
            break;
        case 'transmisiones':
            $vista->imprimir(transmisiones::post($arr));
            break;
        case 'features':
            $vista->imprimir(features::post($arr));
            break;
        case 'colores':
            $vista->imprimir(colores::post($arr));
            break;
        case 'autos':
            $vista->imprimir(autos::post($arr));
            break;
        case 'seccioneshome':
            $vista->imprimir(seccioneshome::post($arr));
            break;
        case 'usuarioautomovil':
            $vista->imprimir(usuarioautomovil::post($arr));
            break;

        case 'pujas':
            $vista->imprimir(autospuja::post($arr));
            break;
        case 'precio':
            $vista->imprimir(precio::post($arr));
            break;
        case 'contactanos':
            $vista->imprimir(contactanos::post($arr));
            break;
        case 'subastautos':
            $vista->imprimir(subastasautos::post($arr));
            break;
        default:
    		# code...
    		break;
    }
}


exit();
