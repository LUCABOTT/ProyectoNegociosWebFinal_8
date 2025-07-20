<?php

namespace Dao\Usuarios;

use Dao\Table;

class Usuarios extends Table
{

    public static function getUsuarios()
    {
        $sqlstr = "SELECT * FROM usuario;";
        return self::obtenerRegistros($sqlstr, []);
    }


    public static function getUsuarioById(int $usercod)
    {
        $sqlstr = "SELECT * FROM usuario WHERE usercod = :usercod;";
        return self::obtenerUnRegistro($sqlstr, ["usercod" => $usercod]);
    }



    /**
     * Crea un nuevo usuario.
     *
     * Nota: usercod es AUTO_INCREMENT, por lo que NO se pasa como parámetro.
     * Los parámetros con valor null pueden omitirse o enviarse como null según tu lógica de negocio.
     */
    public static function nuevoUsuario(
        string  $useremail  = "",
        string  $username   = "",
        string  $userpswd   = "",
        string  $userpswdest = "",
        string  $userpswdexp = "",
        string  $userest    = "",
        string  $useractcod = "",
        string  $userpswdchg = "",
        string  $usertipo   = ""
    ): int {

        $sqlstr = "INSERT INTO usuario (useremail, username, userpswd, userpswdest,userpswdexp, userest, useractcod, userpswdchg, usertipo)
        VALUES(:useremail, :username, :userpswd, :userpswdest,:userpswdexp, :userest, :useractcod, :userpswdchg, :usertipo)";
        $params = [
            "useremail"   => $useremail,
            "username"    => $username,
            "userpswd"    => $userpswd,

            "userpswdest" => $userpswdest,
            "userpswdexp" => $userpswdexp,
            "userest"     => $userest,
            "useractcod"  => $useractcod,
            "userpswdchg" => $userpswdchg,
            "usertipo"    => $usertipo
        ];
        return self::executeNonQuery($sqlstr, $params);
    }
    /**
     * Actualiza un usuario existente.
     */
    public static function actualizarUsuario(
        int     $usercod,
        string  $useremail = "",
        string  $username    = "",
        string  $userpswd    = "",

        string  $userpswdest = "",
        string  $userpswdexp = "",
        string  $userest     = "",
        string  $useractcod  = "",
        string  $userpswdchg = "",
        string  $usertipo    = ""
    ): int {
        $sqlstr = "UPDATE usuario SET useremail = :useremail, username = :username, userpswd = :userpswd, userpswdest = :userpswdest,
    userpswdexp = :userpswdexp, userest = :userest, useractcod = :useractcod, userpswdchg = :userpswdchg, usertipo = :usertipo
    WHERE usercod = :usercod";

        $params = [
            "usercod"     => $usercod,
            "useremail"   => $useremail,
            "username"    => $username,
            "userpswd"    => $userpswd,

            "userpswdest" => $userpswdest,
            "userpswdexp" => $userpswdexp,
            "userest"     => $userest,
            "useractcod"  => $useractcod,
            "userpswdchg" => $userpswdchg,
            "usertipo"    => $usertipo
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    /**
     * Elimina (borra físicamente) un usuario por su ID.
     */
    public static function eliminarUsuario(int $usercod): int
    {
        $sqlstr = "DELETE FROM usuario WHERE usercod = :usercod;";
        return self::executeNonQuery($sqlstr, ["usercod" => $usercod]);
    }
}
