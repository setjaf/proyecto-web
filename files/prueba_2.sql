create database escompartiendo;

use escompartiendo;

create table rol(

    id int unsigned not null auto_increment primary key,
    descripcion char(100) not null

);


create table permiso(

    id int unsigned not null auto_increment primary key,
    descripcion char(100) not null

);

create table rol_permiso(

    rol int unsigned not null,
    permiso int unsigned not null,
    foreign key(rol) references rol(id),
    foreign key(permiso) references permiso(id)

);

create table usuario(

    id int unsigned primary key auto_increment,
    correo char(100) not null unique,
    contrasena char(100) not null,
    fecha_alta date not null,
    nombre char(100) not null,
    paterno char(50) not null,
    materno char(50),
    fecha_nacimiento date not null,
    boleta char(10) unique,
    CURP char(18) unique,
    status bit not null,
    rol int unsigned not null,
    foto char(200),
    foreign key(rol) references rol(id)
    
);

create table unidad_aprendizaje(

    id int unsigned primary key auto_increment,
    nombre char(100) not null,
    descripcion char(150) not null,
    nivel int unsigned not null

);

create table grupo(

    id int unsigned primary key auto_increment,
    nombre char(150) not null,
    usuario_encargado int unsigned not null,
    ua int unsigned not null,
    foreign key(usuario_encargado) references usuario(id),
    foreign key(ua) references unidad_aprendizaje(id)

);

create table grupo_usuario(

    id int unsigned primary key auto_increment,
    usuario int unsigned,
    grupo int unsigned,
    foreign key(usuario) references usuario(id),
    foreign key(grupo)  references grupo(id)

);

create table ua_profesor(

    usuario int unsigned not null,
    ua int unsigned not null,
    foreign key(ua) references unidad_aprendizaje(id),
    foreign key(usuario) references usuario(id)

);

create table archivo(

    id int unsigned not null primary key auto_increment,
    nombre char(100) not null,
    descripcion text,
    fecha_carga date not null,
    url char(150) not null,
    status bit not null,
    usuario int unsigned not null,
    unidad_aprendizaje int unsigned not null,
    nivel enum('Básico','Medio','Avanzado') not null,
    foreign key(usuario) references usuario(id),
    foreign key(unidad_aprendizaje) references unidad_aprendizaje(id)

);

create table visita_archivo(

    id int unsigned not null primary key auto_increment,
    fecha_visita date not null,
    archivo int unsigned not null,
    usuario int unsigned not null,
    foreign key(archivo) references archivo(id),
    foreign key(usuario) references usuario(id)

);

create table comentario(

    id int unsigned not null primary key auto_increment,
    fecha_comentario date not null,
    usuario int unsigned not null,
    archivo int unsigned not null,
    foreign key(usuario) references usuario(id),
    foreign key(archivo) references archivo(id)

);

create table solicitud_borrar_archivo(

    id int unsigned not null primary key auto_increment,
    fecha_solicitud date not null,
    usuario_solicita int unsigned not null,
    archivo int unsigned not null,
    usuario_atiende int unsigned not null,
    foreign key(usuario_solicita) references usuario(id),
    foreign key(archivo) references archivo(id),
    foreign key(usuario_atiende) references usuario(id)

);

create table trabajo(

    id int unsigned not null primary key auto_increment,
    descripcion text not null,
    fecha_creacion date not null,
    fecha_termino date not null,
    path_archivo char(150),
    usuario int unsigned not null,
    archivo int unsigned not null,
    grupo int unsigned not null,
    foreign key(usuario) references usuario(id),
    foreign key(archivo) references archivo(id),
    foreign key(grupo) references grupo(id)

);


create table trabajo_enviado(
    id int unsigned not null primary key auto_increment,
    fecha_subida date not null,
    path_archivo char(150),
    usuario int unsigned not null,
    trabajo int unsigned not null,
    foreign key(usuario) references usuario(id),
    foreign key(trabajo) references trabajo(id)
);


INSERT INTO `permiso` VALUES (1,'subir_archivo'),(2,'borrar_archivo_cualquiera'),(3,'borrar_archivo'),(4,'editar_archivo'),(5,'editar_archivo_cualquiera'),(6,'crear_prueba'),(7,'borrar_prueba'),(8,'modificar_prueba'),(9,'borrar_prueba_cualquiera'),(10,'modificar_prueba_cualquiera'),(11,'calificar_prueba'),(12,'realizar_prueba'),(13,'borrar_comentario');
INSERT INTO `rol` VALUES (1,'administrador'),(2,'profesor'),(3,'alumno');
INSERT INTO `rol_permiso` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,13),(2,1),(2,3),(2,4),(2,6),(2,7),(2,8),(2,11),(3,12);