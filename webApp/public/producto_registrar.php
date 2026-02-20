<?php

$PageTitle = "Registrar pedido";

include '../resources/templates/head.html';
include '../resources/templates/header.html';
?>

    <main>
        <div class="container-sm mt-4">
            <h2>Registrar producto</h2>

            <?php
            include '../resources/db/CategoriaDB.php';
            $categorias = CategoriaDB::getCategorias();
            print_r($categorias);
            ?>

        </div>
    </main>

<?php
include '../resources/templates/footer.html';
include '../resources/templates/scripts.html';
include '../resources/templates/fin.html';
