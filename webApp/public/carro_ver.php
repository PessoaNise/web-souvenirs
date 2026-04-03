<?php

session_start();
if (isset($_SESSION['usuario'])) {

    include_once '../resources/db/CarroDB.php';

    // Initialize shopping cart class
    if (!isset($cart)) {
        $cart = new Cart;
    }

    $PageTitle = "Ver carro";

    include '../resources/templates/head.html';
    include '../resources/templates/header.html';
    include '../resources/templates/cliente_navegacion.html';
    ?>

    <div class="container">
        <h1>Carro de compras</h1>
        <div class="row">
            <div class="cart">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped cart">
                            <thead>
                            <tr>
                                <th width="10%"></th>
                                <th width="35%">Producto</th>
                                <th width="15%">Precio</th>
                                <th width="15%">Cantidad</th>
                                <th width="20%">Total</th>
                                <th width="5%"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($cart->total_items() > 0){
                                // Get cart items from session
                                $cartItems = $cart->contents();
                                foreach ($cartItems as $item) {
                                    ?>
                                    <tr>
                                        <td><img src="../../resources/uploads/<?= $item["image"] ?>" width="150" alt="..."></td>
                                        <td><?php echo $item["name"]; ?></td>
                                        <td>$ <?= $item["price"] ?></td>
                                        <td><input class="form-control" type="number" value="<?= $item["qty"]; ?>" onchange="updateCartItem(this, '<?= $item["rowid"] ?>')"/></td>
                                        <td>$ <?= $item["subtotal"] ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure to remove cart item?')?window.location.href='../resources/lib/cartAction.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>':false;"
                                                    title="Remove Item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                <?php }
                            }else{ ?>
                            <tr>
                                <td colspan="6"><p>Tu carro está vacio...</p></td>
                                <?php } ?>
                                <?php if ($cart->total_items() > 0){ ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>TOTAL</strong></td>
                                    <td><strong>$<?= $cart->total() ?></strong></td>
                                    <td></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col mb-2">
                    <div class="row">
                        <div class="col-sm-12  col-md-6">
                            <a href="cliente_vista.php" class="btn btn-block btn-secondary"><i class="ialeft"></i>Continuar comprando</a>
                        </div>
                        <div class="col-sm-12 col-md-6 text-right">
                            <?php if ($cart->total_items() > 0) { ?>
                                <a href="orden_pago.php" class="btn btn-block btn-primary">Proceder con el pago<i class="iaright"></i></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include '../resources/templates/footer.html';
    include '../resources/templates/scripts.html';
    ?>

    <script>
        function updateCartItem(obj, id) {
            console.log(obj.value + ' ' + id)
            $.get("../resources/lib/cartAction.php", {action: "updateCartItem", id: id, qty: obj.value}, function (data) {
                if (data == 'ok') {
                    location.reload();
                } else {
                    alert('Cart update failed, please try again.');
                }
            });
        }
    </script>

    <?php
    include '../resources/templates/fin.html';
} else {
    header("Location:login_error.php");
    exit();
}
