<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location:index.php");
    session_destroy();
    exit();
} else {
    header("Location:login_error.php");
    exit();
}
