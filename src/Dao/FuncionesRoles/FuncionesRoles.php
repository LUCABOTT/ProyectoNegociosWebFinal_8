<?php

namespace Dao\FuncionesRoles;

use Dao\Table;

class FuncionesRoles extends Table
{
    public static function getFuncionesRoles(): array
    {
        $sqlstr = "SELECT rolescod, fncod, fnrolest, fnexp FROM funciones_roles;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getFuncionRolByIds(string $rolescod, string $fncod)
    {
        $sqlstr = "SELECT * FROM funciones_roles WHERE rolescod = :rolescod AND fncod = :fncod;";
        return self::obtenerUnRegistro($sqlstr, [
            "rolescod" => $rolescod,
            "fncod" => $fncod
        ]);
    }

    public static function nuevaFuncionRol(string $rolescod, string $fncod, string $estado, ?string $exp = null)
    {
        $sqlstr = "INSERT INTO funciones_roles (rolescod, fncod, fnrolest, fnexp) VALUES (:rolescod, :fncod, :estado, :exp);";
        return self::executeNonQuery($sqlstr, [
            "rolescod" => $rolescod,
            "fncod" => $fncod,
            "estado" => $estado,
            "exp" => $exp
        ]);
    }

    public static function actualizarFuncionRol(
        string $original_rolescod,
        string $original_fncod,
        string $nuevo_rolescod,
        string $nuevo_fncod,
        string $fnrolest,
        ?string $fnexp
    ) {
        $sqlstr = "UPDATE funciones_roles SET 
        rolescod = :nuevo_rolescod,
        fncod = :nuevo_fncod,
        fnrolest = :fnrolest,
        fnexp = :fnexp
        WHERE rolescod = :original_rolescod AND fncod = :original_fncod;";

        return self::executeNonQuery($sqlstr, [
            "nuevo_rolescod" => $nuevo_rolescod,
            "nuevo_fncod" => $nuevo_fncod,
            "fnrolest" => $fnrolest,
            "fnexp" => $fnexp,
            "original_rolescod" => $original_rolescod,
            "original_fncod" => $original_fncod
        ]);
    }


    public static function eliminarFuncionRol(string $rolescod, string $fncod)
    {
        $sqlstr = "DELETE FROM funciones_roles WHERE rolescod = :rolescod AND fncod = :fncod;";
        return self::executeNonQuery($sqlstr, [
            "rolescod" => $rolescod,
            "fncod" => $fncod
        ]);
    }
}
