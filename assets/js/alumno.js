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
						if (e.accion=='getGrupos') {
							
							if (e.error == 0) {

								console.log("buscarGrupos")

								self.mostrarGrupos_buscar(e);
								
							}else {
								$('#mensaje-resp-ajax').html(e.mensaje);
								$('#exampleModal').modal('hide');
								$('#exampleModal1').modal('hide');
								$('#exampleModalCenter').modal("toggle");
							}

						}else if(e.accion=='inscribirGrupo'){
							self.cargarGrupos();
							$('#mensaje-resp-ajax').html(e.mensaje);
							$('#exampleModal').modal('hide');
							$('#exampleModal1').modal('hide');
							$('#exampleModalCenter').modal("toggle");
							$("#buscar_grupos").submit();

						}else if (e.accion=='enviarTarea') {
							$('#descripcion_tarea').val('');
							$('#fechaentrega_tarea').val('');
							$('#archivo_tarea').empty();
							$('#inst_tarea').empty();
							$('#exampleModal1').modal('hide');

							$('#alumno_grupos').val("").change();	
							$('#alumno_grupos_tarea').val("").change();

							$('#mensaje-resp-ajax').html(e.mensaje);
							$('#exampleModal').modal('hide');
							$('#exampleModalCenter').modal("toggle");
						}
						else if (e.accion=='salirGrupo') {
							self.cargarGrupos();
							$("#buscar_grupos").submit();
							$('#exampleModal12').modal('hide');
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
		
		$('#uas_buscar').empty();
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

				$('#uas_buscar').append(`
							<option value="">Selecciona una unidad de aprendizaje</option>
							`);
				$('#ua_archivo').append(`
							<option value="">Selecciona una unidad de aprendizaje</option>
							`);

				for(var ua in e){
					
					if ( Number.isInteger(parseInt(ua)) ) {
						$('#uas_buscar').append(`
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

	cargarProfesores(ua=null){

		$('#profesores_buscar').empty();

		var self = this;
		$.ajax({
			url: 'index-prueba.php',
			type: 'POST',
			dataType: 'json',
			data: {accion: 'getProfesores',ua_buscar:ua},
		})
		.done(function(e) {
			if (e.error==0) {
				console.log(e);

				$('#profesores_buscar').append(`
							<option value="">Selecciona un profesor</option>
							`);

				for(var profesor in e){

					if ( Number.isInteger(parseInt(profesor)) ) {
						$('#profesores_buscar').append(`
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

	mostrarGrupos_buscar(e){

		console.log(e);

		var self=this;

		$('#grupos_buscar').empty();
	
		for(var grupo in e){
			
			if ( Number.isInteger(parseInt(grupo)) ) {
				$('#grupo_lista').append(`
					<option value="${e[grupo][0]}">${e[grupo][1]}</option>
					`);
				$('#grupos_buscar').append(`
					<div class="col-sm-12">
						<div class="media border p-3">

							<div class="container col-sm-5">
								<div class="titulo">
									<h1 class="display-3">
										<span style="color:#1169a3; font-family: 'Rajdhani', sans-serif; font-size: 40px;">${e[grupo][1]}</span>
									</h1>
									<h2>
										<span style="color:#1169a3; font-size: 30px;">${e[grupo][3]} ${e[grupo][4]} ${e[grupo][5]}</span>
									</h2>

									<h2>
										<span style="color:#1169a3; font-size: 20px;">${e[grupo][6]}</span>
									</h2>
								</div>
							</div>

							<div class="media-body col-sm-7 ">
						   		<div class="row">
						   			<div class="col-12 text-center">
						   				<h5 class="">
											<span style="color:#1169a3; font-family: 'Rajdhani', sans-serif;">Alumnos inscritos</span>
											
										</h5>
										<p class="display-4" style="color:#1169a3;font-family: 'Rajdhani', sans-serif;"">${e[grupo][2]}</p>
						   			</div>
						   			<div class="col-12 text-center">
						   				<h5 class="">
											<span style="color:#1169a3; font-family: 'Rajdhani', sans-serif;">Inscribirme al grupo</span>
											
										</h5>
						   				<form action="">
						   					<input type="text" name="grupo_inscribir" value="${e[grupo][0]}" hidden/>
						   					<input type="text" name="accion" value="inscribirGrupo" hidden/>
						   					<button type="submit" class="btn btn-link"><i class="fas fa-plus-circle" style="font-size: 40px; color: #1169a3"></i></button>
						   				</form>
						   			</div>
						   		</div>
							</div>
												
						</div>

					</div>
					`);
			}
			
		}

		self.iniciarForm();
		
	}

	cargarGrupos(){

		
		$('#alumno_grupos').empty();
		$('#alumno_grupos').append(`
							<option value="">Selecciona un grupo</option>
							`);
		$('#alumno_grupos_tarea').empty();
		$('#alumno_grupos_tarea').append(`
							<option value="">Selecciona un grupo</option>
							`);
		$('#grupos_salir').empty();
		$('#grupos_salir').append(`
							<option value="">Selecciona un grupo</option>
							`);

		var self = this;
		$.ajax({
			url: 'index-prueba.php',
			type: 'POST',
			dataType: 'json',
			data: {accion: 'getGruposAlumno', correo_usuario:self.correo},
		})
		.done(function(e) {
			console.log(e);
			if (e.error==0) {

				for(var grupo in e){
					
					if ( Number.isInteger(parseInt(grupo)) ) {
						$('#alumno_grupos').append(`
							<option value="${e[grupo][0]}">${e[grupo][1]}</option>
							`);

						$('#alumno_grupos_tarea').append(`
							<option value="${e[grupo][0]}">${e[grupo][1]}</option>
							`);

						$('#grupos_salir').append(`
							<option value="${e[grupo][0]}">${e[grupo][1]}</option>
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

	cargarTareas(grupo,bandera){
		//bandera = true -> Mis grupos
		//bandera = false -> Subir tarea
		if (bandera) {

			$('#lista_tareas_grupo').empty();

		}else{
			$('#lista_tareas_grupo_tarea').empty();
		}
		

		var self = this;
		$.ajax({
			url: 'index-prueba.php',
			type: 'POST',
			dataType: 'json',
			data: {accion: 'getTareas',grupo_tareas:grupo, correo_usuario:self.correo},
		})
		.done(function(e) {
			if (e.error==0) {
				console.log(e);
				if (!bandera) {
					$('#lista_tareas_grupo_tarea').append(`
						<option value="">Selecciona una tarea</option>
					`);
				}
				

				for(var tareas in e){

					if ( Number.isInteger(parseInt(tareas)) ) {

						if (bandera) {
							$('#lista_tareas_grupo').append(`

								<div class="text-center ml-1 mr-1 col-3">
									<button class="btn btn-link" name="btn_tarea" value="${e[tareas][0]}" data-grupo="${e[tareas][7]}">
										<i class="fas fa-file-${self.fileIcon[ e[tareas][4].substring(e[tareas][4].lastIndexOf('.')+1) ]}" style="font-size: 40px; color: black;"></i>
										<h5>${e[tareas][1]}</h5>
										<p style="font-size:15px;">${e[tareas][3]}</p>
									</button>
								</div>
								
							`);

						}else{
							$('#lista_tareas_grupo_tarea').append(`
								<option value="${e[tareas][0]}">${e[tareas][1]}</option>
							`);

						}			

						
					}
					
				}
				$('[name="btn_tarea"]').on('click', function(e) {
					console.log(e);
					console.log(e.currentTarget.value);
					$('#lista_tareas_grupo_tarea').val(e.currentTarget.value).change();
					$('#exampleModal1').modal('show');	
				});

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

	cargarTarea(tarea){

		var self = this;
		$.ajax({
			url: 'index-prueba.php',
			type: 'POST',
			dataType: 'json',
			data: {accion: 'getTarea',tarea_buscar:tarea, correo_usuario:self.correo},
		})
		.done(function(e) {
			if (e.error==0) {
				console.log(e);

				$('#descripcion_tarea').val(e[0][2]);
				$('#fechaentrega_tarea').val(e[0][3]);
				$('#archivo_tarea').empty();
				$('#inst_tarea').empty();
				if (e[0][4]=="") {

					$('#archivo_tarea').append(`<div>
									<i class="fas fa-file-${self.fileIcon[ e[0][4].substring(e[0][4].lastIndexOf('.')+1) ]}" style="font-size: 30px; color: black;"></i>
									<h6>${e[0][1]}</h6>
								</div>`);
				}else{
					$('#archivo_tarea').append(`<a href="${e[0][4]}" download>
									<i class="fas fa-file-${self.fileIcon[ e[0][4].substring(e[0][4].lastIndexOf('.')+1) ]}" style="font-size: 30px; color: black;"></i>
									<h6>${e[0][1]}</h6>
								</a>`);
				}
				
				$('#inst_tarea').append(`<a href="${e[0][6]}" download>
									<i class="fas fa-file-${self.fileIcon[ e[0][6].substring(e[0][6].lastIndexOf('.')+1) ]}" style="font-size: 30px; color: black;"></i>
									<h6>${e[0][5]}</h6>
								</a>`);
				
				/*for(var tareas in e){

					if ( Number.isInteger(parseInt(tareas)) ) {				
						
					}
				}*/

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

}

$(document).ready(function() {
	usuario = new Usuario(getCookie('correo'),getCookie('nombre'),getCookie('paterno'),getCookie('rol'),getCookie('foto'));
	usuario.cargarUAs();
	usuario.cargarProfesores();
	usuario.iniciarForm();
	usuario.cargarGrupos();
	$("#buscar_grupos").submit();

	$('#cerrar_sesion').on('click', function() {
		
		usuario.cerrarSesion();
		
	});

	$('#uas_buscar').on('change', function(e) {
		$("#buscar_grupos").submit();
		usuario.cargarProfesores(e.target.value);
		
	});

	$('#profesores_buscar').on('change', function(e) {
		$("#buscar_grupos").submit();		
	});

	$('#nombre_buscar').on('keyup', function(e) {
		$("#buscar_grupos").submit();		
	});

	$('#alumno_grupos').on('change', function(e) {
		console.log(e);
		usuario.cargarTareas(e.currentTarget.value,true);
		$('#alumno_grupos_tarea').val(e.currentTarget.value).change();
		$('#grupos_salir').val(e.currentTarget.value).change();	
	});

	$('#alumno_grupos_tarea').on('change', function(e) {
		console.log(e);
		usuario.cargarTareas(e.currentTarget.value,false);	
	});

	$('#lista_tareas_grupo_tarea').on('change', function(e) {
		console.log(e);		
		usuario.cargarTarea(e.currentTarget.value);
	});
	

});
