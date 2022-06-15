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
            
    		function comprobarDescripcion($descripcion) {
        		$exitoDescripcion;
        		$exitoSanitizeDescripcion;	
        		$exitoExpresionDescripcion;	
        
        		$descripcion=trim($descripcion);
        		
        		(filter_var($descripcion, FILTER_SANITIZE_STRING)) ? $exitoSanitizeDescripcion=1 : $exitoSanitizeDescripcion=0 ;			
        
        		(preg_match("/^[a-zA-Z0-9ÑñÁáÉéÍíÓóÚúÜü\s]{50,250}$/", $descripcion)) ? $exitoExpresionDescripcion=1 : $exitoExpresionDescripcion=0 ;
        
        		(($exitoSanitizeDescripcion) && ($exitoExpresionDescripcion)) ? $exitoDescripcion=1 : $exitoDescripcion=0 ;	
        
        		return $exitoDescripcion;
    		}
    
    		function comprobarCheck($arrayChecks) {
    			$exitoCheck=1;
    			
    			(empty($arrayChecks)) ? $exitoCheck=0 : "" ;
    			(count($arrayChecks)>=13) ? $exitoCheck=0 : "" ;
    
    			return $exitoCheck;
    		}
    
    		function asignarCheck($arrayChecks, $arrayAficiones) {
    			foreach($arrayChecks as $valor){
    				foreach($arrayAficiones as $clave1=>$valor1){
    					($valor==$clave1) ? $arrayAficiones[$clave1]="S" : "";
    				}
    			}
    
    			return $arrayAficiones;
    		}
    
			// VERIFICAMOS LA DESCRIPCION CONTRA POSIBLES ATAQUES/ERRORES
			$descripcionVerificada=comprobarDescripcion($_POST["descripcion"]);

			// VERIFICAMOS LOS CHECKBOX AFICIONES CONTRA POSIBLES ATAQUES/ERRORES
			$checksVerificados=comprobarCheck($_POST['check_list']);

			// CREAMOS $arrayAficionesAsignadas CON LAS AFICIONES SELECCIONADAS CON "S", EL RESTO SIGUEL CON "X".
    		$arrayAficiones=["estudiar"=>"X", "trabajar"=>"X", "viajar"=>"X", "comprar"=>"X",
    						"socializar"=>"X", "lectura"=>"X", "familia"=>"X", "amistad"=>"X",
    						"deporte"=>"X", "musica"=>"X", "cine"=>"X", "mascotas"=>"X"];
    		$arrayAficionesAsignadas=asignarCheck($_POST['check_list'], $arrayAficiones);
    
			//SUBIMOS LA FOTO A NUESTRO DIRECTORIO IMG_USUARIOS COMPROBANDO QUE LA IMAGEN EXISTE Y EXTENSION CORRECTA
			$nombreArchivo;
			if(file_exists($_FILES['cargararchivo']['tmp_name'])) {
			    
			    $path = "img/IMG_USUARIOS/".$_FILES['cargararchivo']['name'];
				$extension = pathinfo($path, PATHINFO_EXTENSION);
				if(($extension=="jpg") || ($extension=="jpeg") || ($extension=="png") || ($extension=="gif")) {
				    include "INCLUDES/obtenerUsuarioID.php";
				    $nombreArchivoFoto="img".obtenerUsuarioID($_SESSION['gestion']).".".$extension;
					move_uploaded_file($_FILES['cargararchivo']['tmp_name'],"img/IMG_USUARIOS/".$nombreArchivoFoto);
				} else {
					$nombreArchivoFoto="img_foto_por_defecto.jpg";
				}
				
			} else {
				$nombreArchivoFoto="img_foto_por_defecto.jpg";
			}
            
			if(($descripcionVerificada) && ($checksVerificados)) {
								
				include "INCLUDES/insertarUsuario2.php";

				insertarUsuario2($_SESSION['gestion'], $arrayAficionesAsignadas, $nombreArchivoFoto, $_POST["descripcion"]);  
				
			    header('Location: crearCuenta3.php?'.SID); 
				    
			} else {
			    session_destroy();
				header("Location: ENLACES/posibleHackeado.html",TRUE,301);
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
		<link rel="stylesheet" href="crearCuenta2.css" type="text/css" media="all">
		<link rel="shortcut icon" href="img/IMG_COMUNES/fondoPestanaNavegador.png">
		<script type="text/javascript" src="crearCuenta2.js"></script>	   
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
					<h5 class="fw-bold">Ya terminamos, no queda nada</h5>
				</div>
				
				<div class="col-lg-3 col-md-1 col-sm-1 col-xs-1 mt-2"> 				
				</div>
				
				<div class="col-lg-4 col-md-7 col-sm-12 col-xs-12 mt-2">
					
				</div>
				
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					<!--<h6 class="subtitulo">Conoce a miles de personas a un click</h6>-->
					<h6 class="subtitulo">Haz click en "Comenzar a conocer gente":</h6>
				</div>
				
				<div class="col-lg-3 col-md-1 col-sm-1 col-xs-1 mt-2 ">
				
				</div>			
				
				<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12" >
				</div>
				
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" >
					<!--<form action="https://alpanpanalpanpan.000webhostapp.com/filtrarUsuarios.php" method="POST">-->
				    <form action="crearCuenta2.php?<?=SID?>" method="POST" enctype="multipart/form-data">
					<!--<form action="crearCuenta2.php?<?=SID?>" method="POST">-->
						<fieldset class="col col-11">	
						
							<div id="tituloCampoChecks" class="textoFormulario mt-3">Gustos y aficiones</div>
							<div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center mt-3 ">  								
								
                                <label id="checkEstudiar" class="btn btn-outline-secondary m-1 Check0" arial-label="Me gusta estudiar" title="Me gusta estudiar">Estudiar	
                                    <input id="inputCheckEstudiar" type="checkbox" class="btn-check" name="check_list[]" value="estudiar"/>
                                </label>
                                    
                                <label id="checkTrabajar" class="btn btn-outline-secondary m-1 Check0" arial-label="Me gusta trabajar" title="Me gusta trabajar">Trabajar		
                                    <input id="inputCheckTrabajar" type="checkbox" class="btn-check" name="check_list[]" value="trabajar"/>
                                </label>	
								
                                <label id="checkViajar"class="btn btn-outline-secondary m-1 Check0" arial-label="Me gusta viajar" title="Me gusta viajar">Viajar
                                    <input id="inputCheckViajar" type="checkbox" class="btn-check" name="check_list[]" value="viajar"/>
								</label>
                                
                                <label id="checkComprar"class="btn btn-outline-secondary m-1 Check0" arial-label="Me gusta comprar" title="Me gusta comprar">Comprar
                                    <input id="inputCheckComprar" type="checkbox" class="btn-check" name="check_list[]" value="comprar"/>
								</label>

                            </div>	

                            <div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center mt-3 ">  								
								
                                <label  id="checkSocializar" class="btn btn-outline-secondary m-1 Check0" arial-label="Me gusta socializar" title="Me gusta socializar">Socializar								
                                    <input  id="inputCheckSocializar" type="checkbox" class="btn-check" name="check_list[]" value="socializar"/>
                                </label>		
                                    
                                <label id="checkLectura"class="btn btn-outline-secondary m-1 Check0" arial-label="Me gusta leer" title="Me gusta leer">Lectura
                                    <input id="inputCheckLectura" type="checkbox" class="btn-check" name="check_list[]" value="lectura"/>
                                </label>	
                                
                                <label id="checkFamilia"class="btn btn-outline-secondary m-1 Check0" arial-label="Me gusta la Familia" title="Me gusta la familia">Familia
                                    <input id="inputCheckFamilia" type="checkbox" class="btn-check" name="check_list[]" value="familia"/>
                                </label>	

                                <label id="checkAmistad"class="btn btn-outline-secondary m-1 Check0" arial-label="Me gusta la amistad" title="Me gusta la amistad">Amistad
                                    <input id="inputCheckAmistad" type="checkbox" class="btn-check" name="check_list[]" value="amistad"/>
                                </label>

                            </div>	

                            <div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center mt-3 ">  								

                                <label id="checkDeporte"class="btn btn-outline-secondary m-1 Check0" arial-label="Me gusta el deporte" title="Me gusta el deporte">Deporte
                                    <input id="inputCheckDeporte" type="checkbox" class="btn-check" name="check_list[]" value="deporte"/>
								</label>

                                <label id="checkMusica"class="btn btn-outline-secondary m-1 Check0" arial-label="Me gusta la música" title="Me gusta la música">Música
                                    <input id="inputCheckMusica" type="checkbox" class="btn-check" name="check_list[]" value="musica"/>
                                </label>
                                
                                <label  id="checkCine" class="btn btn-outline-secondary m-1 Check0" arial-label="Me gusta el cine" title="Me gusta el cine">Cine							
                                    <input  id="inputCheckCine" type="checkbox" class="btn-check" name="check_list[]" value="cine"/>
                                </label>		
								
                                <label id="checkMascotas"class="btn btn-outline-secondary m-1 Check0" arial-label="Me gustan las mascotas" title="Me gusta las mascotas">Mascotas
								    <input id="inputCheckMascotas" type="checkbox" class="btn-check" name="check_list[]" value="mascotas"/>
                                </label>
								    
                            </div>
                            
                        	<div id="mensajeErrorChecks" class="textoMensajeError mt-1"></div>

							<div id="tituloCampoImagenPersonal" class="textoFormulario mt-3">Imagen personal</div>
                            <div class="textoFormulario">(Archivo jpg; tamaño mínimo 300x200 pixeles; formato 10x15 preferible)</div>
                            <div class="form-group col-lg-11 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center mt-3 ">  
								
                                <label for="inputImagenPersonal"  class="form-label"></label>
                                <input class="form-control" id="inputImagenPersonal" type="file" name="cargararchivo"/>

							</div>

                            <div id="mensajeErrorImagen" class="textoMensajeError mt-1"></div>

                            <div class="col-lg-11 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center mt-4" >
                                <img class="tamanoImagen" id="verImagen" src="img/crearCuenta2/img_foto_por_defecto.jpg" alt="Archivo no válido">				
							</div>

							<div class="form-group  col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-5 ">
								<div id="tituloCampoDescripcion" class="textoFormulario mt-3">Cuentanos sobre ti (Máximo 250 caracteres) </div>
								<label for="campoDescripcionUsuario" class="textoFormulario mb-1"></label>
  								<textarea class="form-control" id="campoDescripcionUsuario" rows="3" placeholder="(Mínimo 50 caracteres, máximo 250 caracteres)" maxlength="250" name="descripcion"></textarea>
							</div>

							<div id="mensajeErrorDescripcion" class="textoMensajeError mt-1"></div>
							
						
							<div class="form-group  col-lg-11 col-md-12 col-sm-12 col-xs-12 mt-4 mb-2">
								<button id="btnContinuar" type="submit" class="btn mt-2 mb-2 botonContinuar" name="botonContinuar">Comenzar a conocer gente</button>
							</div>
											
						</fieldset>
					</form>						
				</div>


			</div>
			
			<div class="row d-flex justify-content-center pie">
			
				<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 mt-3" >					
				</div>			
				
				<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 mt-3" >
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
	