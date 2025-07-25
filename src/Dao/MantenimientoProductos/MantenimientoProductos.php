<?php

namespace Dao\MantenimientoProductos;

use Dao\Table;

class MantenimientoProductos extends Table
{
    /**
     * Obtiene todos los productos.
     */
    public static function getProductos()
    {
        $sqlstr = "SELECT * FROM products;";
        return self::obtenerRegistros($sqlstr, []);
    }

    /**
     * Obtiene un producto por su ID.
     */
    public static function getProductoPorId(int $productId)
    {
        $sqlstr = "SELECT * FROM products WHERE productId = :productId;";
        return self::obtenerUnRegistro($sqlstr, ["productId" => $productId]);
    }

    /**
     * Crea un nuevo producto.
     */
    public static function nuevoProducto(
        string $productName,
        string $productDescription,
        float  $productPrice,
        int    $productStock,
        string $productImgUrl,
        string $productStatus
    ): int {
        $sqlstr = "INSERT INTO products 
            (productName, productDescription, productPrice, productStock, productImgUrl, productStatus)
            VALUES
            (:productName, :productDescription, :productPrice, :productStock, :productImgUrl, :productStatus);";

        $params = [
            "productName"        => $productName,
            "productDescription" => $productDescription,
            "productPrice"       => $productPrice,
            "productStock"       => $productStock,
            "productImgUrl"      => $productImgUrl,
            "productStatus"      => $productStatus
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    /**
     * Actualiza un producto existente.
     */
    public static function actualizarProducto(
        int    $productId,
        string $productName,
        string $productDescription,
        float  $productPrice,
        int    $productStock,
        string $productImgUrl,
        string $productStatus
    ): int {
        $sqlstr = "UPDATE products SET 
            productName = :productName,
            productDescription = :productDescription,
            productPrice = :productPrice,
            productStock = :productStock,
            productImgUrl = :productImgUrl,
            productStatus = :productStatus
            WHERE productId = :productId;";

        $params = [
            "productId"          => $productId,
            "productName"        => $productName,
            "productDescription" => $productDescription,
            "productPrice"       => $productPrice,
            "productStock"       => $productStock,
            "productImgUrl"      => $productImgUrl,
            "productStatus"      => $productStatus
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    /**
     * Elimina un producto por su ID.
     */
    public static function eliminarProducto(int $productId): int
    {
        $sqlstr = "DELETE FROM products WHERE productId = :productId;";
        return self::executeNonQuery($sqlstr, ["productId" => $productId]);
    }
}
