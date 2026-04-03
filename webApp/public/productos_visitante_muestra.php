<?php

$PageTitle = "Productos";

include '../resources/templates/head.html';
include '../resources/templates/header.html';
include '../resources/lib/getProductos.php';
include '../resources/db/ProductoDB.php';

?>
    <main>

        <div class="container">
            <div class="row my-4 justify-content-center">
                    <?php
                    getProductos($_GET['id'], $_GET['palabra'], false);
                    ?>
            </div>
        </div>
    </main>

<?php
include '../resources/templates/footer.html';
include '../resources/templates/scripts.html';
include '../resources/templates/fin.html';