<?php

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
require_once("modelos/subasta-autos.php");
require_once("modelos/seccioneshome.php");
require_once('utilidades/ConexionBD.php');
require_once('utilidades/ExcepcionApi.php');
require_once('utilidades/Utilerias.php');
require_once('modelos/invitacion.php');
error_reporting(E_ERROR);

ini_set("display_errors", 0);
ini_set('upload_max_filesize', '60M');
ini_set('post_max_size', '60M');
ini_set('max_file_uploads',200);

if(isset($_FILES['file'])){
    if ( 0 < $_FILES['file']['error'] ) {
        print_r('ERROR: ' . $_FILES['file']['name'] );
        return 0;
    }


    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    $guid = guidv4();



    if(!isset($_POST["accion"])){
        $_POST["accion"] = "";
    }

    if($_POST["accion"] == "listausuarios"){



        $contador = 0;
        $procesados = 0;
        $total= 0;

        move_uploaded_file($_FILES['file']['tmp_name'], 'userlist/' . $guid.".".$ext);



        $fila = 0;
        ini_set('auto_detect_line_endings',true);

        if (($gestor = fopen('userlist/' . $guid.".".$ext, "r")) !== FALSE) {

            while (($datos = fgetcsv($gestor)) !== FALSE) {
                //echo "datos";

                $total++;
                $numero = count($datos);
                //echo "cuenta: ".$numero;
                $fila++;
                //for ($c=4; $c < $numero; $c++) {


                    //if($c%4 == 0 && $c > 0){

                        try{
                            if ($fila > 1) {

                                $usuario = new usuarios();
                                $usuario->nombre = utf8_encode($datos[0]);
                                $usuario->appaterno = utf8_encode($datos[1]);
                                $usuario->apmaterno = utf8_encode($datos[2]);
                                $usuario->correo = utf8_encode($datos[3]);
                                $usuario->verificado = 0;
                                $usuario->contrasena = "INVITADO";
                                $usuario->valido = 0;
                                $usuario->publico = 0;
                                $usuario->esadmin = 0;
                                $usuario->telefono = $datos[4];

                                if(usuarios::invitarUsuario($usuario, $_POST["idsubasta"])){
                                     $contador++;
                                }
                                $procesados++;

                            }
                        }catch(Exception $er){
                            echo "error: ".$er;
                        }
                    //}
                //}
            }
            fclose($gestor);
        }
        ini_set('auto_detect_line_endings',FALSE);
        // echo $guid.".".$ext;
        if($total > 1)
        {
            $total = $total -1;
        }

         echo $total.".".$contador.".".$procesados;

    }else if($_POST["accion"] == "home"){
        try{
            move_uploaded_file($_FILES['file']['tmp_name'], 'images/home/' . $guid.".".$ext);
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
            $comando = "update cat_seccioneshome set url = '"."images/home/" . $guid.".".$ext."' where id = ".$_POST["id"];
            echo $comando;
            $sentencia = $pdo->prepare($comando);

            $sentencia->execute();
            echo $guid.".".$ext;
        }
        catch(Exception $ex){

            echo "ERROR".$ex;
        }

    }
    else{


        $movido = move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $guid.".".$ext);
        if($movido){
          echo $guid.".".$ext;
        }else{
          switch($_FILES["file"]["error"]){
            case UPLOAD_ERR_INI_SIZE:
              echo "ERROR: El archivo cargado excede la directiva upload_max_filesize en php.ini.";
              break;
            case UPLOAD_ERR_FORM_SIZE:
              echo "ERROR: El archivo cargado excede la directiva MAX_FILE_SIZE que se especificó en el formulario HTML.";
              break;
            case UPLOAD_ERR_PARTIAL:
              echo "ERROR: El archivo cargado solo se cargó parcialmente.";
              break;
            case UPLOAD_ERR_NO_FILE:
              echo "ERROR: No file was uploaded.";
              break;
            case UPLOAD_ERR_NO_TMP_DIR:
              echo "ERROR: Falta una carpeta temporal.";
              break;
            case UPLOAD_ERR_CANT_WRITE:
              echo "ERROR: Error al escribir el archivo en el disco.";
              break;
            case UPLOAD_ERR_EXTENSION:
              echo "ERROR: Una extensión de PHP detuvo la carga del archivo. PHP no proporciona una forma de determinar qué extensión causó que la carga del archivo se detuviera";
              break;
            default;
              echo "ERROR";
              break;
          }
        }

    }
}


function guidv4()
{
    if (function_exists('com_create_guid') === true)
        return trim(com_create_guid(), '{}');

    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
?>
