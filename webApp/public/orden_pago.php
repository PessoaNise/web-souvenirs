<?php

session_start();
if (isset($_SESSION['usuario'])) {

// Initialize shopping cart class
    include_once '../resources/db/CarroDB.php';
    $cart = new Cart;

// If the cart is empty, redirect to the products page
    if ($cart->total_items() <= 0) {
        header("Location: cliente_vista.php");
    }

// Get posted form data from session
    $postData = !empty($_SESSION['postData']) ? $_SESSION['postData'] : array();
    unset($_SESSION['postData']);

// Get status message from session
    $sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';
    if (!empty($sessData['status']['msg'])) {
        $statusMsg = $sessData['status']['msg'];
        $statusMsgType = $sessData['status']['type'];
        unset($_SESSION['sessData']['status']);
    }

    $PageTitle = "Orden pago";

    include '../resources/templates/head.html';
    include '../resources/templates/header.html';
    include '../resources/templates/cliente_navegacion.html';

    ?>

    <div class="container my-5">
        <div>
            <?php if (!empty($statusMsg) && ($statusMsgType == 'success')) { ?>
                <div class="col-md-12">
                    <div class="alert alert-success"><?= $statusMsg; ?></div>
                </div>
            <?php } elseif (!empty($statusMsg) && ($statusMsgType == 'error')) { ?>
                <div class="col-md-12">
                    <div class="alert alert-danger"><?= $statusMsg; ?></div>
                </div>
            <?php } ?>
        </div>

        <div class="row justify-content-center">
            <div class="col-8">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Tu carro</span>
                    <span class="badge badge-secondary badge-pill"><?php echo $cart->total_items(); ?></span>
                </h4>
                <ul class="list-group mb-3">
                    <?php
                    if ($cart->total_items() > 0) {
                        // Get cart items from session
                        $cartItems = $cart->contents();
                        foreach ($cartItems as $item) {
                            ?>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0"><?php echo $item["name"]; ?></h6>
                                    <small class="text-muted">$<?= $item["price"]; ?> (<?= $item["qty"]; ?>)</small>
                                </div>
                                <span class="text-muted">$<?= $item["subtotal"]; ?></span>
                            </li>
                        <?php }
                    } ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total </span>
                        <strong>$<?= $cart->total() ?></strong>
                    </li>
                </ul>
                <div class="mt-4 mb-5 text-end">
                    <a href="cliente_vista.php" class="btn btn-block btn-info">Agregar más artículos</a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-8">
                <form method="post" action="../resources/lib/cartAction.php">
                    <div class="row justify-content-center">
                        <div class="column col-8 mb-3">
                            <label for="propietario">Propietario</label>
                            <input type="text" class="form-control" name="propietario">
                            <span class="text-danger"><?php if (isset($errores['propietario'])) print($errores['propietario']) ?></span>
                        </div>
                        <div class="column col-4 mb-3">
                            <label for="cvv">CVV</label>
                            <input type="text" class="form-control" name="cvv">
                            <span class="text-danger"><?php if (isset($errores['cvv'])) print($errores['cvv']) ?></span>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="column col-12 mb-3">
                            <label for="numTarjeta">Número de tarjeta</label>
                            <input type="text" class="form-control" name="numTarjeta">
                            <span class="text-danger"><?php if (isset($errores['numTarjeta'])) print($errores['numTarjeta']) ?></span>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="column col-12 mb-3">
                            <label class="form-label">Fecha de expiración</label>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="column col-5 mb-3">
                            <select class="form-select" name="mes">
                                <option value="01">Enero</option>
                                <option value="02">Febrero</option>
                                <option value="03">Marzo</option>
                                <option value="04">Abril</option>
                                <option value="05">Mayo</option>
                                <option value="06">Junio</option>
                                <option value="07">Julio</option>
                                <option value="08">Agosto</option>
                                <option value="09">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                            <span class="text-danger"><?php if (isset($errores['mes'])) print($errores['mes']) ?></span>
                        </div>
                        <div class="column col-4 mb-3">
                            <select class="form-select" name="anio">
                                <option value="23">2023</option>
                                <option value="24">2024</option>
                                <option value="25">2025</option>
                                <option value="26">2026</option>
                                <option value="27">2027</option>
                                <option value="28">2028</option>
                            </select>
                            <span class="text-danger"><?php if (isset($errores['anio'])) print($errores['anio']) ?></span>
                        </div>
                        <div class="column col-3 mb-3 ">
                            <img src="assets/img/visa.jpg" id="visa">
                            <img src="assets/img/mastercard.jpg" id="mastercard">
                        </div>
                        <div class="mt-4 mb-5 text-end">
                            <input type="hidden" name="action" value="placeOrder"/>
                            <input class="btn btn-success btn-block" type="submit" name="checkoutSubmit" value="Pagar">
                        </div>
                    </div>
                </form>
            </div>
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