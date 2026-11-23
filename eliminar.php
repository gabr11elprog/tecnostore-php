<?php

require_once __DIR__ . "/config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header(
        "Location: /tecnostore-php/index.php?mensaje=metodo_invalido"
    );
    exit;
}

$id = filter_input(
    INPUT_POST,
    "id",
    FILTER_VALIDATE_INT
);

if (!$id) {
    header(
        "Location: /tecnostore-php/index.php?mensaje=id_invalido"
    );
    exit;
}

$consulta = $conexion->prepare(
    "SELECT id FROM productos WHERE id = :id"
);

$consulta->execute([
    ":id" => $id
]);

$producto = $consulta->fetch();

if (!$producto) {
    header(
        "Location: /tecnostore-php/index.php?mensaje=no_encontrado"
    );
    exit;
}

try {
    $eliminar = $conexion->prepare(
        "DELETE FROM productos WHERE id = :id"
    );

    $eliminar->execute([
        ":id" => $id
    ]);

    header(
        "Location: /tecnostore-php/index.php?mensaje=eliminado"
    );
    exit;

} catch (PDOException $error) {
    header(
        "Location: /tecnostore-php/index.php?mensaje=error_eliminar"
    );
    exit;
}