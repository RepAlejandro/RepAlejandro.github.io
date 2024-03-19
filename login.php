<?php
include "conexion_db.php";
session_start();

$error = ""; 

if (isset($_SESSION["token"])) {
    header("Location: panel.php");
    exit();
}

if (isset($_POST["submit"])) {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Por favor ingrese un email válido";
    } elseif (strlen($password) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres";
    } elseif (empty($email) || empty($password)) {
        $error = "Por favor ingrese un email y contraseña";
    } else {
        $stmt = $conexion->prepare("SELECT * FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                
                $token = bin2hex(random_bytes(32));
                
                $stmt = $conexion->prepare("UPDATE usuario SET token = ? WHERE email = ?");
                $stmt->bind_param("ss", $token, $email);
                $stmt->execute();

                // Establecer el token en la sesión
                $_SESSION["token"] = $token;
 
                // Establecer la cookie del token
                setcookie("token", $token, time() + (86400 * 30), "/", "", true, true);

                $stmt->close();
                
                // Redirigir al usuario al panel
                header("Location: panel.php");
                exit();
            } else {
                $error = "Acceso incorrecto";
            }
        } else {
            $error = "Acceso incorrecto";
        }

        $stmt->close();
    }
}
?>





<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="estilos.css">
	<script type="text/javascript" src="Funciones.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<title>Consultores Caterpillar</title>
	<script>
		document.addEventListener("DOMContentLoaded", () => {
		    var form = document.getElementById("validationForm");
		    form.addEventListener("submit", event => {
		        var email = document.getElementById("email1");
		        var password = document.getElementById("password1");
		        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		        var isValidEmail = filter.test(email.value)
		        var isValidPassword = password.value.length >= 8
		        if (!isValidEmail) {
		            console.log("email not valid");
		            email.classList.add("is-invalid");
		        } else {
		            email.classList.remove("is-invalid");
		        }
		        if (!isValidPassword) {
		            console.log("Password not valid");
		            password.classList.add("is-invalid");
		        } else {
		            password.classList.remove("is-invalid");
		        }
		        if (!(isValidEmail && isValidPassword)) {
                    event.preventDefault();
                    
                }
		        

		    })
		});

	</script>
</head>
	<body>
		<!--MENÚ-->
		<nav class="menu">
			<div class="hamburguesa" onclick="mostrar()">
				<span></span><span></span><span></span>
			</div>
			<div class="logo1">
				<img src="Imágenes/1.png">
			</div>
			<label class="logo">Consultores Caterpillar</label>
			<ul id="menu-desplegable">
				<li><span class="cerrar" onclick="ocultar()">X</span></li>
				<li><a href="panel.php">INICIO</a></li>
				<li><a href="Productos2.php">PRODUCTOS</a></li>
				<li><a href="consultoria.php">CONSULTORÍA</a></li>
				<li><a href="login.php">INICIO DE SESIÓN</a></li>
			</ul>
		</nav>

		<?php if (!empty($error)) { ?>
	        <div class="alert alert-danger"><?php echo $error; ?></div>
	    <?php } ?>

		<div class="container">
		    <div class="row justify-content-center my-5">
		        <div class="col-4">
		            <form id="validationForm" method="POST">
		            	<div class="login color">Iniciar Sesión</div>
		                <div class="mb-3">
		                    <label class="color" for="exampleInputEmail1">Email</label>
		                    <input type="email" class="form-control input" id="email1" name="email" aria-describedby="emailHelp" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
		                    <div id="validationServer03Feedback" class="invalid-feedback">
		                        Invalid email.
		                    </div>
		                    <div id="emailHelp" class="form-text">:)</div>
		                </div>
		                <div class="mb-3">
		                    <label class="color" for="exampleInputPassword1">Contraseña</label>
		                    <input type="password" class="form-control input" id="password1" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
		                    <div id="validationServer03Feedback" class="invalid-feedback">
		                        Contraseña incorrecta.
		                    </div>
		                </div>
		                <div class="text-center">
		                    <button type="submit" class="btn btn-primary" name="submit">Entrar</button>
		                </div>

		                <div class="color align">¿No tienes una cuenta? <a href="registro.php">Crear Cuenta</a></div>
		            </form>
		        </div>
		    </div>
		</div>

    	<!--REDES SOCIALES-->
	    <footer class="redes">
			<h3>SÍGUENOS EN:</h3>
			<a href="https://www.facebook.com/caterpillarinc" target="_blank"><i class="bx bxl-facebook-circle bx-md bx-tada-hover espacio" style = 'color:#ffffff' ></i></a>
			<a href="https://www.instagram.com/caterpillarinc/" target="_blank"><i class="bx bxl-instagram-alt  bx-md bx-tada-hover espacio" style = 'color:#ffffff'></i></a>
			<a href="https://www.youtube.com/CatProducts" target="_blank"><i class="bx bxl-youtube  bx-md bx-tada-hover espacio" style = 'color:#ffffff'></i></a>
			<a href="https://twitter.com/CaterpillarInc" target="_blank"><i class="bx bxl-twitter  bx-md bx-tada-hover espacio" style = 'color:#ffffff'></i></a>
		</footer>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
	</body>
</html>
