# TecnoStore PHP

TecnoStore es una aplicación web desarrollada con PHP y MySQL para administrar un catálogo de productos tecnológicos.

## Funcionalidades

- Consultar productos registrados.
- Agregar nuevos productos.
- Editar productos existentes.
- Eliminar productos con confirmación.
- Validar los campos de los formularios.
- Mostrar una interfaz adaptable a diferentes pantallas.

## Tecnologías utilizadas

- PHP
- MySQL
- HTML5
- CSS3
- PDO
- XAMPP
- phpMyAdmin
- Visual Studio Code

## Estructura del proyecto

- `assets/css`: estilos visuales.
- `assets/img`: imágenes del sitio.
- `config`: conexión con MySQL.
- `includes`: componentes reutilizables.
- `index.php`: catálogo principal.
- `agregar.php`: registro de productos.
- `editar.php`: actualización de productos.
- `eliminar.php`: eliminación de productos.
- `tecnostore_db.sql`: estructura y datos de la base.

## Instalación local

1. Instalar XAMPP.
2. Copiar la carpeta `tecnostore-php` dentro de `htdocs`.
3. Iniciar Apache y MySQL.
4. Abrir phpMyAdmin.
5. Crear o importar la base de datos `tecnostore_db`.
6. Importar el archivo `tecnostore_db.sql`.
7. Abrir la aplicación desde:

http://localhost/tecnostore-php/

## Base de datos

La aplicación utiliza la base de datos `tecnostore_db` y la tabla `productos`.

Los campos principales son:

- id
- nombre
- descripcion
- categoria
- precio
- estado
- fecha_creacion

## Autor

Luis Gabriel Rodríguez Monsalvo

## Actividad académica

Proyecto desarrollado como evidencia de la elaboración de componentes frontend y construcción de una aplicación web con PHP y MySQL.