<?php

namespace Dao\Sales;

use Dao\Table;

class Sales extends Table
{
    /**
     * Obtiene todas las ventas.
     */
    public static function getSales()
    {
        $sqlstr = "SELECT * FROM sales;";
        return self::obtenerRegistros($sqlstr, []);
    }

    /**
     * Obtiene una venta por su ID.
     */
    public static function getSaleById(int $saleId)
    {
        $sqlstr = "SELECT * FROM sales WHERE saleId = :saleId;";
        return self::obtenerUnRegistro($sqlstr, ["saleId" => $saleId]);
    }

    /**
     * Crea una nueva venta.
     */
    public static function nuevaVenta(
        int    $productId,
        float  $salePrice,
        string $saleStart,
        string $saleEnd
    ): int {
        $sqlstr = "INSERT INTO sales 
            (productId, salePrice, saleStart, saleEnd)
            VALUES
            (:productId, :salePrice, :saleStart, :saleEnd);";

        $params = [
            "productId"  => $productId,
            "salePrice"  => $salePrice,
            "saleStart"  => $saleStart,
            "saleEnd"    => $saleEnd
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    /**
     * Actualiza una venta existente.
     */
    public static function actualizarVenta(
        int    $saleId,
        int    $productId,
        float  $salePrice,
        string $saleStart,
        string $saleEnd
    ): int {
        $sqlstr = "UPDATE sales SET 
            productId = :productId,
            salePrice = :salePrice,
            saleStart = :saleStart,
            saleEnd = :saleEnd
            WHERE saleId = :saleId;";

        $params = [
            "saleId"     => $saleId,
            "productId"  => $productId,
            "salePrice"  => $salePrice,
            "saleStart"  => $saleStart,
            "saleEnd"    => $saleEnd
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    /**
     * Elimina una venta por su ID.
     */
    public static function eliminarVenta(int $saleId): int
    {
        $sqlstr = "DELETE FROM sales WHERE saleId = :saleId;";
        return self::executeNonQuery($sqlstr, ["saleId" => $saleId]);
    }
}
