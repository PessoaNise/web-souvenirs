<?php

session_start();
if (isset($_SESSION['usuario'])) {

    include '../resources/db/PedidoDB.php';
    include '../resources/db/ItemPedidoDB.php';

    if (!empty($_REQUEST['id'])) {
        $order_id = base64_decode($_REQUEST['id']);
        $orderData = PedidoDB::getDatosPersonaOrdenPorIdOrden($order_id);
    }

    if (empty($orderData)) {
        header("Location: index.php");
        exit();
    }

    $PageTitle = "Pagar";

    include '../resources/templates/head.html';
    include '../resources/templates/header.html';
    include '../resources/templates/cliente_navegacion.html';

    ?>

    <div class="container">
        <h1>ORDER STATUS</h1>
        <div class="col-12">
            <?php if (!empty($orderData)) : ?>
                <div class="col-md-12">
                    <div class="alert alert-success">Tu orden ha sido procesada exitosamente</div>
                </div>

                <!-- Order status & shipping info -->
                <div class="row col-lg-12 ord-addr-info">
                    <h3>Información de la orden</h3>
                    <p><b>Número de referencia:</b> #<?= $orderData['id']; ?></p>
                    <p><b>Total:</b> $<?= $orderData['total']; ?></p>
                    <p><b>Fecha compra:</b> <?= $orderData['creada']; ?></p>
                    <p><b>Nombre cliente:</b> <?= $orderData['nombre'] . ' ' . $orderData['a_paterno']; ?></p>
                    <p><b>Email:</b> <?= $orderData['correo_electronico']; ?></p>
                    <p><b>Dirección:</b> <?= $orderData['calle'] . ' #' . $orderData['numero']; ?></p>
                </div>

                <!-- Order items -->
                <div class="row col-lg-12">
                    <table class="table table-hover cart">
                        <thead>
                        <tr>
                            <th width="10%"></th>
                            <th width="45%">Producto</th>
                            <th width="15%">Precio</th>
                            <th width="10%">Cantidad</th>
                            <th width="20%">Sub total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $items = ItemPedidoDB::getDatosItemsOrdenPorIdOrden($orderData['id']);
                        foreach ($items as $item) : ?>
                            <tr>
                                <td><img src="../resources/uploads/<?= $item["nombre_archivo"] ?>" width="100" alt="..."></td>
                                <td><?= $item["nombre"]; ?></td>
                                <td>$<?= $item['precio_venta'] ?></td>
                                <td><?= $item['cantidad'] ?></td>
                                <td>$<?= $item['precio_venta'] * $item['cantidad'] ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

                <div class="col my-4">
                    <div class="row">
                        <div class="col-sm-12  col-md-6">
                            <a href="cliente_vista.php" class="btn btn-block btn-primary"><i class="ialeft"></i>Continuar comprando</a>
                        </div>
                    </div>
                </div>

                <div class="col my-3">
                    <form action="ticket_generar.php" method="get" target="_blank">
                        <input type="hidden" name="idOrden" value="<?= $order_id ?>">
                        <button type="submit" class="btn btn-success">Descargar ticket</button>
                    </form>
                </div>
            
            <?php else: ?>
                <div class="col-md-12">
                    <div class="alert alert-danger">Ha habido un error al procesar tu pago!</div>
                </div>
            <?php endif ?>
        </div>
    </div>

    <?php

    include '../resources/templates/footer.html';
    include '../resources/templates/scripts.html';
    include '../resources/templates/fin.html';

} else {
    header("Location:login_error.php");
    exit();
}
