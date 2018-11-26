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
		this.permisos=this.llenarPermisos(this.rol);
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

	llenarPermisos(rol){
		var permisos={};
		$.ajax({
			url: 'index-prueba.php',
			type: 'POST',
			dataType: 'json',
			data: {'accion':'getPermisos','rol': rol},
		})
		.done(function(e) {

			if (e.error==0) {
				for(var permiso in e){

					if ( Number.isInteger(parseInt(permiso)) ) {
						permisos[e[permiso][1]]=true;
					}
					
				}				
			}else{

				$('#mensaje-resp-ajax').html(e.mensaje);
				$('#exampleModal').modal('hide');
				$('#exampleModalCenter').modal("toggle");

			}
			
		})
		.fail(function(e) {
			$('#mensaje-resp-ajax').html(e.responseText);
			$('#exampleModal').modal('hide');
			$('#exampleModalCenter').modal("toggle");
		});

		return permisos;
		
	}

	iniciarInfo(){
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


	iniciarForm(){
		var self = this;
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
						if (e.accion=='crearGrupo') {
							console.log('crearGrupo');
							console.log(e);
							$('#mensaje-resp-ajax').html(e.mensaje);
							$('#exampleModal').modal('hide');
							$('#exampleModal1').modal('hide');
							$('#exampleModalCenter').modal("toggle");
							self.cargarGrupos();

						}else if(e.accion=='eliminarGrupo'){
							
							console.log(e);
							$('#mensaje-resp-ajax').html(e.mensaje);
							$('#exampleModal').modal('hide');
							$('#exampleModal1').modal('hide');
							$('#exampleModalCenter').modal("toggle");
							$('#solicitudes_body').empty();
							self.cargarGrupos();

						}else if (e.accion=='nuevo_archivo') {
							console.log(e);
							$('#mensaje-resp-ajax').html(e.mensaje);
							$('#exampleModal').modal('hide');
							$('#exampleModalCenter').modal("toggle");
						}
						else if (e.accion=='nueva_tarea') {
							console.log(e);
							$('#mensaje-resp-ajax').html(e.mensaje);
							$('#exampleModal').modal('hide');
							$('#exampleModalCenter').modal("toggle");
						}
						
						

					}).fail(function(e) {
						console.log(e);
						$('#mensaje-resp-ajax').html(e.responseText);
						$('#exampleModal').modal('hide');
						$('#exampleModalCenter').modal("toggle");
					});
				  
				});	

	}


	cargarUAs(){

		var self = this;
		$.ajax({
			url: 'index-prueba.php',
			type: 'POST',
			dataType: 'json',
			data: {accion: 'getUAs',correo_usuario:self.correo},
		})
		.done(function(e) {
			if (e.error==0) {

				for(var ua in e){
					
					if ( Number.isInteger(parseInt(ua)) ) {
						$('#uas_nuevo_grupo').append(`
							<option value="${e[ua][0]}">${e[ua][1]}</option>
							`);
						$('#ua_archivo').append(`
							<option value="${e[ua][0]}">${e[ua][1]}</option>
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
			$('#mensaje-resp-ajax').html(e.responseText);
			$('#exampleModal').modal('hide');
			$('#exampleModalCenter').modal("toggle");
		});

	}

	cargarGrupos(){

		$('#grupo_lista').empty();
		$('#grupos_creados').empty();
		$('#grupo_lista').append(`
							<option value="">Selecciona el grupo a eliminar</option>
							`);
		
		var self = this;
		$.ajax({
			url: 'index-prueba.php',
			type: 'POST',
			dataType: 'json',
			data: {accion: 'getGrupos', correo_usuario:self.correo},
		})
		.done(function(e) {
			if (e.error==0) {

				for(var grupo in e){
					
					if ( Number.isInteger(parseInt(grupo)) ) {
						$('#grupo_lista').append(`
							<option value="${e[grupo][0]}">${e[grupo][1]}</option>
							`);
						$('#grupos_creados').append(`
							<div class="col-sm-12">
								<div class="media border p-3">

									<div class="container col-sm-5">
										<div class="titulo">
											<h1 class="display-3">
												<span style="color:#1169a3; font-family: 'Rajdhani', sans-serif; font-size: 40px;">${e[grupo][1]}</span>
											</h1>								
											<br>
											<br>
										</div>
									</div>

									<div class="media-body col-sm-7">
								   		<h5 class="">

											<span style="color:#1169a3; font-family: 'Rajdhani', sans-serif;">Tareas asigandas</span>
										</h5>
								   		<div id="grupo_${e[grupo][0]}" class="row">
								   		</div>
								   		
										<br>
										<br>
									</div>
														
								</div>

							</div>
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
			$('#mensaje-resp-ajax').html(e.responseText);
			$('#exampleModal').modal('hide');
			$('#exampleModalCenter').modal("toggle");
		});

		/* Carga de grupos con tareas*/

		$.ajax({
			url: 'index-prueba.php',
			type: 'POST',
			dataType: 'json',
			data: {accion: 'getGruposArchivos', correo_usuario:self.correo},
		})
		.done(function(e) {
			if (e.error==0) {
				console.log(e);

				for(var tareas in e){
					
					if ( Number.isInteger(parseInt(tareas)) ) {
						console.log(self.fileIcon[ e[tareas][4].substring(e[tareas][4].lastIndexOf('.')+1) ]);
						$('#grupo_'+e[tareas][0]).append(`
							<div class="col-4">

								<a href="${e[tareas][4]}">
									<i class="fas fa-file-${self.fileIcon[ e[tareas][4].substring(e[tareas][4].lastIndexOf('.')+1) ]}" style="font-size: 40px; color: black;"></i>
									<h6>${e[tareas][2]}</h6>
									<h6>${e[tareas][5]}</h6>
								</a>

							</div>
							
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
			$('#mensaje-resp-ajax').html(e.responseText);
			$('#exampleModal').modal('hide');
			$('#exampleModalCenter').modal("toggle");
		});

	}

	cargarArchivos(){		
		var self = this;
		$.ajax({
			url: 'index-prueba.php',
			type: 'POST',
			dataType: 'json',
			data: {accion: 'getArchivos', correo_usuario:self.correo},
		})
		.done(function(e) {
			if (e.error==0) {

				for(var archivo in e){
					
					if ( Number.isInteger(parseInt(archivo)) ) {
						$('#archivos_creados').append(`
							<div class="media-body-c text-center col-sm-3">

								<a href="${e[archivo][3]}">
									<i class="fas fa-file-${self.fileIcon[ e[archivo][3].substring(e[archivo][3].lastIndexOf('.')+1) ]}" style="font-size: 140px; color: black;"></i>
									<h6>${e[archivo][0]}</h6>
									<h6>${e[archivo][3].substring(e[archivo][3].lastIndexOf('/')+1)}</h6>
									<h6>${e[archivo][2]}</h6>
								</a>
								
							</div>
							`);
						$('#archivo_lista').append(`
							<option value="${e[archivo][6]}">${e[archivo][0]}</option>
							`)

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

	
}

$(document).ready(function() {
	usuario = new Usuario(getCookie('correo'),getCookie('nombre'),getCookie('paterno'),getCookie('rol'),getCookie('foto'));
	
	usuario.iniciarForm();
	
	usuario.cargarUAs();
	
	usuario.cargarGrupos();

	usuario.cargarArchivos();

	$('#cerrar_sesion').on('click', function() {
		
		usuario.cerrarSesion();
		
	});
});
