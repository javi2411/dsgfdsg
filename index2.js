window.addEventListener("DOMContentLoaded",()=>{
	
	// CAPTURAMOS LOS ELEMENTOS DEL DOM NECESARIOS.
	var campoCorreo=document.getElementById("campoCorreo");
	var campoContrasena=document.getElementById("campoContrasena");
    var	campoRecordarDatos=document.getElementById("campoRecordarDatos");
    var tituloCampoCorreo=document.getElementById("tituloCampoCorreo");
	var tituloCampoContrasena=document.getElementById("tituloCampoContrasena");
    var textosMensajeError=document.querySelectorAll(".textoMensajeError");
	var textoCheckbox=document.getElementById("textoCheckbox");
	var textoOlvidarContrasena=document.getElementById("textoOlvidarContrasena");
	var btnEntrar=document.getElementById("btnEntrar");
	var btnCrearCuenta=document.getElementById("btnCrearCuenta");
	var btnConfigurarCookies=document.getElementById("btnConfigurarCookies");
	var configurarCookies=document.getElementById("configurarCookies");
	var btnAceptarCookies=document.getElementById("btnAceptarCookies");
	var btnCerrarConfigurarCookies=document.getElementById("btnCerrarConfigurarCookies");
	var pantallaOpacaDesabilitada=document.getElementById("pantallaOpacaDesabilitada");
	var cookies=document.getElementById("cookies");
	var textoSobreNosotros=document.getElementById("textoSobreNosotros");
	var textoPrivacidad=document.getElementById("textoPrivacidad");
	var textoPoliticaCookies=document.getElementById("textoPoliticaCookies");
	var textoAccesibilidad=document.getElementById("textoAccesibilidad");
	var copyright=document.getElementById("copyright");
	
	// CAPTURAMOS LOS EVENTOS NECESARIOS.
	campoContrasena.addEventListener("mouseover",()=>{	
		campoContrasena.classList.add("bordeInputRojo");			
	})
		
	campoContrasena.addEventListener("mouseout",()=>{
		campoContrasena.classList.remove("bordeInputRojo");
	})
	
	campoContrasena.addEventListener("focus",()=>{
		campoContrasena.classList.add("bordeInputRojoImportant");
	})
	
	campoContrasena.addEventListener("blur",()=>{
		campoContrasena.classList.remove("bordeInputRojoImportant");
	})

	campoCorreo.addEventListener("mouseover",()=>{	
		campoCorreo.classList.add("bordeInputRojo");		
	})
	
	campoCorreo.addEventListener("mouseout",()=>{
		campoCorreo.classList.remove("bordeInputRojo");
	})
	
	campoCorreo.addEventListener("focus",()=>{
		campoCorreo.classList.add("bordeInputRojoImportant");
	})
	
	campoCorreo.addEventListener("blur",()=>{
	    grabarCookie("cookiesCorreo", campoCorreo.value, 31536000000);
		campoCorreo.classList.remove("bordeInputRojoImportant");
	})
	
	textoOlvidarContrasena.addEventListener("mouseover",()=>{	
		textoOlvidarContrasena.classList.add("subrayadoYtextoRojo");	
	})
	
	textoOlvidarContrasena.addEventListener("mouseout",()=>{
		textoOlvidarContrasena.classList.remove("subrayadoYtextoRojo");
	})
	
	textoSobreNosotros.addEventListener("mouseover",()=>{	
		textoSobreNosotros.classList.add("subrayadoYtextoBlanco");	
	})
	
	textoSobreNosotros.addEventListener("mouseout",()=>{
		textoSobreNosotros.classList.remove("subrayadoYtextoBlanco");
	})
	
	textoPoliticaCookies.addEventListener("mouseover",()=>{	
		textoPoliticaCookies.classList.add("subrayadoYtextoBlanco");	
	})
	
	textoPoliticaCookies.addEventListener("mouseout",()=>{
		textoPoliticaCookies.classList.remove("subrayadoYtextoBlanco");
	})
	
	textoPrivacidad.addEventListener("mouseover",()=>{	
		textoPrivacidad.classList.add("subrayadoYtextoBlanco");	
	})
	
	textoPrivacidad.addEventListener("mouseout",()=>{
		textoPrivacidad.classList.remove("subrayadoYtextoBlanco");
	})
	
	textoAccesibilidad.addEventListener("mouseover",()=>{	
		textoAccesibilidad.classList.add("subrayadoYtextoBlanco");	
	})
	
	textoAccesibilidad.addEventListener("mouseout",()=>{
		textoAccesibilidad.classList.remove("subrayadoYtextoBlanco");
	})
	
	btnEntrar.addEventListener("mouseover",()=>{	
		btnEntrar.classList.add("fondoBtnEntrar");		
	})
	
	btnEntrar.addEventListener("mouseout",()=>{
		btnEntrar.classList.remove("fondoBtnEntrar");
	})
	
	btnCrearCuenta.addEventListener("mouseover",()=>{	
		btnCrearCuenta.classList.add("fondoBtnCrearCuenta");	
		
	})

	btnCrearCuenta.addEventListener("mouseout",()=>{
		btnCrearCuenta.classList.remove("fondoBtnCrearCuenta");
	})
	
	// FUNCIONES PARA MANEJAR LAS COOKIES.
	/*let leerCookieCorreo=function (nombre) {
        var arrayCookie=document.cookie.split("; ");
        var arrayCookieAux=arrayCookie[1].split("=");
        
        if(arrayCookieAux[0]==nombre) {
            return arrayCookieAux[1];
        } else {
            return false;
        }
    }*/
    
    function leerCookieCorreo(nombre) {
        var lista = document.cookie.split(";");
        for (i in lista) {
             var busca = lista[i].search(nombre);
             if (busca > -1) {micookie=lista[i]}
        }
         var igual = micookie.indexOf("=");
         var valor = micookie.substring(igual+1);
         return valor;
    }
    
    
    
    
    
    
	
	
	let borrarCookie=function (nombre) {
	    console.log(nombre);
        var fechaParaBorrar=new Date(-1).toUTCString();
        var arrayCookie=document.cookie.split("; ");
        console.log(arrayCookie);
              
        for(let i=0; i<=arrayCookie.length-1; i++) {
            var arrayCookieAux=arrayCookie[i].split("=");
            //arrayCookie1[arrayCookieAux[0]]=arrayCookieAux[1]; //Para meter la cookie en un array asociativo.
            if(arrayCookieAux[0]==nombre) {
                document.cookie=nombre+"="+arrayCookieAux[1]+"; "+"expires="+fechaParaBorrar;
            }
        }    
    }


	let grabarCookie=function (nombre, valor, caducidad) {

		if(caducidad<1000) {
		  document.cookie=nombre+"="+valor;
		 } else {
		  let fechahoy=new Date();
		  let fechaCaducidadEnMilisegundos=fechahoy.getTime() + caducidad;
		  let fechaCaducidad=new Date(fechaCaducidadEnMilisegundos);
		  document.cookie=nombre+"="+valor+"; "+"expires="+fechaCaducidad.toUTCString();
		 }
  	}

	function cookieCorreo() {
        
        if(campoRecordarDatos.checked==true) {
            grabarCookie("cookiesCorreo", campoCorreo.value, 31536000000);
        } else {
            borrarCookie("cookiesCorreo");
        }        
    }  
	
	// Al iniciar el script, comprobamos si existen las cookies o no, y hacemos las configuraciones necesarias.
	if(document.cookie=="") { //Si no existen cookies, creamos cookies aceptadas.

        btnConfigurarCookies.addEventListener("click",()=>{
            //btnCrearCuenta.disabled = true; 
            configurarCookies.classList.remove("noVer");
            configurarCookies.classList.add("configurarCookies");
        })
        
        btnCerrarConfigurarCookies.addEventListener("click",()=>{
            configurarCookies.classList.remove("configurarCookies");
            configurarCookies.classList.add("noVer");
        })
        
        btnAceptarCookies.addEventListener("click",()=>{
			grabarCookie("cookiesAceptadas", "S", 31536000000);
            pantallaOpacaDesabilitada.classList.add("noVer");
            cookies.classList.add("noVer");
        })

    } else { // Si existen cookies, eliminamos la aceptación de cookies y comprobamos si existe correo guardado ("recordar datos").
        pantallaOpacaDesabilitada.classList.add("noVer");
        cookies.classList.add("noVer");
       
        if(leerCookieCorreo("cookiesCorreo")!=false) { // Si existe el correo, lo visualizamos en el input.
            campoCorreo.value=leerCookieCorreo("cookiesCorreo");
        }  
    }
	
	// VISUALIZAMOS ALEATORIAMENTEO LAS FOTOS DE LA PRESENTACIÓN.
	function Visor () {

        this.misFotos=[
			"<img class='img-fluid' src='img/index2/pareja1.jpg' alt='Imagen de pareja heterosexual en blanco y negro'>",
            "<img class='img-fluid' src='img/index2/pareja2.jpg' alt='Imagen de pareja heterosexual en blanco y negro'>",           
            "<img class='img-fluid' src='img/index2/pareja3.jpg' alt='Imagen de pareja heterosexual en blanco y negro'>",
			"<img class='img-fluid' src='img/index2/pareja4.jpg' alt='Imagen de pareja heterosexual en blanco y negro'>",
			"<img class='img-fluid' src='img/index2/pareja5.jpg' alt='Imagen de pareja heterosexual en blanco y negro'>",
			"<img class='img-fluid' src='img/index2/pareja6.jpg' alt='Imagen de pareja heterosexual en blanco y negro'>",
			"<img class='img-fluid' src='img/index2/pareja7.jpg' alt='Imagen de pareja heterosexual en blanco y negro'>",
         ];
        
        this.MostrarAleatoria=()=>{
            let numAleat=Math.floor(Math.random()*(7-0)+0);
            if (this.indice==numAleat) {
				setTimeout(ver.MostrarAleatoria());
			} else {
				return this.misFotos[numAleat];
			}
        }
    }

	
    var ver=new Visor();    
    fotoVista=document.getElementById("fotoActual");  
        
    function repetir() {
        fotoVista.innerHTML=ver.MostrarAleatoria();
        subFotoVista=document.getElementById("subFotoActual");
        tituloVisto=document.getElementById("mititulo");
        //tituloVisto.innerHTML=subFotoVista.alt;
        setTimeout(repetir,2000);
    }

    repetir();
	
	//FUNCION QUE VALIDA LA CONTRASEÑA.
    function validarContrasena () {
    	var contrasena=campoContrasena.value;
    	var vContrasena=false;
    		
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
    		console.log("no v");
    		//camposInput[1].focus();
    		textosMensajeError[1].innerText="La contraseña debe contener al menos un número y una letra.";
    		textosMensajeError[1].classList.add("textoMensajeError");
    		tituloCampoContrasena.classList.add("textoFormularioError");
    	} else{
    		console.log("si v");
    		textosMensajeError[1].innerText="";
    		tituloCampoContrasena.classList.remove("textoFormularioError");
    		vContrasena=true;
    	}
    		
    	return vContrasena;
    }

	//FUNCION QUE VALIDA EL CORREO.
    function validarCorreo() {
    	var correo=campoCorreo.value;
    	var vCorreo=false;
    	var expresionCorreo=/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
    	if (correo=="") {
    	    campoCorreo.focus();
    		textosMensajeError[0].innerText="El correo es una campo obligatorio.";
    		textosMensajeError[0].classList.add("textoMensajeError");
    		tituloCampoCorreo.classList.add("textoFormularioError");
    	} else if(!expresionCorreo.test(correo)) {
    		campoCorreo.focus();
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
 
    //CAPTURAMOS EL CLICK EN BOTON ENTRAR Y LLAMAMOS A LAS FUNCIONES CORRESPONDIENTES PARA COMPROBAR. GRABAMOS LA COOKIE CORREO.
    btnEntrar.addEventListener("click",(ev)=>{
        
    	var a1,a2;
    
    	a1=validarCorreo();
    	a2=validarContrasena();
    	    	
    	(!(a1) || !(a2)) ?  ev.preventDefault() : cookieCorreo() ;
    	
    });
    
 })