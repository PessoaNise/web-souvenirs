<?php

include '../resources/db/PersonaDB.php';
include '../resources/db/UsuarioDB.php';
include '../resources/lib/sanitizacion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$nombre = $paterno = $materno = $calle = $numero = $cp = $usuario = $email = $contrasenia = $contrasenia2 = "";
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = sanitizacion($_POST["nombre"]);
    $paterno = sanitizacion($_POST["paterno"]);
    $materno = sanitizacion($_POST["materno"]);
    $calle = sanitizacion($_POST["calle"]);
    $numero = sanitizacion($_POST["numero"]);
    $cp = sanitizacion($_POST["cp"]);
    $usuario = sanitizacion($_POST["usuario"]);
    $email = sanitizacion($_POST["email"]);

    if (!PersonaDB::existeCorreo($_POST['email']) && !UsuarioDB::existeUsuario($_POST['usuario'])) {
        PersonaDB::insertaPersona($_POST);
        $idPersonaInsertada = PersonaDB::getUltimoIdInsertado();
        $resInsertUsuario = UsuarioDB::insertaUsuario($idPersonaInsertada, $_POST);
        $idUsuarioInsertado = UsuarioDB::getIdUltimoInsertado();
        if ($resInsertUsuario > 0) {

            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = SMTP::DEBUG_OFF;         //Disable verbose debug output
                $mail->isSMTP();                            //Send using SMTP
                $mail->Host = 'sandbox.smtp.mailtrap.io';   //Set the SMTP server to send through
                $mail->SMTPAuth = true;                     //Enable SMTP authentication
                $mail->Username = 'ffb41d9b44cace';         //SMTP username
                $mail->Password = '4cb962207e3c58';         //SMTP password
                $mail->Port = 2525;                         //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                $mail->setFrom('registro@tizaovenirs.com', 'admin');
                $mail->addAddress($email, $nombre . ' ' . $paterno);

                $link = "http://$_SERVER[HTTP_HOST]" . "/public/usuario_activacion.php?id=" . $idUsuarioInsertado;
                $mail->isHTML(true);                        //Set email format to HTML
                $mail->Subject = 'Valida tu correo por favor';
                $mail->Body = "Haz click para activar tu cuenta, <a href='" . $link . "'>" . $link . "</a>";

                $resEnviarCorreo = $mail->send();
                ?>

                <?php
            } catch (Exception $e) {
                ?>
                <h2>No se pudo envíar el correo. Mailer error <?= $mail->ErrorInfo ?></h2>
                <?php
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } else {
        if (PersonaDB::existeCorreo($_POST['email'])) {
            ?>
            <div class="text-center m-5 p-5 text-danger ">
                <h2>Ya existe un registro con ese correo electrónico</h2>
            </div>
            <?php
        } else {
            ?>
            <div class="text-center m-5 p-5 text-danger ">
                <h2>Ya existe un registro con ese nombre de usuario</h2>
            </div>
        <?php }
    }
}

$PageTitle = "Registro usuario";
include '../resources/templates/head.html';
include '../resources/templates/header.html';

?>

    <main>
        <div class="text-secondary text-center m-4 ">
            <h2>Registro de usuario nuevo</h2>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="column col-9">
                    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                        
                        <div class="mt-2">
                            <label class="form-label" for="nombre">Nombre:</label>
                            <input class="form-control" type="text" required name="nombre" value="<?= $nombre ?>">
                        </div>
                        <div class="mt-2">
                            <label class="form-label " for="paterno">Apellido paterno:</label>
                            <input class="form-control" type="text" required name="paterno" value="<?= $paterno ?>">
                        </div>
                        <div class="mt-2">
                            <label class="form-label " for="materno">Apellido materno:</label>
                            <input class="form-control" type="text" required name="materno" value="<?= $materno ?>">
                        </div>
                        <div class="row">
                            <div class="col mt-2">
                                <label class="form-label " for="calle">Calle:</label>
                                <input class="form-control" type="text" required name="calle" value="<?= $calle ?>">
                            </div>
                            <div class="col mt-2">
                                <label class="form-label " for="numero">Número:</label>
                                <input class="form-control" type="text" required name="numero" value="<?= $numero ?>">
                            </div>
                            <div class="col mt-2">
                                <label class="form-label " for="cp">Código postal:</label>
                                <input class="form-control" type="text" required name="cp" value="<?= $cp ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mt-2">
                                <label class="form-label " for="usuario">Usuario:</label>
                                <input class="form-control" type="text" required name="usuario" value="<?= $usuario ?>">
                            </div>
                            <div class="col my-2">
                                <label class="form-label " for="contrasenia">Contraseña</label>
                                <input class="form-control" type="password" name="contrasenia" id="contrasenia" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mt-2">
                                <label class="form-label " for="email">Correo electrónico:</label>
                                <input class="form-control" type="email" required name="email" value="<?= $usuario ?>">
                            </div>
                            <div class="col my-2">
                                <label class="form-label " for="contrasenia2">Repetir contraseña</label>
                                <input class="form-control" type="password" name="contrasenia2" id="contrasenia2" required>
                             </div>
                        </div>
                        <div class="mt-2 text-end">
                            <input class="btn btn-primary " type="submit" value="Enviar">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

<?php
include '../resources/templates/footer.html';
include '../resources/templates/scripts.html';
?>
    <script>
        let password = document.getElementById("contrasenia")
        let confirm_password = document.getElementById("contrasenia2");

        function validatePassword() {
            if (password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Las contraseñas no coinciden");
            } else {
                confirm_password.setCustomValidity('');
            }
        }

        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    </script>

<?php if ($resEnviarCorreo): ?>
    <script>
        Swal.fire({
            title: "Revisa tu correo para validar tu usuario",
            icon: "success",
        }).then(function () {
            window.location = "login.php"
        });
    </script>
<?php endif; ?>
<?php
include '../resources/templates/fin.html';