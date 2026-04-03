<?php

include_once 'Conexion.php';

class ItemPedidoDB {

    public static function insertaOrden($idOrden, $idProducto, $cantidad) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'INSERT INTO item_pedido (fk_orden, fk_producto, cantidad) VALUES (?,?,?)';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $idOrden);
            $stmt->bindParam(2, $idProducto);
            $stmt->bindParam(3, $cantidad);
            $resultado = $stmt->execute();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }

    public static function getDatosItemsOrdenPorIdOrden($idOrden) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT io.*, p.nombre, p.precio_venta, i.nombre_archivo  
                FROM item_pedido io
                JOIN pedido o ON o.id = io.fk_orden 
                JOIN producto p  ON p.id = io.fk_producto 
                JOIN imagen i ON i.id = p.fk_imagen 
                WHERE o.id = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->bindParam(1, $idOrden);
            $stmt->execute();
            $resultado = $stmt->fetchAll();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }

}
