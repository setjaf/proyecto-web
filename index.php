<?php
	require_once("procedimientos.php");

	$procedimientos = new Procedimientos();

	$usuario=null;

	/*print_r($_POST);
	echo '<br>';
	print_r($_FILES);*/

	if (isset($_POST['agregar_usuario']) && isset($_POST['correo_usuario']) && isset($_POST['contrasena_nueva']) ) {

		$id_usuario=$procedimientos->insertar_usuario($_POST['correo_usuario'],$_POST['contrasena_nueva'],$_POST['nombre'],$_POST['paterno'],$_POST['materno'],$_POST['nacimiento'],$_POST['boleta'],$_POST['curp'],1,$_POST['rol']);

		$id_usuario=$id_usuario[0][0];

		if($id_usuario){
			echo "<script>alert(Se agregó usuario correctamente)</script>";

			if ( isset($_FILES['foto']) && $_FILES['foto']['error']=='0' ) {

				$info = pathinfo($_FILES['foto']['name']);

				$ext = $info['extension']; // get the extension of the file
				$newname = "user_".$id_usuario.'.'.$ext; 

				$target = 'images/'.$newname;
				if( move_uploaded_file( $_FILES['foto']['tmp_name'], $target) && $procedimientos->insertar_foto_usuario($target,$_POST['correo_usuario']) ){
					echo ' -Se agregó foto correctamente';
				}
			}

			

		}else{
			echo '<br>';
			echo "No se agregó usuario correctamente";
		}
		
	}else if (isset($_POST['login']) && isset($_POST['usuario']) && isset($_POST['contrasena'])) {
		if ($procedimientos->validar_usuario($_POST['usuario'],$_POST['contrasena'])) {
			header("Location: http://localhost:81/proyecto-web/alumno.html");
		}
	}
?>

<!DOCTYPE html>

<html>

<head>
	
	<meta charset="utf-8">
	<title>ESCOMpartiendo - Inicio</title>
	<link rel="stylesheet" href="assets/css/index.css">
	<link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<!--<link rel="stylesheet" href="http://localhost:81/bootstrap-4.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://localhost:81/iconfont/css/all.css">-->

</head>

<body>
	<!--header-->
	<header>
		
		<nav>
			<div class="logos">
				<p style="margin: 0; color:#F9F9F9;"><span style="font-family: 'Rajdhani', sans-serif; font-size: 1.5em;">ESCOM</span>partiendo</p>
			</div>
			<ul>
				<li><a href="#" ><p>Inicio</p></a></li>
				<li><a href="#" data-toggle="modal" data-target="#exampleModal"><p>Iniciar Sesión</p></a></li>
				<li><a href="#contacto" ><p>Contacto</p></a></li>
			</ul>
			
		</nav>

	</header>
	<!-- header -->
	<section class="contenedor">

		<div class="container">
			
			<div class="inicio row justify-content-center" id="inicio">

				<div class="titulo">

					<h1 class="display-3">
						<span style="color:#1169a3; font-family: 'Rajdhani', sans-serif; font-size: 1.5em;">ESCOM</span>partiendo
					</h1>
					
				</div>

				<div class="texto">
					<p>
						Este sitio está creado para profesores y alumnos, en donde profesores comparten contenido digital con sus alumnos, para enriquecer sus clases.
					</p>
				</div>

				<div class="botones_inicio row justify-content-around">
					<div class="col-sm-3">
						<a href="#registro" class="btn btn_red btn-lg">Soy nuevo</a>
					</div>
					
					<div class="col-sm-3">
						<a href="#" class="btn btn_red btn-lg" data-toggle="modal" data-target="#exampleModal">Iniciar sesión</a>
					</div>						
				</div>

				<div class="position-absolute" style="bottom: 20px;">
					<div class="col-12 mt-5 ">
						<a href="#contacto" class="no_link" >Conocer más</a>
					</div>
					<div class="col-12">
						<a href="#profesor" class="no_link"><i class="fas fa-chevron-down"></i></a>
					</div>
				</div>
				

				
			</div>

			<div id="alumno" class="compartir">

				<div class="jumbotron jumbotron-fluid w-100">
				  <div class="container justify-content-center">
				    <h2 class="display-4">Alumno</h2>
				    <p class="lead">Puedes tener acceso a los contenidos de cualquier profesor, sin necesidad de pertenecer a su clase.</p>
				    <img src="assets/img/document.png" alt="" width="256" height="256">
				    <div class="w-100 mt-2"></div>
				    <a class="btn btn_red btn-lg" href="#registro" role="button">Registrarme</a>
				  </div>
				</div>
				
			</div>

			<div id="profesor" class="compartir">

				<div class="jumbotron jumbotron-fluid">
				  <div class="container justify-content-center">
				    <h2 class="display-4">Profesor</h2>
				    <p class="lead">Comparte toda la información que quieras con tus alumnos y también con toda la comunida de ESCOM, que no haya limites para compartir el conocimiento.</p>
				    <img src="assets/img/book.png" alt="" width="256" height="256">
				    <div class="w-100 mt-2"></div>
				    <a class="btn btn_red btn-lg" href="#registro" role="button">Registrarme</a>
				  </div>
				</div>
				
			</div>
	
			<div id="contacto" class="contacto">
				<div class="formulario">

					<h2 class="display-4">Contacto</h2>

					<form class="form-row justify-content-end">
						<div class="form-group col-12">
							<label for="">Correo electrónico:</label>
							<input type="email" class="form-control" name="correo_contacto" placeholder="ejemplo@correo.com" pattern="[\w.%+-]+@[\w.-]+\.[a-zA-Z]{2,6}">
						</div>
						<div class="form-group col-12">
							<label for="">Motivo de contacto:</label>
							<input type="text" class="form-control" name="correo_contacto">
						</div>
						<div class="form-group col-12">
							<label for="">Mensaje:</label>
							<textarea name="mensaje_contacto" id="mensaje_contacto" class="form-control"></textarea>
						</div>
						<div class="form-group">
							<input type="submit" value="Enviar" class="btn btn_red">
						</div>
					</form>
						
				</div>
				
			</div>

			<div id="registro" class="registro">

				<div class="formulario">

					<h2 class="display-4">Registro</h2>

					<ul class="nav nav-tabs" id="myTab" role="tablist">
					  <li class="nav-item">
					    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#alumno" role="tab" aria-controls="alumno" aria-selected="true">Alumno</a>
					  </li>
					  <li class="nav-item">
					    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profesor" role="tab" aria-controls="profesor" aria-selected="false">Profesor</a>
					  </li>
					  <li class="nav-item">
					    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#administrador" role="tab" aria-controls="administrador" aria-selected="false">Administrador</a>
					  </li>
					</ul>
					<div class="tab-content" id="myTabContent">
					  <div class="tab-pane fade show active" id="alumno" role="tabpanel" aria-labelledby="home-tab">

						<form class="form-row justify-content-end" method="POST" enctype="multipart/form-data" id="form_alumno"> 

							<div class="form-group col-12">
								<label for="">Correo electrónico:</label>
								<input type="email" class="form-control" name="correo_usuario" placeholder="ejemplo@correo.com" pattern="[\w.%+-]+@[\w.-]+\.[a-zA-Z]{2,6}" autocomplete="email" required>
							</div>
							<div class="form-group col-12">
								<label for="">Contraseña:</label>
								<input type="password" class="form-control" name="contrasena_nueva" id="contrasena_nueva1" placeholder="Escribe tu nueva contraseña" required>
							</div>
							<div class="form-group col-12">
								<label for="">Confirmar Contraseña:</label>
								<input type="password" class="form-control" placeholder="Escribe tu nueva contraseña" name="confirmar_contrasena_nueva" id="confirmar_contrasena_nueva1" required>
							</div>
							<div class="form-group col-12">
								<label for="">Nombre(s):</label>
								<input type="text" class="form-control" name="nombre" autocomplete="give-name" placeholder="Juan" required>
							</div>
							<div class="form-group col-12">
								<label for="">Apellido Paterno:</label>
								<input type="text" class="form-control" name="paterno" autocomplete="family-name" placeholder="Pérez" required>
							</div>
							<div class="form-group col-12">
								<label for="">Apellido Materno:</label>
								<input type="text" class="form-control" name="materno" autocomplete="family-name" placeholder="Rodíguez" required>
							</div>
							<div class="form-group col-12">
								<label for="">Fecha de nacimiento:</label>
								<input type="date" class="form-control" name="nacimiento" autocomplete="bday" placeholder="00/00/0000" required>
							</div>
							<div class="form-group col-12">
								<label for="">No. Boleta:</label>
								<input type="text" class="form-control" name="boleta" pattern="[0-9]{10}" placeholder="0000000000"  required>
							</div>
							<div class="form-group col-12">
								<label for="">CURP:</label>
								<input type="text" class="form-control" name="curp" pattern="^[A-Z]{4}\d{2}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])[A-Z]{6}(\d|[A-Z])\d$" placeholder="AAAA000101BBBBBB00" required>
								<a href="https://www.gob.mx/curp/" target="_blank">Consultar CURP</a>
							</div>
							<div class="form-group col-12">
								<label for="">Foto:</label>
								<input type="file" class="form-control" name="foto" accept="image/*">
							</div>

							<div>
								<input type="text" hidden name="rol" value="3">
							</div>
							<div class="form-group">
								<input type="submit" value="Agregar Usuarrio" class="btn btn_red" name="agregar_usuario">
							</div>						
						</form>
					  </div>
					  <div class="tab-pane fade" id="profesor" role="tabpanel" aria-labelledby="profile-tab">
					  	<form class="form-row justify-content-end" method="POST" enctype="multipart/form-data">

							<div class="form-group col-12">
								<label for="">Correo electrónico:</label>
								<input type="email" class="form-control" name="correo_usuario" placeholder="ejemplo@correo.com" pattern="[\w.%+-]+@[\w.-]+\.[a-zA-Z]{2,6}" autocomplete="email" required>
							</div>
							<div class="form-group col-12">
								<label for="">Contraseña:</label>
								<input type="password" class="form-control" name="contrasena_nueva" id="contrasena_nueva2" placeholder="Escribe tu nueva contraseña" required>
							</div>
							<div class="form-group col-12">
								<label for="">Confirmar Contraseña:</label>
								<input type="password" class="form-control" placeholder="Escribe tu nueva contraseña" name="confirmar_contrasena_nueva" id="confirmar_contrasena_nueva2" required>
							</div>
							<div class="form-group col-12">
								<label for="">Nombre(s):</label>
								<input type="text" class="form-control" name="nombre" autocomplete="give-name" placeholder="Juan" required>
							</div>
							<div class="form-group col-12">
								<label for="">Apellido Paterno:</label>
								<input type="text" class="form-control" name="paterno" autocomplete="family-name" placeholder="Pérez" required>
							</div>
							<div class="form-group col-12">
								<label for="">Apellido Materno:</label>
								<input type="text" class="form-control" name="materno" autocomplete="family-name" placeholder="Rodíguez" required>
							</div>
							<div class="form-group col-12">
								<label for="">Fecha de nacimiento:</label>
								<input type="date" class="form-control" name="nacimiento" autocomplete="bday" placeholder="00/00/0000" required>
							</div>							
							<div class="form-group col-12">
								<label for="">CURP:</label>
								<input type="text" class="form-control" name="curp" pattern="^[A-Z]{4}\d{2}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])[A-Z]{6}(\d|[A-Z])\d$" placeholder="AAAA000101BBBBBB00" required>
								<a href="https://www.gob.mx/curp/" target="_blank">Consultar CURP</a>
							</div>
							<div class="form-group col-12">
								<label for="">Foto:</label>
								<input type="file" class="form-control" name="foto" accept="image/*">
							</div>

							<div>
								<input type="text" hidden name="rol" value="2">
							</div>
							<div class="form-group">
								<input type="submit" value="Agregar Usuarrio" class="btn btn_red" name="agregar_usuario">
							</div>						
						</form>
					  </div>
					  <div class="tab-pane fade" id="administrador" role="tabpanel" aria-labelledby="profile-tab">
					  	<form class="form-row justify-content-end" method="POST" enctype="multipart/form-data">

							<div class="form-group col-12">
								<label for="">Correo electrónico:</label>
								<input type="email" class="form-control" name="correo_usuario" placeholder="ejemplo@correo.com" pattern="[\w.%+-]+@[\w.-]+\.[a-zA-Z]{2,6}" autocomplete="email" required>
							</div>
							<div class="form-group col-12">
								<label for="">Contraseña:</label>
								<input type="password" class="form-control" name="contrasena_nueva" id="contrasena_nueva3" placeholder="Escribe tu nueva contraseña" required>
							</div>
							<div class="form-group col-12">
								<label for="">Confirmar Contraseña:</label>
								<input type="password" class="form-control" placeholder="Escribe tu nueva contraseña" name="confirmar_contrasena_nueva" id="confirmar_contrasena_nueva3" required>
							</div>
							<div class="form-group col-12">
								<label for="">Nombre(s):</label>
								<input type="text" class="form-control" name="nombre" autocomplete="give-name" placeholder="Juan" required>
							</div>
							<div class="form-group col-12">
								<label for="">Apellido Paterno:</label>
								<input type="text" class="form-control" name="paterno" autocomplete="family-name" placeholder="Pérez" required>
							</div>
							<div class="form-group col-12">
								<label for="">Apellido Materno:</label>
								<input type="text" class="form-control" name="materno" autocomplete="family-name" placeholder="Rodíguez" required>
							</div>
							<div class="form-group col-12">
								<label for="">Fecha de nacimiento:</label>
								<input type="date" class="form-control" name="nacimiento" autocomplete="bday" placeholder="00/00/0000" required>
							</div>
							<div class="form-group col-12">
								<label for="">CURP:</label>
								<input type="text" class="form-control" name="curp" pattern="^[A-Z]{4}\d{2}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])[A-Z]{6}(\d|[A-Z])\d$" placeholder="AAAA000101BBBBBB00" required>
								<a href="https://www.gob.mx/curp/" target="_blank">Consultar CURP</a>
							</div>
							<div class="form-group col-12">
								<label for="">Foto:</label>
								<input type="file" class="form-control" name="foto" accept="image/*">
							</div>

							<div>
								<input type="text" hidden name="rol" value="1">
							</div>
							<div class="form-group">
								<input type="submit" value="Agregar Usuarrio" class="btn btn_red" name="agregar_usuario">
							</div>						
						</form>
					  </div>					  
					</div>					

				</div>
				
			</div>

		</div>
		
	</section>

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Iniciar Sesión</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>

	      <div class="modal-body">

	        <form method="POST" enctype="multipart/form-data">
			  <div class="form-group">
			    <label for="exampleInputEmail1">Correo Electrónico</label>
			    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="ejemplo@correo.com" name="usuario">
			  </div>
			  <div class="form-group">
			    <label for="exampleInputPassword1">Contraseña</label>
			    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="contrasena">
				<br>
				<a href="#">Olvide mi contraseña</a>
				

			  </div>
			  <button type="submit" class="btn btn-primary" name="login" value="login">Entrar</button>
			</form>

	      </div>
	      <div class="modal-footer">
	        <span>Aún no tengo cuenta, quiero <a href="#registro" id="btnregistro">registrarme</a></span>
	      </div>

	    </div>
	  </div>
	</div>

	<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<!--<script src="http://localhost:81/bootstrap-4.1.1/js/bootstrap.min.js"></script>-->
	<script src="assets/js/index.js"></script>

		<section class="contenedor">
			<footer>
				<p>ESCOMpartir ©2018 | Acerca de... | Trabajos | Centro de Noticias | Constactanos | Profesores | Comunidad | Blog | Privacidad | Terminos de Servicios | Idioma</p>
			</footer>
		</section>

</body>

</html>