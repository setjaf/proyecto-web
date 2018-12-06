<?php
	require_once("procedimientos.php");

	$procedimientos = new Procedimientos();

	$usuario=null;

	/*Regresamos el resultado que nos devolvió $procedimientos*/
				$return = ['error'=>1,'mensaje'=>''];

	$return['accion']=$_POST['accion'];

	switch ($_POST['accion']) {
		
		/*Ya programadas en JavaScript*/

		case "nuevo_usuario":

			$result=$procedimientos->insertar_usuario($_POST['correo_usuario'],$_POST['contrasena_nueva'],$_POST['nombre'],$_POST['paterno'],$_POST['materno'],$_POST['nacimiento'],(isset($_POST['boleta'])?$_POST['boleta']:NULL),$_POST['curp'],0,$_POST['rol']);
			try {
				$id_usuario=$result[0][0];
			} catch (Exception $e) {
				$return['mensaje'] .=  'No se agregó usuario correctamente </br>Debes esperar la autorización de un administrador para iniciar con el uso de tu cuenta</br>'.$id_usuario;
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
						insertar_foto_usuario('images/user_0.jpg',$_POST['correo_usuario']);
						$return['mensaje'] .=  'No se logró agregar la foto';
					}
				}else{

					insertar_foto_usuario('images/user_0.jpg',$_POST['correo_usuario']);

				}			

			}else{
				$return['mensaje'] .= "No se agregó usuario correctamente <br>".$result;
			}

			break;

		case "login":

			$rol=$procedimientos->validar_usuario($_POST['usuario'],$_POST['contrasena']);

			if (is_array($rol)) {

				/*Regresamos el resultado que nos devolvió $procedimientos*/
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

				/*Regresamos el resultado que nos devolvió $procedimientos*/
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

				/*Regresamos el resultado que nos devolvió $procedimientos*/
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

			$profesores = $procedimientos->getProfesores(isset($_POST['ua_buscar'])?$_POST['ua_buscar']:null);

			if (is_array($profesores)) {

				/*Regresamos el resultado que nos devolvió $procedimientos*/
				$return = array_merge($return,$profesores);
				$return['error'] = 0;

			}else{

				$return['error'] = 1;
				$return['mensaje'] .= 'No se lograron cargar los profesores. </br>'.$profesores;

			}
			
			break;

		case 'getUAs':

			$UAs = $procedimientos->getUAs((isset($_POST['correo_usuario'])?$_POST['correo_usuario']:NULL));

			if (is_array($UAs)) {

				/*Regresamos el resultado que nos devolvió $procedimientos*/
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
					$return['mensaje'] .= 'No se asigno correctamente la unidad de aprendizaje. </br>'.$asignado;

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

			$Grupos = $procedimientos->getGrupos($_POST["correo_usuario"],(isset($_POST["uas_buscar"])?$_POST["uas_buscar"]:null),(isset($_POST["profesores_buscar"])?$_POST["profesores_buscar"]:null),(isset($_POST["nombre_buscar"])?$_POST["nombre_buscar"]:""));

			if (is_array($Grupos)) {
				/*Regresamos el resultado que nos devolvió $procedimientos*/
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
					if( move_uploaded_file( $_FILES['archivo']['tmp_name'], $target) && $procedimientos->insertar_url_archivo($target,$id_archivo,$_POST['correo_usuario']) )
					{
						$return['error'] = 0;
						$return['mensaje'] .=  "Se agregó archivo correctamente";
					}else{
						$return['mensaje'] .=  'No se logró agregar el archivo';
					}
				}else{
					$return['mensaje'] .=  'No se logró agregar el archivo';
				}			

			}else{
				$return['mensaje'] .= "No se agregó archivo correctamente <br>".$result;
			}

			break;

		case 'getGruposArchivos':

			$Grupos = $procedimientos->getGruposArchivos($_POST["correo_usuario"]);

			if (is_array($Grupos)) {

				/*Regresamos el resultado que nos devolvió $procedimientos*/
				$return = array_merge($return,$Grupos);
				$return['error'] = 0;

			}else{

				$return['error'] = 1;
				$return['mensaje'] .= 'No se lograron cargar las grupos. </br>'.$Grupos;

			}
			
			break;

		case 'getArchivos':

			$Archivos = $procedimientos->getArchivos($_POST["correo_usuario"]);

			if (is_array($Archivos)) {

				/*Regresamos el resultado que nos devolvió $procedimientos*/
				$return = array_merge($return,$Archivos);				
				$return['error'] = 0;

			}else{

				$return['error'] = 1;
				$return['mensaje'] .= 'No se lograron cargar los archivos. </br>'.$Archivos;

			}			
			break;

		case "nueva_tarea":

			$result=$procedimientos->insertar_tarea($_POST['nombre_tarea'],$_POST['descripcion_tarea'],$_POST['fecha_entrega_tarea'],$_POST['correo_usuario'],$_POST['grupo_tarea'],$_POST['archivo_aignar_tarea']);
			
			try {
				$id_tarea=$result;
			} catch (Exception $e) {
				$return['mensaje'] .=  'No se agregó tarea correctamente </br>'.$id_tarea;
			}

			if(is_numeric($id_tarea)){

				$return['error'] = 0;
				$return['mensaje'] .=  "Se agregó tarea correctamente";

				if ( isset($_FILES['archivo_tarea']) && $_FILES['archivo_tarea']['error']=='0' ) {

					$info = pathinfo($_FILES['archivo_tarea']['name']);

					$ext = $info['extension']; // get the extension of the file
					$newname = str_replace(' ', '_', $_POST['nombre_tarea'])."_".$id_tarea.'.'.$ext; 

					$target = 'files/tarea/'.$newname;
					if( move_uploaded_file( $_FILES['archivo_tarea']['tmp_name'], $target) && $procedimientos->insertar_url_tarea($id_tarea,$target,$_POST['correo_usuario'],$_POST['grupo_tarea']) )
					{
						$return['error'] = 0;
						$return['mensaje'] .=  "Se agregó archivo de tarea correctamente";
					}else{
						$return['mensaje'] .=  'No se logró agregar el archivo';
					}
				}		

			}else{
				$return['mensaje'] .= "No se agregó archivo correctamente <br>".$result;
			}

			break;

		case "eliminarArchivo":
			if ( isset($_POST['nombre_archivo_eliminar']) && isset($_POST['correo_usuario'])) {
				
				$UA = $procedimientos->eliminarArchivo($_POST['nombre_archivo_eliminar'], $_POST['correo_usuario']);

				if (!is_string($UA)) {
					
					$return['error'] = 0;
					$return['mensaje'] .= 'Se eliminó correctamente el archivo. </br>';

				}else{

					$return['error'] = 1;
					$return['mensaje'] .= 'No se eliminó correctamente el archivo. </br>'.$UA;

				}

			}	

			break;

		case 'inscribirGrupo':
			
			if (isset($_POST['grupo_inscribir'])) {
				$asignado=$procedimientos->inscribirGrupo($_POST['grupo_inscribir'],$_POST['correo_usuario']);
				if (!is_string($asignado)) {
					
					$return['error'] = 0;
					$return['mensaje'] .= 'Se inscribió correctamnte el grupo. </br>';

				}else{

					$return['error'] = 1;
					$return['mensaje'] .= 'No se asigno correctamente grupo. </br>'.$asignado;

				}

			}else{
				$return['mensaje'] .= 'No se asigno correctamente grupo. </br>'.$asignado;
			}

			break;

		case 'getGruposAlumno':

			$Grupos = $procedimientos->getGruposAlumno($_POST["correo_usuario"]);

			if (is_array($Grupos)) {
				/*Regresamos el resultado que nos devolvió $procedimientos*/
				$return = array_merge($return,$Grupos);
				$return['error'] = 0;

			}else{

				$return['error'] = 1;
				$return['mensaje'] .= 'No se lograron cargar las grupos. </br>'.$Grupos;

			}
			
			break;

		case 'getTareas':
			
			$tareas = $procedimientos->getTareas($_POST['correo_usuario'],$_POST['grupo_tareas']);
			if (is_array($tareas)) {

				/*Regresamos el resultado que nos devolvió $procedimientos*/
				$return = array_merge($return,$tareas);
				$return['error'] = 0;

			}else{

				$return['error'] = 1;
				$return['mensaje'] .= 'No se lograron cargar las tareas. </br>'.$tareas;

			}

			break;

		case 'getTarea':
			
			$tareas = $procedimientos->getTarea($_POST['tarea_buscar']);
			if (is_array($tareas)) {

				/*Regresamos el resultado que nos devolvió $procedimientos*/
				$return = array_merge($return,$tareas);
				$return['error'] = 0;

			}else{

				$return['error'] = 1;
				$return['mensaje'] .= 'No se logró cargar la tarea. </br>'.$tareas;

			}

			break;

		case "enviarTarea":

			$result=$procedimientos->enviartarea($_POST['lista_tareas_grupo_tarea'],$_POST['correo_usuario']);
			
			try {
				$id_tarea=$result;
			} catch (Exception $e) {
				$return['mensaje'] .=  'No se envió tarea correctamente </br>'.$id_tarea;
			}

			if(is_numeric($id_tarea)){

				$return['error'] = 0;
				$return['mensaje'] .=  "Se envió tarea correctamente";

				if ( isset($_FILES['archivo_tarea_enviada']) && $_FILES['archivo_tarea_enviada']['error']=='0' ) {

					$info = pathinfo($_FILES['archivo_tarea_enviada']['name']);

					$ext = $info['extension']; // get the extension of the file
					$newname = "tarea_eviada_".$_POST['lista_tareas_grupo_tarea'].'_'.$procedimientos->id_usuario($_POST['correo_usuario']).'.'.$ext; 

					$target = 'files/tarea/'.$newname;
					if( move_uploaded_file( $_FILES['archivo_tarea_enviada']['tmp_name'], $target) && $procedimientos->insertar_url_tarea_enviada($_POST['lista_tareas_grupo_tarea'],$target,$_POST['correo_usuario']) )
					{
						$return['error'] = 0;
						$return['mensaje'] .=  "Se agregó archivo de tu tarea correctamente";
					}else{
						$return['mensaje'] .=  'No se logró agregar el archivo de tu tarea correctament';
					}
				}		

			}else{
				$return['mensaje'] .= "No se agregó archivo correctamente <br>".$result;
			}

			break;

		case 'salirGrupo':
			$usuarioAceptado = $procedimientos->salirGrupo($_POST['grupoSalir'],$_POST['correo_usuario']);

			if ($usuarioAceptado==True) {
				$return['error']=0;
				$return['mensaje'].='Has salido del grupo satisfactoriamente';
			}else {
				$return['error']=1;
				$return['mensaje'].='No se logró salir del grupo, intentalo denuevo más tarde </br>'.$usuarioAceptado;
			}

			break;

		case 'buscarArchivos':

			$archivos = $procedimientos->buscarArchivos(isset($_POST["nombre_buscar"])?$_POST["nombre_buscar"]:null,isset($_POST["profesores_buscar"])?$_POST["profesores_buscar"]:null,isset($_POST["uas_buscar"])?$_POST["uas_buscar"]:null,isset($_POST["nivel_buscar"])?$_POST["nivel_buscar"]:null);

			if (is_array($archivos)) {
				/*Regresamos el resultado que nos devolvió $procedimientos*/
				$return = array_merge($return,$archivos);
				$return['error'] = 0;

			}else{

				$return['error'] = 1;
				$return['mensaje'] .= 'No se lograron cargar las archivos. </br>'.$archivos;

			}
			
			break;

		case 'comentarArchivo':
			
			if (isset($_POST['id_archivo'])) {
				$asignado=$procedimientos->comentarArchivo($_POST['id_archivo'],$_POST['correo_usuario'],$_POST['comentario_archivo'],$_POST['calificacion_archivo']);
				if (!is_string($asignado)) {
					
					$return['error'] = 0;
					$return['mensaje'] .= 'Se insertó correctamente el comentario. </br>';

				}else{

					$return['error'] = 1;
					$return['mensaje'] .= 'No se insertó correctamente el comentario. </br>'.$asignado;

				}

			}else{
				$return['mensaje'] .= 'No se insertó correctamente el comentario. </br>'.$asignado;
			}

			break;

		case 'getComentarios':

			$Comentarios = $procedimientos->getComentarios(isset($_POST['id_archivo'])?$_POST['id_archivo']:0);

			if (is_array($Comentarios)) {

				/*Regresamos el resultado que nos devolvió $procedimientos*/
				$return = array_merge($return,$Comentarios);
				$return['error'] = 0;

			}else{

				$return['error'] = 1;
				$return['mensaje'] .= 'No se lograron cargar los comentarios. </br>'.$Comentarios;

			}
			
			break;

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

		case 'getUsuariosActivos':
			
			$UsuariosActivos = $procedimientos->getUsuariosActivos();
			if (is_array($UsuariosActivos)) {
				/*Regresamos el resultado que nos devolvió $procedimientos*/
				/*Regresamos el resultado que nos devolvió $procedimientos*/
				$return = array_merge($return,$UsuariosActivos);
				$return['error'] = 0;

			}else{

				$return['error'] = 1;
				$return['mensaje'] .= 'No se lograron cargar las usuarios activos. </br>'.$UsuariosActivos;

			}

			break;

		

		default:
				$return['mensaje'] .= 'No hay caso para esa acción';
			break;
	}

	echo json_encode($return);

	