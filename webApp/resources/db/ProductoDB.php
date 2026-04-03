<?php

include_once 'Conexion.php';

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
                $consulta = 'SELECT p.id, nombre, c.categoria, descripcion, i.nombre_archivo as imagen, existencia, '
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

    public static function getProductoPorId($id) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT p.id, nombre, fk_categoria, descripcion, i.nombre_archivo as imagen, existencia, 
                precio_compra, precio_venta, estado, creado, modificado FROM producto p 
                JOIN categoria c ON c.id = p.fk_categoria 
                JOIN imagen i ON i.id = p.fk_imagen 
                WHERE p.id=?';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $producto = $stmt->fetch();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
            }
        return $producto;
    }

    public static function modificaProductoSinImagen($arreglo) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'UPDATE producto 
                SET nombre=?, fk_categoria=?, descripcion=?, existencia=?, precio_compra=?, precio_venta=?, estado=?, modificado=now() 
                WHERE id=?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $arreglo['nombreProducto']);
            $stmt->bindParam(2, $arreglo['categoria']);
            $stmt->bindParam(3, $arreglo['descripcion']);
            $stmt->bindParam(4, $arreglo['existencia']);
            $stmt->bindParam(5, $arreglo['precioCompra']);
            $stmt->bindParam(6, $arreglo['precioVenta']);
            $stmt->bindParam(7, $arreglo['checkActivo']);
            $stmt->bindParam(8, $arreglo['id']);
            $renglones = $stmt->execute();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (isset($renglones)) {
            return $renglones;
        }
    }

    public static function modificaProductoConImagen($arreglo, $idImagen) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'UPDATE producto 
                SET nombre=?, fk_categoria=?, descripcion=?, existencia=?, precio_compra=?, precio_venta=?, estado=?, fk_imagen=?, modificado=now() 
                WHERE id=?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $arreglo['nombreProducto']);
            $stmt->bindParam(2, $arreglo['categoria']);
            $stmt->bindParam(3, $arreglo['descripcion']);
            $stmt->bindParam(4, $arreglo['existencia']);
            $stmt->bindParam(5, $arreglo['precioCompra']);
            $stmt->bindParam(6, $arreglo['precioVenta']);
            $stmt->bindParam(7, $arreglo['checkActivo']);
            $stmt->bindParam(8, $idImagen);
            $stmt->bindParam(9, $arreglo['id']);
            $renglones = $stmt->execute();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (isset($renglones)) {
            return $renglones;
        }
    }


    public static function getProductosPorCategoriaId($idCategoria) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT p.id, nombre, c.categoria, descripcion, i.nombre_archivo as imagen, existencia, 
                precio_compra, precio_venta, estado, creado, modificado 
                FROM producto p 
                JOIN categoria c ON c.id = p.fk_categoria 
                JOIN imagen i ON i.id = p.fk_imagen 
                WHERE c.id = ?
                ORDER BY nombre ASC';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->bindParam(1, $idCategoria);
            $stmt->execute();
            $productos = $stmt->fetchAll();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $productos;
    }
        
    public static function getProductosAleatorios($cant) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT p.id, nombre, c.categoria, descripcion, i.nombre_archivo as imagen, existencia, 
                        precio_compra, precio_venta, estado, p.creado, p.modificado 
                        FROM producto p 
                        JOIN categoria c ON c.id = p.fk_categoria 
                        JOIN imagen i ON i.id = p.fk_imagen 
                        ORDER BY RAND() LIMIT ?';
                
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                
                // Es vital forzar el tipo a entero para que LIMIT funcione correctamente en PDO
            $stmt->bindValue(1, (int)$cant, PDO::PARAM_INT);
            $stmt->execute();
                
            $productos = $stmt->fetchAll();
            $dbh = null; 
                
            return $productos;
                
        } catch (PDOException $e) {
            print($e->getMessage());
            return array();
        }
    }

}