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
						if (e.accion=='buscarArchivos') {
							
							if (e.error == 0) {

								console.log("buscarGrupos");
								self.mostrarArchivos_buscar(e);
								
							}else {
								$('#mensaje-resp-ajax').html(e.mensaje);
								$('#exampleModal').modal('hide');
								$('#exampleModal1').modal('hide');
								$('#exampleModalCenter').modal("toggle");
							}

						}else if(e.accion=='comentarArchivo'){
							$('#mensaje-resp-ajax').html(e.mensaje);
							$('#exampleModal').modal('hide');
							$('#exampleModal1').modal('hide');
							$('#exampleModalCenter').modal("toggle");

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

	mostrarArchivos_buscar(e){

		console.log(e);

		var self=this;

		$('#archivos').empty();
	
		for(var ua in e){
			
			if ( Number.isInteger(parseInt(ua)) ) {

				
				$('#archivos').append(`
					<div class="container">
						<div class="titulo">
							<h1 class="display-3">
								<span style="color:#1169a3; font-family: 'Rajdhani', sans-serif; font-size: 1.5rem;">${e[ua][0][11]}</span>
							</h1>
							<br>
							<br>
						</div>
					</div>

					<div class="container lista-tareas media border p-1" >
						<div class="row text-center" id="lista_archivos_ua_${ua}">
							
							
						</div>
					</div>
					`);

				for (var archivo in e[ua]) {
					console.log(e[ua][archivo][4].substring(e[ua][archivo][4].lastIndexOf('.')+1));

					$('#lista_archivos_ua_'+ua).append(`
					
						<div class="text-center ml-1 mr-1 col-3">
							<button class="btn btn-link" name="btn_archivo" value="${e[ua][archivo][0]}" data-nombre="${e[ua][archivo][1]}" data-descripcion="${e[ua][archivo][2]}" data-fecha="${e[ua][archivo][3]}" data-url="${e[ua][archivo][4]}" data-nivel="${e[ua][archivo][5]}" data-profesor="${e[ua][archivo][7]} ${e[ua][archivo][8]} ${e[ua][archivo][9]}" data-ua="${e[ua][archivo][11]}">
								<i class="fas fa-file-${self.fileIcon[e[ua][archivo][4].substring(e[ua][archivo][4].lastIndexOf('.')+1) ]}" style="font-size: 40px; color: black;"></i>
								<h5>${e[ua][archivo][1]}</h5>
								<p style="font-size:15px;">${e[ua][archivo][3]}</p>
							</button>
						</div>	

					`);
				
				}
			}
			
		}

		$('[name="btn_archivo"]').unbind();
		$('[name="btn_archivo"]').on('click', function(e) {
					console.log(e);
					console.log(e.currentTarget.value);
					//$('#lista_tareas_grupo_tarea').val(e.currentTarget.value).change();
					$('#id_archivo').val(e.currentTarget.value);
					$('#nombre_archivo').html(e.currentTarget.dataset.nombre);
					$('#desc_archivo').html(e.currentTarget.dataset.descripcion);
					$('#fecha_archivo').html(e.currentTarget.dataset.fecha)
					$('#url_archivo').html(`
							<a class="btn btn-link" name="btn_archivo" href="${e.currentTarget.dataset.url}" download>
								<i class="fas fa-file-${self.fileIcon[e.currentTarget.dataset.url.substring(e.currentTarget.dataset.url.lastIndexOf('.')+1) ]}" style="font-size: 40px; color: black;"></i>
							</a>`);
					$('#nivel_archivo').html(e.currentTarget.dataset.nivel);
					$('#propietario_archivo').html(e.currentTarget.dataset.profesor);
					$('#u_a_archivo').html(e.currentTarget.dataset.ua);
					//$('#').html(e.currentTarget.dataset.);
					$('#exampleModal1').modal('show');	
				});

		self.iniciarForm();
		
	}
}


$(document).ready(function() {
	usuario = new Usuario(getCookie('correo'),getCookie('nombre'),getCookie('paterno'),getCookie('rol'),getCookie('foto'));
	usuario.cargarUAs();
	usuario.cargarProfesores();
	usuario.iniciarForm();
	$("#buscar_archivos").submit();

	$('#cerrar_sesion').on('click', function() {
		
		usuario.cerrarSesion();
		
	});

	$('#uas_buscar').on('change', function(e) {
		$("#buscar_archivos").submit();
		usuario.cargarProfesores(e.target.value);
		
	});

	$('#profesores_buscar').on('change', function(e) {
		$("#buscar_archivos").submit();		
	});

	$('#nombre_buscar').on('keyup', function(e) {
		$("#buscar_archivos").submit();		
	});

	

});