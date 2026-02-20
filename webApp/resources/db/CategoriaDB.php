<?php

include_once 'Conexion.php';

class CategoriaDB {
    public static function getCategorias() {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT * FROM categoria ORDER BY categoria ASC';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_BOTH);
            $stmt->execute();
            $colores = $stmt->fetchAll();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $colores;
    }
}
