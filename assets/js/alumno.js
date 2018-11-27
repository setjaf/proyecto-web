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
}

$(document).ready(function() {
	usuario = new Usuario(getCookie('correo'),getCookie('nombre'),getCookie('paterno'),getCookie('rol'),getCookie('foto'));
});
