<?php

include_once 'Conexion.php';

class ImagenDB {

    public static function insertaImagen($archivos) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        $statusMsg = '';

        // File upload path
        $targetDir = "../resources/uploads/";
        $fileName = basename($archivos['imagen']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        try {
            if (!empty($archivos['imagen']['name'])) {
                // Allow certain file formats
                $tiposPermitidos = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
                if (in_array($fileType, $tiposPermitidos)) {
                    // Upload file to server
                    if (move_uploaded_file($archivos['imagen']['tmp_name'], $targetFilePath)) {
                        // Insert image file name into database
                        $consulta = "INSERT INTO imagen (nombre_archivo) VALUES('" . $fileName . "')";
                        $stmt = $dbh->prepare($consulta);
                        $stmt->setFetchMode(PDO::FETCH_BOTH);
                        $res = $stmt->execute();
                        $dbh = null; // cierra la conexion
                    } else {
                        $statusMsg = "Lo sentimos, hubo un error al subir el archivo.";
                    }
                } else {
                    $statusMsg = 'Solo se permite subir los siguientes formatos de archivos JPG, JPEG, PNG, GIF, & PDF.';
                }
            } else {
                $statusMsg = 'Por favor seleccione una imagen para subir.';
            }
            print($statusMsg);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getMaxId(){
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT MAX(id) FROM imagen';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_BOTH);
            $stmt->execute();
            $resultado = $stmt->fetch();
            if ($resultado == 0) {
                $idImagen = 0;
            } else {
                $idImagen = $resultado[0];
            }
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $idImagen;
    }
}
