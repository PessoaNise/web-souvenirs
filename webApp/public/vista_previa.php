<?php

session_start();
if (isset($_SESSION['usuario'])) {

    $PageTitle = "Vista previa";

    include '../resources/templates/head.html';
    include '../resources/templates/header.html';
    include '../resources/templates/cliente_navegacion.html';
    include_once '../resources/db/ProductoDB.php';

    $producto = ProductoDB::getProductoPorId($_GET['id']);
    ?>
    <main>
        <div class="container">
            <h1 class="my-5 text-center text-primary"><?= $producto['nombre'] ?></h1>
            <div class="card m-5 border-0" style="max-width: 1540px;">
                <div class="row g-0 align-items-center">
                    <div class="col-md-4 ">
                        <img src="../resources/uploads/<?= $producto['imagen'] ?>" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8 p-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-5"><?= $producto['nombre'] ?></h5>
                            <p class="card-text">Descripción:</p>
                            <p class="card-text"><?= $producto['descripcion'] ?></p>
                            <p class="card-text">Existencia: <?= $producto['existencia'] ?> unidades</p>
                            <p class="card-text">Precio: $<?= $producto['precio_venta'] ?></p>
                            <p class="card-text"><small class="text-body-secondary">En venta desde: <?= $producto['creado'] ?></small></p>
                            <div class="row justify-content-end">
                                <div class="col"></div>
                                <div class="col">
                                    <a href="../resources/lib/cartAction.php?action=addToCart&id=<?= $producto["id"]; ?>" class="btn btn-primary">Agregar al carrito</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    include '../resources/templates/footer.html';
    include '../resources/templates/scripts.html';
    include '../resources/templates/fin.html';

} else {
    header("Location:login_error.php");
    exit();
}
