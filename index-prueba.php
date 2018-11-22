<?php
	require_once("procedimientos.php");

	$procedimientos = new Procedimientos();

	$usuario=null;

	$return = ['error'=>1,'mensaje'=>''];

	//print_r($_POST);

	$return['accion']=$_POST['accion'];

	switch ($_POST['accion']) {
		
		/*Ya programadas en JavaScript*/

		case "nuevo_usuario":

			$result=$procedimientos->insertar_usuario($_POST['correo_usuario'],$_POST['contrasena_nueva'],$_POST['nombre'],$_POST['paterno'],$_POST['materno'],$_POST['nacimiento'],(isset($_POST['boleta'])?$_POST['boleta']:NULL),$_POST['curp'],0,$_POST['rol']);
			try {
				$id_usuario=$result[0][0];
			} catch (Exception $e) {
				$return['mensaje'] .=  'No se agregó usuario correctamente </br>'.$id_usuario;
			}			

			if(is_numeric($id_usuario)){
				$return['error'] = 0;
				$return['mensaje'] .=  "Se agregó usuario correctamente";

				if ( isset($_FILES['foto']) && $_FILES['foto']['error']=='0' ) {

					$info = pathinfo($_FILES['foto']['name']);

					$ext = $info['extension']; // get the extension of the file
					$newname = "user_".$id_usuario.'.'.$ext; 

					$target = 'images/'.$newname;
					if( move_uploaded_file( $_FILES['foto']['tmp_name'], $target) && $procedimientos->insertar_foto_usuario($target,$_POST['correo_usuario']) ){
						$return['mensaje'] .=  ', se agregó foto correctamente. Debes esperar la autorización del administradorpara poder hacer uso de tu cuenta';
					}else{
						$return['mensaje'] .=  'No se logró agregar la foto';
					}
				}			

			}else{
				$return['mensaje'] .= "No se agregó usuario correctamente <br>".$result;
			}

			break;

		case "login":

			$rol=$procedimientos->validar_usuario($_POST['usuario'],$_POST['contrasena']);

			if (is_array($rol)) {

				$return = array_merge($return,$rol[0]);
				$return['error'] = 0;
				$return['mensaje'] .=  "Inicio de sesión correcto";

				/*switch ($rol[0][0]) {
					case 1:
						header("Location: http://localhost:81/proyecto-web/administrador.html");
						break;

					case 2:
						header("Location: http://localhost:81/proyecto-web/profesor.html");
						break;
					case 3:
						header("Location: http://localhost:81/proyecto-web/alumno.html");
						break;
				}*/
				
			}else {
				$return['error'] = 1;
				$return['mensaje'] .= 'Correo y/o contraseña incorrectos, revísalos nuevamente. </br>'.$rol;
			}
			
			break;

		case "contacto":

			$to      = $_POST['correo_contacto'];
			$subject = 'ESCOMpartir .- '.$_POST['motivo_contacto'];
			$message = $_POST['mensaje_contacto'];
			$headers = 'From: webmaster@example.com' . "\r\n" .
			    'Reply-To: webmaster@example.com' . "\r\n" .
			    'X-Mailer: PHP/' . phpversion();

			mail($to, $subject, $message, $headers);

			break;

		case 'getPermisos':
			
			$permisos = $procedimientos->getPermisos($_POST['rol']);

			if (is_array($permisos)) {

				$return = array_merge($return,$permisos);
				$return['error'] = 0;

			}else{

				$return['error'] = 1;
				$return['mensaje'] .= 'No se lograron cargar tus permisos. </br>'.$permisos;

			}

			break;

		case 'getSolicitudes':
			
			$solicitudes = $procedimientos->getSolicitudes();
			if (is_array($solicitudes)) {

				$return = array_merge($return,$solicitudes);
				$return['error'] = 0;

			}else{

				$return['error'] = 1;
				$return['mensaje'] .= 'No se lograron cargar las solicitudes. </br>'.$solicitudes;

			}

			break;

		case 'aceptarUsuario':
			$usuarioAceptado = $procedimientos->aceptarUsuario($_POST['correo_solicitud']);

			if ($usuarioAceptado==True) {
				$return['error']=0;
				$return['mensaje'].='Se ha cambiado el status del usuario';
			}else {
				$return['error']=1;
				$return['mensaje'].='No se logró cambiar el status del usuario </br>'.$usuarioAceptado;
			}

			break;

		case 'getProfesores':

			$profesores = $procedimientos->getProfesores();

			if (is_array($profesores)) {

				$return = array_merge($return,$profesores);
				$return['error'] = 0;

			}else{

				$return['error'] = 1;
				$return['mensaje'] .= 'No se lograron cargar los profesores. </br>'.$profesores;

			}
			
			break;

		case 'getUAs':

			$UAs = $procedimientos->getUAs();

			if (is_array($UAs)) {

				$return = array_merge($return,$UAs);
				$return['error'] = 0;

			}else{

				$return['error'] = 1;
				$return['mensaje'] .= 'No se lograron cargar las UAs. </br>'.$UAs;

			}
			
			break;

		case 'crearUA':
			if (isset($_POST['nombre_ua']) && isset($_POST['descripcion_ua']) && isset($_POST['nivel_ua'])) {
				
				$UA = $procedimientos->crearUA($_POST['nombre_ua'],$_POST['descripcion_ua'],$_POST['nivel_ua']);

				if (!is_string($UA)) {
					
					$return['error'] = 0;
					$return['mensaje'] .= 'Se agregó correctamente la unidad de aprendizaje. </br>';

				}else{

					$return['error'] = 1;
					$return['mensaje'] .= 'No se agregó correctamente la unidad de aprendizaje. </br>'.$UA;

				}

			}			

			break;

		case 'asignarUA':
			
			if (isset($_POST['profesor_prof_ua']) && isset($_POST['ua_prof_ua'])) {
				$asignado=$procedimientos->asignarUAProfesor($_POST['profesor_prof_ua'],$_POST['ua_prof_ua']);
				if (!is_string($asignado)) {
					
					$return['error'] = 0;
					$return['mensaje'] .= 'Se asigno correctamente la unidad de aprendizaje. </br>';

				}else{

					$return['error'] = 1;
					$return['mensaje'] .= 'No se asigno correctamente la unidad de aprendizaje. </br>'.$UA;

				}

			}

			break;

		case 'crearGrupo':
			
			if (isset($_POST['nombre_nuevo_grupo']) && isset($_POST['ua_nuevo_grupo']) && isset($_POST['correo_usuario'])) {
				
				$UA = $procedimientos->crearGrupo($_POST['nombre_nuevo_grupo'],$_POST['ua_nuevo_grupo'],$_POST['correo_usuario']);

				if (!is_string($UA)) {
					
					$return['error'] = 0;
					$return['mensaje'] .= 'Se creó el grupo correctamente. </br>';

				}else{

					$return['error'] = 1;
					$return['mensaje'] .= 'No se creó el grupo correctamente. </br>'.$UA;

				}

			}

			break;

		case 'getGrupos':

			$Grupos = $procedimientos->getGrupos($_POST["correo_usuario"]);

			if (is_array($Grupos)) {

				$return = array_merge($return,$Grupos);
				$return['error'] = 0;

			}else{

				$return['error'] = 1;
				$return['mensaje'] .= 'No se lograron cargar las grupos. </br>'.$Grupos;

			}
			
			break;

		case 'eliminarGrupo':

			if ( isset($_POST['grupo_eliminar']) && isset($_POST['correo_usuario'])) {
				
				$UA = $procedimientos->eliminarGrupo($_POST['grupo_eliminar'], $_POST['correo_usuario']);

				if (!is_string($UA)) {
					
					$return['error'] = 0;
					$return['mensaje'] .= 'Se eliminó correctamente el grupo. </br>';

				}else{

					$return['error'] = 1;
					$return['mensaje'] .= 'No se eliminó correctamente el grupo. </br>'.$UA;

				}

			}

			break;

		case "nuevo_archivo":

			$result=$procedimientos->insertar_archivo($_POST['nombre_archivo'],$_POST['descripcion_archivo'],$_POST['correo_usuario'],$_POST['ua_archivo'],$_POST['nivel_archivo']);

			try {
				$id_archivo=$result;
			} catch (Exception $e) {
				$return['mensaje'] .=  'No se agregó archivo correctamente </br>'.$id_archivo;
			}

			if(is_numeric($id_archivo)){
				

				if ( isset($_FILES['archivo']) && $_FILES['archivo']['error']=='0' ) {

					$info = pathinfo($_FILES['archivo']['name']);

					$ext = $info['extension']; // get the extension of the file
					$newname = str_replace(' ', '_', $_POST['nombre_archivo'])."_".$id_archivo.'.'.$ext; 

					$target = 'files/'.$newname;
					if( move_uploaded_file( $_FILES['archivo']['tmp_name'], $target) && $procedimientos->insertar_url_archivo($target,$_POST['correo_usuario']) )
					{
						$return['error'] = 0;
						$return['mensaje'] .=  "Se agregó archivo correctamente";
					}else{
						$return['mensaje'] .=  'No se logró agregar el archivo';
					}
				}			

			}else{
				$return['mensaje'] .= "No se agregó archivo correctamente <br>".$result;
			}

			break;


		/*Aún no programadas en JavaScript*/

		case 'desactivarUsuario':
			$usuarioAceptado = $procedimientos->desactivarUsuario($_POST['correo_solicitud']);

			if ($usuarioAceptado==True) {
				$return['error']=0;
				$return['mensaje'].='Se ha cambiado el status del usuario, ahora está como inactivo';
			}else {
				$return['error']=1;
				$return['mensaje'].='No se logró cambiar el status del usuario, intentalo denuevo más tarde </br>'.$usuarioAceptado;
			}

			break;

		case 'eliminarUsuario':
			$usuarioAceptado = $procedimientos->eliminarUsuario($_POST['correo_solicitud']);

			if ($usuarioAceptado==True) {
				$return['error']=0;
				$return['mensaje'].='Se ha eliminado el usuario correctamente';
			}else {
				$return['error']=1;
				$return['mensaje'].='No se logró eliminar el usuario, intentalo denuevo más tarde </br>'.$usuarioAceptado;
			}

			break;
		
		default:
				$return['mensaje'] .= 'No hay caso para esa acción';
			break;
	}

	echo json_encode($return);

	function correoConfirmacion($correo='')
	{
		
	}

	/*print_r($_POST);
	echo '<br>';
	print_r($_FILES);*/

	/*if (isset($_POST['nuevo_permiso']) && isset($_POST['permiso_desc'])) {

		if($procedimientos->insertar_permiso($_POST['permiso_desc'])){
			echo "Se agregó permiso correctamente";
		}else{
			echo "No se agregó permiso correctamente";
		}
		
	}else if (isset($_POST['nuevo_rol']) && isset($_POST['perm_rol']) && isset($_POST['rol_desc'])) {

		$id_rol = $procedimientos->insertar_rol($_POST['rol_desc']);

		$id_rol = $id_rol[0][0];
		$bandera=true;
		foreach ($_POST['perm_rol'] as $perm) {
			if(!$procedimientos->agregar_permiso_rol($id_rol,$perm)){
				$bandera=false;
			}
		}
		if(!$bandera){
			echo "No se han agregado todos los permisos";
		}else {
			echo 'Se creo el rol y seagregaron todos los permisos';
		}
		
	}else if (isset($_POST['agregar_usuario']) && isset($_POST['correo_usuario']) && isset($_POST['contrasena_nueva']) ) {

		$id_usuario=$procedimientos->insertar_usuario($_POST['correo_usuario'],$_POST['contrasena_nueva'],$_POST['nombre'],$_POST['paterno'],$_POST['materno'],$_POST['nacimiento'],$_POST['boleta'],$_POST['curp'],1,$_POST['rol']);

		$id_usuario=$id_usuario[0][0];

		if($id_usuario){
			echo "Se agregó usuario correctamente";

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
		
	}else if(isset($_POST['buscar_usuario']) && isset($_POST['usuario_buscar']) ){

		$usuario = $procedimientos->seleccionar_usuario($_POST['usuario_buscar']);
		$usuario = $usuario[0];
		if (!isset($usuario)) {
			echo '<br>';
			echo 'No se logró encontrar al usuario';
		}

	}else if (isset($_POST['editar_usuario']) && isset($_POST['correo_usuario_editar']) && isset($_POST['contrasena_nueva']) ) {

		$id_usuario=$procedimientos->editar_usuario($_POST['correo_usuario_editar'],$_POST['contrasena_nueva'],$_POST['nombre'],$_POST['paterno'],$_POST['materno'],$_POST['nacimiento'],$_POST['boleta'],$_POST['curp'],1,$_POST['rol']);

		$id_usuario=$id_usuario[0][0];

		if($id_usuario){

			echo '<br>';

			echo "Se editó usuario correctamente";

			if ( isset($_FILES['foto']) && $_FILES['foto']['error']=='0' ) {

				$info = pathinfo($_FILES['foto']['name']);

				$ext = $info['extension']; // get the extension of the file
				$newname = "user_".$id_usuario.'.'.$ext; 

				$target = 'images/'.$newname;
				if( move_uploaded_file( $_FILES['foto']['tmp_name'], $target) && $procedimientos->insertar_foto_usuario($target,$_POST['correo_usuario']) ){
					echo '<br>';
					echo ' -Se agregó foto correctamente';
				}
			}

			

		}else{

			echo "No se agregó usuario correctamente";
		}
		
		
	}else if ( isset($_POST['borrar_usuario']) && isset($_POST['usuario_buscar']) ) {
		if($procedimientos->borrar_usuario($_POST['usuario_buscar'])){
			echo "Se borró correctamente el usuario";
		}else{
			echo "No se borró correctamente el usuario";
		}
	}else if ( isset($_POST['agregar_ua']) && isset($_POST['nombre_ua']) && isset($_POST['descripcion_ua']) && isset($_POST['nivel_ua']) ) {
		if ( $procedimientos->agregar_ua($_POST['nombre_ua'], $_POST['descripcion_ua'], $_POST['nivel_ua']) ) {
			echo "Se agregó correctamente la unidad de aprendizaje";
		}else {
			echo "Nose logró agregar la unidad de aprendizaje";
		}
	}else if ( isset($_POST['agregar_ua_profesor']) && isset($_POST['profesor_prof_ua']) && isset($_POST['ua_prof_ua']) ){

		if ($procedimientos->asignar_ua_profesor($_POST['profesor_prof_ua'],$_POST['ua_prof_ua'])) {
			echo "Se asignó correctamente Unidad de Aprendizaje al profesor";
		}else{
			echo "No se ha asignado la Unidad de Aprendizaje al profesor";
		}

	}*/
 ?>
