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
        //echo("por-1");
        //header("Location: ENLACES/posibleHackeado.html",TRUE,301);

    } else {
        
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
	
        
        /*if(isset($_POST['btnIniciarSesion'])) {
			unset($_SESSION['tiempo']);
			unset($_SESSION['gestion']);
            session_destroy();
            header("Location: index.php"); 
        }
		}*/
		
		if(isset($_POST['botonIrChats'])) {
            header('Location: misChats.php?'.SID);
        }
		
        
        if(isset($_POST['botonAplicarFiltro'])) {
            //echo("entroenpost");

			
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

			// VERIFICAMOS LOS CHECKBOX AFICIONES CONTRA POSIBLES ATAQUES/ERRORES
			$checksVerificados=comprobarCheck($_POST['check_list']);

			// CREAMOS $arrayAficionesAsignadas CON LAS AFICIONES SELECCIONADAS CON "S", EL RESTO SIGUEL CON "X".
    		$arrayAficiones=["estudiar"=>"X", "trabajar"=>"X", "viajar"=>"X", "comprar"=>"X",
    						"socializar"=>"X", "lectura"=>"X", "familia"=>"X", "amistad"=>"X",
    						"deporte"=>"X", "musica"=>"X", "cine"=>"X", "mascotas"=>"X"];
    		$arrayAficionesAsignadas=asignarCheck($_POST['check_list'], $arrayAficiones);
    		
    	    $_SESSION['filtroSeleccionado']=$_POST['check_list'];
    		
    		// BUSCAMOS LAS PERSONAS QUE CUMPLEN EL FILTRO SELECCIONADO POR EL USUARIO Y GUARDAMOS EN UN ARRAY.
    		include "INCLUDES/buscarPersonasPorFiltro.php";
    	  
    		$arrayUsuariosSeleccionados=buscarPersonasPorFiltro($arrayAficionesAsignadas);
    		
    		//print_r($arrayUsuariosSeleccionados);
    		
    		// 
    		


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
		<link rel="stylesheet" href="filtrarUsuarios.css" type="text/css" media="all">
		<link rel="shortcut icon" href="img/IMG_COMUNES/fondoPestanaNavegador.png">
		<script type="text/javascript" src="filtrarUsuarios.js"></script>	
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

				<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 mt-1">		
				</div>

        		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt-1">
					<div class="row">
						<h5 class="negrita mt-5">FILTRAR</h5>
					</div>

					<div class="row mb-5">
						<!--<h6 class="subtitulo">Conoce a miles de personas a un click</h6>-->
						<h6 class="subtitulo">Selecciona personas afines a ti:</h6>
					</div>
					
    				<form action="filtrarUsuarios.php?<?=SID?>" method="POST">
    					    
    					<div class="row mt-3">
    
    					    <div class="form-group col-lg-11 col-md-11 col-sm-11 col-xs-12 d-flex justify-content-center">  
    						    
    								
    								<label id="checkEstudiar" class="btn btn-outline-secondary m-1 check0" arial-label="Me gusta estudiar" title="Me gusta estudiar">Estudiar	
                                        <input id="inputCheckEstudiar" type="checkbox" class="btn-check" name="check_list[]" value="estudiar"/>
                                    </label>
                                        
                                    <label id="checkTrabajar" class="btn btn-outline-secondary m-1 check0" arial-label="Me gusta trabajar" title="Me gusta trabajar">Trabajar		
                                        <input id="inputCheckTrabajar" type="checkbox" class="btn-check" name="check_list[]" value="trabajar"/>
                                    </label>	
    								
                                    <label id="checkViajar"class="btn btn-outline-secondary m-1 check0" arial-label="Me gusta viajar" title="Me gusta viajar">Viajar
                                        <input id="inputCheckViajar" type="checkbox" class="btn-check" name="check_list[]" value="viajar"/>
    								</label>
                                    
                            </div>
    
    					</div>
    
    					<div class="row">
    
    						<div class="form-group col-lg-11 col-md-11 col-sm-11 col-xs-12 d-flex justify-content-center mt-3 ">  								
    								
    								<label id="checkComprar"class="btn btn-outline-secondary m-1 check0" arial-label="Me gusta comprar" title="Me gusta comprar">Comprar
                                        <input id="inputCheckComprar" type="checkbox" class="btn-check" name="check_list[]" value="comprar"/>
    								</label>
    						
    								<label  id="checkSocializar" class="btn btn-outline-secondary m-1 check0" arial-label="Me gusta socializar" title="Me gusta socializar">Socializar								
                                        <input  id="inputCheckSocializar" type="checkbox" class="btn-check" name="check_list[]" value="socializar" />
                                    </label>		
                                        
                                    <label id="checkLectura"class="btn btn-outline-secondary m-1 check0" arial-label="Me gusta leer" title="Me gusta leer">Lectura
                                        <input id="inputCheckLectura" type="checkbox" class="btn-check"name="check_list[]" value="lectura"/>
                                    </label>	
                                    
                                    
    
                            </div>
    						
    					</div>
    							
    					<div class="row">
    
                            <div class="form-group col-lg-11 col-md-11 col-sm-11 col-xs-12 d-flex justify-content-center mt-3 ">  								
    
    								<label id="checkFamilia"class="btn btn-outline-secondary m-1 check0" arial-label="Me gusta la Familia" title="Me gusta la familia">Familia
                                        <input id="inputCheckFamilia" type="checkbox" class="btn-check" name="check_list[]" value="familia"/>
                                    </label>	
    
                                    <label id="checkAmistad"class="btn btn-outline-secondary m-1 check0" arial-label="Me gusta la amistad" title="Me gusta la amistad">Amistad
                                        <input id="inputCheckAmistad" type="checkbox" class="btn-check" name="check_list[]" value="amistad"/>
                                    </label>
    
                                    <label id="checkDeporte"class="btn btn-outline-secondary m-1 check0" arial-label="Me gusta el deporte" title="Me gusta el deporte">Deporte
                                        <input id="inputCheckDeporte" type="checkbox" class="btn-check" name="check_list[]" value="deporte"/>
    								</label>
    							
    						</div>
    
    					</div>
    
    					<div class="row mb-4">
    
                            <div class="form-group col-lg-11 col-md-11 col-sm-11 col-xs-12 d-flex justify-content-center mt-3 ">  								
    
                                    <label id="checkMusica"class="btn btn-outline-secondary m-1 check0" arial-label="Me gusta la música" title="Me gusta la música">Música
                                        <input id="inputCheckMusica" type="checkbox" class="btn-check" name="check_list[]" value="musica"/>
                                    </label>
                                    
                                    <label  id="checkCine" class="btn btn-outline-secondary m-1 check0" arial-label="Me gusta el cine" title="Me gusta el cine">Cine							
                                        <input  id="inputCheckCine" type="checkbox" class="btn-check" name="check_list[]" value="cine" />
                                    </label>		
    								
                                    <label id="checkMascotas"class="btn btn-outline-secondary m-1 check0" arial-label="Me gustan las mascotas" title="Me gusta las mascotas">Mascotas
    								    <input id="inputCheckMascotas" type="checkbox" class="btn-check" name="check_list[]" value="mascotas"/>
                                    </label>
    							
    						</div>
    
    					</div>
					
    					<div class="row mt-3">
    						<div class="form-group  col-lg-11 col-md-11 col-sm-11 col-xs-12 mt-4 mb-2">
    							<button id="btnAplicarFiltro" name="botonAplicarFiltro" type="submit" class="btn mt-2 mb-2 botonAplicarFiltro">Aplicar filtro seleccionado</button>
    						</div>							
    					</div>	
    			    
    			    </form>	

					
						
				</div>
				   
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-1 opcionesScroll opcionesScrollOcultar">
				 
				<?if(!isset($arrayUsuariosSeleccionados)) {?>
				        
						<h5 class="negrita mt-5">Sin filtro aplicado</h5>
						<h6 class="subtitulo  mb-4">Ejemplos de personas que podrías conocer</h6>
						
					<div class="row mb-3 mostrarPersonas">
						<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 tamanoTextoPersona ">
						<img  class="imagen" src="img/cajon_desastre/caraMujer1.jpg" alt="Archivo no válido">
							<span class="negrita">Ana, 27 años, Cuenca</span>
							<p >1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890
							1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890
							1234567890 1234567890 1234567890 1234567890
							</p>
						</div>
					</div>

					<div class="row mb-3 mostrarPersonas">
					    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 tamanoTextoPersona ">
						<img  class="imagen" src="img/cajon_desastre/caraMujer2.png" alt="Archivo no válido">
							<span class="negrita">Gema, 37 años, Santander</span>
							<p >1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890
							1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890
							1234567890 1234567890 1234567890 1234567890
							</p>
						</div>
					</div>
					
					<div class="row mb-3">
						<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 tamanoTextoPersona ">
						<img  class="imagen" src="img/cajon_desastre/caraMujer3.jpg" alt="Archivo no válido">
							<span class="negrita">Lucia, 29 años, Madrid</span>
							<p >1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890
							1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890
							1234567890 1234567890 1234567890 1234567890
							</p>
						</div>
					</div>

					<div class="row mb-3">
						<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 tamanoTextoPersona ">
						<img  class="imagen" src="img/cajon_desastre/caraMujer4.jpg" alt="Archivo no válido">
							<span class="negrita">María, 35 años, Sevilla</span>
							<p >1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890
							1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890 1234567890
							1234567890 1234567890 1234567890 1234567890
							</p>
						</div>
					</div>
					<?} else {?>
					
					
					
    					<?if(!empty($arrayUsuariosSeleccionados)) {?>
    					    
    					    <div class="row">
            					<h5 class="negrita mt-5 ">Personas que coinciden con tu filtro</h5>
            					<h6 class="subtitulo mb-4">
            				    <?
            				    $cadenafiltroSeleccionado="";
            						    
            				    for($i=0; $i<=count($_SESSION['filtroSeleccionado'])-1; $i++) {
            				        $cadenafiltroSeleccionado=$cadenafiltroSeleccionado.$_SESSION['filtroSeleccionado'][$i].", ";
            				    }
            				    		    
            			    	// Eliminamos la coma fila de la cadena.
            				    $cadenafiltroSeleccionado=rtrim($cadenafiltroSeleccionado, ", ");
            				    // Ponemos en mayúsculas la primera letra de la cadena.
            				    echo(ucfirst($cadenafiltroSeleccionado));
            				    ?>
            			        </h6>
            		        </div>
    					     
    					    <?foreach ($arrayUsuariosSeleccionados as $clave1=>$valor1) {
    					    
    					        if($valor1[1]!=$_SESSION['gestion']) {?>
    					    
    							
    							
                					<div class="row mb-3 mostrarPersonas">
                						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tamanoTextoPersona ">
                						<a href="misChats.php?id=<?=$valor1[0];?>&correo=<?=$valor1[1];?>&<?php echo htmlspecialchars(SID); ?>" src=""><img  class="imagen" src="img/IMG_USUARIOS/<?=$valor1[6];?>" alt="Archivo no válido"></a>
                							<span class="negrita"><?=$valor1[2];?>, <?=$valor1[4];?> años, <?=$valor1[3];?></span>
                							<p >(<?=trim($valor1[5]);?></p>
                						</div>
                					</div>
    							
    								
    				            <?}
    					    }
    					} else {?> 
    					
    					<div class="row">
    						
    				        <h5 class="negrita mt-5">Personas que coinciden con tu filtro</h5>
    				        <h6 class="subtitulo mb-4">
            						    <?
            						    $cadenafiltroSeleccionado="";
            						    
            						    for($i=0; $i<=count($_SESSION['filtroSeleccionado'])-1; $i++) {
            						        $cadenafiltroSeleccionado=$cadenafiltroSeleccionado.$_SESSION['filtroSeleccionado'][$i].", ";
            						    }
            						    
            						    // Eliminamos la coma fila de la cadena.
            						    $cadenafiltroSeleccionado=rtrim($cadenafiltroSeleccionado, ", ");
            						    // Ponemos en mayúsculas la primera letra de la cadena.
            						    echo(ucfirst($cadenafiltroSeleccionado));
            						    ?>
            				</h6>
    					    <h6 class="subtitulo  mb-4">¡ Lo sentimos, no existe personas con el filtro seleccinado !</h6>
    					</div>
    					
    					<?}
    				}?>

					
				


				</div>

				<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12  mt-3 ">		
				</div>



				<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12  mt-1 ">		
				</div>			

				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12  mt-2 ">
					<div class="row">
					    <form action="filtrarUsuarios.php?<?=SID?>" method="POST">
						    <div class="form-group  col-lg-11 col-md-11 col-sm-11 col-xs-12  mb-2">
							    <button id="btnIrChats" type="submit" class="btn mt-2 mb-2 botonIrChats" name="botonIrChats">Ir a mis chats</button>
						    </div>	
						</form>
					</div>
				</div>
				
				<div class="col-lg-6 col-md-4 col-sm-12 col-xs-12  mt-3 ">
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center">  	
						<button type="button" class="btn btn-outline-secondary m-1 variosTextoPaginas"><<</button>
						<button type="button" class="btn btn-outline-secondary m-1 variosTextoPaginas"><</button>
						<p class="centrarTextoContadorPaginas">Página 2 de 7</p>
						<button type="button" class="btn btn-outline-secondary m-1 variosTextoPaginas">></button>
						<button type="button" class="btn btn-outline-secondary m-1 variosTextoPaginas">>></button>
					</div>	
				</div>

				<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12  mt-1 ">		
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
	
		</div>
		
	</body>
	</html>
	