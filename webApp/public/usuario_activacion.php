<?php
include '../resources/db/UsuarioDB.php';

if (!empty($_GET["id"])) {
    $resultado = UsuarioDB::activaUsuarioById($_GET["id"]);

    if (!empty($resultado)) {
        $message = "Tu cuenta ha sido activada";
        $type = "success";
    } else {
        $message = "Hubo un problema al activar tu cuenta";
        $type = "error";
    }
}

$PageTitle = "Activación";

include '../resources/templates/head.html';
include '../resources/templates/header.html';
?>
    <main>

        <?php if (isset($message)) { ?>
            <div class="text-center text-<?php echo $type; ?> my-4">
                <h2> <?php echo $message; ?> </h2>
                <p>Puedes cerrar esta pestaña</p>
            </div>
        <?php } ?>

    </main>
<?php
include '../resources/templates/footer.html';
include '../resources/templates/scripts.html';
include '../resources/templates/fin.html';