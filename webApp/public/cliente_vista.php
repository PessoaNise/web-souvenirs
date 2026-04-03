<?php

session_start();
if (isset($_SESSION['usuario'])) {

    $PageTitle = "Cliente";

    include '../resources/templates/head.html';
    include '../resources/templates/header.html';
    include '../resources/templates/cliente_navegacion.html';
    ?>

    <main>
        <div class="container-md my-5">
            <h2 class="text-center my-5">Productos populares</h2>
            <div class="row my-4 justify-content-center">

                <?php
                include_once '../resources/db/ProductoDB.php';
                $productosAleatorios = ProductoDB::getProductosAleatorios(5);

                foreach ($productosAleatorios as $producto) :?>
                    <div class="card m-2" style="width: 15rem;">
                        <a href="vista_previa.php?id=<?= $producto['id'] ?>">
                            <img src="../resources/uploads/<?= $producto['imagen'] ?>" class="card-img-top mt-3" alt="...">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                            <p class="card-text "><?= substr($producto['descripcion'], 0, 150) . '...' ?></p>
                            <p class="card-text ">$<?= $producto['precio_venta'] ?></p>
                            <a href="vista_previa.php?id=<?= $producto['id'] ?>" class="btn btn-primary">Ver mas</a>
                        </div>
                    </div>
                <?php endforeach; ?>
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
