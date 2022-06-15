

window.addEventListener("DOMContentLoaded",()=>{
	
	var camposInput=document.querySelectorAll("input");
	var campoInputCorreo=document.getElementById("campoCorreo");
	var textosMensajeError=document.querySelectorAll(".textoMensajeError");
	var textosPoliticasYotros=document.querySelectorAll("a");
	var btnCrearCuenta=document.getElementById("btnCrearCuenta");
	var tituloCampoCorreo=document.getElementById("tituloCampoCorreo");
	var tituloCampoContrasena=document.getElementById("tituloCampoContrasena");
	var pie=document.querySelectorAll(".pie");

    comprobarCorreo();
    
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

	
	btnCrearCuenta.addEventListener("mouseover",()=>{	
		btnCrearCuenta.classList.add("fondoBtnCrearCuenta");
	});
	
	btnCrearCuenta.addEventListener("mouseout",()=>{
		btnCrearCuenta.classList.remove("fondoBtnCrearCuenta");
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
		var contrasena=camposInput[1].value;
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
			textosMensajeError[1].innerText="La contraseñan es una campo obligatorio.";
			textosMensajeError[1].classList.add("textoMensajeError");
		 	tituloCampoContrasena.classList.add("textoFormularioError");
		} else if(contrasena.length<=7) {
			//camposInput[1].focus();
			textosMensajeError[1].innerText="La contraseñan debe tener ocho caracteres.";
			textosMensajeError[1].classList.add("textoMensajeError");
		 	tituloCampoContrasena.classList.add("textoFormularioError");
		} else if(!expresionContrasena.test(contrasena)) {
			//console.log("no v");
			camposInput[1].focus();
			textosMensajeError[1].innerText="La contraseña debe contener al menos un número y una letra.";
			textosMensajeError[1].classList.add("textoMensajeError");
			tituloCampoContrasena.classList.add("textoFormularioError");
		} else{
			console.log("si v");
			textosMensajeError[1].innerText="";
			//mensajeErrorNombre.classList.remove("textoMensajeError");
			tituloCampoContrasena.classList.remove("textoFormularioError");
			vContrasena=true;
		}
		
		return vContrasena;
	}


	function validarCompararContrasenas () {
		var repetirContrasena=camposInput[2].value;
		var contrasena=camposInput[1].value;
		var vRepetirContrasena=false;

		if((repetirContrasena=="") && (contrasena!="")) {
		    //camposInput[1].focus();
			textosMensajeError[2].innerText="Introduce tu contraseña otra vez.";
			textosMensajeError[2].classList.add("textoMensajeError");
		 	tituloCampoRepetirContrasena.classList.add("textoFormularioError");
		} else if(repetirContrasena!=contrasena) {
			//console.log("rcom2");
			//camposInput[1].focus();
			textosMensajeError[2].innerText="Las contraseñas no coinciden.";
			textosMensajeError[2].classList.add("textoMensajeError");
		 	tituloCampoRepetirContrasena.classList.add("textoFormularioError");
		} else{
		    //camposInput[1].focus();
			textosMensajeError[2].innerText="";
			tituloCampoRepetirContrasena.classList.remove("textoFormularioError");
			vRepetirContrasena=true;
		}
		
		return vRepetirContrasena;
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	function comprobarCorreo() {
	    
	    var correo=camposInput[0].value;
	   
	    let objeto = {
            nombre: correo,
        };

        fetch('https://simplyred.info/crearCuenta0Fetch.php',{
            method: 'POST',
            body: JSON.stringify(objeto),
            headers:{'Content-Type':'application/json; charset=UTF-8'}
        })
        
            .then(response => response.json())
            .then(data => {
                console.log(data);
                var string1 = JSON.stringify(data);
                var string2 = JSON.parse(string1);
                if(string2.usuario[0]=="siexiste"){
                    camposInput[0].focus();
		  	        textosMensajeError[0].innerText="El correo  introducido ya existe.";
			        textosMensajeError[0].classList.add("textoMensajeError");
			        tituloCampoCorreo.classList.add("textoFormularioError");
			        //var prueba=document.getElementById("prueba");
			        //prueba.innerHTML="<h1>Esto es especial</h1><br>"+string2.usuario[0]+"<br><h3>final</h3>";
			        //let nuevop=document.createElement("p");
			        //nuevop.textContent=string2.usuario[0];
			        //prueba.appendChild(nuevop);
			    } else if (string2.usuario[0]=="noexiste"){
                    textosMensajeError[0].innerText="";
			        textosMensajeError[0].classList.remove("textoMensajeError");
			        tituloCampoCorreo.classList.remove("textoFormularioError");
                } else {
                    textosMensajeError[0].innerText="";
			        textosMensajeError[0].classList.remove("textoMensajeError");
                }
            })
            .catch(error => alert("El error es: "+error.message));
	}
	
	
	//setInterval(comprobarCorreo(), 2000);
	//setInterval(() => {comprobarCorreo();}, 2000);
	/*
	function obtenerJSON() {
	    
	    var correo=camposInput[0].value;
	   
	    let objeto = {
            nombre: correo,
        };
	    
      return new Promise((resolve, reject) => {
        setTimeout(() => {
        fetch('https://simplyred.info/crearCuentaFetch.php',{
            method: 'POST',
            body: JSON.stringify(objeto),
            headers:{'Content-Type':'application/json; charset=UTF-8'}
        })
        
          .then((response) => {
            if (response.ok) {
              return response.json();
            }
            reject(
              "No hemos podido recuperar ese json. El código de respuesta del servidor es: " +
                response.status
            );
          
          })
          .then((json) => resolve(json))
          .catch((err) => reject(err));
        }, 2000);
      });
    }
    
   obtenerJSON()
  .then((json) => {
    console.log("el json de respuesta es:", json);
  })
  .catch((err) => {
    console.log("Error encontrado:", err);
  });
  
  */
  
	
	
	
	
	
	
	
	
	
	
	
	
	
	
  
		btnCrearCuenta.addEventListener("click",(ev)=>{

        //crearCuenta();
        
        //ev.preventDefault();
        
        
		var a1,a2,a3;
	
		a1=validarCorreo();
		a2=validarContrasena();
		a3=validarCompararContrasenas();
		//a4=comprobarCorreo();
		
		
		
		//textosMensajeError[0].classList.add("textoMensajeError");
	    /*	console.log(textosMensajeError[0].innerText);
		if(textosMensajeError[0].innerText=="El correo  introducido ya existe.") {
		    a4=false;
		} else {
		    a4=true;
		}*/
		
		//console.log(a4);

	
		
		(!(a1) || !(a2) || !(a3)) ?  ev.preventDefault() : "";
		
	});
	


	
});