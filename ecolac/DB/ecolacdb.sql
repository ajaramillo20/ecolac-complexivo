/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Diego Jaramillo
 * Created: 26/06/2020
 */

CREATE TABLE Ciudad (
    ciu_id     INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ciu_nombre varchar (40) NULL    
)ENGINE= InnoDB;

CREATE TABLE Direccion (
    dir_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    dir_direccion varchar (200) NULL,
    dir_latitud   varchar (100) NULL,
    dir_longitud  varchar (100) NULL,
    ciu_id        INT        NULL,    
    CONSTRAINT FK_Direccion_ToTable_Ciudad FOREIGN KEY (ciu_id) REFERENCES Ciudad (ciu_id)
)ENGINE= InnoDB;

CREATE TABLE Sucursal (
    suc_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    suc_nombre VARCHAR (200) NULL,
    dir_id     INT           NULL,    
    CONSTRAINT FK_Sucursal_ToTable_Direccion FOREIGN KEY (dir_id) REFERENCES Direccion (dir_id)
)ENGINE= InnoDB;


CREATE TABLE Rol (
    rol_id    INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    rol_nombre VARCHAR (20) NULL    
)ENGINE= InnoDB;

CREATE TABLE PantallaRol(
    pnt_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pnt_nombre VARCHAR (50) NOT NULL,
    pnt_vinculo VARCHAR (50) NULL,
    pnt_menu  BOOLEAN NULL,
    rol_id INT NOT NULL,
    CONSTRAINT FK_Pantalla_ToTable_Rol FOREIGN KEY (rol_id) REFERENCES Rol (rol_id)
)ENGINE= InnoDB;


CREATE TABLE UsuarioDireccion (
    usd_id      INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    usr_id      INT NOT NULL,
    dir_id      INT NOT NULL,        
    CONSTRAINT FK_UsuarioDireccion_ToTable_Usuario FOREIGN KEY (usr_id) REFERENCES Usuario (usr_id),
    CONSTRAINT FK_UsuarioDireccion_ToTable_Direccion FOREIGN KEY (dir_id) REFERENCES Direccion (dir_id)
)ENGINE= InnoDB;

CREATE TABLE Usuario (
    usr_id      INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    usr_nombre  VARCHAR (100) NULL,
    usr_cedula  VARCHAR (12) NULL,
    usr_correo  VARCHAR (100) NULL,
    usr_usuario VARCHAR (20) NULL,
    usr_telefono VARCHAR(15) NULL,
    usr_contrasena VARCHAR (100) NULL,    
    suc_id      INT        NULL,
    rol_id      INT        NULL,
    CONSTRAINT FK_Usuario_ToTable_Sucursal FOREIGN KEY (suc_id) REFERENCES Sucursal (suc_id)
CONSTRAINT FK_Usuario_ToTable_rol FOREIGN KEY (rol_id) REFERENCES Rol (rol_id),
)ENGINE= InnoDB;

CREATE TABLE UsuarioRol (
    rus_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    rol_id INT NULL,
    usr_id INT NULL,    
    CONSTRAINT FK_UsuarioRol_To_rol FOREIGN KEY (rol_id) REFERENCES Rol(rol_id),
    CONSTRAINT FK_UsuarioRol_To_usuario FOREIGN KEY (usr_id) REFERENCES Usuario (usr_id)
)ENGINE= InnoDB;


CREATE TABLE tipo (
    tip_id     INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    tip_nombre varchar (50) NULL
)ENGINE=InnoDB;

CREATE TABLE Categoria (
    cat_id     INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    cat_nombre VARCHAR (100) NULL,
    tip_id     INT        NULL,    
    CONSTRAINT FK_Categoria_ToTableTipo FOREIGN KEY (tip_id) REFERENCES tipo (tip_id)
)ENGINE=InnoDB;

CREATE TABLE Presentacion (
    pre_id     INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pre_nombre VARCHAR (50) NULL   
)ENGINE=InnoDB;

CREATE TABLE Recursos
(
	rec_id INT NOT NULL PRIMARY KEY auto_increment, 
    rec_nombre VARCHAR(200) NULL, 
    rec_descripcion VARCHAR(500) NULL,
    rec_ruta varchar(500) NULL,
    rec_tipo varchar(50) NULL
)ENGINE=InnoDB;

CREATE TABLE Producto (
    pro_id        INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pro_nombre    varchar (20) NULL,
    tip_id        INT        NULL,
    car_id        INT NULL,
    pro_valor     FLOAT (100,2) NULL,
    pro_cantStock INT NULL,
    pre_id        INT        NULL,
    suc_id        INT        NOT NULL,
    rec_id		  INT NULL,
    CONSTRAINT FK_Producto_ToTable_Sucursal FOREIGN KEY (suc_id) REFERENCES Sucursal (suc_id),
    CONSTRAINT FK_Producto_ToTablePresentacion FOREIGN KEY (pre_id) REFERENCES Presentacion (pre_id),
    CONSTRAINT FK_Producto_ToTableTipo FOREIGN KEY (tip_id) REFERENCES tipo (tip_id),
    CONSTRAINT FK_Producto_ToTableRecursos FOREIGN KEY (rec_id) REFERENCES Recursos (rec_id),
    CONSTRAINT FK_Producto_ToTable_Categoria FOREIGN KEY (cat_id) REFERENCES Categoria (cat_id),
)ENGINE= InnoDB;

CREATE TABLE StatusPedido (
    pes_id     INT  NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pes_nombre NCHAR (10) NULL    
)ENGINE = InnoDB;

CREATE TABLE Pedido (
    ped_id     INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    usr_id     INT NOT NULL,
    dir_id     INT NOT NULL,
    pes_id     INT NOT NULL,
    usr_ven_id INT NULL,
    usr_rep_id INT NULL,
    ped_fecha DATETIME NULL,    
    ped_costo FLOAT(100,2) NOT NULL,
    CONSTRAINT FK_Pedido_ToTable_StatusPedido FOREIGN KEY (pes_id) REFERENCES StatusPedido (pes_id),
    CONSTRAINT FK_Pedido_ToTable_Usuario FOREIGN KEY (usr_id) REFERENCES Usuario (usr_id),
    CONSTRAINT FK_Pedido_ToTable_Usuario_Repartidor FOREIGN KEY (usr_rep_id) REFERENCES Usuario (usr_id),
    CONSTRAINT FK_Pedido_ToTable_Usuario_Vendedor FOREIGN KEY (usr_ven_id) REFERENCES Usuario (usr_id)
)ENGINE = InnoDB;


CREATE TABLE ProductoPedido (
    prp_id       INT        NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pro_id       INT        NULL,
    prp_cantidad int 		NULL,
    ped_id       INT        NULL,
	CONSTRAINT FK_prodPedido_ToTable_Pedido FOREIGN KEY (ped_id) REFERENCES Pedido (ped_id),
    CONSTRAINT FK_prodPedido_ToTable_Producto FOREIGN KEY (pro_id) REFERENCES Producto (pro_id)
)ENGINE = InnoDB;


