<?php

require_once __DIR__ . "/config/conexion.php";

$nombreSitio = "Editar producto | TecnoStore";
$descripcion = "Formulario para modificar productos";

$errores = [];

$id = filter_input(
    INPUT_GET,
    "id",
    FILTER_VALIDATE_INT
);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = filter_input(
        INPUT_POST,
        "id",
        FILTER_VALIDATE_INT
    );
}

if (!$id) {
    header(
        "Location: /tecnostore-php/index.php?mensaje=id_invalido"
    );
    exit;
}

$consulta = $conexion->prepare(
    "SELECT * FROM productos WHERE id = :id"
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

$nombre = $producto["nombre"];
$descripcionProducto = $producto["descripcion"];
$categoria = $producto["categoria"];
$precio = $producto["precio"];
$estado = $producto["estado"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"] ?? "");
    $descripcionProducto = trim(
        $_POST["descripcion"] ?? ""
    );
    $categoria = trim($_POST["categoria"] ?? "");
    $precio = trim($_POST["precio"] ?? "");
    $estado = trim(
        $_POST["estado"] ?? "Disponible"
    );

    if ($nombre === "") {
        $errores[] = "El nombre es obligatorio.";
    }

    if ($descripcionProducto === "") {
        $errores[] = "La descripción es obligatoria.";
    }

    if ($categoria === "") {
        $errores[] = "Debes seleccionar una categoría.";
    }

    if (
        $precio === ""
        || !is_numeric($precio)
        || (float) $precio <= 0
    ) {
        $errores[] = "El precio debe ser mayor que cero.";
    }

    $estadosPermitidos = [
        "Disponible",
        "Agotado"
    ];

    if (!in_array($estado, $estadosPermitidos, true)) {
        $errores[] = "El estado seleccionado no es válido.";
    }

    if (empty($errores)) {
        try {
            $sql = "UPDATE productos
                    SET
                        nombre = :nombre,
                        descripcion = :descripcion,
                        categoria = :categoria,
                        precio = :precio,
                        estado = :estado
                    WHERE id = :id";

            $actualizar = $conexion->prepare($sql);

            $actualizar->execute([
                ":nombre" => $nombre,
                ":descripcion" => $descripcionProducto,
                ":categoria" => $categoria,
                ":precio" => (float) $precio,
                ":estado" => $estado,
                ":id" => $id
            ]);

            header(
                "Location: /tecnostore-php/index.php?mensaje=editado"
            );
            exit;

        } catch (PDOException $error) {
            $errores[] = "Error al actualizar: "
                . $error->getMessage();
        }
    }
}

include __DIR__ . "/includes/header.php";
?>

<main class="pagina-formulario">
    <div class="contenedor-formulario">
        <div class="encabezado-formulario">
            <p class="etiqueta">
                Administración del catálogo
            </p>

            <h1>Editar producto</h1>

            <p class="introduccion-formulario">
                Modifica los datos necesarios y guarda los cambios.
            </p>
        </div>

        <?php if (!empty($errores)): ?>
            <div class="mensaje-error" role="alert">
                <strong>Revisa los siguientes campos:</strong>

                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li>
                            <?php echo htmlspecialchars($error); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form
            class="formulario-producto"
            action="/tecnostore-php/editar.php?id=<?php
                echo (int) $id;
            ?>"
            method="POST"
        >
            <input
                type="hidden"
                name="id"
                value="<?php echo (int) $id; ?>"
            >

            <div class="grupo-formulario">
                <label for="nombre">
                    Nombre del producto
                    <span class="campo-obligatorio">*</span>
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    maxlength="100"
                    value="<?php
                        echo htmlspecialchars($nombre);
                    ?>"
                    required
                >
            </div>

            <div class="grupo-formulario">
                <label for="descripcion">
                    Descripción
                    <span class="campo-obligatorio">*</span>
                </label>

                <textarea
                    id="descripcion"
                    name="descripcion"
                    maxlength="255"
                    rows="5"
                    required
                ><?php
                    echo htmlspecialchars(
                        $descripcionProducto
                    );
                ?></textarea>

                <small class="ayuda-campo">
                    Máximo 255 caracteres.
                </small>
            </div>

            <div class="fila-formulario">
                <div class="grupo-formulario">
                    <label for="categoria">
                        Categoría
                        <span class="campo-obligatorio">*</span>
                    </label>

                    <div class="contenedor-select">
                        <select
                            id="categoria"
                            name="categoria"
                            required
                        >
                            <?php
                            $categorias = [
                                "Audio",
                                "Accesorios",
                                "Computadores",
                                "Almacenamiento",
                                "Celulares",
                                "Hogar inteligente"
                            ];
                            ?>

                            <?php foreach ($categorias as $opcion): ?>
                                <option
                                    value="<?php
                                        echo htmlspecialchars(
                                            $opcion
                                        );
                                    ?>"
                                    <?php
                                    echo $categoria === $opcion
                                        ? "selected"
                                        : "";
                                    ?>
                                >
                                    <?php
                                    echo htmlspecialchars($opcion);
                                    ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="grupo-formulario">
                    <label for="estado">
                        Estado
                        <span class="campo-obligatorio">*</span>
                    </label>

                    <div class="contenedor-select">
                        <select
                            id="estado"
                            name="estado"
                            required
                        >
                            <option
                                value="Disponible"
                                <?php
                                echo $estado === "Disponible"
                                    ? "selected"
                                    : "";
                                ?>
                            >
                                Disponible
                            </option>

                            <option
                                value="Agotado"
                                <?php
                                echo $estado === "Agotado"
                                    ? "selected"
                                    : "";
                                ?>
                            >
                                Agotado
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grupo-formulario">
                <label for="precio">
                    Precio en pesos colombianos
                    <span class="campo-obligatorio">*</span>
                </label>

                <input
                    type="number"
                    id="precio"
                    name="precio"
                    min="1"
                    step="1"
                    value="<?php
                        echo htmlspecialchars($precio);
                    ?>"
                    required
                >

                <small class="ayuda-campo">
                    Escribe el valor sin puntos ni signo de pesos.
                </small>
            </div>

            <div class="acciones-formulario">
                <a
                    class="boton-cancelar"
                    href="/tecnostore-php/index.php"
                >
                    Volver
                </a>

                <button class="boton" type="submit">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</main>

<?php include __DIR__ . "/includes/footer.php"; ?>