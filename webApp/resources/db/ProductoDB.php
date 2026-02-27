<?php

class ProductoDB {

    public static function insertaProducto($arreglo, $idImagen) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'INSERT INTO producto (nombre, fk_categoria, descripcion, existencia, precio_compra, precio_venta, estado, fk_imagen, creado) VALUES (?,?,?,?,?,?,?,?,now())';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $arreglo['nombreProducto']);
            $stmt->bindParam(2, $arreglo['categoria']);
            $stmt->bindParam(3, $arreglo['descripcion']);
            $stmt->bindParam(4, $arreglo['existencia']);
            $stmt->bindParam(5, $arreglo['precioCompra']);
            $stmt->bindParam(6, $arreglo['precioVenta']);
            $stmt->bindParam(7, $arreglo['checkActivo']);
            $stmt->bindParam(8, $idImagen);
            $renglones = $stmt->execute();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (isset($renglones)) {
            return $renglones;
        }
    }

    public static function getProductos() {
    $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
                $consulta = 'SELECT nombre, c.categoria, descripcion, i.nombre_archivo as imagen, existencia, '
                    .' precio_compra, precio_venta, estado, creado, modificado '            
    . 'FROM producto p '
                . 'JOIN categoria c ON c.id = p.fk_categoria '
                . 'JOIN imagen i ON i.id = p.fk_imagen '
                . 'ORDER BY nombre ASC';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $productos = $stmt->fetchAll();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $productos;
    }

}
