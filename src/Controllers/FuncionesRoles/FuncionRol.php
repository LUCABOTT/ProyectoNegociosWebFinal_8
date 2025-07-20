<?php

namespace Controllers\FuncionesRoles;

use Controllers\PrivateController;
use Dao\FuncionesRoles\FuncionesRoles as FuncionesRolesDao;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;
use DateTime;

const LIST_URL = "index.php?page=FuncionesRoles-FuncionesRoles";
const XSR_KEY = "xsrToken_funcionesroles";

class FuncionRol extends PrivateController
{
    private array $viewData;
    private array $estados;
    private array $roles;
    public function __construct()
    {
        parent::__construct();
        $this->estados = ["ACT", "INA", "BLQ", "SUS"];
        $this->roles = ["ADM", "AUD", "PBL"];
        $this->viewData = [
            "rolescod" => "",
            "fncod" => "",
            "fnrolest" => "ACT",
            "fnexp" => null,
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
        Renderer::render("FuncionesRoles/FuncionRol", $this->viewData);
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
            if (isset($_GET["rolescod"]) && isset($_GET["fncod"])) {
                $this->viewData["rolescod"] = $_GET["rolescod"];
                $this->viewData["fncod"] = $_GET["fncod"];
                $this->viewData["original_rolescod"] = $this->viewData["rolescod"];
                $this->viewData["original_fncod"] = $this->viewData["fncod"];

                $registro = FuncionesRolesDao::getFuncionRolByIds($this->viewData["rolescod"], $this->viewData["fncod"]);
                if ($registro) {
                    $this->viewData["fnrolest"] = $registro["fnrolest"];
                    $this->viewData["fnexp"] = $registro["fnexp"];
                } else {
                    Site::redirectToWithMsg(LIST_URL, "La relación función-rol no existe.");
                }
            } else {
                Site::redirectToWithMsg(LIST_URL, "Faltan datos clave en la URL");
            }
        }
    }

    private function loadFormData()
    {
        $this->viewData["rolescod"] = $_POST["rolescod"] ?? "";
        $this->viewData["fncod"] = $_POST["fncod"] ?? "";
        $this->viewData["fnrolest"] = $_POST["fnrolest"] ?? "";
        $this->viewData["fnexp"] = $_POST["fnexp"] ?? null;
        if ($this->viewData["fnexp"] === "") {
            $this->viewData["fnexp"] = null;
        }
        $this->viewData["original_rolescod"] = $_POST["original_rolescod"] ?? "";
        $this->viewData["original_fncod"] = $_POST["original_fncod"] ?? "";
        $this->viewData["xsrToken"] = $_POST["xsrToken"] ?? "";
    }

    private function validateData()
    {
        if (!in_array($this->viewData["rolescod"], $this->roles)) {
            $this->viewData["errores"]["rolescod"] = "El código del rol es requerido.";
        }
        if (empty($this->viewData["fncod"])) {
            $this->viewData["errores"]["fncod"] = "El código de la función es requerido.";
        }
        if (!in_array($this->viewData["fnrolest"], $this->estados)) {
            $this->viewData["errores"]["fnrolest"] = "El estado no es válido.";
        }
        if (empty($this->viewData["fnexp"])) {
            $this->viewData["errores"]["fnexp"] = "La fecha de expiración es requerida.";
        } else {
            // Verificar que sea una fecha válida con formato YYYY-MM-DD
            $fecha = $this->viewData["fnexp"];
            $fechaValida = DateTime::createFromFormat('Y-m-d', $fecha);
            if (!$fechaValida || $fechaValida->format('Y-m-d') !== $fecha) {
                $this->viewData["errores"]["fnexp"] = "La fecha de expiración no es válida.";
            }
        }
        if ($_SESSION[XSR_KEY] !== $this->viewData["xsrToken"]) {
            Site::redirectToWithMsg(LIST_URL, "Token inválido.");
        }
    }

    private function processData()
    {
        switch ($this->viewData["mode"]) {
            case "INS":
                $res = FuncionesRolesDao::nuevaFuncionRol(
                    $this->viewData["rolescod"],
                    $this->viewData["fncod"],
                    $this->viewData["fnrolest"],
                    $this->viewData["fnexp"]
                );
                if ($res > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Relación función-rol creada exitosamente.");
                } else {
                    $this->viewData["errores"]["global"] = ["Error al crear la relación."];
                }
                break;

            case "UPD":
                $res = FuncionesRolesDao::actualizarFuncionRol(
                    $this->viewData["original_rolescod"],
                    $this->viewData["original_fncod"],
                    $this->viewData["rolescod"],   // nuevo rolescod
                    $this->viewData["fncod"],      // nuevo fncod
                    $this->viewData["fnrolest"],
                    $this->viewData["fnexp"]
                );
                if ($res > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Relación función-rol actualizada exitosamente.");
                } else {
                    $this->viewData["errores"]["global"] = ["Error al actualizar la relación."];
                }
                break;

            case "DEL":
                $res = FuncionesRolesDao::eliminarFuncionRol(
                    $this->viewData["rolescod"],
                    $this->viewData["fncod"]
                );
                if ($res > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Relación función-rol eliminada exitosamente.");
                } else {
                    $this->viewData["errores"]["global"] = ["Error al eliminar la relación."];
                }
                break;
        }
    }

    private function prepareView()
    {
        $modesDesc = [
            "INS" => "Creando nueva relación función-rol",
            "UPD" => "Modificando relación función-rol {$this->viewData['rolescod']} - {$this->viewData['fncod']}",
            "DEL" => "Eliminando relación función-rol {$this->viewData['rolescod']} - {$this->viewData['fncod']}",
            "DSP" => "Mostrando relación función-rol {$this->viewData['rolescod']} - {$this->viewData['fncod']}"
        ];

        $this->viewData["modeDsc"] = $modesDesc[$this->viewData["mode"]] ?? "";
        $this->viewData["readonly"] = ($this->viewData["mode"] === "DEL" || $this->viewData["mode"] === "DSP") ? "readonly" : "";
        $this->viewData["showAction"] = !($this->viewData["mode"] === "DSP");
        $this->viewData["rolescod_ADM"] = ($this->viewData["rolescod"] === "ADM") ? "selected" : "";
        $this->viewData["rolescod_AUD"] = ($this->viewData["rolescod"] === "AUD") ? "selected" : "";
        $this->viewData["rolescod_PBL"] = ($this->viewData["rolescod"] === "PBL") ? "selected" : "";

        if (count($this->viewData["errores"]) > 0) {
            foreach ($this->viewData["errores"] as $campo => $error) {
                $this->viewData["error_" . $campo] = $error;
            }
        }

        $this->viewData["xsrToken"] = hash("sha256", random_int(0, 1000000) . time() . 'funcionesroles' . $this->viewData["mode"]);
        $_SESSION[XSR_KEY] = $this->viewData["xsrToken"];
    }
}
