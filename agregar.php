<?php

require_once __DIR__ . "/config/conexion.php";

$nombreSitio = "Agregar producto | TecnoStore";
$descripcion = "Formulario para registrar productos";

$errores = [];
$nombre = "";
$descripcionProducto = "";
$categoria = "";
$precio = "";
$estado = "Disponible";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"] ?? "");
    $descripcionProducto = trim($_POST["descripcion"] ?? "");
    $categoria = trim($_POST["categoria"] ?? "");
    $precio = trim($_POST["precio"] ?? "");
    $estado = trim($_POST["estado"] ?? "Disponible");

    if ($nombre === "") {
        $errores[] = "El nombre del producto es obligatorio.";
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
            $sql = "INSERT INTO productos
                    (
                        nombre,
                        descripcion,
                        categoria,
                        precio,
                        estado
                    )
                    VALUES
                    (
                        :nombre,
                        :descripcion,
                        :categoria,
                        :precio,
                        :estado
                    )";

            $consulta = $conexion->prepare($sql);

            $guardado = $consulta->execute([
                ":nombre" => $nombre,
                ":descripcion" => $descripcionProducto,
                ":categoria" => $categoria,
                ":precio" => (float) $precio,
                ":estado" => $estado
            ]);

            if ($guardado) {
                header(
                    "Location: /tecnostore-php/index.php?mensaje=agregado"
                );
                exit;
            }

            $errores[] = "No se pudo guardar el producto.";

        } catch (PDOException $error) {
            $errores[] = "Error al guardar: "
                . $error->getMessage();
        }
    }
}

include __DIR__ . "/includes/header.php";
?>

<main class="pagina-formulario">
    <div class="contenedor-formulario">

        <div class="encabezado-formulario">
            <p class="etiqueta">Administración del catálogo</p>
            <h1>Agregar nuevo producto</h1>

            <p class="introduccion-formulario">
                Completa la siguiente información para registrar
                un producto en el catálogo de TecnoStore.
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
            action="/tecnostore-php/agregar.php"
            method="POST"
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
                    placeholder="Ejemplo: Parlante Bluetooth"
                    value="<?php echo htmlspecialchars($nombre); ?>"
                    required
                >

                <small class="ayuda-campo">
                    Escribe un nombre corto y fácil de reconocer.
                </small>
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
                    placeholder="Describe las características principales del producto"
                    required
                ><?php echo htmlspecialchars(
                    $descripcionProducto
                ); ?></textarea>

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
                            <option value="">
                                Selecciona una categoría
                            </option>

                            <option
                                value="Audio"
                                <?php
                                echo $categoria === "Audio"
                                    ? "selected"
                                    : "";
                                ?>
                            >
                                Audio
                            </option>

                            <option
                                value="Accesorios"
                                <?php
                                echo $categoria === "Accesorios"
                                    ? "selected"
                                    : "";
                                ?>
                            >
                                Accesorios
                            </option>

                            <option
                                value="Computadores"
                                <?php
                                echo $categoria === "Computadores"
                                    ? "selected"
                                    : "";
                                ?>
                            >
                                Computadores
                            </option>

                            <option
                                value="Almacenamiento"
                                <?php
                                echo $categoria === "Almacenamiento"
                                    ? "selected"
                                    : "";
                                ?>
                            >
                                Almacenamiento
                            </option>

                            <option
                                value="Celulares"
                                <?php
                                echo $categoria === "Celulares"
                                    ? "selected"
                                    : "";
                                ?>
                            >
                                Celulares
                            </option>

                            <option
                                value="Hogar inteligente"
                                <?php
                                echo $categoria === "Hogar inteligente"
                                    ? "selected"
                                    : "";
                                ?>
                            >
                                Hogar inteligente
                            </option>
                        </select>
                    </div>
                </div>

                <div class="grupo-formulario">
                    <label for="estado">
                        Estado
                        <span class="campo-obligatorio">*</span>
                    </label>

                    <div class="contenedor-select">
                        <select id="estado" name="estado" required>
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
                    placeholder="Ejemplo: 85000"
                    value="<?php echo htmlspecialchars($precio); ?>"
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
                    Guardar producto
                </button>
            </div>
        </form>
    </div>
</main>

<?php include __DIR__ . "/includes/footer.php"; ?>
    <div class="contenedor contenedor-formulario">
        <p class="etiqueta">Administración del catálogo</p>
        <h1>Agregar producto</h1>

        <p class="introduccion-formulario">
            Completa los campos para registrar un nuevo producto
            en la base de datos de TecnoStore.
        </p>

        <?php if (!empty($errores)): ?>
            <div class="mensaje-error" role="alert">
                <strong>Revisa la información:</strong>

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
            action="agregar.php"
            method="POST"
        >
            <div class="grupo-formulario">
                <label for="nombre">Nombre del producto</label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    maxlength="100"
                    value="<?php echo htmlspecialchars($nombre); ?>"
                    required
                >
            </div>

            <div class="grupo-formulario">
                <label for="descripcion">Descripción</label>

                <textarea
                    id="descripcion"
                    name="descripcion"
                    maxlength="255"
                    rows="5"
                    required
                ><?php echo htmlspecialchars(
                    $descripcionProducto
                ); ?></textarea>
            </div>

            <div class="grupo-formulario">
                <label for="categoria">Categoría</label>

                <select id="categoria" name="categoria" required>
                    <option value="">Selecciona una categoría</option>

                    <option
                        value="Audio"
                        <?php
                        echo $categoria === "Audio"
                            ? "selected"
                            : "";
                        ?>
                    >
                        Audio
                    </option>

                    <option
                        value="Accesorios"
                        <?php
                        echo $categoria === "Accesorios"
                            ? "selected"
                            : "";
                        ?>
                    >
                        Accesorios
                    </option>

                    <option
                        value="Computadores"
                        <?php
                        echo $categoria === "Computadores"
                            ? "selected"
                            : "";
                        ?>
                    >
                        Computadores
                    </option>

                    <option
                        value="Almacenamiento"
                        <?php
                        echo $categoria === "Almacenamiento"
                            ? "selected"
                            : "";
                        ?>
                    >
                        Almacenamiento
                    </option>
                </select>
            </div>

            <div class="grupo-formulario">
                <label for="precio">Precio en pesos colombianos</label>

                <input
                    type="number"
                    id="precio"
                    name="precio"
                    min="1"
                    step="1"
                    value="<?php echo htmlspecialchars($precio); ?>"
                    required
                >
            </div>

            <div class="grupo-formulario">
                <label for="estado">Estado</label>

                <select id="estado" name="estado" required>
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

            <div class="acciones-formulario">
                <button class="boton" type="submit">
                    Guardar producto
                </button>

                <a class="boton-cancelar" href="index.php">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</main>

<?php include __DIR__ . "/includes/footer.php"; ?>