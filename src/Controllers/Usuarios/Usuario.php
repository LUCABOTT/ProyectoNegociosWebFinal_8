<?php

namespace Controllers\Usuarios;

use Controllers\PublicController;
use Dao\Usuarios\Usuarios as UsuariosDao;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

const LIST_URL = "index.php?page=Usuarios-Usuarios";
const XSR_KEY = "xsrToken_usuario";

class Usuario extends PublicController
{
    private array $viewData;
    private array $estados;
    private array $tipos;
    private array $modes;

    public function __construct()
    {
        $this->modes = [
            "INS" => 'Creando nuevo usuario',
            "UPD" => 'Modificando usuario %s',
            "DEL" => 'Eliminando usuario %s',
            "DSP" => 'Mostrando usuario %s'
        ];
        $this->estados = ["ACT", "INA", "BLQ", "AUD"];
        $this->tipos = ["PBL", "ADM", "AUD"];
        $this->viewData = [
            "usercod" => 0,
            "useremail" => "",
            "username" => "",
            "userpswd" => "",

            "userpswdest" => "ACT",
            "userpswdexp" => "",
            "userest" => "ACT",
            "useractcod" => "",
            "userpswdchg" => "",
            "usertipo" => "PBL",

            "mode" => "",
            "modeDsc" => "",
            "errores" => [],
            "readonly" => "",
            "showAction" => true,
            "xsrToken" => ""
        ];
    }

    public function run(): void
    {
        $this->capturarModoPantalla();
        $this->datosDeDao();

        if ($this->isPostBack()) {
            $this->datosFormulario();
            $this->validarDatos();
            if (count($this->viewData["errores"]) === 0) {
                $this->procesarDatos();
            }
        }

        $this->prepararVista();
        Renderer::render("Usuarios/Usuario", $this->viewData);
    }

    private function throwError(string $message)
    {
        Site::redirectToWithMsg(LIST_URL, $message);
    }

    private function capturarModoPantalla()
    {
        if (isset($_GET["mode"])) {
            $this->viewData["mode"] = $_GET["mode"];
            if (!isset($this->modes[$this->viewData["mode"]])) {
                $this->throwError("BAD REQUEST: Modo no válido.");
            }
        }
    }

    private function datosDeDao()
    {
        if ($this->viewData["mode"] !== "INS") {
            if (isset($_GET["id"])) {
                $this->viewData["usercod"] = intval($_GET["id"]);
                $usuario = UsuariosDao::getUsuarioById($this->viewData["usercod"]);
                if (is_array($usuario)) {
                    foreach ($this->viewData as $key => $value) {
                        if (isset($usuario[$key])) {
                            $this->viewData[$key] = $usuario[$key];
                        }
                    }
                } else {
                    $this->throwError("El usuario no existe.");
                }
            } else {
                $this->throwError("No se proporcionó ID para consultar.");
            }
        }
    }

    private function datosFormulario()
    {
        foreach ($this->viewData as $key => $value) {
            if (isset($_POST[$key])) {
                $this->viewData[$key] = $_POST[$key];
            }
        }
    }

    private function validarDatos()
    {
        if (Validators::IsEmpty($this->viewData["useremail"])) {
            $this->viewData["errores"]["useremail"] = "El correo electrónico es obligatorio.";
        } elseif (!Validators::IsValidEmail($this->viewData["useremail"])) {
            $this->viewData["errores"]["useremail"] = "Correo no válido.";
        }

        if (Validators::IsEmpty($this->viewData["username"])) {
            $this->viewData["errores"]["username"] = "El nombre es obligatorio.";
        }

        if (!in_array($this->viewData["userest"], $this->estados)) {
            $this->viewData["errores"]["userest"] = "Estado de usuario no válido.";
        }

        $tmpXsrToken = $_SESSION[XSR_KEY] ?? '';
        if ($this->viewData["xsrToken"] !== $tmpXsrToken) {
            error_log("Intento con token inválido en usuarios.");
            $this->throwError("Token inválido. Intente de nuevo.");
        }
    }

    private function procesarDatos()
    {
        switch ($this->viewData["mode"]) {
            case "INS":
                $result = UsuariosDao::nuevoUsuario(
                    $this->viewData["useremail"],
                    $this->viewData["username"],
                    $this->viewData["userpswd"],

                    $this->viewData["userpswdest"],
                    $this->viewData["userpswdexp"],
                    $this->viewData["userest"],
                    $this->viewData["useractcod"],
                    $this->viewData["userpswdchg"],
                    $this->viewData["usertipo"]
                );
                if ($result > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Usuario creado correctamente.");
                } else {
                    $this->viewData["errores"]["global"][] = "No se pudo crear el usuario.";
                }
                break;
            case "UPD":
                $result = UsuariosDao::actualizarUsuario(
                    $this->viewData["usercod"],
                    $this->viewData["useremail"],
                    $this->viewData["username"],
                    $this->viewData["userpswd"],

                    $this->viewData["userpswdest"],
                    $this->viewData["userpswdexp"],
                    $this->viewData["userest"],
                    $this->viewData["useractcod"],
                    $this->viewData["userpswdchg"],
                    $this->viewData["usertipo"]
                );
                if ($result > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Usuario actualizado correctamente.");
                } else {
                    $this->viewData["errores"]["global"][] = "No se pudo actualizar el usuario.";
                }
                break;
            case "DEL":
                $result = UsuariosDao::eliminarUsuario($this->viewData["usercod"]);
                if ($result > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Usuario eliminado correctamente.");
                } else {
                    $this->viewData["errores"]["global"][] = "No se pudo eliminar el usuario.";
                }
                break;
        }
    }

    private function prepararVista()
    {
        $this->viewData["modeDsc"] = sprintf(
            $this->modes[$this->viewData["mode"]],
            $this->viewData["usercod"]
        );

        // Estados seleccionados en combo
        foreach ($this->estados as $estado) {
            $this->viewData["estado" . $estado] = ($this->viewData["userest"] === $estado) ? "selected" : "";
        }
        foreach ($this->tipos as $tipo) {
            $this->viewData["tipo" . $tipo] = ($this->viewData["usertipo"] === $tipo) ? "selected" : "";
        }

        // Errores
        if (count($this->viewData["errores"]) > 0) {
            foreach ($this->viewData["errores"] as $campo => $error) {
                $this->viewData["error_" . $campo] = $error;
            }
        }


        if (in_array($this->viewData["mode"], ["DEL", "DSP"])) {
            $this->viewData["readonly"] = "readonly";
        }

        if ($this->viewData["mode"] === "DSP") {
            $this->viewData["showAction"] = false;
        }


        $this->viewData["xsrToken"] = hash("sha256", random_int(10000, 99999) . time() . 'usuario' . $this->viewData["mode"]);
        $_SESSION[XSR_KEY] = $this->viewData["xsrToken"];
    }
}
