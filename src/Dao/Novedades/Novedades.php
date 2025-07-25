<?php

namespace Dao\Novedades;

use Dao\Table;

class Novedades extends Table
{
    /**
     * Obtiene todas las novedades.
     */
    public static function getNovedades()
    {
        $sqlstr = "SELECT * FROM highlights;";
        return self::obtenerRegistros($sqlstr, []);
    }

    /**
     * Obtiene una novedad por su ID.
     */
    public static function getNovedadPorId(int $highlightId)
    {
        $sqlstr = "SELECT * FROM highlights WHERE highlightId = :highlightId;";
        return self::obtenerUnRegistro($sqlstr, ["highlightId" => $highlightId]);
    }

    /**
     * Crea una nueva novedad.
     */
    public static function nuevaNovedad(
        int    $productId,
        string $highlightStart,
        string $highlightEnd
    ): int {
        $sqlstr = "INSERT INTO highlights 
            (productId, highlightStart, highlightEnd)
            VALUES
            (:productId, :highlightStart, :highlightEnd);";

        $params = [
            "productId"       => $productId,
            "highlightStart"  => $highlightStart,
            "highlightEnd"    => $highlightEnd
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    /**
     * Actualiza una novedad existente.
     */
    public static function actualizarNovedad(
        int    $highlightId,
        int    $productId,
        string $highlightStart,
        string $highlightEnd
    ): int {
        $sqlstr = "UPDATE highlights SET 
            productId = :productId,
            highlightStart = :highlightStart,
            highlightEnd = :highlightEnd
            WHERE highlightId = :highlightId;";

        $params = [
            "highlightId"     => $highlightId,
            "productId"       => $productId,
            "highlightStart"  => $highlightStart,
            "highlightEnd"    => $highlightEnd
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    /**
     * Elimina una novedad por su ID.
     */
    public static function eliminarNovedad(int $highlightId): int
    {
        $sqlstr = "DELETE FROM highlights WHERE highlightId = :highlightId;";
        return self::executeNonQuery($sqlstr, ["highlightId" => $highlightId]);
    }
}
