<?php

namespace Dao\Funciones;

use Dao\Table;

class Funciones extends Table
{

    public static function getFunciones()
    {
        $sqlstr = "SELECT * from funciones;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getFuncionesById(string $funcionesId)
    {
        $sqlstr = "SELECT * FROM funciones where fncod = :fncod;";
        return self::obtenerUnRegistro($sqlstr, ["fncod" => $funcionesId]); // self retorna
    }

    public static function nuevaFuncion(string $codigo, string $descripcion, string $estado, string $tipo)
    {
        $sqlstr = "INSERT INTO funciones (fncod,fndsc, fnest, fntyp) VALUES (:codigo, :descripcion, :estado, :tipo);";
        return self::executeNonQuery( // excecutenonquery devuleve los registros cambiados si es mayr a cero los insera
            $sqlstr, // self retorna
            [
                "codigo" => $codigo,
                "descripcion" => $descripcion,
                "estado" => $estado,
                "tipo" => $tipo
            ]
        );
    }

    public static function actualizarfuncion(string $codigo, string $descripcion, string $estado, string $tipo): int //: int porue devuelve un entero, o sea la cantidad de datos modificados
    {
        $sqlstr = "UPDATE funciones set fncod = :codigo, fndsc = :descripcion, fnest = :estado, fntyp = :tipo where fncod = :codigo;";

        return self::executeNonQuery( // self retorna
            $sqlstr,
            [
                "codigo" => $codigo,
                "descripcion" => $descripcion,
                "estado" => $estado,
                "tipo" => $tipo
            ]
        );
    }

    public static function eliminarfuncion(string $codigo): string
    {
        $sqlstr = "DELETE from funciones where fncod = :codigo;";
        return self::executeNonQuery( // self retorna
            $sqlstr,
            [
                "codigo" => $codigo
            ]
        );
    }
}
