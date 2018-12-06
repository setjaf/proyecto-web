<?php 

	/**
	 * summary
	 */
	class Procedimientos
	{
	    /**
	     * summary
	     */
	    private $con=null;
	    
	    public function __construct(){
	        $con=$this->conexion_mysql();
	        if ($con!=null) {
	        }
	        $con->close();

	    }

	    private function conexion_mysql(){
	    	$mysqli = new mysqli("127.0.0.1", "root", "", "escompartiendo", 3306);

			if ($mysqli->connect_errno) {
			    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			    return null;
			}
			mysqli_set_charset( $mysqli, 'utf8');
			return $mysqli;
	    }

	    public function insertar_permiso($descripcion=""){

			$con=$this->conexion_mysql();
			if ($con!=null) {
				

					$result=mysqli_query($con,"INSERT INTO permiso(descripcion) values ('$descripcion');");

					$return = $result;

					$con->close();

					return $return;				

				
				
			}else {


				echo mysqli_error($con);				
				return false;

			}

		}

		public function insertar_rol($descripcion=""){

			$con=$this->conexion_mysql();


			if ($con!=null) {

				
					$result=mysqli_query($con,"INSERT INTO rol(descripcion) values ('$descripcion');");
					if ($result) {
						$result=mysqli_query($con,"SELECT * FROM rol WHERE descripcion='$descripcion'");

						$i=0;
						
						while ($fila = $result->fetch_row()) {
						    $return[$i]=$fila;
						    $i++;
						}

						$result->close();
					}else {
						
						$return = $result;

						$result->close();
						
					}

					$con->close();

					return $return;

							
				
			}else {


				echo mysqli_error($con);
				return false;
				
			}

		}

		public function agregar_permiso_rol($rol="",$permiso=""){
			$con=$this->conexion_mysql();
			if ($con!=null) {
				
					$result=mysqli_query($con,"INSERT INTO rol_permiso(rol,permiso) values ($rol,$permiso);");

					$return = $result;

					$con->close();

					return $return;			
				
			}else {


				echo mysqli_error($con);
				return false;
				
			}

		}

		public function insertar_usuario($correo,$contraseña,$nombre,$paterno,$materno,$fecha_nacimiento,$boleta="",$curp,$status,$rol){

			$con=$this->conexion_mysql();
			if ($con!=null) {
					
					$result=mysqli_query($con,"INSERT INTO usuario(correo,contrasena,fecha_alta,nombre,paterno,materno,fecha_nacimiento,boleta,CURP,status,rol,foto) values ('$correo','$contraseña',CURDATE(),'$nombre','$paterno','$materno','$fecha_nacimiento',".($boleta==''?'NULL':"'".$boleta."'").",'$curp',$status,$rol,'')");
					
					if ($result) {
						$result=mysqli_query($con,"SELECT * FROM usuario WHERE correo='$correo'");

						$i=0;

						$return=array();

						while ($fila = $result->fetch_row()) {
							
						    $return[$i]=$fila;
						    $i++;
						}

						$result->close();
					}else {
						
						$return = mysqli_error($con);
						
					}
					
					$con->close();

					return $return;								
				
			}else {


				return mysqli_error($con);
				
			}

		}

		public function insertar_foto_usuario($foto_path,$correo){

			$con=$this->conexion_mysql();
			if ($con!=null) {
				
					$result=mysqli_query($con,"UPDATE usuario SET foto='$foto_path' WHERE correo='$correo'");

					$return = $result;

					$con->close();

					return $return;		
		
				
			}else {


				echo mysqli_error($con);
				return false;
				
			}

		}

		public function seleccionar_permiso(){
			$con= $this->conexion_mysql();
			if ($con!=null) {
				
					if($result=mysqli_query($con,"SELECT * FROM permiso")){
						
						$i=0;
						
						while ($fila = $result->fetch_row()) {
						    $return[$i]=$fila;
						    $i++;
						}

						$result->close();
					}else {
						echo mysqli_error($con);
						$return = $result;
						
					}

					$con->close();

					return $return;
					
				
			}
			else{
				echo mysqli_error($con);
				return false;

			}
			
		}

		public function seleccionar_rol(){
			$con= $this->conexion_mysql();
			if ($con!=null) {
				
					if($result=mysqli_query($con,"SELECT * FROM rol")){
						
						$i=0;
						
						while ($fila = $result->fetch_row()) {
						    $return[$i]=$fila;
						    $i++;
						}

						$result->close();
					}else {
						echo mysqli_error($con);
						$return = $result;
						
					}

					$con->close();

					return $return;
					
				
			}
			else{
				echo mysqli_error($con);
				return false;

			}
			
		}

		public function seleccionar_usuarios(){
			$con= $this->conexion_mysql();
			if ($con!=null) {
				
					if($result=mysqli_query($con,"SELECT * FROM usuario")){
						
						$i=0;
						
						while ($fila = $result->fetch_row()) {
						    $return[$i]=$fila;
						    $i++;
						}

						$result->close();
					}else {
						echo mysqli_error($con);
						$return = $result;
						
					}

					$con->close();

					return $return;
					
				
			}
			else{
				echo mysqli_error($con);
				return false;

			}
			
		}

		public function seleccionar_usuario($id_usuario){
			$con= $this->conexion_mysql();

			if ($con!=null) {
				
					if($result=mysqli_query($con,"SELECT * FROM usuario WHERE id=$id_usuario")){
						
						$i=0;
						
						while ($fila = $result->fetch_row()) {
						    $return[$i]=$fila;
						    $i++;
						}

						$result->close();
					}else {

						echo mysqli_error($con);

						$return = $result;
						
					}

					$con->close();

					return $return;
					
				
			}
			else{
				echo(mysqli_error($con));
				return false;

			}
			
		}

		public function editar_usuario($correo,$contraseña,$nombre,$paterno,$materno,$fecha_nacimiento,$boleta,$curp,$status,$rol){

			$con=$this->conexion_mysql();
			if ($con!=null) {
					
					$result=mysqli_query($con," UPDATE usuario SET contrasena='$contraseña',nombre='$nombre', paterno='$paterno' , materno='$materno',fecha_nacimiento='$fecha_nacimiento' ,boleta='$boleta' ,CURP='$curp',rol=$rol WHERE correo='$correo'");
					
					if ($result) {
						$result=mysqli_query($con,"SELECT * FROM usuario WHERE correo='$correo'");

						$i=0;
						
						while ($fila = $result->fetch_row()) {
						    $return[$i]=$fila;
						    $i++;
						}

						$result->close();
					}else {
						
						$return = $result;
						
					}

					$con->close();

					return $return;									
				
			}else {


				echo mysqli_error($con);
				return false;
				
			}

		}

		public function borrar_usuario($id){
			$con=$this->conexion_mysql();
			if ($con!=null) {

				

					$result=mysqli_query($con,"DELETE FROM usuario WHERE id=$id");

					$return = $result;

					$con->close();

					return $return;		
				
				
			}else {


				echo mysqli_error($con);				
				return false;

			}
		}

		public function crearUA($nombre, $descripcion, $nivel){

			$con=$this->conexion_mysql();
			if ($con!=null) {
				

					$result=mysqli_query($con,"INSERT INTO unidad_aprendizaje(nombre,descripcion,nivel) values ('$nombre','$descripcion',$nivel);");

					$return = $result;

					if (!$return) {

						$return = mysqli_error($con);

					}					

					$con->close();				

					return $return;				

				
				
			}else {


				echo mysqli_error($con);				
				return false;

			}

		}

		public function getProfesores($ua){

			$con= $this->conexion_mysql();
			if ($con!=null) {
					$return=false;
					$result=false;
					if (isset($ua)) {
						$result=mysqli_query($con,"SELECT DISTINCT id, nombre, paterno, materno FROM usuario a INNER JOIN ua_profesor b ON b.profesor=a.id WHERE ".(is_numeric($ua)?"b.ua=$ua AND ":"")."a.status = 1 AND a.rol=(SELECT id FROM rol WHERE descripcion='profesor')");
					}else {
						$result=mysqli_query($con,"SELECT id, nombre, paterno, materno FROM usuario WHERE rol = (SELECT id FROM rol WHERE descripcion='profesor') and status=1");
					}

					
					if(isset($result->num_rows) && (int)$result->num_rows>=0){
						
						$i=0;

						$return = array();
						
						while ($fila = $result->fetch_row()) {
						    $return[$i]=$fila;
						    $i++;
						}

						$result->close();
					}else {

						$return=mysqli_error($con);
						
					}

					$con->close();

					return $return;
					
				
			}
			else{
				return mysqli_error($con);

			}

		}

		public function getUAs($correo=NULL){
			$con= $this->conexion_mysql();
			if ($con!=null) {
					$return=false;

					if (isset($correo)) {

						$result=mysqli_query($con,"SELECT id, nombre FROM unidad_aprendizaje a inner join ua_profesor b on a.id =  b.ua where b.profesor = (SELECT id FROM usuario WHERE correo = '$correo')");
					
					}else{
						$result=mysqli_query($con,"SELECT id, nombre FROM unidad_aprendizaje");
					}				
					

					if(isset($result->num_rows) && (int)$result->num_rows>=0){
						
						$i=0;

						$return = array();
						
						while ($fila = $result->fetch_row()) {
						    $return[$i]=$fila;
						    $i++;
						}

						$result->close();
					}else {
						$return = mysqli_error($con);
						
					}

					$con->close();

					return $return;
					
				
			}
			else{

				return mysqli_error($con);

			}
			
		}

		public function asignarUAProfesor($profesor, $ua){

			$con=$this->conexion_mysql();
			if ($con!=null) {				

					$result=mysqli_query($con,"INSERT INTO ua_profesor(ua,profesor) values ($ua,$profesor);");

					$return = $result;

					if (!$return) {
						$return=mysqli_error($con);
					}

					$con->close();				

					return $return;				

				
				
			}else {


				echo mysqli_error($con);				
				return false;

			}

		}
		public function validar_usuario($usuario, $contrasena){

			$con=$this->conexion_mysql();
			if ($con!=null) {
					$return = false;
				
					if($result=mysqli_query($con,"SELECT correo, nombre, paterno, rol, foto FROM usuario WHERE correo='$usuario' and contrasena='$contrasena' and status=1;")){
						
						$i=0;

						while ($fila = $result->fetch_array(MYSQLI_ASSOC)) {
						    $return[$i]=$fila;
						    $i++;
						}

						$result->close();
					}else {

						$return = mysqli_error($con);
						
					}

					$con->close();

					return $return;


				
				
			}else {


				return mysqli_error($con);

			}

		}
		public function getPermisos($rol)
		{

			$con= $this->conexion_mysql();
			if ($con!=null) {
					$return = false;
					if($result=mysqli_query($con,"SELECT b.id, b.descripcion FROM rol_permiso a INNER JOIN permiso b ON a.permiso = b.id WHERE a.rol = $rol")){
						
						$i=0;
						
						while ($fila = $result->fetch_row()) {
						    $return[$i]=$fila;
						    $i++;
						}

						$result->close();
					}else {

						$return = mysqli_error($con);
						
					}

					$con->close();

					return $return;
					
				
			}
			else{
				return mysqli_error($con);

			}
			
		}

		public function getSolicitudes()
		{

			$con= $this->conexion_mysql();
			if ($con!=null) {
					$return = false;

					$result=mysqli_query($con,"SELECT correo, nombre, paterno, rol, foto, fecha_alta, materno FROM usuario WHERE status = 0");

					if(isset($result->num_rows) && (int)$result->num_rows>=0){
						
						$i=0;

						$return = array();
						
						while ($fila = $result->fetch_row()) {
						    $return[$i]=$fila;
						    $i++;
						}

						$result->close();
					}else {

						$return = mysqli_error($con);
						
					}

					$con->close();

					return $return;
					
				
			}
			else{
				return mysqli_error($con);

			}
			
		}

		public function aceptarUsuario($correo)
		{

			$con= $this->conexion_mysql();
			if ($con!=null) {
					$return = false;
					$result = mysqli_query($con,"UPDATE usuario SET status = 1 WHERE correo = '$correo'");
										
					$return = mysqli_error($con);
					
					if ($return=='') {
						$return = $result;
					}

					$con->close();

					return $return;
					
				
			}
			else{
				return mysqli_error($con);

			}
			
		}

		public function desactivarUsuario($correo)
		{

			$con= $this->conexion_mysql();
			if ($con!=null) {
					$return = false;
					$result = mysqli_query($con,"UPDATE usuario SET status = 0 WHERE correo = '$correo'");
										
					$return = mysqli_error($con);
					
					if ($return=='') {
						$return = $result;
					}

					$con->close();

					return $return;
					
				
			}
			else{
				return mysqli_error($con);

			}
			
		}

		public function eliminarUsuario($correo)
		{

			$con= $this->conexion_mysql();
			if ($con!=null) {
					$return = false;
					$result = mysqli_query($con,"DELETE FROM usuario WHERE correo = '$correo'");
										
					$return = mysqli_error($con);
					
					if ($return=='') {
						$return = $result;
					}

					$con->close();

					return $return;
					
				
			}
			else{
				return mysqli_error($con);

			}
			
		}

		public function crearGrupo($nombre, $ua, $correo){

			$con=$this->conexion_mysql();
			if ($con!=null) {
				

					$result=mysqli_query($con,"INSERT INTO grupo(nombre,ua,profesor) values ('$nombre',$ua,(SELECT id FROM usuario WHERE correo='$correo'))");

					$return = $result;

					if (!$return) {

						$return = mysqli_error($con);

					}					

					$con->close();				

					return $return;				

				
				
			}else {


				echo mysqli_error($con);				
				return false;

			}

		}

		public function getGrupos($correo,$ua,$profesor,$nombre=null){
			$con= $this->conexion_mysql();
			if ($con!=null) {

					$return=false;

					if (isset($profesor) || isset($ua)) {
						/*echo "SELECT a.id, a.nombre, a.profesor, c.nombre, c.paterno, c.materno, d.nombre FROM grupo a LEFT JOIN grupo_alumno b ON a.id = b.grupo INNER JOIN usuario c ON c.id = a.profesor INNER JOIN unidad_aprendizaje d ON d.id = a.ua WHERE (a.nombre LIKE '%$nombre%') ".(is_numeric($profesor)?"AND a.profesor = $profesor ":"").(is_numeric($ua)?"AND a.ua = $ua ":"")."AND (b.alumno <> (SELECT id FROM usuario WHERE correo='$correo') OR b.alumno IS NULL)";/*/
						$result=mysqli_query($con,"SELECT a.id, a.nombre, a.profesor, c.nombre, c.paterno, c.materno, d.nombre FROM grupo a LEFT JOIN (SELECT * FROM grupo_alumno WHERE alumno=(SELECT id FROM usuario WHERE correo='$correo')) b ON a.id = b.grupo INNER JOIN usuario c ON c.id = a.profesor INNER JOIN unidad_aprendizaje d ON d.id = a.ua WHERE (a.nombre LIKE '%$nombre%') ".(is_numeric($profesor)?"AND a.profesor = $profesor ":"").(is_numeric($ua)?"AND a.ua = $ua ":"")."AND (b.alumno <> (SELECT id FROM usuario WHERE correo='$correo') OR b.alumno IS NULL)");
					}else{
						$result=mysqli_query($con,"SELECT id, nombre FROM grupo WHERE profesor=(SELECT id FROM usuario WHERE correo='$correo')");
					}
					

					//SELECT * FROM grupo a LEFT JOIN grupo_alumno b ON a.id = b.grupo WHERE b.grupo IS NULL AND a.profesor = $profesor AND a.ua = $ua AND (b.alumno <> (SELECT id FROM usuario WHERE correo='$correo') OR b.alumno IS NULL) AND (nombre LIKE '%$nombre%');
					
					

					if(isset($result->num_rows) && (int)$result->num_rows>=0){
						
						$i=0;

						$return = array();
						
						while ($fila = $result->fetch_row()) {
						    $return[$i]=$fila;
						    $id=$return[$i][0];
						    $result2=mysqli_query($con,"SELECT COUNT(*) FROM grupo_alumno WHERE grupo=$id");
						    $return[$i][2]=$result2->fetch_row()[0];
						    $i++;
						    $result2->close();
						}

						$result->close();
						
					}else {
						$return = mysqli_error($con);
						
					}

					$con->close();

					return $return;
					
				
			}
			else{

				return mysqli_error($con);

			}
			
		}

		public function getGruposAlumno($correo){
			$con= $this->conexion_mysql();
			if ($con!=null) {

					$return=false;

					
					$result=mysqli_query($con,"SELECT b.id, b.nombre FROM grupo_alumno a INNER JOIN grupo b on a.grupo = b.id WHERE a.alumno = (SELECT id FROM usuario WHERE correo='$correo')");
					
					

					//SELECT * FROM grupo a LEFT JOIN grupo_alumno b ON a.id = b.grupo WHERE b.grupo IS NULL AND a.profesor = $profesor AND a.ua = $ua AND (b.alumno <> (SELECT id FROM usuario WHERE correo='$correo') OR b.alumno IS NULL) AND (nombre LIKE '%$nombre%');
					
					

					if(isset($result->num_rows) && (int)$result->num_rows>=0){
						
						$i=0;

						$return = array();
						
						while ($fila = $result->fetch_row()) {
						    $return[$i]=$fila;
						    $id=$return[$i][0];
						    $result2=mysqli_query($con,"SELECT COUNT(*) FROM grupo_alumno WHERE grupo=$id");
						    $return[$i][2]=$result2->fetch_row()[0];
						    $i++;
						    $result2->close();
						}

						$result->close();
						
					}else {
						$return = mysqli_error($con);
						
					}

					$con->close();

					return $return;
					
				
			}
			else{

				return mysqli_error($con);

			}
			
		}

		public function eliminarGrupo($grupo_id,$correo){

			$con=$this->conexion_mysql();
			if ($con!=null) {
				

					$result=mysqli_query($con,"DELETE FROM grupo WHERE id = $grupo_id and profesor=(SELECT id FROM usuario WHERE correo = '$correo')");

					$return = $result;

					if (!$return) {

						$return = mysqli_error($con);

					}					

					$con->close();				

					return $return;				

				
				
			}else {


				echo mysqli_error($con);				
				return false;

			}

		}

		public function insertar_archivo($nombre_archivo,$descripcion_archivo,$correo,$ua,$nivel){
			
			$con=$this->conexion_mysql();
			if ($con!=null) {
					$result=mysqli_query($con,"INSERT INTO archivo(nombre,fecha_carga,status,profesor,unidad_aprendizaje,descripcion, nivel) VALUE ('$nombre_archivo',CURDATE(),1,(SELECT id FROM usuario WHERE correo='$correo'),$ua,'$descripcion_archivo',$nivel)");
					
					if ($result) {

						$result=mysqli_insert_id($con);

						$i=0;

						$return=$result;
					}else {
						
						$return = mysqli_error($con);
						
					}
					
					$con->close();

					return $return;								
				
			}else {


				return mysqli_error($con);
				
			}
		}

		public function insertar_url_archivo($archivo_path,$id_archivo,$correo){

			$con=$this->conexion_mysql();
			if ($con!=null) {
				
					$result=mysqli_query($con,"UPDATE archivo SET url='$archivo_path' WHERE profesor=(SELECT id FROM usuario WHERE correo='$correo') AND id=$id_archivo");

					$return = $result;

					if (!$return) {

						$return = mysqli_error($con);

					}	

					$con->close();

					return $return;		
		
				
			}else {


				echo mysqli_error($con);
				return false;
				
			}

		}

		public function getArchivos($correo){
			$con= $this->conexion_mysql();
			if ($con!=null) {
					$return=false;

					mysqli_set_charset( $con, 'utf8');
					
					$result=mysqli_query($con,"SELECT nombre, descripcion, fecha_carga, url, unidad_aprendizaje, nivel, id FROM archivo WHERE profesor=(SELECT id FROM usuario WHERE correo='$correo') AND status=1");

					if(isset($result->num_rows) && (int)$result->num_rows>=0){
						
						$i=0;

						$return = array();
						
						while ($fila = $result->fetch_row()) {
							$result2=mysqli_query($con,"SELECT nombre FROM unidad_aprendizaje WHERE id = $fila[4]");
							$return[$result2->fetch_row()[0]][]=$fila;
						    //array_push($return[$result2->fetch_row()[0]],$fila);
						    $i++;
						    $result2->close();
						}

						$result->close();
					}else {
						$return = mysqli_error($con);
						
					}

					$con->close();

					return $return;
					
				
			}
			else{

				return mysqli_error($con);

			}
		}

		public function insertar_tarea($nombre_tarea,$descripcion_tarea,$fecha_termino,$correo,$grupo,$archivo){


			$con=$this->conexion_mysql();
			if ($con!=null) {

					$result=mysqli_query($con,"INSERT INTO tarea(nombre, descripcion, fecha_creacion, fecha_termino, profesor, grupo, archivo, path_archivo) VALUE ('$nombre_tarea', '$descripcion_tarea',CURDATE(),'$fecha_termino',(SELECT id FROM usuario WHERE correo='$correo'),$grupo,$archivo,'')");
					
					if ($result) {

						$result=mysqli_insert_id($con);

						$i=0;

						$return=$result;
					}else {
						
						$return = mysqli_error($con);
						
					}
					
					$con->close();

					return $return;								
				
			}else {


				return mysqli_error($con);
				
			}
		}

		public function insertar_url_tarea($id,$archivo_path,$correo,$grupo){

			$con=$this->conexion_mysql();
			if ($con!=null) {
				
					$result=mysqli_query($con,"UPDATE tarea SET path_archivo='$archivo_path' WHERE profesor=(SELECT id FROM usuario WHERE correo='$correo') AND id=$id");

					$return = $result;

					if (!$return) {

						$return = mysqli_error($con);

					}	

					$con->close();

					return $return;		
		
				
			}else {


				echo mysqli_error($con);
				return false;
				
			}

		}

		public function getGruposArchivos($correo){
			$con= $this->conexion_mysql();
			if ($con!=null) {
					$return=false;
					
					$result=mysqli_query($con,"SELECT a.id, a.nombre, b.nombre,b.descripcion, b.path_archivo, b.fecha_termino  FROM tarea b left join grupo a on a.id = b.grupo WHERE a.profesor=(SELECT id FROM usuario WHERE correo='$correo') ORDER BY b.fecha_creacion DESC LIMIT 4;");

					if(isset($result->num_rows) && (int)$result->num_rows>=0){
						
						$i=0;

						$return = array();
						
						while ($fila = $result->fetch_row()) {
						    $return[$i]=$fila;
						    $i++;
						}

						$result->close();
					}else {
						$return = mysqli_error($con);
						
					}

					$con->close();

					return $return;
					
				
			}
			else{

				return mysqli_error($con);

			}
			
		}

		public function eliminarArchivo($archivo_id,$correo){

			$con=$this->conexion_mysql();
			if ($con!=null) {
				

					$result=mysqli_query($con,"DELETE FROM archivo WHERE id = $archivo_id and profesor=(SELECT id FROM usuario WHERE correo = '$correo')");

					$return = $result;

					if (!$return) {

						$return = mysqli_error($con);

					}					

					$con->close();				

					return $return;				

				
				
			}else {


				echo mysqli_error($con);				
				return false;

			}

		}

		public function inscribirGrupo($grupo,$correo){

			$con=$this->conexion_mysql();
			if ($con!=null) {				

					$result=mysqli_query($con,"INSERT INTO grupo_alumno(alumno,grupo) values ( (SELECT id FROM usuario WHERE correo = '$correo') ,$grupo);");

					$return = $result;

					if (!$return) {
						$return=mysqli_error($con);
					}

					$con->close();				

					return $return;				

				
				
			}else {


				echo mysqli_error($con);				
				return false;

			}

		}
		// 

		public function getTareas($correo,$grupo)
		{

			$con= $this->conexion_mysql();
			if ($con!=null) {
					$return = false;

					$result=mysqli_query($con,"SELECT a.id, a.nombre, a.descripcion, a.fecha_termino, a.path_archivo, c.nombre, c.url, a.grupo FROM tarea a LEFT JOIN tarea_enviada b ON a.id = b.tarea INNER JOIN archivo c ON c.id = a.archivo WHERE (b.tarea IS NULL OR b.alumno <>(SELECT id FROM usuario WHERE correo='$correo') ) AND a.grupo = '$grupo' AND CURDATE()<=DATE(a.fecha_termino)");

					if(isset($result->num_rows) && (int)$result->num_rows>=0){
						
						$i=0;

						$return = array();
						
						while ($fila = $result->fetch_row()) {
						    $return[$i]=$fila;
						    $i++;
						}

						$result->close();
					}else {

						$return = mysqli_error($con);
						
					}

					$con->close();

					return $return;
					
				
			}
			else{
				return mysqli_error($con);

			}
			
		}
		public function getTarea($id_tarea)
				{

					$con= $this->conexion_mysql();
					if ($con!=null) {
							$return = false;

							$result=mysqli_query($con,"SELECT a.id, a.nombre,a.descripcion,a.fecha_termino,a.path_archivo,b.nombre,b.url FROM tarea a INNER JOIN archivo b ON a.archivo = b.id WHERE a.id = '$id_tarea'");

							if(isset($result->num_rows) && (int)$result->num_rows>=0){
								
								$i=0;

								$return = array();
								
								while ($fila = $result->fetch_row()) {
								    $return[$i]=$fila;
								    $i++;
								}

								$result->close();
							}else {

								$return = mysqli_error($con);
								
							}

							$con->close();

							return $return;
							
						
					}
					else{
						return mysqli_error($con);

					}
					
				}

		public function enviartarea($tarea,$correo){


			$con=$this->conexion_mysql();
			if ($con!=null) {

					$result=mysqli_query($con,"INSERT INTO tarea_enviada(fecha_subida, alumno,tarea) VALUE (CURDATE(), (SELECT id FROM usuario WHERE correo='$correo'),$tarea)");
					
					if ($result) {

						$result=mysqli_insert_id($con);

						$i=0;

						$return=$result;
					}else {
						
						$return = mysqli_error($con);
						
					}
					
					$con->close();

					return $return;								
				
			}else {


				return mysqli_error($con);
				
			}
		}

		public function insertar_url_tarea_enviada($id,$archivo_path,$correo){

			$con=$this->conexion_mysql();
			if ($con!=null) {
				
					$result=mysqli_query($con,"UPDATE tarea_enviada SET path_archivo='$archivo_path' WHERE alumno=(SELECT id FROM usuario WHERE correo='$correo') AND tarea=$id");

					$return = $result;

					if (!$return) {

						$return = mysqli_error($con);

					}	

					$con->close();

					return $return;		
		
				
			}else {


				echo mysqli_error($con);
				return false;
				
			}

		}

		public function id_usuario($correo){

			$con=$this->conexion_mysql();
			if ($con!=null) {
				
					$result=mysqli_query($con,"SELECT id FROM usuario WHERE correo='$correo'");

					$return = $result->fetch_row()[0];

					if (!$return) {

						$return = mysqli_error($con);

					}	

					$con->close();

					return $return;		
		
				
			}else {


				echo mysqli_error($con);
				return false;
				
			}

		}

		public function salirGrupo($grupo,$correo){

			$con=$this->conexion_mysql();
			if ($con!=null) {
				

					$result=mysqli_query($con,"DELETE FROM grupo_alumno WHERE grupo = $grupo and alumno=(SELECT id FROM usuario WHERE correo = '$correo')");

					$return = $result;

					if (!$return) {

						$return = mysqli_error($con);

					}					

					$con->close();				

					return $return;				

				
				
			}else {


				echo mysqli_error($con);				
				return false;

			}

		}

		public function buscarArchivos($nombre,$profesor,$ua,$nivel){


			$con= $this->conexion_mysql();
			if ($con!=null) {

					$return=false;

					$result=mysqli_query($con,"SELECT a.id, a.nombre, a.descripcion, a.fecha_carga, a.url, a.nivel,b.id,b.nombre, b.paterno, b.materno,c.id,c.nombre FROM archivo a INNER JOIN usuario b on a.profesor = b.id INNER JOIN unidad_aprendizaje c ON a.unidad_aprendizaje=c.id WHERE a.nombre like '%$nombre%' ".(is_numeric($profesor)?"AND a.profesor = $profesor ":"").(is_numeric($ua)?"AND a.unidad_aprendizaje=$ua ":"").(is_numeric($nivel)?"AND a.nivel=1":""));
										

					//SELECT * FROM grupo a LEFT JOIN grupo_alumno b ON a.id = b.grupo WHERE b.grupo IS NULL AND a.profesor = $profesor AND a.ua = $ua AND (b.alumno <> (SELECT id FROM usuario WHERE correo='$correo') OR b.alumno IS NULL) AND (nombre LIKE '%$nombre%');
					
					

					if(isset($result->num_rows) && (int)$result->num_rows>=0){
						

						$return = array();
						
						while ($fila = $result->fetch_row()) {
						    $id=$fila[10];
						    $return[$id][]=$fila;
						}

						$result->close();
						
					}else {
						$return = mysqli_error($con);
						
					}

					$con->close();

					return $return;
					
				
			}
			else{

				return mysqli_error($con);

			}


		}



	}	


?>