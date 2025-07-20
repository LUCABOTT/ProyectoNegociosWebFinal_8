<?php

namespace Dao\Roles;

use Dao\Table;

class Roles extends Table
{

    public static function getRoles()
    {
        $sqlstr = "SELECT * FROM roles;";
        return self::obtenerRegistros($sqlstr, []);
    }


    public static function getRolById(string $rolescod)
    {
        $sqlstr = "SELECT * FROM roles WHERE rolescod = :rolescod;";
        return self::obtenerUnRegistro($sqlstr, ["rolescod" => $rolescod]);
    }


    public static function nuevoRol(string $codigo, string $descripcion, string $estado)
    {
        $sqlstr = "INSERT INTO roles (rolescod, rolesdsc, rolesest) VALUES (:codigo, :descripcion, :estado);";
        return self::executeNonQuery(
            $sqlstr,
            [
                "codigo" => $codigo,
                "descripcion" => $descripcion,
                "estado" => $estado
            ]
        );
    }


    public static function actualizarRol(string $codigo, string $descripcion, string $estado): int
    {
        $sqlstr = "UPDATE roles SET rolesdsc = :descripcion, rolesest = :estado WHERE rolescod = :codigo;";
        return self::executeNonQuery(
            $sqlstr,
            [
                "codigo" => $codigo,
                "descripcion" => $descripcion,
                "estado" => $estado
            ]
        );
    }


    public static function eliminarRol(string $codigo): int
    {
        $sqlstr = "DELETE FROM roles WHERE rolescod = :codigo;";
        return self::executeNonQuery(
            $sqlstr,
            [
                "codigo" => $codigo
            ]
        );
    }
}
