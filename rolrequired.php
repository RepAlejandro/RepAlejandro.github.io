<?php
if ($result->num_rows == 0) {
    header("Location: login.php");
    exit();
} else {
    $row = $result->fetch_assoc();
    if (isset($row['Id_Rol'])) {
        $rol = $row['Id_Rol'];
    } else {
        $rol = 0; 
    }
}
?>
