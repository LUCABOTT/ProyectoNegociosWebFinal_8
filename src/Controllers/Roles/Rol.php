<?php

namespace Controllers\Roles;

use Controllers\PublicController;
use Dao\Roles\Roles as RolesDao;
use Error;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

const LIST_URL = "index.php?page=Roles-Roles";
const XSR_KEY = "xsrToken_roles";

class Rol extends PublicController
{
    private array $viewData;
    private array $estados;
    private array $modes;

    public function __construct()
    {
        $this->modes = [
            "INS" => 'Creando nuevo rol',
            "UPD" => 'Modificando rol %s %s',
            "DEL" => 'Eliminando rol %s %s',
            "DSP" => 'Mostrando rol %s %s'
        ];
        $this->estados = ["ACT", "INA", "BLQ", "SUS"];
        $this->viewData = [
            "rolescod" => "",
            "rolesdsc" => "",
            "rolesest" => "ACT",
            "mode" => "",
            "modeDsc" => "",
            "estadoACT" => "",
            "estadoINA" => "",
            "estadoRTR" => "",
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
        Renderer::render("Roles/Rol", $this->viewData);
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
                $this->throwError("BAD REQUEST: No se puede procesar su solicitud.");
            }
        }
    }

    private function datosDeDao()
    {
        if ($this->viewData["mode"] !== "INS") {
            if (isset($_GET["id"])) {
                $this->viewData["rolescod"] = $_GET["id"];
                $rol = RolesDao::getRolById($this->viewData["rolescod"]);
                if (is_array($rol)) {
                    $this->viewData["rolescod"] = $rol["rolescod"];
                    $this->viewData["rolesdsc"] = $rol["rolesdsc"];
                    $this->viewData["rolesest"] = $rol["rolesest"];
                } else {
                    $this->throwError("BAD REQUEST: No existe registro en la DB");
                }
            } else {
                $this->throwError("BAD REQUEST: No se puede extraer el registro de la DB");
            }
        }
    }

    private function datosFormulario()
    {
        if (isset($_POST["rolescod"])) {
            $this->viewData["rolescod"] = $_POST["rolescod"];
        }
        if (isset($_POST["rolesdsc"])) {
            $this->viewData["rolesdsc"] = $_POST["rolesdsc"];
        }
        if (isset($_POST["rolesest"])) {
            $this->viewData["rolesest"] = $_POST["rolesest"];
        }
        if (isset($_POST["xsrToken"])) {
            $this->viewData["xsrToken"] = $_POST["xsrToken"];
        }
    }

    private function validarDatos()
    {
        if (Validators::IsEmpty($this->viewData["rolescod"])) {
            $this->viewData["errores"]["rolescod"] = "Código es requerido.";
        }
        if (Validators::IsEmpty($this->viewData["rolesdsc"])) {
            $this->viewData["errores"]["rolesdsc"] = "Descripción es requerida.";
        }
        if (!in_array($this->viewData["rolesest"], $this->estados)) {
            $this->viewData["errores"]["rolesest"] = "El valor del estado no es válido.";
        }
        $tmpXsrToken = $_SESSION[XSR_KEY] ?? '';
        if ($this->viewData["xsrToken"] !== $tmpXsrToken) {
            error_log("Intento con token inválido.");
            $this->throwError("Algo sucedió. Intente de nuevo.");
        }
    }

    private function procesarDatos()
    {
        switch ($this->viewData["mode"]) {
            case "INS":
                if (
                    RolesDao::nuevoRol(
                        $this->viewData["rolescod"],
                        $this->viewData["rolesdsc"],
                        $this->viewData["rolesest"]
                    ) > 0
                ) {
                    Site::redirectToWithMsg(LIST_URL, "Rol agregado exitosamente.");
                } else {
                    $this->viewData["errores"]["global"][] = "Error al crear nuevo rol.";
                }
                break;
            case "UPD":
                if (
                    RolesDao::actualizarRol(
                        $this->viewData["rolescod"],
                        $this->viewData["rolesdsc"],
                        $this->viewData["rolesest"]
                    )
                ) {
                    Site::redirectToWithMsg(LIST_URL, "Rol actualizado exitosamente.");
                } else {
                    $this->viewData["errores"]["global"][] = "Error al actualizar el rol.";
                }
                break;
            case "DEL":
                if (
                    RolesDao::eliminarRol($this->viewData["rolescod"])
                ) {
                    Site::redirectToWithMsg(LIST_URL, "Rol eliminado exitosamente.");
                } else {
                    $this->viewData["errores"]["global"][] = "Error al eliminar el rol.";
                }
                break;
        }
    }

    private function prepararVista()
    {
        $this->viewData["modeDsc"] = sprintf(
            $this->modes[$this->viewData["mode"]],
            $this->viewData["rolescod"],
            $this->viewData["rolesdsc"]
        );

        $this->viewData["rolesest" . $this->viewData["rolesest"]] = 'selected';

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

        $this->viewData["xsrToken"] = hash("sha256", random_int(0, 1000000) . time() . 'roles' . $this->viewData["mode"]);
        $_SESSION[XSR_KEY] = $this->viewData["xsrToken"];
    }
}
