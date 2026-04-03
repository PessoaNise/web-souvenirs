<?php

include_once 'Conexion.php';

class PedidoDB {
    

    public static function insertaOrden($idUsuario,$total) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'INSERT INTO pedido (fk_usuario, total, estado, creada) VALUES (?,?,?,now())';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $idUsuario);
            $stmt->bindParam(2, $total);
            $stmt->bindValue(3, 'Pendiente');
            $resultado = $stmt->execute();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if($stmt->rowCount() > 0)
            return true;
        else
            return false;
//        return $resultado;
    }

    public static function getUltimaIdInsertada() {
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

    public static function getDatosPersonaOrdenPorIdOrden($idOrden) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT o.*, p.nombre, p.a_paterno, p.calle, p.numero, p.correo_electronico
                FROM pedido o
                JOIN usuario u ON u.id = o.fk_usuario  
                JOIN persona p ON p.id = u.fk_persona 
                WHERE o.id = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->bindParam(1, $idOrden);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }


    public static function getOrdenesDeClientePorIdCliente($idCliente) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT * from pedido o WHERE o.fk_usuario = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->bindParam(1, $idCliente);
            $stmt->execute();
            $resultado = $stmt->fetchAll();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }

    public static function getOrdenes() {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT * from pedido p';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $resultado = $stmt->fetchAll();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }


}
