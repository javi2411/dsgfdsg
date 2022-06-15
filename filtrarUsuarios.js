window.addEventListener("DOMContentLoaded",()=>{
	

	var opcionesScroll=document.getElementsByClassName("opcionesScroll");
	
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

	var btnAplicarFiltro=document.getElementById("btnAplicarFiltro");
	var btnIrChats=document.getElementById("btnIrChats");
	var btnUsuario=document.getElementById("btnUsuario");

	var textoSobreNosotros=document.getElementById("textoSobreNosotros");
	var textoPrivacidad=document.getElementById("textoPrivacidad");
	var textoPoliticaCookies=document.getElementById("textoPoliticaCookies");
	var textoAccesibilidad=document.getElementById("textoAccesibilidad");

	var variosTextoPaginas=document.getElementsByClassName("variosTextoPaginas");

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




	
	btnUsuario.addEventListener("mouseover",()=>{	
		btnUsuario.classList.add("fondoBtnUsuario");	
		
	})	
	
	btnUsuario.addEventListener("mouseout",()=>{
		btnUsuario.classList.remove("fondoBtnUsuario");
	})
	
	btnAplicarFiltro.addEventListener("mouseover",()=>{	
		btnAplicarFiltro.classList.add("fondoBtnAplicarFiltro");	
		
	})
	
	
	btnAplicarFiltro.addEventListener("mouseout",()=>{
		btnAplicarFiltro.classList.remove("fondoBtnAplicarFiltro");
	})

	btnIrChats.addEventListener("mouseover",()=>{	
		btnIrChats.classList.add("fondoBtnIrChats");	
		
	})
	
	
	btnIrChats.addEventListener("mouseout",()=>{
		btnIrChats.classList.remove("fondoBtnIrChats");
	})
	

	
	



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


	






	for(let i=0; i<=opcionesScroll.length-1; i++) {

		opcionesScroll[i].addEventListener("mouseover",(event)=>{			
			opcionesScroll[i].classList.remove("opcionesScrollOcultar");
			
			/* Captura de los elemtos clase "row" hijos (contienen las fotos y datos de las personas) de
			las clase padre "opcionesScroll" */
			var divPersona=opcionesScroll[i].getElementsByClassName("tamanoTextoPersona"); 
			for(let j=0; j<=divPersona.length-1; j++) {

				divPersona[j].addEventListener("mouseover",(event)=>{
					divPersona[j].classList.add("colorDivPersona");
				})

				divPersona[j].addEventListener("mouseout",(event)=>{
					divPersona[j].classList.remove("colorDivPersona");
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