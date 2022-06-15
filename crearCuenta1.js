window.addEventListener("DOMContentLoaded",()=>{
	
	var campoNombre=document.getElementById("campoNombre");
	var campoLocalidad=document.getElementById("campoLocalidad");
	var campoFechaNacimiento=document.getElementsByClassName("bordeCampoFecha");
	var labelDia=document.querySelectorAll("label[for=campoDia]");
	var labelMes=document.querySelectorAll("label[for=campoMes]");
	var labelAno=document.querySelectorAll("label[for=campoAno]");
	var checkSoyHombre=document.getElementById("checkSoyHombre");
	var inputCheckSoyHombre=document.getElementById("inputCheckSoyHombre");
	var checkSoyMujer=document.getElementById("checkSoyMujer");
	var inputCheckSoyMujer=document.getElementById("inputCheckSoyMujer");
	var checkBuscoHombres=document.getElementById("checkBuscoHombres");
	var inputCheckBuscoHombres=document.getElementById("inputCheckBuscoHombres");
	var checkBuscoMujeres=document.getElementById("checkBuscoMujeres");
	var inputCheckBuscoMujeres=document.getElementById("inputCheckBuscoMujeres");
	var btnContinuar=document.getElementById("btnContinuar");
	var textoSobreNosotros=document.getElementById("textoSobreNosotros");
	var textoPrivacidad=document.getElementById("textoPrivacidad");
	var textoPoliticaCookies=document.getElementById("textoPoliticaCookies");
	var textoAccesibilidad=document.getElementById("textoAccesibilidad");
	var tituloCampoNombre=document.getElementById("tituloCampoNombre");
	var tituloCampoLocalidad=document.getElementById("tituloCampoLocalidad");
	var tituloCampoFecha=document.getElementById("tituloCampoFecha");
	//var labelsFecha=tituloCampoFecha.getElementsByTagName("label");
	var tituloCampoGenero=document.getElementById("tituloCampoGenero");
	var tituloCampoConocerA=document.getElementById("tituloCampoConocerA");
	var mensajeErrorNombre=document.getElementById("mensajeErrorNombre");
	var mensajeErrorLocalidad=document.getElementById("mensajeErrorLocalidad");
	var mensajeErrorFecha=document.getElementById("mensajeErrorFecha");
	var mensajeErrorGenero=document.getElementById("mensajeErrorGenero");
	var mensajeErrorConocerA=document.getElementById("mensajeErrorConocerA");
	
	campoNombre.addEventListener("mouseover",()=>{	
		campoNombre.classList.add("bordeInputRojo");	
	})	
	
	campoNombre.addEventListener("mouseout",()=>{
		campoNombre.classList.remove("bordeInputRojo");
	})
	
	campoNombre.addEventListener("focus",()=>{
		campoNombre.classList.add("bordeInputRojoImportant");
	})
	
	campoNombre.addEventListener("blur",()=>{
		campoNombre.classList.remove("bordeInputRojoImportant");
	})
	
	campoLocalidad.addEventListener("mouseover",()=>{	
		campoLocalidad.classList.add("bordeInputRojo");	
	})
	
	campoLocalidad.addEventListener("mouseout",()=>{
		campoLocalidad.classList.remove("bordeInputRojo");
	})
	
	campoLocalidad.addEventListener("focus",()=>{
		campoLocalidad.classList.add("bordeInputRojoImportant");
	})	
	
	campoLocalidad.addEventListener("blur",()=>{
		campoLocalidad.classList.remove("bordeInputRojoImportant");
	})
	
	// CAPTURA EVENTOS CAMPOS "FECHA NACIMIENTO" de DIA, MES O AÑO.
	for (var i=0; i<=campoFechaNacimiento.length-1; i++) {
        //Añado un evento a cada elemento
        campoFechaNacimiento[i].addEventListener("mouseover",function(event) {
			event.target.classList.remove("bordeCampoFecha");
			event.target.classList.add("bordeInputRojo");	
        });

		campoFechaNacimiento[i].addEventListener("mouseout",function(event) {
			event.target.classList.remove("bordeInputRojo");
			event.target.classList.add("bordeCampoFecha");
        });

		campoFechaNacimiento[i].addEventListener("focus",function(event) {
			event.target.classList.add("bordeInputRojoImportant");
			datepicket(event);

        });

		campoFechaNacimiento[i].addEventListener("blur",function(event) {
			event.target.classList.remove("bordeInputRojoImportant");
        });
    }

	// RELLENAMOS LOS CAMPOS DIA, MES Y AÑO CON SUS VALORES, SEGÚN EL EVENTO PASADO.
	function datepicket(event){

			// Borramos los "---" la primera vez que se hace click en el campo.
			//let ElementosHijosOption=event.target.children.length;			
			//(ElementosHijosOption==1) ? event.target.removeChild(event.target.children[0]) : "" ;

			// Borramos todos los elementos hijos que existan en el evento capturado (día, mes o año).
			while (event.target.firstChild) {
				event.target.removeChild(event.target.firstChild)
			}

			// Rellenamos el evento capturado con los días, meses o año, según corresponda.
			switch(event.target.id){
				
				case("campoDia") :	for(let i=0; i<=30; i++) {
										let nuevoDia=document.createElement("option")
										nuevoDia.textContent=(i+1);
										event.target.appendChild(nuevoDia);
									}
									break;

				case("campoMes") :	var arrayMes=["enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"];
									
									for(let i=0; i<=11; i++) {
										let nuevoMes=document.createElement("option")
										nuevoMes.textContent=(arrayMes[i]);
										event.target.appendChild(nuevoMes);
									}
									break;

				case("campoAno") :	let fecha=new Date(Date.now());
									
									for(let i=fecha.getFullYear() ; i>=fecha.getFullYear()-100; i--) {
										let nuevoAno=document.createElement("option")
										nuevoAno.textContent=(i);
										event.target.appendChild(nuevoAno);
									}
									break;
			} 
	}

	// CAPTURA EVENTOS CAMPO CHECKSOYHOMBRE
	checkSoyHombre.addEventListener("mouseover",()=>{
		checkSoyHombre.classList.add("check1");
	})
	
	checkSoyHombre.addEventListener("mouseout",()=>{
		checkSoyHombre.classList.remove("check1");
	})
	
	checkSoyHombre.addEventListener("click",()=>{
		if(inputCheckSoyHombre.checked==false) {
			checkSoyHombre.classList.add("check2");
			inputCheckSoyHombre.checked=true;
			checkSoyMujer.classList.remove("check2");
			inputCheckSoyMujer.checked=false;
		} 
		else {
			checkSoyHombre.classList.remove("check2");
			inputCheckSoyHombre.checked=false;
		}
	})
	
	checkSoyMujer.addEventListener("mouseover",()=>{
		checkSoyMujer.classList.add("check1");
	})
	
	checkSoyMujer.addEventListener("mouseout",()=>{
		checkSoyMujer.classList.remove("check1");
	})
	
	checkSoyMujer.addEventListener("click",()=>{
		if(inputCheckSoyMujer.checked==false) {
			checkSoyMujer.classList.add("check2");
			inputCheckSoyMujer.checked=true;
			checkSoyHombre.classList.remove("check2");
			inputCheckSoyHombre.checked=false;
		} 
		else {
			checkSoyMujer.classList.remove("check2");
			inputCheckSoyMujer.checked=false;
		}
	})
	
	checkBuscoHombres.addEventListener("mouseover",()=>{
		checkBuscoHombres.classList.add("check1");
	})
	
	checkBuscoHombres.addEventListener("mouseout",()=>{
		checkBuscoHombres.classList.remove("check1");
	})
	
	checkBuscoHombres.addEventListener("click",()=>{
		if(inputCheckBuscoHombres.checked==false) {
			checkBuscoHombres.classList.add("check2");
			inputCheckBuscoHombres.checked=true;
			checkBuscoMujeres.classList.remove("check2");
			inputCheckBuscoMujeres.checked=false;
		} 
		else {
			checkBuscoHombres.classList.remove("check2");
			inputCheckBuscoHombres.checked=false;
		}
	})
	
	checkBuscoMujeres.addEventListener("mouseover",()=>{
		console.log("hola");
		checkBuscoMujeres.classList.add("check1");
	})
	
	checkBuscoMujeres.addEventListener("mouseout",()=>{
		checkBuscoMujeres.classList.remove("check1");
	})
	
	checkBuscoMujeres.addEventListener("click",()=>{
		if(inputCheckBuscoMujeres.checked==false) {
			checkBuscoMujeres.classList.add("check2");
			inputCheckBuscoMujeres.checked=true;
			checkBuscoHombres.classList.remove("check2");
			inputCheckBuscoHombres.checked=false;
		} 
		else {
			checkBuscoMujeres.classList.remove("check2");
			inputCheckBuscoMujeres.checked=false;
		}
	})
	
	btnContinuar.addEventListener("mouseover",()=>{	
		btnContinuar.classList.add("fondoBtnContinuar");	
		
	})
	
	
	btnContinuar.addEventListener("mouseout",()=>{
		btnContinuar.classList.remove("fondoBtnContinuar");
	})	
	
	btnIniciarSesion.addEventListener("mouseover",()=>{	
		btnIniciarSesion.classList.add("fondoBtnIniciarSesion");			
	})	
	
	btnIniciarSesion.addEventListener("mouseout",()=>{
		btnIniciarSesion.classList.remove("fondoBtnIniciarSesion");
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



	function validarNombre () {
		var nombre=campoNombre.value;
		console.log(nombre);
		var vNombre=false;
		//var expresionNombre=/[a-zA-Zñáéíóú'´¨äëïöï\s]{2,25}/;
		var expresionNombre=/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]{1,25}$/;
		if (nombre=="") {
		  campoNombre.focus();
		  mensajeErrorNombre.innerText="El nombre es una campo obligatorio.";
		  mensajeErrorNombre.classList.add("textoMensajeError");
		  tituloCampoNombre.classList.add("textoFormularioError");
		} else if(!expresionNombre.test(nombre)) {
			campoNombre.focus();
			mensajeErrorNombre.innerText="El nombre no puede contener números ni símbolos especiales.";
			mensajeErrorNombre.classList.add("textoMensajeError");
			tituloCampoNombre.classList.add("textoFormularioError");
		} else{
			mensajeErrorNombre.innerText="";
			//mensajeErrorNombre.classList.remove("textoMensajeError");
			tituloCampoNombre.classList.remove("textoFormularioError");
			vNombre=true;
		}
		
		return vNombre;
	}

	function validarLocalidad () {
		var localidad=campoLocalidad.value;
		//console.log(nombre);
		var vLocalidad=false;
		//var expresionNombre=/[a-zA-Zñáéíóú'´¨äëïöï\s]{2,25}/;
		var expresionLocalidad=/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]{1,25}$/;
		if (localidad=="") {
		  campoLocalidad.focus();
		  mensajeErrorLocalidad.innerText="La localidad es un campo obligatorio.";
		  mensajeErrorLocalidad.classList.add("textoMensajeError");
		  tituloCampoLocalidad.classList.add("textoFormularioError");
		} else if(!expresionLocalidad.test(localidad)) {
			campoLocalidad.focus();
			mensajeErrorLocalidad.innerText="La localidad no puede contener números ni símbolos especiales.";
			mensajeErrorLocalidad.classList.add("textoMensajeError");
			tituloCampoLocalidad.classList.add("textoFormularioError");
		} else{
			mensajeErrorLocalidad.innerText="";
			//mensajeErrorLocalidad.classList.remove("textoMensajeError");
			tituloCampoLocalidad.classList.remove("textoFormularioError");
			vLocalidad=true;
		}
		
		return vLocalidad;

	}
	


	function validarFechaNacimiento () {
		var vFecha=false;
		var dia=campoDia.value;
		var mes=campoMes.value;
		//console.log("el mes es: "+mes);
		var ano=campoAno.value;
		var arrayMes=["enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"];
		var arrayFechaError=["02-29","02-30","02-31","04-31","06-31","09-31","11-31"];
		
		// Si el eño es bisiesto, elimina la primera fecha del array.
		(((ano % 4 == 0) && (ano % 100 != 0 )) || (ano % 400 == 0)) ? arrayFechaError.shift() : "";

		// Pasamos el mes en letra introducido por el cliente, a número de dos cifras.
		for(let i=0; i<=arrayMes.length-1; i++) {
			if(arrayMes[i]==mes) {
				mes=i+1;
				(mes.toString().length==1) ? mes="0"+mes : "" ;
				console.log(mes.toString());
			}
		}

		// Comprobamos si el día, mes o año se ha quedado sin seleccionar.
		if((isNaN(dia)) || (isNaN(mes)) || (isNaN(ano))) {

			// Marcamos en rojo la etiqueta label día, mes o año, según el campo no esté seleccionado.
			(isNaN(dia)) ? labelDia[0].classList.add("textoFormularioError") : labelDia[0].classList.remove("textoFormularioError") ;
			(isNaN(mes)) ? labelMes[0].classList.add("textoFormularioError") : labelMes[0].classList.remove("textoFormularioError") ;
			(isNaN(ano)) ? labelAno[0].classList.add("textoFormularioError") : labelAno[0].classList.remove("textoFormularioError")  ;
			//(isNaN(dia)) ? labelsFecha[0].classList.add("textoFormularioError") : labelsFecha[0].classList.remove("textoFormularioError") ;
			//(isNaN(mes)) ? labelsFecha[1].classList.add("textoFormularioError") : labelsFecha[1].classList.remove("textoFormularioError") ;
			//(isNaN(ano)) ? labelsFecha[2].classList.add("textoFormularioError") : labelsFecha[2].classList.remove("textoFormularioError")  ;


			mensajeErrorFecha.innerText="La fecha no puede contener campos sin rellenar.";
			mensajeErrorFecha.classList.add("textoMensajeError");
			tituloCampoFecha.classList.add("textoFormularioError");

			return vFecha;

		} else {
			mensajeErrorFecha.innerText="";
			//mensajeErrorLocalidad.classList.remove("textoMensajeError");
			labelDia[0].classList.remove("textoFormularioError");
			labelMes[0].classList.remove("textoFormularioError");
			labelAno[0].classList.remove("textoFormularioError");
			tituloCampoFecha.classList.remove("textoFormularioError");
		}
		
		// Pasamos el dia en letra introducido por el cliente a número de dos cifras.
		(dia.toString().length==1) ? dia="0"+dia : "";

		// Componemos en formato "date" la fecha introducida por el cliente.
		var fecha=ano+"-"+mes+"-"+dia;

		// Comprobamos si la fecha introducida existe en el calendario comparando con arrayFechaError.
		for(let i=0; i<=arrayFechaError.length-1; i++) {
			if(ano+"-"+arrayFechaError[i]==fecha) {
				mensajeErrorFecha.innerText="La fecha introducida no existe.";
				mensajeErrorFecha.classList.add("textoMensajeError");
				tituloCampoFecha.classList.add("textoFormularioError");
				return vFecha;
			} 
		}

		// Comprobamos con la fecha introducida que el cliente tiene mas de 18 años.
		var dieciochoAnosMilisegundos=(((((1000*60)*60)*24)*365)*18)+259200000; //259200000 son tres días de error.
		var fechaActual=new Date();
		var fechaCliente=new Date(fecha);
		var edadMilisegundos=fechaActual.getTime() - fechaCliente.getTime();
		if(edadMilisegundos<=dieciochoAnosMilisegundos) {
			mensajeErrorFecha.innerText="La fecha muestra que es menor 18 años.";
			mensajeErrorFecha.classList.add("textoMensajeError");
			tituloCampoFecha.classList.add("textoFormularioError");
			return vFecha;
		}

		vFecha=true;
		return vFecha;
	}
		

	function validarGenero () {
		var vGenero;
		
		if((inputCheckSoyHombre.checked==true) || (inputCheckSoyMujer.checked==true))  {
			mensajeErrorGenero.innerText="";
			tituloCampoGenero.classList.remove("textoFormularioError");
			vGenero=true;
		} else {
			mensajeErrorGenero.innerText="El género es un campo obligatorio.";
			mensajeErrorGenero.classList.add("textoMensajeError");
			tituloCampoGenero.classList.add("textoFormularioError");
			vGenero=false;
		}
		
		return vGenero;
	}


	function validarConocerA () {
		var vGenero;
		console.log("conocerA")
		if((inputCheckBuscoHombres.checked==true) || (inputCheckBuscoMujeres.checked==true))  {
			mensajeErrorConocerA.innerText="";
			tituloCampoConocerA.classList.remove("textoFormularioError");
			vGenero=true;
		} else {
			mensajeErrorConocerA.innerText="\"Querer conocer a\" alguien es un campo obligatorio.";
			mensajeErrorConocerA.classList.add("textoMensajeError");
			tituloCampoConocerA.classList.add("textoFormularioError");
			vGenero=false;
		}
		
		return vGenero;
	}


  btnContinuar.addEventListener("click",(ev)=>{
    
    var a1,a2,a3,a4,a5;

    a1=validarNombre();
    a2=validarLocalidad();
	a3=validarFechaNacimiento();;
    a4=validarGenero();
    a5=validarConocerA();

	(!(a1) || !(a2) || !(a3) || !(a4) || !(a5)) ?  ev.preventDefault() : "";
	
})


});