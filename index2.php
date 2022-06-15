<?
    if(isset($_SESSION['ip_check']) ) {
        unset($_SESSION['ip_check']);
    }
    	
    if(isset($_SESSION['intentos']) ) {
        unset($_SESSION['intentos']);
    }
    	
    if(isset($_SESSION['gestion']) ) {
        unset($_SESSION['gestion']);
    }
    	    
    session_destroy();
    
   
	if(isset($_POST['botonEntrar'])) {
	    
	    
		
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


		$correoVerificado=comprobarCorreo($_POST["campoCorreo"]);
		$contrasenaVerificada1=comprobarContrasena($_POST["campoContrasena"]);
		//$contrasenaComparada=compararContrasena($_POST["campoContrasena"]);
		

	    if(($correoVerificado) && ($contrasenaVerificada1)) {
		    
		    include "INCLUDES/comprobarUsuario.php";
		   
		    
		    if(comprobarUsuario($_POST["campoCorreo"])=="siexiste") {
		        //echo ("por1-");
		    
		        include "INCLUDES/compararContrasena.php";
		        
		        //echo ("por2-");
		        
		        //echo("ES ES: ".compararContrasena($_POST["campoCorreo"], $_POST["campoContrasena"])."----");
    		    
    		    if(compararContrasena($_POST["campoCorreo"], $_POST["campoContrasena"])=="sicorrecta") {
    			   // echo ("por3-");
    			    
    			    ini_set("session.use_cookies","0");
    				ini_set("session.use_only_cookies","0");
    				session_name('sesionGestion');
    				session_start();
    				$sid=session_id(); 
    											
    				// TIEMPO DE CADUCIDAD DE LA SESION (30 MINUTOS), SE COMPRUEBA Y SE INICIALIZA, SEGUN CORRESPONDA.
    				$inactivo = 1800;
    						
    				if(isset($_SESSION['tiempo']) ) {
    				$vida_session = time() - $_SESSION['tiempo'];
    					if($vida_session > $inactivo) {   
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
    											
    				//INICIALIZAMOS O BORRAMOS LAS VARIABLES DE SESION, SEGUN CORRESPONDA.
    				if(!isset($_SESSION['gestion'])) {
    					$_SESSION['gestion']=$_POST["campoCorreo"];
    				}
    											
    				if(isset($_SESSION['intentos'])) {
    					unset($_SESSION['intentos']);
    				}
    											
    				if(isset($_SESSION['aleatorio'])) {
    					unset($_SESSION['aleatorio']);
    				}
    			    
    			    include "INCLUDES/comprobarTipoUsuario.php";
    			    
    			    $resultado=(comprobarTipoUsuario($_POST["campoCorreo"]));
    			    
    			    //echo($resultado);
    			    
    			    switch($resultado) {
    					
    					case("nonombre")	:   header('Location: crearCuenta1.php?'.SID);
    											break;
    
    					case("noquiere")	:	header('Location: crearCuenta2.php?'.SID);
    											break;
    
    					case("novalidado")	:	header('Location: crearCuenta3.php?'.SID);
    											break;
    											
    					default :               header('Location: filtrarUsuarios.php?'.SID);
    											break;
    					    
    
    			    }
    			} else {
    			    //echo("Contraseña erronea");
    			    $valorCorreo=$_POST["campoCorreo"];
    			    $mostrarMensajeErrorContrasena=1;
    			}
		    } else {
		        $valorCorreo=$_POST["campoCorreo"];
		        $mostrarMensajeErrorCorreo=1;
		    }
		} else {
		    session_destroy();
            header("Location: ENLACES/posibleHackeado.html",TRUE,301);
		}
			      
			    
	
	} else {
	    $valorCorreo="";
	    $mostrarMensajeErrorCorreo=0;
	    $mostrarMensajeErrorContrasena=0;
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
		<link rel="stylesheet" href="index2.css" type="text/css" media="all">
		<link rel="shortcut icon" type="image/x-icon" href="https://simplyred.info/img/IMG_COMUNES/fondoPestanaNavegador.png">
		<script type="text/javascript" src="index2.js"></script>
		
		
	   
	</head>
	<body>   
	
		<div class="container">
		
			<div class="row">
				<div class="col-lg-1 col-md-3 col-sm-12 col-xs-12 mt-2 " >
				
				</div>
				
				<div class="col-lg-8 col-md-6 col-sm-12 col-xs-12 mt-2 " >
					<h1 class="fw-bold">simply red</h1>
					<h5>Citas serias para adultos</h5>
				</div>
				
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  mb-3" >
				    <form action="crearCuenta0.php">
					    <button id="btnCrearCuenta" class="btn mt-3 botonCrearCuenta" type="submit">Crear una cuenta</button>
					</form>
				</div>
				
			</div>
			
			
			
			<div class="row border rounded p-1 m-3 cuerpo">
			
				<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mt-2 " >
					
				</div>
				
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 mt-2 " >
					<h5 class="fw-bold">Conéctate a simply red</h5>
				</div>
				
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 mt-2 " >
				
				</div>
				
				<div id="fotoActual" class="col-lg-6 col-md-5 col-sm-12 col-xs-12 mt-2" >
					<img class="img-fluid" src="img/index2/pareja1.jpg" alt="Imagen de pareja heterosexual en blanco y negro">
				</div>
				
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" >
					<!--<form action="https://alpanpanalpanpan.000webhostapp.com/crearCuenta0.php" method="POST">-->
					<form action="index2.php" method="POST">
					<fieldset class="col col-11">
                               
                         
						<div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-3">
						 <?if($mostrarMensajeErrorCorreo==1) {?>
						    <label for="campoCorreo" id="tituloCampoCorreo" class="textoFormularioError mb-1">Introduzca su correo</label>
						<?} else {?>
							<label for="campoCorreo" id="tituloCampoCorreo" class="textoFormulario mb-1">Introduzca su correo</label>
						<?}?>
							
							<input id="campoCorreo" name="campoCorreo" title="Introduzca su email" type="text" arial-label="introduzca su email" class="form-control input-sm " placeholder="Ej. 1234Juan@ejemplo.com" value="<?=$valorCorreo;?>">
							
						</div>
						
					
						
                        <?if($mostrarMensajeErrorCorreo==1) {?>
							<div id="mensajeErrorCorreo" class="col-lg-11 col-md-12 col-sm-12 col-xs-12    textoMensajeError">Error, el correo no existe en nuestra base de datos.</div>
						<?} else {?>
						    <div id="mensajeErrorCorreo" class="col-lg-11 col-md-12 col-sm-12 col-xs-12 textoMensajeError">&nbsp</div>
						<?}?>
							
						<div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-3"> 
						<?if($mostrarMensajeErrorContrasena==1) {?>
						    <label for="campoContrasena" id="tituloCampoContrasena" class="textoFormularioError mb-1">Contraseña</label>
						<?} else {?>	
							<label for="campoContrasena" id="tituloCampoContrasena" class="textoFormulario mb-1">Contraseña</label>
						<?}?>
							
							<input  id="campoContrasena"  name="campoContrasena" title="Introduzca una contraseña (8 caracteres alfanuméricos)"  maxlength="8" minlength="8" type="password" arial-label="introduzca una contraseña" class="form-control input-sm " id="contrasena1" placeholder="Ej. 12345Aa*">
							
						</div>
						
						<?if($mostrarMensajeErrorContrasena==1) {?>
							<div id="mensajeErrorContrasena" class="col-lg-11 col-md-12 col-sm-12 col-xs-12 textoMensajeError">Error, la contraseña no existe en nuestra base datos.</div>
						<?} else {?>
						    <div id="mensajeErrorContrasena" class="col-lg-11 col-md-12 col-sm-12 col-xs-12 textoMensajeError">&nbsp</div>
						<?}?>
						
						<div class="form-group  col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-2">
							<div class="form-check">
								<label id="textoCheckbox" class="form-check-label" for="gridCheck">
								<input id="campoRecordarDatos" type="checkbox" checked class="m-1">
									Recordar datos 
								</label>
							</div>
						</div>
							
						<div class="form-group  col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-5">
							<button id="btnEntrar" name="botonEntrar" type="submit" class="btn mt-2 mb-2 botonEntrar">Entrar</button>
						</div>
								
							<div class="row col-lg-11 col-md-12 col-sm-12 col-xs-12">						
						<a  id="enlaceOlvidarContrasena" class="enlaceOlvidarContrasena mb-1" href="https://simplyred.info/recuperarContrasena0.php"><span id="textoOlvidarContrasena">Olvidé mi contraseña</span></a>
					</div>		
								
								
                    </fieldset>
					</form>
					
				
					
					
					
					
					
				</div>
				
				
				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 mt-2 " >
				
				</div>
			</div>
			
			<div class="row d-flex justify-content-center">
			
				<div class="col-lg-1 col-md-3 col-sm-12 col-xs-12 mt-3" >
					
				</div>
			
				
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-3 " >
					<a class="enlacePiePagina" href="https://www.amazon.es" title="Texto Alternativo" ><span id="textoSobreNosotros">Sobre nosotros</span></a>
				</div>
				
				<div class="col-lg-8 col-md-3 col-sm-12 col-xs-12 mt-3 " >
					<a class="enlacePiePagina" href="ENLACES/accesibilidad.html" target="_blank"><span id="textoAccesibilidad">Accesibilidad</span></a>
				</div>
				
				
				<div class="col-lg-1 col-md-3 col-sm-12 col-xs-12 mt-3 " >
					
				</div>
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-3 " >
					<a class="enlacePiePagina" href="https://www.amazon.es"><span id="textoPrivacidad">Privacidad</span></a>
				</div>
				
				
				
				<div class="col-lg-8 col-md-3 col-sm-12 col-xs-12 mt-3 mb-5" >
					<a class="enlacePiePagina" href="https://www.amazon.es"><span id="textoPoliticaCookies">Política de cookies</span></a>
				</div>
			
			
			</div>			
			
			
			<div class="row ">
			
				<div class="col-lg-1 col-md-3 col-sm-12 col-xs-12 mt-4 " >
					
				</div>
			
				<div class="col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-4 mb-5" >
					<span id="copyright" class="copyright1">2022 © fjsjb<span>
				</div>
			</div>
			
			
			
			<div id="pantallaOpacaDesabilitada" class="pantallaSegundoPlano">
			</div>
			
			<div id="cookies" class="cookies">
				
				<h4>¿Quieres una cita?</h3>
				
				<p>Utilizamos cookies propias para brindarle una experiencia mejorada y única en Simply red. ¿Quieres saber más? 
					Lea nuestra Política de cookies 
					<a class="enlaceDesdeCookiesYaccesiblidad" href="https://www.amazon.es"><span id="textoPoliticaCookiesYaccesibilidad">aquí </span></a> 
					o haga clic en 
					<a class="enlaceDesdeCookiesYaccesiblidad" href="https://www.amazon.es"><span id="textoPoliticaCookiesYaccesibilidad">"Política de privacidad".</span></a>
				</p>

				<p>Además, esta WEB requiere de javascript activado en tu navegador para su funcionamiento, consulta nuestra documento de 
				<a class="enlaceDesdeCookiesYaccesiblidad" href="ENLACES/accesibilidad.html" target="_blank"><span id="textoPoliticaCookiesYaccesibilidad">Accesibilidad</span></a>
					y te contamos por qué.
				</p>

				<button id="btnAceptarCookies" class="btn btn-sm btn-warning btn-space " type="button" >
				Aceptar cookies
				<button id="btnConfigurarCookies" class="btn btn-sm btn-light  btn-space " type="button">
				Ir a configurar cookies
    
			</div>
			
			<div id="configurarCookies" class="noVer">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4 " >
					<div class="form-check">
						<label id="textoCheckbox" class="form-check-label" for="gridCheck">
						<input id="campoRecordarDatos" type="checkbox" checked>
							<span class="textoCookie">Cookies estrictamente necesarias</span>
						</label>
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<p>Cookies estrictamente necesarias Las cookies estrictamente necesarias tiene que 
					activarse siempre para que podamos guardar tus preferencias de ajustes de cookies.
					Si desactivas esta cookie no podremos guardar tus preferencias. Esto significa que 
					cada vez que visites esta web tendrás que activar o desactivar las cookies de nuevo.</p>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4 " >
					<div class="form-check">
						<label id="textoCheckbox" class="form-check-label" for="gridCheck">
						<input id="campoRecordarDatos" type="checkbox">
							<span class="textoCookie">Cookies de terceros</span>
						</label>
					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
					<p>Esta web utiliza Google Analytics y otros servicios de terceros para recopilar información 
					agregada tal como el número de visitantes del sitio, o las páginas más populares. Dejar estas 
					cookies activas nos permite mejorar nuestra web,.</p>
				</div>
				
				<div class="d-flex justify-content-center col-lg-12 col-md-3 col-sm-12 col-xs-12 mt-4 " >
					<button id="btnGuardarCookies" class="btn btn-sm btn-warning btn-space" type="button" >
					Guardar
					<button id="btnCerrarConfigurarCookies" class="btn btn-sm btn-light  btn-space " type="button">
					Cerrar
				</div>
				
			</div>
			
			
	
		</div>
		
				

	
	
	</body>
	</html>
	