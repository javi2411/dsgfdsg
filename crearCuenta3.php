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
    		unset($_SESSION['gestion']);
            session_destroy();
            //echo("por tiempo-");
            header("Location: sesionCaducada.html"); 
        }
    }
    
    $_SESSION['tiempo'] = time();
    
    // CONTROLAMOS LA IP DESDE LA QUE SE ACCEDE PARA EVITAR "Session hijacking" O ROBO DE SESION
    if(isset($_SESSION['ip_check']) ) {
        if($_SESSION['ip_check'] != $_SERVER['REMOTE_ADDR']){
            //session_regenerate_id(); 
    		unset($_SESSION['gestion']);
            session_destroy();
            //session_start();
            //echo("por ipcheck-");
            header("Location: ENLACES/posibleHackeado.html");
        }
    }

   echo($_SESSION['intentos']);
    
                
	//COMPROBAMOS LA VARIABLE DE SESION GESTION QUE CONTIENE EL CORREO DEL USUARIO.
	echo($_SESSION['gestion']);
    if(!isset($_SESSION['gestion'])) {
        session_destroy();
        //echo("por gestion-");
        header("Location: ENLACES/posibleHackeado.html");
    } else {
        
        if(!isset($_SESSION['intentos'])) {
            //echo("por intentos-");
            
            $mostrarMensajeError=0;
            //echo($_SESSION['intentos']);
            $_SESSION['intentos']=0;
            //echo($_SESSION['intentos']);
            
            include "INCLUDES/enviarCorreo.php";
    
            $aleatorio=substr(sha1(time()), 0, 16); //sha1()volverá una cadena hexadecimal de 40 caracteres,                                      cortada a 16 con substr.
            
            $_SESSION['aleatorio']=$aleatorio;
            
            $texto="<p>".iconv("UTF-8", "ISO-8859-1//TRANSLIT","El clave de validación para confirmar su correo es: ".$aleatorio."</p>");
            $titulo=iconv("UTF-8", "ISO-8859-1//TRANSLIT","***CORREO PARA VALIDACIÓN DE ALTA: Listados de grupos***");
                        
            enviarCorreo($titulo, $_SESSION['gestion'],$texto);
        }
        
         if(isset($_POST['btnIniciarSesion'])) {
            unset($_SESSION['gestion']);
            session_destroy();
            //echo("por tiempo-");
            header("Location: index.php"); 
         }
        
        
        
        if(isset($_POST['botonValidarCorreo'])) {
            //echo("entramos en boton validar correo");
            //echo($_SESSION['intentos']);
            $_SESSION['intentos']=$_SESSION['intentos']+1;
            //echo($_SESSION['intentos']);
            function comprobarClave($clave) {
                echo("Ha entrado2");
                echo($clave);
                $exitoClave;
                $exitoEnBlanco;
                $exitoSanitizeClave;	
                $exitoExpresionClave;	
    
                $clave=trim($clave);
                
                ($clave!="") ? $exitoEnBlaco=1 : $exitoEnBlaco=0 ;
                
                (filter_var($clave, FILTER_SANITIZE_STRING)) ? $exitoSanitizeClave=1 : $exitoSanitizeClave=0 ;			
                //echo("$exitoSanitizeClave");
                (preg_match("/^[0-9abcdef\s]{16}$/", $clave)) ? $exitoExpresionClave=1 : $exitoExpresionClave=0 ;
                 echo("$exitoExpresionClave");
                
                (($exitoSanitizeClave) && ($exitoExpresionClave) && ($exitoEnBlaco)) ? $exitoClave=1 : $exitoClave=0 ;	
                
                //echo($exitoClave);
                return $exitoClave;;
            }	
		
            $claveVerificada=comprobarClave($_POST["campoClaveValidacion"]);
				    	
			if($claveVerificada) {
                //echo("clave verificada es: ". $claveVerificada);
                 //echo("aleatorio es: ". $_SESSION['aleatorio']);
                 //echo("introducida es: ". $_POST["campoClaveValidacion"]);
                if($_SESSION['aleatorio']==$_POST["campoClaveValidacion"]) {
                    //echo("claveCorrecta!!");
                    include "INCLUDES/insertarUsuario3.php";  
                    insertarUsuario3($_SESSION['gestion'], "S"); 
                    header('Location: filtrarUsuarios.php?'.SID);
                } else {
                    $mostrarMensajeError=1;
                }
			} else {
			    $mostrarMensajeError=1;
			}
		} 
		
		//echo($_SESSION['intentos']) && !($claveVerificada);
		if(($_SESSION['intentos']==3) && ($_SESSION['aleatorio']!=$_POST["campoClaveValidacion"])) {
            //echo("porintentosfinal");
    		unset($_SESSION['gestion']);
            session_destroy();
            header("Location: ENLACES/intentosSuperados.html"); 
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
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"  />
		<link rel="stylesheet" href="crearCuenta3.css" type="text/css" media="all">
		<link rel="shortcut icon" href="img/IMG_COMUNES/fondoPestanaNavegador.png">
		<script type="text/javascript" src="crearCuenta3.js"></script>	
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
                    <form action="crearCuenta3.php?<?=SID?>" method="POST">
						<button id="btnIniciarSesion" class="btn mt-3 botonIniciarSesion" type="submit" name="btnIniciarSesion">Iniciar sesión</button>
					</form>
				</div>
				
				
			</div>
			
			<div class="row border-bottom p-5 border border-bottom-secondary cuerpo">
			
				<div class="col-lg-4 col-md-7 col-sm-12 col-xs-12 mt-2">					
				</div>
				
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 mt-2">
					<!--<h5 class="fw-bold">Crear una nueva cuenta</h5>-->
					<h5 class="fw-bold">Validamos el correo para tu seguridad</h5>
				</div>
				
				<div class="col-lg-3 col-md-1 col-sm-1 col-xs-1 mt-2"> 				
				</div>
				
				<div class="col-lg-4 col-md-7 col-sm-12 col-xs-12 mt-2">
					
				</div>
				
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					<!--<h6 class="subtitulo">Conoce a miles de personas a un click</h6>-->
					<h6 class="subtitulo">Hemos enviado una clave de confirmación a tu correo:</h6>
				</div>
				
				<div class="col-lg-3 col-md-1 col-sm-1 col-xs-1 mt-2 ">
				
				</div>			
				
				<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12" >
				</div>
				
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" >
					<!--<form action="https://alpanpanalpanpan.000webhostapp.com/crearCuenta1.php" method="POST">-->
					<form action="crearCuenta3.php?<?=SID?>" method="POST">
						<fieldset class="col col-11">
							
							<div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-3"> 
							    <?if($mostrarMensajeError==0) { ?>
								    <label for="campoClaveValidacion" id="tituloCampoClaveValidacion" class="textoFormulario mb-1">Clave validación</label>
								<?} else {?>
								    <label for="campoClaveValidacion" id="tituloCampoClaveValidacion" class="textoFormularioError mb-1">Clave validación</label>
								<?}?>
								
								<input  id="campoClaveValidacion"  name="campoClaveValidacion" title="Introduzca una contraseña" type="password" arial-label="introduzca la clave de validación" class="form-control input-sm " placeholder="Ej. a4b34h67dd492c3a" autocomplete="off">
							</div>
							
							<?if($mostrarMensajeError==1) { ?>
    							<div id="mensajeErrorClaveValidacion" class="col-lg-11 col-md-12 col-sm-12 col-xs-12 textoMensajeError mt-1">
    							    Error, clave incorrecta; inténtelo de nuevo.
    							</div>
							<?}?>

							<div class="form-group  col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-4 mb-2">
								<button id="btnValidarCorreo" name="botonValidarCorreo" type="submit" class="btn mt-2 mb-2 botonValidarCorreo">Validar correo</button>
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
	
	