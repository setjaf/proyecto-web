<?php 
	
	if (isset($_POST['correo_usuario']) && isset($_FILES['foto'])) {
		echo 'cool';
	}else{
		print_r($_POST);
		print_r($_FILES);
	}

 ?>