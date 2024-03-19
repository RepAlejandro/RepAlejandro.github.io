<?php
// Inicia la sesión
session_start();

// Destruye la sesión
session_destroy();

header("Location: login.php");
exit();
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=2">
	<title></title>
</head>
<body>
	<h1> Hola</h1>

</body>
</html>