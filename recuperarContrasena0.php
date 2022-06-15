<?  

    $errorCorreo=0;
    $textoFormularioErrorPHP="";
    
    if(isset($_POST['btnIniciarSesion'])) {
		unset($_SESSION['gestion']);
        unset($_SESSION['intentos']);
        unset($_SESSION['aleatorio']);
        unset($_SESSION['ip_check']);
        unset($_SESSION['tiempo']);
        session_destroy();
        header("Location: index.php"); 
	}
	
	if(isset($_POST['botonContinuar'])) {
		
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

		

		$correoVerificado=comprobarCorreo($_POST["campoCorreo"]);
		
		echo($_POST["campoCorreo"]);
		
		if($correoVerificado) {
		    
		    
		    
		    include "INCLUDES/comprobarUsuario.php";
		    
			if(comprobarUsuario($_POST["campoCorreo"])=="siexiste") {
			    
			    echo(comprobarUsuario($_POST["campoCorreo"]));
			    
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
			        
                    header('Location: recuperarContrasena1.php?'.SID); 
                    
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
		<link rel="stylesheet" href="recuperarContrasena0.css" type="text/css" media="all">
		<link rel="shortcut icon" href="img/IMG_COMUNES/fondoPestanaNavegador.png">
		<script type="text/javascript" src="recuperarContrasena0.js"></script>	
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
					<form action="recuperarContrasena0.php?<?=SID?>" method="POST">
						<button id="btnIniciarSesion" class="btn mt-3 botonIniciarSesion" type="submit" name="btnIniciarSesion">Iniciar sesión
						</button>
					</form>
				</div>
				
				
			</div>
			
			<div class="row border-bottom p-5 border border-bottom-secondary cuerpo">
			
				<div class="col-lg-4 col-md-7 col-sm-12 col-xs-12 mt-2">					
				</div>
				
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 mt-2">
					<!--<h5 class="fw-bold">Crear una nueva cuenta</h5>-->
					<h5 class="fw-bold">Olvidé mi contraseña</h5>
				</div>
				
				<div class="col-lg-3 col-md-1 col-sm-1 col-xs-1 mt-2"> 				
				</div>
				
				<div class="col-lg-4 col-md-7 col-sm-12 col-xs-12 mt-2">
					
				</div>
				
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					<!--<h6 class="subtitulo">Conoce a miles de personas a un click</h6>-->
					<h6 class="subtitulo">Siga las indicaciones para recuperar su contraseña.</h6>
				</div>
				
				<div class="col-lg-3 col-md-1 col-sm-1 col-xs-1 mt-2 ">
				
				</div>			
				
				<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12" >
				</div>
				
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" >
					<!--<form action="https://alpanpanalpanpan.000webhostapp.com/crearCuenta1.php" method="POST">-->
					<form action="recuperarContrasena0.php" method="POST">
						<fieldset class="col col-11">
							
							<div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-3">  
								<label for="campoCorreo" id="tituloCampoCorreo" class="textoFormulario  <?=$textoFormularioErrorPHP;?> mb-1">Introduzca su correo</label>
								<input id="campoCorreo" name="campoCorreo" title="Introduzca su email" type="text" arial-label="introduzca su email" class="form-control input-sm " placeholder="Ej. 1234Juan@ejemplo.com" value="<?=$valorCorreo;?>">
								
							</div>
							
							<?if($errorCorreo==0) { ?>
							
    					        <div id="mensajeErrorCorreo" class="textoMensajeError mt-1"></div>
    					        
    					    <? } else { ?>
    					        <div id="mensajeErrorCorreo" class="textoMensajeError mt-1">El correo introducido no existe.</div>
    					    <? } ?>

							<div class="form-group  col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-4 mb-2">
								<button id="btnContinuar" name="botonContinuar" type="submit" class="btn mt-2 mb-2 botonContinuar">Continuar</button>
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
	