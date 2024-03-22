CREATE TABLE roles (
    Id_Rol INT NOT NULL AUTO_INCREMENT,
    name TEXT,
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (Id_Rol)
);

CREATE TABLE usuario (
    Id INT NOT NULL AUTO_INCREMENT,
    username TEXT NOT NULL,
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Id_Rol INT,
    token VARCHAR(64) DEFAULT NULL,
    PRIMARY KEY (Id),
    FOREIGN KEY (Id_Rol) REFERENCES roles (Id_Rol) ON DELETE SET NULL

);

--Para tener permisos de Administrador realizar un Update a la tabla usuario para actualizar: admin = 2

--Update usuario SET Id_Rol = ? WHERE Id = ?

--El usuario Admin puede ver en el nav la configuración, aunque la configuracion no hace nada y te reedirige al panel
