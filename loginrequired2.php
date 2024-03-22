<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["token"])) {
    // Opcional: Si no ha iniciado sesión, puedes establecer el rol como 0 o cualquier otro valor predeterminado
    $rol = 0;
} else {
    require_once "conexion_db.php"; 

    $token = $_SESSION["token"];

    $stmt = $conexion->prepare("SELECT * FROM usuario WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $rol = 0;
    } else {
        $row = $result->fetch_assoc();
        if (isset($row['Id_Rol'])) {
            $rol = $row['Id_Rol'];
        } else {
            $rol = 0; 
        }
    }
}
?>
