<?php

session_start();
if (isset($_SESSION['usuario'])) {

    $PageTitle = "Ver productos";

    include '../resources/templates/head.html';
    include '../resources/templates/header.html';
    include '../resources/templates/administrador_navegacion.html';

    ?>
    <main>

        <div class="container-md">

            <div class="text-secondary text-center m-4 ">
                <h2>Productos</h2>
            </div>

            <input class="form-control mb-5" type="text" id="busqueda" onkeyup="funcionBuscar()"
                   placeholder="Búsqueda por producto" title="Escribe un producto">

            <table class="table table-striped" id="tabla">
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center">Nombre producto</th>
                    <th class="text-center">Categoria</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Existencia</th>
                    <th class="text-center">Precio compra</th>
                    <th class="text-center">Precio venta</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Creado</th>
                    <th class="text-center">Modificado</th>
                    <th class="text-center">Modificar</th>
                </tr>
                <?php
                include '../resources/db/ProductoDB.php';
                $productos = ProductoDB::getProductos();
                foreach ($productos as $producto):?>
                    <tr>
                        <td class="text-center align-middle"><img src="<?= '../resources/uploads/' . $producto['imagen'] ?>"
                                                                  height="100px"></td>
                        <td class="text-center"><?= $producto['nombre'] ?></td>
                        <td class="text-center"><?= $producto['categoria'] ?></td>
                        <td class="text-center"><?= $producto['descripcion'] ?></td>
                        <td class="text-center"><?= $producto['existencia'] ?></td>
                        <td class="text-center"><?= $producto['precio_compra'] ?></td>
                        <td class="text-center"><?= $producto['precio_venta'] ?></td>
                        <td class="text-center"><?= $producto['estado'] ?></td>
                        <td class="text-center"><?= $producto['creado'] ?></td>
                        <td class="text-center"><?= $producto['modificado'] ?></td>
                        <td class="text-center align-middle">
                            <form action="../../public/producto_modificar.php" method="POST">
                                <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                <input class="btn btn-success" type="submit" value="Modificar">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>

    <script>
        function funcionBuscar() {
            let textoBuscar, tabla, renglones, primerCelda, renglon, textoCelda;
            textoBuscar = document.getElementById("busqueda").value.toUpperCase();
            tabla = document.getElementById("tabla");
            renglones = tabla.getElementsByTagName("tr");
            for (renglon = 0; renglon < renglones.length; renglon++) {
                primerCelda = renglones[renglon].getElementsByTagName("td")[1];
                if (primerCelda) {
                    textoCelda = primerCelda.textContent || primerCelda.innerText;
                    if (textoCelda.toUpperCase().indexOf(textoBuscar) > -1) {
                        renglones[renglon].style.display = "";
                    } else {
                        renglones[renglon].style.display = "none";
                    }
                }
            }
        }
    </script>

    <?php
    include '../resources/templates/footer.html';
    include '../resources/templates/scripts.html';
    include '../resources/templates/fin.html';

} else {
    header("Location:login_error.php");
    exit();
}
