<?php

include '../resources/db/UsuarioDB.php';

$usuario = $contrasenia = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST['usuario'];
    $contrasenia = $_POST['contrasenia'];

    $passwordHasheado = UsuarioDB::getPasswordHashByUser($_POST['usuario']);
if (password_verify($_POST['contrasenia'], $passwordHasheado) && UsuarioDB::esActivo($usuario)) {
        session_start();
        $_SESSION['usuario'] = $_POST['usuario'];
        $consulta = UsuarioDB::getUsuarioTipoCientePorUsuario($_POST['usuario']);
        $tipoUsuario = $consulta['tipo_usuario'];
        $_SESSION['id_usuario'] = $consulta['id'];
        if ($tipoUsuario == 'administrador') {
            header("Location:administrador_vista.php");
        } else {
            header("Location:cliente_vista.php");
        }
        exit();
    } else { // Usuario o password inválido
        header("Location:login_error.php");
        exit();
    }
}

$PageTitle = "Login";

include '../resources/templates/head.html';
include '../resources/templates/header.html';
?>
    <main>
        <div class="container mt-5">

            <div class="row justify-content-center">

                <div class="column col-9 col-md-6 shadow-lg p-5 mb-5 bg-body rounded">

                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                        <div class="mt-3">
                            <label class="form-label" for="usuario">Usuario</label>
                            <input class="form-control" type="text" name="usuario" value="<?= $usuario ?>" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" for="contrasenia">Contraseña</label>
                            <input class="form-control" type="password" name="contrasenia" value="<?= $contrasenia ?>" required>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
<?php
include '../resources/templates/footer.html';
include '../resources/templates/scripts.html';
include '../resources/templates/fin.html';