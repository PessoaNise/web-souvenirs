<?php

include '../db/ProductoDB.php';
include '../db/PedidoDB.php';
include '../db/ItemPedidoDB.php';

require_once '../db/CarroDB.php';
$cart = new Cart;

$redirectURL = '../../public/cliente_vista.php';

// Process request based on the specified action
if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    if ($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])) {
        $product_id = $_REQUEST['id'];

        $product = ProductoDB::getProductoPorId($product_id);

        $itemData = array(
            'id' => $product['id'],
            'image' => $product['imagen'],
            'name' => $product['nombre'],
            'price' => $product['precio_venta'],
            'qty' => 1
        );

        // Insert item to cart
        $insertItem = $cart->insert($itemData);

        // Redirect to cart page
        $redirectURL = $insertItem ? '../../public/carro_ver.php' : '../../public/cliente_vista.php';
    } elseif ($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])) {
        // Update item data in cart
        $itemData = array(
            'rowid' => $_REQUEST['id'],
            'qty' => $_REQUEST['qty']
        );
        $updateItem = $cart->update($itemData);

        // Return status
        echo $updateItem ? 'ok' : 'err';
        die;
    } elseif ($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])) {
        // Remove item from cart
        $deleteItem = $cart->remove($_REQUEST['id']);

        // Redirect to cart page
        $redirectURL = '../../public/carro_ver.php';
    } elseif ($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0) {
        $redirectURL = '../../public/orden_pago.php';

        // Store post data
        $_SESSION['postData'] = $_POST;

        $errorMsg = '';

        $resInsertaOrden = PedidoDB::insertaOrden($_SESSION['id_usuario'], $cart->total());

        if ($resInsertaOrden) {
            $ordenId = PedidoDB::getUltimaIdInsertada();

            // Retrieve cart items
            $cartItems = $cart->contents();

            // Insert order items in the database
            if (!empty($cartItems)) {
                foreach ($cartItems as $item) {
                    ItemPedidoDB::insertaOrden($ordenId, $item['id'], $item['qty']);
                }

                // Remove all items from cart
                $cart->destroy();

                // Redirect to the status page
                $redirectURL = '../../public/pago_validacion.php?id=' . base64_encode($ordenId);
            } else {
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Something went wrong, please try again.';
            }
        } else {
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'Something went wrong, please try again.';
        }
    }
}

// Redirect to the specific page
header("Location: $redirectURL");
exit();
