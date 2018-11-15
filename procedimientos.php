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
	    	$mysqli = new mysqli("127.0.0.1", "root", "root", "escompartiendo", 3306);

			if ($mysqli->connect_errno) {
			    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			    return null;
			}

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

						$fila = $result->fetch_row();

						mysqli_query($con,"INSERT INTO confirmacion_correo(usuario_nuevo,codigo) VALUES ($fila[0],UUID());");
						
						$result=mysqli_query($con,"SELECT * FROM usuario WHERE correo='$correo'");

						while ($fila = $result->fetch_row()) {
							
						    $return[$i]=$fila;
						    $i++;
						}

						print_r($return);

						$result->close();
					}else {
						
						$return = $result;
						
					}

					
					$con->close();

					return (mysqli_error($con)!=''?$return:mysqli_error($con));								
				
			}else {


				echo mysqli_error($con);
				return false;
				
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

		public function agregar_ua($nombre, $descripcion, $nivel){

			$con=$this->conexion_mysql();
			if ($con!=null) {
				

					$result=mysqli_query($con,"INSERT INTO unidad_aprendizaje(nombre,descripcion,nivel) values ('$nombre','$descripcion',nivel);");

					$return = $result;

					echo mysqli_error($con);

					$con->close();				

					return $return;				

				
				
			}else {


				echo mysqli_error($con);				
				return false;

			}

		}

		public function seleccionar_profesores(){

			$con= $this->conexion_mysql();
			if ($con!=null) {
				
					if($result=mysqli_query($con,"SELECT * FROM usuario WHERE rol = (SELECT id FROM rol WHERE descripcion='profesor')")){
						
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

		public function seleccionar_uas(){
			$con= $this->conexion_mysql();
			if ($con!=null) {
				
					if($result=mysqli_query($con,"SELECT * FROM unidad_aprendizaje")){
						
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

		public function asignar_ua_profesor($profesor, $ua){

			$con=$this->conexion_mysql();
			if ($con!=null) {
				

					$result=mysqli_query($con,"INSERT INTO ua_profesor(ua,usuario) values ($ua,$profesor);");

					$return = $result;

					echo mysqli_error($con);

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
				
					if($result=mysqli_query($con,"SELECT correo, nombre, paterno, rol FROM usuario WHERE correo='$usuario' and contrasena='$contrasena' and status=1;")){
						
						$i=0;

						while ($fila = $result->fetch_array(MYSQLI_ASSOC)) {
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


				
				
			}else {


				echo mysqli_error($con);				
				return false;

			}

		}
	}	


?>