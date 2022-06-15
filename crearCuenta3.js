window.addEventListener("DOMContentLoaded",()=>{
    
    console.log("hola");
	
	var camposInput=document.querySelectorAll("input");
	var textosMensajeError=document.querySelectorAll(".textoMensajeError");
	var textosPoliticasYotros=document.querySelectorAll("a");
	var btnValidarCorreo=document.getElementById("btnValidarCorreo");
	var tituloCampoCorreo=document.getElementById("tituloCampoCorreo");
	var tituloCampoContrasena=document.getElementById("tituloCampoContrasena");
	
	
	// CAPTURA EVENTOS CAMPOS "EMAIL, CONTRASEÑA y REPETIR CONTRASEÑA"
	for (var i=0; i<=camposInput.length-1; i++) {
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

	
	btnValidarCorreo.addEventListener("mouseover",()=>{	
		btnValidarCorreo.classList.add("fondoBtnCrearCuenta");	
		
	})
	
	btnValidarCorreo.addEventListener("mouseout",()=>{
		btnValidarCorreo.classList.remove("fondoBtnCrearCuenta");
	})	
	
	btnIniciarSesion.addEventListener("mouseover",()=>{	
		btnIniciarSesion.classList.add("fondoBtnIniciarSesion");			
	})	
	
	btnIniciarSesion.addEventListener("mouseout",()=>{
		btnIniciarSesion.classList.remove("fondoBtnIniciarSesion");
	})


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
	
});