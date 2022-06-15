window.addEventListener("DOMContentLoaded",()=>{
	
	var inputTodosChecks=document.getElementsByClassName("btn-check");
	console.log(inputTodosChecks);
	var checkEstudiar=document.getElementById("checkEstudiar");
	var inputCheckEstudiar=document.getElementById("inputCheckEstudiar");
    var checkTrabajar=document.getElementById("checkTrabajar");
	var inputCheckTrabajar=document.getElementById("inputCheckTrabajar");
    var checkViajar=document.getElementById("checkViajar");
	var inputCheckViajar=document.getElementById("inputCheckViajar");
    var checkComprar=document.getElementById("checkComprar");
	var inputCheckComprar=document.getElementById("inputCheckComprar");
	var checkSocializar=document.getElementById("checkSocializar");
	var inputCheckSocializar=document.getElementById("inputCheckSocializar");
	var checkLectura=document.getElementById("checkLectura");
	var inputCheckLectura=document.getElementById("inputCheckLectura");
    var checkFamilia=document.getElementById("checkFamilia");
	var inputCheckFamilia=document.getElementById("inputCheckFamilia");
    var checkAmistad=document.getElementById("checkAmistad");
	var inputCheckAmistad=document.getElementById("inputCheckAmistad");
    var checkDeporte=document.getElementById("checkDeporte");
	var inputCheckDeporte=document.getElementById("inputCheckDeporte");
    var checkMusica=document.getElementById("checkMusica");
	var inputCheckMusica=document.getElementById("inputCheckMusica");
    var checkCine=document.getElementById("checkCine");
	var inputCheckCine=document.getElementById("inputCheckCine");
    var checkMascotas=document.getElementById("checkMascotas");
	var inputCheckMascotas=document.getElementById("inputCheckMascotas");

	var campoDescripcionUsuario=document.getElementById("campoDescripcionUsuario");
	var btnContinuar=document.getElementById("btnContinuar");
	var textoSobreNosotros=document.getElementById("textoSobreNosotros");
	var textoPrivacidad=document.getElementById("textoPrivacidad");
	var textoPoliticaCookies=document.getElementById("textoPoliticaCookies");
	var textoAccesibilidad=document.getElementById("textoAccesibilidad");
	
	var tituloCampoChecks=document.getElementById("tituloCampoChecks");
	
	var mensajeErrorDescripcion=document.getElementById("mensajeErrorDescripcion");

	const tituloCampoImagenPersonal=document.getElementById("tituloCampoImagenPersonal");
	const inputImagenPersonal = document.getElementById("inputImagenPersonal");
    const verImagen = document.getElementById("verImagen");
    const mensajeErrorImagen = document.getElementById("mensajeErrorImagen");
    
    // CAPTURAR EL EVENTO CAMBIO DE IMAGEN
    inputImagenPersonal.addEventListener("change", () => {
        comprobarCampoImagen();
    });

    function comprobarCampoImagen() {
        // Los archivos seleccionados, pueden ser muchos o uno
        const archivos = inputImagenPersonal.files;
        const nombreArchivos = inputImagenPersonal.value;
        const expresionExtensionArchivos=/(.jpg|.jpeg|.png|.gif)$/i;
  
        // Si no hay archivos salimos de la función y quitamos la imagen
        if (!archivos || !archivos.length) {
            mensajeErrorImagen.innerText="";
			tituloCampoImagenPersonal.classList.remove("textoFormularioError");
            verImagen.src = "img/crearCuenta2/img_foto_por_defecto.jpg";  
            return true;
        }
  
        // Si la extensión del archivo no es jpg, jpeg, png, gif, visualiza imagen y mensaje de error.
        if(!expresionExtensionArchivos.test(nombreArchivos)) {
            //seleccionArchivos.value="";
            verImagen.src = "img/crearCuenta2/img_error_carga_archivo.jpg";
			tituloCampoImagenPersonal.classList.add("textoFormularioError");
            mensajeErrorImagen.innerText="Error, el archivo ha de ser jpg, jpeg, png ó gif.";
            mensajeErrorImagen.classList.add("textoMensajeError");
            return false;
        } else {   
            mensajeErrorImagen.innerText="";
			tituloCampoImagenPersonal.classList.remove("textoFormularioError");
            // Ahora tomamos el primer archivo, el cual vamos a previsualizar
            const primerArchivo = archivos[0];
            // Lo convertimos a un objeto de tipo objectURL
            const objectURL = URL.createObjectURL(primerArchivo);
            // Y a la fuente de la imagen le ponemos el objectURL
            verImagen.src = objectURL;
            return true; 
        }
    }

    // En caso de cualquier error del DOM no recogido anteriormente, se muestra imagen y mensaje de error.
        verImagen.addEventListener("error",() => {
        mensajeErrorImagen.innerText="Error, archivo erroneo o dañado.";
        mensajeErrorImagen.classList.add("textoFormularioError");
        verImagen.src = "img/crearCuenta2/img_error_carga_archivo.jpg";
        resultadoCampoImagen=false;
    })

    // CAPTURAR LOS OTROS EVENTOS DE IMAGEN
    inputImagenPersonal.addEventListener("mouseover",()=>{
		inputImagenPersonal.classList.add("bordeInputRojo");
	})
	
	inputImagenPersonal.addEventListener("mouseout",()=>{
		inputImagenPersonal.classList.remove("bordeInputRojo");
	})

    inputImagenPersonal.addEventListener("focus",()=>{
		inputImagenPersonal.classList.add("bordeInputRojoImportant");
	})
	
	inputImagenPersonal.addEventListener("blur",()=>{
		inputImagenPersonal.classList.remove("bordeInputRojoImportant");
	})

	// CAPTURAR LOS EVENTOS DE CAMPO DESCRIPCION USUARIO
	campoDescripcionUsuario.addEventListener("mouseover",()=>{
		campoDescripcionUsuario.classList.add("bordeInputRojo");
	})
	
	campoDescripcionUsuario.addEventListener("mouseout",()=>{
		campoDescripcionUsuario.classList.remove("bordeInputRojo");
	})

	campoDescripcionUsuario.addEventListener("focus",()=>{
		campoDescripcionUsuario.classList.add("bordeInputRojoImportant");
	})
	
	campoDescripcionUsuario.addEventListener("blur",()=>{
		campoDescripcionUsuario.classList.remove("bordeInputRojoImportant");
	})

	// CAPTURAR LOS EVENTOS DE TODOS LOS CAMPOS CHECKS 	
	// Check
	checkEstudiar.addEventListener("mouseover",()=>{
		checkEstudiar.classList.add("check1");
	})
	
	checkEstudiar.addEventListener("mouseout",()=>{
		checkEstudiar.classList.remove("check1");
	})
	
	checkEstudiar.addEventListener("click",()=>{
		if(inputCheckEstudiar.checked==false) {
			checkEstudiar.classList.add("check2");
            inputCheckEstudiar.checked=true;
		} else {
			checkEstudiar.classList.remove("check2");
            inputCheckEstudiar.checked=false;
		}
	})

	// Check
    checkTrabajar.addEventListener("mouseover",()=>{
		checkTrabajar.classList.add("check1");
	})
	
	checkTrabajar.addEventListener("mouseout",()=>{
		checkTrabajar.classList.remove("check1");
	})
	
	checkTrabajar.addEventListener("click",()=>{
		if(inputCheckTrabajar.checked==false) {
			checkTrabajar.classList.add("check2");
            inputCheckTrabajar.checked=true;
		} else {
			checkTrabajar.classList.remove("check2");
            inputCheckTrabajar.checked=false;
		}
	})

	// Check
    checkViajar.addEventListener("mouseover",()=>{
		checkViajar.classList.add("check1");
	})
	
	checkViajar.addEventListener("mouseout",()=>{
		checkViajar.classList.remove("check1");
	})
	
	checkViajar.addEventListener("click",()=>{
		if(inputCheckViajar.checked==false) {
			checkViajar.classList.add("check2");
            inputCheckViajar.checked=true;
		} else {
			checkViajar.classList.remove("check2");
            inputCheckViajar.checked=false;
		}
	})

	// Check
    checkComprar.addEventListener("mouseover",()=>{
		checkComprar.classList.add("check1");
	})
	
	checkComprar.addEventListener("mouseout",()=>{
		checkComprar.classList.remove("check1");
	})
	
	checkComprar.addEventListener("click",()=>{
		if(inputCheckComprar.checked==false) {
			checkComprar.classList.add("check2");
            inputCheckComprar.checked=true;
		} else {
			checkComprar.classList.remove("check2");
            inputCheckComprar.checked=false;
		}
	})

	// Check
    checkSocializar.addEventListener("mouseover",()=>{
		checkSocializar.classList.add("check1");
	})
	
	checkSocializar.addEventListener("mouseout",()=>{
		checkSocializar.classList.remove("check1");
	})
	
	checkSocializar.addEventListener("click",()=>{
		if(inputCheckSocializar.checked==false) {
			checkSocializar.classList.add("check2");
            inputCheckSocializar.checked=true;
		} else {
			checkSocializar.classList.remove("check2");
            inputCheckSocializar.checked=false;
		}
	})

	// Check
    checkLectura.addEventListener("mouseover",()=>{
		checkLectura.classList.add("check1");
	})
	
	checkLectura.addEventListener("mouseout",()=>{
		checkLectura.classList.remove("check1");
	})
	
	checkLectura.addEventListener("click",()=>{
		if(inputCheckLectura.checked==false) {
			checkLectura.classList.add("check2");
            inputCheckLectura.checked=true;
		} else {
			checkLectura.classList.remove("check2");
            inputCheckLectura.checked=false;
		}
	})

	// Check
    checkFamilia.addEventListener("mouseover",()=>{
		checkFamilia.classList.add("check1");
	})
	
	checkFamilia.addEventListener("mouseout",()=>{
		checkFamilia.classList.remove("check1");
	})
	
	checkFamilia.addEventListener("click",()=>{
		if(inputCheckFamilia.checked==false) {
			checkFamilia.classList.add("check2");
            inputCheckFamilia.checked=true;
		} else {
			checkFamilia.classList.remove("check2");
            inputCheckFamilia.checked=false;
		}
	})

	// Check
    checkAmistad.addEventListener("mouseover",()=>{
		checkAmistad.classList.add("check1");
	})
	
	checkAmistad.addEventListener("mouseout",()=>{
		checkAmistad.classList.remove("check1");
	})
	
	checkAmistad.addEventListener("click",()=>{
		if(inputCheckAmistad.checked==false) {
			checkAmistad.classList.add("check2");
            inputCheckAmistad.checked=true;
		} else {
			checkAmistad.classList.remove("check2");
            inputCheckAmistad.checked=false;
		}
	})

	// Check    
    checkDeporte.addEventListener("mouseover",()=>{
		checkDeporte.classList.add("check1");
	})
	
	checkDeporte.addEventListener("mouseout",()=>{
		checkDeporte.classList.remove("check1");
	})
	
	checkDeporte.addEventListener("click",()=>{
		if(inputCheckDeporte.checked==false) {
			checkDeporte.classList.add("check2");
            inputCheckDeporte.checked=true;
		} else {
			checkDeporte.classList.remove("check2");
            inputCheckDeporte.checked=false;
		}
	})

	// Check
    checkMusica.addEventListener("mouseover",()=>{
		checkMusica.classList.add("check1");
	})
	
	checkMusica.addEventListener("mouseout",()=>{
		checkMusica.classList.remove("check1");
	})
	
	checkMusica.addEventListener("click",()=>{
		if(inputCheckMusica.checked==false) {
			checkMusica.classList.add("check2");
            inputCheckMusica.checked=true;
		} else {
			checkMusica.classList.remove("check2");
            inputCheckMusica.checked=false;
		}
	})

	// Check
    checkCine.addEventListener("mouseover",()=>{
		checkCine.classList.add("check1");
	})
	
	checkCine.addEventListener("mouseout",()=>{
		checkCine.classList.remove("check1");
	})
	
	checkCine.addEventListener("click",()=>{
		if(inputCheckCine.checked==false) {
			checkCine.classList.add("check2");
            inputCheckCine.checked=true;
		} else {
			checkCine.classList.remove("check2");
            inputCheckCine.checked=false;
		}
	})

	// Check
    checkMascotas.addEventListener("mouseover",()=>{
		checkMascotas.classList.add("check1");
	})
	
	checkMascotas.addEventListener("mouseout",()=>{
		checkMascotas.classList.remove("check1");
	})
	
	checkMascotas.addEventListener("click",()=>{
		if(inputCheckMascotas.checked==false) {
			checkMascotas.classList.add("check2");
            inputCheckMascotas.checked=true;
		} else {
			checkMascotas.classList.remove("check2");
            inputCheckMascotas.checked=false;
		}
	})
	
	// CAPTURAR LOS EVENTOS DEL BOTON CONTINUAR
	btnContinuar.addEventListener("mouseover",()=>{	
		btnContinuar.classList.add("fondoBtnContinuar");	
		
	})	
	
	btnContinuar.addEventListener("mouseout",()=>{
		btnContinuar.classList.remove("fondoBtnContinuar");
	})
	
	
	// CAPTURAR LOS EVENTOS DEL BOTON INICIAR SESION	
	btnIniciarSesion.addEventListener("mouseover",()=>{	
		btnIniciarSesion.classList.add("fondoBtnIniciarSesion");			
	})	
	
	btnIniciarSesion.addEventListener("mouseout",()=>{
		btnIniciarSesion.classList.remove("fondoBtnIniciarSesion");
	})


	// CAPTURAR LOS EVENTOS ENLACES PIE DE PAGINA
	// Texto
	textoSobreNosotros.addEventListener("mouseover",()=>{	
		textoSobreNosotros.classList.add("subrayadoYtextoBlanco");	
	})	
	
	textoSobreNosotros.addEventListener("mouseout",()=>{
		textoSobreNosotros.classList.remove("subrayadoYtextoBlanco");
	})	
	
	// Texto
	textoPoliticaCookies.addEventListener("mouseover",()=>{	
		textoPoliticaCookies.classList.add("subrayadoYtextoBlanco");	
	})	
	
	textoPoliticaCookies.addEventListener("mouseout",()=>{
		textoPoliticaCookies.classList.remove("subrayadoYtextoBlanco");
	})	
	
	// Texto
	textoPrivacidad.addEventListener("mouseover",()=>{	
		textoPrivacidad.classList.add("subrayadoYtextoBlanco");	
	})	
	
	textoPrivacidad.addEventListener("mouseout",()=>{
		textoPrivacidad.classList.remove("subrayadoYtextoBlanco");
	})
	
	// Texto
	textoAccesibilidad.addEventListener("mouseover",()=>{	
		textoAccesibilidad.classList.add("subrayadoYtextoBlanco");	
	})	
	
	textoAccesibilidad.addEventListener("mouseout",()=>{
		textoAccesibilidad.classList.remove("subrayadoYtextoBlanco");
	})	

	function validarChecks () {
		var Vchecks=false;

		for (let i=0; i<=11; i++) {
			(inputTodosChecks[i].checked==true) ? Vchecks=true: "" ;	
		}

		if(Vchecks==false) {
			tituloCampoChecks.classList.add("textoFormularioError");
            mensajeErrorChecks.innerText="Error, debe seleccionar al menos una afición.";
            mensajeErrorChecks.classList.add("textoMensajeError");

		} else {
			tituloCampoChecks.classList.remove("textoFormularioError");
            mensajeErrorChecks.innerText="";
            mensajeErrorChecks.classList.remove("textoMensajeError");
		}

		return Vchecks;
	}

	function validarDescripcion () {
		var descripcion=campoDescripcionUsuario.value;
		//console.log(nombre);
		var vDescripcion=false;
		//var expresionNombre=/[a-zA-Z0-9ñáéíóú'´¨äëïöï\s]{2,25}/;
		var expresionDescripcion=/^[a-zA-Z0-9ÑñÁáÉéÍíÓóÚúÜü\s]{50,250}$/;
		if (descripcion=="") {
			campoDescripcionUsuario.focus();
		  	mensajeErrorDescripcion.innerText="La descripcion es un campo obligatorio.";
		 	mensajeErrorDescripcion.classList.add("textoMensajeError");
		  	tituloCampoDescripcion.classList.add("textoFormularioError");
		} else if(!expresionDescripcion.test(descripcion)) {
			campoDescripcionUsuario.focus();
			mensajeErrorDescripcion.innerText="Error, debe haber entre [50-250] caracteres sin símbolos especiales.";
			mensajeErrorDescripcion.classList.add("textoMensajeError");
			tituloCampoDescripcion.classList.add("textoFormularioError");
		} else{
			mensajeErrorDescripcion.innerText="";
			//mensajeErrorLocalidad.classList.remove("textoMensajeError");
			tituloCampoDescripcion.classList.remove("textoFormularioError");
			vDescripcion=true;
		}
		
		return vDescripcion;

	}


	btnContinuar.addEventListener("click",(ev)=>{
		
		var a1,a2, a3;

		//console.log(validarChecks());
		//console.log(validarDescripcion());
	
		a1=validarChecks();
		a2=validarDescripcion();	
		a3=comprobarCampoImagen();
	
		(!(a1) || !(a2) || !(a3)) ?  ev.preventDefault() : "";
		
	})
	
	

	










	
});