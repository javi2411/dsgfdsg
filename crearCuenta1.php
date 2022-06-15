<?
    
	
	
	ini_set("session.use_cookies","0");
	ini_set("session.use_only_cookies","0");
	session_name('sesionGestion');
	session_start();
	$sid=session_id();
	
    //TIEMPO DE CADUCIDAD DE LA SESION (30 MINUTOS), SE COMPRUEBA Y SE INICIALIZA, SEGUN CORRESPONDA.
   $inactivo = 1800;
 
    if(isset($_SESSION['tiempo']) ) {
        $vida_session = time() - $_SESSION['tiempo'];
        if($vida_session > $inactivo) {
			unset($_SESSION['tiempo']);
			unset($_SESSION['gestion']);
            session_destroy();
            header("Location: sesionCaducada.html"); 
        }
    }
    
    $_SESSION['tiempo'] = time();
    
    // CONTROLAMOS LA IP DESDE LA QUE SE ACCEDE PARA EVITAR "Session hijacking" O ROBO DE SESION
    if(isset($_SESSION['ip_check']) ) {
        if($_SESSION['ip_check'] != $_SERVER['REMOTE_ADDR']){
            //session_regenerate_id(); 
            session_destroy();
            //session_start();
            header("Location: ENLACES/posibleHackeado.html",TRUE,301);
        }
    }
                
	//COMPROBAMOS LA VARIABLE DE SESION GESTION QUE CONTIENE EL CORREO DEL USUARIO.
    if(!isset($_SESSION['gestion'])) {
		//unset($_SESSION['tiempo']);
        session_destroy();
        header("Location: ENLACES/posibleHackeado.html",TRUE,301);
    } else {

		if(isset($_POST['btnIniciarSesion'])) {
			unset($_SESSION['tiempo']);
			unset($_SESSION['gestion']);
            session_destroy();
            header("Location: index.php"); 
		}
        
        if(isset($_POST['botonContinuar'])) {
		
			// FUNCIONES DE SANITIZACIÓN PARA EVITAR ATAQUE "XSS"
			// Elimininamos espacios en blanco a derecha e izquierda de la cadena.
			// Sanitizamos el correo para evitar posibles caracteres html, como adicción de a la expresión regular.
			// Comprobamos con la misma expresión regular que en el lado cliente.
			function comprobarNombreLocalidad($nombreLocalidad) {
			    	echo("Ha entrado2");
				$exitoNombreLocalidad;
				$exitoSanitizeNombreLocalidad;	
				$exitoExpresionNombreLocalidad;	
	
				$nombreLocalidad=trim($nombreLocalidad);
				
				(filter_var($nombreLocalidad, FILTER_SANITIZE_STRING)) ? $exitoSanitizeNombreLocalidad=1 : $exitoSanitizeNombreLocalidad=0 ;			
	
				(preg_match("/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]{1,25}$/", $nombreLocalidad)) ? $exitoExpresionNombreLocalidad=1 : $exitoExpresionNombreLocalidad=0 ;
	
				(($exitoSanitizeNombreLocalidad) && ($exitoExpresionNombreLocalidad)) ? $exitoNombreLocalidad=1 : $exitoNombreLocalidad=0 ;	
	
				return $exitoNombreLocalidad;
			}	
            
            	echo("Ha entrado11");
			function comprobarFecha($dia, $mes, $ano) {
			    echo("Ha entrado3");
				$exitoFecha;
				$exitoSanitizeDia;
				$exitoSanitizeMes;
				$exitoSanitizeAno;
				$mesExiste=0;
				$arrayMes=["enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"];

				$dia=trim($dia);
				$mes=trim($mes);
				$ano=trim($ano);
				
				(filter_var($dia, FILTER_SANITIZE_NUMBER_INT)) ? $exitoSanitizeDia=1 : $exitoSanitizeDia=0 ;
				(filter_var($dia, FILTER_SANITIZE_STRING)) ? $exitoSanitizeMes=1 : $exitoSanitizeMes=0 ;				
				(filter_var($ano, FILTER_SANITIZE_NUMBER_INT)) ? $exitoSanitizeAno=1 : $exitoSanitizeAno=0 ;
				
				for($i=0; $i<=count($arrayMes)-1; $i++) {
					($arrayMes[$i]==$mes) ? $mesExiste=1 : "" ;
				}

				(($exitoSanitizeDia) && ($exitoSanitizeMes) && ($exitoSanitizeAno) && ($mesExiste)) ? $exitoFecha=1 : $exitoFecha=0 ;	

				return $exitoFecha;
			}

            	echo("Ha entrado1111");
			function comprobarCheck($arrayChecks) {
			    echo("Ha entrado8");
				$exitoCheck=1;
				
				(empty($arrayChecks)) ? $exitoCheck=0 : "" ;
				(count($arrayChecks)>=3) ? $exitoCheck=0 : "" ;

				($arrayChecks[0]=="soyHombre") && ($arrayChecks[1]=="soyMujer") ? $exitoCheck=0 : "" ;
				($arrayChecks[0]=="buscoHombre") && ($arrayChecks[1]=="buscoMujer") ? $exitoCheck=0 : "" ;

				return $exitoCheck;
			}

			function asignarCheck($tipo, $arrayChecks) {
				$exito;
				
				if ($tipo=="genero") {					
					($arrayChecks[0]=="soyHombre") ? $exito="H" : $exito="M" ;
				}

				
				if ($tipo=="busco") {					
					($arrayChecks[1]=="buscoHombre") ? $exito="H" : $exito="M" ;
				}				

				return $exito;
			}

			$nombreVerificado=comprobarNombreLocalidad($_POST["campoNombre"]);
			$localidadVerificada=comprobarNombreLocalidad($_POST["campoLocalidad"]);
			$fechaVerificada=comprobarFecha($_POST["campoDia"], $_POST["campoMes"], $_POST["campoAno"]);
			$checksVerificados=comprobarCheck($_POST['check_list']);

			if(($nombreVerificado) && ($localidadVerificada) && ($fechaVerificada) && ($checksVerificados)) {
				$genero=asignarCheck("genero", $_POST['check_list']);
				$busco=asignarCheck("busco", $_POST['check_list']);
		
				include "INCLUDES/insertarUsuario1.php";
				insertarUsuario1($_SESSION['gestion'], $_POST["campoNombre"], $_POST["campoLocalidad"],
				    $_POST["campoDia"], $_POST["campoMes"], $_POST["campoAno"], $genero, $busco);;
				header('Location: crearCuenta2.php?'.SID); 
				    
			} else {
				session_destroy();
				header("Location: /ENLACES/posibleHackeado.html",TRUE,301);
			}
		} 
    }


	



?>

	<!DOCTYPE html>
	<html lang="es">

	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" /> 
		<title>simplyred</title>
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"  />
		<link rel="stylesheet" href="crearCuenta1.css" type="text/css" media="all">
		<link rel="shortcut icon" href="img/IMG_COMUNES/fondoPestanaNavegador.png">
		<script type="text/javascript" src="crearCuenta1.js"></script>	
	</head>

	<body>   
		<div class="container-fluid">		
			<div class="row">

				<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 mt-2 ">									
				</div>
				
				<div class="col-lg-7 col-md-6 col-sm-12 col-xs-12 mt-2 ">
					<h3 class="fw-bold">simply red</h3>	
					<h6 class="fw-bold">Citas serias para adultos</h6>				
				</div>

				
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
					<form action="crearCuenta1.php?<?=SID?>" method="POST">
						<button id="btnIniciarSesion" class="btn mt-3 botonIniciarSesion" type="submit" name="btnIniciarSesion">Iniciar sesión</button>
					</form>
				</div>
				
				
			</div>
			
			<div class="row border-bottom p-5 border border-bottom-secondary cuerpo">
			
				<div class="col-lg-4 col-md-7 col-sm-12 col-xs-12 mt-2">					
				</div>
				
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 mt-2">
					<!--<h5 class="fw-bold">Crear una nueva cuenta</h5>-->
					<h5 class="fw-bold">¡ Ya estás registrado, completa tus datos !</h5>
				</div>
				
				<div class="col-lg-3 col-md-1 col-sm-1 col-xs-1 mt-2"> 				
				</div>
				
				<div class="col-lg-4 col-md-7 col-sm-12 col-xs-12 mt-2">
					
				</div>
				
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					<!--<h6 class="subtitulo">Conoce a miles de personas a un click</h6>-->
					<h6 class="subtitulo">Estás a un paso de empezar a conocer gente nueva:</h6>
				</div>
				
				<div class="col-lg-3 col-md-1 col-sm-1 col-xs-1 mt-2 ">
				
				</div>			
				
				<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12" >
				</div>
				
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" >
					<form action="crearCuenta1.php?<?=SID?>" method="POST">
						<fieldset class="col col-11">								
							
							<div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-3">  
								<label for="nombre" id="tituloCampoNombre" class="textoFormulario mb-1">Nombre</label>
								<input id="campoNombre" class="form-control input-sm" title="Introduzca su nombre" type="text" arial-label="introduzca su nombre"  placeholder="Ej. Juan" name="campoNombre">							
								
							</div>

							<div id="mensajeErrorNombre" class="textoMensajeError mt-1"></div>
							
							<div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-3">  
								<label for="localidad" id="tituloCampoLocalidad" class="textoFormulario mb-1">Localidad</label>
								<input id="campoLocalidad" class="form-control input-sm " title="Introduzca su localidad" type="text" arial-label="introduzca su localidad"  placeholder="Ej. Madrid" name="campoLocalidad">							
							</div>

							<div id="mensajeErrorLocalidad" class="textoMensajeError mt-1"></div>
							
							<!--<div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-3">  
								<label for="campoFechaNacimiento" id="tituloCampoFecha" class="textoFormulario mb-1">Fecha nacimiento</label>
								<input id="campoFechaNacimiento" class="form-control input-sm  textoFechaGris" min="1923-01-01" max="2022-01-01" title="Introduzca fecha nacimiento" type="date" arial-label="Introduzca fecha nacimiento">							
							</div>	

							<div id="mensajeErrorFecha" class="textoMensajeError mt-1"></div>-->

							<div id="tituloCampoFecha" class="textoFormulario mt-3">Fecha de nacimiento</div>
								<div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-3 d-flex justify-content-center">
									<label for="campoDia" class="textoFormulario m-2">Día</label>
									<select class="form-select-inline form-select-sm rounded-2 bordeCampoFecha anchoCampoDia" id="campoDia" name="campoDia"> 
										<option selected>---</option>
									</select>

									<label for="campoMes" class="textoFormulario m-2">Mes</label>
									<select class="form-select-inline form-select-sm rounded-2 bordeCampoFecha anchoCampoMes" id="campoMes" name="campoMes">
										<option selected>-----------</option>
									</select>

									<label for="campoAno" class="textoFormulario m-2">Año</label>
									<select class="form-select-inline form-select-sm rounded-2 bordeCampoFecha anchoCampoAno" id="campoAno" name="campoAno"> 
										<option selected>------</option>
									</select>
								</div>
							

							<div id="mensajeErrorFecha" class="textoMensajeError mt-1"></div>

							<div id="tituloCampoGenero" class="textoFormulario mt-3"></label>Su género es</div>
							<div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center mt-3 ">  								
								
								<input  id="inputCheckSoyHombre" type="checkbox" class="btn-check" name="check_list[]" value="soyHombre"/>
								<label  id="checkSoyHombre" class="btn btn-outline-secondary m-1 Check0" for="campoBuscasHombre" arial-label="Soy un hombre" title="Soy un hombre">Masculino</label>									
									
								<input id="inputCheckSoyMujer" type="checkbox" class="btn-check" name="check_list[]" value="soyMujer"/>
								<label id="checkSoyMujer"class="btn btn-outline-secondary m-1 Check0" for="campoBuscasMujer" arial-label="Soy una mujer" title="Soy una mujer">Femenino</label>
										
							</div>	

							<div id="mensajeErrorGenero" class="textoMensajeError mt-1"></div>

							
							<div id="tituloCampoConocerA" class="textoFormulario mt-3">Desea conocer a</div>
							<div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center mt-3 ">  
								
								<input id="inputCheckBuscoHombres" type="checkbox" class="btn-check"  name="check_list[]" value="buscoHombre"/>
								<label id="checkBuscoHombres" class="btn btn-outline-secondary m-1 Check0" for="campoBuscasHombre" arial-label="Conocer hombres" title="Conocer hombres">Hombres</label>
										
								<input id="inputCheckBuscoMujeres" type="checkbox" class="btn-check" name="check_list[]" value="buscoMujer"/>
								<label id="checkBuscoMujeres" class="btn btn-outline-secondary m-1 Check0" for="campoBuscasMujer" arial-label="Conocer mujeres" title="Conocer mujeres">Mujeres</label>
							
							</div>

							<div id="mensajeErrorConocerA" class="textoMensajeError mt-1"></div>
							
							<div class="form-group  col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-3 mb-2">
								<button id="btnContinuar" type="submit" class="btn mt-2 mb-2 botonContinuar" name="botonContinuar">Continuar</button>
							</div>
											
						</fieldset>
					</form>						
				</div>
				
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 mt-2 " >				
				</div>

			</div>
			
			<div class="row d-flex justify-content-center pie">
			
				<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 mt-3" >					
				</div>			
				
				<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 mt-3 " >
					<a class="enlacePiePagina" href="https://www.amazon.es"><span id="textoSobreNosotros">Sobre nosotros</span></a>
				</div>
				
				<div class="col-lg-8 col-md-3 col-sm-12 col-xs-12 mt-3 " >
					<a class="enlacePiePagina" href="ENLACES/accesibilidad.html" target="_blank"><span id="textoAccesibilidad">Accesibilidad</span></a>
				</div>
				
				
				<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 mt-3 " >					
				</div>

				<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 mt-3 " >
					<a class="enlacePiePagina" href="https://www.amazon.es"><span id="textoPrivacidad">Privacidad</span></a>
				</div>				
				
				<div class="col-lg-8 col-md-3 col-sm-12 col-xs-12 mt-3 mb-5" >
					<a class="enlacePiePagina" href="https://www.amazon.es"><span id="textoPoliticaCookies">Política de cookies</span></a>
				</div>			
			
			</div>
			
			<div class="row pie">
			
				<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 mt-4 " >					
				</div>
			
				<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12 mt-4 mb-5" >
					<span id="copyright" class="copyright1">2022 © fjsjb<span>
				</div>

			</div>
	
		</div>
	</body>
	</html>
	