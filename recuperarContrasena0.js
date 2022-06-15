

window.addEventListener("DOMContentLoaded",()=>{
	
	var camposInput=document.querySelectorAll("input");
	var campoInputCorreo=document.getElementById("campoCorreo");
	var textosMensajeError=document.querySelectorAll(".textoMensajeError");
	var textosPoliticasYotros=document.querySelectorAll("a");
	var btnContinuar=document.getElementById("btnContinuar");
	var pie=document.querySelectorAll(".pie");

    
    
    //campoInputCorreo.addEventListener("blur",()=>{	
			//comprobarCorreo();
	//});

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

	
	btnContinuar.addEventListener("mouseover",()=>{	
		btnContinuar.classList.add("fondoBtnCrearCuenta");
	});
	
	btnContinuar.addEventListener("mouseout",()=>{
		btnContinuar.classList.remove("fondoBtnCrearCuenta");
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
	
	function validarCorreo() {
		var correo=camposInput[0].value;
		//console.log(nombre);
		var vCorreo=false;
		//var expresionNombre=/[a-zA-Zñáéíóú'´¨äëïöï\s]{2,25}/;
		var expresionCorreo=/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
		if (correo=="") {
			camposInput[0].focus();
		  	textosMensajeError[0].innerText="El correo es una campo obligatorio.";
			textosMensajeError[0].classList.add("textoMensajeError");
		  	tituloCampoCorreo.classList.add("textoFormularioError");
		} else if(!expresionCorreo.test(correo)) {
			camposInput[0].focus();
			textosMensajeError[0].innerText="El correo introducido es erróneo, revíselo.";
			textosMensajeError[0].classList.add("textoMensajeError");
			tituloCampoCorreo.classList.add("textoFormularioError");
		} else{
			textosMensajeError[0].innerText="";
			//mensajeErrorNombre.classList.remove("textoMensajeError");
			tituloCampoCorreo.classList.remove("textoFormularioError");
			vCorreo=true;
		}
		
		
		return vCorreo;

	}
	

	btnContinuar.addEventListener("click",(ev)=>{
		var a1;	
		a1=validarCorreo();
			
		(!(a1))  ?  ev.preventDefault() : "";		
	});
	
});