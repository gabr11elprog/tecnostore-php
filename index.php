<?php

require_once __DIR__ . "/config/conexion.php";

$nombreSitio = "TecnoStore";
$descripcion = "Tienda virtual de productos tecnológicos";

$sql = "SELECT * FROM productos ORDER BY id DESC";
$consulta = $conexion->query($sql);
$productos = $consulta->fetchAll();

include __DIR__ . "/includes/header.php";
?>

<main>
    <section class="hero">
        <div class="contenedor contenido-hero">
            <div>
                <p class="etiqueta">Tecnología a tu alcance</p>

                <h1>Encuentra el producto ideal para ti</h1>

                <p class="texto-hero">
                    En TecnoStore ofrecemos productos tecnológicos
                    para estudiar, trabajar y disfrutar.
                </p>

                <a class="boton" href="#productos">
                    Ver productos
                </a>
            </div>

            <div class="imagen-hero" aria-hidden="true">
                💻
            </div>
        </div>
    </section>

    <section class="seccion productos" id="productos">
        <div class="contenedor">
            <p class="etiqueta">Nuestro catálogo</p>
            <h2>Productos destacados</h2>

            <div class="cuadricula-productos">

                 <?php foreach ($productos as $producto): ?>

                     <article class="tarjeta-producto">
    <div class="icono-producto" aria-hidden="true">
        <?php
        $iconos = [
            "Audio" => "🎧",
            "Accesorios" => "⌨️",
            "Computadores" => "💻",
            "Almacenamiento" => "💾",
            "Celulares" => "📱",
            "Hogar inteligente" => "🏠"
        ];

        echo $iconos[$producto["categoria"]] ?? "📦";
        ?>
    </div>

    <h3>
        <?php echo htmlspecialchars($producto["nombre"]); ?>
    </h3>

    <p>
        <?php echo htmlspecialchars($producto["descripcion"]); ?>
    </p>

    <p class="informacion-producto">
        <strong>Categoría:</strong>
        <?php echo htmlspecialchars($producto["categoria"]); ?>
    </p>

    <p class="informacion-producto">
        <strong>Estado:</strong>
        <?php echo htmlspecialchars($producto["estado"]); ?>
    </p>

    <p class="precio">
        $<?php
        echo number_format(
            (float) $producto["precio"],
            0,
            ",",
            "."
        );
        ?>
    </p>

   <div class="acciones-producto">
    <a
        class="boton-editar"
        href="/tecnostore-php/editar.php?id=<?php
            echo (int) $producto["id"];
        ?>"
    >
        ✏ Editar
    </a>

    <form
        class="formulario-eliminar"
        action="/tecnostore-php/eliminar.php"
        method="POST"
        onsubmit="return confirm(
            '¿Estás seguro de eliminar este producto? Esta acción no se puede deshacer.'
        );"
    >
        <input
            type="hidden"
            name="id"
            value="<?php echo (int) $producto["id"]; ?>"
        >

        <button
            class="boton-eliminar"
            type="submit"
        >
            🗑 Eliminar
        </button>
    </form>
</div>
</article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="seccion nosotros" id="nosotros">
        <div class="contenedor">
            <p class="etiqueta">LO MEJOR EN TECNOLOGIA
            <h2>¿Qué es TecnoStore?</h2>

            <p>
                TecnoStore es un sitio web donde podemos adquirir, cotizar 
                prodcutos tecnologicos tiene una alta gama de catálogo de 
                productos tecnológicos. tenemos domicilis todo el pais
                escribenos al whatsapp 3226579542.
                "LAS BUENAS COSAS DE LA VIDA TOMAN TIEMPO"
            </p>
        </div>
    </section>
</main>
<?php
$mensaje = $_GET["mensaje"] ?? "";
?>

<?php if ($mensaje === "agregado"): ?>
    <div class="contenedor">
        <div class="mensaje-exito" role="status">
            Producto registrado correctamente.
        </div>
    </div>
<?php elseif ($mensaje === "editado"): ?>
    <div class="contenedor">
        <div class="mensaje-exito" role="status">
            Producto actualizado correctamente.
        </div>
    </div>
<?php elseif ($mensaje === "eliminado"): ?>
    <div class="contenedor">
        <div class="mensaje-exito" role="status">
            Producto eliminado correctamente.
        </div>
    </div>
<?php elseif ($mensaje === "error_eliminar"): ?>
    <div class="contenedor">
        <div class="mensaje-error mensaje-superior" role="alert">
            No fue posible eliminar el producto.
        </div>
    </div>
<?php elseif ($mensaje === "no_encontrado"): ?>
    <div class="contenedor">
        <div class="mensaje-error mensaje-superior" role="alert">
            El producto solicitado no existe.
        </div>
    </div>
<?php endif; ?>

<?php include "includes/footer.php"; ?>O"                