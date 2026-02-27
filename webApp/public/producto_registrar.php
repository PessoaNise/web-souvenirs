<?php

include '../resources/db/ProductoDB.php';
include '../resources/db/ImagenDB.php';
include '../resources/lib/sanitizacion.php';

$nombreProducto = $precioCompra = $precioVenta = $descripcion = $imagen = $categoriaSel = $existencia = "";
$errores = [];

if (isset($_POST['registar'])) {

    if (empty($_POST['nombreProducto'])) {
        $errores['nombreProducto'] = "se requiere el nombre del producto";
    } else {
        $nombreProducto = sanitizacion($_POST["nombreProducto"]);
    }

    if (empty($_POST['categoria']))
        $errores['categoria'] = "se requiere una categoria";
    else
        $categoriaSel = $_POST["categoria"];

    if (empty($_POST['precioCompra'])) {
        $errores['precioCompra'] = "Se requiere el precio de compra";
    } else {
        $precioCompra = sanitizacion($_POST['precioCompra']);
        if (!filter_var($precioCompra, FILTER_VALIDATE_FLOAT))
            $errores['precioCompra'] = "No es un formato de dato correcto";
    }

    if (empty($_POST['precioVenta'])) {
        $errores['precioVenta'] = "Se requiere el precio de venta";
    } else {
        $precioVenta = sanitizacion($_POST['precioVenta']);
        if (!filter_var($precioVenta, FILTER_VALIDATE_FLOAT))
            $errores['precioVenta'] = "No es un formato de dato correcto";
    }

    if (empty($_POST['descripcion'])) {
        $errores['descripcion'] = "Se requiere una descripción";
    } else {
        $descripcion = $_POST['descripcion'];
    }

    if (empty($_POST['existencia'])) {
        $errores['existencia'] = "Indica cuantas unidades son";
    } else {
        $existencia = sanitizacion($_POST['existencia']);
        if (!filter_var($existencia, FILTER_VALIDATE_INT))
            $errores['existencia'] = "No es un formato de dato correcto";
    }

    if (count($errores) == 0) {
        if (isset($_POST['checkActivo']))
            $activo = 1;
        else
            $activo = 0;
        $_POST['checkActivo'] = $activo;

        $errorInsertarImagen = ImagenDB::insertaImagen($_FILES);
        if (!isset($errorInsertarImagen)) {
            $idImagen = ImagenDB::getMaxId();
            $resultadoRegistrarProducto = ProductoDB::insertaProducto($_POST, $idImagen);
            $nombreProducto = $precioCompra = $precioVenta = $descripcion = $categoriaSel = $existencia = "";
        }
    }
}

$PageTitle = "Registrar producto";

include '../resources/templates/head.html';
include '../resources/templates/header.html';

?>
    <main>
        <div class="container-sm mt-4">
            <h2>Registrar producto</h2>

            <form class="mt-4 mb-3" method="POST" novalidate action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data">

                <div class="container">
                    <div class="row row-cols-2">
                        <div class="column col-6">
                            <div class="my-3">
                                <label for="nombreProducto" class="form-label">Nombre producto</label>
                                <input type="text" class="form-control" name="nombreProducto" value="<?= $nombreProducto ?>">
                                <span class="text-danger"><?php if (isset($errores['nombreProducto'])) print($errores['nombreProducto']) ?></span>
                            </div>

                            <div class="my-3">
                                <label class="form-label" for="categoria">Categoria:</label>
                                <select class="form-select" id="categoria" name="categoria">
                                    <option value="" <?php if (!isset($categoria)) print('selected') ?>>selecciona</option>
                                    <?php
                                    include '../resources/db/CategoriaDB.php';
                                    $categorias = CategoriaDB::getCategorias();
                                    foreach ($categorias as $categoria): ?>
                                        <option value=<?= $categoria['id'] ?> <?php if ($categoria['id'] == $categoriaSel) print('selected') ?>> <?= $categoria['categoria'] ?></option>";
                                    <?php endforeach ?>
                                </select>
                                <span class="text-danger"><?php if (isset($errores['categoria'])) print($errores['categoria']) ?></span>
                            </div>

                            <div class="my-3">
                                <label for="precioCompra" class="form-label">Precio compra</label>
                                <input type="text" class="form-control" name="precioCompra" value="<?= $precioCompra ?>">
                                <span class="text-danger"><?php if (isset($errores['precioCompra'])) print($errores['precioCompra']) ?></span>
                            </div>

                            <div class="my-3">
                                <label for="precioVenta" class="form-label">Precio venta</label>
                                <input type="text" class="form-control" name="precioVenta" value="<?= $precioVenta ?>">
                                <span class="text-danger"><?php if (isset($errores['precioVenta'])) print($errores['precioVenta']) ?></span>
                            </div>
                        </div>

                        <div class="column col-6">
                            <div class="my-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea id="descripcion" class="form-control" rows="5" name="descripcion"><?php if(isset($descripcion)) print($descripcion) ?></textarea>
                                <span class="text-danger"><?php if (isset($errores['descripcion'])) print($errores['descripcion']) ?></span>
                            </div>

                            <div class="my-3">
                                <label class="form-label" for="imagen">Elije una imagen:</label>
                                <input class="form-control" type="file" name="imagen">
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group my-3">
                                        <label for="existencia" class="form-label">Existencia</label>
                                        <input type="number" class="form-control mx-3" name="existencia" value="<?= $existencia ?>">
                                        <span class="text-danger"><?php if (isset($errores['existencia'])) print($errores['existencia']) ?></span>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="my-4 form-check">
                                        <input type="checkbox" class="form-check-input" id="checkActivo" name="checkActivo" checked>
                                        <label class="form-check-label" for="checkActivo">Activo</label>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="d-grid justify-content-end">
                        <button type="submit" name="registar" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

<?php if (isset($errorInsertarImagen)): ?>
    <script>
        Swal.fire({
            title: "<?=$errorInsertarImagen ?>",
            icon: "error",
            timer: 1000
        });
    </script>
<?php endif ?>

<?php if (isset($resultadoRegistrarProducto)): ?>
    <script>
        Swal.fire({
            title: "Producto registrado exitosamente",
            icon: "success",
            timer: 1000
        });
    </script>
<?php endif ?>

<?php
include '../resources/templates/footer.html';
include '../resources/templates/scripts.html';
include '../resources/templates/fin.html';
