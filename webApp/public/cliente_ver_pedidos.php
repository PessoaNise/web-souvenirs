<?php

session_start();
if (isset($_SESSION['usuario'])) {

    $PageTitle = "Cliente";

    include '../resources/db/PedidoDB.php';
    include '../resources/db/ItemPedidoDB.php';

    include '../resources/templates/head.html';
    include '../resources/templates/header.html';
    include '../resources/templates/cliente_navegacion.html';

    ?>

    <main>
        <div class="container-md">
            <div class="accordion" id="accordionExample">
                <?php
                $i = 1;
                $ordenes = PedidoDB::getOrdenesDeClientePorIdCliente($_SESSION['id_usuario']);
                foreach ($ordenes as $orden): ?>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?php if ($i != 1) print('collapsed') ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $i ?>"
                                    aria-expanded="<?php ($i == 1) ? print('true') : print('false') ?>"
                                    aria-controls="collapse-<?= $i ?>">
                                <div>
                                    <p><b>Fecha de pedido:</b> <?= $orden['creada'] ?></p>
                                    <p><b>Estado:</b> <?= $orden['estado'] ?></p>
                                    <p><b>Importe:</b> $<?= $orden['total'] ?></p>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse-<?= $i ?>" class="accordion-collapse collapse <?php ($i == 1) ? print('collapse') : print('') ?>" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <?php
                                $items = ItemPedidoDB::getDatosItemsOrdenPorIdOrden($orden['id']);
                                foreach ($items as $item): ?>
                                    <div class="row row-cols-3 border-bottom p-3">
                                        <div class="col-2">
                                            <img src="../resources/uploads/<?= $item['nombre_archivo'] ?>" alt="" width="100">
                                        </div>
                                        <div class="col-5">
                                            <p><b>Nombre:</b> <?= $item['nombre'] ?></p>
                                            <p><b>Cantidad:</b> <?= $item['cantidad'] ?></p>
                                        </div>
                                        <div class="col-5">
                                            <p><b>Precio unitario:</b> <?= $item['precio_venta'] ?></p>
                                            <p><b>Subtotal:</b> <?= $item['cantidad'] * $item['precio_venta'] ?></p>
                                        </div>
                                    </div>

                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    $i++;
                endforeach ?>
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
