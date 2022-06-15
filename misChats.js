window.addEventListener("DOMContentLoaded",()=>{
	
    console.log("hola");
	var opcionesScroll=document.getElementsByClassName("opcionesScroll");	

	var tamanoTextoPersona=document.getElementsByClassName("tamanoTextoPersona");	

	var btnAplicarFiltro=document.getElementById("btnAplicarFiltro");
	var btnIrFiltrar=document.getElementById("btnIrFiltrar");
	var btnUsuario=document.getElementById("btnUsuario");
	var btnEnviarMensaje=document.getElementById("btnEnviarMensaje");

	var textoSobreNosotros=document.getElementById("textoSobreNosotros");
	var textoPrivacidad=document.getElementById("textoPrivacidad");
	var textoPoliticaCookies=document.getElementById("textoPoliticaCookies");
	var textoAccesibilidad=document.getElementById("textoAccesibilidad");

	var variosTextoPaginas=document.getElementsByClassName("variosTextoPaginas");
	
	var mostrarPersonas=document.getElementsByClassName("mostrarPersonas");
	var usuarioId=document.getElementsByClassName("usuarioId");
	
	var campoTextoMensaje=document.getElementById("campoTextoMensaje");
	
	var prueba=document.getElementById("prueba");
	
	
	
	
	
	
	 /*var posNuevoChat=mostrarPersonas.length-1;
	 console.log(posNuevoChat);
     var ultimoHijoMostrarPersonas=mostrarPersonas[posNuevoChat].firstChild;
     console.log(mostrarPersonas[posNuevoChat]);
     console.log(ultimoHijoMostrarPersonas);
     ultimoHijoMostrarPersonas.classList.add("colorDivPersona");*/
	
	/*let leerCookieCorreo=function (nombre) {
        var arrayCookie=document.cookie.split("; ");
        console.log(arrayCookie);
        var arrayCookieAux=arrayCookie[1].split("=");
        console.log(arrayCookieAux);
        
        if(arrayCookieAux[0]==nombre) {
            return arrayCookieAux[1];
        } else {
            return false;
        }
    }*/
    
    
    /*let leerCookie=function (nombre) {
		var arrayCookie=document.cookie.split("; ");
			console.log(arrayCookie);
		for(let i=0; i<=arrayCookie.length-1; i++) {
		  var arrayCookieAux=arrayCookie[i].split("=");
		  console.log(arrayCookieAux);
		  //arrayCookie1[arrayCookieAux[0]]=arrayCookieAux[1]; //Para meter la cookie en un array asociativo.
		  console.log(arrayCookieAux[0]);
		  if(arrayCookieAux[0]==nombre) {
			return arrayCookieAux[1];
		  } else {
		      return false;
		  }
		}   
	}*/
	
	function scrollChatAbajo() {
        const nuevoP5=document.createElement("input");
        nuevoP5.type="text";
        prueba.appendChild(nuevoP5); 
        nuevoP5.focus();
        prueba.removeChild(nuevoP5);
        campoTextoMensaje.focus();
    }
            
            
	
	function leerCookie(nombre) {
        var lista = document.cookie.split(";");
        for (i in lista) {
             var busca = lista[i].search(nombre);
             if (busca > -1) {micookie=lista[i]}
        }
         var igual = micookie.indexOf("=");
         var valor = micookie.substring(igual+1);
         return valor;
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
  	
  	
  	//grabarCookie("longitudConversacion", 0, 31536000000);



	numeroUsuarioId=usuarioId[0].getAttribute('id');
		    
	grabarCookie("cookiesUsuarioId", numeroUsuarioId, 31536000000);

	//var checkTodos=document.getElementsByClassName("check0");
	//var inputCheckTodos=document.getElementsByClassName("btn-check");

	for(let i=0; i<=variosTextoPaginas.length-1; i++) {
		variosTextoPaginas[i].addEventListener("mouseover",()=>{
			variosTextoPaginas[i].classList.add("check1");
		})
		
		variosTextoPaginas[i].addEventListener("mouseout",()=>{
			variosTextoPaginas[i].classList.remove("check1");
		})
	}

    var id;
	var timerId=0;
	for(let i=0; i<=mostrarPersonas.length-1; i++) {
		mostrarPersonas[i].addEventListener("click",()=>{
		    console.log("por aqui");
		   
		    grabarCookie("longitudConversacion", 0, 31536000000);
		    
		    numeroChat = mostrarPersonas[i].getAttribute('id');
		    
		    grabarCookie("cookiesChatId", numeroChat, 31536000000);
			
			clearInterval(timerId);
			timerId = setInterval(() => {imprimirConversacion(numeroChat);}, 1250);
            
            //setTimeout(scrollChatAbajo, 1500);
            //prueba.removeChild(nuevoP5);

			//setInterval(() => {imprimirConversacion(i);}, 5000);
		})
	}
	
	//console.log(numeroChat);


	function imprimirConversacion(numeroChat) {
	    
	    //var correo=camposInput[0].value;   

		
		let objeto = {
			nChat: numeroChat,
		};
		
		console.log(objeto);


        fetch('https://simplyred.info/misChatsFetch.php',{
            method: 'POST',
            body: JSON.stringify(objeto),
            headers:{'Content-Type':'application/json; charset=UTF-8'}
        })
        
            .then(response => response.json())
            .then(data => {
                console.log(data);
                //var string1 = JSON.stringify(data);
                //var string2 = JSON.parse(string1);
                
                
                function formatearFecha(fechaSinFormato) {
                    console.log(fechaSinFormato);
                    var arrayAux=fechaSinFormato.split(" ");
                    
                    var arrayFecha=arrayAux[0].split("-");
                    var fecha=arrayFecha[2]+"-"+arrayFecha[1]+"-"+arrayFecha[0];
                    
                    var hora=arrayAux[1];
                    
                    var fechaYhora=fecha+" "+hora;
                    
                    return fechaYhora;
                }
                
                
              
                if(leerCookie("longitudConversacion")<data.length) {
                
                    var textoMensaje=document.getElementById("textoMensaje");
                    
                    // Borramos todos los elementos hijos que existan en el evento capturado (día, mes o año).
        			while (textoMensaje.firstChild) {
        				textoMensaje.removeChild(textoMensaje.firstChild)
        			}
        	
                    
                    for(let i=0; i<data.length; i++) {
                        //for(let j=0; j<data[i].length; j++) {
                        //for(let j=0; j<data[i].length; j++) {
                        
                        if(data[i][0]==leerCookie("cookiesUsuarioId")) {
                            const nuevoP1=document.createElement("span");
                            nuevoP1.style.fontWeight = "bold";
                            nuevoP1.style.borderRadius= "5px"; 
                            nuevoP1.style.padding = "5px";
                            nuevoP1.style.backgroundColor = "#eafaf1"; 
                            nuevoP1.textContent=formatearFecha(data[i][1]);
                            textoMensaje.appendChild(nuevoP1);
                                
                            const nuevoP3=document.createElement("p");
                            nuevoP3.style.maxWidth="650px";
                            nuevoP3.style.borderRadius= "5px";
                            nuevoP3.style.padding = "5px";
                            nuevoP3.style.backgroundColor = "#eafaf1"; 
                            nuevoP3.textContent=data[i][2];
                            textoMensaje.appendChild(nuevoP3);
                                
                            const nuevoP4=document.createElement("br");
                            textoMensaje.appendChild(nuevoP4); 
                                
                                
                                
                                
                                
                        } else {
                            const nuevoP1=document.createElement("span");
                            nuevoP1.style.fontWeight = "bold"
                            nuevoP1.style.borderRadius= "5px"; 
                            nuevoP1.style.padding = "5px";
                            nuevoP1.style.backgroundColor = "#F6EAEA"; 
                            nuevoP1.textContent=formatearFecha(data[i][1]);
                            textoMensaje.appendChild(nuevoP1);
                                
                            const nuevoP3=document.createElement("p");
                            nuevoP3.style.maxWidth="650px";
                            nuevoP3.style.borderRadius= "5px";
                            nuevoP3.style.padding = "5px";
                            nuevoP3.style.backgroundColor = "#F6EAEA"; 
                            nuevoP3.textContent=data[i][2];
                            textoMensaje.appendChild(nuevoP3);
                                
                            const nuevoP4=document.createElement("br");
                            textoMensaje.appendChild(nuevoP4);
                        }
                    }
                    
                    setTimeout(scrollChatAbajo, 1500);
                    grabarCookie("longitudConversacion", data.length, 31536000000);
                    
                }
                
                
                
                
                
                
                
                
                
                /*const nuevoSpan=document.createElement("span");
                nuevoSpan.id="final";
                document.getElementById('final').scrollIntoView(true);
                
                const img = document.createElement("img");
                img.src = "https://lenguajejs.com/assets/logo.svg";
                img.alt = "Logo Javascript";*/
                
                /*document.body.appendChild(img);
                var opcionesScroll=document.getElementsByClassName("opcionesScroll");	
                
                opcionesScroll.scrollTop=opcionesScroll.scrollHeight;
            
                */
                
			   
            })
            .catch(error => alert("El error es: "+error.message));
	}
	
	
	
	btnEnviarMensaje.addEventListener("click",(ev)=>{
	    ev.preventDefault();
	    var chatId=leerCookie("cookiesChatId");
	    var usuarioId=leerCookie("cookiesUsuarioId");
	    var textoMensaje=campoTextoMensaje.value;
	    var recibido="X";
	    
	    var arrayDatosMensaje=[chatId, usuarioId, textoMensaje, recibido];
	    //console.log("El array es: "+arrayDatosMensaje);
	    
	    if(campoTextoMensaje.value!="") {
	        campoTextoMensaje.value="";
	        guardarMensaje(arrayDatosMensaje);
	    }
	    
	    //setTimeout(scrollChatAbajo, 1500);
	    
	    
	    
	    
    })
	
	
	
	function guardarMensaje(arrayDatosMensaje) {
	    
		let objeto2 = {
			chatId: arrayDatosMensaje[0],
			usuarioId: arrayDatosMensaje[1],
			textoMensaje: arrayDatosMensaje[2],
			recibido: arrayDatosMensaje[3],
		};
		
	
		
		
		console.log(objeto2);


        fetch('https://simplyred.info/misChatsFetch2.php',{
            method: 'POST',
            body: JSON.stringify(objeto2),
            headers:{'Content-Type':'application/json; charset=UTF-8'}
        })
        
            .then(response => response.json())
            .then(data => {
                console.log(data);
                //var string1 = JSON.stringify(data);
                //var string2 = JSON.parse(string1);
                
                //var textoMensaje=document.getElementById("textoMensaje");
                
                // Borramos todos los elementos hijos que existan en el evento capturado (día, mes o año).
    			
    			
    			/*
    			while (textoMensaje.firstChild) {
    				textoMensaje.removeChild(textoMensaje.firstChild)
    			}
                
                
                for(let i=0; i<data.length; i++) {
                    for(let j=0; j<data[i].length; j++) {
                    //for(let j=0; j<data[i].length; j++) {
                        const nuevoP=document.createElement("p");
                        nuevoP.textContent=data[i][j];
                        textoMensaje.appendChild(nuevoP);
                        //textoMensaje.innerText=data[i][j];
                        console.log(data[i][j]);
                    }
                } 
                
                */
                
                /*const nuevoSpan=document.createElement("span");
                nuevoSpan.id="final";
                document.getElementById('final').scrollIntoView(true);
                
                const img = document.createElement("img");
                img.src = "https://lenguajejs.com/assets/logo.svg";
                img.alt = "Logo Javascript";*/
                
                /*document.body.appendChild(img);
                var opcionesScroll=document.getElementsByClassName("opcionesScroll");	
                
                opcionesScroll.scrollTop=opcionesScroll.scrollHeight;
            
                */
                
			   
            })
            .catch(error => alert("El error es: "+error.message));
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

    campoTextoMensaje.addEventListener("mouseover",()=>{
		campoTextoMensaje.classList.add("bordeInputRojo");
	})
	
	campoTextoMensaje.addEventListener("mouseout",()=>{
		campoTextoMensaje.classList.remove("bordeInputRojo");
	})

	campoTextoMensaje.addEventListener("focus",()=>{
		campoTextoMensaje.classList.add("bordeInputRojoImportant");
	})
	
	campoTextoMensaje.addEventListener("blur",()=>{
		campoTextoMensaje.classList.remove("bordeInputRojoImportant");
	})









	
	btnUsuario.addEventListener("mouseover",()=>{	
		btnUsuario.classList.add("fondoBtnUsuario");	
		
	})	
	
	btnUsuario.addEventListener("mouseout",()=>{
		btnUsuario.classList.remove("fondoBtnUsuario");
	})
	
	
	btnIrFiltrar.addEventListener("mouseover",()=>{	
		btnIrFiltrar.classList.add("fondoBtnIrFiltrar");	
		
	})
	
	
	btnIrFiltrar.addEventListener("mouseout",()=>{
		btnIrFiltrar.classList.remove("fondoBtnIrFiltrar");
	})
	
	btnEnviarMensaje.addEventListener("mouseover",()=>{	
		btnEnviarMensaje.classList.add("fondoBtnMensaje");	
		
	})	
	
	btnEnviarMensaje.addEventListener("mouseout",()=>{
		btnEnviarMensaje.classList.remove("fondoBtnMensaje");
	})
	
	
	
	/*
    btnAplicarFiltro.addEventListener("mouseover",()=>{	
		btnAplicarFiltro.classList.add("fondoBtnAplicarFiltro");	
		
	})
	
	
	btnAplicarFiltro.addEventListener("mouseout",()=>{
		btnAplicarFiltro.classList.remove("fondoBtnAplicarFiltro");
	})
    */
    
    
    
    // PARA EMPEQUEÑECER EL TEXTO DEL MENSAJE SEGUN SE HACERCA AL FINAL DEL CAMPO INPUT.
    campoTextoMensaje.addEventListener("keydown",()=>{
        
        var textoMensaje=campoTextoMensaje.value;
        
        if(textoMensaje.length>=60) {
            campoTextoMensaje.classList.add("CampoTextoMensajeLetraPequena");	
        }
        
        if(textoMensaje.length>=80) {
            campoTextoMensaje.classList.add("CampoTextoMensajeLetraPequena2");	
        }
        
        if(textoMensaje.length<=60) {           
            campoTextoMensaje.classList.remove("CampoTextoMensajeLetraPequena");	
        }
        
        if(textoMensaje.length<=80) {
            campoTextoMensaje.classList.remove("CampoTextoMensajeLetraPequena2");	
        }
        
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


	




    // PARA OCULTAR DESOCULTAR EL SCROLL Y COLOREAR LOS CHATS ABIERTOS.
	for(let i=0; i<=opcionesScroll.length-1; i++) {

		opcionesScroll[i].addEventListener("mouseover",(event)=>{			
			opcionesScroll[i].classList.remove("opcionesScrollOcultar");
			
			/* Captura de los elemtos clase "row" hijos (contienen las fotos y datos de las personas) de
			las clase padre "opcionesScroll" */
			var divPersona=opcionesScroll[i].getElementsByClassName("tamanoTextoPersona"); 
			
			for(let j=0; j<=divPersona.length-1; j++) {

				divPersona[j].addEventListener("click",(event)=>{
				    
				    // Borramos todos los chats que estuvieran coloreados (sólo será uno).
				    for(let k=0; k<=divPersona.length-1; k++) {
				        divPersona[k].classList.remove("colorDivPersona");
			        }
				    
				    // Coreamos el chat donde se hace click.
					divPersona[j].classList.add("colorDivPersona");
					
					(campoTextoMensaje.disabled==true) ? campoTextoMensaje.disabled=false : campoTextoMensaje.value="" ;	
					
                    
				})
				
			}
			
		})

		opcionesScroll[i].addEventListener("mouseout",()=>{
			opcionesScroll[i].classList.add("opcionesScrollOcultar");
		})
	}

  
	

	
	
	
/*
  btnContinuar.addEventListener("click",(ev)=>{
    
    var a1,a2,a3,a4,a5;

    a1=validarNombre();
    a2=validarLocalidad();
	a3=validarFechaNacimiento();;
    a4=validarGenero();
    a5=validarConocerA();

	(!(a1) || !(a2) || !(a3) || !(a4) || !(a5)) ?  ev.preventDefault() : "";
	
})
*/

});