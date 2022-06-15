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
       // echo("por-1");
        //header("Location: ENLACES/posibleHackeado.html",TRUE,301);

    } else {
        
        //include "INCLUDES/insertarMensaje.php";
        //$datos555=["1-2", "1", "fsfsfd", "X"];
        //insertarMensaje($datos555);
        
        // OBTENEMOS DE LA BASE DE DATOS LOS DATOS DEL USUARIO QUE HA INICIADO SESION
        include "INCLUDES/obtenerDatosUsuario.php";
        $arrayDatosUsuario=obtenerDatosUsuario($_SESSION['gestion']);
        
        if(isset($_GET['cerrar'])) {
            if($_GET['cerrar']==true) {
    			unset($_SESSION['tiempo']);
    			unset($_SESSION['gestion']);
                session_destroy();
                header("Location: index.php"); 
            }
		}
		
		if(isset($_POST['nombreUsuario'])) {
            header("Location: ENLACES/perfilUsuario.html");
        }
		
		
		if(isset($_GET['id'])) {
		    
            if($_GET['id']<=$arrayDatosUsuario[0][0]) {
                $nuevoChatID=$_GET['id']."-".$arrayDatosUsuario[0][0];
            } else {
                $nuevoChatID=$arrayDatosUsuario[0][0]."-". $_GET['id'];
            }
            
            include "INCLUDES/insertarNuevoChat.php";
            insertarNuevoChat($nuevoChatID);
            
            include "INCLUDES/insertarNuevoUsuariosChat.php";
            insertarNuevoUsuariosChat($arrayDatosUsuario[0][0], $nuevoChatID);
            insertarNuevoUsuariosChat($_GET['id'], $nuevoChatID);
            
		}
		
		//echo("aquiiiii7");
		include "INCLUDES/obtenerChatsAbiertos.php";
        $arrayChatsAbiertos=obtenerChatsAbiertos($arrayDatosUsuario[0][0]);
        //print_r($arrayChatsAbiertos);
        
        include "INCLUDES/obtenerDatosUsuarioPorId.php";
		
	    include "INCLUDES/obtenerMensajesChat.php";
	    
	    //print_r(obtenerMensajesChat("1-2"));
        
        
	
        
        /*if(isset($_POST['btnIniciarSesion'])) {
			unset($_SESSION['tiempo']);
			unset($_SESSION['gestion']);
            session_destroy();
            header("Location: index.php"); 
        }
		}*/
        
        if(isset($_POST['botonIrFiltrar'])) {
            header('Location: filtrarUsuarios.php?'.SID);
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
		<link rel="stylesheet" href="misChats.css" type="text/css" media="all">
		<link rel="shortcut icon" href="img/IMG_COMUNES/fondoPestanaNavegador.png">
		<script type="text/javascript" src="https://simplyred.info/misChats.js"></script>	
	</head>

	<body>   
		<div class="container-fluid">		
			<div class="row encabezado">

				<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 mt-2 ">									
				</div>
				
				<div class="col-lg-7 col-md-6 col-sm-12 col-xs-12 mt-2 ">
					<h3 class="fw-bold">simply red</h3>	
					<h6 class="fw-bold">Citas serias para adultos</h6>				
				</div>

				
				<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mb-3">
					<form action="filtrarUsuarios1.php?<?=SID?>" method="POST">
						<button id="btnUsuario" name"nombreUsuario" class="btn mt-3 botonUsuario" title="Ir a mi perfil" arial-label="Ir a mi perfil" type="submit"><?=$arrayDatosUsuario[0][2];?></button>
					</form>
				</div>

                   
				<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 d-flex justify-content-center">
						<a href="filtrarUsuarios.php?cerrar=true&<?php echo htmlspecialchars(SID); ?>" title="Salir" arial-label="Salir"><img class="imagenCerrar" src="img/IMG_COMUNES/botonCerrar.jpg"></a>
				</div>
				
				
			</div>
			
		
			<div class="row" id="fila">

                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 mt-5">		
				</div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-5">
                    <h5 class="negrita">MIS CHATS</h5>
					<h6 class="subtitulo">Haz click y habla con tus amigos</h6>
                </div>

                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mt-5">		
				</div>

                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 mt-5">		
				</div>


				<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 mt-1">		
				</div>

        		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-1 opcionesScroll opcionesScrollOcultar">
				 
			
				        
					<?for($i=0; $i<=count($arrayChatsAbiertos)-1; $i++) {
					
					    $arrayFotoYnombre=obtenerDatosUsuarioPorId($arrayChatsAbiertos[$i][0], $arrayDatosUsuario[0][0]);?>
					   
        				<div class="row mb-3 mostrarPersonas" id="<?=$arrayChatsAbiertos[$i][0];?>">
        					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tamanoTextoPersona ">
        					<a href=# src=""><img  class="imagen" src="img/IMG_USUARIOS/<?=$arrayFotoYnombre[0][0];?>" alt="Archivo no válido"></a>
        						<span class="negrita"><?=$arrayFotoYnombre[0][1];?></span>
        						<p >
        						</p>
        					</div>
        				</div>
        				
    				
    				<?}?>

				</div>
				   
				<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mt-1 opcionesScroll opcionesScrollOcultar">
					<div class="row mb-3">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
						    
							<p id="textoMensaje">
							    
							</p>
							<div id="prueba">
							</div>
							
						</div>
					</div>
					
				</div>

				<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12  mt-1 ">		
				</div>



				<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12  mt-5 ">		
				</div>			

				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12  mt-5 ">
					<div class="row">
					    <form action="misChats.php?<?=SID?>" method="POST">
    						<div class="form-group">
    							<button id="btnIrFiltrar" type="submit" class="btn botonIrFiltrar" name="botonIrFiltrar">Ir a filtrar</button>
    						</div>	
    					</form>
					</div>
				</div>
				
                
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mt-5 prueba">
                     <form action="" method="POST">     
						<label for="textoMensaje" id="tituloTextoMensaje" class=""></label>
						<!--<input id="campoTextoMensaje" class="form-control CampoTextoMensaje" disabled title="Introduzca el mensaje" type="text" arial-label="introduzca el mensaje a enviar"  placeholder="(Máximo 100 caracteres)" name="campoTextoMensaje" maxlength="100">-->
						<input id="campoTextoMensaje" class="CampoTextoMensaje" disabled title="Introduzca el mensaje" type="text" arial-label="introduzca el mensaje a enviar"  placeholder="(Máximo 100 caracteres)" name="campoTextoMensaje" maxlength="100">
				</div>


				<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12  mt-5 ">	
    				    <div class="row">
    				        <form action="" method="POST">
        						<div class="form-group">
        							<button id="btnEnviarMensaje" type="submit" class="btn botonEnviarMensaje">-></button>
        						</div>
    					</div>
    				</form>
				</div>	
				
			

				
				
				
			</div>

			
				   
				
			
			
			<div class="row pull-right border-top d-flex justify-content-center pie mt-5">
			
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

			<div id="<?=$arrayDatosUsuario[0][0];?>" class="usuarioId"></div>
			
		
	
		</div>
		
	</body>
	</html>
	

