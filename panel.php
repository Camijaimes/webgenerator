<?php 
	session_start();
	$con = mysqli_connect("local host", "adm_webgenerator", "webgenerator2020", "webgenerator");
	if (isset($_SESSION["id"])) {
		
		if (isset($_POST["crear"])) {
			if ($_POST["nombre"] != "") {

				$name = $_SESSION["id"].$_POST["nombre"];
				$fecha = date("y-m-d");

				if (encontrarDominio($name)) {
					echo '<script language="javascript">alert("Este dominio ya está registrado.");</script>';
				} else {
					$sql = "INSERT INTO `webs`(`idWeb`,`idUsuario`,`dominio`, `fechaCreacion`) VALUES (NULL,'".$_SESSION["id"]."','$name','$fecha')";
					$res = mysqli_query($con, $sql);

					if (!$res) {
						echo '<script language="javascript">alert("No se pudo crear la web, intentelo nuevamente mas tarde.");</script>';
					}else{
						echo '<script language="javascript">alert("Web creada con éxito.");</script>';			
					}
				}
				shell_exec('./wix.sh '.$name);
				shell_exec('chmod 777 '.$name);
			}
		}
	} else {
		header('Location : login.php');
	}


	


	function encontrarDominio($dom){
		$con =mysqli_connect("local host", "adm_webgenerator", "webgenerator2020", "webgenerator");
		$ssql = "SELECT * FROM `webs` WHERE `dominio`='$dom'";
		$r = mysqli_query($con, $ssql);
		if(mysqli_num_rows($r) > 0) {
			return TRUE;	
		}else{
			return FALSE;			
		}

	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Web generator panel</title>
</head>
<body><center>	
	<h1>Bienvenido a tu panel</h1>
		<?php 
			
			echo "<a href='logout.php'><i>Cerrar sesion de ".$_SESSION["id"]."</i></a>";
		 ?>
	<h1>Generar Web de:</h1>
	<form action="panel.php" method="POST">
		<input type="text" name="nombre" placeholder="Nombre de la web"><br><br>
		<input type="submit" name="crear" value="Crear web">
	</form>
	<?php 

			$con = mysqli_connect("local host", "adm_webgenerator", "webgenerator2020", "webgenerator");

			if ($_SESSION["email"] == "admin@server" && $_SESSION["pass"] == "serveradmin") {
				$ssql = "SELECT * FROM `webs` WHERE 1";
			} else {
				$ssql = "SELECT * FROM `webs` WHERE `idUsuario`='".$_SESSION["id"]."'";
			}

			$r = mysqli_query($con, $ssql);

			if(mysqli_num_rows($r) > 0) {

				while ($fila = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					shell_exec('zip -r '.$fila["dominio"].'.zip '.$fila["dominio"]);
					echo "<a href='".$fila["dominio"]."../index.php'>".$fila["dominio"]."</i></a> <a href=".$fila["dominio"].".zip>    descargar web</a><br><br>";					
				}	

			}

		 ?>
</center>
</body>
</html>
