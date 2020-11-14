<!DOCTYPE html>
<html>
<head>
	<title>Web generator registro</title>
</head>
<body><center>
	<h1>Registrarse es simple</h1>
	<form action="register.php" method="POST">
		<input type="email" name="email" placeholder="Email" required><br><br>
		<input type="password" name="pass" placeholder="Contraseña" required><br><br>
		<input type="password" name="pass2" placeholder="Repetir contraseña"><br><br>
		<input type="submit" name="ingresar" value="Registrarme"><br>	
	</form>

</center></body>
</html>
<?php 
	date_default_timezone_set('UTC');


	if (isset($_POST["ingresar"])) {
		if ($_POST["email"] != "" && $_POST["pass"] != "") {
			if ($_POST["pass"] == $_POST["pass2"]) {
				$email = $_POST["email"];
				$pass = $_POST["pass"];
				$fecha = date("y-m-d");

				$con = mysqli_connect("local host", "adm_webgenerator", "webgenerator2020", "webgenerator");

				if (encontrarCorreo($email)) {
					echo '<script language="javascript">alert("Este usuario ya tiene una cuenta, intente con uno nuevo");</script>';
				} else {
					$sql = "INSERT INTO `usuarios`(`idUsuario`,`email`, `password`, `fechaRegistro`) VALUES (NULL,'$email','$pass','$fecha')";
					$res = mysqli_query($con, $sql);

					if (!$res) {
						echo '<script language="javascript">alert("No se pudo registrar, intentelo de nuevo");</script>';
					}else{
						header('Location: login.php?');				
					}
				}
				
			} else {
				echo '<script language="javascript">alert("Ambas contraseñas deben ser iguales.");</script>';
			}
			
		} 
	}

	function encontrarCorreo($correo){
		$ssql = "SELECT * FROM `usuarios` WHERE `email`='$correo'";
		$r = mysqli_query($con, $ssql);
		if(mysqli_num_rows($r) > 0) {
			return TRUE;	
		}else{
			return FALSE;			
		}

	}


 ?>