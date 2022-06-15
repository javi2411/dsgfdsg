

window.addEventListener("DOMContentLoaded",()=>{
	
	var camposInput=document.querySelectorAll("input");
	var textosMensajeError=document.querySelectorAll(".textoMensajeError");
	var textosPoliticasYotros=document.querySelectorAll("a");
	var btnFinalizar=document.getElementById("btnFinalizar");
	var tituloCampoContrasena=document.getElementById("tituloCampoContrasena");
	var pie=document.querySelectorAll(".pie");
	
	// CAPTURA SOLO EL INPUT CORREO PARA PETICION FETCH Y COMPROBAR SI EXISTE YA EL CORREO.

	
	// CAPTURA EVENTOS CAMPOS "EMAIL, CONTRASEÑA y REPETIR CONTRASEÑA"
	for (let i=0; i<=camposInput.length-1; i++) {
        //Añado un evento a cada elemento
        camposInput[i].addEventListener("mouseover",function(event) {
			event.target.classList.add("bordeInputRojo");
        });

		camposInput[i].addEventListener("mouseout",function(event) {
			event.target.classList.remove("bordeInputRojo");
			
        });

		camposInput[i].addEventListener("focus",function(event) {
			event.target.classList.add("bordeInputRojoImportant");

        });

		camposInput[i].addEventListener("blur",function(event) {
			event.target.classList.remove("bordeInputRojoImportant");
		});
		
    }

	
	btnFinalizar.addEventListener("mouseover",()=>{	
		btnFinalizar.classList.add("fondoBtnCrearCuenta");
	});
	
	btnFinalizar.addEventListener("mouseout",()=>{
		btnFinalizar.classList.remove("fondoBtnCrearCuenta");
	});
	
	btnIniciarSesion.addEventListener("mouseover",()=>{	
		btnIniciarSesion.classList.add("fondoBtnIniciarSesion");			
	});
	
	btnIniciarSesion.addEventListener("mouseout",()=>{
		btnIniciarSesion.classList.remove("fondoBtnIniciarSesion");
	});


	// CAPTURA EVENTOS ENLACES COOKIES, PRIVACIDAD, ACCESIBILIDAD Y SOBRE NOSOTROS"
	for (let i=0; i<=textosPoliticasYotros.length-1; i++) {
        //Añado un evento a cada elemento
		textosPoliticasYotros[i].addEventListener("mouseover",function(event) {
			event.target.classList.add("subrayadoYtextoBlanco");		
			
        });

		textosPoliticasYotros[i].addEventListener("mouseout",function(event) {
			event.target.classList.remove("subrayadoYtextoBlanco");
			
			
        });

    }


	


	function validarContrasena () {
		var contrasena=camposInput[0].value;
		//console.log(nombre);
		var vContrasena=false;
		
/*		Mínimo de ocho caracteres, al menos una letra, un número y un carácter especial:
		"^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$"
		Mínimo de ocho caracteres, al menos una letra mayúscula, una letra minúscula y un número:
		"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$"
		Mínimo de ocho caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial:
		"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
		Mínimo de ocho y máximo de 10 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial:
		"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,10}$"
*/
		var expresionContrasena=/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8}$/;
		if (contrasena=="") {
			//camposInput[1].focus();
			textosMensajeError[0].innerText="La contraseñan es una campo obligatorio.";
			textosMensajeError[0].classList.add("textoMensajeError");
		 	tituloCampoContrasena.classList.add("textoFormularioError");
		} else if(contrasena.length<=7) {
			//camposInput[1].focus();
			textosMensajeError[0].innerText="La contraseñan debe tener ocho caracteres.";
			textosMensajeError[0].classList.add("textoMensajeError");
		 	tituloCampoContrasena.classList.add("textoFormularioError");
		} else if(!expresionContrasena.test(contrasena)) {
			//console.log("no v");
			camposInput[1].focus();
			textosMensajeError[0].innerText="La contraseña debe contener al menos un número y una letra.";
			textosMensajeError[0].classList.add("textoMensajeError");
			tituloCampoContrasena.classList.add("textoFormularioError");
		} else{
			console.log("si v");
			textosMensajeError[0].innerText="";
			//mensajeErrorNombre.classList.remove("textoMensajeError");
			tituloCampoContrasena.classList.remove("textoFormularioError");
			vContrasena=true;
		}
		
		return vContrasena;
	}


	function validarCompararContrasenas () {
		var repetirContrasena=camposInput[1].value;
		var contrasena=camposInput[0].value;
		var vRepetirContrasena=false;

		if((repetirContrasena=="") && (contrasena!="")) {
		    //camposInput[1].focus();
			textosMensajeError[1].innerText="Introduce tu contraseña otra vez.";
			textosMensajeError[1].classList.add("textoMensajeError");
		 	tituloCampoRepetirContrasena.classList.add("textoFormularioError");
		} else if(repetirContrasena!=contrasena) {
			//console.log("rcom2");
			//camposInput[1].focus();
			textosMensajeError[1].innerText="Las contraseñas no coinciden.";
			textosMensajeError[1].classList.add("textoMensajeError");
		 	tituloCampoRepetirContrasena.classList.add("textoFormularioError");
		} else{
		    //camposInput[1].focus();
			textosMensajeError[1].innerText="";
			tituloCampoRepetirContrasena.classList.remove("textoFormularioError");
			vRepetirContrasena=true;
		}
		
		return vRepetirContrasena;
	}
	
	
	  
		btnFinalizar.addEventListener("click",(ev)=>{

		var a1,a2	
		
		a1=validarContrasena();
		a2=validarCompararContrasenas();
		
		(!(a1) || !(a2)) ?  ev.preventDefault() : "";
		
	});
	


	
});