function getCookie(cname) {
		    var name = cname + "=";
		    var decodedCookie = decodeURIComponent(document.cookie);
		    var ca = decodedCookie.split(';');
		    for(var i = 0; i <ca.length; i++) {
		        var c = ca[i];
		        while (c.charAt(0) == ' ') {
		            c = c.substring(1);
		        }
		        if (c.indexOf(name) == 0) {
		            return c.substring(name.length, c.length);
		        }
		    }
		    return "";
		}

var url = ['','administrador.html','profesor.html','alumno.html'];

class Usuario {

	constructor(correo,nombre,paterno,rol,foto){
		this.correo=correo;
		this.nombre=nombre;
		this.paterno=paterno;
		this.rol=rol;
		this.foto=foto;
		this.iniciarInfo();
		this.fileIcon = {
			'':'upload',
			docx:'word',
			pptx:'powerpoint',
			xslx:'excel',
			csv:'csv',
			sql:'code',
			js:'code',
			py:'code',
			h:'code',
			pdf:'pdf',
			jpg:'image',
			png:'image',
			gif:'image',
			txt:'alt',
			zip:'archive',
			rar:'archive'
		};
	}

	iniciarInfo(){
		$("#info_usuario").append(`
			<a href="${url[this.rol]}" class="usuario_info">
				<img src="${this.foto}" alt="Imagen usuario" width="40">
				
				<p><span id="nombre_usuario">${this.nombre} ${this.paterno} <i class="fas fa-sign-in-alt" style="font-size: 20px; color: white"></i></span></p>
			</a>`);

	}

	cerrarSesion(){

		document.cookie.split(";").forEach(function(c) {

			console.log(c.replace(/^ +/, "").replace(/=.*/,""));
			document.cookie = c.replace(/^ +/, "").replace(/=.*/,"=");


		});

		console.log(document.cookie);

		window.location.replace('index.html');
	}
}

$("#btnregistro").click(function(event) {
	$("#exampleModal").modal("toggle");
});

$( "form" ).submit(function( event ) {
	event.preventDefault();

	console.log(event);

	var formElement = event.currentTarget;

	var datos = new FormData(formElement);

	$.ajax({
		url: 'index-prueba.php',
		contentType: false,
		processData: false,
		cache: false,
		type: 'POST',
		dataType: 'json',
		data: datos,
	}).done(function(e) {
		
		console.log(e);

		if (e.accion == 'login' & e.error == 0) {
			document.cookie="correo="+e.correo;
			document.cookie="nombre="+e.nombre;
			document.cookie="paterno="+e.paterno;
			document.cookie="rol="+e.rol;
			document.cookie="foto="+e.foto;
			document.cookie="max-age=" + 60;

			window.sessionStorage.setItem('correo',e.correo);
			window.sessionStorage.setItem('nombre',e.nombre);
			window.sessionStorage.setItem('paterno',e.paterno);
			window.sessionStorage.setItem('rol',e.rol);
			window.sessionStorage.setItem('foto',e.foto);

			switch(e.rol){
				case '1':
					window.location.replace("administrador.html");
				break;
				case '2':
					window.location.replace("profesor.html");
				break;
				case '3':
					window.location.replace("alumno.html");
				break;
			}
		}else{
			console.log(e);
			$('#mensaje-resp-ajax').html(e.mensaje);
			$('#exampleModal').modal('hide');
			$('#exampleModalCenter').modal("toggle");
		}				
		console.log(document.cookie);
	}).fail(function(e) {
		console.log(e);
		$('#mensaje-resp-ajax').html(e.responseText);
		$('#exampleModal').modal('hide');
		$('#exampleModalCenter').modal("toggle");
	});
  
});


$(document).ready(function() {
	usuario = new Usuario(getCookie('correo'),getCookie('nombre'),getCookie('paterno'),getCookie('rol'),getCookie('foto'));

	$('#cerrar_sesion').on('click', function() {
		
		usuario.cerrarSesion();
		
	});

});

$("input[name='nacimiento']").focusout(function(event) {
	console.log(event.target.value);
	let fecha = new Date(event.target.value);
	let hoy = new Date();
	console.log(fecha,hoy);
	if (fecha>=hoy) {
		$('#mensaje-resp-ajax').html('La fecha no puede ser de hoy o posterior a hoy');
		$('#exampleModal').modal('hide');
		$('#exampleModalCenter').modal("toggle");
		event.target.value="";
	}
	
});


/***Inicia revisión de coincidencia entre campos de contraseña del registro***/

var cont1 = document.getElementById('contrasena_nueva1');
var cont2 = document.getElementById('confirmar_contrasena_nueva1');
var btn_guard = document.getElementById('btn_guard')

cont1.addEventListener('keyup',function () {
	
	if (cont1.value != cont2.value) {
		btn_guard.setAttribute('disabled','disabled');
		$('#contrasena_error').html(`
			<div class="alert alert-danger" role="alert">
				Las contraseñas no son iguales, verifícalas de nuevo.
			</div>`);
	}else if(cont1.value.length<=2 || /[\w.%+-]+@[\w.-]+\.[a-zA-Z]{2,6}/.test(cont1.value) || cont1.value.length>=9){
		btn_guard.setAttribute('disabled','disabled');
		$('#contrasena_error').html(`
			<div class="alert alert-danger" role="alert">
				Las contraseñas no tienen el formato correcto. Longitud de 3 a 8 caracteres, letras minúsculas y mayúsculas, números y * ó +.
			</div>`);
	}else{
		btn_guard.removeAttribute('disabled');
		$('#contrasena_error').html(``);
	}
})
cont2.addEventListener('keyup',function () {
	
	if (cont1.value != cont2.value) {
		btn_guard.setAttribute('disabled','disabled');
		$('#contrasena_error').html(`
			<div class="alert alert-danger" role="alert">
				Las contraseñas no son iguales, verifícalas de nuevo.
			</div>`);
	}else if(cont1.value.length<=2 || /[\w.%+-]+@[\w.-]+\.[a-zA-Z]{2,6}/.test(cont1.value) || cont1.value.length>=9){
		btn_guard.setAttribute('disabled','disabled');
		$('#contrasena_error').html(`
			<div class="alert alert-danger" role="alert">
				Las contraseñas no tienen el formato correcto. Longitud de 3 a 8 caracteres, letras minúsculas y mayúsculas, números y * ó +.
			</div>`);
	}else{
		btn_guard.removeAttribute('disabled');
		$('#contrasena_error').html(``);
	}
})

var cont3 = document.getElementById('contrasena_nueva2');
var cont4 = document.getElementById('confirmar_contrasena_nueva2');
var btn_guard1 = document.getElementById('btn_guard1')

cont3.addEventListener('keyup',function () {
	
	if (cont3.value != cont4.value) {
		btn_guard.setAttribute('disabled','disabled');
		$('#contrasena_error_p').html(`
			<div class="alert alert-danger" role="alert">
				Las contraseñas no son iguales, verifícalas de nuevo.
			</div>`);
	}else if(cont3.value.length<=2 || /[\w.%+-]+@[\w.-]+\.[a-zA-Z]{2,6}/.test(cont3.value) || cont3.value.length>=9){
		btn_guard.setAttribute('disabled','disabled');
		$('#contrasena_error_p').html(`
			<div class="alert alert-danger" role="alert">
				Las contraseñas no tienen el formato correcto. Longitud de 3 a 8 caracteres, letras minúsculas y mayúsculas, números y * ó +.
			</div>`);
	}else{
		btn_guard.removeAttribute('disabled');
		$('#contrasena_error_p').html(``);
	}
})
cont4.addEventListener('keyup',function () {
	
	if (cont3.value != cont4.value) {
		btn_guard.setAttribute('disabled','disabled');
		$('#contrasena_error_p').html(`
			<div class="alert alert-danger" role="alert">
				Las contraseñas no son iguales, verifícalas de nuevo.
			</div>`);
	}else if(cont3.value.length<=2 || /[\w.%+-]+@[\w.-]+\.[a-zA-Z]{2,6}/.test(cont3.value) || cont3.value.length>=9){
		btn_guard.setAttribute('disabled','disabled');
		$('#contrasena_error_p').html(`
			<div class="alert alert-danger" role="alert">
				Las contraseñas no tienen el formato correcto. Longitud de 3 a 8 caracteres, letras minúsculas y mayúsculas, números y * ó +.
			</div>`);
	}else{
		btn_guard.removeAttribute('disabled');
		$('#contrasena_error_p').html(``);
	}
})


var cont5 = document.getElementById('contrasena_nueva3');
var cont6 = document.getElementById('confirmar_contrasena_nueva3');
var btn_guard2 = document.getElementById('btn_guard2')

cont5.addEventListener('keyup',function () {
	
	if (cont5.value != cont6.value) {
		btn_guard.setAttribute('disabled','disabled');
		$('#contrasena_error_a').html(`
			<div class="alert alert-danger" role="alert">
				Las contraseñas no son iguales, verifícalas de nuevo.
			</div>`);
	}else if(cont5.value.length<=2 || /[\w.%+-]+@[\w.-]+\.[a-zA-Z]{2,6}/.test(cont5.value) || cont5.value.length>=9){
		btn_guard.setAttribute('disabled','disabled');
		$('#contrasena_error_a').html(`
			<div class="alert alert-danger" role="alert">
				Las contraseñas no tienen el formato correcto. Longitud de 3 a 8 caracteres, letras minúsculas y mayúsculas, números y * ó +.
			</div>`);
	}else{
		btn_guard.removeAttribute('disabled');
		$('#contrasena_error_a').html(``);
	}
})
cont6.addEventListener('keyup',function () {
	
	if (cont5.value != cont6.value) {
		btn_guard.setAttribute('disabled','disabled');
		$('#contrasena_error_a').html(`
			<div class="alert alert-danger" role="alert">
				Las contraseñas no son iguales, verifícalas de nuevo.
			</div>`);
	}else if(cont5.value.length<=2 || /[\w.%+-]+@[\w.-]+\.[a-zA-Z]{2,6}/.test(cont5.value) || cont5.value.length>=9){
		btn_guard.setAttribute('disabled','disabled');
		$('#contrasena_error_a').html(`
			<div class="alert alert-danger" role="alert">
				Las contraseñas no tienen el formato correcto. Longitud de 3 a 8 caracteres, letras minúsculas y mayúsculas, números y * ó +.
			</div>`);
	}else{
		btn_guard.removeAttribute('disabled');
		$('#contrasena_error_a').html(``);
	}
});