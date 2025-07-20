<?php

namespace Controllers\RolesUsuarios;

use Controllers\PrivateController;
use Dao\RolesUsuarios\RolesUsuarios as RolesUsuariosDao;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

const LIST_URL = "index.php?page=RolesUsuarios-RolesUsuarios";
const XSR_KEY = "xsrToken_rolesusuarios";

class RolUsuario extends PrivateController
{
    private array $viewData;
    private array $estados;
    private array $rol;

    public function __construct()
    {
        parent::__construct();
        $this->estados = ["ACT", "INA", "BLQ", "SUS"];
        $this->rol = ["ADM", "AUD", "PBL"];
        $this->viewData = [
            "usercod" => "",
            "rolescod" => "",
            "roleuserest" => "ACT",
            "roleuserfch" => null,
            "roleuserexp" => null,
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
        $this->captureMode();
        $this->loadDataFromDao();

        if ($this->isPostBack()) {
            $this->loadFormData();
            $this->validateData();
            if (count($this->viewData["errores"]) === 0) {
                $this->processData();
            }
        }

        $this->prepareView();
        Renderer::render("RolesUsuarios/RolUsuario", $this->viewData);
    }

    private function captureMode()
    {
        if (isset($_GET["mode"])) {
            $this->viewData["mode"] = $_GET["mode"];
            if (!in_array($this->viewData["mode"], ["INS", "UPD", "DEL", "DSP"])) {
                Site::redirectToWithMsg(LIST_URL, "Modo inválido");
            }
        } else {
            Site::redirectToWithMsg(LIST_URL, "Falta el modo");
        }
    }

    private function loadDataFromDao()
    {
        if ($this->viewData["mode"] !== "INS") {
            if (isset($_GET["usercod"]) && isset($_GET["rolescod"])) {
                $this->viewData["usercod"] = $_GET["usercod"];
                $this->viewData["rolescod"] = $_GET["rolescod"];

                $registro = RolesUsuariosDao::obtenerPorLlaves($this->viewData["usercod"], $this->viewData["rolescod"]);
                if ($registro) {
                    $this->viewData["roleuserest"] = $registro["roleuserest"];
                    $this->viewData["roleuserfch"] = $registro["roleuserfch"];
                    $this->viewData["roleuserexp"] = $registro["roleuserexp"];
                } else {
                    Site::redirectToWithMsg(LIST_URL, "La relación rol-usuario no existe.");
                }
            } else {
                Site::redirectToWithMsg(LIST_URL, "Faltan datos clave en la URL");
            }
        }
    }

    private function loadFormData()
    {
        $this->viewData["usercod"] = $_POST["usercod"] ?? "";
        $this->viewData["rolescod"] = $_POST["rolescod"] ?? "";
        $this->viewData["roleuserest"] = $_POST["roleuserest"] ?? "";
        $this->viewData["roleuserfch"] = $_POST["roleuserfch"] ?? null;
        $this->viewData["roleuserexp"] = $_POST["roleuserexp"] ?? null;
        $this->viewData["xsrToken"] = $_POST["xsrToken"] ?? "";
    }

    private function validateData()
    {
        if (!is_numeric($this->viewData["usercod"])) {
            $this->viewData["errores"]["usercod"] = "Código de usuario inválido.";
        }
        if (!in_array($this->viewData["rolescod"], $this->rol)) {
            $this->viewData["errores"]["rolescod"] = "El código del rol es requerido.";
        }
        if (!in_array($this->viewData["roleuserest"], $this->estados)) {
            $this->viewData["errores"]["roleuserest"] = "El estado no es válido.";
        }
        if ($_SESSION[XSR_KEY] !== $this->viewData["xsrToken"]) {
            Site::redirectToWithMsg(LIST_URL, "Token inválido.");
        }
    }

    private function processData()
    {
        $data = [
            "usercod" => $this->viewData["usercod"],
            "rolescod" => $this->viewData["rolescod"],
            "roleuserest" => $this->viewData["roleuserest"],
            "roleuserfch" => $this->viewData["roleuserfch"],
            "roleuserexp" => $this->viewData["roleuserexp"]
        ];

        switch ($this->viewData["mode"]) {
            case "INS":
                $res = RolesUsuariosDao::insertar($data);
                if ($res > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Relación rol-usuario creada exitosamente.");
                } else {
                    $this->viewData["errores"]["global"] = ["Error al crear la relación."];
                }
                break;

            case "UPD":


                // Asumamos que recibes el rolescod viejo en un hidden input llamado 'oldRolescod'
                $oldRolescod = $_POST["oldRolescod"] ?? $this->viewData["rolescod"];
                $oldUsercod = $_POST["oldUsercod"] ?? $this->viewData["usercod"];

                $data = [
                    "usercod" => $this->viewData["usercod"],
                    "rolescod" => $this->viewData["rolescod"],
                    "roleuserest" => $this->viewData["roleuserest"],
                    "roleuserfch" => $this->viewData["roleuserfch"],
                    "roleuserexp" => $this->viewData["roleuserexp"]
                ];

                $res = RolesUsuariosDao::actualizar($oldUsercod, $oldRolescod, $data);

                if ($res > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Relación rol-usuario actualizada exitosamente.");
                } else {
                    $this->viewData["errores"]["global"] = ["Error al actualizar la relación."];
                }
                break;

            case "DEL":
                $res = RolesUsuariosDao::eliminar($this->viewData["usercod"], $this->viewData["rolescod"]);
                if ($res > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Relación rol-usuario eliminada exitosamente.");
                } else {
                    $this->viewData["errores"]["global"] = ["Error al eliminar la relación."];
                }
                break;
        }
    }

    private function prepareView()
    {
        $modesDesc = [
            "INS" => "Creando nueva relación rol-usuario",
            "UPD" => "Modificando relación rol-usuario {$this->viewData['usercod']} - {$this->viewData['rolescod']}",
            "DEL" => "Eliminando relación rol-usuario {$this->viewData['usercod']} - {$this->viewData['rolescod']}",
            "DSP" => "Mostrando relación rol-usuario {$this->viewData['usercod']} - {$this->viewData['rolescod']}"
        ];
        $this->viewData["rolescodADM"] = $this->viewData["rolescod"] === "ADM" ? "selected" : "";
        $this->viewData["rolescodAUD"] = $this->viewData["rolescod"] === "AUD" ? "selected" : "";
        $this->viewData["rolescodPBL"] = $this->viewData["rolescod"] === "PBL" ? "selected" : "";

        $this->viewData["modeDsc"] = $modesDesc[$this->viewData["mode"]] ?? "";
        $this->viewData["readonly"] = ($this->viewData["mode"] === "DEL" || $this->viewData["mode"] === "DSP") ? "readonly" : "";
        $this->viewData["showAction"] = !($this->viewData["mode"] === "DSP");

        if (count($this->viewData["errores"]) > 0) {
            foreach ($this->viewData["errores"] as $campo => $error) {
                $this->viewData["error_" . $campo] = $error;
            }
        }

        $this->viewData["xsrToken"] = hash("sha256", random_int(0, 1000000) . time() . 'rolesusuarios' . $this->viewData["mode"]);
        $_SESSION[XSR_KEY] = $this->viewData["xsrToken"];
    }
}
