<?php

include_once 'Conexion.php';

class personaDB {

    public static function insertaPersona($persona) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'INSERT INTO persona (nombre, a_paterno, a_materno, calle, numero, correo_electronico, creado) VALUES (?,?,?,?,?,?,now())';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $persona['nombre']);
            $stmt->bindParam(2, $persona['paterno']);
            $stmt->bindParam(3, $persona['materno']);
            $stmt->bindParam(4, $persona['calle']);
            $stmt->bindParam(5, $persona['numero']);
            $stmt->bindParam(6, $persona['email']);
            $stmt->execute();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getUltimoIdInsertado() {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            // $consulta = 'SELECT MAX(id) FROM persona';
            $consulta = 'SELECT LAST_INSERT_ID()';
            $stmt = $dbh->prepare($consulta);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $id = $resultado[0];
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $id;
    }

    public static function existeCorreo($correo) : bool{
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT correo_electronico FROM persona WHERE correo_electronico = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $correo);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
            }
        if (isset($resultado['correo_electronico']))
            return true;
        else
            return false;
    }

    public static function getIdUltimoInsertado(): int {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT LAST_INSERT_ID()';
            $stmt = $dbh->prepare($consulta);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $id = $resultado[0];
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $id;
    }


}
