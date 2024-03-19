<?php

include "conexion_db.php";
error_reporting(0);
session_start();

$error = "";

$correct = "";

if (isset($_SESSION["token"])) {
    header("Location: panel.php");
    exit();
}

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    if(strlen($username) < 3){
    	$error = "Por favor, el usuario debe tener al menos 3 caracteres";
    }elseif (empty($email)) {
        $error = "Por favor, ingrese su correo electrónico";
    } else if (strlen($password) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres";
        $username = "";
        $email = "";
        $_POST["password"] = "";
        $_POST["cpassword"] = "";
    } else if ($password == $cpassword) {
        $check_email = "SELECT * FROM usuario WHERE email='$email'";
        $result = mysqli_query($conexion, $check_email);
        if (mysqli_num_rows($result) == 0) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuario (username, email, password, Id_Rol) VALUES ('$username', '$email', '$hashed_password', 2)";
            if (mysqli_query($conexion, $sql)) {
            	 $correct  = "Usuario registrado correctamente";
                $username = "";
                $email = "";
                $_POST["password"] = "";
                $_POST["cpassword"] = "";
                
               
               
            } else {
                $error = "Hay un error";
            }
        } else {
            $error = "El correo ya existe";
        }
    } else {
        $error = "Las contraseñas no coinciden";
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
    document.addEventListener("DOMContentLoaded", function() {
        var form = document.getElementById("registrationForm");

        form.addEventListener("submit", function(event) {
            var username = document.getElementById("username2");
            var email = document.getElementById("email2");
            var password = document.getElementById("password2");
            var cpassword = document.getElementById("cpassword2");

            username.classList.remove("is-invalid");
            email.classList.remove("is-invalid");
            password.classList.remove("is-invalid");
            cpassword.classList.remove("is-invalid");

            if (username.value.trim().length < 3) {
                username.classList.add("is-invalid");
                event.preventDefault(); 
            }

            var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if (!emailRegex.test(email.value.trim())) {
                email.classList.add("is-invalid");
                event.preventDefault(); 
            }

            if (password.value.trim().length < 8) {
                password.classList.add("is-invalid");
                event.preventDefault();
            }

            if (cpassword.value.trim() !== password.value.trim()) {
                cpassword.classList.add("is-invalid");
                event.preventDefault(); 
            }
        });
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
				<li><a href="Consultoria.php">CONSULTORÍA</a></li>
				<li><a href="login.php">INICIO DE SESIÓN</a></li>
			</ul>
		</nav>

		<?php if (!empty($error)) { ?>
	        <div class="alert alert-danger"><?php echo $error; ?></div>
	    <?php } ?>
	    <?php if (!empty($correct)) { ?>
		    <div class="alert alert-success"><?php echo $correct; ?></div>
		<?php } ?>



	<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-4">
            <form id="registrationForm" method="POST">
                <div class="login color">Regístrate</div>
                <div class="form-group mb-3">
                    <label class="color" for="username">Usuario</label>
                    <input type="text" class="form-control input" id="username2" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                    <div class="invalid-feedback">
                        El usuario debe tener al menos 3 caracteres.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="color" for="email">Email</label>
                    <input type="email" class="form-control input" id="email2" name="email" aria-describedby="emailHelp" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                    <div class="invalid-feedback">
                        Email no válido.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="color" for="password">Contraseña</label>
                    <input type="password" class="form-control input" id="password2" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
                    <div class="invalid-feedback">
                        La contraseña debe tener al menos 8 caracteres.
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="color" for="cpassword">Confirmar Contraseña</label>
                    <input type="password" class="form-control input" id="cpassword2" name="cpassword" value="<?php echo isset($_POST['cpassword']) ? $_POST['cpassword'] : ''; ?>">
                    <div class="invalid-feedback">
                        Las contraseñas no coinciden.
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="submit">Registrarme</button>
                </div>

                <div class="color align">¿Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a></div>
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
