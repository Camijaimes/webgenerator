<!DOCTYPE html>
<html>
	<head>
		<title>Web generator login</title>
	</head>
	<body><center>
		<h1>Web generator</h1>
		<form action="login.php" method="POST">
			<input type="email" name="email" placeholder="Email" required><br><br>
			<input type="password" name="pass" placeholder="Contraseña" required><br><br>
			<input type="submit" name="ingresar" value="Inciar Sesión"><br>
		</form>
		<a href="register.php">Registrarme</a>
	</center></body>
</html>
<?php 
	session_start();
	if (isset($_POST["ingresar"])) {
		if ($_POST["email"] != "" && $_POST["pass"] != "") {
			
			$email = $_POST["email"];
			$pass = $_POST["pass"];

			$con = mysqli_connect("local host", "adm_webgenerator", "webgenerator2020", "webgenerator");
			$sql = "SELECT * FROM `usuarios` WHERE `email`='$email'  AND `password`='$pass'";
			$res = mysqli_query($con, $sql);

			if (mysqli_num_rows($res) > 0) {
				while ($fila = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
					$_SESSION["id"] = $fila["idUsuario"];
					$_SESSION["email"] = $fila["email"];
					$_SESSION["pass"] = $fila["password"];
				header('Location: panel.php?');					
				}
			}else{
				echo '<script language="javascript">alert("Datos incorrectos.");</script>';			
			}
		}

	}

 ?>