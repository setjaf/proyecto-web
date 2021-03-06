var usuario;

var tipo_usuario={1:'Administrador',2:'Profesor',3:'Alumno'}

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
			xlsx:'excel',
			csv:'csv',
			sql:'code',
			js:'code',
			py:'code',
			h:'code',
			html:'code',
			css:'code',
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
		console.log(this)
		$("#info_usuario").append(`
			<a href="#" class="usuario_info">
				<img src="${this.foto}" alt="Imagen usuario" width="40">
				
				<p><span id="nombre_usuario">${this.nombre} ${this.paterno} <i class="fas fa-edit" style="font-size: 20px; color: white"></i></span></p>
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

	cargarSolicitudes(){
		$('#solicitudes_body').empty();
		var self = this;
		$.ajax({
			url: 'index-prueba.php',
			type: 'POST',
			dataType: 'json',
			data: {accion: 'getSolicitudes'},
		})
		.done(function(e) {
			if (e.error==0) {
				console.log(e);

				for(var solicitud in e){

					if ( Number.isInteger(parseInt(solicitud)) ) {
						$('#solicitudes_body').append(`
							<div class="media border p-3">`+
								
								(e[solicitud][4]==""?`<i class="fas fa-user" style="font-size: 30px; color: white"></i>`:`<img class="align-self-center mr-3" src="${e[solicitud][4]}" alt="No logramos encontrar la imagen de perfil" width="64">`)+

								`<div class="media-body align-self-center mr-3">
							    	<h5 class="mt-0">${e[solicitud][1]} ${e[solicitud][2]} ${e[solicitud][6]}</h5>
							        <p class="lead mb-0">${tipo_usuario[e[solicitud][3]]}</p>
							        <p class="lead mb-0">Fecha alta: ${e[solicitud][5]}</p>
							  	</div>
							  	<form class="align-self-center mr-3">
							  		<div style="display: none;">
							  			<input type="text" value="${e[solicitud][0]}" name="correo_solicitud">
							  			<input type="text" value="aceptarUsuario" name="accion">
							  		</div>
							  		<button type="submit" class="align-self-center mr-3 btn btn-link"><i class="fas fa-plus-circle" style="font-size: 40px; color: black;"></i></button>					  		
							  	</form>
							   	
							</div>
							`);
					}
					
				}

				self.iniciarForm();
			}else{
				console.log(e);
				$('#mensaje-resp-ajax').html(e.mensaje);
				$('#exampleModal').modal('hide');
				$('#exampleModalCenter').modal("toggle");

			}
		})
		.fail(function(e) {
			console.log(e);
			$('#mensaje-resp-ajax').html(e.responseText);
			$('#exampleModal').modal('hide');
			$('#exampleModalCenter').modal("toggle");
		});
		
	}

	iniciarForm(){
		var self = this;
		$("form").unbind();
		$( "form" ).submit(function( event ) {

					event.preventDefault();

					console.log(event);

					var formElement = event.currentTarget;

					var datos = new FormData(formElement);

					datos.append('correo_usuario',self.correo);
					
					console.log(datos.keys());
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
						if (e.accion=='crearUA') {
							console.log('crearUA');
							console.log(e);
							$('#mensaje-resp-ajax').html(e.mensaje);
							$('#exampleModal').modal('hide');
							$('#exampleModalCenter').modal("toggle");
							self.cargarUAs();

						}else if(e.accion=='aceptarUsuario'){
							
							console.log(e);
							$('#mensaje-resp-ajax').html(e.mensaje);
							$('#exampleModal').modal('hide');
							$('#exampleModalCenter').modal("toggle");
							$('#solicitudes_body').empty();
							self.cargarSolicitudes();
							self.cargarUsuariosActivos();

						}else if (e.accion=='asignarUA') {
							console.log(e);
							$('#mensaje-resp-ajax').html(e.mensaje);
							$('#exampleModal').modal('hide');
							$('#exampleModalCenter').modal("toggle");
						}else if (e.accion=='nuevo_archivo') {
							console.log(e);
							$('#mensaje-resp-ajax').html(e.mensaje);
							$('#exampleModal').modal('hide');
							$('#exampleModalCenter').modal("toggle");
						}else if (e.accion=='eliminarUsuario' ||e.accion=='desactivarUsuario') {
							console.log(e);
							$('#mensaje-resp-ajax').html(e.mensaje);
							$('#exampleModal').modal('hide');
							$('#exampleModalCenter').modal("toggle");
							self.cargarUsuariosActivos();
							self.cargarSolicitudes();
						}
						
						

					}).fail(function(e) {
						console.log(e);
						$('#mensaje-resp-ajax').html(e.responseText);
						$('#exampleModal').modal('hide');
						$('#exampleModalCenter').modal("toggle");
					});
				  
				});	

	}

	cargarProfesores(){

		$('#profesor_prof_ua').empty();

		var self = this;
		$.ajax({
			url: 'index-prueba.php',
			type: 'POST',
			dataType: 'json',
			data: {accion: 'getProfesores'},
		})
		.done(function(e) {
			if (e.error==0) {
				console.log(e);

				$('#profesor_prof_ua').append(`
							<option value="">Selecciona un profesor</option>
							`);

				for(var profesor in e){

					if ( Number.isInteger(parseInt(profesor)) ) {
						$('#profesor_prof_ua').append(`
							<option value="${e[profesor][0]}">${e[profesor][1]} ${e[profesor][2]} ${e[profesor][3]}</option>
							`);
					}
					
				}

			}else{
				$('#mensaje-resp-ajax').html(e.mensaje);
				$('#exampleModal').modal('hide');
				$('#exampleModalCenter').modal("toggle");

			}
		})
		.fail(function(e) {
			console.log(e);
			$('#mensaje-resp-ajax').html(e.responseText);
			$('#exampleModal').modal('hide');
			$('#exampleModalCenter').modal("toggle");
		});

	}

	cargarUAs(){
		
		$('#ua_prof_ua').empty();
		$('#ua_archivo').empty();
		var self = this;
		$.ajax({
			url: 'index-prueba.php',
			type: 'POST',
			dataType: 'json',
			data: {accion: 'getUAs'},
		})
		.done(function(e) {
			if (e.error==0) {
				console.log(e);

				$('#ua_prof_ua').append(`
							<option value="">Selecciona una unidad de aprendizaje</option>
							`);
				$('#ua_archivo').append(`
							<option value="">Selecciona una unidad de aprendizaje</option>
							`);

				for(var ua in e){
					
					if ( Number.isInteger(parseInt(ua)) ) {
						$('#ua_prof_ua').append(`
							<option value="${e[ua][0]}">${e[ua][1]}</option>
							`);
						$('#ua_archivo').append(`
							<option value="${e[ua][0]}">${e[ua][1]}</option>
							`);
					}
					
				}

			}else{
				console.log(e);
				$('#mensaje-resp-ajax').html(e.mensaje);
				$('#exampleModal').modal('hide');
				$('#exampleModalCenter').modal("toggle");

			}
		})
		.fail(function(e) {
			console.log(e);
			$('#mensaje-resp-ajax').html(e.responseText);
			$('#exampleModal').modal('hide');
			$('#exampleModalCenter').modal("toggle");
		});

	}

	cargarUsuariosActivos(){
		$('#usuarios_body').empty();
		var self = this;
		$.ajax({
			url: 'index-prueba.php',
			type: 'POST',
			dataType: 'json',
			data: {accion: 'getUsuariosActivos'},
		})
		.done(function(e) {
			if (e.error==0) {
				console.log(e);

				for(var solicitud in e){

					if ( Number.isInteger(parseInt(solicitud)) ) {
						$('#usuarios_body').append(`
							<div class="media border p-3">`+
								
								(e[solicitud][4]==""?`<i class="fas fa-user" style="font-size: 30px; color: white"></i>`:`<img class="align-self-center mr-3" src="${e[solicitud][4]}" alt="No logramos encontrar la imagen de perfil" width="64">`)+

								`<div class="media-body align-self-center mr-3">
							    	<h5 class="mt-0">${e[solicitud][1]} ${e[solicitud][2]} ${e[solicitud][6]}</h5>
							        <p class="lead mb-0">${tipo_usuario[e[solicitud][3]]}</p>
							        <p class="lead mb-0">Fecha alta: ${e[solicitud][5]}</p>
							  	</div>
							  	<form class="align-self-center mr-3">
							  		<div style="display: none;">
							  			<input type="text" value="${e[solicitud][0]}" name="correo_solicitud">
							  			<input type="text" value="desactivarUsuario" name="accion">
							  		</div>
							  		<button type="submit" class="align-self-center mr-3 btn btn-link"><i class="fas fa-user-times" title="Desactivar usuario" style="font-size: 40px; color: black;"></i></button>					  		
							  	</form>

							  	<form class="align-self-center mr-3">
							  		<div style="display: none;">
							  			<input type="text" value="${e[solicitud][0]}" name="correo_solicitud">
							  			<input type="text" value="eliminarUsuario" name="accion">
							  		</div>
							  		<button type="submit" class="align-self-center mr-3 btn btn-link"><i class="fas fa-user-minus" title="Borrar usuario" style="font-size: 40px; color: black;"></i></button>					  		
							  	</form>
							   	
							</div>
							`);
					}
					
				}

				self.iniciarForm();
			}else{
				console.log(e);
				$('#mensaje-resp-ajax').html(e.mensaje);
				$('#exampleModal').modal('hide');
				$('#exampleModalCenter').modal("toggle");

			}
		})
		.fail(function(e) {
			console.log(e);
			$('#mensaje-resp-ajax').html(e.responseText);
			$('#exampleModal').modal('hide');
			$('#exampleModalCenter').modal("toggle");
		});
		
	}


}

$(document).ready(function() {
	usuario = new Usuario(getCookie('correo'),getCookie('nombre'),getCookie('paterno'),getCookie('rol'),getCookie('foto'));
	usuario.cargarSolicitudes();
	usuario.cargarUsuariosActivos();
	usuario.cargarProfesores();
	usuario.cargarUAs();

	$('#cerrar_sesion').on('click', function() {
		
		usuario.cerrarSesion();
		
	});

});



/*`<div class="media border p-3">
					    <div class="media-body">
					        <p class="lead">Ing. Juan Sanchez Hernandez</p>
					  	</div>
					   <a href=""><i class="fas fa-plus-circle" style="font-size: 40px; color: black;"></i></a>
					</div>`*/