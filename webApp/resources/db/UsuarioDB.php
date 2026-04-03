<?php

include_once 'Conexion.php';

class UsuarioDB {

    public static function insertaUsuario($id, $usuario) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'INSERT INTO usuario (usuario, password, fk_persona, tipo_usuario, creado) VALUES (?,?,?,?, now())';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $usuario['usuario']);
            $stmt->bindValue(2, password_hash($usuario['contrasenia'], PASSWORD_DEFAULT));
            $stmt->bindParam(3, $id);
            $stmt->bindValue(4, 'cliente');
            $renglones = $stmt->execute();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (isset($renglones)) {
            return $renglones;
        }
    }


    public static function existeUsuario($usuario){
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT id FROM usuario WHERE usuario = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $usuario);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (isset($resultado['id_usuario']))
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

    public static function activaUsuarioById($id){
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'UPDATE usuario u SET u.activo = 1 WHERE u.id = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (isset($resultado))
            return true;
        else
            return false;
    }

    public static function getPasswordHashByUser($usuario) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT password FROM usuario WHERE usuario = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $usuario);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (isset($resultado['password'])) {
            return $resultado['password'];
        } else {
            return 0;
        }
    }

    public static function esActivo($usuario) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT u.activo FROM usuario u WHERE u.usuario = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $usuario);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if ($resultado['activo'] == 1)
            return true;
        else
            return false;
    }

    public static function getUsuarioTipoCientePorUsuario($usuario) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT tipo_usuario, id FROM usuario WHERE usuario = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $usuario);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }


}