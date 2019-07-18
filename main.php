<?php
session_start();
require_once("views/VistaApi.php");
require_once("views/VistaJson.php");
require_once("modelos/usuarios.php");
require_once('utilidades/ConexionBD.php');
require_once('utilidades/ExcepcionApi.php');
require_once('utilidades/Utilerias.php');
unregister_GLOBALS();
?>
<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>::Escudería::</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link href="https://fonts.googleapis.com/css?family=Oswald:300,400,700&amp;subset=latin-ext" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css?family=Dosis:400,500,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">

        <link href="css/jquery-ui.css" rel="stylesheet" />
        <link href="css/materialize.css" rel="stylesheet"/>
        <link href="css/font-awesome.css" rel="stylesheet"/>
        <link href="css/styles.css?<?php echo "?" . rand(0, 9999999); ?>" rel="stylesheet"/>
        <link href="css/mediaQueries.css?v=2" rel="stylesheet"/>
        <link href="css/jcarousel.basic.css" rel="stylesheet"/>

	</head>
	<body>
		<!-- contenedor "absoluto"" del sitio -->
		<main class="mainContainer">
			<!-- contenedor del encabezado del sitio -->
			<div class="mainHeader">
				<!-- En ésta parte esta: el titulo de la pagina y los botones principales para registrarse o entrar -->
				<div>
					<h1>ESCUDERIA</h1>
					<div class="menuitem" name="registro">
						Regístrate
					</div>
					<div class="menuitem" name="login">
						Entrar
					</div>
				</div>
				<!-- menú principal; botones de redes sociales -->
				<ul>

				</ul>
				<!-- apartado de fecha y hora -->
				<!-- <div><label>JUEVES, 19 DE ENERO DE 2017</label><label> 11:28:17</label></div>-->
			</div>
			<!-- contenedor del cuerpo principal del sitio -->
			<div class="mainMinusHeader">
				<!-- <div id="btnClose">[X]</div> -->
				<div class="mainBody"></div>

			</div>
		</main>
		<footer class="mainFooter"></footer>
		<div class="modalWindow"></div>

		<script type="text/javascript" src="scripts/jquery-1.12.4.js"></script>
		<script type="text/javascript" src="scripts/jquery-ui.js"></script>
		<script type="text/javascript" src="scripts/jssor.slider-22.2.8.debug.js" ></script>
		<script type="text/javascript" src="scripts/dobPicker.min.js"></script>
		<script type="text/javascript" src="scripts/jquery.colorbox.js"></script>
		<script type="text/javascript" src="scripts/materialize.js"></script>


		<script type="text/javascript" src="scripts/main.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/header.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/footer.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/admin.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/utilidades.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/request.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/imgSlider.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/uisearch.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/entities.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/modulos/admin/adminsubastas.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/modulos/admin/altaauto.js?<?php echo "?" . rand(0, 9999999); ?>"</script>
		<script type="text/javascript" src="scripts/Venta-Autos.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/adminhome.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/MisAutos.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/modulos/admin/resultadossubastas.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/jcarousel.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/MisCotizaciones.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/Contactanos.js<?php echo "?" . rand(0, 9999999); ?>"></script>
		<script type="text/javascript" src="scripts/modulos/admin/useradmin.js<?php echo "?" . rand(0, 9999999); ?>"></script>



		<?php


if(isset($_SESSION['claveapi'])){

    if(!usuarios::ValidaSesion($_SESSION['claveapi'], $_SESSION['idusuario'])){


       echo "<script> alert('Su sesión ha caducado'); sessionStorage.clear(); window.location.href =  siteurl+'home.php'; </script>";


    }
}

?>
	</body>
	<!-- contenedor del cuerpo principal del sitio -->


</html>
<?php
exit();
?>
