<?  

    $errorCorreo=0;
    $textoFormularioErrorPHP="";
	
	if(isset($_POST['botonCrearCuenta'])) {
		
		// FUNCIONES DE SANITIZACIÓN PARA EVITAR ATAQUE "XSS"
		// Elimininamos espacios en blanco a derecha e izquierda de la cadena.
		// Sanitizamos el correo para evitar posibles caracteres html, como adicción de a la expresión regular.
		// Comprobamos con la misma expresión regular que en el lado cliente.
		function comprobarCorreo($correo) {
			$exitoCorreo;
			$exitoSanitizeCorreo;	
			$exitoExpresionCorreo;	

			$correo=trim($correo);
			
			(filter_var($correo, FILTER_SANITIZE_EMAIL)) ? $exitoSanitizeCorreo=1 : $exitoSanitizeCorreo=0 ;			

			(preg_match("/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/", $correo)) ? $exitoExpresionCorreo=1 : $exitoExpresionCorreo=0 ;

			(($exitoSanitizeCorreo) && ($exitoExpresionCorreo)) ? $exitoCorreo=1 : $exitoCorreo=0 ;	
			
			//echo("<br>"."existo es igual a: ".$exitoCorreo."<br>");

			return $exitoCorreo;
		}	

		function comprobarContrasena($contrasena) {
			$exitoContrasena;
			$exitoSanitizeContrasena;	
			$exitoExpresionContrasena;

			$contrasena=trim($contrasena);

			(filter_var($contrasena, FILTER_SANITIZE_STRING)) ? $exitoSanitizeContrasena=1 : $exitoSanitizeContrasena=0 ;
			 
			(preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8}$/", $contrasena)) ? $exitoExpresionContrasena=1 : $exitoExpresionContrasena=0 ;
			
			(($exitoSanitizeContrasena) && ($exitoExpresionContrasena)) ? $exitoContrasena=1 : $exitoContrasena=0 ;
			
			//echo("<br>"."existo es igual a: ".$exitoContrasena."<br>");

			return $exitoContrasena;    			
		}

		function compararContrasenas($contrasena1, $contrasena2) {			
			$exitoCompararContrasena;

			($contrasena1==$contrasena2) ? $exitoCompararContrasena=1 : $exitoCompararContrasena=0;

			return $exitoCompararContrasena;
		}

		$correoVerificado=comprobarCorreo($_POST["campoCorreo"]);
		$contrasenaVerificada1=comprobarContrasena($_POST["campoContrasena"]);
		$contrasenaVerificada2=comprobarContrasena($_POST["campoRepetirContrasena"]);

		if(($correoVerificado) && ($contrasenaVerificada1) && ($contrasenaVerificada2)) {
		    
		    include "INCLUDES/comprobarUsuario.php";
		    
			if(comprobarUsuario($_POST["campoCorreo"])!="siexiste") {
			    
			    if(compararContrasenas($_POST["campoContrasena"], $_POST["campoRepetirContrasena"])) {
			        
			        session_destroy();
			        
			        ini_set("session.use_cookies","0");
            		ini_set("session.use_only_cookies","0");
            		session_name('sesionGestion');
            		session_start();
            		$sid=session_id(); 
            		
            		// TIEMPO DE CADUCIDAD DE LA SESION (30 MINUTOS), SE COMPRUEBA Y SE INICIALIZA, SEGUN CORRESPONDA.
            		$inactivo = 1800;
 
                    if(isset($_SESSION['tiempo']) ) {
                        $vida_session = time() - $_SESSION['tiempo'];
                        if($vida_session > $inactivo)
                        {   
                            unset($_SESSION['tiempo']);
                            session_destroy();
                            header("Location: sesionCaducada.html"); 
                        }
                    }
                 
                    $_SESSION['tiempo'] = time();
                    
                    // CONTROLAMOS LA IP DESDE LA QUE SE ACCEDE PARA EVITAR "Session hijacking" O ROBO DE SESION
                    $_SESSION['ip_check'] = $_SERVER['REMOTE_ADDR'];
                    
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
            			$_SESSION['gestion']=$_POST["campoCorreo"];
            		}
            		
            		if(isset($_SESSION['intentos'])) {
            		    unset($_SESSION['intentos']);
            		}
            		
            		if(isset($_SESSION['aleatorio'])) {
            		    unset($_SESSION['aleatorio']);
            		}
			        
			    	//include "INCLUDES/enviarCorreo.php";
					include "INCLUDES/insertarUsuario0.php";
					
					//$aleatorio=substr(sha1(time()), 0, 16); //sha1()volverá una cadena hexadecimal de 40 caracteres,                                      cortada a 16 con substr.
					//$texto="<p>".iconv("UTF-8", "ISO-8859-1//TRANSLIT","El clave de validación para confirmar su correo es: ".$aleatorio."</p>");
					//$titulo=iconv("UTF-8", "ISO-8859-1//TRANSLIT","***CORREO PARA VALIDACIÓN DE ALTA: Listados de //grupos***");
					
                    //enviarCorreo($titulo, $_POST["campoCorreo"],$texto);
                    
                    $contrasenaHash = password_hash($_POST["campoContrasena"], PASSWORD_DEFAULT);
                 
                    insertarUsuario0($_POST["campoCorreo"], $contrasenaHash, "X");
                   
                    header('Location: crearCuenta1.php?'.SID); 
			        
			    } else {
			        header("Location: ENLACES/posibleHackeado.html",TRUE,301);
			    }
                   
			} else {
			    $valorCorreo=$_POST["campoCorreo"];
			    $textoFormularioErrorPHP="textoFormularioError";
			    $errorCorreo=1;
			}
		} else {
			header("Location: ENLACES/posibleHackeado.html",TRUE,301);
			
		}
	
	} else {
	    $valorCorreo="";
	}

?>

	<!DOCTYPE html>
	<html lang="es">

	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" /> 
		<title>simplyred</title>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"  />
		<link rel="stylesheet" href="crearCuenta0.css" type="text/css" media="all">
		<link rel="shortcut icon" href="img/IMG_COMUNES/fondoPestanaNavegador.png">
		<script type="text/javascript" src="crearCuenta0.js"></script>	
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
					<form action="index.php">
						<button id="btnIniciarSesion" class="btn mt-3 botonIniciarSesion" type="submit">Iniciar sesión</button>
					</form>
				</div>
				
				
			</div>
			
			<div class="row border-bottom p-5 border border-bottom-secondary cuerpo">
			
				<div class="col-lg-4 col-md-7 col-sm-12 col-xs-12 mt-2">					
				</div>
				
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 mt-2">
					<!--<h5 class="fw-bold">Crear una nueva cuenta</h5>-->
					<h5 class="fw-bold">Crear una cuenta</h5>
				</div>
				
				<div class="col-lg-3 col-md-1 col-sm-1 col-xs-1 mt-2"> 				
				</div>
				
				<div class="col-lg-4 col-md-7 col-sm-12 col-xs-12 mt-2">
					
				</div>
				
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					<!--<h6 class="subtitulo">Conoce a miles de personas a un click</h6>-->
					<h6 class="subtitulo">Únete y haz amigos con nosotros.</h6>
				</div>
				
				<div class="col-lg-3 col-md-1 col-sm-1 col-xs-1 mt-2 ">
				
				</div>			
				
				<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12" >
				</div>
				
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" >
					<!--<form action="https://alpanpanalpanpan.000webhostapp.com/crearCuenta1.php" method="POST">-->
					<form action="crearCuenta0.php" method="POST">
						<fieldset class="col col-11">
							
							<div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-3">  
								<label for="campoCorreo" id="tituloCampoCorreo" class="textoFormulario mb-1">Introduzca su correo</label>
								<input id="campoCorreo" name="campoCorreo" title="Introduzca su email" type="text" arial-label="introduzca su email" class="form-control input-sm " placeholder="Ej. 1234Juan@ejemplo.com" value="<?=$valorCorreo;?>">
								
							</div>
							
							<?if($errorCorreo==0) { ?>
							
    					        <div id="mensajeErrorCorreo" class="textoMensajeError mt-1"></div>
    					        
    					    <? } else { ?>
    					        <div id="mensajeErrorCorreo" class="textoMensajeError mt-1">El correo introducido ya existe.</div>
    					    <? } ?>
							
							<div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-3">  
								<label for="campoContrasena" id="tituloCampoContrasena" class="textoFormulario mb-1">Contraseña (8 caracteres, al menos un núm. y una letra)</label>
								<input  id="campoContrasena"  name="campoContrasena" title="Introduzca una contraseña" maxlength="8" minlength="8" type="password" arial-label="introduzca una contraseña" class="form-control input-sm " placeholder="Ej. Ab123456" autocomplete="off">
							</div>
							
    						<div id="mensajeErrorContrasena" class="col-lg-11 col-md-12 col-sm-12 col-xs-12 textoMensajeError mt-1">
    						</div>
						
							<div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-3">  
								<label for="campoRepetirContrasena" id="tituloCampoRepetirContrasena" class="textoFormulario mb-1">Repetir contraseña (8 caracteres, al menos un núm. y una letra)</label>
								<input  id="campoRepetirContrasena"  name="campoRepetirContrasena" title="Repita la contraseña introducida" maxlength="8" minlength="8" type="password" arial-label="introduzca una contraseña" class="form-control input-sm " id="contrasena1" placeholder="Ej. Ab123456" autocomplete="off">
							</div>						
							
							<div id="mensajeErrorRepertirContrasena" class="textoMensajeError mt-1"></div>


							<div class="form-group  col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-4 mb-2">
								<button id="btnCrearCuenta" name="botonCrearCuenta" type="submit" class="btn mt-2 mb-2 botonCrearCuenta">Crear cuenta</button>
							</div>

							<div class="row d-flex justify-content-center">
							<div class="form-group  col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-4 mb-2 ">
								<p><span class="textoNegrita">Al identificarte</span>, aceptas nuestra 
									<a class="enlacePiePagina" href="https://www.amazon.es">política de privacidad</a> y de 
									<a class="enlacePiePagina" href="https://www.amazon.es">cookies</a> , así como nuestro 
									<a class="enlacePiePagina" href="ENLACES/accesibilidad.html" target="_blank">documento de accesibilidad</a>.
								</p>
							</div>
							</div>

						</fieldset>
					</form>						
				</div>
				
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 mt-2" id="prueba" >				
				</div>

			</div>
			
			<div class="row d-flex justify-content-center pie">
			
				<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 mt-3" >					
				</div>			
				
				<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 mt-3 " >
					<a class="enlacePiePagina" href="https://www.amazon.es">Sobre nosotros</a>
				</div>
				
				<div class="col-lg-8 col-md-3 col-sm-12 col-xs-12 mt-3 " >
					<a class="enlacePiePagina" href="ENLACES/accesibilidad.html" target="_blank">Accesibilidad</a>
				</div>
				
				
				<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 mt-3 " >					
				</div>

				<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 mt-3 " >
					<a class="enlacePiePagina" href="https://www.amazon.es">Privacidad</a>
				</div>				
				
				<div class="col-lg-8 col-md-3 col-sm-12 col-xs-12 mt-3 mb-5" >
					<a class="enlacePiePagina" href="https://www.amazon.es">Política de cookies</a>
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
	