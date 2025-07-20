<?php

namespace Dao\RolesUsuarios;

use Dao\Table;

class RolesUsuarios extends Table
{
    public static function obtenerPorLlaves($usercod, $rolescod)
    {
        $sqlstr = "SELECT * FROM roles_usuarios WHERE usercod = :usercod AND rolescod = :rolescod;";
        return self::obtenerUnRegistro($sqlstr, ["usercod" => $usercod, "rolescod" => $rolescod]);
    }

    public static function insertar($data)
    {
        $sqlstr = "INSERT INTO roles_usuarios (usercod, rolescod, roleuserest, roleuserfch, roleuserexp) 
                   VALUES (:usercod, :rolescod, :roleuserest, :roleuserfch, :roleuserexp);";
        return self::executeNonQuery($sqlstr, $data);
    }

    public static function actualizar($oldUsercod, $oldRolescod, $data)
    {
        if (isset($data["roleuserfch"]) && $data["roleuserfch"] === '') {
            $data["roleuserfch"] = null;
        }
        if (isset($data["roleuserexp"]) && $data["roleuserexp"] === '') {
            $data["roleuserexp"] = null;
        }

        // Primero eliminar el registro viejo
        $sqlDelete = "DELETE FROM roles_usuarios WHERE usercod = :oldUsercod AND rolescod = :oldRolescod;";
        $resDelete = self::executeNonQuery($sqlDelete, [
            "oldUsercod" => $oldUsercod,
            "oldRolescod" => $oldRolescod
        ]);

        if ($resDelete > 0) {
            // Insertar el nuevo registro con los datos actualizados
            $sqlInsert = "INSERT INTO roles_usuarios (usercod, rolescod, roleuserest, roleuserfch, roleuserexp) 
                      VALUES (:usercod, :rolescod, :roleuserest, :roleuserfch, :roleuserexp);";
            return self::executeNonQuery($sqlInsert, $data);
        }

        return 0; // no se pudo eliminar el viejo, no se inserta el nuevo
    }

    public static function eliminar($usercod, $rolescod)
    {
        $sqlstr = "DELETE FROM roles_usuarios WHERE usercod = :usercod AND rolescod = :rolescod;";
        return self::executeNonQuery($sqlstr, ["usercod" => $usercod, "rolescod" => $rolescod]);
    }

    public static function obtenerTodo()
    {
        $sqlstr = "SELECT * FROM roles_usuarios;";
        return self::obtenerRegistros($sqlstr, []);
    }
}
